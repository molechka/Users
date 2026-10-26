<?php
use user\models\MoneyTransfer;
class BillUserFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("user",$cur,$route);
        NoiCore::app()->setParam("type","chet");
if(!NoiCore::user()->isLogin()){
  return false;  
}
    }
    public function actionSend(){
         MoneyTransfer::doSend();
       NoiCore::app()->returnback();
       exit;
    }
    public function actionAjax(){
     if(!isset($_POST['iduser'])){
      echo 'Неправильный id';   
     }else{
      if(isset($_POST['iduser'])){
      if(is_numeric($_POST['iduser'])){
       $us=NoiCore::user()->load((int)$_POST['iduser'],"last_id");
       if(isset($us['_id'])){
         echo $us['surname'].' '.$us['name'].' , '.$us['email'];  
       }else {
        echo 'Пользователя не существует';   
       }
      }else {
      echo 'Неправильный id';    
      }    
      }   
     }  
     exit;
    }
    public function actionIndex(){
    $this->setTitle(NoiCore::lang()->t('user_chet'));      
     $data=array();   
  
    MoneyTransfer::fillUp();
    $user=NoiCore::user()->load();
     $data['history']=NoiCore::app()->db()->query(array(),"widthdrawals_request",array('user._id'=>$user['_id']),array('_id'=>-1),50,NoiCore::c('ppaginator')->getOffset(50));
     $data['count']=NoiCore::app()->db()->count("widthdrawals_request",array('user._id'=>$user['_id']));
     $data['pages']=NoiCore::c('ppaginator')->show($data['count'],50);
     
     return $this->render("bill",$data);   
    }
}

