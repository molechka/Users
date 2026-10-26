<?php
 /*
 * Class for work with application
 * @package NoiCore
 *
 *
 */
namespace noicms\core;
use NoiCore;
use Yii;
class NoiApp{
    /**
     *
     * @var array of site_data
     */
     public $site_data=false;
     
 
    
     /**
      * @var string id site in string mongoId
      *
      */
     public $site_id=false;
     /**
      * @var object /noicore/system_core/NoiDB.php
      */
     public $db_class=false;
     /**
      * 
      * @var array storage for local params site
      */
     public $params=array();
     private  $array_params=array();
     public function __construct($site_data) {
     if(isset($site_data) and is_array($site_data) and isset($site_data['_id'])){
     $this->site_id=$site_data['_id']->__toString();
     $this->site_data=$site_data;
     }
     if(isset(NoiCore::$must_be_loading['classes']) and count(NoiCore::$must_be_loading['classes']>0)){
      foreach(NoiCore::$must_be_loading['classes'] as $names=>$path){
         
          \Yii::$classMap[$names] = $path;
          unset(NoiCore::$must_be_loading['classes'][$names]);
      }
     }
     NoiCore::events()->load();
     if(!$this->isAdmin()){
        if(isset($_POST) and count($_POST)>0){
         $_POST=$this->parsePost($_POST);   
        }
     }
     }
   /**
    * How to use
    *
    * NoiCore::app()->redirect($url,$statusCode);
    * @param string  $url url adress to redirect
    * @param  int  @statusCode  redirect code
    *
    * @return void
    *
    */
     private function parsePost($array){
      if(isset($array) and is_array($array) and count($array)>0){
      foreach($array as $name=>$val){
     if(!is_object($val) and !  is_array($val)){
      $val=str_replace("[short","",$val);
      $val=str_replace("[/short]","",$val);
      $array[$name]=$val;      
     }
     if(is_array($val) and count($val)>0){
      $array[$name]=$this->parsePost($val);  
     }
       
      }    
      return $array;    
      }   
     }
     public function isAdmin(){
      $folder="frontend";
       if(isset(\Yii::$app->params['isadminrigtnow']) and \Yii::$app->params['isadminrigtnow']==1){
       return true;
       }else {
          return false;
       }
     }
  public function redirect($url,$statusCode=302){
    //  return parent::redirect($url);
$result=\Yii::$app->getResponse()->redirect($url, 302)->send();
return $result;



  }
  public function returnback($url="/"){
  if(isset($_SERVER['HTTP_REFERER'])){
   $this->redirect($_SERVER['HTTP_REFERER']) ;  
  }else {
      
     $this->redirect("/") ; 
  }   
  exit;
  }
  /**
   * How to use
   *
   * NoiCore::app()->getListRoles();
   *
   * @return all roles in array() : array('role1','role2','role3')
   * 
   *
   */
   public function getListRoles(){
   $site_data=NoiCore::app()->site_data;
       $array_lists=array();
   if(isset($site_data['theme_components']['plugins']['mongogrid_values']['user']['roles'][0]['name'])){

    foreach($site_data['theme_components']['plugins']['mongogrid_values']['user']['roles'] as $role){
    if(isset($role['name'])){
     $array_lists[]=$role['name'];
    }
    }

   }
    return $array_lists;
   }
     /**
      * 
      * This function is called automatically,
      * you dont need call function manualy 
      * 
      * function is found better language for client 
      *
      */
     public function setLang(){

   NoiCore::lang()->set();
     }
     /**
      *
      * How to use
      *
      * NoiCore::app()->getListLanguages() ;
      *
      * @return array of exists languages array('ru','al','en');
      *
      * 
      *
      */
     public function getListLanguges(){
     return NoiCore::lang()->getList();
     }
     /**
      * How to use
      * NoiCore::app()->getLang();
      * @return string current language "ru"
      * 
      *
      */
     public function getLang(){
    return NoiCore::lang()->get();
     }
     /**
      *
      * How to use
      *
      * NoiCore::app()->lang($key);
      * @param string $key
      * @return string language phrase for current language;
      *
      *
      */
     public function lang($key,$plugin=""){
     return NoiCore::lang()->t($key,$plugin);
     }
     /*
      *
      * This is functional is not need
      *
      */
     public function isEnableComponent($name_component){
     if(isset($this->site_data['theme_components'][$name_component]) ){
      return true;
     }else {
       return false;
     }
     }
     /**
      * How to use
      * NoiCore::app()->email($to,$title,$message);
      *
      * @param string $to   email recipient
      * @param string $title  subject email
      * @param string $message  message  body
      * @return void 
      *
      *
      *
      */
     static public function email($to,$title,$message,$from=""){
     $site_data=NoiCore::app()->site_data;

if(isset($site_data['email_conf']['type']) and $site_data['email_conf']['type']=="smtp"){
    require_once  PATH_TO_ENGINE.'/extensions/phpmailer/SMTPClient.php';;
    $smtp=new SMTPClient($to,$title,$message);
  $result=$smtp->SendMail();
}else {

 if($from==""){
  $from="no-reply@".$_SERVER['HTTP_HOST'];
 }
$headers  = "Content-type: text/html; charset=utf-8 \r\n";
$headers .= "From: ".$_SERVER['HTTP_HOST']."  <".$from.">\r\n";

mail($to, $title, $message, $headers);
}
  }
  /**
   * How to use NoiCore::app()->setNotify($notify_text);
   *
   * @param string $notify_text  Text notify
   * @return void
   *
   */
  public function setNotify($str){

 // \Yii::$app->session->setFlash('success', $str);
  NoiCore::notify()->set($str);
  }
  /*
   * How to use
   * NoiCore::app()->getNotify();
   *
   * return in array() all notify
   * array('notify 1','notify 2','notify 3');
   *
   */
    public function getNotify(){
   return NoiCore::notify()->getAll();
  }
  public function loadBySessionId($session_id){
  if(isset($session_id)){
   \Yii::$app->session->setId($session_id); 
   \Yii::$app->session->regenerateID(false);

  }
  }
  public function getSessionId(){
    return  \Yii::$app->session->getId();
  }
  /**
   * NoiCore::app()->setSession($name,$data);
   * @param string $name of key session
   * @param string or array $data  for save in session storage
   * @return void
   *
   */

       public function setSession($name,$data){

\Yii::$app->session->set($this->site_data['_id']->__toString()."_noicore__".$name,$data);
    }
    /**
     * NoiCore::app()->removeSession($name);
     * remove session by $name
     *
     * @param string $name  name of key session
     * @return void
     *
     */
    public function removeSession($name){
     if(isset( \Yii::$app->session[$this->site_data['_id']->__toString()."_noicore__".$name])){
       unset( \Yii::$app->session[$this->site_data['_id']->__toString()."_noicore__".$name]);
     }
    }
    /**
     * NoiCore::app()->getSession($name);
     *
     * @param string $name  key of session
     * @return (array) or (string) data by @name
     *
     *
     */
    public function getSession($name){
     if(isset( \Yii::$app->session[$this->site_data['_id']->__toString()."_noicore__".$name])){
  return  \Yii::$app->session[$this->site_data['_id']->__toString()."_noicore__".$name];
    }else {
      return false;
    }
    }
    /**
     *
     * NoiCore::app()->setParam($key,$value) ;
     * save in array params
     * @param string  $key (string)
     * @param (string) or ($array) or (int)  $value
     * @return void
     * 
     *
     *
     */
     public function setParam($key,$value){

     if(isset($key) and isset($value) ){




    $this->array_params[$key]=$value;

     }
     }
     /**
      *
      * NoiCore::app()->getParam($key);
      * @param string @key
      * @return (array) or (string) or (int)
      *  
      *
      */
     public function getParam($key){
$route=NoiCore::route()->get();

    if($key=="description"){
     $result="";
     if(isset($this->site_data['description'])){
     if($route==""){
     $result=$this->site_data['description'];
     }
     }
     if(isset($key)  and isset($this->array_params[$key])  ){
      $result.=$this->array_params[$key];
     }
     return $result;
     }else if($key=="keywords"){
     $result="";
      if(isset($this->site_data['keywords'])){
       if($route==""){
     $result=$this->site_data['keywords'];
       }
     }
     if(isset($key)  and isset($this->array_params[$key])  ){
      $result.=$this->array_params[$key];
     }
     return $result;
     }else {
     if(isset($key)  and isset($this->array_params[$key])  ){
     return $this->array_params[$key];
     }else {
      return 0;
     }
     }
     }
     /**
      *
      * NoiCore::app()->db();
      *
      *
      */
     public function db(){
      return $this->getDB();
     }
     /**
      *
      * NoiCore::app()->getDB();
      *
      */
     public function getDB(){
     if($this->db_class==false){
     $this->db_class=new NoiDB($this->site_id);
     }
     if(is_object($this->db_class)){
      return $this->db_class;
     }
     }
     /**
      * NoiCore::app()->get();
      *
      * @return in (array) data about current site;
      *
      */
     public function get(){
      return $this->site_data;
     }
     public function component($name){
      if(isset($this->site_data['theme_components'][$name])){
       return $this->site_data['theme_components'][$name];
      }
     }
     public function plugin_values_all($name_plugin){
     if(!isset($this->site_data['theme_components']['plugins']['mongogrid_values'][$name_plugin])){
        return array();
     }else {
       return $this->site_data['theme_components']['plugins']['mongogrid_values'][$name_plugin];
     }
     }
     /**
      *
      * NoiCore::app()->plugin_values($name_plugin,$field);
      *
      * @param string $name_plugin name of the plugin
      * @param string $field field from config file
      * @return array
      *
      */
     public function plugin_values($name_plugin,$field,$iswidget=0,$position=0,$number=0){
    if($iswidget==0){
     if(!isset($this->site_data['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field])){
      return array();
     }else {
     return $this->site_data['theme_components']['plugins']['mongogrid_values'][$name_plugin][$field];
     }
    }else {

   if(isset($this->site_data['theme_components']['widgets']['position'][$position][$number]['value'][$field])){
    return $this->site_data['theme_components']['widgets']['position'][$position][$number]['value'][$field];
   } else {
      return array();
   }

    }

     }
     public function render($file,$data=array()){


     if(file_exists($file)){

        extract($data, EXTR_PREFIX_SAME, "wddx");
        ob_start();
         @include($file);
       $result=ob_get_clean();



       return $result;
     }
     }
      public function get_plugin($plugin_name="",$param=array(),$iswidget=0,$widget=array()){

 if(strlen($plugin_name)>0 and in_array($plugin_name,$this->site_data['theme_components']['plugins']['available'])){
  

  
$param=implode("/",$param);

  $result=NoiCore::c("plugins")->run($plugin_name,$param,$iswidget,$widget,$this);
  return $result;
//  $this->result_html=$result;

 }
  }
     public function getWidget($name_position){
     $array_result=array();
     $name_plugin=$name_position;
       if(isset($this->site_data['theme_components']['widgets']['position'][$name_plugin]) and is_array($this->site_data['theme_components']['widgets']['position'][$name_plugin]) and count($this->site_data['theme_components']['widgets']['position'][$name_plugin])>0){
  $current_pos=$this->site_data['theme_components']['widgets']['position'][$name_plugin];


foreach($current_pos as $key=>$plugin){
if($plugin['show']=="1" and isset($plugin['params']) and isset($plugin['name'])){
 if($this->checkAccessWidget($plugin)){
    $result=$this->get_plugin($plugin['name'], $plugin['params'],1,array('position'=>$name_plugin,'number'=>$key));
$class="";
$title="";
$current_id=$plugin['name']."_".$key;
if(isset($plugin['options']['id'])){
$current_id=$plugin['options']['id'];
}
if(isset($plugin['options']['title'])){
$title=$plugin['options']['title'];
}
if(isset($plugin['options']['class'])){
$class=$plugin['options']['class'];
}



//     $current_result=str_replace("%%widget%%",$result,$format_result);
//
//     $current_result=str_replace("%%name_widget%%",$title,$current_result);
//     $current_result=str_replace("%%class_widget%%",$class,$current_result);
//     $current_result=str_replace("%%idwidget%%",$current_id,$current_result);
if(is_string($result)){
  $array_result[]=$result;
}
 }
}
}
     }
     return $array_result;
     }
     public function getRoute($url){
     $string="";
     if(isset(\Yii::$app->params['isadminrigtnow']) and \Yii::$app->params['isadminrigtnow']==1){
         return "/".Yii::$app->params['admin_folder']."/".$url;
     }
     }
     public function checkAccessWidget($plugin){

   if(isset($plugin['options'])){
    $available_access=array('all','auth','noauth');
     $list_all_role=  $this->getListRoles();

       if(isset($list_all_role) and is_array($list_all_role) and count($list_all_role)>0){
       foreach($list_all_role as $s_role){
       $available_access[]=$s_role;
       }
       }
    if(isset($plugin['options']['language'])){
    $cur_lang=$this->getLang();
    if($plugin['options']['language']!=$cur_lang){
       return false;
    }

    }
    if(isset($plugin['options']['access'])){
   if(in_array($plugin['options']['access'],$available_access)){
    $islogin=  NoiCore::user()->isLogin();
    $getrole=NoiCore::user()->getLogged("role");
//    $getrole=  UsersUserComponent::getLogged("role",$this->site_data['_id']->__toString());

    if($plugin['options']['access']=="auth" and $islogin==false){
     return false;
    }else   if($plugin['options']['access']=="noauth" and $islogin==true){
     return false;
    }else if($plugin['options']['access']!="all"){

     if($plugin['options']['access']=="noauth" and $islogin==false){
         return true;
     }
      if($plugin['options']['access']=="auth" and $islogin==true){
         return true;
     }
     if(is_array($getrole) and in_array($plugin['options']['access'],$getrole)){

     }else {
         return false;
     }
    }

   }

   }
    if(isset($plugin['options']['visible_all']) and $plugin['options']['visible_all']=="1" ){
     return true;
    }
   $result_visible=false;
   if(isset($plugin['options']['visible']) and is_array($plugin['options']['visible']) and count($plugin['options']['visible'])>0){
   $path_route=$this->path_route;;

   if($path_route==""){
   $path_route="/";
   }

   foreach($plugin['options']['visible'] as $vis){
  if(isset($vis['link'])) {
   $tmp_link=str_replace($vis['link'],"",$path_route);
   if(strripos($path_route,$vis['link']) ===false and $tmp_link==$path_route){

   }else {
    $result_visible=true;
   }
  }
   }
   }

   if(isset($plugin['options']['invisible']) and is_array($plugin['options']['invisible'])){

    foreach($plugin['options']['invisible'] as $visd){
  if(isset($visd['link'])) {
    $path_route=$this->path_route;;

   if(strripos($path_route,$visd['link']) ===false){

   }else {
    $result_visible=false;
   }
  }
   }
   }
   }


   return $result_visible;
    }


}

