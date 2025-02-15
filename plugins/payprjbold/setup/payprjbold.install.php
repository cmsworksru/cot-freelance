<?php
/**
 * Installation handler
 *
 * @package payprjbold
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru, Cotonti team
 * @license BSD
 */

declare(strict_types=1);

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects;

if (empty($db_projects)) {
    Cot::$db->registerTable('projects');
}

// Add field if missing @todo миграцию
if (!Cot::$db->fieldExists($db_projects, 'item_bold')) {
	Cot::$db->query("ALTER TABLE $db_projects ADD COLUMN item_bold INT NOT NULL DEFAULT 0");
}
