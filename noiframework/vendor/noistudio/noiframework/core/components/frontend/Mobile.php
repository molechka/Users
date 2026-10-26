<?php

class Mobile{
    public $system_params=array();
    function isMobile(){
       $result=false;
            if(isset($_GET['hash']) and isset($_GET['openkey'])  and strlen($_GET['openkey'])>4){
       $_GET['openkey']=strip_tags($_GET['openkey']);
       $site_data_tmp=NoiCore::app()->get();
       if(isset($site_data_tmp['mobile']['status']) and $site_data_tmp['mobile']['status']==1 and isset($site_data_tmp['mobile']['secret_phras']) and strlen($site_data_tmp['mobile']['secret_phras'])>4){
       $hash_check=hash("sha512",$site_data_tmp['mobile']['secret_phras'].$_GET['openkey']);

      if($hash_check==$_GET['hash']){
          
       $count_hashs=NoiCore::app()->db()->count('used_openkey',array('openkey'=>$_GET['openkey']));

       if($count_hashs==0){

       $result=true;

       if(count($_POST)>0){
        
       $this->system_params=$_POST;
       if(isset($_POST['api_sessionid'])){
          
           NoiCore::app()->loadBySessionId($_POST['api_sessionid']);
       }

       if(isset($_POST['api_username']) and isset($_POST['api_password'])){
       $result=NoiCore::p("LoginUserFCP")->doLogin($_POST['api_username'],$_POST['api_password'],"mobile");
        

       if(is_array($result) and isset($result['_id'])){
        $this->system_params['api_user']=$result;
       }

       }
       }
       NoiCore::app()->setParam("return_json",1);
       $array_insert=array();
       $array_insert['openkey']=$_GET['openkey'];
       $array_insert['phrase']=$site_data_tmp['mobile']['secret_phras'];
       $array_insert['ip']=$_SERVER['REMOTE_ADDR'];
       $array_insert['date']=new MongoDate();
       NoiCore::app()->db()->insert($array_insert,'used_openkey');
       }
      }
       }

      }
      return $result;
    }
}
