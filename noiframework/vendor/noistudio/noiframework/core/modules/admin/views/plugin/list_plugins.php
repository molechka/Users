<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo   NoiCore::app()->lang("plugins_list");?></li>
</ol>
<h2><?php echo   NoiCore::app()->lang("plugins_list");?></h2>
<?

if(count($new)>0 ){


    ?>
<form action="" method="POST">
    <table class="table">

        <tr>
            <td><select name="name_install_plugin">
              <?

              foreach($new as $n){
             
              ?>
                    <option value="<?php echo $n;?>"><?php echo $n;?></option>
              <?
              
              }
              

              ?>
                </select></td>
            <td><input class="btn btn-success" type="submit" name="act_add_plugin" value="<?php echo NoiCore::app()->lang("plugin_list_add");?>"></td>
        </tr>
    </table></form>
<?
}
    if(count($plugins)>0){
    ?>
<table class="table">

    <?
    foreach($plugins as $plugin){
    ?>
    <tr><td><?php echo $plugin;?></td>
        <td><a class="btn btn-success" href="<?php echo   NoiCore::app()->getRoute("p_".$plugin)?>"><?php echo NoiCore::app()->lang("plugin_list_setup");?></a></td>
        <td><a class="btn btn-danger" href="?delete_plugin=<?php echo $plugin;?>"><?php echo NoiCore::app()->lang("plugin_list_delete");?></a></td>
    </tr>
    <?

    }
    ?>
</table>
<?
    }

?>