<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if (Cot::$db->fieldExists(Cot::$db->users, 'user_detailcounts')) {
    Cot::$db->query('ALTER TABLE ' . Cot::$db->users . ' DROP COLUMN user_detailcounts');
}