<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

use cot\modules\payments\inc\PaymentDictionary;
use cot\modules\payments\inc\PaymentService;

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');
require_once cot_incfile('payments', 'module');

/**
 * Проверяем платежки на оплату услуги PRO. Если есть то включаем услугу или продлеваем ее.
 * @todo правильнее обновлять статус используя хук 'payments.payment.success'
 * @see PaymentService::processSuccessPayment()
 */
if ($propays = cot_payments_getallpays('pro', 'paid')) {
	foreach ($propays as $pay) {
		$userid = (!empty($pay['pay_code'])) ? $pay['pay_code'] : $pay['pay_userid'];
		$upro = cot_getuserpro($userid);
		$initialtime = ($upro > cot::$sys['now']) ? $upro : cot::$sys['now'];
		$rproexpire = $initialtime + $pay['pay_time'];

		if (PaymentService::setStatus($pay['pay_id'], PaymentDictionary::STATUS_DONE)) {
			cot::$db->update($db_users,  array('user_pro' => (int) $rproexpire), "user_id=" . (int) $userid);

			/* === Hook === */
			foreach (cot_getextplugins('paypro.done') as $pl) {
				include $pl;
			}
			/* ===== */
		}
	}
}

?>