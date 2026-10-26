 <?
$newdata=array('site'=>$site);
echo $cur->render_setup("editsite_bar",$newdata);
if(isset($fields)){
?>
<form action="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/settings/<?php echo $value;?>" method="POST">
<table class="table">
<?
  foreach($fields as $key=>$f){
  $label=$key;

 
  if(isset($f['label'])){
  $label=$f['label'];
  }
 ?>
    <tr>
        <td><?php echo $label;?>:</td>
        <td>
 <?
  $name=$key;
 if(!isset($f['type'])){
 echo $key;
 exit;
 }else {
  $type=$f['type'];
 }
  $value_sel="";
  if(isset($f['value'])){
  $value_sel=$f['value'];
  }
  if(isset($_POST['field_'.$name])){
  $value_sel=$_POST['field_'.$name];
  }
  if($type=="select"){
  ?>
<select name="field_<?php echo $name?>">
<?
if(isset($f['available'])){
 foreach($f['available'] as $option){
  $selected="";
  if($option['value']==$value_sel){
  $selected="selected";
  }
 ?>
    <option  <?php echo $selected;?> value="<?php echo $option['value']?>"><?php echo $option['title'];?></option>
 <?
 }
}
?>
</select>
  <?
  }else if($type=="input") {
  ?>
            <input type="text" value="<?php echo $value_sel;?>" name="field_<?php echo $name?>">
  <?
  }else if($type=="array"){
  ?>
            <a href="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_components/settings/<?php echo $value;?>/?field=<?php echo $key?>"><?php echo $label;?></a>
  <?
  }
  ?>
        </td></tr>
            <?
  }
}
?>
    <tr>
        <td></td>
        <td><input type="submit" name="act_save_settings" value="<?php echo Lang::t("field_edit_button_save");?>"></td>
    </tr>
</table>
</form>