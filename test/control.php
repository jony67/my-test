<?php
require_once("sec_mod/security_mod.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>Страница управления тестом</title>
<link href="js/jquery-ui.css" rel="stylesheet">
	<style>
	body{
		font: 62.5% "Trebuchet MS", sans-serif;
		margin: 10px;
	}
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	select {
		width: 200px;
	}
/* Абсолютное позицирование */
   #sidebar, #mycontent, #id_selectmenu, #id_selectmenu_test, #id_selectmenu_group { position: absolute; } 
   #sidebar, #mycontent { overflow: auto; padding: 10px; }
   #sidebar { 
    width: 150px; background: #ECF5E4; border-right: 1px solid #231F20;
    top: 82px; /* Расстояние от верхнего края */ 
    bottom: 0; /* Расстояние снизу  */
   }
   #mycontent {
    top: 0px; /* Расстояние от верхнего края */
    left: 18%; /* Расстояние от левого края */ 
    bottom: 0; right: 0;
   }
   #button {
       font-size: 9pt;	
   }
   #info, #id_result_1, #id_result_2, #id_result_3,
   #id_result_4, #id_result_5, #id_result{
       font-size: 11pt;
   }
path.slice{
	stroke-width:2px;
}
polyline{
	opacity: .3;
	stroke: black;
	stroke-width: 2px;
	fill: none;
} 
svg text.percent{
	fill:white;
	text-anchor:middle;
	font-size:16px;
} 
/*Подписи "Отл." и т.д.*/
svg rectS{
	fill:#3366CD;
}
/*Подписи "Отл." и т.д.*/
svg text.legendS, text.legendSt{
	fill:#3366CD;
	text-anchor:end;
	font-size:18px;	
}
/*Подписи "Лучший результат:" и т.д.*/
svg text.legendSt{
	fill:#109619;
	text-anchor:end;
	font-size:18px;	
} 
svg text.legendD, text.legendStD {
	fill:#eb1300;
	text-anchor:end;
	font-size:18px;	
}
   </style
</head>
<body>
<!-- Интерфейс программы ////////////////////////////////////////////////////////// -->
<!-- Accordion -->
<h2 class="demoHeaders">Меню управления</h2>
<div id="accordion">
	<h3>Списки учебных групп.</h3>
	<div>Просмотр списка учебной группы и установленных паролей.</div>
	<h3>Доступные тесты.</h3>
	<div>Подключение или отключение тестов. Не забывайте отключить тест по окончании тестирования!</div>
	<h3>Очистка таблицы сессий</h3>
	<div>Механизм сессий позволяет защититься от параллельной сдачи теста на другом компьютере. При регистации в тесте в эту таблицу заносятся учетные данные пользователей и удаляются только после ПОЛНОГО прохождения теста! Если данное условие нарушено (например, браузер был закрыт до окончания тестирования), повторное тестирование НЕВОЗМОЖНО! Для этого необходимо удалить пользователя из таблицы сессий.</div>
		<h3>Просмотр файла ошибок</h3>
	<div>При параллельном входе в систему тестирования выдается предупреждение: "Вы пытаетесь зарегистрироваться под именем пользователя, который уже проходит тестирование! Имя: Петров В.В.; IP: 192.168.2.58; Выйдите из системы!" Все эти события и время возникновения заносятся в файл ошибок, что позволяет по IP-адресу вычислить компьютер, с которого уже ведется тестирование.</div>
		<h3>Результаты сдачи тестов</h3>
	<div>Просмотр результатов тестирования и итогов по имени теста и номеру группы.</div>
</div>
<!-- Конец Accordion -->
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<!-- Рабочая область -->
<div id="mycontent">
<!-- Selectmenu "Учебные группы" для области Списки учебных групп-->
	<div id="id_group">
<h3 class="demoHeaders">Учебные группы:</h3>
   <select name="number_groups" id="id_selectmenu" >
      <option value="No">Выбирите группу</option>
   </select>
    </div>
<!-- Конец Selectmenu  "Учебные группы" -->	
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<!-- Область Результаты сдачи тестов --> 	
<!-- Кнопки управления для области Результаты сдачи тестов -->
<table  cellspacing="0">
<tr>
  <td>
<div  id="select_test">
<h3 class="demoHeaders">Тесты:</h3>
   <select id="id_selectmenu_test" class="select_test">
   </select>
</div>    							
  </td>
  <td>
<div  id="select_group">
<h3 class="demoHeaders">Учебные группы:</h3>
   <select id="id_selectmenu_group">
   </select>
</div>   							
  </td>
    <td>
<div  id="check_statistic">
<h3 class="demoHeaders">Статистика:</h3>   
   <input type="checkbox" value="On" id="id_statistic"><label for="id_statistic">Включить</label>		
</div>
  </td>
    <td>
<div  id="btn_save">
<h3 class="demoHeaders">Сохранить в файл:</h3>   
</div>   						
  </td>  
</tr>
</table>  
<!-- Конец Кнопки управления для области Результаты сдачи тестов -->	
<!-- Кнопки -->
<div id="id_button_session">
<button id="button">Очистить таблицу сесий</button>	
</div>
<div id="id_button_test">
<button id="button_all">Отключить все тесты</button>	
</div>
<!-- Область вывода Списки учебных групп -->
	<div id="id_result_1">		
	</div>
<!-- Область вывода Доступные тесты -->
	<div id="id_result_2">		
	</div>
<!-- Область вывода Таблица сессий -->
	<div id="id_result_3">		
	</div>
<!-- Область вывода Файл ошибок -->
	<div id="id_result_4">
<?php 
   $s=file("./../test_logs/access.log");
   foreach ($s as $value)
   {
   echo $value;
   echo "<br>";
   }
?>			
	</div>
<!-- Область вывода Результаты сдачи тестов -->
	<div id="id_result_5">		
	</div>
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<div id="save">
</div>
<div id="chart">
<svg id="statistic" width="700" height="400"></svg>
</div>
</div>
<!-- Конец Рабочая область -->
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<!-- Библиотеки JQuery, D3 </script>-->
<?php
print '<script src="js/jquery.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/d3.min.js" charset="utf-8"></script>
<script src="js/js-control.js"></script>'
?>
</body>
</html>