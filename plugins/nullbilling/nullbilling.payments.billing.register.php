<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=payments.billing.register
[END_COT_EXT]
==================== */

declare(strict_types=1);

/**
 * Null billing Plugin
 *
 * @package nullbilling
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, 2024 Alexey Kalnov, Lily Software https://lily-software.com
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('nullbilling', 'plug');

$cot_billings['null'] = [
	'plug' => 'nullbilling',
	'title' => Cot::$L['nullbilling_title'],
	'icon' => Cot::$cfg['plugins_dir'] . '/nullbilling/images/nullbill.png',
];