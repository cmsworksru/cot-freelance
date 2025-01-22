<?php
/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, Cotonti team
 * @license BSD
 */

use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\modules\payments\Repositories\PaymentRepository;
use cot\modules\payments\Services\UserBalanceService;

defined('COT_CODE') or die('Wrong URL.');

[$usr['auth_read'], $usr['auth_write'], $usr['isadmin']] = cot_auth('payments', 'any', 'RWA');
cot_block($usr['auth_read']);

require_once cot_incfile('payments', 'module');

/* === Hook === */
foreach (cot_getextplugins('payments.billing.first') as $pl) {
	include $pl;
}
/* ===== */

$t = new XTemplate(cot_tplfile('payments.billing', 'module'));

/* === Hook === */
foreach (cot_getextplugins('payments.billing.main') as $pl) {
	include $pl;
}
/* ===== */

$pid = cot_import('pid', 'G', 'INT');

if (empty($pid)) {
	cot_redirect(cot_url('payments', 'm=error&msg=2', '', true));
}

// Получаем информацию о заказе
$payment = PaymentRepository::getInstance()->getById($pid);
if ($payment === null) {
    cot_redirect(cot_url('payments', 'm=error&msg=2', '', true));
}

// Block access to other user's payments
cot_block(Cot::$usr['id'] == $payment['pay_userid']);

// Don't allow duplicate payment with statuses 'payed' or 'done'.
if (
    in_array(
        $payment['pay_status'],
        [PaymentDictionary::STATUS_PAID, PaymentDictionary::STATUS_DONE],
        true
    )
) {
    cot_error(Cot::$L['payments_payment_already_made']);
    cot_redirect(cot_url('payments', ['m' => 'balance'], '', true));
}

if (!in_array($payment['pay_status'], PaymentDictionary::ALLOW_PAYMENT_STATUSES, true)) {
    cot_error(Cot::$L['payments_payment_not_allowed']);
    cot_redirect(cot_url('payments', ['m' => 'balance'], '', true));
}

// Если счета пользователей	включены, то оплата всех услуг производится со счета пользователя.
// Проверяем баланс и, если средств достаточно - оплачиваем с баланса.
if (Cot::$cfg['payments']['balance_enabled'] && $payment['pay_area'] !== 'balance' && Cot::$usr['id'] > 0) {
    $userBalance = UserBalanceService::getInstance()->getByUserId(Cot::$usr['id']);
    if (bccomp($userBalance, $payment['pay_summ'], 5) !== -1) {
        UserBalanceService::getInstance()->payPaymentFromBalance(Cot::$usr['id'], $payment['pay_id']);

        if (!empty($payment['pay_redirect'])){
            $payment['pay_redirect'] = rtrim($payment['pay_redirect'], '/') . '&' . cot_xg();
            cot_redirect($payment['pay_redirect']);
        } else {
            cot_redirect(cot_url('index'));
        }
    } else {
        $needAmount = bcsub($payment['pay_summ'], $userBalance, 5);
        cot_redirect(
            cot_url(
                'payments',
                ['m' => 'balance', 'n' => 'billing', 'rsumm' => (float) $needAmount, 'pid' => $pid],
                '',
                true
            )
        );
    }
}

// Выводим подключенные платежные системы
if ($cot_billings) {
    if (count($cot_billings) == 1) {
        foreach ($cot_billings as $bill) {
            cot_redirect(cot_url('plug', 'e=' . $bill['plug'] . '&pid=' . $pid, '', true));
        }
    } else {
        /* === Hook === */
        $extp = cot_getextplugins('payments.billing.loop');
        /* ===== */

        foreach ($cot_billings as $bill)
        {
            $t->assign(array(
                'BILL_ROW_TITLE' => $bill['title'],
                'BILL_ROW_ICON' => $bill['icon'],
                'BILL_ROW_URL' => cot_url('plug', 'e=' . $bill['plug'] . '&pid=' . $pid),
            ));

            /* === Hook - Part2 : Include === */
            foreach ($extp as $pl)
            {
                include $pl;
            }
            /* ===== */

            $t->parse('MAIN.BILLINGS.BILL_ROW');
        }

        $t->parse('MAIN.BILLINGS');
    }
} else {
    /* === Hook === */
    foreach (cot_getextplugins('payments.billing.empty') as $pl) {
        include $pl;
    }
    /* ===== */

    $t->parse('MAIN.EMPTYBILLINGS');
}

// Error and message handling
cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('payments.billing.tags') as $pl) {
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$module_body = $t->text('MAIN');