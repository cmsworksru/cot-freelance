/**
 * Projects module DB installation
 * @todo indexes
 */
CREATE TABLE IF NOT EXISTS `cot_projects` (
  `item_id` int unsigned NOT NULL auto_increment,
  `item_state` tinyint DEFAULT 0,
  `item_realized` tinyint DEFAULT 0,
  `item_userid` int DEFAULT 0,
  `item_performer` int DEFAULT 0,
  `item_date` int DEFAULT 0,
  `item_update` int DEFAULT 0,
  `item_parser` VARCHAR(64) NOT NULL DEFAULT '',
  `item_cat` varchar(255) DEFAULT '',
  `item_type` int DEFAULT 0,
  `item_title` varchar(255) DEFAULT '',
  `item_alias` varchar(255) DEFAULT '',
  `item_desc` varchar(255) DEFAULT '',
  `item_keywords` varchar(255) DEFAULT '',
  `item_metatitle` varchar(255) DEFAULT '',
  `item_metadesc` varchar(255) DEFAULT '',
  `item_text` MEDIUMTEXT,
  `item_cost` float DEFAULT 0, -- @todo decimal
  `item_count` int DEFAULT 0,
  `item_offerscount` int DEFAULT 0,
  `item_country` varchar(3) DEFAULT '',
  `item_region` INT NOT NULL DEFAULT 0,
  `item_city` INT NOT NULL DEFAULT 0,
  PRIMARY KEY  (`item_id`)
);

CREATE TABLE IF NOT EXISTS `cot_projects_offers` (
  `offer_id` int unsigned NOT NULL auto_increment,
  `offer_pid` int DEFAULT 0,
  `offer_date` int DEFAULT 0,
  `offer_userid` int DEFAULT 0,
  `offer_text` MEDIUMTEXT,
  `offer_cost_min` float DEFAULT 0,
  `offer_cost_max` float DEFAULT 0,
  `offer_time_min` int DEFAULT 0,
  `offer_time_max` int DEFAULT 0,
  `offer_time_type` tinyint DEFAULT 0,
  `offer_choise` varchar(20) DEFAULT '',
  `offer_choise_date` int DEFAULT 0,
  `offer_hidden` tinyint DEFAULT 0,
  PRIMARY KEY  (`offer_id`)
);

CREATE TABLE IF NOT EXISTS `cot_projects_posts` (
  `post_id` int unsigned NOT NULL auto_increment,
  `post_pid` int DEFAULT 0,
  `post_oid` int DEFAULT 0,
  `post_userid` int DEFAULT 0,
  `post_text` MEDIUMTEXT,
  `post_date` int DEFAULT 0,
  PRIMARY KEY  (`post_id`)
);

CREATE TABLE IF NOT EXISTS `cot_projects_types` (
  `type_id` int unsigned NOT NULL auto_increment,
  `type_title` varchar(255) DEFAULT '',
  PRIMARY KEY  (`type_id`)
);
