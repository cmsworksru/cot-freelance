<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if (!Cot::$db->fieldExists($db_users, "user_detailcounts")) {
    Cot::$db->query('ALTER TABLE ' . Cot::$db->users . ' ADD COLUMN user_detailcounts INT NOT NULL DEFAULT 0');
}