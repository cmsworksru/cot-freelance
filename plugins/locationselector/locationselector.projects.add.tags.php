<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.add.tags,projects.edit.tags
[END_COT_EXT]
==================== */

/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru, Cotonti team
 * @license BSD
 *
 * @var int|numeric-string|null $id
 * @var XTemplate $t
 */

defined('COT_CODE') or die('Wrong URL.');

if ((int) $id > 0) {
	$t->assign([
		"PRJEDIT_FORM_LOCATION" => cot_select_location(
            $item['item_country'] ?? '',
            $item['item_region'] ?? 0,
            $item['item_city'] ?? 0,
        ),
	]);
} else {
	$t->assign([
		"PRJADD_FORM_LOCATION" => cot_select_location(
            $ritem['item_country'] ?? '',
            $ritem['item_region'] ?? 0,
            $ritem['item_city'] ?? 0,
            true
        ),
	]);
}
