<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=reviews.add.add.done
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
$ev_data['ev_type'] = 'add'.$ritem['item_score'];
$ev_data['ev_code'] = $itemid;
$ev_data['ev_date'] = (int)$ritem['item_date'];
$ev_data['ev_touid'] = (int)$touser;
$ev_data['ev_fromuid'] = (int)$usr['id'];
$ev_data['ev_status'] = '1';

insert_not($ev_data);