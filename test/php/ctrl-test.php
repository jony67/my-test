<?php
require_once("../sec_mod/security_mod.php");
require_once '../class/FastJSON.class.php';
require_once '../class/ClassItogiCtrl.php';
// Соединяемся с базой данных `test`
try{
  $mysqli = new mysqli($hostname,$username,$password,$databasename);
  if ($mysqli->connect_error) {
    die('Ошибка подключения к БД (' .$mysqli->errno.')'.$mysqli->error);
  }
  $mysqli->set_charset("utf8");   
     }
catch(Exception $e)
{
  echo $e;
  exit();
}
//Запрос на обновление в таблице БД ("UPDATE")
function setUpdate($link,$sql){
  if($sql<>''){
    $rs=mysqli_query($link,$sql) or die("SQL-запрос не выполнен!");
	  }
  else {
    echo "Введите строку запроса!";
	}	
  }  
//////////////////////////////////////////
// Выбор действия
switch ($_REQUEST['my_type']) {
//////////////////////////////////////////
// Списки учебных групп
    case 'group':
        $number_groups=$_POST['my_data'];
if (isset($number_groups))
{
	if($number_groups=='update'){
?><h3 class="demoHeaders"><label for="tableSQL">Учебные группы:</label></h3>
   <select name="number_groups" id="id_selectmenu" >
   <option selected="selected" disabled="disabled">Выберите группу</option>
   <?php 
// Получаем список учебных групп	
	$result = mysqli_query($mysqli,"SHOW TABLES FROM `test` LIKE '%_group'") or die(mysqli_error());
    while ($row = mysqli_fetch_array($result)) {
    ?>
    <option value="<?php echo $row[0]; ?>"><?php echo substr($row[0],0,-6); ?></option>
    <?php }
	 mysqli_free_result($result); 
  ?>	
  </select>
  <?php		
	}
	else{
$query_groups = "SELECT login, password FROM $number_groups ORDER BY login";
$groups = mysqli_query($mysqli,$query_groups) or die("Выберите группу!");
?>
<table border="1"  cellspacing="0">
  <tr>
    <td width="20%"><strong>№ п/п</strong></td>
    <td width="60%"><strong>Фамилия, инициалы</strong></td>
    <td width="20%"><strong>Пароль</strong></td>
  </tr>
<?php
	 $k=1;
while ($row_fkoz = mysqli_fetch_assoc($groups))
	{
?>
  <tr>
      <td><?php echo $k."."; ?></td>
      <td><?php echo $row_fkoz['login']; ?></td>
      <td><?php echo $row_fkoz['password']; ?></td>
<?php
++$k;
	}
?>
  </tr>
</table>
<?php 
    mysqli_free_result($groups);
  }
}         
        break;
// Конец Списки учебных групп
//////////////////////////////////////////
// Доступные тесты
    case 'test':   
 if(isset($_POST['my_data']))
{
$query_test = "SELECT no, desk, vid FROM reg ORDER BY vid DESC, desk ASC";
$test = mysqli_query( $mysqli, $query_test) or die("Таблица не выбрана!");
?>
Список тестов:
<table border="1" width="80%"  cellspacing="0">
  <tr>
    <td width="40%"><strong>Наименование</strong></td>
    <td width="5%"><strong>Доступность</strong></td>
  </tr>
<?php

$k=0;
while ($row_fkoz = mysqli_fetch_assoc($test))
	{		
		?>	
  <tr>
      <td><?php echo $row_fkoz['desk']; ?></td>
      <td><?php       
//Добавление CHECKBOX в виде кнопки      
       if($row_fkoz['vid']==1) {
          print('<input type="checkbox" id="check_test_'.$k.'"  checked="checked" value="'.$row_fkoz['no'].'"><label for="check_test_'.$k.'">+Включен</label>');	  
	  	  }       
       else {
	      print('<input type="checkbox" id="check_test_'.$k.'" value="'.$row_fkoz['no'].'"><label for="check_test_'.$k.'">-Отключен</label>');	      
	      }          
?>
	  </td>           
<?php
	$k=$k+1;
	}
//Конец Добавление CHECKBOX в виде кнопки 	
?>
  </tr>
</table>
 
<?php
mysqli_free_result($test);
}                   
        break;
    case 'test_update':
//Если пришел запрос на изменение, то 
      if(isset($_POST['my_data']))
        {
 //Определяем текущее состояние теста
          $query="SELECT vid from reg WHERE no=".$_POST['my_data'];
          $r=mysqli_query($mysqli,$query) or die(mysqli_error());
          mysqli_data_seek($r,0);
          $vid = mysqli_fetch_assoc($r);  
 //Если тест был выключен, то включаем его
          if ($vid['vid']==0) {
            $query="UPDATE reg SET vid=1 WHERE no=".$_POST['my_data'];
            if (setUpdate($mysqli,$query)) {           
              echo "Тест включен!";
              mysqli_free_result($r);
			}	  	
		  }
 //Если тест был включен, то выключаем его
		  else {
            $query="UPDATE reg SET vid=0 WHERE no=".$_POST['my_data'];
            if (setUpdate($mysqli,$query)){	
			  echo "Тест отключен!";
			  mysqli_free_result($r);	
			}	  	
		  }
		
//	}
//else echo "Ресурс не определен!";
}
  else echo "Не дошло!";       
	    break;
//Отключить все тесты	    
    case 'all_test_off':
            $query="UPDATE reg SET vid=0 WHERE vid=1";
            if (!setUpdate($mysqli,$query)) {
			  echo "Off";			  
			}       	    
	    break;	    
// Конец Доступные тесты
//////////////////////////////////////////            
// Таблица сессий
    case 'session':
        $query_sessions = "SELECT * FROM `sessions` ORDER BY `login` ASC";
        $sessions = mysqli_query($mysqli, $query_sessions) or die(mysqli_error());
//Если нажата кнопка, то очищаем таблицу сессий

        if (isset($_POST['my_data'])){
			mysqli_query($mysqli,"DELETE FROM `sessions`") or die ("Таблица не очищена!");
			$query_sessions = "SELECT * FROM `sessions` ORDER BY `login` ASC";
    		$sessions = mysqli_query($mysqli, $query_sessions) or die(mysqli_error()); 	
		  }
?>
<p>
Таблица пользователей, проходящих тест:
<table border="1"  cellspacing="0">
  <tr>
    <td width="30%">Имя пользователя</td>
    <td width="20%">IP-адрес</td>
  </tr>
<?php
	 
	 while ($row_fkoz = mysqli_fetch_assoc($sessions))
	{
?>
  <tr>
      <td><?php echo $row_fkoz['login']; ?></td>
      <td><?php echo $row_fkoz['ip_address']; ?></td>
<?php
	};
?>
  </tr>
</table>
<?php
        mysqli_free_result($sessions); 
        break;
// Конец Таблица сессий
//////////////////////////////////////////            
// Результаты сдачи тестов
//////////////////////////////////////////            
// Получить список тестов
    case 'test_json':
if(isset($_POST['my_data']))
  {
    $query_json_test = "SELECT tbl, desk FROM reg ORDER BY desk ASC";
    $json_test = mysqli_query($mysqli, $query_json_test) or die("Таблица не выбрана!");
    while ($row_test = mysqli_fetch_assoc($json_test)){
      $json_get_test[]=$row_test;
      };
// Посылаем заголовок браузеру 
    header('Content-Type: application/json; charset=utf-8');
// Преобразуем ассоциативный масив в JSON
    echo json_encode($json_get_test);
    mysqli_free_result($json_test);
  }
else echo "Не дошло!"; 
// Результаты сдачи тестов учебной группой
//////////////////////////////////////////
      break;
    case 'get_result':
      $table_id=$_POST['table_id']."_a";      
      $group=$_POST['group_id'];
      $query_fkoz = "SELECT * FROM $table_id WHERE `group` = '$group' ORDER BY `login` ASC";
      $name_group=$group."_group";
      $query_n = "SELECT COUNT(*) FROM $table_id WHERE `group` = '$group'";
      $n_fkoz= mysqli_query($mysqli,$query_n) or die(mysqli_error());
      if (!$n_fkoz) echo "Результаты тестирования отсутствуют в таблице!";
      else {
	  	 $fkoz = mysqli_query($mysqli,$query_fkoz) or die(mysqli_error());	               
// Получаем ассоциативный массив
      while ($row_fkoz = mysqli_fetch_assoc($fkoz)){
            $encoded['table'][]=$row_fkoz;
            $m[]=$row_fkoz['mark'];            
      	};
// Добавляем статистику
      $stat = new ClassItogiCtrl($m);
 //     echo(print_r($m));
      $mark['m_all']=$stat->getAll();
      $mark['m_sr']=$stat->getSrZnach();
      $mark['m_max']=$stat->getMax();
      $mark['m_min']=$stat->getMin();
      $mark['m_5']=$stat->getFive();
      $mark['m_4']=$stat->getFor();
      $mark['m_3']=$stat->getThree();
      $mark['m_2']=$stat->getToo();
// Посылаем заголовок браузеру 
      header('Content-Type: application/json; charset=utf-8');
// Преобразуем ассоциативный масив в JSON
      $encoded['stat'][]=$mark;
      echo json_encode($encoded);
      //mysqli_free_result($fkoz);
      }//КОНЕЦ ELSE
      break;
// Меню Группа
//////////////////////////////////////////   
    case 'group_json':
if(isset($_POST['my_data']))
  {      
    $j_table_id=$_POST['my_data'];
    $query_group = "SELECT `group` FROM ".$j_table_id." GROUP BY `group` ASC";
    $group_res = mysqli_query($mysqli,$query_group) or die(mysqli_error());
//    $n = mysqli_num_rows($group_res);
//      if (!$n) echo "Результаты тестирования отсутствуют в таблице!";
      //else echo '{"name":"Есть результат"}';             
// Получаем ассоциативный массив
    while ($row_group = mysqli_fetch_assoc($group_res)){
      $json_get_group[]=$row_group;
      };
// Посылаем заголовок браузеру 
      header('Content-Type: application/json; charset=utf-8');
// Преобразуем ассоциативный масив в JSON
      echo json_encode($json_get_group);
      mysqli_free_result($group_res);
  }
else echo "Не дошло!";
      break;
// Конец Меню Группа
//////////////////////////////////////////
// Кнопка сохранить в файл
    case 'save_to_file':
      $table_id=$_GET['table_id']."_a";      
      $group=$_GET['group_id'];
      $query_fkoz = "SELECT * FROM $table_id WHERE `group` = '$group' ORDER BY `login` ASC";
      $name_group=$group."_group";
      $query_n = "SELECT `login` FROM $name_group";
      $fkoz = mysqli_query($mysqli,$query_fkoz) or die(mysqli_error());            
// Посылаем заголовок браузеру      
      header("Content-Type: text/csv;");
      header("Content-Disposition: attachment; filename=".$group."_".$table_id.".csv");
      header("Pragma: no-cache");
      header("Expires: 0");
// Заголовок
      $content = 'Учебная группа №'.$group."\r\n";
      $content .="№ п/п".";"."Ф.И.О.".";"."Оценка"."\r\n"; 
      $count=1;
// Результат 
      while ($row_fkoz = mysqli_fetch_assoc($fkoz)){
        $arr=array();
        $arr[]=array($count,$row_fkoz['login'],str_ireplace(".",",",$row_fkoz['mark']));
        $count+=1;     
      foreach($arr as $value) 
        { 
          $content .= implode(';', $value);
          $content .= "\r\n"; 
          } 
       	};          
      echo $content;
      mysqli_free_result($fkoz);          
      break;
// Кнопка сохранить в файл             
// Конец Результаты сдачи тестов
////////////////////////////////////////// /              
}
?>