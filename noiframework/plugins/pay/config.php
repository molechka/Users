<?php

$plugin_config=array();
$plugin_config['name']='Плагин  для пополнения счета';
$plugin_config['route']='pay';
$plugin_config['type_run']="route";

$plugin_config['mongogrid']=array(
"default"=>array(
 "label"=>'Основные настройки',
 "count"=>1,
 "fields"=>array(
 'field_money'=>array('type'=>'string','label'=>'поле профиля,пользователя где хранятся деньги'),
 
 'disable'=>array('type'=>'select','label'=>'статус','opt'=>array(array('value'=>'1','title'=>'выключено'),array('value'=>'0','title'=>'включено'))),
     )
),
 
);

