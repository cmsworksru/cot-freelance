<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
**/

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('eventindicator', 'plug');

if($usr['id'] > 0)
{
 $whereindicator = "item_userid=".$usr['id']." AND item_status=0";

 $usr['eventindicator'] = array(
   'useroffers' => array(
      'all' => $db->query("SELECT COUNT(*) FROM $db_eventindicator WHERE $whereindicator AND item_area='useroffers'")->fetchColumn(),
      //Добавление комментария к предложение к проекту.
      'addpost' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='useroffers' AND item_area='addpost'")->fetchAll(PDO::FETCH_COLUMN),
      //Отказали в предложении
      'refuse' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='useroffers' AND item_area='refuse'")->fetchAll(PDO::FETCH_COLUMN),
      //Назначили исполнителем
      'setperformer' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='useroffers' AND item_area='setperformer'")->fetchAll(PDO::FETCH_COLUMN),
   ),
   'projects' => array(
      'all' => $db->query("SELECT COUNT(*) FROM $db_eventindicator WHERE $whereindicator AND item_area='projects'")->fetchColumn(),
      //Добавление предложения к проекту.
      'addoffer' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='projects' AND item_area='addoffer'")->fetchAll(PDO::FETCH_COLUMN),
      //Добавление комментария к предложение к проекту.
      'addpost' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='projects' AND item_area='addpost'")->fetchAll(PDO::FETCH_COLUMN),
   ),
   'sbr' => array(
      'all' => $db->query("SELECT COUNT(*) FROM $db_eventindicator WHERE $whereindicator AND item_area='sbr'")->fetchColumn(),
      //Подтверждена
      //'confirm' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='sbr' AND item_area='confirm'")->fetchAll(PDO::FETCH_COLUMN),
      // Оплачена
      //'paid' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='sbr' AND item_area='paid'")->fetchAll(PDO::FETCH_COLUMN),
      //Новый пост
      //'post' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='sbr' AND item_area='post'")->fetchAll(PDO::FETCH_COLUMN),
      //Отказали
      //'refuse' => $db->query("SELECT item_code FROM $db_eventindicator WHERE $whereindicator AND item_area='sbr' AND item_area='refuse'")->fetchAll(PDO::FETCH_COLUMN),
   )
 );
 $usr['eventindicator']['all'] = $usr['eventindicator']['useroffers']['all']+$usr['eventindicator']['projects']['all']+$usr['eventindicator']['sbr']['all'];
}