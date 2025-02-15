<?php 

declare(strict_types=1);

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects;

if (empty($db_projects)) {
    Cot::$db->registerTable('projects');
}

Cot::$db->query('ALTER TABLE ' . Cot::$db->projects . ' MODIFY item_bold INT NOT NULL DEFAULT 0');