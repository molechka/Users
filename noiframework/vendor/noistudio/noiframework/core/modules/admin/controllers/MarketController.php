<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
 class MarketController extends AdminController{
 public function init($login=false){
     parent::init($login);
      Yii::$app->params['current_page']="market";
       if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }
  public function sendPost($url,$data){
    if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $out = curl_exec($curl);

    curl_close($curl);
    return $out;
  }
    }
   public function actionSetup(){
    if(isset($_POST['market_login']) and isset($_POST['market_password'])){
     $result_login=$this->sendPost("http://noicms.com/nmarket/api/login", "market_login=".$_POST['market_login']."&market_password=".$_POST['market_password']);
    if($result_login=="1"){
     NoiCore::app()->setSession("market_login",$_POST['market_login']);
     NoiCore::app()->setSession("market_password",$_POST['market_password']);
     NoiCore::app()->setSession("market_status",1);
    }
    }
     return $this->render("setup");
 }
 public function fastInstall($name,$type){
 if(isset($name) and isset($type) and ($type=="plugins" or $type=="templates")){
$results=$this->sendPost("http://noicms.com/nmarket/api/buy", "market_login=".NoiCore::app()->getSession("market_login")."&market_password=".NoiCore::app()->getSession("market_password")."&market_item=".$name);

if(!file_exists(YII_PLUGIN_PATH."".$name."/config.php") and $results!="none"){
$zip_path=DOCUMENT_ROOT."tmp/zip/plugin_".$name.".zip";
file_put_contents($zip_path, file_get_contents(trim($results)));
//$tmpfname = tempnam("/tmp", $type."_".$name);
//$handle = fopen($tmpfname, "w");
//fwrite($handle, $results);
$zip = new ZipArchive;
   if($type=="plugins"){
if(!file_exists(YII_PLUGIN_PATH."".$name)){
mkdir(YII_PLUGIN_PATH."".$name);
}
   }
     if($type=="templates"){
if(!file_exists(DOCUMENT_ROOT.THEMES_PATH."".$name)){
mkdir(DOCUMENT_ROOT.THEMES_PATH."".$name);
}
   }
if ($zip->open($zip_path) === TRUE) {
    if($type=="plugins"){
    $zip->extractTo(YII_PLUGIN_PATH."".$name);
    }
    if($type=="templates"){
      $zip->extractTo(DOCUMENT_ROOT.THEMES_PATH."".$name);
    }
    $zip->close();
   
} else {
  
}
}
 
 
 }
 }
 public function actionTemplate(){
    if(isset($_GET['install'])){
  $this->fastInstall($_GET['install'],"templates");
  }
  $results=$this->sendPost("http://noicms.com/nmarket/api/list", "market_login=".NoiCore::app()->getSession("market_login")."&market_password=".NoiCore::app()->getSession("market_password")."&market_type=templates");
 if (is_object(json_decode($results)))
    {
     $object=json_decode($results,true);

   return $this->render("templates",array('user'=>$object['user'],"templates"=>$object['items']));
    }
 }
 public function actionPlugins(){
  if(isset($_GET['install'])){
  $this->fastInstall($_GET['install'],"plugins");
  }
 $results=$this->sendPost("http://noicms.com/nmarket/api/list", "market_login=".NoiCore::app()->getSession("market_login")."&market_password=".NoiCore::app()->getSession("market_password")."&market_type=plugins");
 if (is_object(json_decode($results)))
    {
     $object=json_decode($results,true);
   return $this->render("plugins",array('user'=>$object['user'],"plugins"=>$object['items']));
    }
 
 }
 }


