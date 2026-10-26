<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("db/index");?>"><?php echo NoiCore::app()->lang("links_config_db");?></a></li>
  <li class="active">управление</li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_db");?></h2>
<ul class="nav nav-tabs">
    <li  ><a  href="<?php echo   NoiCore::app()->getRoute('db/import');?>"><?php echo NoiCore::app()->lang("database_import");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/export');?>"><?php echo NoiCore::app()->lang("database_export");?></a></li>
      <li class="active"><a href="<?php echo   NoiCore::app()->getRoute('db/manage');?>"><?php echo NoiCore::app()->lang('db_manage');?></a></li>
</ul>
<h4><?php echo NoiCore::app()->lang('db_select_c');?></h4>
<table class="table">
<?
foreach($collections as $collection){
?>
    <tr>
        <td><?php echo $collection;?></td>
        <td><a href="<?php echo   NoiCore::app()->getRoute('db/m/'.$collection);?>"><?php echo NoiCore::app()->lang('db_manage');?></a></td>
    </tr>
<?
}
?>
</table>