<?php
/**
 * Cwsender API
 *
 * @package Cwsender
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('cwsender', 'module');

// Global variables
global $db_cwsender_letters, $db_cwsender_recipients, $db_x;
$db_cwsender_lists = (isset($db_cwsender_lists)) ? $db_cwsender_lists : $db_x . 'cwsender_lists';
$db_cwsender_lists_recipients = (isset($db_cwsender_lists_recipients)) ? $db_cwsender_lists_recipients : $db_x . 'cwsender_lists_recipients';
$db_cwsender_letters = (isset($db_cwsender_letters)) ? $db_cwsender_letters : $db_x . 'cwsender_letters';
$db_cwsender_letters_recipients = (isset($db_cwsender_letters_recipients)) ? $db_cwsender_letters_recipients : $db_x . 'cwsender_letters_recipients';



/**
 * 
 * @global type $sys
 * @global type $db
 * @global type $db_cwsender_letters
 * @param string $area
 * @param string $code
 * @param array $options
 * @return int
 */
function cwsender_create_letter($area, $code, $options)
{
	global $sys, $db, $db_cwsender_letters;
	
	if(is_array($options))
	{
		foreach ($options as $i => $option)
		{
			if($i != 'recipients')
			{
				$letter['letter_'.$i] = $option;
			}
		}
		
		$letter['letter_area'] = $area;
		$letter['letter_code'] = $code;
		$letter['letter_date'] = $sys['now'];
	}
	
	if(!empty($letter['letter_title']) && !empty($letter['letter_text']))
	{
		$db->insert($db_cwsender_letters, $letter);
		$letterid = $db->lastInsertId();

		if(is_array($options['recipients']))
		{
			cwsender_addrecipients($letterid, $options['recipients']);
		}
	}
	return $letterid;
}


/**
 * Изменение информации о рассылке 
 * @global type $sys
 * @global type $db
 * @global type $db_cwsender_letters
 * @global type $db_cwsender_letters_recipients
 * @param int $letterid
 * @param array $options
 */
function cwsender_update_letter($letterid, $options)
{
	global $db, $db_cwsender_letters, $db_cwsender_letters_recipients;
	
	if(is_array($options))
	{
		foreach ($options as $i => $option)
		{
			if($i != 'recipients')
			{
				$letter['letter_'.$i] = $option;
			}
		}
		$db->update($db_cwsender_letters, $letter, "letter_id=".$letterid);
	}

	if(is_array($options['recipients']))
	{
		$db->delete($db_cwsender_letters_recipients, "rec_letterid=".$letterid);
		cwsender_addrecipients($letterid, $options['recipients']);
	}
}



/**
 * Удаление рассылки 
 * @global type $sys
 * @global type $db
 * @global type $db_cwsender_letters
 * @global type $db_cwsender_letters_recipients
 * @param int $letterid
 */
function cwsender_delete_letter($letterid)
{
	global $db, $db_cwsender_letters, $db_cwsender_letters_recipients;
	
	$db->delete($db_cwsender_letters, "letter_id=" . $letterid);
	$db->delete($db_cwsender_letters_recipients, "rec_letterid=" . $letterid);
}


/**
 * Удаление списка рассылки
 * @global type $sys
 * @global type $db
 * @global type $db_cwsender_lists
 * @global type $db_cwsender_lists_recipients
 * @param int $listid
 */
function cwsender_delete_list($listid)
{
    global $db, $db_cwsender_lists, $db_cwsender_lists_recipients;
     
    $db->delete($db_cwsender_lists, "list_id=" . $listid);
    $db->delete($db_cwsender_lists_recipients, "rec_listid=" . $listid);
}



/**
 * Получение информации о рассылке $letterid
 * @global type $db
 * @global type $db_cwsender_letters
 * @param int $letterid
 * @return letter details or false
 */
function cwsender_getletterinfobyid($letterid)
{
	global $db, $db_cwsender_letters, $db_cwsender_lists;
	
	if($letter = $db->query("SELECT * FROM $db_cwsender_letters WHERE letter_id=".$letterid)->fetch())
	{
		foreach($letter as $i => $option)
		{
			$optcode = explode('_', $i);
			$options[$optcode[1]] = $option;
		}
		
		$options['list'] = $db->query("SELECT * FROM $db_cwsender_lists WHERE list_id=".$letter['letter_listid'])->fetch();
	}
	
	$options['recipients'] = cwsender_getrecipients($letterid);
			
	if(is_array($options))
	{	
		return $options;
	}
	else
	{
		return false;
	}
}

/**
 * Получение информации о рассылке по типу и коду
 * @global type $db
 * @global type $db_cwsender_letters
 * @param string $area
 * @param string $code
 * @return array or false
 */
function cwsender_getletterinfo($area, $code)
{
	global $db, $db_cwsender_letters;
	
	if($letter = $db->query("SELECT * FROM $db_cwsender_letters WHERE letter_area='".$area."' AND letter_code='".$code."'")->fetch())
	{
		foreach($letter as $i => $option)
		{
			$optcode = explode('_', $i);
			$options[$optcode[1]] = $option;
		}
	
		$options['recipients'] = cwsender_getrecipients($letter['letter_id']);

		return $options;
	}
	else
	{
		return false;
	}
}



/**
 * Добавление получателей для рассыли $letterid
 * @param int $letterid
 * @param array $recipients
 */
function cwsender_addrecipients($letterid, $recipients)
{
	global $db, $db_cwsender_letters_recipients;
	
	foreach ($recipients as $i => $recipient)
	{
		$rec['rec_letterid'] = $letterid;
		$rec['rec_name'] = $recipient[0];
		$rec['rec_email'] = $recipient[1];
		
		$db->insert($db_cwsender_letters_recipients, $rec);
	}
}


/**
 * Удаление получателей из списка рассылки $letterid
 * @global type $db
 * @global type $db_cwsender_letters_recipients
 * @param type $letterid
 * @param type $emails
 */
function cwsender_delrecipients($letterid, $emails)
{
	global $db, $db_cwsender_letters_recipients;
	
	if(is_array($emails))
	{
		foreach ($emails as $email)
		{		
			$db->delete($db_cwsender_letters_recipients, "rec_email=? AND rec_letterid=?", array($email, $letterid));
		}
	}
	else 
	{
		$db->delete($db_cwsender_letters_recipients, "rec_email=? AND rec_letterid=?", array($emails, $letterid));
	}
}



/**
 * Получение списка получателей рассылки $letterid
 * @global type $db
 * @global type $db_cwsender_letters_recipients
 * @param int $letterid
 * @return array
 */
function cwsender_getrecipients($letterid, $sent = 0)
{
	global $db, $db_cwsender_letters_recipients;
	
	$jj = 0;
	$sql = $db->query("SELECT * FROM $db_cwsender_letters_recipients WHERE rec_letterid=".$letterid." AND rec_sent=".$sent);
	while($recipient = $sql->fetch())
	{
		foreach($recipient as $i => $option)
		{
			$optcode = explode('_', $i);
			$recipients[$jj][$optcode[1]] = $option;
		}
		$jj++;
	}
	return $recipients;
}



/**
 * Вывод формы подписки
 */
function cwsender_subscribe($id)
{
	global $db, $db_cwsender_lists;
	
	if($subs = $db->query("SELECT * FROM $db_cwsender_lists WHERE list_id=".$id." AND list_type='subs'")->fetch())
	{
		$t = new XTemplate(cot_tplfile(array('cwsender', 'subscribe', $id), 'module'));
		
		$t->assign(array(
			'SUBS_ID' => $id
		));
		
		$t->parse('MAIN');
		return $t->text('MAIN');
	}
	else
	{
		return false;
	}
}