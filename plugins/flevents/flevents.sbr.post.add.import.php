<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.post.add.import
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

if(!empty($rposttext) || !empty($_FILES)) {

	$resiver = ($role == 'employer') ? $sbr['sbr_performer'] : $sbr['sbr_employer'];
	
	$ev_data['ev_area'] = 'sbr';
	$ev_data['ev_type'] = 'addpost';
	$ev_data['ev_code'] = $id;
	$ev_data['ev_date'] = (int)$sys['now'];
	$ev_data['ev_touid'] = (int)$resiver;
	$ev_data['ev_fromuid'] = (int)$usr['id'];
	$ev_data['ev_status'] = '1';

	insert_not($ev_data);
}