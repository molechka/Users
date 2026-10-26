<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("db/index");?>"><?php echo NoiCore::app()->lang("links_config_db");?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang("database_import");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_db");?></h2>
<ul class="nav nav-tabs">
    <li class="active" ><a  href="<?php echo   NoiCore::app()->getRoute('db/import');?>"><?php echo NoiCore::app()->lang("database_import");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/export');?>"><?php echo NoiCore::app()->lang("database_export");?></a></li>
</ul>
<form action="" method="POST" enctype="multipart/form-data">
<table class="table">
    <tr>
        <td>File(.js)</td>
        <td><input type="file" name="importfile"></td>
    </tr>
    <tr>
        <td></td>
        <td><input class="btn btn-danger" type="submit" name="act_import" value="<?php echo NoiCore::app()->lang("database_import");?>"></td>
    </tr>
</table>
</form>