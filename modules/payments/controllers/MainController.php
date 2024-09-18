<?php

declare(strict_types=1);

namespace cot\modules\payments\controllers;

use Cot;
use cot\modules\payments\inc\PaymentDictionary;
use cot\modules\payments\inc\PaymentRepository;

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, Alexey Kalnov https://lily-software.com
 * @license BSD
 */
class MainController
{
    /**
     * The action where the user can be redirected from the payment system after payment
     */
    public function resultAction(): void
    {
        $payment = null;
        $paymentId = cot_import('pid', 'G', 'INT');
        if ($paymentId > 0) {
            $payment = PaymentRepository::getById($paymentId);
            if (!$payment) {
                cot_die_message(404);
            }
        }

        $paymentResult = cot_import('result', 'G', 'ALP');

        if ($paymentResult === PaymentDictionary::RESULT_SUCCESS) {
            cot_message(Cot::$L['payments_payment_success']);
        } else {
            cot_error(Cot::$L['payments_payment_fail']);
        }

        $redirectUrl = cot_url('payments', ['m' => 'balance'], '', true);
        if ($payment !== null && !empty($payment['pay_redirect'])) {
            $redirectUrl = $payment['pay_redirect'];
        }

        /* === Hook === */
        foreach (cot_getextplugins('payments.result.done') as $pl) {
            include $pl;
        }
        /* ===== */

        cot_redirect($redirectUrl);
    }
}