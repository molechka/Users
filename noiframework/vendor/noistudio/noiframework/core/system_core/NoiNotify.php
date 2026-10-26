<?php
/*
 *
 * @package NoiCore
 *
 *
 */
namespace noicms\core;
use NoiCore;
use Yii;
class NoiNotify{

    /**
     *
     * NoiCore::notify()->set($str)
     * @param  string $str  string notify
     * @return void
     *
     *
     */

public function set($str=""){
 if(isset($str) and is_string($str) and strlen($str)>1){
     $notify_array=NoiCore::app()->getSession("notify_array");
     if(!is_array($notify_array)){
     $notify_array=array();
     }
     $notify_array[]=$str;
     NoiCore::app()->setSession("notify_array",$notify_array);
 }
}
/**
 *
 * NoiCore::notify()->getAll();
 * @return array of notify : array('notify1','notify2','notify3');
 *
 *
 */
public function getAll(){
 $notify_array=NoiCore::app()->getSession("notify_array");

   if(!is_array($notify_array)){
     $notify_array=array();
     }else {
      $folder="frontend";
       if(isset(\Yii::$app->params['isadminrigtnow']) and \Yii::$app->params['isadminrigtnow']==1){
       $folder="admin";
       }
       if($folder=="admin"){
        $this->removeAll();
       }
     }
    return $notify_array;

}
public function removeAll(){
    NoiCore::app()->removeSession("notify_array");
}
}
