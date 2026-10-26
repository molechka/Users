<?php
use noicms\mongogrid\system_core\MGQuery;
class PluginUser{
   public $name_plugin="";
   public $id=0;
   public $user_site=array();
   public function __construct($name_plugin) {
   $this->name_plugin=$name_plugin;
   if(!isset(NoiCore::c("mobile")->system_params['api_user'])){
   $this->user_site=NoiCore::app()->getSession("user_result");
   }else {
   $this->user_site=NoiCore::c("mobile")->system_params['api_user'];
   }
   if(isset($this->user_site['_id'])){
    if(isset($this->user_site['user_id'])){
    $this->id=$this->user_site['user_id'];
    }
   }
    if(!$this->isLogin()  and NoiCore::app()->getParam("iscron")!==true){
     
     if (isset(Yii::$app->request->cookies['misterti']) and isset($_SERVER['REMOTE_ADDR'])) {
//        echo Yii::$app->request->cookies['misterti'] ;
//        exit;
          
         $do_search_user=array();
         $do_search_user['access_hash_token']=Yii::$app->request->cookies->getValue('misterti');
         $do_search_user['access_ip']=$_SERVER['REMOTE_ADDR'];
         
         $results_users=NoiCore::app()->db()->query(array(),"cms_users",$do_search_user);
         
         if(isset($results_users[0]['_id'])){
              
           $results_users[0]['user_id']=$results_users[0]['_id']->__toString();
     // $user_identify->result=$result[0];
           
      $results_users[0][ user\models\UserAccount::getLogin()]=$results_users[0][user\models\UserAccount::getLogin()];
      $results_users[0]['mainlogin']=$results_users[0][user\models\UserAccount::getLogin()];
      NoiCore::app()->setSession("user_auth",1);
      NoiCore::app()->setSession("user_id",$results_users[0]['_id']->__toString());
      NoiCore::app()->setSession("user_result",$results_users[0]);
 
      $this->user_site= $results_users[0];
      $this->id=$results_users[0]['_id']->__toString();
         }
     }
   }
   if($this->isLogin()){
   $load_user=$this->load();
   if(!isset($load_user['_id'])){
   $this->logout();
   
   }
   if(isset($load_user['blocked']) and $load_user['blocked']==1){
    $this->logout();   
   }
 
     if(isset($load_user['enable_account']) and $load_user['enable_account']==0){
         
    $this->logout();   
   }
   if(isset($load_user['enable_account']) and $load_user['enable_account']==0){
    $this->logout();   
   }
  
   $arr_user_update=array();
   $arr_user_update['session_id']=\Yii::$app->session->id;
   $arr_user_update['last_update_time']=new MongoDate();
   $arr_user_update['status_user']=1;

   $this->update($arr_user_update);
   }
   $result_site=  NoiCore::app()->get();

    if(isset($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'])){
    $time=strtotime('-5 minutes', strtotime(date('Y-m-d H:i:s')));
    $array_update=array();
    $array_update['status_user']=0;
    //$array_update['session_id']="";
 
    NoiCore::app()->db()->update($array_update,$result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'],array('last_update_time'=>array('$lte'=>new MongoDate($time))),true);
    }

   }
  
   public function login($array){
   return false;
   if(is_array($array) and count($array)>0){
   if(!isset(\Yii::$app->session[$this->name_plugin."_user_data"]) and !isset(\Yii::$app->session[$this->name_plugin."_user_login"])){
  \Yii::$app->session->add($this->name_plugin."_user_data",$array);
   \Yii::$app->session->add($this->name_plugin."_user_login",true);
   return true;
   }else {
     return false;
   }
   }else {
       return false;
   }
   }
   public function loads($id_user="0",$field="last_id"){

       if($id_user=="0"){
   $id_user=$this->user_site['last_id'];
  
   }

  if($field=="_id"){
  $search_value=new MongoId($id_user);
  }else {
  if($field=="last_id"){
  $id_user=(int)$id_user;    
  }    
  $search_value=$id_user;
  }
  $result_site=  NoiCore::app()->get();

    if(isset($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection']) and strlen($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'])>0){

  $result=MGQuery::execute(array(), $result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'],array($field=>$search_value,"site_id"=>$this->name_plugin));

  return $result;
    }
   }
   public function load($id_user="0",$field="last_id"){

      if($id_user=="0"){
           
   $id_user=$this->user_site['last_id'];
  
   }

  if($field=="_id"){
  $search_value=new MongoId($id_user);
  }else {
  if($field=="last_id"){
  $id_user=(int)$id_user;    
  }    
  $search_value=$id_user;
  }
  $result_site=  NoiCore::app()->get();
 
    if(isset($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection']) and strlen($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'])>0){

  $result=MGQuery::execute(array(), $result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'],array($field=>$search_value,"site_id"=>$this->name_plugin));

  if(isset($result[0])){
    return $result[0];
  }else {
      return false;
  }
    }
   }
   public function history($user,$op="plus",$amount,$comment="",$pop=0,$data=array()){
    if(isset($user['_id'])){
    $user=$this->load($user['_id']->__toString(),"_id");
    }
    
      $history['id_user']=$user['_id']->__toString();
    $history['user']=$user;
    $history['date']=new MongoDate();
    $history['op']=$op;
    $history['pop']=$pop;
    $history['amount']=(float)$amount;
    $history['comment']=$comment;
    $history['data']=$data;
    NoiCore::app()->db()->insert($history,"historyop_collection");
   
   }
   public function plus($field,$value,$id_user){
NoiCore::user()->update(array($field=>$value),$id_user,'$inc');
   }
   public function minus($field,$value,$id_user){
 
    $value=-(float)$value;
NoiCore::user()->update(array($field=>$value),$id_user,'$inc');
   }
   public function update($array,$id_user=0,$modifier='$set'){
   
     if($id_user==0){
     if($this->isLogin()==true){
          
     $id_user=$this->id;
     }else {
      return false;
     }
     }
    if(isset($array) and is_array($array)){
    $result_site=  NoiCore::app()->get();
    if(isset($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection']) and strlen($result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'])>0){
    $result= MGQuery::update($array, $result_site['theme_components']['plugins']['mongogrid_values']['user']['default'][0]['collection'],array('_id'=>new MongoId($id_user),"site_id"=>$this->name_plugin),false,$modifier);
    $current_user=$this->load($id_user);

    $array_new_update=array();
    $array_new_update['messages.$.user']=$current_user;
  if(!isset($array['last_update_time'])){
   NoiCore::app()->db()->update($array_new_update,"forum_themes",array('messages.user._id'=>$current_user['_id']));
     NoiCore::app()->db()->update(array('user'=>$current_user),"comments_list",array('user._id'=>$current_user['_id']));
    NoiCore::events()->execute("update_user",array('user'=>$current_user));
  }


     return $result;
      if($id_user==\Yii::$app->session[$this->name_plugin."_user_data"]['user_id']){
      \Yii::$app->params[$this->name_plugin.'_user_'.\Yii::$app->session[$this->name_plugin."_user_data"]['user_id']]=$this->load($id_user);
      }
    }
    }


   }
   public function isLogin(){
if(!isset(NoiCore::c("mobile")->system_params['api_user'])){
$user_result=NoiCore::app()->getSession("user_result");
   if(isset($user_result) and is_array($user_result) ){
   $update_time=  NoiCore::app()->getParam("update_time");
if(isset($update_time) and $update_time=="yes"){

}else {
 $this->update(array('last_update'=>new MongoDate()));
 NoiCore::app()->setParam("update_time","yes");
}
   return true;
   }else {
     //  var_dump(\Yii::$app->session[$this->name_plugin."_user_data"]);
      // var_dump(\Yii::$app->session[$this->name_plugin."_user_login"]);
      // exit;
   return false;
   }
}else {
    return true;
}
   }
   public function toArray(){
    if(isset($this->user_site) and is_array($this->user_site)  ){
   return  $this->user_site;

   }else {
    return false;
   }
   }
   public function logout(){
   if($this->isLogin()){
    Yii::$app->session->removeAll();
     NoiCore::app()->redirect("/");
    }
   }
   public function isRole($role_val){
   $role=$this->getLogged('role');
    
   if(isset($role) and is_array($role)){
   if(in_array($role_val, $role)){
    return true;
   }
   }
   return false;
   }
   public function getSessionId(){
    if($this->isLogin()){
      return \Yii::$app->session->id;
   }else {
       return false;
   }
   }
   public function getLogged($field){


   if(isset($this->user_site['_id']) and is_array($this->user_site) and count($this->user_site)>0 ){

  if(!isset(\Yii::$app->params[$this->name_plugin.'_user_'.$this->user_site['user_id']])){
  $result=$this->load($this->user_site['user_id']);
  $result['user_id']=$this->user_site['user_id'];
  \Yii::$app->params[$this->name_plugin.'_user_'.$this->user_site['user_id']]=$result;
 
 if(isset($result[$field])){
  return $result[$field];
 }else {
  return false;
 }
  }else   {
    if(isset(\Yii::$app->params[$this->name_plugin.'_user_'.$this->user_site['user_id']][$field])){
     return \Yii::$app->params[$this->name_plugin.'_user_'.$this->user_site['user_id']][$field];
    }else {
     return false;
    }
  }
   }else {
    return false;
   }
   }
}

