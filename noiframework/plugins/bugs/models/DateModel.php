<?php

namespace bugs\models;
use NoiCore;
use DateTime;
class DateModel{
     public function isCorrectDate($field){
     if(!isset($field)){
      return false;   
     }else {
      
     if(isset($field) and is_string($field) and $this->validateDate($field,"d.m.Y")){
     return true;    
     }else {
       return false;  
     }   
     }   
     
    }
    private function getYears($field){
    $a = new DateTime();
$b = new DateTime($field);
$years = $b->diff($a)->y;

$years=floatval((time() - strtotime($_POST['date'])) / 31556926);
return $years;
}
    public function getCategory($field){
    $years=$this->getYears($field);
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
    function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
}

