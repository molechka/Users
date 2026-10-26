<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("market/setup");?>"><?php echo NoiCore::app()->lang("links_market");?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang("market_install_template");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("market_install_template");?></h2>
<p><?php echo NoiCore::app()->lang("market_yours_name");?> <?php echo $user['name'];?>, <?php echo NoiCore::app()->lang("market_your_have_money");?> <?php echo $user['user_money'];?>$</p>
<div class="col-sm-10">
<?
if(isset($templates) and count($templates)>0){
foreach($templates as $template){
?>
<div class="col-sm-4 alert_danger">
<h4><a target="_blank"   href="http://noicms.com/nmarket/item/<?php echo $template['shortname'];?>.html"><?php echo $template['title'];?></a></h4>

<img class="img-thumbnail" src="http://noicms.com/<?php echo $template['image'];?>">

<?
if(!file_exists($_SERVER['DOCUMENT_ROOT'].THEMES_PATH."".$template['shortname']."/page/main.php")){
?>
<button class="btn btn-danger"><?php echo NoiCore::app()->lang("market_price");?> <?php echo $template['price'];?>$</button>
<p><a href="<?php echo   NoiCore::app()->getRoute("market/template");?>?install=<?php echo $template['shortname'];?>" class="btn btn-success"><?php echo NoiCore::app()->lang("market_buy");?></a></p>
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
</div><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

