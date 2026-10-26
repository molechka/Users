<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("db/index");?>"><?php echo NoiCore::app()->lang("links_config_db");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("db/m/".$collection);?>"><?php echo $collection;?></a></li>
  <li class="active">#<?php echo $rowid;?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_db");?></h2>
<ul class="nav nav-tabs">
    <li  ><a  href="<?php echo   NoiCore::app()->getRoute('db/import');?>"><?php echo NoiCore::app()->lang("database_import");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/export');?>"><?php echo NoiCore::app()->lang("database_export");?></a></li>
      <li class="active"><a href="<?php echo   NoiCore::app()->getRoute('db/manage');?>"><?php echo NoiCore::app()->lang('db_manage');?></a></li>
</ul>
<h4><?php echo NoiCore::app()->lang('db_edit');?> </h4>
<form action="<?php echo   NoiCore::app()->getRoute('db/u/'.$collection."/".$rowid);?>" method="POST">
<table class="table">
    <tr>
        <td>
          _id
        </td>
        <td><?php echo $rowid;?></td>
    </tr>
    <tr>
        <td>data</td>
        <td><textarea name="data" rows="10" cols="60"><?php echo $json;?></textarea></td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
         <input type="submit" name="update_row" value="Update" class="btn btn-danger">  
        </td>
    </tr>
</table>
</form>
 

