<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

use cot\modules\payments\dictionaries\PaymentDictionary;
use cot\modules\payments\Services\PaymentService;

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprjtop', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

/**
 * @todo правильнее обновлять статус используя хук 'payments.payment.success'
 * @see \cot\modules\payments\Services\PaymentService::processSuccessPayment()
 */
if ($pays = cot_payments_getallpays('prj.top', 'paid')) {
	foreach ($pays as $pay)
	{		
		$adv = Cot::$db->query("SELECT item_top FROM $db_projects WHERE item_id=" . $pay['pay_code'])->fetch();
		$initialtime = ($adv['item_top'] > Cot::$sys['now']) ? $adv['item_top'] : Cot::$sys['now'];
		$rtopexpire = $initialtime + $pay['pay_time'];

		if (PaymentService::getInstance()->setStatus($pay['pay_id'], PaymentDictionary::STATUS_DONE)) {
			Cot::$db->update($db_projects,  array('item_top' => (int) $rtopexpire), "item_id=".(int)$pay['pay_code']);

			/* === Hook === */
			foreach (cot_getextplugins('payprjtop.done') as $pl) {
				include $pl;
			}
			/* ===== */
		}
	}
}
