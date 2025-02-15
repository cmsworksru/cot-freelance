<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if (!Cot::$db->fieldExists(Cot::$db->users, "user_referal")) {
    Cot::$db->query('ALTER TABLE '. Cot::$db->users . ' ADD COLUMN user_referal INT NOT NULL DEFAULT 0');
}