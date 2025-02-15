<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\modules\payments\Services\PaymentService;

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprjbold', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

/**
 * @todo правильнее обновлять статус используя хук 'payments.payment.success'
 * @see \cot\modules\payments\Services\PaymentService::processSuccessPayment()
 */
if ($pays = cot_payments_getallpays('prj.bold', 'paid')) {
	foreach ($pays as $pay) {
		$adv = Cot::$db->query("SELECT item_bold FROM $db_projects WHERE item_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['item_bold'] > Cot::$sys['now']) ? $adv['item_bold'] : Cot::$sys['now'];
		$rboldexpire = $initialtime + $pay['pay_time'];

		if (PaymentService::getInstance()->setStatus($pay['pay_id'], PaymentDictionary::STATUS_DONE)) {
			Cot::$db->update($db_projects,  array('item_bold' => (int)$rboldexpire), "item_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payprjbold.done') as $pl) {
				include $pl;
			}
			/* ===== */
		}
	}
}
