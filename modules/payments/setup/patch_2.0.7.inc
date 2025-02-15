<?php
/**
 * Update to v. 2.0.7
 */

declare(strict_types=1);

defined('COT_CODE') or die('Wrong URL');

global $db_payments;

if (empty($db_payments)) {
    // Registering tables
    Cot::$db->registerTable('payments');
}

if (
    !Cot::$db->indexExists(
        $db_payments,
        'payments_user_area_status_idx',
        ['pay_userid', 'pay_area', 'pay_status']
    )
) {
    Cot::$db->addIndex(
        $db_payments,
        'payments_user_area_status_idx',
        ['pay_userid', 'pay_area', 'pay_status']
    );
}

