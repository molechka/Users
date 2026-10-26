<?php
use noicms\mongogrid\OneField;

 
use noicms\core\StrInput; 
class FormFCP extends CoreFrontendControllerPlugin {
public $result_fields=array();
    public function __construct($route,&$cur) {

        parent::__construct("form",$cur,$route);

    }
     public function byPrefix($prefix){
    $data=array();
    $data['all']=NoiCore::app()->db()->query2(array(),"plugin_forms",array('prefix'=>$prefix));
    return $this->render("byprefix",$data);
    }
    public function getMessages($rows){
     $new_result=array();
    if(count($rows)>0){
     foreach($rows as $row){
     $array=array();
     if(count($row['fields'])>0){
     foreach($row['fields'] as $field){
     $array[$field['name']]=$field['value'];
     }
     }

     if(count($array)>0){
     if(isset($row['comment'])){
     $array['admin_comment']=$row['comment'];
     }else {
     $array['admin_comment']="";
     }
     $new_result[]=$array;

     }
     }
    }
return $new_result;
    }
    public function preParse($val){
        if(!NoiCore::lang()->is()){
       return $val;
     }
       
     $cur_lang=NoiCore::app()->getLang();
     if(isset($val['title_'.$cur_lang])){
        
     $val['title']=$val['title_'.$cur_lang];
     } 
      if(isset($val['description_'.$cur_lang])){
        
     $val['description']=$val['description_'.$cur_lang];
     } 
     if(isset($val['meta_keywords_'.$cur_lang])){
        
     $val['meta_keywords']=$val['meta_keywords_'.$cur_lang];
     } 
      if(isset($val['meta_description_'.$cur_lang])){
        
     $val['meta_description']=$val['meta_description_'.$cur_lang];
     } 
        if(isset($val['before_'.$cur_lang])){
        
     $val['before']=$val['before_'.$cur_lang];
     } 
      if(isset($val['after_'.$cur_lang]) ){
        
     $val['after']=$val['after_'.$cur_lang];
     } 
      if(isset($val['notify_success_'.$cur_lang]) ){
        
     $val['notify_success']=$val['notify_success_'.$cur_lang];
     } 
       if(isset($val['notify_error_'.$cur_lang]) ){
        
     $val['notify_error']=$val['notify_error_'.$cur_lang];
     } 
     
     
         
     return $val;    
     }
    public function actionIndex($id_form){
      if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('visible'=>1,'_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id']) and count($form[0]['fields'])>0){
$form=$form[0];
$form=$this->preParse($form);
$new_array=array();
foreach($form['fields'] as $field){
$new_array[$field['name']]=$field;    
}
$form['fields']=$new_array;
$data=array('form'=>$form); 
$data['fields']=$new_array;
$data['after']="";
$data['before']="";
$data['m']=$this->getMessages($this->db()->query(array(),"plugin_form_messages",array('id_form'=>$id_form,'visible'=>1),array('_id'=>-1),10,NoiCore::c("ppaginator")->getOffset(10)));
$data['count_m']=$this->db()->count("plugin_form_messages",array('id_form'=>$id_form,'visible'=>1));

$data['paginator']=NoiCore::c("ppaginator")->show($data['count_m'],10,$this->getRoute($id_form));
if(isset($form['after'])){
$data['after']=$form['after'];
}
if(isset($form['before'])){
$data['before']=$form['before'];
}
 $data['iscaptcha']=0;
 if(isset($form['captcha']) and $form['captcha']==1){
 
$data['captcha']=NoiCore::c("captcha")->get("noicms_captcha_form_".$form['_id']->__toString());
$data['iscaptcha']=1;
 }

if($this->iswidget==0){
if(isset($form['title'])){
 $this->setTitle($form['title']);
}
 if(isset($form['meta_keywords'])){
 NoiCore::app()->setParam("keywords",$form['meta_keywords']);
}
if(isset($form['meta_description'])){
 NoiCore::app()->setParam("description",$form['meta_description']);
}
}
if(isset($form['prefix']) and strlen($form['prefix'])>0){
   
$data['messages']=$this->render($form['prefix']."_messages",$data);
 
return $this->render($form['prefix']."_form",$data);

}else {
return $this->render("form",$data);
}
 }
      }
    }
    public function actionAjax($id_form){
    $result_json=array();    
    if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('visible'=>1,'_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id'])){
 $form=$form[0];
 $form=$this->preParse($form);
 if(isset($form['fields']) and count($form['fields'])>0){
 $form['fields']=$this->getFields($form['fields']);
 $check=$this->checkFields($form['fields']);
 
 if(isset($form['captcha']) and $form['captcha']==1){

 if(isset($_POST['noicms_captcha'])){
     
 $result_captcha=NoiCore::c("captcha")->check("noicms_captcha_form_".$form['_id']->__toString(),$_POST['noicms_captcha']);
 }else {
 $result_captcha=false;
 }
 }else {
 $result_captcha=true;
 }
 if($result_captcha==false){
  $check['success']=0;
  $check['message']="captcha not valid";
 }
 if($check['success']==0){
 $data['id_form']=$id_form;
 if(isset($form['notify_error'])){
 $data['message']=$form['notify_error'];
 $data['message']=str_replace("[error]",$check['error_text'],$data['message']);
 $result_json=array('type'=>"error","message"=>$data['message']);
 }
 }else {
  if(isset($form['notify_success'])){
 $array_insert=array();
 $array_insert['_id']=new MongoId();
 $array_insert['name']=$form['title'];
 $array_insert['id_form']=$id_form;
 $array_insert['date']=new MongoDate();
 
 $array_insert['fields']=$this->result_fields;
 
 $this->db()->insert($array_insert,"plugin_form_messages");

  $data['message']=$form['notify_success'];
 $result_json=array('type'=>"success","message"=>$data['message']);
 if(isset($form['sendonemail']) and $form['sendonemail']==1 and  isset($form['sendemail']) and filter_var($form['sendemail'],FILTER_VALIDATE_EMAIL)){
  $result_html=$this->render("message_html",array('message'=>$array_insert,'form'=>$form)); 
  NoiCore::app()->email($form['sendemail'],"Новое сообщение из формы ".$form['title'],$result_html);
 }
  }
 }
 }
 }
    }
    echo json_encode($result_json);
    exit;
    }
   public function actionSend($id_form){
    if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('visible'=>1,'_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id'])){
 $form=$form[0];
 $form=$this->preParse($form);
 if(isset($form['fields']) and count($form['fields'])>0){
 $form['fields']=$this->getFields($form['fields']);
 $check=$this->checkFields($form['fields']);
 
  if(isset($form['captcha']) and $form['captcha']==1){

 if(isset($_POST['noicms_captcha'])){

 $result_captcha=NoiCore::c("captcha")->check("noicms_captcha_form_".$form['_id']->__toString(),$_POST['noicms_captcha']);
 }else {
 $result_captcha=false;
 }
 }else {
 $result_captcha=true;
 }
 if($result_captcha==false){
  $check['success']=0;
  $check['error_text']="captcha not valid";
 }
 if($check['success']==0){
 $data['id_form']=$id_form;
 if(isset($form['notify_error'])){
 $data['message']=$form['notify_error'];
 $data['message']=str_replace("[error]",$check['error_text'],$data['message']);
 return $this->render("status_error",$data);
 }
 }else {
  if(isset($form['notify_success'])){
 $array_insert=array();
 $array_insert['_id']=new MongoId();
 $array_insert['name']=$form['title'];
 $array_insert['id_form']=$id_form;
 $array_insert['date']=new MongoDate();
 
 $array_insert['fields']=$this->result_fields;
 
 $this->db()->insert($array_insert,"plugin_form_messages");
  $data['message']=$form['notify_success'];
   if(isset($form['sendonemail']) and $form['sendonemail']==1 and  isset($form['sendemail']) and filter_var($form['sendemail'],FILTER_VALIDATE_EMAIL)){
  $result_html=$this->render("message_html",array('message'=>$array_insert,'form'=>$form)); 
  NoiCore::app()->email($form['sendemail'],"Новое сообщение из формы ".$form['title'],$result_html);
 }
 return $this->render("status_success",$data);
  }
 }
 }
 }
    }
   }
    public function getFields($all_fields){

    $result=array();
    if(isset($all_fields) and count($all_fields)>0){
    foreach($all_fields as $key=>$field){


    $field['render']=new OneField();
    $opt=array();

    $json_opt=  json_decode($field['json_opt'],true);
    if($json_opt!=NULL and  is_array($json_opt)){
    $opt=$json_opt;
    }

    $field['render']->init($field['name'], $field['type'], $opt);
    //$result[$field['name']]=$field;
    $all_fields[$key]['render']=$field['render'];

    }
    }
    
    return $all_fields;
    }
   public function checkFields($fields){


    $result_array=array();
    if(is_array($fields) and count($fields)>0){
       foreach($fields as $key_field=>$field){
        $name_field=$field['name'];
      
       if($field['required']==1 or $field['required']=="1"){
       if(!isset($_POST["field_".$name_field]) and !isset($_FILES["field_".$name_field])){

      

        return array('success'=>0,'error_text'=>"Поле ".$field['label']." обязательно для заполнения");
       }else {

       }
       }


       if(isset($_POST["field_".$name_field]) and strlen($_POST["field_".$name_field])>0){
       
       $_POST[$field['render']->getName()]=$_POST["field_".$name_field];
       $tmp_result=$field['render']->setInput();
        
       if($tmp_result===false){
        return array('success'=>0,'error_text'=>"Поле ".$field['label']." неправильное значение поля");
       }else {
       $fields[$key_field]['value']=$tmp_result;
       $result_array[$key_field]=$tmp_result;
       }


       }else if(isset($_FILES["field_".$name_field])){
          
        
         $_FILES[$field['render']->getName()]=$_FILES["field_".$name_field];
       $tmp_result=$field['render']->setInput();
     
         
       
       if($tmp_result===false){
        return array('success'=>0,'error_text'=>"Поле ".$field['label']." неправильное значение поля");
       }else {
       $fields[$key_field]['value']=$tmp_result;    
       $result_array[$key_field]=$tmp_result;
       }     
       }  else {
    
if($field['required']==1){
    return array('success'=>0,'error_text'=>"Поле ".$field['label']." неправильное значение поля");
}else {
   $fields[$key_field]['value']=$field['default'];    
}
     
       }
      
      unset($fields[$key_field]['render']);
       }
       $this->result_fields=$fields;
       return array('success'=>1,'error_text'=>"");
    }
   }

}