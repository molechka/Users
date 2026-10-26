<?php

yii::import("ext.mongogrid.core.PluginField");
class MultiselectField extends PluginField{
  private $collection;
  private $condition;
  private $select;
  private $default;
  private $data;
  private $iscollection=1;
  private $isnull=0;
  private $array_data;

  function __construct($field_name,$opt) {
   
      if(isset($opt['isnull']) and $opt['isnull']==1){
      $this->isnull=1;
      }
      if(!isset($opt['default'])){
        $opt['default']="";
      }
      if(!isset($opt['data'][0]['value'])){
      $this->collection=$opt['collection'];
      $this->condition=$opt['condition'];
      $this->select=$opt['select'];
      $this->default=$opt['default'];
      $this->data=  MGQuery::execute($this->select, $this->collection, $this->condition, array('_id'=>-1), 100,0);
     
      }else {
      $this->data=$opt['data'];
   
      $this->iscollection=0;
      $this->select=array('title');
      }

      parent::__construct("multiselect",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $hidden_div="<div id='multiselect_".$this->field_name."'>";
  $input_show="";

 if(is_array($value)){
 if(count($value)==0){
  $value=array(0);
   
 }
     $i=0;
     $input_show="";
 
   foreach($value as $v){
    

    $input_show.="<select  id='field_".$this->field_name."_".$i."'name='field_".$this->field_name."_".$i."'>";
    if($this->isnull==1){
    $input_show.='<option value="null">Не выбрано</option>';
    }
    foreach($this->data as $row){
    if(isset($row[$this->select[0]])){
     $selected="";
     if($this->iscollection==1){
   

     if($row['_id']->__toString()==$v){
    
     $selected="selected";
  
     }
    $values=$row['_id']->__toString()."|".$row[$this->select[0]];
    $input_show.="<option ".$selected." value='".$values."'>".$row[$this->select[0]]."</option>";
    
     }else {
 
     if($row['value']==$v){
      $selected='selected';
     }
      $values=$row['value']."|".$row[$this->select[0]];
      $input_show.="<option value='".$values."' ".$selected.">".$row[$this->select[0]]."</option>";
     }

    }
   }
   $input_show.="</select>";
   $i++;
   }
  
 
 }
      if($this->isnull==1){
    $hidden_div.='<option value="null">Не выбрано</option>';
    }
  if(isset($this->data)){
     
   foreach($this->data as $row){
    if(isset($row[$this->select[0]])){
     $selected="";
     if($this->iscollection==1){
     if($row['_id']->__toString()==$this->default){
     $selected="selected='selected'";
     }
     }else {
       
     if($row['value']==$this->default){
      $selected="selected='selected'";
     }
     }
    if($this->iscollection==1){
    $values=$row['_id']->__toString()."|".$row[$this->select[0]];
    $hidden_div.="<option ".$selected." value='".$values."'>".$row[$this->select[0]]."</option>";
    }else {
    $values=$row['value']."|".$row[$this->select[0]];
    $hidden_div.="<option ".$selected." value='".$values."'>".$row[$this->select[0]]."</option>";
    
    }
    }
   }
  }
  
  $hidden_div.="</div>";
 
  if(!is_array($value)){

  $template=$hidden_div."<a id='click".$this->field_name."' href='#'>+</a><select  id='field_".$this->field_name."_0'name='field_".$this->field_name."_0'></select><div class='insert_".$this->field_name."'></div>";
  $template.="<script>"."var i=0;var content_".$this->field_name."=$('#multiselect_".$this->field_name."').html();"
          . "$('document').ready(function(){"
          . " var temp_data_".$this->field_name."=$('#multiselect_".$this->field_name."').html(); "
          . "$('#field_".$this->field_name."_0').html(temp_data_".$this->field_name."); "
          . "$('#click".$this->field_name."').on('click',function(){"
            .""
          . "i++;"
          . "$('.insert_".$this->field_name."').append('<select name=field_".$this->field_name."_'+i+'>'+content_".$this->field_name."+'</select>');"
          . "return false;})})</script>";

  }else {
  
   if(count($value)>0){
   $newi=count($value)-1;
   }else {
   $newi=0;
   }
   $newi=(int)$newi;

  
    $template=$input_show."".$hidden_div."<a id='click".$this->field_name."' href='#'>+</a><div class='insert_".$this->field_name."'></div>";
  $template.="<script>"."var i_".$this->field_name."=".$newi.";var content_".$this->field_name."=$('#multiselect_".$this->field_name."').html();"
          . "$('document').ready(function(){"
          . " var temp_data_".$this->field_name."=$('#multiselect_".$this->field_name."').html(); "
          . " "
          . "$('#click".$this->field_name."').on('click',function(){"
            .""
          . "i_".$this->field_name."++;"
          . "$('.insert_".$this->field_name."').append('<select name=field_".$this->field_name."_'+i_".$this->field_name."+'>'+content_".$this->field_name."+'</select>');"
          . "return false;})})</script>";
  }
  return $template;
  }
  public function setInput($value="",$mg) {


$array=array();
$array_label=array();
$i=0;

while(isset($_POST['field_'.$this->field_name."_".$i])){
$tmp=explode("|",$_POST['field_'.$this->field_name."_".$i]);
if(isset($tmp[1])){
 $label=$tmp[1];
 $array_label[count($array_label)]=$label;
 $_POST['field_'.$this->field_name."_".$i]=$tmp[0];
}
if((StrInput::is_Id($_POST['field_'.$this->field_name."_".$i]) and $this->iscollection==1)or (isset($_POST['field_'.$this->field_name."_".$i]) and $this->iscollection==0)){
if(!in_array($_POST['field_'.$this->field_name."_".$i], $array)){
 $array[count($array)]=$_POST['field_'.$this->field_name."_".$i];

}
}else {
if($_POST['field_'.$this->field_name."_".$i]=="null"){
 if(count($array)==0){
  $array=array();
 }
}
}
$i++;
}
$mg->fields->row[$this->field_name."_title"]=$array_label;
return $array;
  }
  public function renderValue($value,$mg) {
  $template="<a href='".$value."'>Посмотрет</a>";
  return $template;
  }
}
?>
