<?php
/**
 * Events for freelance
 * @package flevents
 * @author Cotonti team
 * @copyright (c) Cotonti team
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('flevents', 'plug');

cot::$db->registerTable('flevents');

function insert_not($noti_data)
{
    global $db, $db_flevents;
    $db->insert($db_flevents, $noti_data);
}

function flevents_show($template = '', $count = '')
{
    global $db, $db_flevents, $usr;

    if (Cot::$cfg['plugin']['flevents']['perPage'] > 0 && empty($count)) {
        [$pn, $d, $d_url] = cot_import_pagenav('d', Cot::$cfg['plugin']['flevents']['perPage']);
    }

    $query_limit = (Cot::$cfg['plugin']['flevents']['perPage'] > 0 && empty($count))
        ? "LIMIT $d, " . Cot::$cfg['plugin']['flevents']['perPage']
        : "LIMIT " . $count;

    $sql = Cot::$db->query(
        'SELECT * FROM ' . Cot::$db->flevents . ' WHERE ev_status = 1 AND ev_touid = ? ORDER BY ev_date DESC '
	    . $query_limit,
        Cot::$usr['id']
    );

    if (empty($count)) {
        $totalitems = Cot::$db->query(
            'SELECT COUNT(*) FROM ' . Cot::$db->flevents . ' WHERE ev_status = 1 AND ev_touid = ?',
            Cot::$usr['id']
        )->fetchColumn();
        $pagenav = cot_pagenav('flevents', [], $d, $totalitems, Cot::$cfg['plugin']['flevents']['perPage']);

        $t->assign(cot_generatePaginationTags($pagenav));

    } else {
        $totalitems = Cot::$db->query(
            'SELECT COUNT(*) FROM ' . Cot::$db->flevents . ' WHERE ev_status = 1 AND ev_touid = ? ' . $query_limit,
            Cot::$usr['id']
        )->fetchColumn();
    }

    $t = new XTemplate(cot_tplfile(['flevents', $template], 'plug'));

    $t->assign([
        "EVENTS_COUNT" => $totalitems,
//        "PAGENAV_PAGES" => $pagenav['main'],
//        "PAGENAV_PREV" => $pagenav['prev'],
//        "PAGENAV_NEXT" => $pagenav['next'],
        "EV_REVLINK" => cot_url('users', 'm=details&id=' . $usr['id'] . '&u=' . $usr['name'] . '&tab=reviews'),
    ]);

    while ($flevents = $sql->fetch()) {
        if ($flevents['ev_area'] == 'offers') {
            $t->assign(cot_generate_projecttags($flevents['ev_code'], 'EV_ROW_PRJ_'));
        } elseif ($flevents['ev_area'] == 'sbr') {
            $t->assign(cot_generate_sbrtags($flevents['ev_code'], 'EV_ROW_SBR_'));
        } elseif ($flevents['ev_area'] == 'marketorders') {
            $t->assign(cot_generate_ordermarkettags($flevents['ev_code'], 'EV_ROW_ORDER_'));
        } elseif ($flevents['ev_area'] == 'orderservices') {
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

        $t->assign([
            "EV_ROW_ID" => $flevents['ev_id'],
            "EV_ROW_AREA" => $flevents['ev_area'],
            "EV_ROW_TYPE" => $flevents['ev_type'],
            "EV_ROW_TO" => $flevents['ev_touid'],
            "EV_ROW_FROM" => $flevents['ev_fromuid'],
            "EV_ROW_DATE" => cot_date('datetime_medium', $flevents['ev_date']),
            "EV_ROW_DATE_STAMP" => $flevents['ev_date'],
            "EV_ROW_STYLER" => $style,
        ]);

        $t->parse("MAIN.EV_ROWS");
    }


    $t->parse('MAIN');
    return $t->text("MAIN");
}

function cot_generate_ordertags(
    $item_data,
    $tag_prefix = '',
    $textlength = 0,
    $admin_rights = null,
    $pagepath_home = false,
    $emptytitle = ''
) {
    global $db, $cfg, $L, $Ls, $R, $db_services, $db_services_orders;

    if (!is_array($item_data)) {
        $sql = $db->query(
            "SELECT * FROM $db_services_orders  AS o
		LEFT JOIN $db_services AS m ON m.item_id=o.order_pid
		WHERE order_status!='new' AND order_id=" . (int)$item_data . " LIMIT 1"
        );
        $item_data = $sql->fetch();
    }

    if ($item_data['order_id'] > 0) {
        $temp_array = [
            "ID" => $item_data['order_id'],
            "COUNT" => $item_data['order_count'],
            "COST" => $item_data['order_cost'],
            "TITLE" => $item_data['order_title'],
            "COMMENT" => $item_data['order_text'],
            "EMAIL" => $item_data['order_email'],
            "PAID" => $item_data['order_paid'],
            "DONE" => $item_data['order_done'],
            "STATUS" => $item_data['order_status'],
            "DOWNLOAD" => (in_array($item_data['order_status'], ['paid', 'done']
                ) && !empty($item_data['item_file']) && file_exists(
                    $cfg['plugin']['orderservices']['filepath'] . '/' . $item_data['item_file']
                )) ? cot_url('plug', 'r=orderservices&m=download&id=' . $item_data['order_id'] . '&key=' . $key) : '',
            "LOCALSTATUS" => $L['orderservices_status_' . $item_data['order_status']],
            "WARRANTYDATE" => $item_data['order_paid'] + $cfg['plugin']['orderservices']['warranty'] * 60 * 60 * 24,
        ];
    } else {
        $temp_array = [
            'ORDER_ID' => (!empty($emptyid)) ? $emptyid : $L['Deleted'],
        ];
    }

    $return_array = [];
    foreach ($temp_array as $key => $val) {
        $return_array[$tag_prefix . $key] = $val;
    }

    return $return_array;
}

function cot_generate_ordermarkettags(
    $item_data,
    $tag_prefix = '',
    $textlength = 0,
    $admin_rights = null,
    $pagepath_home = false,
    $emptytitle = ''
) {
    global $db, $cfg, $L, $Ls, $R, $db_market, $db_market_orders;

    if (!is_array($item_data)) {
        $sql = $db->query(
            "SELECT * FROM $db_market_orders  AS o
		LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
		WHERE order_status!='new' AND order_id=" . (int)$item_data . " LIMIT 1"
        );
        $item_data = $sql->fetch();
    }

    if ($item_data['order_id'] > 0) {
        $temp_array = [
            "ID" => $item_data['order_id'],
            "COUNT" => $item_data['order_count'],
            "COST" => $item_data['order_cost'],
            "TITLE" => $item_data['order_title'],
            "COMMENT" => $item_data['order_text'],
            "EMAIL" => $item_data['order_email'],
            "PAID" => $item_data['order_paid'],
            "DONE" => $item_data['order_done'],
            "STATUS" => $item_data['order_status'],
            "DOWNLOAD" => (in_array($item_data['order_status'], ['paid', 'done']
                ) && !empty($item_data['item_file']) && file_exists(
                    $cfg['plugin']['marketorders']['filepath'] . '/' . $item_data['item_file']
                )) ? cot_url('plug', 'r=marketorders&m=download&id=' . $item_data['order_id'] . '&key=' . $key) : '',
            "LOCALSTATUS" => $L['marketorders_status_' . $item_data['order_status']],
            "WARRANTYDATE" => $item_data['order_paid'] + $cfg['plugin']['marketorders']['warranty'] * 60 * 60 * 24,
        ];
    } else {
        $temp_array = [
            'ORDER_ID' => (!empty($emptyid)) ? $emptyid : $L['Deleted'],
        ];
    }

    $return_array = [];
    foreach ($temp_array as $key => $val) {
        $return_array[$tag_prefix . $key] = $val;
    }

    return $return_array;
}