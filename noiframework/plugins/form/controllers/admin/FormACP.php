<?php

class FormACP  extends CoreAdminControllerPlugin{
  public $collections=array('plugin_form_messages');
 public function __construct($site) {
     parent::__construct('form',$site);
 }
  public function menu_get_links($op=0){


     if($op=="0"){

     return array(array('value'=>'form','title'=>'Просмотр формы'));
     }
     if($op=="form"){
    $array=array();
  $forms=$this->db()->query2(array(),"plugin_forms",array('visible'=>1));
  if(count($forms)>0){
  foreach($forms as $form){
  $array[]=array('value'=>'/form/'.$form['_id']->__toString().".html",'title'=>$form['title']);
  }
  }

  return $array;
     }

 }
  public function menu_get_widgets($value="0"){
  $array=array();
  $forms=$this->db()->query2(array(),"plugin_forms",array('visible'=>1));
  if(count($forms)>0){
  foreach($forms as $form){
  $array[]=array('value'=>'index::'.$form['_id']->__toString(),'title'=>$form['title']);
  }
  }
  $category=$this->db()->query2(array(),"forms_category",array('visible'=>1));
    if(count($category)>0){
  foreach($category as $cat){
  $array[]=array('value'=>'c::index::'.$cat['_id']->__toString(),'title'=>"Категория ".$cat['title']);
   $array[]=array('value'=>'c::links::'.$cat['_id']->__toString(),'title'=>"Ссылки ".$cat['title']);
  }
  }

  return $array;
 }

}

