<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.list.tags
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');

$indicator['all'] = 0;

$sbrstat = array();
$sbrstat = $db->query("SELECT sbr_status as status, sbr_id as id FROM $db_sbr
		WHERE (sbr_employer=" . $usr['id'] . " OR sbr_performer=" . $usr['id'] . ")
		GROUP BY sbr_status")->fetchAll();

foreach($sbrstat as $stat)
{
  $stat['indicator'] = $db->query("SELECT COUNT(*) FROM $db_eventindicator WHERE item_userid=".$usr['id']." AND item_status=0 AND item_area='sbr' AND item_code=".$stat['id'])->fetchColumn();
	if($stat['indicator'] > 0)
  {
   $indicator[$stat['status']]++;
	 $indicator['all']++;
  }
}

foreach($R['sbr_statuses'] as $status)
{
	$indicator[$status] = ($indicator[$status] > 0) ? $indicator[$status] : 0;
}