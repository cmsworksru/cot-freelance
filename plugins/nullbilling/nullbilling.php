<?php
/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=standalone
 * [END_COT_EXT]
==================== */

declare(strict_types=1);

/**
 * Null billing Plugin
 *
 * @package nullbilling
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

use cot\modules\payments\inc\PaymentDictionary;
use cot\modules\payments\inc\PaymentRepository;
use cot\modules\payments\inc\PaymentService;

defined('COT_CODE') && defined('COT_PLUG') or die('Wrong URL');

require_once cot_incfile('nullbilling', 'plug');
$m = cot_import('m', 'G', 'ALP');
$pid = cot_import('pid', 'G', 'INT');

if (empty($pid)) {
    cot_die_message(404);
}

// Получаем информацию о заказе
$payment = PaymentRepository::getById($pid);
if ($payment === null) {
    cot_die_message(404);
}

cot_block(Cot::$usr['id'] === $payment['pay_userid']);
cot_block(in_array($payment['pay_status'], PaymentDictionary::ALLOW_PAYMENT_STATUSES, true));

// Изменяем статус "в процессе оплаты"
PaymentService::setStatus($pid, PaymentDictionary::STATUS_PROCESS, 'nullbilling');

// Изменяем статус "Оплачено"
if (PaymentService::setStatus($pid, PaymentDictionary::STATUS_PAID, 'nullbilling')) {
    cot_redirect(PaymentService::getSuccessUrl($pid));
} else {
    cot_redirect(PaymentService::getFailUrl($pid));
}
