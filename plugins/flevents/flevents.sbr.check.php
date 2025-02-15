<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.main
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

$db->query("UPDATE $db_flevents SET ev_status='0' WHERE ev_area='sbr' AND ev_touid='".$usr['id']."' AND ev_code='".$id."' AND ev_status='1'");