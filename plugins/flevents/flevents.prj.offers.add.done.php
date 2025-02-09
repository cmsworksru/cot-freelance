<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=projects.offers.add.done
[END_COT_EXT]
==================== */

/**
 * Events for freelance
 *
 * @package flevents
 * @author CoTEMPLATE, Cotonti team
 * @copyright Copyright (c) CoTEMPLATE.com, 2024-2025 Cotonti team
 */

use cot\plugins\flevents\inc\EventDictionary;

defined('COT_CODE') or die('Wrong URL');

$ev_data['ev_area'] = 'offers';
$ev_data['ev_type'] = 'addoffer';
$ev_data['ev_code'] = $item['item_id'];
$ev_data['ev_date'] = Cot::$sys['now'];
$ev_data['ev_touid'] = (int) $item['user_id'];
$ev_data['ev_fromuid'] = Cot::$usr['id'];
$ev_data['ev_status'] = EventDictionary::STATUS_NEW;

insert_not($ev_data);