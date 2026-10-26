<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\mongogrid\system_core\MGQuery;
use app\extensions\elfinder\elFinder;
use app\extensions\elfinder\elFinderConnector;

use app\extensions\elfinder\elFinderVolumeDriver;
use app\extensions\elfinder\elFinderVolumeLocalFileSystem;

 class FilemanagerController extends AdminController{
 public function init($login=false){
     parent::init($login);
     Yii::$app->params['current_page']="filemanager";
    if(AdminController::isRoot()==false){
      Yii::$app->controller->redirect(AdminController::getAdminLink("index"));
     }
  }

     function actionIndex(){

   return $this->render("index",array());
     }
     public function actionSetup(){
      
    $opts = array(
	 'debug' => false,
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => DOCUMENT_ROOT .'/tmp/files/',         // path to files (REQUIRED)
			'URL'           =>  '/tmp/files/', // URL to files (REQUIRED)
                     'alias'         => NoiCore::app()->lang('main_filemanager'),
			'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
		),
//             array(
//            'driver'        => 'LocalFileSystem',
//            'path'          =>  $_SERVER['DOCUMENT_ROOT'] .'/themes/widget/userthemes/'.$site['_id']->__toString().'/tpl/',
//            'URL'           => '/themes/widget/userthemes/'.$site['_id']->__toString().'/tpl/',
//            'alias'         => 'Template files',
//             'attributes' => array(
//          array(
//            'pattern' => '/^$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
//            'read'    => false,
//            'write'   => false,
//            'locked'  => true,
//            'hidden'=>true,
//
//        ),
//                  array(
//            'pattern' => '/^.tpl$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
//            'read'    => true,
//            'write'   => true,
//            'locked'  => false,
//            'hidden'=>false
//
//        )
//    )
//        )
	)
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();
     }
     public function actionList(){
      $json_results=array();
      $results=scandir(DOCUMENT_ROOT."/tmp/files");

      if(count($results)>0){
      foreach($results as $res){
      if(is_file(DOCUMENT_ROOT."/tmp/files/".$res)){
      $json_results[]=array('value'=>"/tmp/files/".$res,"title"=>$res);
      }
      }
      }
      echo json_encode($json_results);
      exit;
     }
 }

