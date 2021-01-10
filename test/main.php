<?php
$LoginScript=$_SERVER['HTTP_HOST']."/test/login.php";
//$LoginScript=$_SERVER['HTTP_HOST']."/xampp/test/login.php";
$NewsFile="readme.php";
$data=date("d.m.Y");
//  Читаем  файл  с  новостями
if(file_exists($NewsFile))
{
$news = join('', file($NewsFile));
}
else  $news="Сегодня новостей нет";
?>

<html><head><meta  http-equiv="Content-Type" content="text/html";   charset="windows-1251">
<meta  name="Author"  content="(c)   2005  jony67">
<title>SmartTest</title>
<link  rel=stylesheet  type="text/css" href="tooltip.css">
</head>
<body  text="#000000"  bgcolor="#FFFFFF" link="#0000EE"  vlink="#551A8B" link="#FF0000" background="smarttest.jpg">
<table  WIDTH="100%"  BGCOLOR="#336699"><tr><td>
<font  color="FFFFFF"><font  size=+l>Ceгодня <?php echo $data; ?></font></font></td></tr></table>
<table  WIDTH="100%"  border="l"  cellspacing="0" cellpadding="3"  bordercolor="#336699">
<tr><td  width="50%"><font  color="#336699"><font size=+l>О программе</font></font></td>
<td  width="50%"><font  color="#336699" size=+l>Peгистрация</font></td></tr>
<tr><td>   
<?php echo  $news; ?>
<td><form  action="<?php echo 'http://'.$LoginScript; ?>" method=POST>
<br> Фамилия, инициалы &nbsp; 
<input  type=text  name="user" class="fio_inp">
<span class='tip'>
	<span class='answer'>
		<font color="#888888" size="-1">Например,</font> Иванов И.И.
	</span>
</span>
<br>Группа &nbsp; <input  type=text  name="ngr">
<br> Пароль &nbsp; <input  type=password  name="pswd">
<br><br><input  type=submit  value="В х о д"><p>Вы должны быть  зарегистрированным
<br>пользователем!  По  вопросам  регистрации  обращайтесь к 
<a href=mailto:st-admin@host.com>администратору  системы Test-Info</a>
</td></tr></table>
<p><h3>&copy jony67  <a  href="https://github.com/jony67/testinfo.git">GitHub </a></h2>

