<?php
/**
 * Installation handler
 *
 * @package payprjtop
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('projects', 'module');

global $db_projects;

if (empty($db_projects)) {
    Cot::$db->registerTable('projects');
}

// Add field if missing
if (!Cot::$db->fieldExists(Cot::$db->projects, "item_top")) {
	Cot::$db->query('ALTER TABLE ' . Cot::$db->projects .' ADD COLUMN item_top INT UNSIGNED NOT NULL DEFAULT 0');
}
