<?php

defined('COT_CODE') or die('Wrong URL');

global $db_users;

if (!Cot::$db->fieldExists($db_users, 'user_prjsenderdate')) {
    Cot::$db->query('ALTER TABLE ' . Cot::$db->users . ' ADD COLUMN user_prjsenderdate INT NOT NULL DEFAULT 0');
}

if (!Cot::$db->fieldExists($db_users, 'user_prjsendercats')) {
    Cot::$db->query(
        'ALTER TABLE ' . Cot::$db->users . ' ADD COLUMN user_prjsendercats MEDIUMTEXT NOT NULL DEFAULT NULL'
    );
}