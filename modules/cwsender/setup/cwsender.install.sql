CREATE TABLE IF NOT EXISTS `cot_cwsender_letters` (  `letter_id` int(10) unsigned NOT NULL auto_increment,  `letter_listid` int(11) NOT NULL,  `letter_area` varchar(255) NOT NULL,  `letter_code` varchar(255) NOT NULL,  `letter_title` varchar(50) NOT NULL,  `letter_text` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,  `letter_date` int(11) NOT NULL,  `letter_begin` int(11) NOT NULL,  `letter_type` varchar(10) NOT NULL,  `letter_status` varchar(10) NOT NULL,  PRIMARY KEY  (`letter_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;CREATE TABLE IF NOT EXISTS `cot_cwsender_letters_recipients` (  `rec_id` int(10) unsigned NOT NULL auto_increment,  `rec_letterid` int(11) NOT NULL,  `rec_name` varchar(255) NOT NULL,  `rec_email` varchar(255) NOT NULL,  `rec_sent` int(11) NOT NULL,  PRIMARY KEY  (`rec_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;CREATE TABLE IF NOT EXISTS `cot_cwsender_lists` (  `list_id` int(10) unsigned NOT NULL auto_increment,  `list_type` varchar(255) NOT NULL,  `list_title` varchar(255) NOT NULL,  `list_setting` MEDIUMTEXT collate utf8_unicode_ci NOT NULL,  PRIMARY KEY  (`list_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;CREATE TABLE IF NOT EXISTS `cot_cwsender_lists_recipients` (  `rec_id` int(10) unsigned NOT NULL auto_increment,  `rec_listid` int(11) NOT NULL,  `rec_name` varchar(255) NOT NULL,  `rec_email` varchar(255) NOT NULL,  PRIMARY KEY  (`rec_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;