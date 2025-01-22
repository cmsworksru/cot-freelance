<?php
/**
 * Update to v. 2.6.5:
 */

defined('COT_CODE') or die('Wrong URL');

Cot::$db->query(
    'ALTER TABLE ' . Cot::$db->users . ' MODIFY user_cats TEXT NULL DEFAULT NULL'
);
