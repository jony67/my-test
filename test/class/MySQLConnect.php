<?php
require 'MySQLException.php';
require 'MySQLResultSet.php';
////////////////////////////////////////////////////////////////////
class MySQLConnect{
  //данные-члены класса
  private $connection;
  private static $instances = 0;
  const ONLY_ONE_INSTANCE_ALLOWED = 5000;
////////////////////////////////////////////////////////////////////
//конструктор
////////////////////////////////////////////////////////////////////
public function __construct($hostname, $username, $password){
    if(MySQLConnect::$instances == 0){
      if(!$this->connection = mysqli_connect($hostname, $username,$password )){
        throw new MySQLException(mysqli_error(), mysqli_errno());
      }
      MySQLConnect::$instances = 1;
    }else{
      $msg = "Закройте существующую копию".
        "MySQLConnect class.";
      throw new MySQLException($msg, self::ONLY_ONE_INSTANCE_ALLOWED);
    }
}
////////////////////////////////////////////////////////////////////
//деструктор
////////////////////////////////////////////////////////////////////
  public function __destruct(){
    $this->close();
  }
////////////////////////////////////////////////////////////////////
//открытые методы
////////////////////////////////////////////////////////////////////
  public function createResultSet($strSQL, $databasename){
    $rs = new MySQLResultSet($strSQL, $databasename, $this->connection );
    return $rs;
  }
////////////////////////////////////////////////////////////////////
  public function getConnection(){
    return $this->connection;
  }
////////////////////////////////////////////////////////////////////
  public function selectDatabase($databasename){
    if(!mysqli_select_db($databasename, $this->connection)){
      throw new MySQLException(mysqli_error(), mysqli_errno());
    }
	return $this->connection;  
  }
////////////////////////////////////////////////////////////////////
  public function getVersionNumber(){
    //mysql_get_server_info
    return mysql_get_server_info();
  }
////////////////////////////////////////////////////////////////////  
//Запрос на обновление в таблице БД ("UPDATE")
  public function setUpdate($sqlQuery){
    if($sqlQuery<>''){
    	$rs=mysql_query($sqlQuery, $this->connection) or die("SQL-запрос не выполнен!");
	  }
	else {
		echo "Введите строку запроса!";
	}	
  }    
////////////////////////////////////////////////////////////////////
  public function close(){
    MySQLConnect::$instances = 0;
    if(isset($this->connection)){
      mysql_close($this->connection);
      unset($this->connection);
    }
  }
}//конец класса
////////////////////////////////////////////////////////////////////
?>
