<?php
////////////////////////////////////////////////////////////////////
class MySQLResultSet implements Iterator{
  //данные - члены класса
  private $strSQL;
  private $databasename;
  private $connection;
  private $result;
  private $valid;
  private $currentrow;
  private $key;
  private $no;
  private $vid;
  //задание номера ошибки
  //вне диапазона использования MySQL (>5000)
  const INDETERMINATE_TOTAL_NUMBER = 5001;
  const UNNECESSARY_SQL_CALC_FOUND_ROWS = 5002;
  const NOT_SELECT_QUERY = 5003;
////////////////////////////////////////////////////////////////////
//конструктор
////////////////////////////////////////////////////////////////////
  public function __construct( $strSQL, $databasename, $connection ){
    $this->strSQL = $strSQL;
    $this->connection = $connection;
    $this->databasename = $databasename;
    if(!mysql_selectdb($databasename, $connection)){
      throw new MySQLException(mysql_error(), mysql_errno());
    }
    if(!$this->result = mysql_query($strSQL, $connection)){
      throw new MySQLException(mysql_error(), mysql_errno());
    }
    //check if contains SQL_CALC_FOUND_ROWS
    if (stristr($strSQL,"SQL_CALC_FOUND_ROWS")){
      $msg = "No need to use SQL_CALC_FOUND_ROWS.";
      throw new MySQLException($msg, self::UNNECESSARY_SQL_CALC_FOUND_ROWS);
    }
    //initialize values (not necessary for foreach)
    $this->rewind();
  }
////////////////////////////////////////////////////////////////////
//деструктор
////////////////////////////////////////////////////////////////////
  public function __destruct(){
    $this->close();
  }
////////////////////////////////////////////////////////////////////
// открытые методы
////////////////////////////////////////////////////////////////////
  public function getDatabaseName(){
    return $this->databasename;
  }
////////////////////////////////////////////////////////////////////
  public function getNumberColumns(){
    return mysql_num_fields($this->result);
  }
////////////////////////////////////////////////////////////////////
//Только для выборки запросов
////////////////////////////////////////////////////////////////////
  public function getNumberRows(){
    return mysql_num_rows($this->result);
  }
////////////////////////////////////////////////////////////////////
  public function getInsertId(){
    return mysql_insert_id( $this->connection);
  } 
////////////////////////////////////////////////////////////////////
//Вычисление общего количества записей, при существующем ограничении
//Применяется для подсчета страниц в версиях MySQL 4.0 и ниже
//Unreliable results if DISTINCT used
////////////////////////////////////////////////////////////////////
  public function getUnlimitedNumberRows(){
    $number = $this->countVersionFour();
    return $number;
  }
////////////////////////////////////////////////////////////////////
  public function getFieldNames(){
    $fieldnames = array();
    if(isset($this->result)){
      $num = mysql_numfields($this->result);
      for($i = 0; $i < $num; $i++){
        if (!$meta = mysql_fetch_field($this->result, $i)){
          throw new MySQLException(mysql_error(), mysql_errno());
        }else{
          $fieldnames[$i]= $meta->name;
        }
      }
    }
    return $fieldnames;
  }
////////////////////////////////////////////////////////////////////
  public function getJSON(){
    if(isset($this->result)){
      //$jdata = new FastJSON::encode($this->result);
      //return $jdata;      
        }
    else {
      echo "Json-encoder error!";
        }
      }
////////////////////////////////////////////////////////////////////
  public function findVersionNumber(){
    //mysql_get_server_info
    return mysql_get_server_info($this->connection);
  }
////////////////////////////////////////////////////////////////////
//методы класса Iterator которые должны быть выполнены
////////////////////////////////////////////////////////////////////
  public function current (){
    return $this->currentrow;
  }
////////////////////////////////////////////////////////////////////
  public function key (){
    return $this->key;
  }
////////////////////////////////////////////////////////////////////
  public function next (){
    if($this->currentrow = mysql_fetch_array($this->result)){
      $this->valid = true;
      $this->key++;
    }else{
      $this->valid = false;
    }
  }
////////////////////////////////////////////////////////////////////
  public function rewind (){
    if($num = mysql_num_rows($this->result) > 0){
      if(mysql_data_seek($this->result, 0)){
        $this->valid = true;
        $this->key = 0;
        $this->currentrow = mysql_fetch_array($this->result);
      }
    }else{
      $this->valid = false;
    }
  }
////////////////////////////////////////////////////////////////////
 	public function valid (){
    return $this->valid;
  }
////////////////////////////////////////////////////////////////////
//закрытые методы
////////////////////////////////////////////////////////////////////
  private function checkForSelect(){
    $bln = true;
    $strtemp = trim(strtoupper($this->strSQL));
    if(substr($strtemp,0,6)!= "SELECT"){
      $bln = false;
    }
    return $bln;
  }
////////////////////////////////////////////////////////////////////
  private function close(){
    if(isset($this->result)){
      mysql_free_result($this->result);
      unset($this->result);
    }
  }
////////////////////////////////////////////////////////////////////
  private function countVersionFour(){
    $tempsql = trim($this->strSQL);
    //insert SQL_CALC_FOUND_ROWS
    $insertstr = " SQL_CALC_FOUND_ROWS ";
    //Запуск через "SELECT"
    $tempsql = substr_replace($tempsql, $insertstr, 6, 1);
    if(!$rs = mysql_query($tempsql, $this->connection)){
      throw new MySQLException(mysql_error(), mysql_errno());
    }
    $tempsql = "SELECT FOUND_ROWS()";
    if(!$rs = mysql_query($tempsql)){
      throw new MySQLException(mysql_error(), mysql_errno());
    }
    $row = mysql_fetch_row($rs);
    $number = $row[0];
    //освобождаем память соединения от $rs
    mysql_free_result($rs);
    return $number;
  }
}//end class
?>
