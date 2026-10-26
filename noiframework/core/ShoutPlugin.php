<?php
class ShoutPlugin{
 static  public function getRoute2(){
     return "/".Yii::$app->params['admin_folder'];
 }
}