<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
 * [END_COT_EXT]
 */

/**
 * plugin User Group Selector for Cotonti Siena
 * 
 * @package usergroupselector
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 *
 * @var array $row User data
 */
defined('COT_CODE') or die('Wrong URL.');

if (!empty($cfg['plugin']['usergroupselector']['groups'])) {
	$groupstoselect = explode(',', $cfg['plugin']['usergroupselector']['groups']);

	if (
        $row['user_usergroup'] != $row['user_maingrp']
		&& !empty($row['user_usergroup'])
		&& $row['user_usergroup'] != COT_GROUP_SUPERADMINS
		&& $row['user_usergroup'] != COT_GROUP_MODERATORS
		&& in_array($row['user_usergroup'], $groupstoselect)
		&& $row['user_maingrp'] != COT_GROUP_SUPERADMINS
		&& $row['user_maingrp'] != COT_GROUP_MODERATORS
    ) {
		Cot::$db->update(Cot::$db->users, ['user_maingrp' => $row['user_usergroup']], 'user_id = ' . $row['user_id']);
        Cot::$db->update(
            Cot::$db->groups_users,
            ['gru_groupid' => $row['user_usergroup']],
            "gru_userid = {$row['user_id']} AND gru_groupid = {$row['user_maingrp']}"
        );
	}	
}