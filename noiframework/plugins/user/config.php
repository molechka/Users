<?php
$array=array('data');
$array['data']=array(
array('value'=>'register','title'=>'register'),
array('value'=>'profile','title'=>'profile'),
array('value'=>'null','title'=>'null')

);

$plugin_config=array();
$plugin_config['name']='User System';
$plugin_config['route']='user';
$plugin_config['type_run']="route";

$plugin_config['mongogrid']=array(
"status_activate"=>array(
  "label"=>'Активация по Email',
  "count"=>1,
    'visible'=>false,
  'fields'=>array('status'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_activate_email'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
   'text_mail_from'=>array('type'=>'string','label'=>NoiCore::app()->lang('users_who'),'opt'=>array()),
 'text_mail_subject'=>array('type'=>'string','label'=>NoiCore::app()->lang('users_subject')."(active user)",'opt'=>array()),
  'text_mail'=>array('type'=>'guieditor','label'=>NoiCore::app()->lang('users_text'),'opt'=>array())),
   
),
 "token"=>array(
  "label"=>'Настройка токена',
  "count"=>1,
    'visible'=>false,
  'fields'=>array(
  'token'=>array('type'=>'string','label'=>"Токен авторазации",'opt'=>array()),
  'url'=>array('type'=>'string','label'=>"URL API",'opt'=>array())    
     )
     
 
   
),   
"default"=>array(
 "label"=>NoiCore::app()->lang('users_config'),
 "count"=>1,
  'visible'=>false,
 "fields"=>array(
 'status_captcha'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_captcha'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
 'status_register'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_page_register'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
'status_login'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_page_login'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
'status_lost'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_page_lost'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
 'status_profile'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_page_profile'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
 'status_list'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_page_list'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
 'collection'=>array('type'=>'string','label'=>NoiCore::app()->lang("users_name_collection")),
 'superroot'=>array('type'=>'string','label'=>NoiCore::app()->lang("users_global_password")),
 'after_login'=>array('type'=>'string','label'=>NoiCore::app()->lang("users_redirect_login")),
 'after_register'=>array('type'=>'string','label'=>NoiCore::app()->lang("users_redirect_register")),
 'auto_login'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_auto_enter'),'opt'=>array(array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')),array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')))),
  'text_lost_mail_from'=>array('type'=>'string','label'=>NoiCore::app()->lang('users_who')."(restore password)",'opt'=>array()),
 'text_lost_mail_subject'=>array('type'=>'string','label'=>NoiCore::app()->lang('users_subject')."(restore password)",'opt'=>array()),
  'text_lost_mail'=>array('type'=>'guieditor','label'=>NoiCore::app()->lang('users_text')."(restore password)",'opt'=>array())
     )
),'roles'=>array(
  "label"=>NoiCore::app()->lang('users_roles'),
  'visible'=>false,
   "fields"=>array(
    'name'=>array('type'=>'username','label'=>NoiCore::app()->lang('users_roles_name')),
    'default'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_roles_default') ,'opt'=>array(array('value'=>1,'title'=>NoiCore::app()->lang('users_enabled')),array('value'=>0,'title'=>NoiCore::app()->lang('users_disabled')))),
   )   
),'pages'=>array(
  'visible'=>false,
  "label"=>'Pages',
   "fields"=>array(
    'name_php'=>array('type'=>'username','label'=>'Name Php View in folder pages'),
    
   )
),"fields"=>array(

 "label"=>NoiCore::app()->lang('users_fields'),
 'visible'=>false,
 "fields"=>array(
 'name'=>array('type'=>'username','label'=>NoiCore::app()->lang('users_fields_name')),
 'label'=>array('type'=>'string','label'=>NoiCore::app()->lang('users_fields_title')),
 'default_status'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_fields_status_default_value'),'opt'=>array(array('title'=>NoiCore::app()->lang('users_enabled'),'value'=>1),array('title'=>NoiCore::app()->lang('users_disabled'),'value'=>0))),
 'default'=>array('type'=>'string','label'=>NoiCore::app()->lang('users_fields_default_value')),
 'opt'=>array('type'=>'textarea2','label'=>NoiCore::app()->lang('users_fields_array_json')),
 'required'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_fields_required'),'opt'=>array(array('value'=>1,'title'=>NoiCore::app()->lang('users_yes')),array('value'=>0,'title'=>NoiCore::app()->lang('users_no')))),
'unique'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_fields_unique'),'opt'=>array(array('value'=>1,'title'=>NoiCore::app()->lang('users_yes')),array('value'=>0,'title'=>NoiCore::app()->lang('users_no')))),
'type'=>array('type'=>'type','label'=>NoiCore::app()->lang('users_fields_type')),
 'available_pages'=>array('required'=>true,'type'=>'multiselect','label'=>NoiCore::app()->lang('users_fields_available_pages'),'opt'=>$array),
 'is_login'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_fields_is_username'),'opt'=>array(array('value'=>1,'title'=>NoiCore::app()->lang('users_yes')),array('value'=>0,'title'=>NoiCore::app()->lang('users_no')))),
  'is_password'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_fields_is_password'),'opt'=>array(array('value'=>1,'title'=>NoiCore::app()->lang('users_yes')),array('value'=>0,'title'=>NoiCore::app()->lang('users_no')))),
 'is_email'=>array('type'=>'select','label'=>NoiCore::app()->lang('users_fields_is_email'),'opt'=>array(array('value'=>1,'title'=>NoiCore::app()->lang('users_yes')),array('value'=>0,'title'=>NoiCore::app()->lang('users_no')))),
     )
));

