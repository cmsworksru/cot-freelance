<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.post.add.done
 * [END_COT_EXT]
**/

/**
 * Events for freelance
 *
 * @package flevents
 * @version 1.0
 * @author CoTEMPLATE
 * @copyright Copyright (c) CoTEMPLATE.com
 */

defined('COT_CODE') or die('Wrong URL');

global $usr;

if($text == $L['sbr_posts_performer_new']){
	$ev_data['ev_area'] = 'sbr';
	$ev_data['ev_type'] = 'new';
	$ev_data['ev_code'] = $id;
	$ev_data['ev_date'] = (int)$sys['now'];
	$ev_data['ev_touid'] = (int)$to;
	$ev_data['ev_fromuid'] = (int)$usr['id'];
	$ev_data['ev_status'] = '1';
} elseif($text == $L['sbr_posts_performer_edited']) {
	$ev_data['ev_area'] = 'sbr';
	$ev_data['ev_type'] = 'edit';
	$ev_data['ev_code'] = $id;
	$ev_data['ev_date'] = (int)$sys['now'];
	$ev_data['ev_touid'] = (int)$to;
	$ev_data['ev_fromuid'] = (int)$usr['id'];
	$ev_data['ev_status'] = '1';
} elseif($text == $L['sbr_posts_performer_cancel']) {
	$ev_data['ev_area'] = 'sbr';
	$ev_data['ev_type'] = 'emp_cancel';
	$ev_data['ev_code'] = $id;
	$ev_data['ev_date'] = (int)$sys['now'];
	$ev_data['ev_touid'] = (int)$to;
	$ev_data['ev_fromuid'] = (int)$usr['id'];
	$ev_data['ev_status'] = '1';
} else {
	return false;
}

insert_not($ev_data);