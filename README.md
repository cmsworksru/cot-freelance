## Фриланс-биржа на Cotonti Siena ##

Версия сборки: 2.7.1

Copyright 2012 - 2016 CMSWorks Team

Сайт по сборке: https://Cotonti.CMSWorks.ru

### Подготовка к установке ###

Это не готовая сборка сайта! Для установки необходима последняя версия фреймворка Cotonti Siena, которую можно скачать и установить с сайта http://cotonti.com

1. Скачиваете Cotonti Siena. Распаковываете архив в директорию будущего сайта.
2. Скачиваете данную сборку фриланс-биржи и распаковываете в ту же директорию, в которую распакован Cotonti.
3. Создайте в директории datas/ файл config.php и скопируйте в него содержимое файла datas/config-sample.php. Установите к файлу datas/config.php права на запись CHMOD 666 или CHMOD 664 (в зависимости от настроек вашего хостинга).
4. Установите права 777 на все папки и подпапки в директории datas/, в частности:

/datas/avatars
/datas/cache (и все подпаки)
/datas/defaultav
/datas/extflds
/datas/photos
/datas/thumbs
/datas/users

### Установка ###

1. Откройте ваш браузер и перейдите по ссылке: http://example.com/install.php
2. Следуйте инструкциям на экране до окончания установки.
При установке выберите инсталл-скрипт flance и укажите тему bootlance.
3. Во время установки вам будет предложено выбрать плагины и расширения при первой установке. Галочкой отмечены самые основные расширения, которые необходимы для работы биржи, но вы можете выбрать также остальные при необходимости.
4. Обязательно настройте плагин Usergroupselector, если на вашем сайте будет разделение пользователей на различные группы, например на работодателей и фрилансеров. В настройках этого плагина нужно указать какие группы будут доступны для выбора пользователям при регистрации или в профиле. Если нужно создать другую группу пользователей, то перейдите в раздел админки "Пользователи".
5. Для того чтобы можно было закреплять файлы и изображения к проектам ( а также к предложениям в магание и в портфолио), необходимо также установить плагины mavatars и mavatarslance, которые также идут в составе сборки. Инструкция по настройке плагина.
6. Изначально сайт будет пустой. Свои категории вы должны самостоятельно создать в разделе админки "Структура".

**UPD:** В версии 2.7.0 чтобы правильно работала структруа с подкатегориями нужно в файле datas/config.php установить опцию $cfg['customfuncs'] = true;    
Эта опция подключает к Cotonti дополнительную библиотеку функций, которые находятся в файле system/functions.custom.php. Если у вас уже подключен этот файл, то нужно добавить в него ваши дополнительные функции, которые были в нем прописаны.
