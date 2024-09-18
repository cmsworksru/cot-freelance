<?php

declare(strict_types=1);

namespace cot\modules\payments\inc;

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, Alexey Kalnov https://lily-software.com
 * @license BSD
 */
class PaymentDictionary
{
    public const STATUS_NEW = 'new';

    /**
     * Payment in process
     */
    public const STATUS_PROCESS = 'process';

    /**
     * Paid
     */
    public const STATUS_PAID = 'paid';

    /**
     * completed (service activated)
     */
    public const STATUS_DONE = 'done';

    public const ALLOW_PAYMENT_STATUSES = [
        self::STATUS_NEW,
        self::STATUS_PROCESS,
    ];

    public const RESULT_SUCCESS = 'success';
    public const RESULT_FAIL = 'fail';

    public const METHOD_CARD = 'card';

    public const PAYMENT_SOURCE_BALANCE = 'balance';
}