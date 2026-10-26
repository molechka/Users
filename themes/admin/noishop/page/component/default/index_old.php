<?
use noicms\mongogrid\OneField;
?>
<div class="alert alert-success">
<h2><?php echo NoiCore::app()->lang("fast_links");?></h2>
<ul class="nav nav-tabs">
    <li><a href="<?php echo   NoiCore::app()->getRoute('plugins')?>"><?php echo NoiCore::app()->lang("links_plugins_manage");?></a></li>
     <li><a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>
     <li><a href="<?php echo   NoiCore::app()->getRoute('wi/positions')?>"><?php echo NoiCore::app()->lang('links_widgets_manage_positions');?></a></li>
     <?
     if(NoiCore::admin()->isRoot()){
     ?>
     <li><a href="<?php echo   NoiCore::app()->getRoute('db/index')?>"><?php echo NoiCore::app()->lang('links_config_db');?></a></li>
      <li><a href="<?php echo   NoiCore::app()->getRoute('setup')?>"><?php echo NoiCore::app()->lang('links_config_config');?></a></li>
      <li><a href="<?php echo   NoiCore::app()->getRoute('route')?>"><?php echo NoiCore::app()->lang('links_config_route');?></a></li>
        <li><a href="<?php echo   NoiCore::app()->getRoute('logs')?>"><?php echo NoiCore::app()->lang('links_config_logs');?></a></li>
          <li><a href="<?php echo   NoiCore::app()->getRoute('template')?>"><?php echo NoiCore::app()->lang('links_config_template');?></a></li>
     <?
     }
     ?>
</ul>
</div>
<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#plugins" aria-controls="plugins" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang("links_plugins")?></a></li>
    <li role="presentation"><a href="#widgets" aria-controls="widgets" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="plugins">
<h2><?php echo   NoiCore::app()->lang("main_page_available_plugins");?></h2>
<p class="lead"><a href="<?php echo   NoiCore::app()->getRoute("plugins");?>"><?php echo NoiCore::app()->lang("main_page_install_plugins");?></a></p>
<?
$array_class=array('alert-danger','alert-error','alert-info','alert-success','alert-warning');

$result_site=NoiCore::app()->site_data;
 if(isset($result_site['theme_components']['plugins']['available']) and count($result_site['theme_components']['plugins']['available'])>0){
 include(YII_COMPONENT_PATH."plugins/CoreAdminControllerPlugin.php");
  foreach($result_site['theme_components']['plugins']['available'] as $plugin){
  include_once $_SERVER['DOCUMENT_ROOT']."/".NOIPRODUCT_FOLDER."/plugins/".$plugin."/config.php";
$plugin_name=$plugin;
if(isset($plugin_config['name'])){
$plugin_name=$plugin_config['name'];
}
$plugin_config=array();
$random_keys=array_rand($array_class);

?>
<div class="col-sm-4 <?php echo $array_class[$random_keys];?>">
<h4><a href="<?php echo   NoiCore::app()->getRoute("p_".$plugin)?>"><?php echo $plugin_name;?></a></h4>

<?

$admin_class=null;

if(file_exists(YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."AdminControllerPlugin.php")){
 include(YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."AdminControllerPlugin.php");
  $name_class=ucfirst($plugin)."AdminControllerPlugin";
 $admin_class=new $name_class($result_site);
}else if(file_exists(YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."ACP.php")){
include(YII_PLUGIN_PATH."".$plugin."/controllers/admin/".  ucfirst($plugin)."ACP.php");
 $name_class=ucfirst($plugin)."ACP";
 $admin_class=new $name_class($result_site);

}

if($admin_class!=null){
  echo $admin_class->render("toolbar");
}
?>
</div>
<?
  }
 }
?>
</div>
      <div role="tabpanel" class="tab-pane" id="widgets">
    <?
 $positions=array();   
 $widgets=array();
if(isset($site['theme_components']['widgets']['positions_available']) and is_array($site['theme_components']['widgets']['positions_available'])){
$positions=$site['theme_components']['widgets']['positions_available'];
}

if(isset($site['theme_components']['widgets']['position']) and is_array($site['theme_components']['widgets']['position'])){
$widgets=$site['theme_components']['widgets']['position'];
}
$widget=  new OneField();
$widget->init("widget","widgetsselect",array('site'=>$site,'id_site'=>$site['_id']->__toString()));
?>
<h4><?php echo NoiCore::app()->lang("widgets_add");?></h4>
<form action="<?php echo   NoiCore::app()->getRoute("wi/all")?>" method="POST">
    <table class="table">
        <tr>
            <td><?php echo NoiCore::app()->lang("widgets_add_title");?></td>
            <td><input type="text" name="title" required="required" value=""></td>
        </tr>
        <tr>
            <td><?php echo NoiCore::app()->lang("widgets_add_widget")?></td>
            <td>
                <?
               echo $widget->getInput();
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo NoiCore::app()->lang("widgets_add_position");?></td>
            <td><select name="position">
              <?
              if(isset($positions) and is_array($positions) and count($positions)>0){
              foreach($positions as $pos){
              ?>
                    <option value="<?php echo $pos;?>"><?php echo $pos;?></option>
              <?
              }
              }
              ?>
                </select></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="btn btn-success" type="submit" name="act_add_widget" value="<?php echo NoiCore::app()->lang("widgets_add_button");?>"></td>
        </tr>
    </table>
</form>
<h2><?php echo NoiCore::app()->lang("widgets_list");?></h2>
<table class="table">
    <thead>
        <tr>
            <th>#id</th>
            <th><?php echo NoiCore::app()->lang("widgets_add_title");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_add_position");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>

            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>
        </tr>
    </thead>
    <tbody>
   <?
   $url=  ShoutPlugin::getRoute2()."widget/mysites_components/widgets/".$site['_id']->__toString();
   if(isset($widgets) and is_array($widgets) and count($widgets)>0){
    foreach($widgets as $pos=>$w){
     if(isset($w) and is_array($w) and count($w)>0){
      foreach($w as $number=>$plugin){
      if(isset($plugin['name']) and isset($plugin['show'])){
      $current_id=$plugin['name']."_".$number;
      if(isset($plugin['options']['id'])){
      $current_id=$plugin['options']['id'];
      }
      ?>
    <tr>

        <td>#<?php echo $current_id;?></td>
        <td>
      <? if(!isset($plugin['options']['title'])) { echo $plugin['name']; }else {
        echo $plugin['options']['title'];
      }?>
        </td>
        <td><?php echo $pos;?></td>
        <td>
        <?
        $tmp_number=$number+1;
        if($number>0){
        ?>
            <a href="<?php echo $url;?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=up"><i class="fa fa-arrow-up"></i></a>
        <?
        }
        ?>
        <?php echo $tmp_number;?>

        <?
        $next_number=$number+1;
        if(isset($w[$next_number]['name'])){
        ?>
            <a href="<?php echo $url;?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=down"><i class="fa fa-arrow-down"></i></a>
        <?
        }
        ?>
        </td>
        <td>
           <?
           if($plugin['show']=="0"){
           ?>
            <a href="<?php echo $url?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=show"><i class="fa fa-eye"></i></a>
           <?
            }else if($plugin['show']=="1"){
            ?>
            <a href="<?php echo $url?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=hide"><i class="fa fa-eye-slash"></i></a>
            <?
            }
           ?>
        </td>
        <td><a href="<?php echo $url;?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=config"><i class="fa fa-edit"></i></a></td>
        <td><a href="<?php echo $url;?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=delete"><i class="fa fa-trash-o"></i></a></td>
    </tr>
     <?
      }
      }
     }
    }
   }
   ?>
    </tbody>
</table>
      </div>

  </div>

</div>
