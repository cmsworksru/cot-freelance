<?php
/**
 * Update to v. 1.0.2:
 */

defined('COT_CODE') or die('Wrong URL');

global $db_projects;

if (empty($db_projects)) {
    Cot::$db->registerTable('projects');
}

Cot::$db->query('ALTER TABLE ' . Cot::$db->projects .' MODIFY item_top INT UNSIGNED NOT NULL DEFAULT 0');