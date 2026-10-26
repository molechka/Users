<?php

$plugin_config=array();
$plugin_config['name']='html plugin';
$plugin_config['route']='html';
$plugin_config['type_run']="oncall";

$plugin_config['fields']=array(



);
$plugin_config['mongogrid']=array(
"default"=>array(
 "label"=>NoiCore::app()->lang('html_main'),
"count"=>1,
 "fields"=>array(
 'content'=>array('type'=>'guieditor','label'=>NoiCore::app()->lang('html_content')),
     )
)
        );
$list_languages=NoiCore::app()->getListLanguges();
 
if(count($list_languages)>0 and NoiCore::lang()->is()){
 foreach($list_languages as $lang){
 $plugin_config['mongogrid']['default']['fields']['content_'.$lang]=array('type'=>'guieditor','label'=>NoiCore::app()->lang('html_content').'('.$lang.')');
 }   
}
 