<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("market/setup");?>"><?php echo NoiCore::app()->lang("links_market");?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang("market_install_plugins");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang('market_install_plugins');?></h2>

<p><?php echo NoiCore::app()->lang("market_yours_name");?> <?php echo $user['name'];?>, <?php echo NoiCore::app()->lang("market_your_have_money");?> <?php echo $user['user_money'];?>$</p>
<div class="col-sm-10">
<?
if(isset($plugins) and count($plugins)>0){
foreach($plugins as $plugin){    
?>
<div class="col-sm-4 alert_danger">
<h4><a target="_blank"   href="http://noicms.com/nmarket/item/<?php echo $plugin['shortname'];?>.html"><?php echo $plugin['title'];?></a></h4>

<img class="img-thumbnail" src="http://noicms.com/<?php echo $plugin['image'];?>">

<?
if(!file_exists(YII_PLUGIN_PATH."".$plugin['shortname']."/config.php")){
?>
<button class="btn btn-danger"><?php echo NoiCore::app()->lang("market_price");?> <?php echo $plugin['price'];?>$</button>
<p><a href="<?php echo   NoiCore::app()->getRoute("market/plugins");?>?install=<?php echo $plugin['shortname'];?>" class="btn btn-success"><?php echo NoiCore::app()->lang("market_buy");?></a></p>
<?
}else {
?>
<button class="btn btn-danger"><?php echo NoiCore::app()->lang("market_installed");?></button>
<?
}
?>
</div>
<?
}
}
?>
</div>