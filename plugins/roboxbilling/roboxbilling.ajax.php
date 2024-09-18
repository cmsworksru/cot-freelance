<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */

/**
 * Robox billing Plugin
 *
 * @package roboxbilling
 * @version 1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

use cot\modules\payments\inc\PaymentDictionary;
use cot\modules\payments\inc\PaymentService;

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

// регистрационная информация (пароль #2)
$mrh_pass2 = Cot::$cfg['plugin']['roboxbilling']['mrh_pass2'];

// чтение параметров
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];

$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item"));

// проверка корректности подписи
if ($my_crc != $crc) {
	echo "bad sign\n";
	exit();
}

// Обновляем статус платежа на "оплачен"
if (PaymentService::setStatus($inv_id, PaymentDictionary::STATUS_PAID, 'robox')) {
    echo "OK$inv_id\n";
} else {
    echo "Error of update order status!";
}
