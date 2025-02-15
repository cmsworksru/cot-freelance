<?php

declare(strict_types=1);

namespace cot\modules\payments\Services;

use Cot;
use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\modules\payments\Repositories\PaymentRepository;
use cot\traits\GetInstanceTrait;
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
    use GetInstanceTrait;

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
     * @param ?string $transaction Transaction ID in payment system
     * @return bool
     *
     * @see \cot\modules\payments\dictionaries\PaymentDictionary::STATUS_NEW
     * @see \cot\modules\payments\dictionaries\PaymentDictionary::STATUS_PROCESS
     * @see \cot\modules\payments\dictionaries\PaymentDictionary::STATUS_PAID
     * @see \cot\modules\payments\dictionaries\PaymentDictionary::STATUS_DONE
     */
    public function setStatus(
        int $paymentId,
        string $status,
        ?string $paymentSystem = null,
        ?string $paymentMethod = null,
        ?string $paymentSystemPaymentId = null,
        ?string $transaction = null
    ) {
        $payment = PaymentRepository::getInstance()->getById($paymentId);
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
            $payment = PaymentRepository::getInstance()->getById($paymentId);

            $this->processSuccessPayment($payment);
        }

        return $result > 0;
    }

    /**
     * Extensions should use the hook in this method to process their successful payments
     */
    private function processSuccessPayment(array $payment): void
    {
        // For hook handlers includes
        global $L, $Ls, $R;

        /* === Hook === */
        foreach (cot_getextplugins('payments.payment.success') as $pl) {
            include $pl;
        }
        /* ===== */

        if ($payment['pay_area'] === PaymentDictionary::PAYMENT_SOURCE_BALANCE) {
            UserBalanceService::getInstance()->processSuccessBalanceReplenishment($payment);
        }
    }

    /**
     * The URL where the user can be redirected from the payment system in case of successful payment
     * @param ?int $paymentId cot_payments.pay_id
     * @return string
     */
    public function getSuccessUrl(?int $paymentId = null): string
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
    public function getFailUrl(?int $paymentId = null): string
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