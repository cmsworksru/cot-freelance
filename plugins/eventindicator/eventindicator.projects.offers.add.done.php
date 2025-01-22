<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.add.done
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');

$indicator['item_area'] = 'projects';
$indicator['item_type'] = 'addoffer';
$indicator['item_code'] = $item['item_id'];
$indicator['item_date'] = (int)$sys['now'];
$indicator['item_userid'] = (int)$item['user_id'];

cot_eventindicator_add($indicator);