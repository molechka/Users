

<?
$visulal_fields=array();
$button_label="Add record";



if(isset($plugin_config['mongogrid'][$main_field]['count']) and $plugin_config['mongogrid'][$main_field]['count']==1){
 $_GET['update']=0;

}
if(isset($_GET['update'])){
$button_label="Update Record";
}

if(isset($plugin_config['name'])){
?>
<h2><?php echo $plugin_config['name'];?></h2>
<?
}
?>
<?
if(isset($name_plugin)){
echo PluginsUserComponent::getToolbar($name_plugin,$site,array());
}

if(isset($plugin_config['mongogrid'][$main_field]['label'])){
?>
<h2><?php echo $plugin_config['mongogrid'][$main_field]['label'];?></h2>
<?
}
?>
<form id='update_form' action="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/plugins/<?php echo $id_site;?>?plugin_selected=<?php echo $name_plugin;?>&page=config&config_field=<?php echo $main_field;?>&type_run=ajax" method="POST" enctype="multipart/form-data">
    <table class="table">

<?

if(isset($fields) and count($fields)>0){
 foreach($fields as $field=>$data_field){
  $field_label=$field;
  if(isset($data_field['label'])){
  $field_label=$data_field['label'];
  }
  if(isset($data_field['type'])){
  if(!isset($data_field['opt'])){
  $data_field['opt']=array();
  }
  $data_field['opt']['id_site']=$site['_id']->__toString();
  $data_field['opt']['site']=$site;
  $visulal_fields[$field]=new OneField();
  $visulal_fields[$field]->init($field,$data_field['type'],$data_field['opt']);

  ?>  <tr>
            <td>
            <?php echo $field_label;?>
            </td>
            <td>
            <?


            if(isset($_GET['update']) ){

if(!isset($values[$_GET['update']][$field])){
 $values[$_GET['update']][$field]="";
}
          echo  $visulal_fields[$field]->getInput($values[$_GET['update']][$field]);
            }else {

          echo   $visulal_fields[$field]->getInput();
            }
            ?>

            </td>
            </tr>
  <?
  }
 }
}
if(isset($fields) and count($fields)>0){
?>
            <tr>
                <td>
                <?
                if(isset($_GET['update'])  and $_GET['update']>=0){
          ?>
          <input type="hidden" name="plugins_pos_update" value="<?php echo $_GET['update'];?>">
           <?
}
                ?>
                </td>
                <td><input type="hidden" name="plugin_add_row" value="<?php echo $button_label;?>">
                    <a href='javascript:addrow();' id='plugin_add_row'><?php echo $button_label;?></a>
                </td>
            </tr>
            <?
}
            ?>
    </table>
</form>
<table class="table">
  <?

  if(isset($values) and is_array($values) and count($values)>0 and !isset($_GET['update'])){
   foreach($values as $key=>$val){
   ?>
    <tr>
    <?


    if(isset($val)  and is_array($val) and count($val)>0){
    foreach($val as $sub_key=>$sub_val){
    ?>
        <td>
    <?
    if(isset($visulal_fields[$sub_key])){
    if(is_object($visulal_fields[$sub_key])){

        echo $visulal_fields[$sub_key]->showInput($sub_val);
    }
    }
    ?>
        </td>
    <?
    }
    }
    ?>
         
         <td><a  class="op_update" data-field="<?php echo $main_field;?>" data-update="<?php echo $key;?>" href="javascript:update_row_plugin('<?php echo $main_field;?>',<?php echo $key;?>);">Update</a></td>
        <td><a  class="op_delete" data-field="<?php echo $main_field;?>" data-delete="<?php echo $key;?>" href="javascript:delete_row_plugin('<?php echo $main_field;?>',<?php echo $key;?>);">Delete</a></td>
    </tr>
   <?
   }
  }
  ?>

</table>

