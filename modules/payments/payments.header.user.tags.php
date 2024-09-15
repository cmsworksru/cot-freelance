<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.user.tags
[END_COT_EXT]
==================== */

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Kalnov Alexey
 * @copyright (c) CMSWorks.ru, Kalnov Alexey https://lily-software.com
 * @license BSD
 *
 * @var XTemplate $t
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payments', 'module');

if (defined('COT_ADMIN') || Cot::$env['ext'] === 'admin') {
    return;
}

if (Cot::$cfg['payments']['balance_enabled']) {
	$t->assign([
		'HEADER_USER_BALANCE' => cot_payments_getuserbalance(Cot::$usr['id']),
		'HEADER_USER_BALANCE_URL' => cot_url('payments', 'm=balance'),
	]);
}
