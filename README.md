# Автоматизированная система контроля уровня знаний (АСКУЗ)
## Оглавление
1. [Используемые технологии и компоненты](#Используемые-технологии-и-компоненты)
2. [Описание](#Описание)
3. [Установка](#Установка)
3. [Описание базы данных](#Описание-базы-данных)
4. [Управление системой тестирования](#Управление-системой-тестированияа)
5. [Проблемные вопросы](#Проблемные-вопросы)
6. [Состав дистрибутива](#Состав-дистрибутива)
## Используемые технологии и компоненты
### - Система тестирования: WEB-сервер Apache, базы данных (MySQL для Windows, MariaDB для Linux), PHP, JavaScript;
### - Система управления и анализа:
#### 1. PHP:
- [PHP-библиотека FastJSON JSON-кодировщика/декодировщика](http://pear.php.net/pepr/pepr-proposal-show.php?id=198)
Copyright (c) 2006 - 2007 Andrea Giammarchi
#### 2. JavaScript
 - библиотека JQuery с использованием Ajax-запросов,
 - [D3.js для построения диаграм](https://d3js.org/).
### 3. Python: для создания в БД таблицы тестов из файла Excel.
### 4. Протестировано в среде:
- Windows 7 x64 Ultimate,
- Laragon Full 4.0.16 190914,
- php-7.2.19-Win32-VC15-x64,
- Apache httpd-2.4.35-win64VC15,
- MySQL mysql-5.7.24-winx64 
____
[:arrow_up:Оглавление](#Оглавление)
____
## Описание
### Возможности системы
- сетевое тестирование в WEB-браузере для тестов, включенных преподавателем;
- тестирование только зарегистированных пользователей с помощью заданий закрытого типа с единственным выбором из 3, 4 или 5 возможных вариантов ответов;
- пользователям недоступна самостоятельная регистрация;
- повторная сдача пройденного теста невозможна, без удаления сведений о прохождении теста преподавателем;
- защита от параллельной сдачи на основе сессий и БД;
- запись ошибок (неправильный пароль, попытка параллельной сдачи) в лог-файл с возможностью просмотра через WEB-браузер;
- ограничение по времени теста с выводом в браузер оставщегося времени и количества вопросов;
- просмотр результатов тестирования и вопросов, на которые были даны неправильные ответы;
- установка уровня сложности для каждого вопроса;
- тренировочный режим тестирования с выводом всех вопросов, без записываия результатов в базу данных;
- просмотр результатов тестирования с выводом статистики для выбранного теста и выбранной группы.
### Пример работы теста:
![Пример работы](/_jpg/12.jpg)
![Пример работы](/_jpg/13.jpg)
![Пример работы](/_jpg/14.jpg)
![Пример работы](/_jpg/15.jpg)
![Пример работы](/_jpg/18.jpg)

### Пример работы системы управления:
![Пример работы](/_jpg/10.jpg)
![Пример работы](/_jpg/11.jpg)
![Пример работы](/_jpg/19.jpg)
![Пример работы](/_jpg/20.jpg)
![Пример работы](/_jpg/21.jpg)
![Пример работы](/_jpg/22.jpg)
____
[:arrow_up:Оглавление](#Оглавление)
____


## Установка
1. Скопировать папки "test" и "test_logs" на WEB-сервер и установить права NTFS:
	"только чтение" на папку "test" и "чтение и запись" на папку "test_logs"!
2. После установки MySQL установить пароль на пользователя "root" (в файле создания теста из Excel /_python/myconnect.py записан пароль "123").
	Adminer по умолчанию не подключается к MySQL без пароля, для этого добавлен плагин 
	"login-password-less", временный пароль ("mypswd") хранится в файле /test/adminer/index.php.
3. Разрешить ему работу только на localhost.
4. Выполнить скрипт создания всех баз данных вместе с хранимыми процедурами - /_sql/1.test.sql.
5. Выполнить скрипт создания пользователя, от имени которого будет осуществляться тестирование и наделение его необходимыми правами - /_sql/2.test_users.sql.
6. Выполнить скрипт создания таблицы пользователей "24_group" для управления тестом - /_sql/3.24_group.sql.

***Примечание.

В таблице представлены пользователи с паролями:
- Иванов В.Е. - 12345
- Петров Н.А. - mypass
- Сидоров В.А. - passtest
В таблицу БД "24_group" записываются md5-хеш пароли, которые можно создать на [онлайн-сервисе](https://snipp.ru/tools/md5).

	
____
[:arrow_up:Оглавление](#Оглавление)
____
## Описание базы данных

____
[:arrow_up:Оглавление](#Оглавление)
____
## Управление системой тестирования

____
[:arrow_up:Оглавление](#Оглавление)
____
## Проблемные вопросы

____
[:arrow_up:Оглавление](#Оглавление)
____
## Состав дистрибутива
