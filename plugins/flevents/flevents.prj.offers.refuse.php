<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.offers.refuse
 * [END_COT_EXT]
**/

/**
 * Events for freelance
 *
 * @package flevents
 * @version 1.0
 * @author CoTEMPLATE
 * @copyright Copyright (c) CoTEMPLATE.com
 */

defined('COT_CODE') or die('Wrong URL');

$ev_data['ev_area'] = 'offers';
$ev_data['ev_type'] = 'refuse';
$ev_data['ev_code'] = $item['item_id'];
$ev_data['ev_date'] = (int)$sys['now'];
$ev_data['ev_touid'] = (int)$urr['user_id'];
$ev_data['ev_fromuid'] = (int)$item['user_id'];
$ev_data['ev_status'] = '1';

insert_not($ev_data);