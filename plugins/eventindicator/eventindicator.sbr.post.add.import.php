<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=sbr.post.add.import
 * [END_COT_EXT]
**/

/**
 * Events for freelance
 *
 * @package flevents
 * @author CoTEMPLATE
 * @copyright Copyright (c) CoTEMPLATE.com
 */

defined('COT_CODE') or die('Wrong URL');

if (!empty($rposttext) || !empty($_FILES)) {
    require_once cot_incfile('eventindicator', 'plug');

    $resiver = ($role == 'employer') ? $sbr['sbr_performer'] : $sbr['sbr_employer'];

    $indicator['item_area'] = 'sbr';
    $indicator['item_type'] = 'addpost';
    $indicator['item_code'] = $id;
    $indicator['item_date'] = (int) $sys['now'];
    $indicator['item_userid'] = (int) $resiver;
    //$indicator['item_fromuid'] = (int) $usr['id'];
    $indicator['item_status'] = '1';

    cot_eventindicator_add($indicator);
}