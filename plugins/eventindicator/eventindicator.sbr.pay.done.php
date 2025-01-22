<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.pay.done
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');
$indicator['item_area'] = 'sbr';
$indicator['item_type'] = 'paid';
$indicator['item_code'] = $pay['pay_code'];
$indicator['item_date'] = (int)$sys['now'];
$indicator['item_userid'] = (int)$sbr['sbr_performer'];

cot_eventindicator_add($indicator);