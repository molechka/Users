<?php
namespace noicms\mongogrid\plugins\type\fields;


use noicms\mongogrid\core\PluginField;
use NoiCore;
class CheckboxarrayField extends PluginField{
  private $type="array";
  private $value_row="_id";
  private $title_row="title";
  private $data;
  private $id_data=array();
  private $isnull=0;

   function __construct($field_name,$opt) {
       
  if(isset($opt['isnull']) and $opt['isnull']==1){
      $this->isnull=1;
      }
 
     if(isset($opt['collection']) and isset($opt['condition']) and is_array($opt['condition']) and  isset($opt['select']) and is_array($opt['select'])){
      $this->type="db";
      if(!isset($opt['select'])){
       $opt['select']=array();   
      }
         
      if(isset($opt['value_row'])){
       $opt['select'][count($opt['select'])]=$opt['value_row'];
       $this->value_row=$opt['value_row'];
      }
  
       if(isset($opt['title_row'])){
       $opt['select'][count($opt['select'])]=$opt['title_row'];
       $this->title_row=$opt['title_row'];
      }
      $opt['select'][count($opt['select'])]="_id";
      
      $result=  NoiCore::app()->db()->query2($opt['select'],  $opt['collection'], $opt['condition'], array('_id'=>-1), null,0);
  
      $this->data=array();
     
     

      if(isset($result[0]['_id'])){
          foreach($result as $row){
          if(isset($row[$opt['select'][0]]) and isset($row['_id'])){
          $value="";
          if($this->value_row=="_id"){
          $value=$row['_id']->__toString();
          }else {
          $value=$row[$this->value_row];
          }
          $this->data[count($this->data)]=array('value'=>$value,'title'=>$row[$this->title_row]);
          $this->id_data[count($this->id_data)]=$value;
          }
          }
     
      }
     }
    
     if(isset($opt[0]['title']) and isset($opt[0]['value'])){
     $this->id_data=array();
     $this->data=$opt;
     $i=0;
      while(isset($opt[$i]['value'])){
 $this->id_data[count($this->id_data)]=$opt[$i]['value'];
$i++;

     }
     }
// if($this->isnull==1){
//  $this->data[]=array('value'=>'null','title'=>'null');
//  $this->id_data[]="null";
// }

      parent::__construct("checkboxarray",$field_name,$opt);
  }
  
  
   public function getInput($value="",$mg) {
   $added=""; 
   if(NoiCore::app()->isAdmin()){
  $added="class='form-control input-lg'";    
  }    
  $template="";
 $i=0;

  if(isset($this->data) and count($this->data)>0){
    while(isset($this->data[$i]['value'])){
    $row=$this->data[$i];
     
  
    
    $tmp=$row['value'];
     $checked="";
    if(isset($value[$row['value']]['result']) and $value[$row['value']]['result']==1){
    $checked="checked";    
    }
     
     
    $template.='<input name="'.$this->getNameField().'['.$row['value'].']" '.$checked.'  type="checkbox"  value="1">'.$row['title']."<br>";
    
    $i++;
    }
  }

  $template.="";
  return $template;
  }
  
  public function setInput($value="",$mg) {
 if(!isset($_POST[''.$this->getNameField()])){
    return false;
 }
 if(isset($_POST[''.$this->getNameField()]) and is_array($_POST[''.$this->getNameField()]) and count($_POST[''.$this->getNameField()])>0){
 
     if(isset($this->data) and count($this->data)>0){
    $result_array=array(); 
    $i=0;
    while(isset($this->data[$i]['value'])){
    $row=$this->data[$i];
     
  
    
    $tmp=$row['value'];
     
    $checked="";
    if(isset($_POST[''.$this->getNameField()][$row['value']]) and is_numeric($_POST[''.$this->getNameField()][$row['value']]) and (int)$_POST[''.$this->getNameField()][$row['value']]===1){
     $result_array[$row['value']]=array('result'=>1,'title'=>$row['title']);   
    }else {
    if(isset($result_array[$row['value']])){
    unset($result_array[$row['value']]);    
    }    
      
    }
     
    $i++;
    }
   
    return $result_array;
  }   
 }
  
  if($this->opt['required']==true){
     return false;
  }else {
   return $this->opt['default'];
  }

 
  }
  public function renderValue($value,$mg) {
  if(isset($value) and is_array($value)){
  return count($value);
  }else {
     return 0; 
  }
  }

}