<?php
 use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\OneField;
use noicms\core\StrInput; 
class ManageFormACP  extends CoreAdminControllerPlugin{
  public $collections=array('plugin_form_messages');
 public function __construct($site) {
     parent::__construct('form',$site);
 }

 public function actionChange($var=0){
  if(isset($var) and ($var==0 or $var==1)){
      $array_update=array();
      $array_update['visible']=(int)$var;
      if(isset($_GET['id']) and StrInput::is_Id($_GET['id'])){
      $this->db()->update($array_update,"plugin_forms",array('_id'=>new MongoId($_GET['id'])));
      $this->return_back();
      }
  }
 }
 public function actionDelete($id_form){
   if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id'])){
  if(isset($_GET['id']) and isset($form[0]['fields'][(int)$_GET['id']])){
  $array_update=array();
  $array_update['fields']=$form[0]['fields'];
  $count_fields=count($array_update['fields']);
  unset($array_update['fields'][(int)$_GET['id']]);
  if($count_fields>1){
  $array_update['fields']=  array_values($array_update['fields']);
  }else {
  $array_update['fields']=array();
  }
   $this->db()->update($array_update,"plugin_forms",array('_id'=>new MongoId($id_form)));
  $this->redirect($this->getRoute('manage/edit/'.$id_form));
  }
 }
   }
 }
 public function actionEdit2($id_form,$lang){
  if(strlen($lang)==0 or $lang=="0"){
 $lang="null";    
 }
$list_languages=NoiCore::app()->getListLanguges();
$suffix_field="";
$title_suffix=""; 
if(in_array($lang, $list_languages)){
$suffix_field="_".$lang;  
$title_suffix="(".$lang.")";
}    
     
   if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('_id'=>new MongoId($id_form)));
  if(isset($form[0]['_id'])){
      $array_update=array();
      if(isset($_POST['title'.$suffix_field])){
      $array_update['title'.$suffix_field]=  strip_tags($_POST['title'.$suffix_field]);
      }
      if(isset($_POST['captcha'])){
      $array_update['captcha']=(int)$_POST['captcha'];
      }
      if(isset($_POST['prefix'])){
       $array_update['prefix']=strip_tags($_POST['prefix']);
      }
        if(isset($_POST['sendonemail'])){
       $array_update['sendonemail']=1;
      }else {
      $array_update['sendonemail']=0;    
      }
      if(isset($_POST['sendemail']) and filter_var($_POST['sendemail'],FILTER_VALIDATE_EMAIL)){
      $array_update['sendemail']= $_POST['sendemail'];   
      }
      if(isset($_POST['notify_success'.$suffix_field])){
       $array_update['notify_success'.$suffix_field]=$_POST['notify_success'.$suffix_field];
      }
       if(isset($_POST['notify_error'.$suffix_field])){
       $array_update['notify_error'.$suffix_field]=$_POST['notify_error'.$suffix_field];
      }
       if(isset($_POST['meta_keywords'.$suffix_field])){
       $array_update['meta_keywords'.$suffix_field]=$_POST['meta_keywords'.$suffix_field];
      }
       if(isset($_POST['meta_description'.$suffix_field])){
       $array_update['meta_description'.$suffix_field]=$_POST['meta_description'.$suffix_field];
      }
       if(isset($_POST['after'.$suffix_field])){
       $array_update['after'.$suffix_field]=$_POST['after'.$suffix_field];
      }
       if(isset($_POST['before'.$suffix_field])){
       $array_update['before'.$suffix_field]=$_POST['before'.$suffix_field];
      }

      if(count($array_update)>0){
        $this->db()->update($array_update,"plugin_forms",array('_id'=>new MongoId($id_form)));
  $this->redirect($this->getRoute('manage/edit/'.$id_form."/".$lang));
      }
  }
   }
 }
 public function getEmails($id_form){
 $messages=$this->db()->query(array(),"plugin_form_messages",array('fields.type'=>'email','id_form'=>$id_form));
 $emails=array();
 if(isset($messages[0]['_id'])){
foreach($messages as $message){
foreach($message['fields'] as $field){
if($field['type']=="email" and !in_array($field['value'],$emails)){
$emails[]=$field['value'];
}
}
}

 }
 return $emails;
 }
 public function actionSendemails($id_form){
  if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id'])){
 if(isset($_POST['email_subject']) and isset($_POST['email_text'])){
$emails=$this->getEmails($id_form);
if(count($emails)>0){
 foreach($emails as $email){
 NoiCore::app()->email($email,strip_tags($_POST['email_subject']),$_POST['email_text']);
 }
 $this->setNotify("Рассылка успешна!");
 $this->return_back();
}
 }
 }
  }
 }
 public function actionAdd($id_form){
 if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id'])){
 $form=$form[0];
 if(isset($_POST['act_add'])){
 if(isset($_POST['name']) and isset($_POST['label']) and isset($_POST['required'])){
  $type=new OneField();
  $type->init("type","type");
  $result_type=$type->setInput();
  if(!is_bool($result_type)){
  $field_array=array();
  $field_array['name']=strip_tags($_POST['name']);
  $field_array['label']=strip_tags($_POST['label']);
  $field_array['type']=$result_type;
  $field_array['required']=(int)$_POST['required'];
  if(isset($_POST['default'])){
  $field_array['default']=$_POST['default'];
  }else {
  $field_array['default']="";
  }
  if(isset($_POST['opt'])){
  $field_array['json_opt']=$_POST['opt'];
  }else {
  $field_array['json_opt']="";
  }
  $array_update['fields']=array();
  if(isset($form['fields'])){
  $array_update['fields']=$form['fields'];
  }
  $array_update['fields'][]=$field_array;
  $this->db()->update($array_update,"plugin_forms",array('_id'=>new MongoId($id_form)));
  $this->redirect($this->getRoute('manage/edit/'.$id_form));
  }
 }
 }
 }
 }
 }
 public function actionEdit($id_form,$lang="null"){
  
if(strlen($lang)==0 or $lang=="0"){
 $lang="null";    
 }
$list_languages=NoiCore::app()->getListLanguges();
$suffix_field="";
$title_suffix=""; 
if(in_array($lang, $list_languages)){
$suffix_field="_".$lang;  
$title_suffix="(".$lang.")";
}     
if(isset($id_form) and StrInput::is_Id($id_form)){
 $form=$this->db()->query(array(),"plugin_forms",array('_id'=>new MongoId($id_form)));
 if(isset($form[0]['_id'])){
   $data=array('form'=>$form[0]);
   if(isset($form[0]['prefix']) and strlen($form[0]['prefix'])>0){
   $data['name_file']=$form[0]['prefix'].'_form.php';
   }else {
   $data['name_file']='form.php';
   }
   $html="";
   if(isset($form[0]['fields']) and count($form[0]['fields'])>0){
   $html="<h2>".$form[0]['title']."</h2>";
   $field_html="<form action='/form/send/".$id_form.".html' method='POST' enctype='multipart/form-data'><table class='table'>";
   foreach($form[0]['fields'] as $field){
   $field_html.="<tr><td>".$field['label']."</td><td><input type='text' name='field_".$field['name']."'></td></tr>";
   }
    $field_html.="<tr><td></td><td><input type='submit' name='act_send' value='Отправить'></td></tr>";
    $field_html.='</table></form>';
    $html.=$field_html;
   }
   $data['html']=$html;
   $data['languages']=$list_languages;;
   $data['suffix_field']=$suffix_field;
   $data['lang']=$lang;
 
   $data['tittle_suffix']=$title_suffix;
   $data['messages']=$this->db()->query2(array(),"plugin_form_messages",array('id_form'=>$id_form));

 return $this->render("form_edit",$data);
 }

}
 }

 public function actionIndex($i=0){
    $site=$this->site_data;
     $title=NoiCore::app()->lang('form_name');

  if(isset($i) and StrInput::is_Id($i)){
  $category=$this->db()->query(array(),"forms_category",array('_id'=>new MongoId($i)));
  if(isset($category[0]['_id'])){
 $title=$category[0]['title']." ".$title;

  }
  }
   $grid=new MongoGrid("plugin_forms",10,0,"asd",$title,$this->getUrl('manage/index/'.$i));
     $fields=new GridField();


      $fields->setFields(array("title","visible","category"));
      $fields->setField("title", "string", "", array(),NoiCore::app()->lang('form_title'),true, false);
      $fields->setField("visible","hidden",(int)1,array(),"Видимость");
   if(isset($i) and StrInput::is_Id($i)){
     $fields->setField("category","hidden",$i);
     $grid->condition=array('category'=>$i);
     }else {
      $fields->setField("category","select","",array('collection'=>'forms_category','condition'=>array(),'select'=>array('title')));
     }

      $fields->setField("site_id","hidden",$site['_id']->__toString(),array());
      $fields->not_show['visible']['list']=1;
      $fields->showid=false;

      $grid->setFields($fields);
      //$grid->condition['site_id']=$site['_id']->__toString();
      $operation=new GridOperation();
      $denied_access=array();
      $available_access=array('clone','list','delete',"create");

      $operation->denied_access=$denied_access;

      $operation->available=$available_access;


      $operation->default_operation='list';

      $grid->setOperations($operation);
      $grid->view->option['controller']=$this;
     
      $grid->view->available['list']=  $this->getPluginPath('forms_list');
      $grid->view->available['delete']=$this->getPluginPath('standart_delete');
      $grid->view->available['create']= $this->getPluginPath('standart_create');
      $newdata=array('site'=>$site);

 return $grid->render();
 }

}

