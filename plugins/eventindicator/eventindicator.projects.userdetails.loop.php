<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.userdetails.loop
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('eventindicator', 'plug');

if($usr['id'] > 0) $item['indicator'] = $db->query("SELECT COUNT(*) FROM $db_eventindicator WHERE item_userid=".$usr['id']." AND item_status=0 AND (item_area='projects' OR item_area='useroffers') AND item_code=".$item['item_id'])->fetchColumn();