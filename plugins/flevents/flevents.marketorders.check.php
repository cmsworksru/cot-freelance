<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=marketorders.order.main
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

$diff = $sys['now'] - $marketorder['order_date'];
$second=$diff-(int)($diff/60)*60;
if ($diff > '2') {
	$db->query("UPDATE $db_flevents SET ev_status='0' WHERE ev_area='marketorders' AND ev_touid='".$usr['id']."' AND ev_code='".$id."' AND ev_status='1'");
}