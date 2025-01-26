<?php
/**
 * [BEGIN_COT_EXT]
 * Code=support
 * Name=Support
 * Category=
 * Description=Техническая поддержка пользователей на основе тикетов
 * Version=2.0.5
 * Date=2025-01-26
 * Author=CMSWorks Team, Cotonti team
 * Copyright=Copyright (c) CMSWorks.ru, Cotonti team
 * Notes=
 * Auth_guests=R
 * Lock_guests=12345A
 * Auth_members=RW
 * Lock_members=12345
 * Requires_modules=users
 * Requires_plugins=
 * Recommends_plugins=notify
 * [END_COT_EXT]
 * 
 * [BEGIN_COT_EXT_CONFIG]
 * markup=01:radio::1:
 * parser=02:callback:cot_get_parsers():html:
 * email=03:string:::E-mail для уведомлений о новых обращениях
 * waitanswer=04:radio::1:Запретить новые сообщения в обращении пока не получен ответ от администрации
 * onlyoneticket=05:radio::0:Запретить создание новых обращений пока есть незакрытое обращение
 * [END_COT_EXT_CONFIG]
 */
