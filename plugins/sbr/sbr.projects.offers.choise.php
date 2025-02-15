<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.offers.choise
[END_COT_EXT]
==================== */

/**
 * Sbr plugin
 *
 * @package sbr
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, Cotonti team
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('sbr', 'plug');
require_once cot_incfile('projects', 'module');
require_once cot_incfile('payments', 'module');

if ($offer['offer_choise'] != 'refuse') {
	$t_o->assign([
		"OFFER_ROW_SBRCREATELINK" => cot_url(
            'sbr',
            'm=add&pid=' . $id . '&uid=' . $offer['offer_userid'] . '&' . cot_xg()
        ),
	]);
}
