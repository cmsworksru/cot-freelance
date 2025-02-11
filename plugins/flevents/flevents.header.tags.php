<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.user.tags
Tags=header.tpl:{HEADER_FL_EVENTS}
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

if ($t->hasTag('HEADER_FL_EVENTS')) {
    $event = flevents_show('header', Cot::$cfg['plugin']['flevents']['header_count']);
    $t->assign('HEADER_FL_EVENTS', $event);
}