<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("db/index");?>"><?php echo NoiCore::app()->lang("links_config_db");?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang("database_export");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_db");?></h2>
<ul class="nav nav-tabs">
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/import');?>"><?php echo NoiCore::app()->lang("database_import");?></a></li>
    <li class="active"><a href="<?php echo   NoiCore::app()->getRoute('db/export');?>"><?php echo NoiCore::app()->lang("database_export");?></a></li>
</ul>
<h2><a target="_blank" href="<?php echo   NoiCore::app()->getRoute('db/export');?>?download=1"><?php echo NoiCore::app()->lang("database_download");?></a></h2>