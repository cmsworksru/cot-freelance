<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
**/


defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('flevents', 'plug');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'flevents');
cot_block($usr['id'] > 0 && $usr['auth_read']);

if($cfg['plugin']['flevents']['perPage'] > 0)
{
	list($pn, $d, $d_url) = cot_import_pagenav('d', $cfg['plugin']['flevents']['perPage']);
}

$out['subtitle'] = $L['Events_title'];
$out['head'] .= $R['code_noindex'];

require_once $cfg['system_dir'].'/header.php';

$query_limit = ($cfg['plugin']['flevents']['perPage'] > 0) ? "LIMIT $d, ".$cfg['plugin']['flevents']['perPage'] : '';

$sql = $db->query("SELECT * FROM $db_flevents WHERE ev_status='1' AND ev_touid='".$usr['id']."' ORDER BY ev_date DESC
	" . $query_limit . "");

$totalitems = $db->query("SELECT COUNT(*) FROM $db_flevents WHERE ev_status='1' AND ev_touid=".$usr['id'])->fetchColumn();
	
$pagenav = cot_pagenav('flevents', $status, $d, $totalitems, $cfg['plugin']['flevents']['perPage']);

$t = new XTemplate(cot_tplfile('flevents', 'plug'));

$t->assign(array(
	"PAGENAV_COUNT" => $totalitems,
	"PAGENAV_PAGES" => $pagenav['main'],
	"PAGENAV_PREV" => $pagenav['prev'],
	"PAGENAV_NEXT" => $pagenav['next'],
	"EV_REVLINK" => cot_url('users', 'm=details&id=' . $usr['id'] . '&u=' . $usr['name'] . '&tab=reviews'),
));

while ($flevents = $sql->fetch())
{
	if ($flevents['ev_area'] == 'offers') {
		$t->assign(cot_generate_projecttags($flevents['ev_code'], 'EV_ROW_PRJ_'));
	} elseif($flevents['ev_area'] == 'sbr') {
		$t->assign(cot_generate_sbrtags($flevents['ev_code'], 'EV_ROW_SBR_'));
	} elseif($flevents['ev_area'] == 'marketorders') {
		$t->assign(cot_generate_ordermarkettags($flevents['ev_code'], 'EV_ROW_ORDER_'));
	}
	 elseif($flevents['ev_area'] == 'orderservices') {
		$t->assign(cot_generate_ordertags($flevents['ev_code'], 'EV_ROW_ORDER_'));
	}
	
	$t->assign(cot_generate_usertags($flevents['ev_fromuid'], 'EV_ROW_USER_'));
	
	if ($flevents['ev_type'] == 'setperformer' || $flevents['ev_type'] == 'addoffer' || $flevents['ev_type'] == 'paid' || $flevents['ev_type'] == 'add1' || $flevents['ev_type'] == 'edit1' || $flevents['ev_type'] == 'buy') {
		$style = "bg-success";
	} elseif ($flevents['ev_type'] == 'refuselastperformer' || $flevents['ev_type'] == 'refuse' || $flevents['ev_type'] == 'emp_cancel' || $flevents['ev_type'] == 'add-1' || $flevents['ev_type'] == 'edit-1') {
		$style = "bg-danger";
	} elseif ($flevents['ev_type'] == 'addpost' || $flevents['ev_type'] == 'addpost_offer' || $flevents['ev_type'] == 'confirm' || $flevents['ev_type'] == 'del' || $flevents['ev_type'] == 'sell') {
		$style = "bg-warning";
	} elseif ($flevents['ev_type'] == 'new' || $flevents['ev_type'] == 'edit') {
		$style = "bg-info";
	} else {
		$style = "";
	}

	$t->assign(array(
		"EV_ROW_ID" => $flevents['ev_id'],
		"EV_ROW_AREA" => $flevents['ev_area'],
		"EV_ROW_TYPE" => $flevents['ev_type'],
		"EV_ROW_TO" => $flevents['ev_touid'],
		"EV_ROW_FROM" => $flevents['ev_fromuid'],
		"EV_ROW_DATE" => cot_date('datetime_medium', $flevents['ev_date']),
		"EV_ROW_DATE_STAMP" => $flevents['ev_date'],
		"EV_ROW_STYLER" => $style,
	));
	
	$t->parse("MAIN.EV_ROWS");
}

$db->query("UPDATE $db_flevents SET ev_status='1' WHERE ev_touid='".$usr['id']."' AND ev_status='0' ORDER BY ev_date DESC");

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'].'/footer.php';