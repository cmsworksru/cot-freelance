/**
 * Userpoints module DB installation
 */
CREATE TABLE IF NOT EXISTS `cot_userpoints` (
  `item_id` int unsigned NOT NULL auto_increment,
  `item_userid` int DEFAULT 0,
  `item_date` int DEFAULT 0,
  `item_type` varchar(20) DEFAULT '',
  `item_point` float DEFAULT 0,
  `item_itemid` int DEFAULT 0,
  PRIMARY KEY  (`item_id`)
) 