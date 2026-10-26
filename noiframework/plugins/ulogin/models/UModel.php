<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UModel
 *
 * @author megamind
 */
namespace ulogin\models;
use user\models\UserAccount;
use NoiCore;
use MongoId;
use MongoDate;
class UModel  {
    //put your code here
    
    public function getWidget(){
    return '<script src="//ulogin.ru/js/ulogin.js"></script>
<div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/ulogin/auth/index.html"></div>';
    
    }
    static function doRegister(){
        if(isset($_POST['token']) and isset($_SERVER['HTTP_HOST'])){
     $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
                    $user = json_decode($s, true);
                     
                    if(is_array($user)){
                    $conf=NoiCore::app()->plugin_values("user","default");
                 
                    if(isset($conf[0]['collection'])){
                        
                       
                    $results=NoiCore::app()->db()->query(array(),$conf[0]['collection'],array('ulogin_id'=>$user['network']."_".$user['uid']));
                    if(!isset($results[0]['_id'])){
                    if(!NoiCore::user()->isLogin()){     
                    $result=array();
                    $result['ulogin_id']=$user['network']."_".$user['uid'];
                    $result['_id']=new MongoId();
                    if(isset($user['first_name']) and isset($user['last_name'])){
                    $result['name']=$user['first_name']." ".$user['last_name'];    
                    }else {
                    $result['name']=$user['network'].$user['uid'];   
                    }
                    $result['role']=  UserAccount::getRoles();
                    $result['date_register']=new MongoDate();
                    $result['date']=date('Y-m-d');
                    $result['user_active']=0;
                    $result['enable_account']=1;
                    $result['user_id']=$result['_id']->__toString();  
                    $result['user_money']=0;
                    $result=  UserAccount::addOtherfields($result);
                    $result=NoiCore::app()->db()->insert($result,$conf[0]['collection'],true);
                    }else {
                    $myuser=NoiCore::user()->load();    
                    $array_upd=array();    
                    $array_upd['ulogin_id']=$user['network']."_".$user['uid'];
                    NoiCore::user()->update($array_upd,$myuser['_id']->__toString());
                     NoiCore::app()->redirect("/user/profile/index.html");
                     exit;
                    return false;
                    }
                    }else {
                    $result=$results[0];    
                    $result['user_id']=$result['_id']->__toString();    
                    }
                     
                     
                    
                     NoiCore::app()->setSession("user_auth",1);
                     NoiCore::app()->setSession("user_id",$result['_id']->__toString());
                     NoiCore::app()->setSession("user_result",$result);
                     NoiCore::app()->redirect("/");
                    }
                    }
                    
        }
                    
                
    }
}
