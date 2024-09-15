<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Kalnov Alexey
 * @copyright (c) CMSWorks.ru, Kalnov Alexey https://lily-software.com
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if (
    (
        Cot::$env['ext'] === 'admin'
        && isset($m)
        && $m === 'extensions'
        && isset($a)
        && $a === 'details'
        //&& !empty($b)
    )
    || Cot::$env['ext'] === 'install'
) {
    return;
}

require_once cot_incfile('payments', 'module');

$cot_billings = [];

/* === Hook === */
foreach (cot_getextplugins('payments.billing.register') as $pl) {
	include $pl;
}
/* ===== */


// Проверяем платежки на оплату пополнение счета.
if ($balancepays = cot_payments_getallpays('balance', 'paid'))
{
	foreach ($balancepays as $pay)
	{
		if (cot_payments_updatestatus($pay['pay_id'], 'done'))
		{
			$urr = $db->query("SELECT * FROM $db_users WHERE user_id=".$pay['pay_userid'])->fetch();
			
			$subject = $L['payments_balance_billing_admin_subject'];
			$body = sprintf($L['payments_balance_billing_admin_body'], $urr['user_name'], $pay['pay_summ'].' '.$cfg['payments']['valuta'], $pay['pay_id'], cot_date('d.m.Y в H:i', $pay['pay_pdate']));
			cot_mail($cfg['adminemail'], $subject, $body);

			if (!empty($pay['pay_code']))
			{
				$dpay = cot_payments_payinfo($pay['pay_code']);
				if (!empty($dpay))
				{
					$ubalance = cot_payments_getuserbalance($dpay['pay_userid']);
					if ($ubalance >= $dpay['pay_summ'] && cot_payments_updatestatus($dpay['pay_id'], 'paid'))
					{
						cot_payments_updateuserbalance($dpay['pay_userid'], -$dpay['pay_summ'], $dpay['pay_id']);
					}
				}
			}

			/* === Hook === */
			foreach (cot_getextplugins('payments.balance.billing.done') as $pl)
			{
				include $pl;
			}
			/* ===== */
		}
	}
}

if ($cfg['payments']['clearpaymentsdays'] > 0)
{
	$clearpaymentsdate = $sys['now'] - $cfg['payments']['clearpaymentsdays'] * 24 * 60 * 60;
	$db->delete($db_payments, "pay_status!='done' AND pay_cdate<" . $clearpaymentsdate);
}