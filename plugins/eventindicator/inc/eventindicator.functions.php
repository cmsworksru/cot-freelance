<?php

defined('COT_CODE') or die('Wrong URL');

Cot::$db->registerTable('eventindicator');

function cot_eventindicator_add($item)
{
    $item['item_status'] = 0;

    if (empty($item['item_text'])) {
        $item['item_text'] = '';
    }

    Cot::$db->insert(Cot::$db->eventindicator, $item);
}