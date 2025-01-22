/**
 * Events plugin DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_eventindicator` (
  `item_id` int(10) unsigned NOT NULL auto_increment,
  `item_userid` int(11) NOT NULL,
  `item_date` int(11) NOT NULL,
  `item_code` int(11) NOT NULL,
  `item_area` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `item_type` varchar(64) collate utf8_unicode_ci NOT NULL default '',
  `item_text` text collate utf8_unicode_ci,
  `item_status` int(1) NOT NULL,
  PRIMARY KEY  (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;