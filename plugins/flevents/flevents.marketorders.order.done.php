<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=marketorders.order.done
 * [END_COT_EXT]
**/

/**
 * Events for freelance
 *
 * @package flevents
 * @version 1.3
 * @author CoTEMPLATE
 * @copyright Copyright (c) CoTEMPLATE.com
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('flevents', 'plug');

$ev_data['ev_area'] = 'marketorders';
$ev_data['ev_type'] = 'paid';
$ev_data['ev_code'] = $marketorder['order_id'];
$ev_data['ev_date'] = (int)$sys['now'];
$ev_data['ev_touid'] = (int)$seller['user_id'];
$ev_data['ev_fromuid'] = '0';
$ev_data['ev_status'] = '1';
	
insert_not($ev_data);