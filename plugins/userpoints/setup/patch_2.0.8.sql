ALTER TABLE `cot_userpoints` 
CHANGE `item_id` `item_id` int unsigned NOT NULL auto_increment,
CHANGE `item_userid` `item_userid` int DEFAULT 0,
CHANGE `item_date` `item_date` int DEFAULT 0,
CHANGE `item_type` `item_type` varchar(20) DEFAULT '',
CHANGE `item_point` `item_point` float DEFAULT 0,
CHANGE `item_itemid` `item_itemid` int DEFAULT 0;