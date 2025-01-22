<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.useroffers.tags
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');

$indicator['all'] = 0;

$offersstat = array();
$offersstat = $db->query("SELECT offer_choise as status, offer_pid as id FROM $db_projects_offers WHERE offer_userid=" . $usr['id'] . " GROUP BY offer_choise")->fetchAll();

foreach($offersstat as $stat)
{
  $stat['indicator'] = $db->query("SELECT COUNT(*) FROM $db_eventindicator WHERE item_userid=".$usr['id']." AND item_status=0 AND item_area='useroffers' AND item_code=".$stat['id'])->fetchColumn();
	if($stat['indicator'] > 0)
  {
   if(!$stat['status']) $stat['status'] = 'none';
   $indicator[$stat['status']]++;
	 $indicator['all']++;
  }
}