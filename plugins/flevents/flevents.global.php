<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

declare(strict_types=1);

use cot\plugins\flevents\inc\EventDictionary;

/**
 * Events for freelance
 *
 * @package flevents
 * @author CoTEMPLATE, Cotonti team
 * @copyright Copyright (c) CoTEMPLATE.com, 2024-2025 Cotonti team
 *
 * @todo кеширование
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('flevents', 'plug');

if (Cot::$usr['id'] < 1 || !Cot::$cfg['plugin']['flevents']['globalOn']) {
    return;
}

$query = 'SELECT ev_area, ev_type, COUNT(*) AS ' . Cot::$db->quoteC('count')
    . ' FROM cot_flevents WHERE ev_touid = :userId AND ev_status = ' . EventDictionary::STATUS_NEW
    . ' GROUP BY ev_touid, ev_area, ev_type';

$eventsData = Cot::$db->query($query, ['userId' => Cot::$usr['id']])->fetchAll();

$result = [
    'offers' => ['all' => 0],
    'marketorders' => ['all' => 0],
    'orderservices' => ['all' => 0],
    'reviews' => ['all' => 0],
    'sbr' => ['all' => 0],
];

if (empty($eventsData)) {
    Cot::$usr['flevents'] = $result;
    return;
}

foreach ($eventsData as $event) {
    if (!isset($result[$event['ev_area']])) {
        $result[$event['ev_area']] = [];
    }
    if (!isset($result[$event['ev_area']]['all'])) {
        $result[$event['ev_area']]['all'] = 0;
    }
    if (!isset($result[$event['ev_area']][$event['ev_type']])) {
        $result[$event['ev_area']][$event['ev_type']] = 0;
    }
    $result[$event['ev_area']]['all'] += $event['count'];
    $result[$event['ev_area']][$event['ev_type']] += $event['count'];
}
