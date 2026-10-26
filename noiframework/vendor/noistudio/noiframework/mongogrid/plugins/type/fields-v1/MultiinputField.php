<?php

 yii::import("ext.mongogrid.core.PluginField");
class MultiinputField extends PluginField{
    public function __construct( $field_name, $opt) {
        parent::__construct('multiselect', $field_name, $opt);
    }
    public function afterEvent($mg) {
        parent::afterEvent($mg);
    }
  public function getInput($value="",$mg) {
  $hidden_div="<div id='multiselect_".$this->field_name."'>";
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
   $input_show.="<input  id='field_".$this->field_name."_".$i."'name='field_".$this->field_name."_".$i."' value='".$v."'>";
   $i++;
   }


 }


 $i=count($value)-1;
  $hidden_div.="</div>";


    $template=$input_show."".$hidden_div."<a id='click".$this->field_name."' href='#'>+</a><div class='insert_".$this->field_name."'></div>";
  $template.="<script>"."var i_".$this->field_name."=".$i.";var content_".$this->field_name."=$('#multiselect_".$this->field_name."').html();"
          . "$('document').ready(function(){"
           . " "
          . "$('#click".$this->field_name."').on('click',function(){"
            .""
          . "i_".$this->field_name."++;"
          . "$('.insert_".$this->field_name."').append('<input type=text name=field_".$this->field_name."_'+i_".$this->field_name."+'>');"
          . "return false;})})</script>";
  return $template;
  }
  
    public function renderValue($value, $mg) {
        return $value;
    }
   public function setInput($value="",$mg) {


$array=array();
$i=0;

while(isset($_POST['field_'.$this->field_name."_".$i])){
$array[count($array)]=$_POST['field_'.$this->field_name."_".$i];
$i++;
}
 

return $array;
  }
}
?>
