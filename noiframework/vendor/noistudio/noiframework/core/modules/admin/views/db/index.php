<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("links_config_db");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_db");?></h2>
<ul class="nav nav-tabs">
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/import');?>"><?php echo NoiCore::app()->lang("database_import");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/export');?>"><?php echo NoiCore::app()->lang("database_export");?></a></li>
</ul>

<div class="alert alert-success">
    <p><?php echo NoiCore::app()->lang("database_welcome");?></p>
</div>
