<?php
namespace noicms\admin\components;
class AdminRender{
    public function render($file,$data){

    $path=Yii::getPathOfAlias('application.modules.admin.views.mysites');

    
    $path=$path."/".$file.".php";
   
    $data['cur']=new AdminRender;
    if(file_exists($path)){
   $text=Yii::app()->controller->renderFile($path,$data,$data,true);
   $text=  AdminController::change_text($text);
   return $text;
    }

    }
}

