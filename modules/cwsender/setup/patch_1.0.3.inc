<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('users', 'module');

global $db_users;

$db->query("ALTER TABLE $db_users CHANGE `user_sendmail` `user_sendmail` TINYINT( 1 ) NULL DEFAULT '1'");
$db->update($db_users, array('user_sendmail' => '1'));