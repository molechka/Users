<?php
namespace noicms\core;
use NoiCore;
use Yii;
class NoiMysql{
 
 public function get(){
    $connection=Yii::app()->db;
    return $connection;
 }
}
