<?php

namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
class MultiinputField extends PluginField{
    public function __construct( $field_name, $opt) {
        parent::__construct('multiinput', $field_name, $opt);
    }
    public function afterEvent($mg) {
        parent::afterEvent($mg);
    }
  public function getInput($value="",$mg) {
  $hidden_div="<div id='multiinput_".$this->getNameField()."'>";
  $input_show="";
  $i=0;
 if(!is_array($value)){
 $value=array();
 }
 if(is_array($value)){
 if(count($value)==0){
  $value=array(0);

 }
   
     $input_show="";
   foreach($value as $v){
   $input_show.="<input  id='".$this->getNameField()."_".$i."'name='".$this->getNameField()."_".$i."' value='".$v."'>";
   $i++;
   }


 }


 $i=count($value)-1;
  $hidden_div.="</div>";


    $template=$input_show."".$hidden_div."<a id='click".$this->getNameField()."' href='#'>+</a><div class='insert_".$this->getNameField()."'></div>";
  $template.="<script>"."var i_".$this->getNameField()."=".$i.";var content_".$this->getNameField()."=$('#multiselect_".$this->getNameField()."').html();"
          . "$('document').ready(function(){"
           . " "
          . "$('#click".$this->getNameField()."').on('click',function(){"
            .""
          . "i_".$this->getNameField()."++;"
          . "$('.insert_".$this->getNameField()."').append('<input type=text name=".$this->getNameField()."_'+i_".$this->getNameField()."+'>');"
          . "return false;})})</script>";
  return $template;
  }
  
    public function renderValue($value, $mg) {
        return $value;
    }
   public function setInput($value="",$mg) {


$array=array();
$i=0;

while(isset($_POST[''.$this->getNameField()."_".$i])){
$array[count($array)]=$_POST[''.$this->getNameField()."_".$i];
$i++;
}
 

return $array;
  }
}
?>