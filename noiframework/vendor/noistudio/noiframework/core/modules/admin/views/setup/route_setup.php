<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("links_config_route");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_route");?></h2>
<form action="" method="POST">
    <table class="table">
        <tr>
            <td><input type="text" name="seo_url"></td>
            <td>&rightrightarrows;</td>
            <td><input type="text" name="normal_url"></td>
            <td><input class="btn btn-success" type="submit" name="act_add" value="<?php echo NoiCore::app()->lang("add");?>"></td>
        </tr>
    </table>
</form>
<table class="table">
<?
if(isset($route) and count($route)>0){
 foreach($route as $key=>$array){
  ?>
      <tr>
            <td><?php echo $array['seo'];?></td>
            <td>&rightrightarrows;</td>
            <td><?php echo $array['normal'];?></td>
            <td><a href="?delete=<?php echo $key;?>" class="btn btn-danger"><?php echo NoiCore::app()->lang("delete");?></a></td>
        </tr>
  <?
 }
}
?>
</table>

