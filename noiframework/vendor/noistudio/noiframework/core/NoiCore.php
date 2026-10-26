<?php
/*
 * основной класс для осуществления взаимодействия с CMS
 *
 * @package NoiCore
 * echo check check
 */
 

 use noicms\core\NoiAdmin;
 use noicms\core\NoiApp;
 use noicms\core\NoiCustom;
 use noicms\core\NoiDB;
 use noicms\core\NoiEvents;
 use noicms\core\NoiJson;
 use noicms\core\NoiLang;
 use noicms\core\NoiMysql;
 use noicms\core\NoiNotify;
 use noicms\core\NoiRoute;
 

 

 
class NoiCore{
     /**
      *
      * @var  object /noicore/system_core/NoiApp.php
      */
     public static $path_to_engine=PATH_TO_ENGINE;
     public static $app_class=false;
     /**
      *
      * @var  object /noicore/class/PluginUser.php
      */
     public static $user_class=false;
     /**
      *
      * @var  object /noicore/system_core/NoiJson.php
      */
     public static $json_class=false;
     /**
      *
      * @var  object /noicore/system_core/NoiMysql.php
      */
     public static $mysql_class=false;
     /**
      *
      * @var  object /noicore/system_core/NoiCustom.php
      */

     public static $custom_class=false;
     /**
      *
      * @var  object /noicore/system_core/NoiRoute.php
      */
     public static $route_class=false;
     /**
      *
      * @var  object /noicore/system_core/NoiAdmin.php
      */
     public static $admin_class=false;
     /**
      *
      * @var  object /noicore/system_core/NoiNotify.php
      */
     public static $notify_class=false;

     /**
      *
      * @var  array
      */
     public static $components_array=array();
     public static $lang_class=false;
     public static $events_class=false;
     public static $p_array=array();
     public static $must_be_loading=array('classes'=>array(
    

     ),'status'=>1);
     public function __construct() {





     }

     /**
      *
      *  How to use
      *  NoiCore::app()->method
      *  @return object NoiApp.php
      *
      */

     public static function app(){
          
     if(!is_object(NoiCore::$app_class) and NoiCore::$app_class==false and isset(\Yii::$app->params['noi_site_data'])){
       if(isset(\Yii::$app->params['noi_site_data']) and is_array(\Yii::$app->params['noi_site_data']) and isset(\Yii::$app->params['noi_site_data'])){
      NoiCore::$app_class=new NoiApp(\Yii::$app->params['noi_site_data']);

     }
     }
     if(is_object(NoiCore::$app_class)){
      return NoiCore::$app_class;
     }
     }
     /**
      *
      *  How to use
      *  NoiCore::json()->method
      *  @return object NoiJson.php
      *
      */
     public static function json(){
     if(!is_object(NoiCore::$json_class) and NoiCore::$json_class==false and isset(\Yii::$app->params['noi_site_data'])){
        NoiCore::$json_class=new NoiJson();
     }
     if(is_object(NoiCore::$json_class)){
      return NoiCore::$json_class;
     }
     }
     /**
      *
      *  How to use
      *  NoiCore::notify()->method
      *  @return object  NoiNotify.php
      *
      */
      public static function notify(){
     if(!is_object(NoiCore::$notify_class) and NoiCore::$notify_class==false and isset(\Yii::$app->params['noi_site_data'])){
        NoiCore::$notify_class=new NoiNotify();
     }
     if(is_object(NoiCore::$notify_class)){
      return NoiCore::$notify_class;
     }
     }
       public static function lang(){
     if(!is_object(NoiCore::$lang_class) and NoiCore::$lang_class==false and isset(\Yii::$app->params['noi_site_data'])){
        NoiCore::$lang_class=new NoiLang();
     }
     if(is_object(NoiCore::$lang_class)){
      return NoiCore::$lang_class;
     }
     }
       public static function events(){
     if(!is_object(NoiCore::$events_class) and NoiCore::$events_class==false and isset(\Yii::$app->params['noi_site_data'])){
        NoiCore::$events_class=new NoiEvents(\Yii::$app->params['noi_site_data']);
     }
     if(is_object(NoiCore::$events_class)){
      return NoiCore::$events_class;
     }
     }
     public static function p($classname){
      if(!isset(NoiCore::$p_array[$classname]) or !is_object(NoiCore::$p_array[$classname])){
      $object=NoiCore::c("plugins")->runController($classname);
      if(is_object($object)){
      NoiCore::$p_array[$classname]=$object;
      }
      }
      return NoiCore::$p_array[$classname];
     }
     /**
      *
      *  How to use
      *  NoiCore::c($component)->method
      *  @param string $component nameclass
      *  @return object from /noicore/components/(frontend) or (admin)/Nameclass.php
      *
      */
     public static function c($component){
       $component=  ucfirst($component);
       $folder="frontend";
       if(isset(\Yii::$app->params['isadminrigtnow']) and \Yii::$app->params['isadminrigtnow']==1){
       $folder="admin";
       }
       if(!file_exists(__DIR__."/components/".$folder."/".$component.".php")){
         if($folder=="admin"){
          $folder="frontend";   
         }else {
           $folder="admin";  
         }  
       }
      if(!class_exists($component)){
      require_once __DIR__."/components/".$folder."/".$component.".php";

      }
      if(isset(NoiCore::$components_array[$component]) and is_object(NoiCore::$components_array[$component])){
          return NoiCore::$components_array[$component];
      }else {
          NoiCore::$components_array[$component]=new $component();
          return NoiCore::$components_array[$component];
      }

     }
     /**
      *
      *  How to use
      *  NoiCore::custom()->method
      *  @return object NoiCustom.php
      *
      */
      public static function custom(){
     if(!is_object(NoiCore::$custom_class) and NoiCore::$custom_class==false and isset(\Yii::$app->params['noi_site_data'])){
\Yii::$classMap['noicms\minify\Converter'] = PATH_TO_ENGINE."/vendor/noistudio/noiframework/minify/Converter.php";
\Yii::$classMap['noicms\minify\CSS'] = PATH_TO_ENGINE."/vendor/noistudio/noiframework/minify/CSS.php";
\Yii::$classMap['noicms\minify\Exception'] = PATH_TO_ENGINE."/vendor/noistudio/noiframework/minify/Exception.php";
\Yii::$classMap['noicms\minify\JS'] = PATH_TO_ENGINE."/vendor/noistudio/noiframework/minify/JS.php";
\Yii::$classMap['noicms\minify\Minify'] = PATH_TO_ENGINE."/vendor/noistudio/noiframework/minify/Minify.php";

        NoiCore::$custom_class=new NoiCustom(\Yii::$app->params['noi_site_data']);
     }
     if(is_object(NoiCore::$custom_class)){
      return NoiCore::$custom_class;
     }
     }
     /**
      *
      *  How to use
      *  NoiCore::route()->method
      *  @return object NoiRoute.php
      *
      */
       public static function route(){
     if(!is_object(NoiCore::$route_class) and NoiCore::$route_class==false and isset(\Yii::$app->params['noi_site_data'])){
        NoiCore::$route_class=new NoiRoute(\Yii::$app->params['noi_site_data']);
     }
     if(is_object(NoiCore::$route_class)){
      return NoiCore::$route_class;
     }
     }
      public static function mysql(){
     if(!is_object(NoiCore::$mysql_class) and NoiCore::$mysql_class==false){
        NoiCore::$mysq_class=new NoiMysql();
     }
     if(is_object(NoiCore::$mysql_class)){
      return NoiCore::$mysql_class;
     }
     }
     /**
      *
      *  How to use
      *  NoiCore::admin()->method
      *  @return Object NoiAdmin.php
      *
      */
       public static function admin(){
     if(!is_object(NoiCore::$admin_class) and NoiCore::$admin_class==false){
        NoiCore::$admin_class=new NoiAdmin();
     }
     if(is_object(NoiCore::$admin_class)){
      return NoiCore::$admin_class;
     }
     }
     /**
      *
      *  How to use
      *  NoiCore::user()->method
      *  @return object /noicore/class/PluginUser.php
      *
      */
     public static function user(){
     if(file_exists(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/PluginUser.php")){
     include_once(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/PluginUser.php");
     if(NoiCore::$user_class==false and isset(\Yii::$app->params['noi_site_data'])){
      NoiCore::$user_class=new PluginUser(\Yii::$app->params['noi_site_data']['_id']->__toString());

     }
     return NoiCore::$user_class;
     }
     }
     public static function load($namespace,$path){
       
if(isset($namespace) and isset($path) and file_exists($path)){
         NoiCore::$must_be_loading['classes'][$namespace]=$path;
          NoiCore::$must_be_loading['classes']['status']=1;
}

     }


}

