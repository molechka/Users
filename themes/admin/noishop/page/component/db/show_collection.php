<?

?>
<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("db/index");?>"><?php echo NoiCore::app()->lang("links_config_db");?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang("database_import");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_db");?></h2>
<ul class="nav nav-tabs">
    <li  ><a  href="<?php echo   NoiCore::app()->getRoute('db/import');?>"><?php echo NoiCore::app()->lang("database_import");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute('db/export');?>"><?php echo NoiCore::app()->lang("database_export");?></a></li>
      <li class="active"><a href="<?php echo   NoiCore::app()->getRoute('db/manage');?>"><?php echo NoiCore::app()->lang('db_manage');?></a></li>
</ul>
<form action="<?php echo   NoiCore::app()->getRoute('db/m/'.$collection);?>" method="GET">
<table class="table">
    <tr>
        <td>Condition</td>
        <td><textarea name="condition" rows="3" cols="50"><? if(isset($_GET['condition'])) { echo $_GET['condition'];} ?></textarea></td>

    </tr>
    <tr><td>

        </td>
        <td>
            <input type="submit"  value="Filter" class="btn btn-danger">
        </td>
    </tr>
</table>
</form>
<h4><?php echo NoiCore::app()->lang('db_select_row');?></h4>
<table class="table">
<?
if(isset($rows) and count($rows)>0){
foreach($rows as $row){
?>
    <tr>
        <td><?php echo $row['_id']->__toString();?></td>
        <td><a href="<?php echo   NoiCore::app()->getRoute('db/u/'.$collection."/".$row['_id']->__toString());?>"><?php echo NoiCore::app()->lang('db_edit');?></a></td>
        <td><a href="<?php echo   NoiCore::app()->getRoute('db/delete/'.$collection."/".$row['_id']->__toString());?>"><?php echo NoiCore::app()->lang('db_delete');?></a></td>
    </tr>
<?
}
}
?>
</table>
<p><?php echo NoiCore::app()->lang('mongogrid_all');?>:<?php echo $counts;?></p>
 
<?

$condition_url="";
if(count($condition)>0){
$json_condition=  json_encode($condition);
$query_build=array('condition'=>$json_condition);
$condition_url="?".http_build_query($query_build);
}
 

echo NoiCore::c("ppaginator")->show($counts,10,NoiCore::app()->getRoute('db/m/'.$collection."".$condition_url));
?>

