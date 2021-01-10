<?php
require 'sec_mod/connection.php';
//  Открываем  сессию  smartest
session_name("smarttest") ;
session_start();
// Соединяемся с базой данных `test`
try{
  $mysqli = new mysqli($hostname,$username,$password,$databasename);
  $_SESSION['mysqli']=$mysqli;
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
//Функция преобразования массива переменных, переданных методом POST
//в переменные сессии
function getpost_ifset($test_vars)
    {  
        if (!is_array($test_vars)) {  
            $test_vars = array($test_vars);
        }  
        foreach($test_vars as $test_var) {  
            if (isset($_POST[$test_var])) {  
                $_SESSION[$test_var] = $_POST[$test_var];  
            }
        }  
    } 


//  Функция  получает  текст  вопроса,   выводит  его  и  создает
//  средства   (Radio Group)   для
//  выбора  правильных  вариантов  ответа
// для тестов с 3-мя ответами
function  GetQuestText3()
{
$tmp=$_SESSION['Counter']+1;
?>
  <script language="JavaScript">
    parent.infoFrame.document.getElementById("info1").style.display="block"
  </script>
<?php
  echo "<meta http-equiv=Content-Type content=\"text/html; charset=windows-1251\">";
  echo "<title>Test-Info</title><head>";
  echo "</head><body  bgcolor=white>";
  echo "<center><h3>Система  дистанционного  контроля знаний Test-Info</h3></center>" ;
  echo "<br><b><font>Bonpoc  $tmp:</font></b><br>";
  echo "<h4><PRE>".$_SESSION['text']."</PRE></h4>";
  echo "<br>";
  echo "<form  action=$_SERVER[PHP_SELF] method=POST><br>";
// Варианты ответов
  echo "<table width=\"780\" border=\"1\" fontsize=14>" ;
  echo "<tr><th width=\"500\" scope=\"row\" align=\"left\">".$_SESSION['var1']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"1\">Ответ 1</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var2']."</th>";
  echo "    <td width=\"100\"><label> <input type=radio name=otv  value=\"2\">Ответ 2</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var3']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"3\">Ответ 3</label></td>";
  echo "</tr>";
  echo "</table>";
  echo  "<b1><input  type=submit  value=\"0тветить!\"</b1>";
  echo "</form></body></html>";
// Конец функции GetQuestText3()
}


//  Функция  получает  текст  вопроса,   выводит  его  и  создает
//  средства   (Radio Group)   для
//  выбора  правильных  вариантов  ответа
// для тестов с 4-мя ответами
function  GetQuestText4()
{
$tmp=$_SESSION['Counter']+1;
?>
  <script language="JavaScript">
    parent.infoFrame.document.getElementById("info1").style.display="block"
  </script>
<?php
  echo "<meta http-equiv=Content-Type content=\"text/html; charset=windows-1251\">";
  echo "<title>Test-Info</title><head>";
  echo "</head><body  bgcolor=white>";
  echo "<center><h3>Система  дистанционного  контроля знаний Test-Info</h3></center>" ;
  echo "<br><b><font>Bonpoc  $tmp:</font></b><br>";
  echo "<h4><PRE>".$_SESSION['text']."</PRE></h4>";
  echo "<br>";
  echo "<form  action=$_SERVER[PHP_SELF] method=POST><br>";
// Варианты ответов
  echo "<table width=\"780\" border=\"1\" fontsize=14>" ;
  echo "<tr><th width=\"500\" scope=\"row\" align=\"left\">".$_SESSION['var1']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"1\">Ответ 1</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var2']."</th>";
  echo "    <td width=\"100\"><label> <input type=radio name=otv  value=\"2\">Ответ 2</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var3']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"3\">Ответ 3</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var4']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"4\">Ответ 4</label></td>";
  echo "  </tr>";
  echo "</table>";
  echo  "<b1><input  type=submit  value=\"0тветить!\"</b1>";
  echo "</form></body></html>";
// Конец функции GetQuestText4()
}
// для тестов с 5-ю ответами
function  GetQuestText5()  
{
$tmp=$_SESSION['Counter']+1;
?>
  <script language="JavaScript">
  parent.infoFrame.document.getElementById("info1").style.display="block"
  </script>
<?php
  echo "<meta http-equiv=Content-Type content=\"text/html; charset=windows-1251\">";
  echo "<title>Test-Info</title><head>";
  echo "</head><body  bgcolor=white>";
  echo "<center><h3>Система  дистанционного  контроля знаний Test-Info</h3></center>" ;
  echo "<br><b><font>Bonpoc  $tmp:</font></b><br>";
  echo "<h4><PRE>".$_SESSION['text']."</PRE></h4>";
  echo "<br>";
  echo "<form  action=$_SERVER[PHP_SELF] method=POST><br>";
// Варианты ответов
  echo "<table width=\"780\" border=\"1\" fontsize=14>" ;
  echo "<tr><th width=\"500\" scope=\"row\" align=\"left\">".$_SESSION['var1']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"1\">Ответ 1</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var2']."</th>";
  echo "    <td width=\"100\"><label> <input type=radio name=otv  value=\"2\">Ответ 2</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var3']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"3\">Ответ 3</label></td>";
  echo "</tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var4']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"4\">Ответ 4</label></td>";
  echo "  </tr>";
  echo "<tr><th scope=\"row\" align=\"left\">".$_SESSION['var5']."</th>";
  echo "    <td width=\"100\"><label><input type=radio name=otv  value=\"5\">Ответ 5</label></td>";
  echo "  </tr>";
  echo "</table>";
  echo  "<b1><input  type=submit  value=\"0тветить!\"</b1>";
  echo "</form></body></html>";
// Конец функции GetQuestText5()
}
//  Функция  выводит  список  тестов  в  виде  таблицы
function  GetTestList()
{
  echo  "<center><i>Cпиcoк  доступных  тестов :</i></center><br>";
  echo  "<table  BORDER  COLS=3  WIDTH=\"100%\"  BGCOLOR=#CEFFCE>";
  echo  "<tr  ALIGN=CENTER  BGCOLOR=#3333FF>";
  echo   "<td><b><i><font  color=#FFFFFF>Hoмep</font></i></b></td>";
  echo  "<td><b><i><font  color=#FFFFFF>Haзвание</font></i></b></td>";
  echo  "<td><b><i><font  color=#FFFFFF>Aвтop</font></i></b></td>";
  $res=mysqli_query($_SESSION['mysqli'],"SELECT no,desk,autor, vid FROM reg ORDER BY no");
  while($Row=mysqli_fetch_row($res))
    {
      if($Row[3]==1)
	  {
	  echo  "<tr>";
      for($i=0;$i<mysqli_num_fields($res)-1;$i++)
			{
				echo  "<td><a href=$_SERVER[PHP_SELF]?tno=$Row[0]>$Row[$i]</a></td>";
			}
      echo  "</tr>";			
	  }
    }
  echo  "</table>";
//Конец функции GetTestList() 
}
//Фунция выводит вопросы, на которые получены неправильные ответы
function  GetNoList($n,$table)
{
  echo  "<center><i>Получены неправильные ответы на вопросы:</i></center><br>";
  echo  "<table  BORDER  COLS=3  WIDTH=\"100%\"  BGCOLOR=#CEFFCE>";
  echo  "<tr  ALIGN=CENTER  BGCOLOR=#3333FF>";
  echo   "<td><b><i><font  color=#FFFFFF>№ п/п</font></i></b></td>";
  echo  "<td><b><i><font  color=#FFFFFF>Вопрос</font></i></b></td>";
  $res=mysqli_query($_SESSION['mysqli'],"SELECT npp,vopros FROM $table WHERE npp IN ($n)");
  while($Row=mysqli_fetch_row($res))
    {
      echo  "<tr>";
      for($i=0;$i<mysqli_num_fields($res);$i++)
        echo  "<td>$Row[$i]</td>";
      echo  "</tr>";
    }
  echo  "</table>";
//Конец функции GeNotList() 
}
//  Функция  проверяет  имя  пользователя  и  его  пароль.   Если
//  они  правильны,   она
//  присваивает  глобальной  переменной  Login  значение  1
function  Register()
{
  getpost_ifset(array('user','ngr','pswd'));
  $group=$_SESSION['ngr']."_group";
  $u=$_POST['user'];
$res=mysqli_query($_SESSION['mysqli'],"SELECT  *  from  $group") or die ("Нет такой группы!");
//Проверяем, работает такой пользователь сейчас в сети
$res_1=mysqli_query($_SESSION['mysqli'],"SELECT  *  from  `sessions` WHERE `login`='$u'") or die ("Проблема...Что-то с session...");
$s=mysqli_fetch_row($res_1); 
if ($s[0]===$u) 
 {   
	   //Если есть запись в таблице о входе пользователя
	   $_SESSION['login']=2;
 }
//Если пользователь только зашел на сайт
else
{	
while   ($Row=mysqli_fetch_row($res))
 {
  if($Row[0]===$_SESSION['user'])
   {
	 //Если нет записи в таблице о входе пользователя
    if(($Row[1]===$_SESSION['ngr']) and ($Row[2]===$_SESSION['pswd']))
     {
      $_SESSION['FullName']=$Row[3];
      $_SESSION['UserName']=$_SESSION['user'];
      $_SESSION['login']=1;
	  $_SESSION['NumGroup']=$_SESSION['ngr'];
	  $u=$_SESSION['user'];
	  $ip=$_SERVER['REMOTE_ADDR'];
	  mysqli_query($_SESSION['mysqli'],"INSERT INTO  `sessions` VALUES ('$u', '$ip')") or die ("Сессия пользователя не зарегистрирована!");
	  break;
     }

   }
 }
}
if   ($_SESSION['login']==0)
  {
   //  Неправильные  имя  пользователя  и/или  пароль
   echo  "<html><head><meta  http-equiv=\"Content-Type\"
   content=\"text/html;     charset=windows-1251\">";
   echo  "<title>Test-Info  -  Доступ закрыт для пользователя</title></head><body
   bgcolor=white>";
   echo  "<center><h2>Система  дистанционного  контроля
   знаний Test-Info</h2>";
   echo  "<center><img  src=stop.gif  alt=STOPX <h3>Доступ закрыт для пользователя \"".$_POST['user']."\" группа №". $_POST['ngr']."</h3></center>";
   echo  "<p>Проверьте  имя  пользователя  и  пароль!";
   echo  "</body></html>";
   unset($Accept);
   session_unset();
   //  Нужно  обеспечить  запись  в  этот  каталог
   $Dir="./../test_logs";
   @mkdir($Dir,0755);
   $f=fopen("$Dir/access.log","a+")   or  Die("Невозможно создать файл access.log");
   flock($f,2);
   $dt=date("d.m.y  H.i.s");
   if(PHP_OS=="Linux")   $NL="\n";   else  $NL="\n\r";
   fputs($f,"$dt  Доступ запрещен для пользователя  \"".$_POST['user']."\" группа №". $_POST['ngr']." IP: ".$_SERVER['REMOTE_ADDR']."  $NL");
   flock($f,3);
   fclose($f);
   exit;
  }
elseif   ($_SESSION['login']==2)

{
   //  Повторный вход на сайт под одним именем
   echo  "<html><head><meta  http-equiv=\"Content-Type\"
   content=\"text/html;     charset=windows-1251\">";
   echo  "<title>Test-Info  -  Двойная регистрация на сайте</title></head><body
   bgcolor=white>";
   echo  "<center><h2>Система  дистанционного  контроля
   знаний Test-Info</h2>";
   echo  "<center><img  src=stop.gif  alt=STOPX ><h3><strong><font color=\"#FF0000\">Вы пытаетесь зарегистрироваться под именем пользователя, который уже проходит тестирование!</font></strong></h3></center>";
   echo  "<p><strong>Имя: ".$s[0];
   echo  "<p>IP: ".$s[1]."</strong>";
   echo  "<p>Выйдите из системы!"; 
   echo  "</body></html>";
   unset($Accept);
   session_unset();
   //  Нужно  обеспечить  запись  в  этот  каталог
   $Dir="./../test_logs";
   @mkdir($Dir,0755);
   $f=fopen("$Dir/access.log","a+")   or  Die("Невозможно создать файл access.log");
   flock($f,2);
   $dt=date("d.m.y  H.i.s");
   if(PHP_OS=="Linux")   $NL="\n";   else  $NL="\n\r";
   fputs($f,"$dt  Попытка двойного входа под именем  \"".$_POST['user']."\" с адреса IP: ".$_SERVER['REMOTE_ADDR']."  $NL");
   flock($f,3);
   fclose($f);
   exit;
  }


else
 {
  //  Все  Ок,   ВЫВОДИМ  СПИСОК  тестов
  echo  "<html><head><meta  http-equiv=\"Content-Type\"
  content=\"text/html;   charset=windows-1251\">" ;
  echo  "<title>Test-Info</title></head><body  bgcolor=white>";
  echo  "<center><h3>Система  дистанционного  контроля  знаний Test-Info</h3></center>";
  echo  "<B><I>Здравствуйте,   $Row[0] ! </B></I><BR>" ;
  GetTestList ();

 }
mysqli_free_result($res_1);
return;
//Конец функции Register()
}
//************************************************
/*      Основная программа	*/
//************************************************
if (!isSet($_SESSION['login']))
{
Register();
}
else
{
//  При  первом  запуске  устанавливаем  номер  теста  и
//  инициализируем  базу
if (!isSet($_SESSION['TestNo']))
   {
// Номер теста в таблице
  $tno=$_GET['tno'];
  $Res=mysqli_query($_SESSION['mysqli'],"SELECT no, qmax, tbl, tip, num, time, vid FROM  reg  WHERE no=$tno")
      or die ("Таблица не выбрана!");
    $Row=mysqli_fetch_row($Res);
// Регистрируем  в  сессии  служебные  переменные:
  $_SESSION['Table']=$Row[2]; //Название теста
	$_SESSION['Ntype']=$Row[3]; //Тип теста
	$_SESSION['Num']=$Row[4];   //Количество вопросов в тесте
  $Table=$_SESSION['Table'];
  $Res_Rows=mysqli_query($_SESSION['mysqli'],"SELECT * FROM  $Table")
      or die ("Таблица не выбрана!");
  $_SESSION['Max']=mysqli_num_rows($Res_Rows); //Максимальное количество вопросов

if ($_SESSION['Num']==0)      //Тест тренировочный, все вопросы, время не ограничено
{
  $_SESSION['Num']=$_SESSION['Max'];
	$_SESSION['TR']=0;
	$_SESSION['Kol_vo']=$_SESSION['Max']; //Счетчик оставшегося количества вопросов (все)
	$_SESSION['TTime']=0; //Время выполнения теста неограничено
}
else
{
	$_SESSION['TR']=1;
	$_SESSION['Kol_vo']=$_SESSION['Num']; //Счетчик оставшегося количества вопросов
	$_SESSION['TTime']=$Row[5]; //Время выполнения теста
}
	$_SESSION['TT']=0;
	$_SESSION['MaxTotal']=0;
	$_SESSION['Exp1']=0;
    $_SESSION['ATable']=$_SESSION['Table']."_a";   //  таблица  ответов
//Проверяем проходил пользователеь выбранный тест или нет
   $ATable=$_SESSION['ATable'];
    $R=mysqli_query($_SESSION['mysqli'],"SELECT  *  FROM  $ATable")  or  die ("Запрос
                    не выполнен для теста  [$ATable]");
    while($Rw=mysqli_fetch_row($R))
      {
       if($Rw[1]===$_SESSION['UserName'] and ($Rw[0]===$_SESSION['NumGroup'] )) //Если пользователь с данной фамилией уже существует
        {
         echo  "<br><font size=+2>Вы  уже  проходили  выбранный  тест<br>";
         echo  "Ваша  оценка  <b>$Rw[2]</b>.  Вы  правильно  ответили  на
                <b>$Rw[3]</b>   вопросов(а) </font>";
         $UserName=$_SESSION['UserName'];
		 mysqli_query($_SESSION['mysqli'],"DELETE FROM  `sessions` WHERE `login`='$UserName'") or die("Not delete");
		 //GetTestList ();
         exit;
        }   //  if($Rw)
      }  //While($Rw);
$_SESSION['TestNo']=$_GET['tno']; //Номер таблицы тестов
$_SESSION['Counter']=0; // Устанавливаем счетчик номера вопроса равным "0" 
//  Проверяем  все  ли  разные  элементы  в  массиве
function  checkarr($Arr, $Num)
{
  //  разные
  $Res=1;
   for ($i=0;$i<$Num;$i++)
    for ($j=$i+1;$j<$Num;$j++)
     if($Arr[$i]===$Arr[$j])
      {
       $Res=0;
       break(1);
      }
  return  $Res;
}
//Если TR=1, тест рабочий, включаем генератор случайных чисел
if ($_SESSION['TR']==1)
{

//Генерируем случайную выборку вопросов
for($i=0;$i<$_SESSION['Max'];$i++) 
	{ 
	$sel[$i] = $i+1;
}
shuffle($sel);

for($i=0;$i<$_SESSION['Max'];$i++) 
	{ 

}

for($i=0;$i<$_SESSION['Num'];$i++) $Quest[$i]=$sel[$i];
}


//TR=0, тест тренировочный, выводим все вопросы теста
else
	{
	for($i=0;$i<$_SESSION['Max'];$i++) $Quest[]=$_SESSION['Max'];
	for($i=0;$i<$_SESSION['Max'];$i++) $Quest[$i]=$i+1;
	}
//  массив  сгенерирован,   пишем  его   . ..
$_SESSION['Arr']=serialize($Quest);
$_SESSION['Q']=$Quest;
//  сейчас  нужно  выдать  первый  вопрос...
//Выбираем все поля из выбранной таблицы
$Counter=$_SESSION['Counter'];
$Table=$_SESSION['Table'];

$Res=mysqli_query($_SESSION['mysqli'],"SELECT  *  FROM  $Table  WHERE npp=$Quest[$Counter]");
$Row=mysqli_fetch_row($Res);
$_SESSION['Diff']=$Row[0]; //Сложность
$_SESSION['text']=$Row[2]; //Текст вопроса
$_SESSION['var1']=$Row[3]; //Отв 1
$_SESSION['var2']=$Row[4]; //Отв 2
$_SESSION['var3']=$Row[5]; //Отв 3
$_SESSION['var4']=$Row[6]; //Отв 4
$_SESSION['var5']=$Row[7]; //Отв 5
$_SESSION['Prav']=$Row[8]; //Правильный вариант
$_SESSION['No']=0;
$_SESSION['Yes']=0;
//Вывести вопрос
if($_SESSION['Ntype']==3) GetQuestText3();
if($_SESSION['Ntype']==4) GetQuestText4();
if($_SESSION['Ntype']==5) GetQuestText5();
$_SESSION['Counter']=$_SESSION['Counter']+1;
//Включаем таймер
?>
  <script language="JavaScript">
	parent.timeFrame.document.location.href="time.php?t=<?php echo $_SESSION['TTime'];?>+&kol_vo=+<?php echo $_SESSION['Kol_vo'];?>";
	
  </script>
<?php
}  // if(!isSet)
else  //  уже  не  первый  запуск,   $TestNo  установлена
 //  пришел  ответ  на  предыдущий  вопрос
  {
 //Количество вопросов, на которое осталось ответить
$_SESSION['Kol_vo']=$_SESSION['Kol_vo']-1;
if ($_SESSION['Kol_vo']==1) {
?>
  <script language="JavaScript">
	parent.timeFrame.document.getElementById("number").innerHTML="<em><strong>Это последний вопрос!</strong></em>"
  </script>
<?php	
}
else if ($_SESSION['Kol_vo']<1) {
?>
  <script language="JavaScript">
	parent.timeFrame.document.getElementById("number").innerHTML=""
  </script>
<?php	
}
else {
?>
  <script language="JavaScript">
	parent.timeFrame.document.getElementById("number").innerHTML="Осталось ответить на&nbsp;&nbsp;<strong>"+<?php echo $_SESSION['Kol_vo']; ?>+"</strong>&nbsp;&nbsp;вопрос(а)ов"
  </script>
<?php	

};
  if(!isSet($_POST['otv'])) $_PST['otv']="";
    $Answer1=$_POST['otv'];   
	
//Если ответ правильный
   if($Answer1===$_SESSION['Prav'])
    {
     $_SESSION['True_1']=@$_SESSION['True_1']+1;
     $_SESSION['TT']=$_SESSION['TT']+$_SESSION['Diff'];
      if(!isset($_SESSION['YesOtv'])) $_SESSION['YesOtv']=$_SESSION['Q'][$_SESSION['Counter']-1];
     else $_SESSION['YesOtv']=$_SESSION['YesOtv'].",".$_SESSION['Q'][$_SESSION['Counter']-1];
     $_SESSION['Yes']=$_SESSION['Yes']+1;    
    }
    else // Если не правильный
    {
      if(!isset($_SESSION['NoOtv'])) $_SESSION['NoOtv']=$_SESSION['Q'][$_SESSION['Counter']-1];
      else $_SESSION['NoOtv']=$_SESSION['NoOtv'].",".$_SESSION['Q'][$_SESSION['Counter']-1];
      $_SESSION['No']=$_SESSION['No']+1; 
    } 
$_SESSION['MaxTotal']=$_SESSION['MaxTotal']+$_SESSION['Diff'];
// Если вопрос последний
if($_SESSION['Counter']==$_SESSION['Num'])
  {
   //Завершаем тест
  
   $Exp1=($_SESSION['TT'])/($_SESSION['MaxTotal']);
   $Exp1=sprintf("%.2f",$Exp1)*10;

//Формируем результат, удаляем запись о сессии
if ($Exp1=="") $Exp1=0;
if ($_SESSION['True_1']=="") $_SESSION['True_1']=0;
$True_1=$_SESSION['True_1'];
$ATable=$_SESSION['ATable'];
$UserName=$_SESSION['UserName'];
$NumGroup=$_SESSION['NumGroup'];
$NoOtv=$_SESSION['NoOtv'];
$YesOtv=$_SESSION['YesOtv'];
//Если тест рабочий, а не тренировочный
if ($_SESSION['TR']==1)
{
//Записываем результат в таблицу:
mysqli_query($_SESSION['mysqli'],"INSERT  INTO  $ATable VALUES('$NumGroup','$UserName','$Exp1','$True_1','$NoOtv','$YesOtv')")
     or die("Not insert");
}
//Удаление данных из sessions
mysqli_query($_SESSION['mysqli'],"DELETE FROM  `sessions` WHERE `login`='$UserName'") or die("Not delete");
//Выводим сообщение для пользователя о результатах тестирования: 	 
   $msg="<br><font size=+2>".$_SESSION['FullName'].",  вы  ответили  правильно  на  <b>".$_SESSION['True_1']."</b>  вопросов(а).";
   $msg=$msg."<br>Вы набрали  <b>".$_SESSION['TT']."</b>  баллов  из  возможных </b>".$_SESSION['MaxTotal'];
   $msg=$msg."<br>Baшa  оценка: <b>$Exp1<b/> баллов(а)</font>";
   echo  $msg;
   GetNoList($NoOtv,$_SESSION['Table']);
	?>
		<script language="JavaScript">
        parent.timeFrame.document.location.href="test_end.php";
		</script>
	<?php
   //  удаляем  сессию.
   session_unset() ;
   exit;
  }
$Quest=unserialize($_SESSION['Arr']);
$Counter=$_SESSION['Counter'];
$npp=$Quest[$_SESSION['Counter']];
$Table=$_SESSION['Table'];
$Res=mysqli_query($_SESSION['mysqli'],"SELECT  *  FROM  $Table  WHERE npp=$npp");
$Row=mysqli_fetch_row($Res);
$_SESSION['Diff']=$Row[0]; //Сложность
$_SESSION['text']=$Row[2]; //Текст вопроса
$_SESSION['var1']=$Row[3]; //Отв 1
$_SESSION['var2']=$Row[4]; //Отв 2
$_SESSION['var3']=$Row[5]; //Отв 3
$_SESSION['var4']=$Row[6]; //Отв 4
$_SESSION['var5']=$Row[7]; //Отв 5
$_SESSION['Prav']=$Row[8]; //Правильный вариант
//Вывести вопрос
if($_SESSION['Ntype']==3) GetQuestText3();
if($_SESSION['Ntype']==4) GetQuestText4();
if($_SESSION['Ntype']==5) GetQuestText5();
$_SESSION['Counter']=$_SESSION['Counter']+1;
 }
//  от  самого  первого  else
}
//Если превышено время ответа на тест
if (isset($_GET['time_out']))
{
//Формируем результат, удаляем запись о сессии
if ($Exp1=="") $Exp1=0;
if ($_SESSION['True_1']=="") $_SESSION['True_1']=0;
$True_1=$_SESSION['True_1'];
$ATable=$_SESSION['ATable'];
$UserName=$_SESSION['UserName'];
$NumGroup=$_SESSION['NumGroup'];
$True_1=$_SESSION['True_1'];
$NoOtv=$_SESSION['NoOtv'];
$YesOtv=$_SESSION['YesOtv'];
//Записываем результат в таблицу:
mysqli_query($_SESSION['mysqli'],"INSERT  INTO  $ATable VALUES('$NumGroup','$UserName','$Exp1','$True_1','$NoOtv','$YesOtv')")
     or die("Not insert");	
//Удаление данных из sessions
mysqli_query($_SESSION['mysqli'],"DELETE FROM  `sessions` WHERE `login`='$UserName'") or die("Not delete");
//Выводим сообщение о превышении времени тестирования	 
	?>
		<script language="JavaScript">
        parent.mainFrame.document.location.href="stop.php";
		parent.timeFrame.document.location.href="test_end.php";
		</script>
	<?php
   //  удаляем  сессию.
   session_unset() ;
   exit;
}

?>