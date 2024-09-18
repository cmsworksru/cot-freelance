<?php

declare(strict_types=1);

namespace cot\modules\payments\inc;

use Cot;

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, Alexey Kalnov https://lily-software.com
 * @license BSD
 */
class PaymentRepository
{
    public static function getById(int $id): ?array
    {
        $table = Cot::$db->quoteTableName(Cot::$db->payments);
        $condition['id'] = "{$table}.pay_id = :paymentId";
        $params['paymentId'] = $id;

        $result = self::getByCondition($condition, $params);

        return !empty($result) ? array_shift($result) : null;
    }

    /**
     * @return array<int, <array<string, int|string>> Return payment data indexed by id
     */
    public static function getByCondition(array $condition, array $params = []): array
    {
        $tableName = Cot::$db->quoteTableName(Cot::$db->payments);

        $sqlWhere = '';
        if ($condition !== []) {
            $sqlWhere = ' WHERE (' . implode(') AND (', $condition) . ')';
        }

        $sql = "SELECT {$tableName}.* "
            . " FROM {$tableName} "
            . $sqlWhere . " ORDER BY {$tableName}.pay_cdate DESC";

        $items = Cot::$db->query($sql, $params)->fetchAll();
        if (empty($items)) {
            return [];
        }

        $result = [];
        foreach ($items as $item) {
            $item = self::castAttributes($item);
            $result[$item['pay_id']] = $item;
        }

        return $result;
    }

    public static function castAttributes(array $data): array
    {
        $data['pay_id'] = (int) $data['pay_id'];
        $data['pay_userid'] = (int) $data['pay_userid'];
        $data['pay_cdate'] = (int) $data['pay_cdate'];
        $data['pay_pdate'] = (int) $data['pay_pdate'];
        $data['pay_adate'] = (int) $data['pay_adate'];
        $data['pay_time'] = (int) $data['pay_time'];
        return $data;
    }
}