<?php

$plugin_config=array();
$plugin_config['name']='Плагин для просмотра финансовой истории';
$plugin_config['route']='historyop';
$plugin_config['type_run']="route";

$plugin_config['mongogrid']=array(
"default"=>array(
 "label"=>'Основные настройки',
 "visible"=>false,
 "count"=>1,
 "fields"=>array(
  'collection'=>array('type'=>'string','label'=>'название коллекции где хранится история'),
  'field_id_user'=>array('type'=>'string','label'=>'ключ айди пользователя'),
     
     )
),
 
);



