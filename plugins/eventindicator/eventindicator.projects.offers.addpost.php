<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.addpost.done
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');

$indicator['item_type'] = 'addpost';
$indicator['item_code'] = $item['item_id'];
$indicator['item_date'] = (int)$sys['now'];

$indicator['item_area'] = 'projects';
$indicator['item_userid'] = (int)$item['user_id'];

cot_eventindicator_add($indicator);

$indicator['item_area'] = 'useroffers';
$indicator['item_userid'] = (int)$offer['user_id'];

cot_eventindicator_add($indicator);