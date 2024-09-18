<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Payments module
 *
 * @package payments
 * @author CMSWorks Team, Kalnov Alexey
 * @copyright (c) CMSWorks.ru, Kalnov Alexey https://lily-software.com
 * @license BSD
 */

use cot\modules\payments\inc\PaymentDictionary;

defined('COT_CODE') or die('Wrong URL.');

if (
    (
        Cot::$env['ext'] === 'admin'
        && isset($m)
        && $m === 'extensions'
        && isset($a)
        && $a === 'details'
    )
    || Cot::$env['ext'] === 'install'
) {
    return;
}

require_once cot_incfile('payments', 'module');

$cot_billings = [];

/* === Hook === */
foreach (cot_getextplugins('payments.billing.register') as $pl) {
	include $pl;
}
/* ===== */

if (Cot::$cfg['payments']['clearpaymentsdays'] > 0) {
	$clearpaymentsdate = Cot::$sys['now'] - Cot::$cfg['payments']['clearpaymentsdays'] * 24 * 60 * 60;
    Cot::$db->delete(
        Cot::$db->payments,
        "pay_status <> '" . PaymentDictionary::STATUS_DONE . "'"
        . " AND pay_status <> '" . PaymentDictionary::STATUS_PAID . "'"
        . " AND pay_cdate < " . $clearpaymentsdate
    );
}