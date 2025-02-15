<?php
/**
 * JavaScript and CSS loader for bootlance theme
 *
 * @package Cotonti
 * @version 0.9.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

Resources::addFile(Cot::$cfg['themes_dir'] . '/' . Cot::$usr['theme'] . '/bootstrap/css/bootstrap.min.css');
Resources::addFile(Cot::$cfg['themes_dir'] . '/' . Cot::$usr['theme'] . '/bootstrap/css/bootstrap-responsive.css');

Resources::addFile(Cot::$cfg['themes_dir'] . '/' . Cot::$usr['theme'] . '/css/modalbox.css');
Resources::addFile(Cot::$cfg['themes_dir'] . '/' . Cot::$usr['theme'] . '/css/style.css');

Resources::addFile(Cot::$cfg['themes_dir'] . '/' . Cot::$usr['theme'] . '/js/js.js');

require_once Cot::$cfg['themes_dir'] . '/' . Cot::$usr['theme'] . '/' . Cot::$usr['theme'] . '.resources.php';
