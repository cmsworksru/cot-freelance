<?php

declare(strict_types=1);

namespace cot\modules\payments\inc;

use Cot;
use Exception;

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, Alexey Kalnov https://lily-software.com
 * @license BSD
 */
class PaymentService
{
    /**
     * Set payment status
     *  'new' - new
     *  'process' - payment in process
     *  'paid' - paid
     *  'done' - completed (service activated)
     *
     * @param int $paymentId Payment ID (cot_payments.pay_id)
     * @param string $status
     * @param ?string $paymentSystem
     * @param ?string $paymentMethod
     * @param ?string $paymentSystemPaymentId Payment Id passed to payment system
     * @param ?string $transaction Tranaction ID in payment system
     * @return bool
     *
     * @see PaymentDictionary::STATUS_NEW
     * @see PaymentDictionary::STATUS_PROCESS
     * @see PaymentDictionary::STATUS_PAID
     * @see PaymentDictionary::STATUS_DONE
     */
    public static function setStatus(
        int $paymentId,
        string $status,
        ?string $paymentSystem = null,
        ?string $paymentMethod = null,
        ?string $paymentSystemPaymentId = null,
        ?string $transaction = null
    ) {
        $payment = PaymentRepository::getById($paymentId);
        if ($payment === null) {
            throw new Exception('Payment not found');
        }

        $oldStatus = $payment['pay_status'];

        $data = ['pay_status' => $status];

        if ($status === PaymentDictionary::STATUS_PAID)  {
            // Оплачено
            $data['pay_pdate'] = Cot::$sys['now'];
        } elseif ($status === PaymentDictionary::STATUS_DONE) {
            // Исполнено
            $data['pay_adate'] = Cot::$sys['now'];
        }

        if ($paymentSystem !== null) {
            $data['pay_system'] = $paymentSystem;
        }
        if ($paymentMethod !== null) {
            $data['pay_method'] = $paymentMethod;
        }
        if ($paymentSystemPaymentId !== null) {
            $data['pay_payment_id'] = $paymentSystemPaymentId;
        }
        if ($transaction !== null) {
            $data['pay_transaction_id'] = $transaction;
        }

        $result = Cot::$db->update(Cot::$db->payments, $data, 'pay_id = ?', $paymentId);

        if (
            !in_array($oldStatus, [PaymentDictionary::STATUS_PAID, PaymentDictionary::STATUS_DONE], true)
            && $status === PaymentDictionary::STATUS_PAID
        ) {
            // Reload data from DB
            $payment = PaymentRepository::getById($paymentId);

            self::processSuccessPayment($payment);
        }

        return $result > 0;
    }

    /**
     * Extensions should use the hook in this method to process their successful payments
     * @param array $payment
     * @return void
     */
    private static function processSuccessPayment(array $payment): void
    {
        if ($payment['pay_area'] === PaymentDictionary::PAYMENT_SOURCE_BALANCE) {
            self::processSuccessBalancePayment($payment);
            return;
        }

        /* === Hook === */
        foreach (cot_getextplugins('payments.payment.success') as $pl) {
            include $pl;
        }
        /* ===== */
    }

    private static function processSuccessBalancePayment(array $payment): void
    {
        self::setStatus($payment['pay_id'], PaymentDictionary::STATUS_DONE);

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

        if (!empty($pay['pay_code'])) {
            $dpay = PaymentRepository::getById($pay['pay_code']);
            if (!empty($dpay)) {
                $ubalance = cot_payments_getuserbalance($dpay['pay_userid']);
                if (
                    $ubalance >= $dpay['pay_summ']
                    && self::setStatus($dpay['pay_id'], PaymentDictionary::STATUS_PAID)
                ) {
                    cot_payments_updateuserbalance($dpay['pay_userid'], -$dpay['pay_summ'], $dpay['pay_id']);
                }
            }
        }

        /* === Hook === */
        foreach (cot_getextplugins('payments.balance.billing.done') as $pl) {
            include $pl;
        }
        /* ===== */
    }

    /**
     * The URL where the user can be redirected from the payment system in case of successful payment
     * @param ?int $paymentId cot_payments.pay_id
     * @return string
     */
    public static function getSuccessUrl(?int $paymentId = null): string
    {
        $params = ['a' => 'result', 'result' => PaymentDictionary::RESULT_SUCCESS];
        if ($paymentId !== null) {
            $params['pid'] = $paymentId;
        }

        $result = cot_url('payments', $params, '', true);
        if (!cot_url_check($result)) {
            $result = rtrim(Cot::$cfg['mainurl'], '/') . '/' . $result;
        }
        return $result;
    }

    /**
     * The URL where the user can be redirected from the payment system in case of a failed payment
     * @param ?int $paymentId cot_payments.pay_id
     * @return string
     */
    public static function getFailUrl(?int $paymentId = null): string
    {
        $params = ['a' => 'result', 'result' => PaymentDictionary::RESULT_FAIL];
        if ($paymentId !== null) {
            $params['pid'] = $paymentId;
        }

        $result = cot_url('payments', $params, '', true);
        if (!cot_url_check($result)) {
            $result = rtrim(Cot::$cfg['mainurl'], '/') . '/' . $result;
        }
        return $result;
    }
}