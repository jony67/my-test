<?php 
  ////////////////////////////////////////////////////////////
  // Устанавливаем соединение с базой данных
  require_once 'connection.php';
  $mysqli = new mysqli($hostname,$username,$password,$databasename);
  if ($mysqli->connect_error) {
    die('Ошибка подключения к БД (' .$mysqli->errno.')'.$mysqli->error);
  }
  // Если пользователь не авторизовался - авторизуемся    
  if(!isset($_SERVER['PHP_AUTH_USER'])) 
  { 
	Header("Content-Type: text/html; charset=utf-8");
	Header("WWW-Authenticate: Basic realm=\"Admin Page\""); 
    Header("HTTP/1.0 401 Unauthorized");    
    exit(); 
  } 
  else 
  { 
 //Определяем тип браузера 
   $user_agent = $_SERVER["HTTP_USER_AGENT"];      	
   if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
   elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
   elseif (strpos($user_agent, "YaBrowser") !== false) $browser = "YaBrowser";  
   elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
   elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
   elseif (strpos($user_agent, "Trident") !== false) $browser = "Internet Explorer";    
 if(($browser == "YaBrowser")||($browser == "Chrome")){
    $u=$_SERVER['PHP_AUTH_USER'];
    $p=$_SERVER['PHP_AUTH_PW'];	   
 }
  elseif($browser == "Firefox"){
    $u=iconv('UTF-7','UTF-8',$_SERVER['PHP_AUTH_USER']);   
    $p=$_SERVER['PHP_AUTH_PW'];  
 }
 elseif($browser == "Internet Explorer"){   
    $u=iconv('Windows-1251','UTF-8',$_SERVER['PHP_AUTH_USER']);
    $p=iconv('Windows-1251','UTF-8',$_SERVER['PHP_AUTH_PW']);
 }
  else{
    $u=$_SERVER['PHP_AUTH_USER'];
    $p=$_SERVER['PHP_AUTH_PW'];	
 }   
    // Защищаемся от SQL-атак
    $u = $mysqli->real_escape_string($u);
    $p = $mysqli->real_escape_string($p);        
    $query = "SELECT password FROM 24_group WHERE login='".$u."'";
    $mysqli->set_charset("utf8");
    $result = $mysqli->query($query);   
    // Если ошибка в SQL-запросе - то
    if(!$result)
    {
	  Header("WWW-Authenticate: Basic realm=\"Admin Page-SQL incorrect\""); 
      Header("HTTP/1.0 401 Unauthorized"); 
      exit(); 
    }
    // Если нет такого пользователя - то
    if($result->num_rows == 0)
    {
      Header("WWW-Authenticate: Basic realm=\"Admin Page-User incorrect\""); 
      Header("HTTP/1.0 401 Unauthorized"); 
      exit(); 
    }
    // Если все проверки пройдены, сравниваем хэши паролей
    $pass = $result->fetch_assoc(); 
    if(md5($p) != $pass['password'])
    { 
      Header("WWW-Authenticate: Basic realm=\"Admin Page-Password incorrect\""); 
      Header("HTTP/1.0 401 Unauthorized"); 
      exit(); 
    }
  }
?>