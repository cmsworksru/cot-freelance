<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=users.auth.check.done
 * Order=11
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * @var array $row User data
 */

$referal = $row;
if ($referal['user_logcount'] <= 1 && $referal['user_referal'] > 0) {
	$partner = Cot::$db->query(
        'SELECT * FROM ' . Cot::$db->users . ' WHERE user_id = ' . $referal['user_referal']
    )->fetch();

	// Сообщаем партнеру о новом реферале
	cot_mail(
        $partner['user_email'],
        Cot::$L['affiliate_mail_newreferal_subject'],
        sprintf(Cot::$L['affiliate_mail_newreferal_body'], $partner['user_name'], $referal['user_name'])
    );

	// Начисляем баллы в рейтинг за нового реферала
	if (cot_plugin_active('userpoints') && Cot::$cfg['plugin']['affiliate']['refpoints'] > 0) {
		cot_setuserpoints(
            Cot::$cfg['plugin']['affiliate']['refpoints'],
            'affiliate',
            $referal['user_referal'],
            $row['user_id']
        );
	}	

	// Начисляем на счет партнера вознаграждение за нового реферала
	if(Cot::$cfg['plugin']['affiliate']['refpay'] > 0) {
		$payinfo['pay_userid'] = $partner['user_id'];
		$payinfo['pay_area'] = 'balance';
		$payinfo['pay_code'] = 'affiliate:' . $row['user_id'];
		$payinfo['pay_summ'] = Cot::$cfg['plugin']['affiliate']['refpay'];
		$payinfo['pay_cdate'] = Cot::$sys['now'];
		$payinfo['pay_pdate'] = Cot::$sys['now'];
		$payinfo['pay_adate'] = Cot::$sys['now'];
		$payinfo['pay_status'] = 'done';
		$payinfo['pay_desc'] = Cot::$L['affiliate_refpay_desc'];

		if (Cot::$db->insert(Cot::$db->payments, $payinfo)) {
			cot_mail(
                $partner['user_email'],
                Cot::$L['affiliate_refpay_mail_subject'],
                sprintf(Cot::$L['affiliate_refpay_mail_body'], $partner['user_name'])
            );
			cot_log("Payment for referal");
		}
	}
}	