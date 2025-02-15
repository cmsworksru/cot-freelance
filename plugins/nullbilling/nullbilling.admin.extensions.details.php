<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.extensions.details
[END_COT_EXT]
==================== */

declare(strict_types=1);

/**
 * Null billing Plugin
 *
 * @package nullbilling
 * @author CMSWorks Team, Alexey Kalnov
 * @copyright (c) CMSWorks.ru, 2024-2025 Alexey Kalnov, Lily Software https://lily-software.com
 * @license BSD
 *
 * @var string $type
 * @var string $code
 * @var XTemplate $t
 */

use cot\extensions\ExtensionsDictionary;

defined('COT_CODE') or die('Wrong URL');

if ($type === ExtensionsDictionary::TYPE_PLUGIN && $code === 'nullbilling') {
    $standalone = null;
    $t->assign([
        'ADMIN_EXTENSIONS_JUMPTO_URL' => $standalone,
    ]);
}
