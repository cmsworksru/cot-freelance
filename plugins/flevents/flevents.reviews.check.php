<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
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

if ($id == $usr['id']) {
	$db->query("UPDATE $db_flevents SET ev_status='0' WHERE ev_area='reviews' AND ev_touid='".$id."' AND ev_status='1'");
}