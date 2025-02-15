CREATE TABLE IF NOT EXISTS `cot_payments` (
    `pay_id` INT UNSIGNED NOT NULL auto_increment,
    `pay_userid` INT UNSIGNED NOT NULL,
    `pay_status` varchar(50) NOT NULL DEFAULT '',
    `pay_system` varchar(100) NOT NULL DEFAULT '',
    `pay_method` varchar(255) NOT NULL DEFAULT '',
    `pay_payment_id` varchar(255) NOT NULL DEFAULT '',
    `pay_transaction_id` varchar(255) NOT NULL DEFAULT '',
    `pay_cdate` INT UNSIGNED NOT NULL DEFAULT 0,
    `pay_pdate` INT UNSIGNED NOT NULL DEFAULT 0,
    `pay_adate` INT UNSIGNED NOT NULL DEFAULT 0,
    `pay_summ` DECIMAL(15,5) NOT NULL DEFAULT '0',
    `pay_desc` varchar(255) NOT NULL DEFAULT '',
    `pay_area` varchar(20) NOT NULL DEFAULT '',
    `pay_code` varchar(255) NOT NULL DEFAULT '',
    `pay_time` INT UNSIGNED DEFAULT 0,
    `pay_redirect` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY  (`pay_id`),
    KEY `payments_userid_idx` (`pay_userid`),
    KEY `payments_status_idx` (`pay_status`)
);

CREATE TABLE IF NOT EXISTS `cot_payments_services` (
    `service_id` INT UNSIGNED NOT NULL auto_increment,
    `service_area` varchar(20) NOT NULL,
    `service_userid` INT UNSIGNED NOT NULL,
    `service_expire` INT UNSIGNED NOT NULL,
    PRIMARY KEY  (`service_id`)
);

CREATE TABLE IF NOT EXISTS `cot_payments_outs` (
    `out_id` INT UNSIGNED NOT NULL auto_increment,
    `out_userid` INT UNSIGNED NOT NULL,
    `out_summ` DECIMAL(15,5) NOT NULL,
    `out_status` varchar(50) NOT NULL DEFAULT '',
    `out_date` INT UNSIGNED NOT NULL DEFAULT 0,
    `out_details` TEXT NOT NULL,
    PRIMARY KEY  (`out_id`),
    KEY `payments_outs_status_idx` (`out_status`),
    KEY `payments_outs_userid_idx` (`out_userid`)
);

CREATE TABLE IF NOT EXISTS `cot_payments_transfers` (
    `trn_id` INT UNSIGNED NOT NULL auto_increment,
    `trn_from` INT UNSIGNED NOT NULL,
    `trn_to` INT UNSIGNED NOT NULL,
    `trn_summ` DECIMAL(15,5) NOT NULL,
    `trn_status` varchar(50) NOT NULL DEFAULT '',
    `trn_date` INT UNSIGNED NOT NULL DEFAULT 0,
    `trn_done` INT UNSIGNED NOT NULL DEFAULT 0,
    `trn_comment` text NOT NULL,
    PRIMARY KEY  (`trn_id`),
    KEY `payments_transfers_status_idx` (`trn_status`),
    KEY `payments_transfers_from_idx` (`trn_from`)
);