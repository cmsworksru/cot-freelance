<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.main
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

if ($id && $id != $usr['id']) {
	// echo $urr['id'];
	$db->query("UPDATE $db_users SET user_detailcounts= user_detailcounts + 1 WHERE user_id= $id");
}