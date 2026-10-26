<?php

namespace bugs\models;
use NoiCore;
use DateTime;
class BugModel{
   private $fio_string="";  
   private $fio_status=true;
    public function getCode(){
    
    if(!$this->isCorrectDate()){
     return array('type'=>'error','message'=>'Дата неправильная! Правильный формат даты ДД.ММ.ГГГГ');  
    }else {
     $message=$this->getCategory();   
     $fio=$this->getFio();
     $date=date('Y-m-d',strtotime($_POST['date']));
     $array=array('type'=>'success',"message"=>$fio.',искомая дата '.$date.',категория:'.$message);
     return $array;
    }  
        
    }
 public function isCorrectFio(){
 if(isset($_POST['name']) and is_string($_POST['name']) and strlen($_POST['name'])>0){
 return true;    
 }else {
  return false;   
 }     
 }  
public function getFio(){
  if(isset($_POST['name']) and is_string($_POST['name']) and strlen($_POST['name'])>0){  
  $result="";  
  $string=$_POST['name'];
  $newstring=preg_replace('/[^a-zA-Zа-яА-Я]/ui', ' ',$string );
  $newstring=trim($newstring);
 $this->fio_string=$newstring;
  $result="";
  if($string==$newstring){
  $result.="Мы ничего не делали"; 
  $this->fio_status=true;
  }else {
  $result.="Мы удалили мусор";   
  $this->fio_status=false;
  }
  //$_POST['name']=$newstring;
  }else {
  $result="Отсутствуют данные";    
  }
  return $result;
}
public function getStatusFio(){
  return $this->fio_status;  
}
public function getNewFio(){
 return $this->fio_string;   
}
private function getYears(){
    $a = new DateTime();
$b = new DateTime($_POST['date']);
$years = $b->diff($a)->y;

$years=floatval((time() - strtotime($_POST['date'])) / 31556926);
return $years;
}
    public function getCategory(){
    $years=$this->getYears();
    if($years<0.90 and $years>0.0){
       return 'грудной ребенок';
    }else if($years<14.0 and $years>0.8){
       return 'ребенок';  
    }else if($years<18.0 and $years>14.0){
        return 'подросток';
    }else if($years<22.0 and $years>18.0){
        return 'взрослый (спиртное нельзя)';
    }else if($years<60.0 and $years>22.0){
        return 'взрослый';
    }else if($years<100.0 and $years>60.0){
        return 'пенсионер';
    }else if($years>100.0){
        return 'тебе врут, чувак';
    }else {
        return 'где-то тебя накололи…';
    }
    }
    public function getDate(){
     if($this->isCorrectDate()){
     return "Все ок,мы ничего не меняли";    
     }else {
      return "Неправильный формат даты";   
     }   
    }
    public function isCorrectDate(){
     if(!isset($_POST['date'])){
      return false;   
     }else {
     if(isset($_POST['date']) and is_string($_POST['date']) and $this->validateDate($_POST['date'],"d.m.Y")){
     return true;    
     }else {
       return false;  
     }   
     }   
     
    }
    function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
    
}
