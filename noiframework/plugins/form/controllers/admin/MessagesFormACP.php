<?php

 use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\OneField;
use noicms\core\StrInput; 
class MessagesFormACP  extends CoreAdminControllerPlugin{
  public $collections=array('plugin_form_messages');
 public function __construct($site) {
     parent::__construct('form',$site);
 }
public function actionChange($var=0){
  if(isset($var) and ($var==0 or $var==1)){
      $array_update=array();
      $array_update['visible']=(int)$var;
      if(isset($_GET['id']) and StrInput::is_Id($_GET['id'])){
      $this->db()->update($array_update,"plugin_form_messages",array('_id'=>new MongoId($_GET['id'])));
      $this->return_back();
      }
  }
 }
 public function actionIndex(){
    $site=$this->site_data;
   $grid=new MongoGrid("plugin_form_messages",10,0,"asd",'Формы',$this->getUrl('messages/index'));
     $fields=new GridField();


      $fields->setFields(array("name","comment"));
      $fields->setField("name", "string", "", array(),'Название',true, false);
      $fields->setField("comment", "guieditor", "", array(),'Комментарий',true, false);


      $fields->setField("site_id","hidden",$site['_id']->__toString(),array());
      $fields->not_show['visible']['list']=1;
       $fields->not_show['comment']['list']=1;
      $fields->showid=false;

      $grid->setFields($fields);
      //$grid->condition['site_id']=$site['_id']->__toString();
      $operation=new GridOperation();
      $denied_access=array();
      $available_access=array('list','delete','update');

      $operation->denied_access=$denied_access;

      $operation->available=$available_access;


      $operation->default_operation='list';

      $grid->setOperations($operation);
      $grid->view->option['controller']=$this;

      $grid->view->available['list']=  $this->getPluginPath('forms_list');
      $grid->view->available['delete']=$this->getPluginPath('standart_delete');
      $grid->view->available['update']=$this->getPluginPath('standart_update');
      $newdata=array('site'=>$site);

 return $grid->render();
 }

}

