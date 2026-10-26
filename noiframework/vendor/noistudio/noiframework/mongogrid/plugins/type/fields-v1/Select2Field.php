<?php

yii::import("ext.mongogrid.core.PluginField");
class Select2Field extends PluginField{
  private $type="array";

  private $data;
  private $id_data=array();
  function __construct($field_name,$opt) {
     if(isset($opt['collection']) and isset($opt['condition']) and is_array($opt['condition']) and  isset($opt['select']) and is_array($opt['select'])){
      $this->type="db";
      $result=  MGQuery::execute(array('_id',$opt['select'][0]),  $opt['collection'], $opt['condition'], array('_id'=>-1), null,0);
      $this->data=array();
            

      if(isset($result[0]['_id'])){
          foreach($result as $row){
          if(isset($row[$opt['select'][0]]) and isset($row['_id'])){
           
          $this->data[count($this->data)]=array('value'=>$row['_id']->__toString(),'title'=>$row[$opt['select'][0]]);
          $this->id_data[count($this->id_data)]=$row['_id']->__toString();
          }
          }
     
      }
     }
    
     if(isset($opt[0]['title']) and isset($opt['value'])){
     $this->id_data=array();
     $this->data=$opt;
     foreach($this->data  as $row){
       if(isset($row['value'])){
        $this->id_data[count($this->id_data)]=$row['value'];
       }
     }
     }


      parent::__construct("select2",$field_name,$opt);
  }

  public function getInput($value="",$mg) {
  $template="<select name='field_".$this->field_name."'>";
 
  if(isset($this->data) and count($this->data)>0){
    foreach($this->data as $row){
    $selected="";
    if($row['value']==$value){
     $selected="selected";
    }
    $tmp=$row['value'];
    $template.='<option '.$selected." value='".$tmp."'>".$row['title']."</option>";
    }
  }

  $template.="</select>";
  return $template;
  }
  public function setInput($value="",$mg) {
  if(in_array($_POST['field_'.$this->field_name],$this->id_data)){
    $key_val=array_search($_POST['field_'.$this->field_name], $this->id_data);
    $mg->fields->row[$this->field_name."_title"]=$this->data[$key_val]['title'];
    return $_POST['field_'.$this->field_name];
  }
  if($this->opt['required']==true){
     return false;
  }else {
   return $this->opt['default'];
  }

 
  }
  public function renderValue($value,$mg) {
  
  return $value;
  }
}
?>