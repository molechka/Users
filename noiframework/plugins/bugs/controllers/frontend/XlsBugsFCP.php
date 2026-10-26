<?php

class XlsBugsFCP extends CoreFrontendControllerPlugin {

    public function __construct($route,&$cur) {
        parent::__construct("bugs",$cur,$route);
         
         
    }
    public function actionIndex(){
      $json=array();
      if(NoiCore::user()->isLogin()){
        if(isset($_FILES['file'])){
         $result=  bugs\models\FileModel::doArray($_FILES['file']);
         if(!is_array($result)){
         $json=array('message'=>'Файл имеет неправильный формат.Поддерживаемые форматы csv,xls, xlxs');    
         }else {
        $document_unworked=bugs\models\FileModel::isPay($result,$_FILES['file']);     
        if(is_array($document_unworked)){  
         $json=array('message'=>'Файл загружен ,его обработка закончилась.','redirect'=>'/bugs/xls/view/'.$document_unworked['last_id']);     
        }else {
          
        }
         }
        }
      }else {
      $json=array('message'=>'Вы не авторизованы!');    
      }
      
      echo json_encode($json);
        exit;
   
    }
    public function actionDownload($last_id){
     if(is_numeric($last_id) and NoiCore::user()->isLogin()){
     $user=NoiCore::user()->load();    
     $query=NoiCore::app()->db()->query(array(),"documents_filtered",array('ispay'=>1,'user._id'=>$user['_id'],'last_id'=>(int)$last_id));
     if(isset($query[0]['_id'])){
         \bugs\models\FileModel::generateFromArr($query[0]);
         exit;
     }
     }
    }
     public function actionFinish($last_id){
     if(is_numeric($last_id) and NoiCore::user()->isLogin()){
     $user=NoiCore::user()->load();    
     $query=NoiCore::app()->db()->query(array(),"documents_filtered",array('ispay'=>1,'user._id'=>$user['_id'],'last_id'=>(int)$last_id));
     if(isset($query[0]['_id'])){
     $data=array();
     $query[0]=  bugs\models\FileModel::getTotalMoney($query[0]);
     $data['name_file']=basename($query[0]['file']);
     $data['result']=$query[0];
     $data['file']=$query[0];
     return $this->render("finish_file",$data);    
     }
     }
    }
    public function actionSave($last_id){
         if(is_numeric($last_id) and NoiCore::user()->isLogin()){
     $user=NoiCore::user()->load();    
     $query=NoiCore::app()->db()->query(array(),"documents_filtered",array('ispay'=>array('$ne'=>1),'user._id'=>$user['_id'],'last_id'=>(int)$last_id));
     
     
     if(isset($query[0]['_id'])){
      NoiCore::app()->setSession("saved_lastid",$last_id);  
      NoiCore::app()->redirect("/historyop/index");
      exit;
     } 
         }
    }
    public function actionView($last_id){
     if(is_numeric($last_id) and NoiCore::user()->isLogin()){
     $user=NoiCore::user()->load();    
     $query=NoiCore::app()->db()->query(array(),"documents_filtered",array('ispay'=>array('$ne'=>1),'user._id'=>$user['_id'],'last_id'=>(int)$last_id));
     
     
     if(isset($query[0]['_id'])){
//    $file2=array('name'=>DOCUMENT_ROOT.$query[0]['file'],'tmp_name'=>DOCUMENT_ROOT.$query[0]['file']);
//   
//     print_r(bugs\models\FileModel::doArray($file2));
//     exit;     
     $data=array();
     $query[0]=  bugs\models\FileModel::getTotalMoney($query[0]);
     $data['name_file']=basename($query[0]['file']);
     $data['result']=$query[0];
     $data['file']=$query[0];
     $data['canpay']=true;
     if($user['user_money']<$query[0]['totalmoney']){
     $data['canpay']=false;    
     }
     return $this->render("preview_file",$data);    
     }
     }
    }
    
    public function actionPay($last_id){
       if(is_numeric($last_id) and NoiCore::user()->isLogin()){
     $user=NoiCore::user()->load();    
     $query=NoiCore::app()->db()->query(array(),"documents_filtered",array('ispay'=>array('$ne'=>1),'user._id'=>$user['_id'],'last_id'=>(int)$last_id));
     if(isset($query[0]['_id'])){
      $result=  bugs\models\FileModel::getTotalMoney($query[0]);
      $elements=count($result['results']);
      $money=  \user\models\MManager::minus($user['_id']->__toString(), $result['totalmoney'], 'оплата за обработку '.$elements." строк", 1,array());   
      if($money){
      $array_insert=array();
      $array_insert['date']=new MongoDate;
      $array_insert['count']=$elements;
      $array_insert['user']=$user;
      $array_insert['price']=$result['totalmoney'];
      NoiCore::app()->db()->insert($array_insert,"stats_pay");
      NoiCore::app()->db()->update(array('ispay'=>1),"documents_filtered",array('ispay'=>array('$ne'=>1),'user._id'=>$user['_id'],'last_id'=>(int)$last_id));
      NoiCore::app()->redirect("/bugs/xls/finish/".$result['last_id']);
      }else {
      NoiCore::app()->setNotify("У вас не хватает денег на счету");    
      NoiCore::app()->returnback();    
      }
      exit;
      
     }
       }
    }
}

