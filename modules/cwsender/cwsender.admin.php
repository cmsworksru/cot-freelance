<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');


include_once cot_incfile('cwsender', 'module');
require_once cot_incfile('forms');
require_once cot_incfile('users', 'module');

if(empty($n)) $n = 'lists';

$t = new XTemplate(cot_tplfile('cwsender.admin', 'module'));

if($n == 'lists')
{
	$type = 'text';
	
	if($a == 'add')
	{
		$rlist['list_title'] = cot_import('rtitle', 'P', 'TXT');
		$rlist['list_type'] = cot_import('rtype', 'P', 'ALP');
		
		$type = (!empty($rlist['list_type'])) ? $rlist['list_type'] : 'text';
		
		cot_check(empty($rlist['list_title']), 'Не указан заголовок списка', 'rtitle');
		
		switch ($rlist['list_type'])
		{
		
			case 'text':
				
				$setting['text'] = cot_import('rtext', 'P', 'HTM');
				
				cot_check(empty($setting['text']), $L['cwsender_error_type_text_empty'], 'rsetting');
				
			break;
		
			case 'groups':
				
				$rusergroupsms = cot_import('rusergroupsms', 'P', 'ARR');
				if(count($rusergroupsms) > 0)
				{
					foreach ($rusergroupsms as $grp => $var)
					{
						$sgroups[] = $grp;
					}

					$setting['groups'] = implode(',',$sgroups);
				}
				
				cot_check(empty($setting['groups']), $L['cwsender_error_type_groups_empty'], 'rusergroupsms');
				
			break;
			
			case 'mysql':

				$setting['mysql'] = cot_import('rquery', 'P', 'TXT');
				
				if(!empty($setting['mysql']))
				{				
					$query_resilt = $db->query($setting['mysql'])->fetchAll();
					
				}
				cot_check((empty($setting['mysql']) || count($query_resilt) == 0), $L['cwsender_error_type_mysql_empty'], 'rsetting');
				
			break;
			
			case 'subs':
				
				
				
			break;
		
		}

		if(!cot_error_found())
		{	
			switch($type)
			{
				case 'text':
					$db->insert($db_cwsender_lists, $rlist);
					$lid = $db->lastInsertId();
					
					$lines = preg_split('#\r?\n#', $setting[$type]);
					foreach ($lines as $line)
					{
						$rcpnt = explode(',', $line);
						$rcpnt = array_map('trim', $rcpnt);
						if (count($rcpnt) > 0)
						{
							$rrec['rec_listid'] = $lid;
							$rrec['rec_email'] = $rcpnt[0];
							$rrec['rec_name'] = $rcpnt[1];
							
							$db->insert($db_cwsender_lists_recipients, $rrec);
						}
						unset($rrec);
					}
					
				break;
			
				case 'groups':
					$rlist['list_setting'] = $setting[$type];
					$db->insert($db_cwsender_lists, $rlist);
					$lid = $db->lastInsertId();
				break;
			
				case 'mysql':
					$rlist['list_setting'] = $setting[$type];
					$db->insert($db_cwsender_lists, $rlist);
					$lid = $db->lastInsertId();
				break;
			
				case 'subs':
					$db->insert($db_cwsender_lists, $rlist);
					$lid = $db->lastInsertId();
				break;
			}	
		}
		cot_redirect(cot_url('admin', 'm=cwsender&n=lists', '' ,true));
	}
	
	if($a == 'delete' && !empty($id))
    {
        cwsender_delete_list($id);
		
        cot_redirect(cot_url('admin', 'm=cwsender&n=lists', '' ,true));
    }
	
	$sql = $db->query("SELECT l.*, COUNT(r.rec_id) AS count_recipients FROM $db_cwsender_lists AS l LEFT JOIN $db_cwsender_lists_recipients AS r ON l.list_id = r.rec_listid GROUP BY l.list_id");
	while($list = $sql->fetch())
	{	
		$count_recipients = ($list['list_type'] == 'subs') ? ' ('. cot_rc_link(cot_url('admin', 'm=cwsender&n=subsusers&subsid='.$list['list_id']), $list['count_recipients']).')' : '' ;
		$t->assign(array(
			'LIST_ROW_ID' => $list['list_id'],
			'LIST_ROW_TITLE' => $list['list_title'].$count_recipients,
			'LIST_ROW_TYPE' => $list['list_type'],
			'LIST_ROW_SETTING' => $list['list_setting'],
			'LIST_ROW_DELETE_URL' => cot_url('admin', 'm=cwsender&n=lists&a=delete&id=' . $list['list_id']),
			'LIST_ROW_EDIT_URL' => cot_url('admin', 'm=cwsender&n=lists&a=edit&id=' . $list['list_id']),
			'LIST_ROW_SEND_URL' => cot_url('admin', 'm=cwsender&n=lists&a=send&id=' . $list['list_id']),
		));
		$t->parse('MAIN.LISTS.LIST_ROW');
	}

	$R['users_input_grplist_checkbox'] = '<input type="checkbox" class="checkbox" name="{$name}" value="1"{$checked}{$attrs} /> ';
	$R['users_input_grplist_radio'] = '';
	
	$t->assign(array(
		'ADDFORM_ACTION' => cot_url('admin', 'm=cwsender&n=lists&a=add'),
		'ADDFORM_TITLE' => cot_inputbox('text', 'rtitle', $rlist['list_title'], array('size' => '64', 'maxlength' => '255')),
		'ADDFORM_RECIPIENTS' => cot_build_groupsms(0, true),
	));
	
	cot_display_messages($t, 'MAIN.LISTS.ADDFORM');
	
	$t->parse('MAIN.LISTS.ADDFORM');
	$t->parse('MAIN.LISTS');
	
	
}

if($n == 'subsusers'){

	$subsid = cot_import('subsid', 'G', 'INT');

	$sql = $db->query("SELECT * FROM $db_cwsender_lists_recipients WHERE rec_listid={$subsid}")->fetchAll();
	foreach ($sql as $user) {
		$t->assign(array(
			'USERS_ROW_ID' => $user['rec_id'],
			'USERS_ROW_NAME' => $user['rec_name'],
			'USERS_ROW_EMAIL' => $user['rec_email']
		));
		$t->parse('MAIN.SUBSUSERS.USERS_ROW');
	}
	$t->assign(array(
		'SUBSUSERS_TITLE' => $db->query("SELECT list_title FROM {$db_cwsender_lists} WHERE list_id={$subsid}")->fetchColumn(),
	));
	$t->parse('MAIN.SUBSUSERS');
}

if($n == 'letters')
{
	$order = cot_import('order', 'G', 'TXT');

	if($a == 'add')
	{
		$rletter['title'] = cot_import('rtitle', 'P', 'TXT');
		$rletter['text'] = cot_import('rtext', 'P', 'HTM');
		$rletter['listid'] = cot_import('rlistid', 'P', 'INT');

		cot_check(empty($rletter['title']), $L['cwsender_error_letter_title_empty'], 'rtitle');
		cot_check(empty($rletter['text']), $L['cwsender_error_letter_text_empty'], 'rtext');
		cot_check(empty($rletter['listid']), $L['cwsender_error_letter_list_notselect'], 'rlistid');

		if(!cot_error_found())
		{	

			$options['title'] = $rletter['title'];
			$options['text'] = $rletter['text'];
			$options['listid'] = $rletter['listid'];
			$options['type'] = 'html';
			$options['status'] = 'new';

			cwsender_create_letter('cwsender', '', $options);

		}
		cot_redirect(cot_url('admin', 'm=cwsender&n=letters', '' ,true));
	}

	if($a == 'send' && !empty($id))
	{
		$letter = cwsender_getletterinfobyid($id);
		if(!empty($letter['listid']))
		{
			if($list = $db->query("SELECT * FROM $db_cwsender_lists WHERE list_id=" . $letter['listid'])->fetch())
			{
				switch($list['list_type'])
				{
					case 'text':
						$recipients = $db->query("SELECT rec_name, rec_email FROM $db_cwsender_lists_recipients WHERE rec_listid=" . $list['list_id'])->fetchAll();
						foreach ($recipients as $recipient)
						{
							$options['recipients'][] = array($recipient['rec_name'], $recipient['rec_email']);
						}
					break;

					case 'groups':
						$groups = explode(',', $list['list_setting']);
						$recipients = $db->query("SELECT user_name, user_email FROM $db_users AS u 
							LEFT JOIN $db_groups_users as m ON m.gru_userid=u.user_id 
							WHERE m.gru_groupid IN (".implode(',', $groups).") AND u.user_sendmail=1")->fetchAll();
						foreach ($recipients as $recipient)
						{
							$options['recipients'][] = array($recipient['user_name'], $recipient['user_email']);
						}
					break;

					case 'mysql':
						$recipients = $db->query($list['list_setting'])->fetchAll();
						foreach ($recipients as $recipient)
						{
							$options['recipients'][] = array($recipient['name'], $recipient['email']);
						}
					break;
				
					case 'subs':
						$recipients = $db->query("SELECT rec_name, rec_email FROM $db_cwsender_lists_recipients WHERE rec_listid=" . $list['list_id'])->fetchAll();
						foreach ($recipients as $recipient)
						{
							$options['recipients'][] = array($recipient['rec_name'], $recipient['rec_email']);
						}
					break;
				}
			}
		}
		
		if(!empty($options['recipients']))
		{
			$options['status'] = 'process';
			$options['begin'] = $sys['now'];

			cwsender_update_letter($id, $options);
		}
		
		cot_redirect(cot_url('admin', 'm=cwsender&n=letters', '' ,true));
	}

	if($a == 'delete' && !empty($id))
	{
		cwsender_delete_letter($id);

		cot_redirect(cot_url('admin', 'm=cwsender&n=letters', '' ,true));
	}

	switch ($order) {
		case 'asc':
			$ordersql = " ORDER BY letter_date ASC";
			$order = 'desc';
			break;
		case 'desc':
			$ordersql = " ORDER BY letter_date DESC";
			$order = 'asc';
			break;
		default:
			$ordersql = " ORDER BY letter_date ASC";
			$order = 'desc';
			break;
	}

	$sql = $db->query("SELECT * FROM $db_cwsender_letters AS letters 
		LEFT JOIN $db_cwsender_lists AS lists ON lists.list_id=letters.letter_listid 
		WHERE 1 ".$ordersql);
	while($letter = $sql->fetch())
	{	
		$t->assign(array(
			'LETTER_ROW_ID' => $letter['letter_id'],
			'LETTER_ROW_DATE' => $letter['letter_date'],
			'LETTER_ROW_BEGIN' => $letter['letter_begin'],
			'LETTER_ROW_TITLE' => $letter['letter_title'],
			'LETTER_ROW_TEXT' => $letter['letter_text'],
			'LETTER_ROW_LIST' => $letter['list_title'],
			'LETTER_ROW_STATUS' => $letter['letter_status'],
			'LETTER_ROW_DELETE_URL' => cot_url('admin', 'm=cwsender&n=letters&a=delete&id=' . $letter['letter_id']),
			'LETTER_ROW_EDIT_URL' => cot_url('admin', 'm=cwsender&n=letters&a=edit&id=' . $letter['letter_id']),
			'LETTER_ROW_SEND_URL' => cot_url('admin', 'm=cwsender&n=letters&a=send&id=' . $letter['letter_id']),
		));
		$t->parse('MAIN.LETTERS.LETTER_ROW');
	}

	$lists = $db->query("SELECT * FROM $db_cwsender_lists WHERE 1")->fetchAll();
	foreach ($lists as $list)
	{
		$lists_values[] = $list['list_id'];
		$lists_titles[] = $list['list_title'];
	}
	
	$t->assign(array(
		'ADDFORM_ACTION' => cot_url('admin', 'm=cwsender&n=letters&a=add'),
		'ADDFORM_TITLE' => $rletter['letter_title'],
		'ADDFORM_RECIPIENTS' => cot_selectbox('', 'rlistid', $lists_values, $lists_titles),
	));

	$t->parse('MAIN.LETTERS.ADDFORM');
	$t->assign(array(
		'LETTERS_ORDER' => cot_rc_link(cot_url('admin', 'm=cwsender&n=letters&order='.$order),($order == 'asc') ? $L['Ascending'] : $L['Descending'],"class='btn btn-default'"),
	));
	$t->parse('MAIN.LETTERS');
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
