<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
use noicms\mongogrid\system_core\MGQuery;
class RandField extends PluginField{


  function __construct($field_name,$opt) {


      parent::__construct("invite",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $required="";
  
  $this->visible=false;
  $template="";
  return $template;
  }
  public function generate($length=4,$arr){
$max=count($arr);
$max=$max-1;
$i=0;
$str="";
while($i!=$length){
   $str=$str."".$arr[rand(0,$max)];
   $i++;
}
return $str;

  }
  public function setInput($value="",$mg) {
   $array_worlds=array(
  'A','B','C','D','E','F','G','H','J','K','L','Q','W','E','R','T','Y','U','I','O','P','Z','X','C','V','B','N','M'
);
$array_number=array(0,1,2,3,4,5,6,7,8,9);
$value=$this->generate(1,$array_worlds)."".$this->generate(5,$array_number);

$condition=array($this->field_name=>$value);
$result=  MGQuery::execute(array($this->field_name), $mg->collection,$condition);
if(!isset($result[0][$this->field_name])){
     $_POST[$this->getNameField()]=$value;
   return $value;
}else {
  return false;
}



  }
  public function renderValue($value,$mg) {

  return $value;
  }
}
?>