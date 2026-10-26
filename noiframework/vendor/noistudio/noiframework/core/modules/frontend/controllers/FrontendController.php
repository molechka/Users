<?php

namespace noicms\frontend\controllers;
use yii\extensions\mongogrid\MongoGrid;
use Yii;
use noicms\mongogrid\system_core\MGQuery;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Request;
use app\models\ManualInstall;

use yii\mongodb\Query;

class FrontendController extends Controller
{
  public $enableCsrfValidation = false;
  
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

  function removeqsvar($url, $varname,$val) {
  if(is_array($val)){
   if(count($val)>0){
    foreach($val as $vkey=>$vval){
     $url=$this->removeqsvar($url, $varname."[".$vkey."]", $vval);   
    }   
   }   
  }else {   
   $url=str_replace("?".$varname."=".$val,"",$url); 
   $url=str_replace("&".$varname."=".$val,"",$url); 
   $url=str_replace($varname."=".$val,"",$url);
  }
   return $url;
}
    public function actionIndex($url="")
    {
Yii::trace(" Всем привет!");

       $route="";
        
   if(count($_GET)>0){
   foreach($_GET as $vname=>$val){
   
   $_SERVER['QUERY_STRING']=$this->removeqsvar($_SERVER['QUERY_STRING'], $vname,$val);  
   
   }    
   }

 
        
    if(isset($_SERVER['PATH_INFO'])){
     $route=$_SERVER['PATH_INFO'];
     }else if(isset($_SERVER['QUERY_STRING'])){
     $route=$_SERVER['QUERY_STRING'];
     }
 
$tmp=explode("from",$route);
$route=$tmp[0];
$tmp=explode("isnoi",$route);
$route=$tmp[0];
  $tmp_admin_found=str_replace(\Yii::$app->params['admin_folder'],"",$route);
    $default_route="site/index";
    if($tmp_admin_found!=$route){


    }
     $tmp_str=str_replace("/","",$route);


//     $res=yii::app()->session['ref'];

//     if(strlen($tmp_str)>1){
//     $result=MGQuery::execute(array(),"cms_users",array('login'=>$tmp_str));
//
//     if(isset($result[0]['_id'])){
//     $route="/user/register/index.html";
//
//     $_GET['ref']=$tmp_str;
//  yii::app()->session->add("ref",$tmp_str);
//     }
//
//     }else {
//     $_GET['type']="site";
//     }
       if(isset($res) and$res>2){

     $_GET['ref']=$res;
     }
     
if(isset($_GET['install'])){

 $count_install=MGQuery::count("install_success", array());
 
 if($count_install==0){
    
            $install=new \noicms\core\ManualInstall;
 }

}




      $pos = strpos($route, "set_language");

      if($pos===false){

      }else {
       if($pos==0){
        $route="";
       }
      }

            $route_new=explode("?",$route);

            if(isset($route_new[0])){
             $route=$route_new[0];
              $route_new=explode("&",$route);
                 if(isset($route_new[0])){
                    $route=$route_new[0];
                 }

            }


            $app=new AppController("www","","domain_site",$route);
           $_POST['default_redirect']="off";
            $render_site=$app->return_render();
            
           echo $render_site;

            $this->render("notify");
        
    }








}
