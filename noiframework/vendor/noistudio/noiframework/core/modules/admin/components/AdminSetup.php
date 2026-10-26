<?php
namespace noicms\admin\components;
class AdminSetup{
    public function render($file,$data){
    $path=Yii::getPathOfAlias('application.modules.admin.views.mysites');
    $path=$path."/".$file.".php";
    $data['cur']=new AdminSetup;
    if(file_exists($path)){
   $text= Yii::app()->controller->renderFile($path,$data);
   $text=  AdminController::change_text($text);
   return $text;
    }


    }
      public function render_setup($view,$data,$full=0){
    $uc=new ViewUserComponent();
 return $uc->render_setup($view, $data,$full);
    }
}

