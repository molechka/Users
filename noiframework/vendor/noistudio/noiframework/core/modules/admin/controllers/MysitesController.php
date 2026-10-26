<?php
namespace noicms\admin\controllers;
use Yii;
use NoiCore;
use noicms\admin\components\AdminController;
use noicms\admin\components\AdminRender;
use noicms\admin\components\SetupSite;
use noicms\core\StrInput; 
use NoiCoreSet;
use noicms\mongogrid\system_core\MGQuery;

 class MysitesController extends AdminController{
   public function init($login=false){
     parent::init($login);
     
  }
  public function actionEdit($site_id){
 $data=array();
 $data['render']=$this->mysites('edit', $site_id);
 $this->render("render",$data);
  }

    public function actionComponents($name="",$site_id=""){
  $value=$name;
  $value2=$site_id;
  $widget=new AdminRender;
       if(StrInput::is_Id($value2)){
      $condition_query=array();
    $condition_select=array();
    $site=array();
    $site[0]=  NoiCore::json()->get();
if($name=="widgets"){
  Yii::$app->params['current_page']="widget";
}else if($name=="plugins"){
  Yii::$app->params['current_page']="plugin";
}
    if(isset($site[0]['theme_components'][$value]) or  $value=="settings" or $value=="docs"){
      NoiCoreSet::add($site[0]); 
     $setup=new SetupSite(array('component'=>$value,'value'=>$value2,'site'=>$site[0]), $widget);
     $data['render']=$setup->render();



//     if(isset( Yii::$app->params['data_page'])){
//     $data['render']= Yii::$app->params['data_page'];
//     }
     //SiteComponent::render_setup("render",$data,1);
  return   $this->render("render",$data);
    }
    }
    }
    public function get_theme_config($name){
    $array_result=array();
    $result=  MGQuery::execute2(array(), 'widget_sites_themes_settings',array('theme'=>$name));
    if(isset($result[0]['_id'])){
       foreach($result as $row){
        $array_result[$row['name']]=array('name'=>$row['name'],'title'=>$row['title'],"type"=>$row['type'],"count"=>$row['count']);
       }
    }

    return $array_result;
    }
     public function get_theme_components($name,$type,$old_component){
       $file_path_config=DOCUMENT_ROOT."/themes/widget/".$type."/".$name."/config.php";
    if(file_exists($file_path_config)){
        include_once $file_path_config;
        $current_config=$config_array;
        if(isset($old_component['settings']['options']['fields'])){
        if(isset($current_config['settings']['options']['fields'])){
        foreach($old_component['settings']['options']['fields'] as $key=>$value){
         if(isset($value['value'])){
        $current_config['settings']['options']['fields'][$key]['value']=$value['value'];
         }
        }
        }
        }

        return $current_config;

    }
    }
//  public function mysites($value,$value2=""){
//    $condition_query=array();
//    $condition_select=array();
//    $array_roles=  ShoutController::getLogged('array_roles');
//if(isset($array_roles) and is_array($array_roles)){
//if(in_array("developer",$array_roles)){
//  $condition_query=array();
//  $condition_select=array();
//}
//}
//    if($value=="edit" and StrInput::is_Id($value2)){
//     if(isset($_POST['act_edit']) and strlen($_POST['act_edit'])>0){
//     $array_update=array();
//
//     if(isset($_POST['domain_site']) and strlen($_POST['domain_site'])>0){
//     $count_site=  MGQuery::count("widget_user_sites", array('domain_site'=> htmlspecialchars($_POST['domain_site'])));
//     if(isset($_POST['domain_site']) and $count_site==0){
//
//     $array_update['domain_site']=  htmlspecialchars($_POST['domain_site']);
//     }
//
//
//     }
//     $count_site_www=0;
//      if(isset($_POST['domain_www']) and strlen($_POST['domain_www'])>0){
//     $count_site_www=  MGQuery::count("widget_user_sites", array('domain_www'=> htmlspecialchars($_POST['domain_www'])));
//     if(isset($_POST['domain_www']) and $count_site_www==0){
//
//     $array_update['domain_www']=  htmlspecialchars($_POST['domain_www']);
//     }
//
//
//     }
//     if(isset($_POST['title'])){
//     $array_update['title']=  htmlspecialchars($_POST['title']);
//
//     }
//
//     if(isset($_POST['theme_site']) and strlen($_POST['theme_site'])>0 and $this->is_exist_theme($_POST['theme_site'])){
//     $site_new=  MGQuery::execute(array(), "widget_user_sites", $condition_query);
//
//     $array_update['theme_site']=$_POST['theme_site'];
//     $array_update['theme_config']=$this->get_theme_config($_POST['theme_site']);
//     if(!isset($array_update['theme_components'])){
//     $array_update['theme_components']=array()    ;
//     }
//     if(!isset($site_new[0]['theme_components'])){
//    $site_new[0]['theme_components']=array();
//     }
//     $array_update['theme_components']=$this->get_theme_components($_POST['theme_site'], $site_new[0]['type_site'],$site_new[0]['theme_components']);
//     }
//    if(count($array_update)>0){
//        MGQuery::update($array_update, "widget_user_sites", $condition_query);
//        ShoutCore::setNotify(Lang::t("component_notify_success_save"));
//
//    }
//      if($count_site>0){
//     ShoutCore::setNotify(Lang::t("component_notify_error_domain_exist"));
//     }
//      if($count_site_www>0){
//     ShoutCore::setNotify(Lang::t("component_notify_error_domain_exist"));
//     }
//
//
//     }
//
//     $site=  MGQuery::execute(array(), "widget_user_sites",$condition_query);
//     if(isset($site[0]['_id'])){
//     $data=array();
//
//     $data['site']=$site[0];
//    return  SiteComponent::render_setup("mysites_edit",$data,1);
//
//     }
//    }    else if($value=="show"){
//    $data=array();
//    $available=ShoutController::getLogged('available_site');;
//    if($available==""){
//    $available=0;
//    }
//    $data['available']=(int) $available;
//    $data['rows']=  MGQuery::execute2(array(), "widget_user_sites", $condition_select);
//   return SiteComponent::render_setup("mysites",$data);
//    }else {
//
//    }
//    }
 }

