<?php

/** 
 * [BEGIN_COT_EXT]
 * Hooks=input
 * [END_COT_EXT]
 */
 
/**
 * Robox billing Plugin
 *
 * @package roboxbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

if(
    (
        (isset($_GET['e']) && $_GET['e'] == 'roboxbilling')
        || (isset($_GET['r']) && $_GET['r'] == 'roboxbilling')
    )
    && $_SERVER['REQUEST_METHOD'] == 'POST'
    && Cot::$cfg['plugin']['roboxbilling']['enablepost']
) {
	define('COT_NO_ANTIXSS', 1) ;
	$cfg['referercheck'] = false;
}
