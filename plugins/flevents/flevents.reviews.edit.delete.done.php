<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.edit.delete.done
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

$ev_data['ev_area'] = 'reviews';
$ev_data['ev_type'] = 'del';
$ev_data['ev_code'] = $itemid;
$ev_data['ev_date'] = (int)$sys['now'];
$ev_data['ev_touid'] = (int)$item['item_touserid'];
$ev_data['ev_fromuid'] = (int)$item['item_userid'];
$ev_data['ev_status'] = '1';

insert_not($ev_data);