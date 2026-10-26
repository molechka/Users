<?php

 use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use noicms\mongogrid\OneField;
class CategoryFormACP  extends CoreAdminControllerPlugin{
 
 public function __construct($site) {
     parent::__construct('form',$site);
 }
  public function actionIndex($i="null"){
 if(strlen($i)==0){
 $i="null";    
 }
$list_languages=NoiCore::app()->getListLanguges();
$suffix_field="";
$title_suffix=""; 
if(in_array($i, $list_languages)){
$suffix_field="_".$i;  
$title_suffix="(".$i.")";
}     
$site=$this->site_data;
    $grid=new MongoGrid("forms_category",10,0,"asd",NoiCore::app()->lang('contentc_name').$title_suffix,$this->getUrl('category/index/'.$i));
     $fields=new GridField();



      $fields->setFields(array("title".$suffix_field,"prefix","site_id","visible",'meta_description'.$suffix_field,"meta_keywords".$suffix_field));
      $fields->setField("title".$suffix_field, "translit", "", array(), NoiCore::app()->lang('contentc_title'),true, false);
      $fields->setField("prefix","string","",array(),NoiCore::app()->lang('contentc_template'),false,false);
      $fields->setField("site_id","hidden",$site['_id']->__toString(),array());
      $fields->setField("visible","hidden",1,array());
      $fields->setField("meta_description".$suffix_field,"textarea","",array(),NoiCore::app()->lang('content_field_description'));
      $fields->setField("meta_keywords".$suffix_field,"textarea","",array(),NoiCore::app()->lang('content_field_keywords'));
   
      $fields->showid=false;
      $fields->not_show['site_id']['list']=1;
      $fields->not_show['suffix']['list']=1;
      $fields->not_show['visible']['list']=1;
      $fields->not_show['meta_description']['list']=1;
      $fields->not_show['meta_keywords']['list']=1;
      $fields->not_show['size']['list']=1;
      $grid->setFields($fields);
      $grid->condition=array('site_id'=>$site['_id']->__toString());
      $operation=new GridOperation();
      $denied_access=array();
      $available_access=array();
      $denied_access=array();
      $available_access=array('clone','list','update','delete',"create");
 if($i=="null"){
      $denied_access=array();
      $available_access=array('clone','list','update','delete',"create");
      }else {
         $denied_access=array("create");
      $available_access=array('clone','list','update','delete',);
      }
      $operation->denied_access=$denied_access;

      $operation->available=$available_access;


      $operation->default_operation='list';

      $grid->setOperations($operation);
        $grid->view->option['controller']=$this;
          $grid->view->option['languages']=$list_languages;
      $grid->view->option['url_to_lang']=$this->getUrl('category/index/');
       $grid->view->available['list']=  $this->getPluginPath('category_list');
      $grid->view->available['update']=$this->getPluginPath("standart_update");
      $grid->view->available['delete']=$this->getPluginPath('standart_delete');
      $grid->view->available['create']= $this->getPluginPath('standart_create');
      $newdata=array('site'=>$site);

 return $grid->render();
 }
}


