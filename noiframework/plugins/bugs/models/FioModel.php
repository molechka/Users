<?php

namespace bugs\models;
class FioModel{
   private $newfio=""; 
   private $oldfio="";
   private $isnew=false;
   public function getStatus(){
       
   $result=$this->isnew;  
   
   }
   public function getFio(){
    return $this->newfio;   
   }
   public function start($fio){
  $this->oldfio=$fio;     
  $result="";  
  $string=$fio;
  $newstring=preg_replace('/[^a-zA-Zа-яА-Я]/ui', ' ',$string );
  $newstring=trim($newstring);
 $this->newfio=$newstring;
  $result="";
  if($string==$newstring){
   
  $this->isnew=false;
  }else {
      
 // $result.="Мы удалили мусор";   
  $this->isnew=true;
  }
  //$_POST['name']=$newstring;
   }  
}