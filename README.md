## Автоматизированная система контроля уровня знаний (АСКУЗ)
***
### Используемые технологии и компоненты
#### - Система тестирования: WEB-сервер Apache, базы данных (MySQL для Windows, MariaDB для Linux), PHP, JavaScript;
#### - Система управления и анализа:
##### 1) PHP:
- PHP-библиотека FastJSON JSON-кодировщика/декодировщика	[http://pear.php.net/pepr/pepr-proposal-show.php?id=198]
Copyright (c) 2006 - 2007 Andrea Giammarchi
##### 2) JavaScript
 - библиотека JQuery (Ajax-запросы),
 - D3.js
### * апв
***
Скрипт получает сведения о текущей погоде для выбранного города или местоположения, сохраняет в файл как объект JSON для дальнейшего использования и выводит необходимую информацию в окно консоли. Те же действия осуществляются при вызове API "One Call" с полной информацией и прогнозом. 
### Доступные URL API для текущей погоды (Current weather API):
1. По городу:
* 'api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}'
* 'api.openweathermap.org/data/2.5/weather?q={city name},{state code}&appid={API key}'
* 'api.openweathermap.org/data/2.5/weather?q={city name},{state code},{country code}&appid={API key}'
* 'api.openweathermap.org/data/2.5/weather?id={city id}&appid={API key}'
2. По географическим координатам:
* 'api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={API key}'
3. По zip-коду:
* 'api.openweathermap.org/data/2.5/weather?zip={zip code},{country code}&appid={API key}'
4. Для нескольких городов в прямоугольной области координат:
* 'api.openweathermap.org/data/2.5/box/city?bbox={bbox}&appid={API key}'
5. Для нескольких городов в окружности:
* 'api.openweathermap.org/data/2.5/box/city?bbox={bbox}&appid={API key}'
6. Для нескольких городов по ID:
* 'api.openweathermap.org/data/2.5/group?id={id,..,id}&appid={API key}'

## Весь прогноз погоды одним вызовом (One Call API).
Доступно:
* текущая погода;
* минутный прогноз на 1 час;
* почасовой прогноз на 48 часов;
* ежедневный прогноз погоды на 7 дней;
* глобальные погодные оповещения;
* исторические данные о погоде за предыдущие 5 дней.

### Пример URL API:
'api.openweathermap.org/data/2.5/onecall?lat={lat}&lon={lon}&exclude={part}&lang={language}&units={units}&appid={API key}'

# Пример работы в консоли IPython:
![Пример работы](/jpg/openweather.png)
