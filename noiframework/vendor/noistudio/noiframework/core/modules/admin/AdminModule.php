<?php
namespace noicms\admin;
 
use Yii;
use noicms\mongogrid\system_core\MGQuery;
use NoiCoreSet;
use NoiCore;  
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/NoiCore.php";
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/NoiCoreSet.php";
 
 
class AdminModule extends \yii\base\Module
{
 public $controllerNamespace = 'noicms\admin\controllers';
  public $layout="main";
 
	public function init()
	{
       
            
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/components/AdminController.php";
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/components/AdminIdentify.php";
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/components/AdminRender.php";
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/components/AdminSetup.php";
require_once PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/modules/admin/components/SetupSite.php";
require_once PATH_TO_ENGINE."/core/ShoutController.php";
require_once PATH_TO_ENGINE."/core/ShoutCore.php";
require_once PATH_TO_ENGINE."/core/ShoutPlugin.php";
require_once PATH_TO_ENGINE."/core/SiteComponent.php";
require_once PATH_TO_ENGINE."/core/ThemeManage.php";
require_once PATH_TO_ENGINE."/core/UserComponent.php";
 
    // set the layout
    $this->layoutPath = ADMIN_PATH.''.Yii::$app->params['admin_theme'].'/page/';

    $this->layout="login_page";
 \Yii::$app->params['isadminrigtnow']=1;
  $site=  $this->getsite();
 
  if(isset($site['_id'])){

      NoiCoreSet::add($site);
      NoiCore::admin()->setAdminStyle();
         if(file_exists(DOCUMENT_ROOT."/conf/copyright.php")){
      require  (DOCUMENT_ROOT."/conf/copyright.php");
      if(count($copyright)>0){
      foreach($copyright as $kc=>$copy){
          
     if(is_string($copy)){
      NoiCore::admin()->set($copy,$kc);   
     }
        
      }    
      }
      }
      if(NoiCore::admin()->isLogin()){
      $this->layout="main";
      }
  }
 
 $router_string="";
 if(isset($_SERVER['QUERY_STRING'])){
 $router_string=$_SERVER['QUERY_STRING'];
 }else if(isset($_SERVER['PATH_INFO'])){
   $router_string=$_SERVER['PATH_INFO'];
 }
  $check_url=str_replace( \Yii::$app->params['admin_folder'],"",$router_string);
 if($check_url==$router_string){

     
 }
   $array_insert=array();
    $user_agent = $_SERVER["HTTP_USER_AGENT"];
  if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
  elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
  elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
  elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
  elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
  else $browser = "Неизвестный";
   $array_insert['user_agent']="Браузер -".$browser."<br>OC:".$this->getOS($_SERVER["HTTP_USER_AGENT"]);
   $array_insert['ip']=$_SERVER['REMOTE_ADDR'];
   $array_insert['route']=$router_string;
   $array_insert['date']=new \MongoDate();
  MGQuery::insert($array_insert, 'noicms_log');

	} 
        function getOS($userAgent) {
  // Создадим список операционных систем в виде элементов массива
    $oses = array (
        'iPhone' => '(iPhone)',
        'Windows 3.11' => 'Win16',
        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Используем регулярное выражение
        'Windows 98' => '(Windows 98)|(Win98)',
        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
        'Windows 2003' => '(Windows NT 5.2)',
        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME' => 'Windows ME',
        'Open BSD'=>'OpenBSD',
        'Sun OS'=>'SunOS',
        'Linux'=>'(Linux)|(X11)',
        'Safari' => '(Safari)',
        'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
        'QNX'=>'QNX',
        'BeOS'=>'BeOS',
        'OS/2'=>'OS/2',
        'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
    );
  
    foreach($oses as$os=>$pattern){
        if(preg_match("/$pattern/i", $userAgent)) { 
            return $os;
        }
    }
    return 'Unknown'; // Хрен его знает, чего у него на десктопе стоит.
}
        public function getsite(){
          require  (DOCUMENT_ROOT."/conf/config.php");
      
   if(isset($config['sitestorage']) and ($config['sitestorage']=="mongodb" or $config['sitestorage']=="json")){

   if($config['sitestorage']=="mongodb"){
   $url_host=$_SERVER['HTTP_HOST'];

    $result=MGQuery::execute2(array(), "widget_user_sites", array());
     if(count($result)>1){
      foreach($result as $r){
if(isset($r['subroute']) and $r['subroute']==$url_host){
   return $r;
}
      }
        foreach($result as $r){
if(isset($r['subroute']) and $r['subroute']=="*"){
   return $r;
}
      }
     }else {
     if(isset($result[0]['_id'])){
       return $result[0];
    }
     }
   
   }else {
include PATH_TO_ENGINE."/vendor/noistudio/noiframework/core/class/JsonDB.class.php";
$db=new JsonDB(PATH_TO_ENGINE."/data/json/");
  $result=$db->selectAll("mysite");
        if(isset($result[0])){
          return $result[0];
        }else {
          return array();
        }
   }
   }
        }


}




?>