<?php
/*
 * Class for work with admin data
 * @package NoiCore
 *
 *
 */
namespace noicms\core;
use NoiCore;
use Yii;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;

class NoiAdmin{

    
     public function set($logo,$type="logo"){
     if(isset($logo) and is_string($logo) and isset($type) and is_string($type)){
      NoiCore::app()->setParam("admin_".$type,$logo);   
     }   
    }
    public function get($type="logo"){
     if(isset($type) and is_string($type)){
      $result=NoiCore::app()->getParam("admin_".$type);      
     if(!is_bool($result)){
       return $result;  
     }else {
         return "";
     }
     }   
    }
    /**
     *
     * NoiCore::admin()->getCssArray();
     * function return array of css files from frontend template
     * @return array('/template/name_template/contain/1.css','/template/name_template/contain/2.css');
     *
     */
    public function getCssArray(){
     $site_data=NoiCore::app()->get();
     $array_css=array();
    
      $file_path=DOCUMENT_ROOT."".THEMES_PATH."".$site_data['theme_site']."/page/main.php";
    if(strlen($site_data['type_site'])>0){
    $file_path=DOCUMENT_ROOT.THEMES_PATH."".$site_data['type_site']."/".$site_data['theme_site']."/page/main.php";
    }

    if(file_exists($file_path)){
    $file_text=  file_get_contents($file_path);
    $file_text=NoiCore::custom()->doReplace($file_text);
    preg_match_all('/(<link\b.+href=")(?!http)([^"]*)(".*>)/', $file_text, $matches) ;
    if(isset($matches[2])){
        foreach ($matches[2] as $row){
        $tmp=str_replace(".css","",$row);
        if($tmp!=$row){
             $array_css[]=$row;
        //$array_css[]=NoiCore::app()->getRoute("setup/replacecss?css=".$row);
        }
        }
    }

    }
$array_css[]="/themes/admin/noishop/assets/css/page-elrte.css";
 
    return $array_css;
     }
     /**
      * NoiCore::admin()->isLogin();
      *
      * check login user in admin panel or not
      * @return bool (if user is login in admin return true,is user not login in admin          *  return false
      *
      *
      */
     public function isLogin(){
if(DB_TYPE=="mongodb"){
      $is_auth=NoiCore::app()->getSession("admin_auth");

      if(isset($is_auth) and $is_auth==1){
          return true;
      }else {
          return false;
      }
}
if(DB_TYPE=="mongolite"){
 $is_auth=NoiCore::app()->getSession("admin_is_login");

 if(isset($is_auth) and $is_auth==true){
   return true;
 }else {
    return false;
 }
}

  }
  public function isRoot(){
     return true;
  }
  /**
   *
   * NoiCore::admin()->getPreview($original_link);
   * @param  string $original_link  url path
   * @return auto replacement link;
   *
   */
  public function getPreview($original_link){
  if(isset($original_link)){
  $result=$original_link;
   $site_data=  NoiCore::app()->site_data;
 

   if(isset($site_data['route']) and count($site_data['route'])>0 ){
   foreach($site_data['route'] as $value){

   if(isset($value['normal']) and $value['normal']==$original_link){
 
   $result=$value['seo'];
   }
   }
   }
  }
  return $result;
  }
  /**
   * NoiCore::app()->getManageLink($original_link);
   *
   * @param string $original_link   - path url
   * @return string
   *
   *
   */
  public function getManageLink($original_link){

   if(isset($original_link)){
   $result=array('seo'=>$original_link,'normal'=>$original_link);

   $site_data=  NoiCore::app()->site_data;
 
   if(isset($site_data['route']) and count($site_data['route'])>0 ){
   foreach($site_data['route'] as $value){

   if(isset($value['normal']) and $value['normal']==$original_link){

   $result=$value;
   }
   }
   }
      }

   return NoiCore::app()->render(PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/views/fastlink/manage.php",$result);
  }
  /**
   * NoiCore::admin()->isMainPage();
   *  check if it mainpage in admin
   * @return bool
   *
   */
    static function isMainPage(){
   $current_url=Yii::$app->request->url;
$current_url=str_replace("/".Yii::$app->params['admin_folder'],"",$current_url);
if(strlen($current_url)==0){
   return true;
}else {
    if($current_url=="/"){
     return true;
    }
   return false;
}
  }
   public function getAllWidgets($name_plugin,$op=2){
  $results=array();
  $site=NoiCore::app()->site_data;
  if(isset($site['theme_components']['widgets']['position']) and is_array($site['theme_components']['widgets']['position']) and count($site['theme_components']['widgets']['position'])>0){
  foreach($site['theme_components']['widgets']['position']  as $name_pos=>$pos){
  if(isset($pos) and count($pos)>0){
  foreach($pos as $number=>$pos_val){
   if(isset($pos_val['name']) and $pos_val['name']==$name_plugin){
   if(($op==1 and (int)$pos_val['show']==(int)$op) or ($op==0 and (int)$pos_val['show']==(int)$op) or $op==2 ){
   $pos_val['position']=$name_pos;
   $pos_val['number']=$number;
   $results[]=$pos_val;

   }
   }
  }
  }
  }
  }

   return $results;
  }
  /**
   * NoiCore::admin()->setDisableConditionDb();
   *
   * disable auto condition site_id with database query
   *
   * @return void
   *
   */
  public function setDisableConditionDb(){
      NoiCore::app()->setParam("disable_auto_db",1) ;

  }
  /**
   * NoiCore::admin()->getCountTrash();
   * return count elements in trash
   *
   * @return int
   *
   *
   */
  public function getCountTrash(){
     NoiCore::app()->setParam("disable_auto_db",1) ;
     $count=NoiCore::app()->db()->count("trash_collection",array());
     NoiCore::app()->setParam("disable_auto_db",444) ;
     return $count;
  }
  public function getAll($route){
   $result_plugins=scandir(YII_PLUGIN_PATH);
   $result_array=array();
   $plugins=array();
   if(count($result_plugins)>0){
    foreach($result_plugins as $plugin){
     if(file_exists(YII_PLUGIN_PATH."".$plugin."/config.php")){
     if(NoiCore::c("plugins")->isInstall($plugin)){
     $plugins[]=$plugin;
     }
     }
    } 
   }
     $result_site=  NoiCore::app()->site_data;

     
if(count($plugins)>0){
 foreach($plugins as $pl){






     $data['render']=NoiCore::c("plugins")->run($pl,$route);

     
     if(strlen($data['render'])>2){
     $result_array[]=$data['render'];
     }
 }
}
  
  return $result_array;
  }
  public function getAdminStyle(){
    $array_available=array(
    'skin-blur-violate','skin-blur-blue','skin-blur-chrome','skin-blur-city','skin-blur-greenish','skin-blur-kiwi','skin-blur-lights','skin-blur-night','skin-blur-ocean','skin-blur-sunny','skin-blur-sunset','skin-blur-yellow','skin-cloth','skin-tectile'
    );
    $default_value="skin-blur-kiwi";
    $value_get=NoiCore::app()->getSession("admin_style");
    if(in_array($value_get,$array_available)){
    return $value_get;
    }else {
       return $default_value;
    }
  }

  public function setAdminStyle(){
    $array_available=array(
    'skin-blur-violate','skin-blur-blue','skin-blur-chrome','skin-blur-city','skin-blur-greenish','skin-blur-kiwi','skin-blur-lights','skin-blur-night','skin-blur-ocean','skin-blur-sunny','skin-blur-sunset','skin-blur-yellow','skin-cloth','skin-tectile'
    );
   if(isset($_POST['admin_style']) and  in_array($_POST['admin_style'],$array_available)){
    NoiCore::app()->setSession("admin_style",$_POST['admin_style']);


   }
  }
}

