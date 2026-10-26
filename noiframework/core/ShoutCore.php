<?php

class ShoutCore{
 static public function setNotify($str){
 
  \Yii::$app->session->setFlash('success', $str);

  }
    static public function getNotify(){
   return \Yii::$app->session->getAllFlashes();
  }
}

