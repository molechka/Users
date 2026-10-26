<?
use noicms\mongogrid\OneField;
?>
<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
 <li ><a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>
  <li class="active"><?if(isset($options['title'])) { echo $options['title'];}?></li>
</ol>
<form action=""  method="POST">
<table class="table">
    <tr>
        <td><?php echo NoiCore::app()->lang("widget_edit_title");?></td>
        <td><input type="text" name="title" value="<?if(isset($options['title'])) { echo $options['title'];}?>"></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("widget_edit_class");?></td>
        <td><input type="text" name="class" value="<?if(isset($options['class'])) { echo $options['class'];}?>"></td>
    </tr>
    <tr>
        <td>Id#</td>
        <td><input type="text" name="id" value="<?if(isset($options['id'])) { echo $options['id'];}?>"></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("widget_edit_visible_segment");?></td>
        <td>
       <?
       $visible_field=new OneField();
       $visible_field->init("visible", "multi", array('fields'=>array('link'=>array('type'=>'string','default_value'=>"",'opt'=>array(),'label'=>'URL'))));
       if(isset($options['visible'])){
       echo $visible_field->getInput($options['visible']);
       }else {
       echo $visible_field->getInput();
       }

       ?>
        </td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("widget_edit_invisible_segment");?></td>
          <td>
       <?
       $visible_field=new OneField();
       $visible_field->init("invisible", "multi", array('fields'=>array('link'=>array('type'=>'string','default_value'=>"",'opt'=>array(),'label'=>'URL'))));
       if(isset($options['invisible'])){
       echo $visible_field->getInput($options['invisible']);
       }else {
       echo $visible_field->getInput();
       }

       ?>
        </td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("widget_edit_access");?></td>
        <td><?
        $access_array=array();
        $access_array[0]=array('value'=>'all','title'=>NoiCore::app()->lang("widget_edit_access_for_all"));
        $access_array[1]=array('value'=>'auth','title'=>NoiCore::app()->lang("widget_edit_access_for_auth"));
        $access_array[2]=array('value'=>'noauth','title'=>NoiCore::app()->lang("widget_edit_access_for_guest"));
        
        $list_all_role=  NoiCore::app()->getListRoles();
       if(isset($list_all_role) and is_array($list_all_role) and count($list_all_role)>0){
       foreach($list_all_role as $s_role){
       $access_array[]=array('value'=>$s_role,'title'=>$s_role);
       }
       }
       $access_field=new OneField();
       $access_field->init("access", "select", $access_array);
       if(isset($options['access'])){
       echo $access_field->getInput($options['access']);
       }else {
       echo $access_field->getInput();
       }

       ?></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("widget_edit_visible_all_page");?></td>
        <td><input type="checkbox" value="1" <?if(isset($options['visible_all']) and $options['visible_all']=="1") { echo "checked";}?> name="visible_all"></td>
    </tr>

    <tr>
        <td></td>
       
        <td><input class="btn btn-success" type="submit" name="act_edit_widget" value="<?php echo NoiCore::app()->lang("widget_edit_save");?>"></td>

    </tr>
</table>
</form>
<?
$visulal_fields=array();
$button_label=NoiCore::app()->lang("widget_edit_add_button");



if(isset($plugin_config['mongogrid'][$main_field]['count']) and $plugin_config['mongogrid'][$main_field]['count']==1){
 $_GET['update']=0;

}
if(isset($_GET['update'])){
$button_label=NoiCore::app()->lang("widget_edit_save");
}
if(isset($plugin_config['name'])){
?>
<h2><?php echo $plugin_config['name'];?></h2>
<?
}
?>
<?
 

if(isset($plugin_config['mongogrid'][$main_field]['label'])){
?>
<h2><?php echo $plugin_config['mongogrid'][$main_field]['label'];?></h2>
<?
}
?>
<form action="" method="POST" enctype="multipart/form-data">
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
                <td><input class="btn btn-success" type="submit" name="plugin_add_row" value="<?php echo $button_label;?>"></td>
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
if(!is_array($sub_val)){
        echo $visulal_fields[$sub_key]->showInput($sub_val);
}else {
    echo count($sub_val);
}
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
            <a href="<?php echo $current_url;?>?cur_key=<?php echo $key;?>&op_row=up"><i class="fa fa-arrow-up"></i></a>
        <?
        }
        ?>
        <?php echo $tmp_key;?>
           <?
        $new_key_next=$key+1;
        
        if(isset($values[$new_key_next])){
        ?>
            <a href="<?php echo $current_url?>?cur_key=<?php echo $key;?>&op_row=down"><i class="fa fa-arrow-down"></i></a>
        <?
        }
        ?>
        </td>
        <td><a href="<?php echo $current_url;?>?config_field=<?php echo $main_field;?>&update=<?php echo $key;?>"><i class="fa fa-edit"></i></a></td>
        <td><a href="<?php echo $current_url;?>?config_field=<?php echo $main_field;?>&delete=<?php echo $key;?>"><i class="fa fa-trash-o"></i></a></td>
    </tr>
   <?
   }
  }
  ?>

</table>

