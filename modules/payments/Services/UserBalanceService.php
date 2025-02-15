<?php

namespace cot\modules\payments\Services;

use Cot;
use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\modules\payments\exceptions\NotEnoughFundsOnTheBalanceException;
use cot\modules\payments\exceptions\PaymentNotAllowedException;
use cot\modules\payments\exceptions\PaymentNotFoundException;
use cot\modules\payments\Repositories\PaymentRepository;
use cot\modules\payments\Repositories\UserBalanceRepository;
use cot\traits\GetInstanceTrait;
use Exception;
use Throwable;

class UserBalanceService
{
    use GetInstanceTrait;

    /**
     * @var array<int, numeric-string>
     */
    private $cacheByUserId = [];

    /**
     * @return string Returns a string for use with bcmath
     */
    public function getByUserId(int $userId, $useCache = true): string
    {
        if ($useCache && isset($this->cacheByUserId[$userId])) {
            return $this->cacheByUserId[$userId];
        }

        $this->cacheByUserId[$userId] = UserBalanceRepository::getInstance()->getByUserId($userId);

        return $this->cacheByUserId[$userId];
    }

    /**
     * @param ?int $paymentId The ID of the payment that caused this update
     *  (ID платежа, оплата которого и вызвала это обновление)
     */
    public function updateForUser(int $userId, string $amount, ?int $paymentId = null): bool
    {
        // @todo PaymentService::create()
        $pdata['pay_userid'] = $userId;
        $pdata['pay_summ'] = $amount;
        $pdata['pay_area'] = 'balance';
        $pdata['pay_status'] = 'done';
        if ($paymentId !== null) {
            $pdata['pay_code'] = $paymentId;
        }
        $pdata['pay_cdate'] = Cot::$sys['now'];
        $pdata['pay_pdate'] = Cot::$sys['now'];
        $pdata['pay_adate'] = Cot::$sys['now'];

        $result = Cot::$db->insert(Cot::$db->payments, $pdata);

        unset($this->cacheByUserId[$userId]);

        return $result > 0;
    }

    public function payPaymentFromBalance(int $userId, int $paymentId)
    {
        $userBalance = $this->getByUserId($userId);
        $payment = PaymentRepository::getInstance()->getById($paymentId);

        if ($payment === null) {
            throw new PaymentNotFoundException();
        }

        if (!in_array($payment['pay_status'], PaymentDictionary::ALLOW_PAYMENT_STATUSES)) {
            throw new PaymentNotAllowedException();
        }

        if (bccomp($userBalance, $payment['pay_summ']) === -1) {
            throw new NotEnoughFundsOnTheBalanceException();
        }

        Cot::$db->beginTransaction();
        try {
            $this->updateForUser($userId, -$payment['pay_summ'], $paymentId);
            if (
                !PaymentService::getInstance()->setStatus(
                    $paymentId,
                    PaymentDictionary::STATUS_PAID,
                    PaymentDictionary::PAYMENT_SYSTEM_BALANCE
                )
            ) {
                throw new Exception("Can't update payment status"); // @todo translate
            }

            Cot::$db->commit();
        } catch (Throwable $e) {
            Cot::$db->rollBack();
            throw $e;
        }

        unset($this->cacheByUserId[$userId]);

        /* === Hook === */
        foreach (cot_getextplugins('payments.balance.pay.done') as $pl) {
            include $pl;
        }
        /* ===== */

        return true;
    }

    /**
     * Processing balance replenishment (пополнение баланса)
     */
    public function processSuccessBalanceReplenishment(array $payment): void
    {
        PaymentService::getInstance()->setStatus($payment['pay_id'], PaymentDictionary::STATUS_DONE);

        $user = cot_user_data($payment['pay_userid']);

        $subject = Cot::$L['payments_balance_billing_admin_subject'];
        $body = sprintf(
            Cot::$L['payments_balance_billing_admin_body'],
            !empty($user) ? $user['user_name'] : 'Unknown',
            $payment['pay_summ'] . ' ' . Cot::$cfg['payments']['valuta'],
            $payment['pay_id'],
            cot_date('d.m.Y H:i', $payment['pay_pdate'])
        );
        cot_mail(Cot::$cfg['adminemail'], $subject, $body);

        // Если при оплате услуги на балансе не хватает средств и пополнение баланса было именно для оплаты этого
        // заказа, то сразу и оплатим его
        if (!empty($payment['pay_code'])) {
            $logFileName = Cot::$sys['baseDir']  . "/komtet-payment.log";
            $log  = "=============================\n";
            $log .= "processSuccessBalanceReplenishment со списанием по другому платежу: " . date('Y-m-d H:i:s') . "\n";
            $log .= "=============================\n";
            $log .= "GET:\n" . var_export($_GET, true). "\n\n";
            $log .= "POST:\n" . var_export($_POST, true). "\n\n";
            $log .= "Payment:\n" . var_export($payment ?? null, true). "\n\n";
            file_put_contents($logFileName, $log, FILE_APPEND | LOCK_EX);
            // ===

            $dpay = PaymentRepository::getInstance()->getById((int) $payment['pay_code']);
            if (
                !empty($dpay)
                && in_array($dpay['pay_status'], PaymentDictionary::ALLOW_PAYMENT_STATUSES)
            ) {
                try {
                    $this->payPaymentFromBalance($dpay['pay_userid'], $dpay['pay_id']);
                } catch (NotEnoughFundsOnTheBalanceException $e) {
                }
            }
        }

        /* === Hook === */
        foreach (cot_getextplugins('payments.balance.replenish.done') as $pl) {
            include $pl;
        }
        /* ===== */
    }
}