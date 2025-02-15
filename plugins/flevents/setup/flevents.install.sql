/**
 * Events plugin DB installation
 * @todo индексы, нормальные названия полей
 */
CREATE TABLE IF NOT EXISTS `cot_flevents` (
  `ev_id` INT UNSIGNED NOT NULL auto_increment,
  `ev_area` varchar(64) NOT NULL default '',
  `ev_type` varchar(64) NOT NULL default '',
  `ev_code` varchar(255) NOT NULL default '',
  `ev_date` INT UNSIGNED NOT NULL,
  `ev_touid` INT UNSIGNED NOT NULL,
  `ev_fromuid` INT UNSIGNED NOT NULL DEFAULT 0,
  `ev_status` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY  (`ev_id`),
  KEY `flevent_touid_idx` (`ev_touid`),
  KEY `flevent_touid_status_idx` (`ev_touid`, `ev_status`)
);