<?php
use noicms\mongogrid\MongoGrid;
use noicms\mongogrid\system_core\GridField;
use noicms\mongogrid\system_core\GridOperation;
class CollectionsMgACP  extends CoreAdminControllerPlugin{
 
 public function actionIndex($lang="null"){
   if(!isset($lang) or (is_numeric($lang) and $lang==0)){
  $lang="";
  }
  if(strlen($lang)==0){
 $lang="null";    
 }
 

 
NoiCore::app()->setParam("mg_manage",1);
$list_languages=NoiCore::app()->getListLanguges();
$suffix_field="";
$title_suffix=""; 
 if(in_array($lang, $list_languages)){
$suffix_field="_".$lang;  
$title_suffix="(".$lang.")";
}   
   $site=$this->site_data;
    $grid=new MongoGrid("collections_list",10,0,"asd",'Список коллекций '.$title_suffix."",$this->getUrl('collections/index/'.$lang));
      $fields=new GridField();


   if(strlen($suffix_field)>0){  
    $fields->setFields(array("name","canadduser","canaddguest","title","icon","count_on_page","sort","sort_field","condition","description","description".$suffix_field,'canchange',"meta_title","meta_title".$suffix_field,"meta_description","meta_description".$suffix_field,"meta_keywords","meta_keywords".$suffix_field));
      $fields->setField("name", "username", "", array(), 'Name collection',true, false);  
      $fields->setField("canadduser","checkbox","",array(),"Может добавлять пользователь?");
      $fields->setField("canaddguest","checkbox","",array(),"Может добавлять гость?");
      $fields->setField("title","string","",array(),"Название");
      $fields->setField("icon", "rimage", "", array('images'=>array(array('resize_type'=>'auto','width'=>32,'height'=>32))), 'Иконка(32x32)',true, false);  
      $fields->setField("count_on_page","int",10,array(),"count on page");
      $fields->setField("sort","select","-1",array(array('value'=>"-1","title"=>"-1"),array('value'=>"1","title"=>"1")),"sort");
      $fields->setField("sort_field","string","_id",array(),"sort field");
      $fields->setField("condition","textarea","{}",array(),"condition");
      $fields->setField("description","guieditor","",array(),"Описание"); 
      $fields->setField("description".$suffix_field,"guieditor","",array(),"Описание ".$title_suffix); 
      $fields->setField("canchange","checkbox","",array(),"Запретить изменить meta?");
      $fields->setField("meta_title","string","",array(),"meta title");
       $fields->setField("meta_title".$suffix_field,"string","",array(),"meta title" .$title_suffix);
      $fields->setField("meta_description","textarea","",array(),"meta description");
      $fields->setField("meta_description".$suffix_field,"textarea","",array(),"meta description ".$title_suffix);
      $fields->setField("meta_keywords","textarea","",array(),"meta keywords");
      $fields->setField("meta_keywords".$suffix_field,"textarea","",array(),"meta keywords ".$title_suffix);
 
  
      $fields->showid=false;
      $fields->not_show['site_id']['list']=1;
      $fields->not_show['suffix']['list']=1;
      $fields->not_show['canadduser']['list']=1;
      $fields->not_show['canaddguest']['list']=1;
        $fields->not_show['icon']['list']=1;
      $fields->not_show['title']['list']=1;
      $fields->not_show['sort']['list']=1;
       $fields->not_show['sort_field']['list']=1;
       $fields->not_show['condition']=1;
      $fields->not_show['visible']['list']=1;
      $fields->not_show['fields']['list']=1;
      $fields->not_show['description']['list']=1;
      $fields->not_show['meta_title']['list']=1;
       $fields->not_show['canchange']['list']=1;
      $fields->not_show['meta_description']['list']=1;
      $fields->not_show['meta_keywords']['list']=1;    
        $fields->not_show['description'.$suffix_field]['list']=1;
      $fields->not_show['meta_title'.$suffix_field]['list']=1;
      $fields->not_show['meta_description'.$suffix_field]['list']=1;
      $fields->not_show['meta_keywords'.$suffix_field]['list']=1;  
   }else {
      $fields->setFields(array("name","canadduser","canaddguest","title","icon","count_on_page","sort","sort_field","condition","canchange","description","meta_title","meta_description","meta_keywords"));
      $fields->setField("icon", "rimage", "", array('images'=>array(array('resize_type'=>'auto','width'=>32,'height'=>32))), 'Иконка(32x32)',true, false);  
      $fields->setField("title","string","",array(),"Название");
      $fields->setField("name", "username", "", array(), 'Name collection',true, false); 
      $fields->setField("canadduser","checkbox","",array(),"Может добавлять пользователь?");
      $fields->setField("canaddguest","checkbox","",array(),"Может добавлять гость?");
      $fields->setField("count_on_page","int",10,array(),"count on page");
      $fields->setField("sort","select","-1",array(array('value'=>"-1","title"=>"-1"),array('value'=>"1","title"=>"1")),"sort");
      $fields->setField("sort_field","string","_id",array(),"sort field");
      $fields->setField("condition","textarea","{}",array(),"condition");
      $fields->setField("canchange","checkbox","",array(),"Запретить изменить meta?");
      $fields->setField("description","guieditor","",array(),"Описание"); 
      $fields->setField("meta_title","string","",array(),"meta title");
      $fields->setField("meta_description","textarea","",array(),"meta description");
      $fields->setField("meta_keywords","textarea","",array(),"meta keywords");
 
  
      $fields->showid=false;
      $fields->not_show['site_id']['list']=1;
      $fields->not_show['suffix']['list']=1;
      $fields->not_show['canadduser']['list']=1;
      $fields->not_show['canaddguest']['list']=1;
      $fields->not_show['icon']['list']=1;
      $fields->not_show['title']['list']=1;
      $fields->not_show['sort']['list']=1;
       $fields->not_show['sort_field']['list']=1;
      $fields->not_show['visible']['list']=1;
      $fields->not_show['fields']['list']=1;
      $fields->not_show['condition']['list']=1;
      $fields->not_show['description']['list']=1;
       $fields->not_show['canchange']['list']=1;
      $fields->not_show['meta_title']['list']=1;
      $fields->not_show['meta_description']['list']=1;
      $fields->not_show['meta_keywords']['list']=1;
   }
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
          $grid->view->option['languages']=$list_languages;
      $grid->view->option['title_suffix']=$title_suffix;
      $grid->view->option['url_to_lang']=$this->getUrl('collections/index/');
      $grid->view->available['list']=  $this->getPluginPath('category_list');
      $grid->view->available['update']=$this->getPluginPath("standart_update");
      $grid->view->available['delete']=$this->getPluginPath('standart_delete');
      $grid->view->available['create']= $this->getPluginPath('standart_create');
      $newdata=array('site'=>$site);

 return $grid->render();
 }
 
 
}
