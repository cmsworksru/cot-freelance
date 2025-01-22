<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.confirm.done
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');
$indicator['item_area'] = 'sbr';
$indicator['item_type'] = 'confirm';
$indicator['item_code'] = $id;
$indicator['item_date'] = (int)$sys['now'];
$indicator['item_userid'] = (int)$sbr['sbr_employer'];

cot_eventindicator_add($indicator);