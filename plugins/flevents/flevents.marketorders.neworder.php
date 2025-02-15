<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=marketorders.order.paid
 * [END_COT_EXT]
**/

/**
 * Events for freelance
 *
 * @package flevents
 * @version 1.2
 * @author CoTEMPLATE
 * @copyright Copyright (c) CoTEMPLATE.com
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('flevents', 'plug');

$cst_id = ($customer['user_id'] > 0) ? $customer['user_id'] : '0';

$ev_data_sell['ev_area'] = 'marketorders';
$ev_data_sell['ev_type'] = 'sell';
$ev_data_sell['ev_code'] = $marketorder['order_id'];
$ev_data_sell['ev_date'] = (int)$sys['now'];
$ev_data_sell['ev_touid'] = (int)$seller['user_id'];
$ev_data_sell['ev_fromuid'] = (int)$cst_id;
$ev_data_sell['ev_status'] = '1';
	
insert_not($ev_data_sell);

if ($cst_id > 0) {
	$ev_data['ev_area'] = 'marketorders';
	$ev_data['ev_type'] = 'buy';
	$ev_data['ev_code'] = $marketorder['order_id'];
	$ev_data['ev_date'] = (int)$sys['now'];
	$ev_data['ev_touid'] = (int)$customer['user_id'];
	$ev_data['ev_fromuid'] = '0';
	$ev_data['ev_status'] = '1';
	
	insert_not($ev_data);
}