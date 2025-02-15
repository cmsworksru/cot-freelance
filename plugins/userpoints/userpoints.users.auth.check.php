<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
 * [END_COT_EXT]
 */

/**
 * UserPoints plugin
 *
 * @package userpoints
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru, Cotonti team
 *
 * @var array $row User data
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('userpoints', 'plug');

$lastlog = Cot::$db->query(
    'SELECT item_date FROM ' . Cot::$db->userpoints
	. " WHERE item_userid = :userId AND item_type = 'auth' ORDER BY item_date DESC LIMIT 1",
    ['userId' => $row['user_id']]
)->fetchColumn();

if ($lastlog + 86400 < Cot::$sys['now']) {
	cot_setuserpoints(Cot::$cfg['plugin']['userpoints']['auth'], 'auth', $row['user_id']);
    Cot::$db->update(Cot::$db->users, array('user_userpointsauth' => Cot::$sys['now']), 'user_id = ' . $row['user_id']);
}