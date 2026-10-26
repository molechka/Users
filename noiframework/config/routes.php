<?php  
include(DOCUMENT_ROOT."/conf/config.php");

if(!isset($config_admin['admin_folder'])){
 $config_admin['admin_folder']="admin";
}
if(!isset($config_admin['only_ip'])){
 $config_admin['only_ip']="";
}



return [
  
   
                '/' => 'site/index',

           
               
       $config_admin['admin_folder']=>'admin/default/index',
       $config_admin['admin_folder']."/"=>'admin/default/index',
       $config_admin['admin_folder']."/index"=>'admin/default/index',
   $config_admin['admin_folder'].'/about'=>'admin/default/about',
$config_admin['admin_folder'].'/auth/login'=>'admin/auth/login',
   $config_admin['admin_folder'].'/logout'=>'admin/auth/logout',
    $config_admin['admin_folder'].'/filemanager/setup'=>'admin/filemanager/setup',             $config_admin['admin_folder'].'/mobile/index'=>'admin/mobile/index',
    $config_admin['admin_folder'].'/mobile/logs'=>'admin/mobile/logs',
    $config_admin['admin_folder'].'/filemanager/list'=>'admin/filemanager/list',
    $config_admin['admin_folder'].'/filemanager/index'=>'admin/filemanager/index',
    $config_admin['admin_folder'].'/setup'=>'admin/setup/index',
     $config_admin['admin_folder'].'/market/setup'=>'admin/market/setup',
     $config_admin['admin_folder'].'/market/plugins'=>'admin/market/plugins',
      $config_admin['admin_folder'].'/market/template'=>'admin/market/template',
     $config_admin['admin_folder'].'/route'=>'admin/setup/route',
    $config_admin['admin_folder'].'/ajroute'=>'admin/setup/ajroute',
    $config_admin['admin_folder'].'/logs'=>'admin/log/index',
    $config_admin['admin_folder'].'/admins'=>'admin/admins/index',
     $config_admin['admin_folder'].'/admins/add'=>'admin/admins/add',
   $config_admin['admin_folder'].'/language/index'=>'admin/language/index', 
    $config_admin['admin_folder'].'/language/manage/<lang:.*>'=>'admin/language/manage',
    $config_admin['admin_folder'].'/language/update/<lang:.*>/<key:.*>'=>'admin/language/update',
    $config_admin['admin_folder'].'/language/delete/<lang:.*>/<key:.*>'=>'admin/language/delete',
   $config_admin['admin_folder'].'/language/add/<lang:.*>'=>'admin/language/add', 
   $config_admin['admin_folder'].'/trash/index'=>'admin/trash/index',
   $config_admin['admin_folder'].'/trash/delete/<rowid:.*>'=>'admin/trash/delete',
    $config_admin['admin_folder'].'/trash/restore/<rowid:.*>'=>'admin/trash/restore',
   $config_admin['admin_folder'].'/sessions/index'=>'admin/sessions/index',
   $config_admin['admin_folder'].'/sessions/delete/<rowid:.*>'=>'admin/sessions/delete',
    $config_admin['admin_folder'].'/sites/index'=>'admin/sites/index',
     $config_admin['admin_folder'].'/sites/copy/<siteid:.*>'=>'admin/sites/copy',
    $config_admin['admin_folder'].'/sites/update/<siteid:.*>'=>'admin/sites/update',
    $config_admin['admin_folder'].'/sites/delete/<siteid:.*>'=>'admin/sites/delete',
    $config_admin['admin_folder'].'/db/index'=>'admin/db/index',                              
    $config_admin['admin_folder'].'/db/import'=>'admin/db/import',
    $config_admin['admin_folder'].'/db/export'=>'admin/db/export',
   $config_admin['admin_folder'].'/db/manage'=>'admin/db/manage',
   $config_admin['admin_folder'].'/db/m/<select:.*>'=>'admin/db/m',
   $config_admin['admin_folder'].'/db/u/<select:.*>/<rowid:.*>'=>'admin/db/update',
   $config_admin['admin_folder'].'/db/delete/<select:.*>/<rowid:.*>'=>'admin/db/delete',
    $config_admin['admin_folder'].'/template'=>'admin/template/index',
    $config_admin['admin_folder'].'/plugins'=>'admin/plugin/all',
    $config_admin['admin_folder'].'/plugin/get/<plugin:.*>'=>'admin/plugin/get',
   $config_admin['admin_folder'].'/wi/get/<plugin:.*>'=>'admin/widget/get',
   $config_admin['admin_folder'].'/wi/positions'=>'admin/widget/positions',
    $config_admin['admin_folder'].'/wi/all'=>'admin/widget/all',
   $config_admin['admin_folder'].'/wi/<position:.*>/<number:.*>'=>'admin/widget/run',
   $config_admin['admin_folder'].'/wi/<position:.*>/<number:.*>/<data:.*>'=>'admin/widget/run',
    $config_admin['admin_folder'].'/p_<plugin:\w+>'=>'admin/plugin/manage',
    $config_admin['admin_folder'].'/p_<plugin:\w+>/<data:.*>'=>'admin/plugin/manage',
    $config_admin['admin_folder'].'widget/mysites/edit/<site_id:\w+>'=>'admin/mysites/edit',
    $config_admin['admin_folder'].'/mysites/edit/<site_id:\w+>'=>'admin/mysites/edit',
    $config_admin['admin_folder'].'/mysites_images/<site_id:\w+>'=>'admin/mysites/images',
    $config_admin['admin_folder'].'/mysites_components/<name:\w+>/<site_id:\w+>'=>'admin/mysites/components',
    $config_admin['admin_folder'].'widget/mysites_components/<name:\w+>/<site_id:\w+>'=>'admin/mysites/components',
    
        '<data:.*>' => 'site/index',

			];

