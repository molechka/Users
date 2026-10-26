<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
 <li ><a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>
  <li class="active"><?php echo NoiCore::app()->lang("links_widgets_manage_positions");?></li>
</ol>

<ul class="nav nav-tabs">
    <li ><a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>
      <li class="active" ><a href="<?php echo   NoiCore::app()->getRoute('wi/positions')?>"><?php echo NoiCore::app()->lang("links_widgets_manage_positions");?></a></li>
</ul>
<h4><?php echo NoiCore::app()->lang("widget_positions_add");?></h4>
<form action="" method="POST">
    <table class="table">
        <tr>
            <td><?php echo NoiCore::app()->lang("widget_positions_title");?></td>
            <td><input type="text" name="position" value=""></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="btn btn-success" type="submit" name="act_add_position" value="<?php echo NoiCore::app()->lang("widget_positions_add");?>"></td>
        </tr>
    </table>
</form>
<table class="table">
<?
if(isset($positions) and is_array($positions) and count($positions)>0){
foreach($positions as $key=>$pos){
?>
    <tr>
        <td><?php echo $pos;?></td>

        <td><a class="btn btn-danger" href="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $site['_id']->__toString();?>?manage=1&delete=<?php echo $key;?>"><?php echo NoiCore::app()->lang("widget_positions_delete");?></a></td>
    </tr>
<?
}
}
?>
</table>