<?php

class ClassItogiCtrl {
// Функция выводов результатов
//данные - члены класса
  private $data1;      //промежуточный массив данных
  private $data;       //обработанные данные  
  private $d;          //необработанные данные
//  private $schema;   //цветовая схема
  private $k=0;        //положительные оценки
  private $d_all=0;    //всего
  private $d_5=0;      //отлично    
  private $d_4=0;      //хорошо  
  private $d_3=0;      //удовлетворительно
  private $d_2=0;	   //неудовлетворительно
  private $d_sr=0;	   //средний балл
  private $d_max=NULL; //максимальная оценка
  private $d_min=NULL; //минимальная оценка    
  private $persent;    //процент оценок
  private $s;          //вывод в браузер

////////////////////////////////////////////////////////////////////
// ClassItogi - класс обработки итогов сдачи экзамена (зачета)
////////////////////////////////////////////////////////////////////
//конструктор
////////////////////////////////////////////////////////////////////
  public function __construct($d){
    if(!isset($d)) echo "Отсутствуют данные для анализа!";
	else {
        $this->data1=0;
		$this->d=$d;
        $this->s="";
		$this->persent=0;
		$this->d_max=max($this->d);
		$this->d_min=min($this->d);
		$this->checkForMark();
/*
if($schema==0) 
		$this->data=array(
        array( "отлично", $this->data1[0], "#00FFFF"), 
        array( "хорошо", $this->data1[1],"#33FF00"),
        array( "удов.", $this->data1[2],"#333399" ),
        array( "неуд.", $this->data1[3],"#FF0000"));
if($schema==1) 
		$this->data=array(
        array( "отлично", $this->data1[0], "#FF0000"), 
        array( "хорошо", $this->data1[1],"#00FF00"),
        array( "удов.", $this->data1[2],"#0000FF" ),
        array( "неуд.", $this->data1[3],"#000000"));
if($schema==2) //Без графиков (для печати)
		$this->data=array(
        array( "отлично", $this->data1[0], "#FFFFFF"), 
        array( "хорошо", $this->data1[1],"#FFFFFF"),
        array( "удов.", $this->data1[2],"#FFFFFF" ),
        array( "неуд.", $this->data1[3],"#FFFFFF"));		
		$this->s=$this->s."<table width=\"500\" cellspacing=\"0\" cellpadding=\"2\">";
		foreach( $this->data as $n )
		   {
			if(!$n[1]) $n[1]=0; 
			$this->percent = sprintf("%.1f",( $n[1] / $this->d_all ) * 100);
			$this->s=$this->s."<tr><td width=\"15%\">-".$n[0]."</td><td width=\"5%\">".$n[1]."&nbsp;чел.</td><td width=\"10%\">&nbsp;".$this->percent."%</td><td>";
			if(!$n[1]) $n[2]="white";
			$this->s=$this->s."<table width=\"".$this->percent."%\" bgcolor=\"".$n[2]."\"><tr><td>&nbsp;</td></tr></table></td></tr>";
		   }
		$this->s=$this->s."</table>";
       }
*/
  }
}  
////////////////////////////////////////////////////////////////////
// открытые методы
//Максимальный балл
  public function getMax(){
    return $this->d_max;
  }
//Минимальный балл
  public function getMin(){
    return $this->d_min;
  }  
//Кол-во отличных оценок 
  public function getFive(){
    return $this->data1[0];
  }
//Кол-во хороших оценок
  public function getFor(){
    return $this->data1[1];
  }
//Кол-во удовлетворительных оценок  
  public function getThree(){
    return $this->data1[2];
  }
//Кол-во неудовлетворительных оценок  
  public function getToo(){
    return $this->data1[3];
  }
//Кол-во положительных оценок  
  public function getPlus(){
   $this->k=$this->getFive()+$this->getFor()+$this->getThree();
	return $this->k;
  }
//Всего сдавало    
  public function getAll(){
   $this->d_all=$this->getFive()+$this->getFor()+$this->getThree()+$this->getToo();
	return $this->d_all;
  }
//Средний балл    
  public function getSrZnach(){
    $this->d_sr=sprintf("%.1f",($this->getFive()*5+$this->getFor()*4+ $this->getThree()*3+$this->getToo()*2)/$this->getAll());
	return $this->d_sr;
  }
//Вывод таблицы  
  public function getTable(){
   	return $this->s;
  }  
////////////////////////////////////////////////////////////////////
//закрытые методы
////////////////////////////////////////////////////////////////////
  public function checkForMark(){
	foreach ($this->d as $key=>$value )
	 { 
	  $this->d_all=$this->d_all+1; 
	  if($value>=8.5) $this->d_5=$this->d_5+1; 
	  else if($value>=6.5) $this->d_4=$this->d_4+1;
	  else if($value>=4.5) $this->d_3=$this->d_3+1; 
	  else $this->d_2=$this->d_2+1; 
	 }
	$this->data1=array($this->d_5,$this->d_4,$this->d_3,$this->d_2);
	return $this->data1;
	}
////////////////////////////////////////////////////////////////////

}
//конец описания класса
