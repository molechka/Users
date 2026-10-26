<?php
use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\OneField;
use noicms\core\StrInput; 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserACP
 *
 * @author backdoor
 */
class UserACP  extends CoreAdminControllerPlugin{
 public $name_collection="user_sites_users";
 public function __construct($site) {
     parent::__construct('user',$site);
 }
  public function menu_get_widgets($value="0"){
  $array=array();
  $array[0]=array('value'=>'register::index','title'=>'Показать форму регистрации');
  $array[1]=array('value'=>'status','title'=>'Форма входа или панель пользователя');
  $array[]=array('value'=>'widget::last::6','title'=>'последние пользователи');
  return $array;
  }
 public function getRoles(){
 $value=$this->get_value('roles');
 $result_array=array();
 if(isset($value) and count($value)>0){
 foreach($value as $val){
 if(isset($val['name'])){
 $result_array[]=array('title'=>$val['name'],'value'=>$val['name']);
 }
 }
 }
 return $result_array;
 }
 public function getOpt($op="list"){
  if(isset($op) and ($op=="list" or $op=="array")){
  $fields=$this->get_value('fields');
  if($op=="list"){
  if(count($fields)>0){
   $result_array=array();
   foreach($fields as $field){
   if(isset($field['name']) and isset($field['is_password']) and $field['is_password']!=1){
  if($field['name']!="finance"){
   $opt=array();
    $json_opt=  json_decode($field['opt'],true);
    if($json_opt!=NULL and  is_array($json_opt)){
    $opt=$json_opt;
    }
   $result_array[$field['name']]=$opt;
  }
   }
   }
   return $result_array;
  }else {
   return array();
  }
  }
  }else {
     return array();
  }
 }

 public function getLogin(){
 $fields=$this->get_value('fields');
 $result_field="";
  if(count($fields)>0){
   $result_array=array();
   foreach($fields as $field){
   if(isset($field['is_login']) and $field['is_login']==1 and $field['is_password']!=1){
  $result_field=$field['name'];
   }
   }
   if($result_field==""){
   if(isset($fields[0]['name'])){
    $result_field=$fields[0]['name'];
   }
   }
   return $result_field;
  }
 }
 public function getPassword(){
  $fields=$this->get_value('fields');
 $result_field="";
  if(count($fields)>0){
   $result_array=array();
   foreach($fields as $field){
   if(isset($field['is_password']) and $field['is_password']==1){
   return $field;
   break;
   }
   }
   
  }
 }
 public function generateFields($op="list"){
  if(isset($op) and ($op=="list" or $op=="array")){
  $fields=$this->get_value('fields');
  if($op=="list"){
  if(count($fields)>0){
   $result_array=array();
   foreach($fields as $field){
   if(isset($field['name']) and isset($field['is_password']) and $field['is_password']!=1){
  if($field['name']!="finance"){
   $result_array[]=$field['name'];
  }
   }
   }
   return $result_array;
  }else {
   return array();
  }
  }
  }else {
     return array();
  }
 }
 public function createUser(){
  $main=$this->get_value();
 $fields_array=$this->get_value('fields');
 if(isset($main[0]['collection']) and strlen($main[0]['collection'])>3){
 $this->name_collection=$main[0]['collection'];
 }
 $field_mg=array();
 $field_list=array();
 $is_create=0;
 if(isset($_POST['act_create'])){
 $is_create=1;
 }
 $array_insert=array();
 $complete=0;
 $result_parse=3;
 $roles=$this->getRoles();
 $fields_array[]=array('type'=>'multiselect','label'=>'User Role','name'=>'role','required'=>1,'unique'=>0,'default_status'=>0,'default'=>'','opt'=>array('data'=>$roles));
  
 if(isset($fields_array) and count($fields_array)>0){
  foreach($fields_array as $field){
      if(isset($field['type']) and isset($field['name']) ){
    $tmp_obj=new OneField();
    $opt=array();
   
    if(isset($field['opt']) and is_string($field['opt'])){
        
    $opt=json_decode($field['opt'],true);
 
   
    if(is_null($opt)){
    $opt=array();    
    }
    }else if($field['opt'] and is_array($field['opt'])){
    $opt=$field['opt'];    
    }
    
    
    $tmp_obj->init($field['name'], $field['type'],$opt);
    $field_mg[]=array('obj'=>$tmp_obj,'field'=>$field);
     
    if($is_create==1 and ($result_parse==1 or $result_parse==3)){
        
     $tmp_result=$tmp_obj->setInput();

     if($tmp_result===false){
       if(isset($field['default_status']) and $field['default_status']==1 and isset($field['default'])){
      $array_insert[$field['name']]=$field['default'];
      $result_parse=1;
     }else {
      if(isset($field['required']) and $field['required']==1){
      $result_parse=0;
      }else {
      $array_insert[$field['name']]="";
      $result_parse=1;
      }
     }
  
    
     }else {
     $array_insert[$field['name']]=$tmp_result;
     $result_parse=1;
     }
   if(isset($field['unique']) and $result_parse==1 and $field['unique']==1 and isset($array_insert[$field['name']])){
   $count=$this->db()->query(array(),$this->name_collection,array($field['name']=>$array_insert[$field['name']]));
   if($count==1){
   $result_parse=0;
   }
   }
    }
      }  
  }   
 }
 
 if($result_parse==1){
  $array_insert['blocked']=0;
  $array_insert['enable_account']=1;
  $this->db()->insert($array_insert,$this->name_collection);
  $this->redirect($this->getRoute('users'));
 }
 return $this->render("create_user",array('fields'=>$field_mg,'error'=>$result_parse));
 }
 public function actionView($id_user){
  if(isset($id_user) and StrInput::is_Id($id_user)){
   $main=$this->get_value();
 $fields_array=$this->get_value('fields');
 if(isset($main[0]['collection']) and strlen($main[0]['collection'])>3){
 $this->name_collection=$main[0]['collection'];
 }
 $result=$this->db()->query(array(),$this->name_collection,array('_id'=>new MongoId($id_user)));
 $password_field=$this->getPassword();
 if(isset($password_field) and is_array($password_field) and isset($password_field['name']) and isset($password_field['type'])){
 $tmp_obj=new OneField();
  $opt=array();
 if(isset($password_field['opt']) and is_array($password_field['opt'])){
$opt=$password_field['opt'];
 }
    $tmp_obj->init($password_field['name'], $password_field['type'],$opt);
    $password_field['obj']=$tmp_obj;
    if(isset($_POST['act_changepw'])){
    $tmp_new_result=$tmp_obj->setInput();
  
    if($tmp_new_result===false){

    }else {
    $array_update['password']=$tmp_new_result;
    $this->db()->update($array_update,$this->name_collection,array('_id'=>new MongoId($id_user)));
    $this->setNotify("Пароль успешно обновлен!");
    }
    }
 }
 if(isset($result[0]['_id'])){
 return $this->render("view_user",array('user'=>$result[0],'password_field'=>$password_field));
 }
  }
 }
 public function actionUsers($current_op="list"){
 if(isset($current_op) and $current_op=="create"){
  return $this->createUser();
 }
 $main=$this->get_value();
 $fields_array=$this->get_value('fields');
 if(isset($main[0]['collection']) and strlen($main[0]['collection'])>3){
 $this->name_collection=$main[0]['collection'];
 }
   $site=$this->site_data;
   $grid=new MongoGrid($main[0]['collection'],10,0,"asd",'Manage Users',$this->getRoute('users'));
     $fields=new GridField();
     $list_fields=$this->generateFields("list");
     $opt_fields=$this->getOpt("list");

     $roles=$this->getRoles();
     $list_fields[]="site_id";
     $list_fields[]="role";
     $list_fields[]="blocked";


      $fields->setFields($list_fields);
     
      if(isset($fields_array) and count($fields_array)>0){
       foreach($fields_array as $field){
        
         if(isset($field['type']) and isset($field['name']) and isset($field['is_password']) and $field['is_password']!=1){
  $required=false;
  $unique=false;
  $label=$field['name'];
  if(isset($field['label'])){
  $label=$field['label'];
  }
  if(isset($field['required']) and $field['required']==1){
  $required=true;
  }
  if(isset($field['unique']) and $field['unique']==1){
  $required=false;
  }
  $default_value="";
  if(isset($field['default_status']) and $field['default_status']==1 and isset($field['default']) and strlen($field['default'])>1){
  $default_value=$field['default'];
  }
 
  $opt=array();
 if(isset($opt_fields[$field['name']])){
 $opt=$opt_fields[$field['name']];
 }
  $fields->setField($field['name'], $field['type'], $default_value, $opt, $label,$required,$unique);
   }
       }
      }
        $blocked_array=array(
      array('value'=>'0','title'=>'No Blocked'),
      array('value'=>'1','title'=>'Yes Blocked'),

      );
       $fields->setField("blocked", "select", '0', $blocked_array, 'Is Blocked?',true, false);
      $fields->setField("site_id", "hidden", $this->site_data['_id']->__toString(), array(), 'site_id',true, false);
        $fields->setField("role", "multiselect", "", array('data'=>$roles), 'Role User',true, false);
 
 $login_field=$this->getLogin();
 if(isset($list_fields) and count($list_fields)>0){
  foreach($list_fields as $nf){
   if($nf!=$login_field){
   $fields->not_show[$nf]['list']=1;
   }
  }
 }
//      $fields->not_show['site_id']['list']=1;
//      $fields->not_show['full']['list']=1;
//      $fields->not_show['anonce']['list']=1;
//      $fields->not_show['entry_date']['list']=1;
      $fields->showid=true;
    $grid->setFields($fields);
//
     $operation=new GridOperation();
     $denied_access=array();
     $available_access=array('list','update','delete');
     $operation->denied_access=$denied_access;
    $operation->available=$available_access;
    $operation->default_operation='list';
      $grid->setOperations($operation);
 
    $grid->view->available['list']=  $this->getPluginPath("standart_list");
     $grid->view->available['update']=$this->getPluginPath("standart_update");
     $grid->view->available['create']= $this->getPluginPath('standart_create');
     $grid->view->options['controller']=$this;
     $newdata=array('site'=>$site);
return $grid->render();

 }
}