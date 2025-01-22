<?php 

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('users', 'module');
require_once cot_incfile('extrafields');

global $db_users;

cot_extrafield_add($db_users, 'sendmail', 'checkbox', $R['input_checkbox'],'','1','','', '','');