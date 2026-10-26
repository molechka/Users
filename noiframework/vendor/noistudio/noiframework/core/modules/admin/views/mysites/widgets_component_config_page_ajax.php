<form action="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/widgets/<?php echo $id_site;?>?position=<?php echo $position;?>&number=<?php echo $number;?>&op=config"  method="POST">
<table class="table">
    <tr>
        <td>Title</td>
        <td><input type="text" name="title" value="<?if(isset($options['title'])) { echo $options['title'];}?>"></td>
    </tr>
    <tr>
        <td>Class</td>
        <td><input type="text" name="class" value="<?if(isset($options['class'])) { echo $options['class'];}?>"></td>
    </tr>
    <tr>
        <td>Id#</td>
        <td><input type="text" name="id" value="<?if(isset($options['id'])) { echo $options['id'];}?>"></td>
    </tr>
    <tr>
        <td>Visible only segment</td>
        <td>
       <?
       $visible_field=new OneField();
       $visible_field->init("visible", "multi", array('fields'=>array('link'=>array('type'=>'string','default_value'=>"",'opt'=>array(),'label'=>'URL Segment'))));
       if(isset($options['visible'])){
       echo $visible_field->getInput($options['visible']);
       }else {
       echo $visible_field->getInput();
       }

       ?>
        </td>
    </tr>
    <tr>
        <td>Invisible only segment</td>
          <td>
       <?
       $visible_field=new OneField();
       $visible_field->init("invisible", "multi", array('fields'=>array('link'=>array('type'=>'string','default_value'=>"",'opt'=>array(),'label'=>'URL Segment'))));
       if(isset($options['invisible'])){
       echo $visible_field->getInput($options['invisible']);
       }else {
       echo $visible_field->getInput();
       }

       ?>
        </td>
    </tr>
    <tr>
        <td>Visible all page</td>
        <td><input type="checkbox" value="1" <?if(isset($options['visible_all']) and $options['visible_all']=="1") { echo "checked";}?> name="visible_all"></td>
    </tr>

    <tr>
        <td></td>

        <td><input type="submit" id="act_edit_widget" name="act_edit_widget" value="Save changes"></td>

    </tr>
</table>
</form>
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
echo PluginsUserComponent::getToolbar($name_plugin,$site,array(),1,array('position'=>$position,"number"=>$number));
}

if(isset($plugin_config['mongogrid'][$main_field]['label'])){
?>
<h2><?php echo $plugin_config['mongogrid'][$main_field]['label'];?></h2>
<?
}
?>
<form action="<?php echo $current_url;?>&config_field=<?php echo $main_field;?>&type_run=ajax" method="POST" enctype="multipart/form-data" id='update_form' >
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
                <td><input type="hidden"     name="plugin_add_row" value="<?php echo $button_label;?>">
                <a href='javascript:addrow();' id='plugin_add_row'><?php echo $button_label;?></a></td>
            </tr>
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
        <td><?
        $tmp_key=$key+1;
        $new_key=$key-1;

        if(isset($values[$new_key])){
        ?>
            <a data-curkey="<?php echo $key;?>" class="op_move" data-op="up"  href="javascript:movekey(<?php echo $key;?>,'up');">up</a>
        <?
        }
        ?>
        <?php echo $tmp_key;?>
           <?
        $new_key_next=$key+1;

        if(isset($values[$new_key_next])){
        ?>
             <a data-curkey="<?php echo $key;?>" class="op_move" data-op="down" href="javascript:movekey(<?php echo $key;?>,'down');">down</a>
        <?
        }
        ?>
        </td>
        <td><a  class="op_update" data-field="<?php echo $main_field;?>" data-update="<?php echo $key;?>" href="javascript:update_row('<?php echo $main_field;?>',<?php echo $key;?>);">Update</a></td>
        <td><a  class="op_delete" data-field="<?php echo $main_field;?>" data-delete="<?php echo $key;?>" href="javascript:delete_row('<?php echo $main_field;?>',<?php echo $key;?>);">Delete</a></td>
    </tr>
   <?
   }
  }
  ?>

</table>

