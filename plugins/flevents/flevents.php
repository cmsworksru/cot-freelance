<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

use cot\plugins\flevents\inc\EventDictionary;
use cot\users\UsersRepository;

/**
 * Events for freelance
 * @package flevents
 * @author Cotonti team
 * @copyright (c) Cotonti team
 */

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('flevents', 'plug');

[$usr['auth_read'], $usr['auth_write'], $usr['isadmin']] = cot_auth('plug', 'flevents');
cot_block($usr['id'] > 0 && $usr['auth_read']);

if (Cot::$cfg['plugin']['flevents']['perPage'] > 0) {
	[$pn, $d, $d_url] = cot_import_pagenav('d', Cot::$cfg['plugin']['flevents']['perPage']);
}

Cot::$out['subtitle'] = Cot::$L['Events_title'];
Cot::$out['head'] .= Cot::$R['code_noindex'];

require_once Cot::$cfg['system_dir'].'/header.php';

$query_limit = (Cot::$cfg['plugin']['flevents']['perPage'] > 0) ? "LIMIT $d, ". Cot::$cfg['plugin']['flevents']['perPage'] : '';

$totalItems = Cot::$db->query(
    'SELECT COUNT(*) FROM ' . Cot::$db->flevents . ' WHERE ev_touid = ? AND ev_status = ' . EventDictionary::STATUS_NEW,
    $usr['id']
)->fetchColumn();

$pagenav = cot_pagenav('flevents', [], $d, $totalItems, $cfg['plugin']['flevents']['perPage']);

$t = new XTemplate(cot_tplfile('flevents', 'plug'));

$t->assign([
    'EVENTS_COUNT' => $totalItems,
	'EV_REVLINK' => cot_url('users', 'm=details&id=' . $usr['id'] . '&u=' . $usr['name'] . '&tab=reviews'),
]);

$t->assign(cot_generatePaginationTags($pagenav));

$events = [];
if ($totalItems > 0) {
    $query = 'SELECT * FROM ' . Cot::$db->flevents . ' WHERE ev_touid = ? AND ev_status = '
        . EventDictionary::STATUS_NEW . ' ORDER BY ev_date DESC ' . $query_limit;
    $events = Cot::$db->query($query, $usr['id'])->fetchAll();
}

$userIds = [];
foreach ($events as $event) {
    $userId = (int) $event['ev_fromuid'];
    if ($userId > 0) {
        $userIds[] = $userId;
    }
}
$users = [];
if (!empty($userIds)) {
    $userList = UsersRepository::getInstance()
        ->getByCondition('user_id IN (' . implode(',', $userIds) . ')');
    foreach ($userList as $user) {
        $users[$user['user_id']] = $user;
    }
    unset($userList);
}

foreach ($events as $event) {
	if ($event['ev_area'] == 'offers') {
		$t->assign(cot_generate_projecttags($event['ev_code'], 'EV_ROW_PRJ_'));
	} elseif ($event['ev_area'] == 'sbr') {
		$t->assign(cot_generate_sbrtags($event['ev_code'], 'EV_ROW_SBR_'));
	} elseif ($event['ev_area'] == 'marketorders') {
		$t->assign(cot_generate_ordermarkettags($event['ev_code'], 'EV_ROW_ORDER_'));
	} elseif ($event['ev_area'] == 'orderservices') {
		$t->assign(cot_generate_ordertags($event['ev_code'], 'EV_ROW_ORDER_'));
	}


	$t->assign(
        cot_generate_usertags(
            $users[$event['ev_fromuid']] ?? ['user_id' => 0],
            'EV_ROW_USER_'
        )
    );
	
	if ($event['ev_type'] == 'setperformer' || $event['ev_type'] == 'addoffer' || $event['ev_type'] == 'paid' || $event['ev_type'] == 'add1' || $event['ev_type'] == 'edit1' || $event['ev_type'] == 'buy') {
		$style = "bg-success";
	} elseif ($event['ev_type'] == 'refuselastperformer' || $event['ev_type'] == 'refuse' || $event['ev_type'] == 'emp_cancel' || $event['ev_type'] == 'add-1' || $event['ev_type'] == 'edit-1') {
		$style = "bg-danger";
	} elseif ($event['ev_type'] == 'addpost' || $event['ev_type'] == 'addpost_offer' || $event['ev_type'] == 'confirm' || $event['ev_type'] == 'del' || $event['ev_type'] == 'sell') {
		$style = "bg-warning";
	} elseif ($event['ev_type'] == 'new' || $event['ev_type'] == 'edit') {
		$style = "bg-info";
	} else {
		$style = "";
	}

	$t->assign([
		"EV_ROW_ID" => $event['ev_id'],
		"EV_ROW_AREA" => $event['ev_area'],
		"EV_ROW_TYPE" => $event['ev_type'],
		"EV_ROW_TO" => $event['ev_touid'],
		"EV_ROW_FROM" => $event['ev_fromuid'],
		"EV_ROW_DATE" => cot_date('datetime_medium', $event['ev_date']),
		"EV_ROW_DATE_STAMP" => $event['ev_date'],
		"EV_ROW_STYLER" => $style,
	]);
	
	$t->parse("MAIN.EV_ROWS");
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';