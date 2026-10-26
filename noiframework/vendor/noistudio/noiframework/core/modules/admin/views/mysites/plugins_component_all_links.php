<?
if(NoiCore::admin()->isMainPage()==false){
?>

<?
}
?>
<?php
$main_field="";
$endurl="";
$subattr="";

if(isset(Yii::$app->params['type_run']) and Yii::$app->params['type_run']=="ajax"){
 
}
if(isset($plugin_config['mongogrid']) and is_array($plugin_config['mongogrid']) and count($plugin_config['mongogrid'])>0){
foreach($plugin_config['mongogrid'] as $mkey=>$mfield){


$label_m=$mkey;
if(isset($plugin_config['mongogrid'][$mkey]['label'])){
$label_m=$plugin_config['mongogrid'][$mkey]['label'];
}
if(!isset($mfield['visible']) or $mfield['visible']==true){
if($controller->iswidget==0){
$subattr=str_replace('replace_href',ShoutPlugin::getRoute2()."widget/mysites_components/plugins/".$id_site."?plugin_selected=".$name_plugin."&page=config&config_field=".$mkey.$endurl,$subattr);


?>

<p><a class='ajax_link' <?php echo $subattr;?> href="<?php echo   ShoutPlugin::getRoute2();?>/p_<?php echo $name_plugin;?>/config/<?php echo $mkey;?><?php echo $endurl;?>"><?php echo $label_m;?></a></p>
<?
}else {
if(isset($controller->widget['position']) and isset($controller->widget['number'])){
$position=$controller->widget['position'];
$number=$controller->widget['number'];
 
?>
 
<p><a class='ajax_link' <?php echo $subattr;?>href="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $id_site;?>?position=<?php echo $position;?>&number=<?php echo $number?>&op=config&config_field=<?php echo $mkey;?><?php echo $endurl;?>"><?php echo $label_m;?></a></p>
<?
}
}
}
}
}
