<?php
use noicms\mongogrid\OneField;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Widgets
 *
 * @author backdoor
 */
class Widgets {
   public function getWidgets(){
    $site=NoiCore::app()->site_data;
    if(isset($site['theme_components']['widgets']['position'])){
    return $site['theme_components']['widgets']['position'];
    }else {
        return array();
    }
   }
   public function getAvailables($name_plugin){
  $site=NoiCore::app()->site_data;
if(isset($site['theme_components']['plugins'])){
    $default_op=0;
    if(isset($_GET['default_op'])){
    $default_op=$_GET['default_op'];
    }

require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/CoreAdminControllerPlugin.php";
     $data['result']=array();
     if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".  ucfirst($name_plugin)."ACP.php")){

          require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".  ucfirst($name_plugin)."ACP.php";
      $name_class=ucfirst($name_plugin)."ACP";
      $admin_class=new $name_class($site);

      if(method_exists($admin_class, "menu_get_widgets")){
      $data['result']=$admin_class->menu_get_widgets($default_op);

      if(!is_array($data['result'])){
       $data['result']=array();
      }
      }
     }
     else  if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".  ucfirst($name_plugin)."AdminControllerPlugin.php")){
      require_once YII_PLUGIN_PATH."".$name_plugin."/controllers/admin/".  ucfirst($name_plugin)."AdminControllerPlugin.php";
      $name_class=ucfirst($name_plugin)."AdminControllerPlugin";
      $admin_class=new $name_class($site);

      if(method_exists($admin_class, "menu_get_widgets")){
      $data['result']=$admin_class->menu_get_widgets($default_op);

      if(!is_array($data['result'])){
       $data['result']=array();
      }
      }
      }

   echo NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/widget/widgets_links.php", $data);

}
   }
   public function doManagePositions(){
    $site=NoiCore::app()->site_data;
    if(!isset($site['theme_components']['widgets']['position'])){
    $site['theme_components']['widgets']['position']=array();
    }
     if(!isset($site['theme_components']['widgets']['positions_available'])){
    $site['theme_components']['widgets']['positions_available']=array();
    }
    if(isset($_GET['delete'])  and isset($site['theme_components']['widgets']['positions_available'][$_GET['delete']])){
     $array_update=array();
    $array_update['theme_components']=$site['theme_components'];
    $count=count($array_update['theme_components']['widgets']['positions_available']);
    unset($array_update['theme_components']['widgets']['positions_available'][$_GET['delete']]);
    if($count>1){
      $array_update['theme_components']['widgets']['positions_available']=  array_values($array_update['theme_components']['widgets']['positions_available']);
    }else {
    $array_update['theme_components']['widgets']['positions_available']=  array();

    }
//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
        NoiCore::json()->update($array_update);
    $site['theme_components']=$array_update['theme_components'];
    NoiCore::app()->redirect(NoiCore::app()->getRoute('wi/positions'));
    }
    if(isset($_POST['act_add_position'])){
    if(isset($_POST['position']) and strlen($_POST['position'])>0){
  $_POST['position']=strip_tags($_POST['position']) ;
    $_POST['position']= mb_strtolower($_POST['position']);
    $array_update=array();
    $array_update['theme_components']=$site['theme_components'];
    if(!in_array($_POST['position'],$array_update['theme_components']['widgets']['positions_available'])){
    $array_update['theme_components']['widgets']['positions_available'][]=$_POST['position'];
//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
        NoiCore::json()->update($array_update);
    $site['theme_components']=$array_update['theme_components'];
     NoiCore::app()->redirect(NoiCore::app()->getRoute('wi/positions'));
    }
    }
    }
    $data['site']=$site;

    $data['positions']=$site['theme_components']['widgets']['positions_available'];


    return NoiCore::app()->render(PATH_TO_ENGINE.'/vendor/noistudio/noiframework/core/modules/admin/views/widget/widgets_manage_positions.php', $data);
   }
   public function run($position,$number){
    
  $site=NoiCore::app()->site_data;
  if(!isset($site['theme_components']['widgets']['position'][$position][$number]['name'])){
      return "";
  }
 
//$site['theme_components']['widgets']['position'][$position][$number]['config']['mongogrid']
 if(file_exists(YII_PLUGIN_PATH."".$site['theme_components']['widgets']['position'][$position][$number]['name']."/config.php")){
  require_once YII_PLUGIN_PATH."".$site['theme_components']['widgets']['position'][$position][$number]['name']."/config.php";
   if(isset($plugin_config['mongogrid'])){
  $site['theme_components']['widgets']['position'][$position][$number]['config']['mongogrid']=$plugin_config['mongogrid'];     
   }
 }
 
  $name_plugin=$site['theme_components']['widgets']['position'][$position][$number]['name'];
 $field="default";
 $type_run="normal";
   if(isset($_GET['type_run'])){
 $type_run=$_GET['type_run'];
}
Yii::$app->params['type_run']=$type_run;
 if(isset($_GET['config_field'])){
  $field=$_GET['config_field'];
 }
  
 if(in_array($position,$site['theme_components']['widgets']['positions_available'])){

 }else {
    
    exit;
 }

 if(!isset($site['theme_components']['widgets']['position'][$position][$number])){
     
     exit;
 }
 
 if(isset($_GET['op_row']) and ($_GET['op_row']=="down" or $_GET['op_row']=="up")){

    if(isset($_GET['cur_key'])    and isset($site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_GET['cur_key']])){
   
   if($_GET['op_row']=="down"){

   $cur_key=$_GET['cur_key'];
   $prev=$cur_key+1;
 
   if(isset($site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$prev])){

  $array_update=array();
   $array_update['theme_components']=$site['theme_components'];

   $old_value=$site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$prev];
   $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$prev]=$site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$cur_key];
   $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$cur_key]=$old_value;
//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
        NoiCore::json()->update($array_update);
 
     NoiCore::app()->redirect(NoiCore::app()->getRoute("wi/".$position."/".$number));
    
   }
   }
   if($_GET['op_row']=="up"){

   $cur_key=$_GET['cur_key'];
   $prev=$cur_key-1;
   if(isset($site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$prev])){
  $array_update=array();
   $array_update['theme_components']=$site['theme_components'];

   $old_value=$site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$prev];
   $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$prev]=$site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$cur_key];
   $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$cur_key]=$old_value;

//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
       NoiCore::json()->update($array_update);
    $site['theme_components']=$array_update['theme_components'];
    if($type_run=="normal"){
 


    NoiCore::app()->redirect(NoiCore::app()->getRoute("wi/".$position."/".$number));
    }
   }
   }
    }
    }

if(isset($_POST['act_edit_widget'])){
    
 $array_new_upd=array();
 $array_new_upd['theme_components']=$site['theme_components'];
 if(isset($_POST['title']) and strlen($_POST['title'])>0){
$array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['title']=htmlspecialchars($_POST['title']);

 }
 if(isset($_POST['class']) and strlen($_POST['class'])>0){
$array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['class']=htmlspecialchars($_POST['class']);

 }
  if(isset($_POST['id']) and strlen($_POST['id'])>0){
$array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['id']=htmlspecialchars($_POST['id']);

 }
   if(isset($_POST['language']) and $_POST['language']!="all"){
     $array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['language']=$_POST['language'];
     }
 if(isset($_POST['visible_all']) and $_POST['visible_all']=="1"){
 $array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['visible_all']="1";
 }else {
   $array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['visible_all']="0";
 }
   $access_array=array();
  $access_array[0]=array('value'=>'all','title'=>'For All');
  $access_array[1]=array('value'=>'auth','title'=>'Auth');
  $access_array[2]=array('value'=>'noauth','title'=>'No Auth');

     $list_all_role=  NoiCore::app()->getListRoles();
       if(isset($list_all_role) and is_array($list_all_role) and count($list_all_role)>0){
       foreach($list_all_role as $s_role){
       $access_array[]=array('value'=>$s_role,'title'=>$s_role);
       }
       }
   $access_field=new OneField();
   $access_field->init("access", "select", $access_array);
   $array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['access']=$access_field->setInput();
  $visible_field=new OneField();
       $visible_field->init("visible", "multi", array('fields'=>array('link'=>array('type'=>'string','default_value'=>"",'opt'=>array(),'label'=>'URL Segment'))));
  $array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['visible']=$visible_field->setInput();
  $invisible_field=new OneField();
    $invisible_field->init("invisible", "multi", array('fields'=>array('link'=>array('type'=>'string','default_value'=>"",'opt'=>array(),'label'=>'URL Segment'))));
  $array_new_upd['theme_components']['widgets']['position'][$position][$number]['options']['invisible']=$invisible_field->setInput();
// MGQuery::update($array_new_upd, 'widget_user_sites',array('_id'=>new MongoId($site['_id']->__toString())));
     NoiCore::json()->update($array_new_upd);
      $site['theme_components']=$array_new_upd['theme_components'];
      //testhere
     
    //  NoiCore::app()->redirect(NoiCore::app()->getRoute('wi/'.$position."/".$number));
}

      if(!isset($site['theme_components']['widgets']['position'][$position][$number]['value'])){
      $site['theme_components']['widgets']['position'][$position][$number]['value']=array();

      }
      if(!isset($site['theme_components']['widgets']['position'][$position][$number]['value'][$field])){
      $site['theme_components']['widgets']['position'][$position][$number]['value'][$field]=array();
      }
      if (is_array($site['theme_components']['widgets']['position'][$position][$number]['config'])) {
      $plugin_config=$site['theme_components']['widgets']['position'][$position][$number]['config'];

      if(!isset($plugin_config['mongogrid'][$field])){
      $plugin_config['mongogrid'][$field]="";
      }

      if(isset($plugin_config['mongogrid']) and isset($plugin_config['mongogrid'][$field])){

      if(isset($plugin_config['mongogrid'][$field]['fields'])){
      if(isset($_POST['plugin_add_row'])){
      $array_insert=array();
      foreach($plugin_config['mongogrid'][$field]['fields'] as $field_on=>$data_field){

  if(isset($data_field['type'])){
  if(!isset($data_field['opt'])){
  $data_field['opt']=array();
  }
  $data_field['opt']['id_site']=$site['_id']->__toString();
  $data_field['opt']['site']=$site;
  $tmp_obj=new OneField();
  $tmp_obj->init($field_on,$data_field['type'],$data_field['opt']);
  $array_insert[$field_on]=$tmp_obj->setInput();
  }
      }

      if(count($array_insert)>0){
      $cur_pos="last";
      $max_count=0;
      if(isset($plugin_config['mongogrid'][$field]['count']) and $plugin_config['mongogrid'][$field]['count']>0){
      $max_count=$plugin_config['mongogrid'][$field]['count'];
      }
      if($max_count>0){
      $cur_count=count($site['theme_components']['widgets']['position'][$position][$number]['value'][$field]);
      if($cur_count>0 and $cur_count==$max_count){
      $tmp_count=$cur_count-1;
      $cur_pos=$tmp_count;
      }
      }
      $array_update=array();
      $array_update['theme_components']=$site['theme_components'];

      if(isset($_POST['plugins_pos_update'])){


      if(isset($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']])){
      foreach($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']] as $cur_key=>$cur_val){
      if(!isset($array_insert[$cur_key])){
      $array_insert[$cur_key]=$array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']][$cur_key];
      }

      if(is_string($array_insert[$cur_key]) and strlen($array_insert[$cur_key])==0){
       $array_insert[$cur_key]=$array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']][$cur_key];
      }
      if(is_array($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']] ) and count($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']] )>0){
     if(is_array($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']][$cur_key]) and count($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']][$cur_key])>0) {
      if(!is_array($array_insert[$cur_key])  ){
      $array_insert[$cur_key]=$array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']][$cur_key];
      }
      if(is_array($array_insert[$cur_key]) and count($array_insert[$cur_key])==0 ) {
      $array_insert[$cur_key]=$array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']][$cur_key];
      }
     }
      }
      }
      }

      $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_POST['plugins_pos_update']]=$array_insert;
      }
      else if($cur_pos!="last"){
      $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$cur_pos]=$array_insert;
      }else {
      $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][]=$array_insert;
      }


//      MGQuery::update($array_update, 'widget_user_sites',array('_id'=>new MongoId($site['_id']->__toString())));
          NoiCore::json()->update($array_update);
      $site['theme_components']=$array_update['theme_components'];
      NoiCore::app()->redirect(NoiCore::app()->getRoute('wi/'.$position."/".$number));
      }

      }
      if(isset($_GET['delete']) and isset($site['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_GET['delete']])){
       $array_update=array();
       $array_update['theme_components']=$site['theme_components'];
       $count_cur=count($site['theme_components']['widgets']['position'][$position][$number]['value'][$field]);
       unset($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field][$_GET['delete']]);
       if($count_cur>1){
       $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field]=  array_values($array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field]);

       }else {
       $array_update['theme_components']['widgets']['position'][$position][$number]['value'][$field]=array();
       }
//        MGQuery::update($array_update, 'widget_user_sites',array('_id'=>new MongoId($site['_id']->__toString())));
           NoiCore::json()->update($array_update);
      $site['theme_components']=$array_update['theme_components'];
          NoiCore::app()->redirect(NoiCore::app()->getRoute("wi/".$position."/".$number));
      }

      }
        $data=array();
      $data['site']=$site;
      $data['main_field']=$field;
      $data['name_plugin']=$name_plugin;
      $data['iswidget']="1";
      if(!isset($site['theme_components']['widgets']['position'][$position][$number]['options']) or !is_array($site['theme_components']['widgets']['position'][$position][$number]['options'])){
      $site['theme_components']['widgets']['position'][$position][$number]['options']=array();
      }
      $data['options']=$site['theme_components']['widgets']['position'][$position][$number]['options'];
      $data['position']=$position;
      $data['number']=$number;
//      $data['current_url']=  ShoutPlugin::getRoute2()."widget/mysites_components/widgets/".$site['_id']->__toString()."?position=".$position."&number=".$number."&op=config";
      $data['current_url']=NoiCore::app()->getRoute('wi/'.$position."/".$number);
      $data['id_site']=$site['_id']->__toString();
      $fields_name=array();
      if(isset($plugin_config['mongogrid'][$field]['fields'])){
       $fields_name=$plugin_config['mongogrid'][$field]['fields'];
      }
      $data['fields']=$fields_name;
      $fields_value=array();
      if(isset($site['theme_components']['widgets']['position'][$position][$number]['value'][$field])){
       $fields_value=$site['theme_components']['widgets']['position'][$position][$number]['value'][$field];
      }
      $data['values']=$fields_value;
      $data['plugin_config']=$plugin_config;
      $data['type_run']=$type_run;
      $data['gridconf']=new noicms\mongogrid\GridConf();
     Yii::$app->params['widget_page']=$name_plugin;
      if($type_run=="normal"){
      $text=SiteComponent::render_setup("editsite_bar",$data);
    if(file_exists(YII_PLUGIN_PATH."".$name_plugin."/views/admin/config/w_".$field.".php")){
 $text.=NoiCore::app()->render(YII_PLUGIN_PATH."".$name_plugin."/views/admin/config/w_".$field.".php",$data);
 return $text;
  }else if(file_exists(ADMIN_PATH.Yii::$app->params['admin_theme']."/page/plugin/w_".$name_plugin."/config/w_".$field.".php")) {

 $text.=NoiCore::app()->render(ADMIN_PATH.Yii::$app->params['admin_theme']."/page/plugin/".$name_plugin."/config/w_".$field.".php",$data);
 return $text;
  }else {


 $text.= NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/widget/widgets_component_config_page.php",$data);
  }
   return $text;
      }else if($type_run=="ajax"){

    
       echo NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/widget/widgets_component_config_page_ajax.php",$data);
       exit;
      }
      }

     }
   }
   public function opWidget(){
   $site=NoiCore::app()->site_data;
     if(isset($_GET['op'])){
    if($_GET['op']=="show" or $_GET['op']=="hide"){
    if(isset($_GET['number']) and isset($_GET['position']) and in_array($_GET['position'],$site['theme_components']['widgets']['positions_available']) and isset($site['theme_components']['widgets']['position'][$_GET['position']][$_GET['number']])){
    $array_update=array();
    $array_update['theme_components']=$site['theme_components'];
    if($_GET['op']=="show"){
     $array_update['theme_components']['widgets']['position'][$_GET['position']][$_GET['number']]['show']="1";
    }
    if($_GET['op']=="hide"){
      $array_update['theme_components']['widgets']['position'][$_GET['position']][$_GET['number']]['show']="0";
    }
//     MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
        NoiCore::json()->update($array_update);

    }
    }
    if($_GET['op']=="delete"){
      if(isset($_GET['number']) and isset($_GET['position']) and in_array($_GET['position'],$site['theme_components']['widgets']['positions_available']) and isset($site['theme_components']['widgets']['position'][$_GET['position']][$_GET['number']])){
    $array_update=array();
    $array_update['theme_components']=$site['theme_components'];
    $count=count($site['theme_components']['widgets']['position'][$_GET['position']]);
    unset($array_update['theme_components']['widgets']['position'][$_GET['position']][$_GET['number']]);
    if($count>1){
    $array_update['theme_components']['widgets']['position'][$_GET['position']]=  array_values($array_update['theme_components']['widgets']['position'][$_GET['position']]);
    }else {
    $array_update['theme_components']['widgets']['position'][$_GET['position']]=array();
    }
//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
        NoiCore::json()->update($array_update);

      }
    }
   
    if($_GET['op']=="down" or $_GET['op']=="up"){
    if(isset($_GET['number']) and isset($_GET['position']) and in_array($_GET['position'],$site['theme_components']['widgets']['positions_available']) and isset($site['theme_components']['widgets']['position'][$_GET['position']][$_GET['number']])){
   if($_GET['op']=="down"){
   $position=$_GET['position'];
   $number=$_GET['number'];
   $prev=$number+1;
   if(isset($site['theme_components']['widgets']['position'][$position][$prev])){
  $array_update=array();
   $array_update['theme_components']=$site['theme_components'];
   $array_cur_update=$site['theme_components']['widgets']['position'][$position];
   $old_value=$array_update['theme_components']['widgets']['position'][$position][$prev];
   $array_update['theme_components']['widgets']['position'][$position][$prev]=$array_update['theme_components']['widgets']['position'][$position][$number];
   $array_update['theme_components']['widgets']['position'][$position][$number]=$old_value;
//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
       NoiCore::json()->update($array_update);

   }
   }
   if($_GET['op']=="up"){
   $position=$_GET['position'];
   $number=$_GET['number'];
   $prev=$number-1;
   if(isset($site['theme_components']['widgets']['position'][$position][$prev])){
   $array_update=array();
   $array_update['theme_components']=$site['theme_components'];
   $array_cur_update=$site['theme_components']['widgets']['position'][$position];
   $old_value=$array_update['theme_components']['widgets']['position'][$position][$prev];
   $array_update['theme_components']['widgets']['position'][$position][$prev]=$array_update['theme_components']['widgets']['position'][$position][$number];
   $array_update['theme_components']['widgets']['position'][$position][$number]=$old_value;
//    MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
       NoiCore::json()->update($array_update);
    

   }
   }
    }
    }
    }
   }
   public function addWidget(){
     $site=NoiCore::app()->site_data;
      if(isset($_POST['position']) and in_array($_POST['position'],$site['theme_components']['widgets']['positions_available'])){
     if(isset($_POST['noibiz_widget']) and strlen($_POST['noibiz_widget'])>0){
     $array_update=array();
     $new_widget=array();
     $new_widget['config']=array();
     $new_widget['value']=array();
     $new_widget['options']=array();
     if(isset($_POST['title'])){
    $new_widget['options']['title']=  htmlspecialchars($_POST['title']);
    $new_widget['options']['visible_all']="1";
     }
     if(isset($_POST['language']) and $_POST['language']!="all"){
     $new_widget['options']['language']=$_POST['language'];
     }
     $new_widget['params']=array();
     $tmp_val=explode("::",$_POST['noibiz_widget']);
     if(isset($tmp_val[0]) and strlen($tmp_val[0])>0){
     if(file_exists(YII_PLUGIN_PATH."".$tmp_val[0]."/config.php")){
     require_once(YII_PLUGIN_PATH."".$tmp_val[0]."/config.php");
     if(isset($plugin_config)){
     $new_widget['name']=$tmp_val[0];
     $new_widget['config']=$plugin_config;
     }
     }
     if(count($tmp_val)>1){
     $newi=1;
     while(isset($tmp_val[$newi])){
     $new_widget['params'][]=$tmp_val[$newi];
     $newi++;
     }
     }
     }
     $new_widget['show']="1";

     $array_update['theme_components']=$site['theme_components'];
     if(isset($array_update['theme_components']['widgets']['position'][$_POST['position']]) and is_array($array_update['theme_components']['widgets']['position'][$_POST['position']]) and count($array_update['theme_components']['widgets']['position'][$_POST['position']])>0){
    $new_widget['options']['id']=$new_widget['name']."_".count($array_update['theme_components']['widgets']['position'][$_POST['position']]);
    $array_update['theme_components']['widgets']['position'][$_POST['position']][]=$new_widget;
     }else {
      $new_widget['options']['id']=$new_widget['name']."_0";
     $array_update['theme_components']['widgets']['position'][$_POST['position']]=array($new_widget);
     }
//     MGQuery::update($array_update, 'widget_user_sites', array('_id'=>new MongoId($site['_id']->__toString())));
      NoiCore::json()->update($array_update);
     $site['theme_components']=$array_update['theme_components'];
     }
     }
   }
   public function getPositions(){
   $site=NoiCore::app()->site_data;
   if(isset($site['theme_components']['widgets']['positions_available'])){
     return $site['theme_components']['widgets']['positions_available'];;
   }else {
       return array();
   }
   }
}
