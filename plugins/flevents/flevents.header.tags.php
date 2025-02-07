<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.user.tags
[END_COT_EXT]
==================== */

/**
 * Events for freelance
 * @package flevents
 * @author Cotonti team
 * @copyright (c) Cotonti team
 *
 * @var XTemplate $t
 */

defined('COT_CODE') or die('Wrong URL');

$event = flevents_show('header', Cot::$cfg['plugin']['flevents']['header_count']);
//echo '<pre>';
//var_dump($event);
//echo '</pre>';
$t->assign("EVENTS_HEADER", $event);