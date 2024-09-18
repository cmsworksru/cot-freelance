<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

use cot\modules\payments\inc\PaymentDictionary;
use cot\modules\payments\inc\PaymentService;

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paytop', 'plug');
require_once cot_incfile('payments', 'module');

/**
 * Проверяем платежки на оплату услуги TOP. Если есть то включаем услугу или продлеваем ее.
 * @todo правильнее обновлять статус используя хук 'payments.payment.success'
 * @see PaymentService::processSuccessPayment()
 */
$pt_cfg = cot_cfg_paytop();
foreach($pt_cfg as $area => $opt) {
	if ($toppays = cot_payments_getallpays('paytop.'.$area, 'paid')) {
		foreach ($toppays as $pay) {
			if (cot_payments_userservice('paytop.'.$area, $pay['pay_userid'], $pay['pay_time'])) {
				if (PaymentService::setStatus($pay['pay_id'], PaymentDictionary::STATUS_DONE)) {
					$urr = Cot::$db->query("SELECT * FROM $db_users WHERE user_id=".$pay['pay_userid'])->fetch();

					// Отправка уведомления админу
					$subject = Cot::$L['paytop_mail_admin_subject'];
					$body = sprintf(
                        Cot::$L['paytop_mail_admin_body'],
                        $urr['user_name'],
                        $opt['name'],
                        $pay['pay_id'],
                        cot_date('d.m.Y в H:i', Cot::$sys['now'])
                    );
					cot_mail(Cot::$cfg['adminemail'], $subject, $body);

					/* === Hook === */
					foreach (cot_getextplugins('paytop.done') as $pl) {
						include $pl;
					}
					/* ===== */
					
					/* === Hook === */
					foreach (cot_getextplugins('paytop.'.$area.'.done') as $pl) {
						include $pl;
					}
					/* ===== */
				}
			}
		}
	}
}

?>