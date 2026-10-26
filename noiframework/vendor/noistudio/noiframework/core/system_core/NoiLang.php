<?php

namespace noicms\core;
use NoiCore;
use Yii;
class NoiLang{
    private $default_lang="en";
    
    public function setDefault($lang){
    if(isset($lang)){    
    $this->default_lang=$lang;    
    }
    }
    public function getDefault(){
    return $this->default_lang;    
    }
    public function is(){
    $site=NoiCore::app()->get();
    if(!isset($site['multilanguage']) or (isset($site['multilanguage']) and $site['multilanguage']==0)){
     return false;
    }else {
        return true;
    }
    }
    public function set(){

     if(isset($_GET['set_language'])){
      if (preg_match("/^([[:alnum:]])*$/", $_GET['set_language']))
{

   NoiCore::app()->setSession("current_language", strip_tags($_GET['set_language']));
}

     }else{
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
        $lang= substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (preg_match("/^([[:alnum:]])*$/", $lang))
{
  $current_lang=NoiCore::app()->getSession('current_language');

     if(isset($current_lang) and $current_lang==false){
        NoiCore::app()->setSession("current_language", strip_tags($lang));
     }


}
        }
     }
     }
     public function getList(){
       $result_dirs=  scandir(PATH_TO_ENGINE."/language/frontend/");
     $result_languges=array();
    if(count($result_dirs)>0){
     foreach($result_dirs as $dir){
          if (preg_match("/^([[:alnum:]])*$/", $dir))
         {
          if(file_exists(PATH_TO_ENGINE."/language/frontend/".$dir."/main.php")){
          $result_languges[]=$dir;
          }

          }
     }
    }
return $result_languges;
     }
     public function get(){
             $default_language=Yii::$app->params['default_language'];
     $current_lang=NoiCore::app()->getSession('current_language');
     if(isset($current_lang) and $current_lang==false){
      $current_lang=$default_language;
     }
     return $current_lang;
     }
     public function toParse($string,$data){
         
        if(isset($data) and is_array($data)  and count($data)>0){
        foreach($data as $key=>$d){
         if(is_string($d)){
          $d=(string)$d;  
         $string=  str_replace("@".$key."@", $d, $string);   
         }   
        }    
        } 
        
         return $string;
         
     }
     public function t($key,$plugin="",$data=array()){
           if(!isset($key)){
       return 0;
      }
         if(isset($plugin) and is_array($plugin)){
      $data=$plugin;
      $plugin="";
      }
     $default_language=$this->getDefault();
  
     $current_lang=NoiCore::app()->getSession('current_language');

     if(isset($current_lang) and $current_lang==false){
      $current_lang=$default_language;
     }

     $folder="frontend";
     if(isset(Yii::$app->params['isadminrigtnow']) and Yii::$app->params['isadminrigtnow']==1){
     $folder="admin";
     }

  $file=PATH_TO_ENGINE."/language/".$folder."/".$current_lang."/main.php";

  if(file_exists(YII_PLUGIN_PATH."".$plugin."/config.php")){
     $file=YII_PLUGIN_PATH.$plugin."/language/".$folder."/".$current_lang."/main.php";
  }
if($folder=="frontend"){
    if(isset(NoiCore::app()->site_data['language_'.$current_lang][$key])){
      return NoiCore::lang()->toParse(NoiCore::app()->site_data['language_'.$current_lang][$key],$data);

    }else if(isset(NoiCore::app()->site_data['language_en'][$key])){
        return NoiCore::lang()->toParse(NoiCore::app()->site_data['language_en'][$key],$data);
    }
  }

     if(file_exists($file)){
      include($file);

      if(isset($lang[$key])){
         return NoiCore::lang()->toParse($lang[$key],$data);
      }else {
          return NoiCore::lang()->toParse($key,$data);
      }
     }else {
      return $key;
     }
     }
}

