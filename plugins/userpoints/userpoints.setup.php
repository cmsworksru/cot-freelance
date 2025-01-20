<?php
/**
 * [BEGIN_COT_EXT]
 * Code=userpoints
 * Name=UserPoints
 * Description=Система рейтингов пользователей
 * Version=2.1.2
 * Date=2025-01-20
 * Author=CMSWorks Team, Cotonti team
 * Copyright=Copyright (c) CMSWorks.ru, littledev.ru, Cotonti team
 * Notes=
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=12345A
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * pro=01:string::20%:За покупку PRO-аккаунта
 * top=02:string::20%:За покупку платного места на главной
 * performer=03:string::1:За выбор исполнителем по проекту
 * refuse=04:string::-1:За отказ по проекту
 * reviewplus=05:string::20:За положительные отзыв
 * reviewminus=06:string::-20:За отрицательный отзыв
 * auth=07:string::1:За посещение сайта
 * portfolioaddtocat=08:string::10:За размещение работы в портфолио
 * [END_COT_EXT_CONFIG]
 */

/**
 * UserPoints plugin
 *
 * @package userpoints
 * @author CMSWorks Team, Cotonti team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru, Cotonti team
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

