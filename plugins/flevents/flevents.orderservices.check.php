<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=orderservices.order.main
 * [END_COT_EXT]
**/


defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('flevents', 'plug');

$diff = $sys['now'] - $orderservice['order_date'];
$second=$diff-(int)($diff/60)*60;
if ($diff > '2') {
	$db->query("UPDATE $db_flevents SET ev_status='0' WHERE ev_area='orderservices' AND ev_touid='".$usr['id']."' AND ev_code='".$id."' AND ev_status='1'");
}