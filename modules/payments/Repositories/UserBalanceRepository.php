<?php

declare(strict_types=1);

namespace cot\modules\payments\Repositories;

use Cot;
use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\traits\GetInstanceTrait;

class UserBalanceRepository
{
    use GetInstanceTrait;

    /**
     * @return string Returns a string for use with bcmath
     */
    public function getByUserId(int $userId): string
    {
        $balance = Cot::$db->query(
            'SELECT SUM(pay_summ) FROM ' . Cot::$db->payments
            . " WHERE pay_userid = :userId AND pay_area = '" . PaymentDictionary::PAYMENT_SOURCE_BALANCE . "'"
            . " AND pay_status = '" . PaymentDictionary::STATUS_DONE . "'",
            ['userId' => $userId]
        )->fetchColumn();

        if ($balance === null || bccomp($balance, '0', 5) === 0) {
            return '0';
        }

        return $balance;
    }
}