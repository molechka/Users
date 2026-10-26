<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
 
  <li class="active"><?php echo   NoiCore::app()->lang("plugins_list");?></li>
</ol>
<h2><?php echo   NoiCore::app()->lang("plugins_list");?></h2>
<?

if(isset($site['theme_components']['plugins']['available']) and is_array($site['theme_components']['plugins']['available']) ){

    $available=$site['theme_components']['plugins']['available'];
    ?>
<form action="" method="POST">
    <table class="table">
    
        <tr>
            <td><select name="name_install_plugin">
              <?
              if(isset($plugins) and count($plugins)>0){
              foreach($plugins as $plugin){
              if(!in_array($plugin,$available)){
              ?>
                    <option value="<?php echo $plugin;?>"><?php echo $plugin;?></option>
              <?
              }
              }
              }

              ?>
                </select></td>
            <td><input class="btn btn-success" type="submit" name="act_add_plugin" value="<?php echo NoiCore::app()->lang("plugin_list_add");?>"></td>
        </tr>
    </table></form>
<?
    if($available>0){
    ?>
<table class="table">

    <?
    foreach($available as $plugin){
    ?>
    <tr><td><?php echo $plugin;?></td>
        <td><a class="btn btn-success" href="<?php echo   NoiCore::app()->getRoute("p_".$plugin)?>"><?php echo NoiCore::app()->lang("plugin_list_setup");?></a></td>
        <td><a class="btn btn-danger" href="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/plugins/<?php echo $site['_id']->__toString();?>?plugin_nav=manage&delete_plugin=<?php echo $plugin;?>"><?php echo NoiCore::app()->lang("plugin_list_delete");?></a></td>
    </tr>
    <?

    }
    ?>
</table>
<?
    }
}
?>