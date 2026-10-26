<?php

use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
use mg\models\Collections;
class ManageMgACP  extends CoreAdminControllerPlugin{
 
 public function actionIndex($id_collection,$lang="null"){
     
   if(isset($id_collection) ){
   $collection=Collections::getManage($id_collection);
  
   if(!is_bool($collection)){
    NoiCore::app()->setParam("mg_manage_".$collection['name'],1);   
   $site=$this->site_data;
  if(!isset($lang) or (is_numeric($lang) and $lang==0)){
  $lang="";
  }
  if(strlen($lang)==0){
 $lang="null";    
 }
 

 

$list_languages=NoiCore::app()->getListLanguges();
$suffix_field="";
$title_suffix=""; 
 if(in_array($lang, $list_languages)){
$suffix_field="_".$lang;  
$title_suffix="(".$lang.")";
}
   $array_fields=array();
   if(count($collection['fields'])==0){
    NoiCore::app()->redirect(NoiCore::app()->getRoute('p_mg/fields/index/'.$collection['_id']->__toString()));
    
       exit;
   }
   foreach($collection['fields'] as $kf=>$f){
    if(isset($f['multilang']) and $f['multilang']==1){   
      
   $array_fields[]=$kf; 
 
 
   if(strlen($suffix_field)>0){  
   $array_fields[]=$kf.$suffix_field;   
    }
  
    }else {
     $array_fields[]=$kf;       
    }
   }
   
   
 
    $grid=new MongoGrid($collection['name'],10,0,"asd",$collection['name']." ".$title_suffix,$this->getUrl('manage/index/'.$id_collection."/".$lang));
    if((int)$collection['count_on_page']>0){
    $grid->page_item=(int)$collection['count_on_page'];
    }
     
    if($collection['sort']==="-1"){
        
      $sort=array($collection['sort_field']=>-1);    
      }else {
      $sort=array($collection['sort_field']=>1);    
      }   
     $grid->sort=$sort;
    $fields=new GridField();
    $array_fields[]="meta_title".$suffix_field;
    $array_fields[]="meta_description".$suffix_field;
    $array_fields[]="meta_keywords".$suffix_field;
    $fields->setFields($array_fields);
 foreach($collection['fields'] as $kf=>$f){
 if(isset($f['multilang']) and $f['multilang']==1){
  $fields->setField($kf, $f['type'], $f['default'], $f['json'], $f['title'],$f['required'], $f['unique']);  
     if(strlen($suffix_field)>0){  
  $fields->setField($kf.$suffix_field, $f['type'], $f['default'], $f['json'], $f['title'].$title_suffix,$f['required'], $f['unique']);  
     }
 }else {
  $fields->setField($kf, $f['type'], $f['default'], $f['json'], $f['title'],$f['required'], $f['unique']);  
    
 }    
   }

      $fields->setField("meta_title".$suffix_field,"string","",array(),"meta title");
      $fields->setField("meta_description".$suffix_field,"textarea","",array(),"meta description");
      $fields->setField("meta_keywords".$suffix_field,"textarea","",array(),"meta keywords");
 
  
      $fields->showid=false;
       foreach($collection['fields'] as $kf=>$f){
           
       if($f['showinlist']==0){
        if(isset($f['multilang']) and $f['multilang']==1){ 
       $fields->not_show[$kf]['list']=1;   
          if(strlen($suffix_field)>0){  
       $fields->not_show[$kf.$suffix_field]['list']=1;    
          }
        }else {
         $fields->not_show[$kf]['list']=1;        
        }
       }    
       }
      $fields->not_show['site_id']['list']=1;
      $fields->not_show['meta_title'.$suffix_field]['list']=1;
      $fields->not_show['meta_keywords'.$suffix_field]['list']=1;
      $fields->not_show['meta_description'.$suffix_field]['list']=1;
      $grid->setFields($fields);
      $grid->condition=array();
      $operation=new GridOperation();
      $denied_access=array();
      $available_access=array('clone','list','update','delete',"create");

      $operation->denied_access=$denied_access;

      $operation->available=$available_access;


      $operation->default_operation='list';

      $grid->setOperations($operation);
      $grid->view->option['controller']=$this;
      $grid->view->option['sort']=$grid->sort;
      $grid->view->option['collection']=$collection;
      $grid->view->option['languages']=$list_languages;
      $grid->view->option['title_suffix']=$title_suffix;
      $grid->view->option['url_to_lang']=$this->getUrl('manage/index/'.$id_collection."/");
      $grid->view->available['list']=  $this->getPluginPath('category_list');
      $grid->view->available['update']=$this->getPluginPath("standart_update");
      $grid->view->available['delete']=$this->getPluginPath('standart_delete');
      $grid->view->available['create']= $this->getPluginPath('standart_create');
      $newdata=array('site'=>$site);

 return $grid->render();    
   }   
 }
 }
 
}

