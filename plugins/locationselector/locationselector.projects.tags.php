<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.list.tags,projects.admin.list.tags
 * [END_COT_EXT]
 */

/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru, Cotonti team
 * @license BSD
 *
 * @var XTemplate $t
 */
defined('COT_CODE') or die('Wrong URL.');

$t->assign([
	'SEARCH_LOCATION' => cot_select_location(
        $location['country'] ?? null,
        $location['region'] ?? null,
        $location['city'] ?? null
    ),
]);
