<?php
/**
 * Update to v. 2.0.6
 *
 * Migrate to MySql collation 'utf8mb4_unicode_ci'
 * Will not change collation if user using his own $cfg['mysqlcharset'] and $cfg['mysqlcharset'] settings different
 * from 'utf8mb4'
 *
 * Replace table engine MyISAM to InnoDB
 * Some DB tables updates
 */

declare(strict_types=1);

defined('COT_CODE') or die('Wrong URL');

global $db_payments, $db_payments_services, $db_payments_outs, $db_payments_transfers;

if (empty($db_payments)) {
    // Registering tables
    Cot::$db->registerTable('payments');
    Cot::$db->registerTable('payments_services');
    Cot::$db->registerTable('payments_outs');
    Cot::$db->registerTable('payments_transfers');
}

$changeCollation = false;
if (
    Cot::$cfg['mysqlcharset'] === 'utf8mb4'
    && (empty(Cot::$cfg['mysqlcollate']) || Cot::$cfg['mysqlcollate'] === 'utf8mb4_unicode_ci')
) {
    $changeCollation = true;
}

Cot::$db->query("
    ALTER TABLE `{$db_payments}` 
    MODIFY `pay_id` INT UNSIGNED NOT NULL auto_increment,
    MODIFY `pay_userid` INT UNSIGNED NOT NULL,
    MODIFY `pay_status` varchar(50) NOT NULL DEFAULT '',
    MODIFY `pay_cdate` INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY `pay_pdate` INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY `pay_adate` INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY `pay_summ` DECIMAL(15,5) NOT NULL DEFAULT '0',
    MODIFY `pay_desc` varchar(255) NOT NULL DEFAULT '',
    MODIFY `pay_area` varchar(20) NOT NULL DEFAULT '',
    MODIFY `pay_code` varchar(255) NOT NULL DEFAULT '',
    MODIFY `pay_time` INT UNSIGNED DEFAULT 0,
    MODIFY `pay_redirect` varchar(255) NOT NULL DEFAULT '',
    ENGINE=InnoDB;"
);
if ($changeCollation) {
    Cot::$db->query("ALTER TABLE `{$db_payments}`
    CONVERT TO CHARACTER SET '" . Cot::$cfg['mysqlcharset'] . "' COLLATE '" . Cot::$cfg['mysqlcollate'] . "', 
    DEFAULT CHARACTER SET='" . Cot::$cfg['mysqlcharset'] . "' COLLATE='" . Cot::$cfg['mysqlcollate'] . "'");
}

if (!Cot::$db->fieldExists($db_payments, 'pay_system')) {
    Cot::$db->query(
        "ALTER TABLE $db_payments "
        . " ADD `pay_system` varchar(100) NOT NULL DEFAULT '' AFTER `pay_status`, "
        . " ADD `pay_method` varchar(255) NOT NULL DEFAULT '' AFTER `pay_system`, "
        . " ADD `pay_payment_id` varchar(255) NOT NULL DEFAULT '' AFTER `pay_method`, "
        . " ADD `pay_transaction_id` varchar(255) NOT NULL DEFAULT '' AFTER `pay_payment_id` "
    );
}

if (!Cot::$db->indexExists($db_payments, 'payments_userid_idx', 'pay_userid')) {
    Cot::$db->addIndex($db_payments, 'payments_userid_idx', 'pay_userid');
}

Cot::$db->query("
    ALTER TABLE `{$db_payments_services}` 
    MODIFY `service_userid` INT UNSIGNED NOT NULL,
    MODIFY `service_expire` INT UNSIGNED NOT NULL,
    ENGINE=InnoDB;"
);
if ($changeCollation) {
    Cot::$db->query("ALTER TABLE `{$db_payments_services}`
    CONVERT TO CHARACTER SET '" . Cot::$cfg['mysqlcharset'] . "' COLLATE '" . Cot::$cfg['mysqlcollate'] . "', 
    DEFAULT CHARACTER SET='" . Cot::$cfg['mysqlcharset'] . "' COLLATE='" . Cot::$cfg['mysqlcollate'] . "'");
}

Cot::$db->query("
    ALTER TABLE `{$db_payments_outs}` 
    MODIFY `out_userid` INT UNSIGNED NOT NULL,
    MODIFY `out_summ` DECIMAL(15,5) NOT NULL,
    MODIFY `out_status` varchar(50) NOT NULL DEFAULT '',
    MODIFY `out_date` INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY `out_details` text NOT NULL,
    ENGINE=InnoDB;"
);
if ($changeCollation) {
    Cot::$db->query("ALTER TABLE `{$db_payments_outs}`
    CONVERT TO CHARACTER SET '" . Cot::$cfg['mysqlcharset'] . "' COLLATE '" . Cot::$cfg['mysqlcollate'] . "', 
    DEFAULT CHARACTER SET='" . Cot::$cfg['mysqlcharset'] . "' COLLATE='" . Cot::$cfg['mysqlcollate'] . "'");
}
if (!Cot::$db->indexExists($db_payments_outs, 'payments_outs_status_idx', 'out_status')) {
    Cot::$db->addIndex($db_payments_outs, 'payments_outs_status_idx', 'out_status');
    Cot::$db->addIndex($db_payments_outs, 'payments_outs_userid_idx', 'out_userid');
}

Cot::$db->query("
    ALTER TABLE `{$db_payments_transfers}` 
    MODIFY `trn_id` INT UNSIGNED NOT NULL auto_increment,
    MODIFY `trn_from` INT UNSIGNED NOT NULL,
    MODIFY `trn_to` INT UNSIGNED NOT NULL,
    MODIFY `trn_summ` DECIMAL(15,5) NOT NULL,
    MODIFY `trn_status` varchar(50) NOT NULL DEFAULT '',
    MODIFY `trn_date` INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY `trn_done` INT UNSIGNED NOT NULL DEFAULT 0,
    MODIFY `trn_comment` text NOT NULL,
    ENGINE=InnoDB;"
);
if ($changeCollation) {
    Cot::$db->query("ALTER TABLE `{$db_payments_transfers}`
    CONVERT TO CHARACTER SET '" . Cot::$cfg['mysqlcharset'] . "' COLLATE '" . Cot::$cfg['mysqlcollate'] . "', 
    DEFAULT CHARACTER SET='" . Cot::$cfg['mysqlcharset'] . "' COLLATE='" . Cot::$cfg['mysqlcollate'] . "'");
}
if (!Cot::$db->indexExists($db_payments_transfers, 'payments_transfers_status_idx', 'trn_status')) {
    Cot::$db->addIndex($db_payments_transfers, 'payments_transfers_status_idx', 'trn_status');
    Cot::$db->addIndex($db_payments_transfers, 'payments_transfers_from_idx', 'trn_from');
}