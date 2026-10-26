 <?
$newdata=array('site'=>$site);
echo $cur->render_setup("editsite_bar",$newdata);
$first_value="";
if($field['count']==1){
if(isset($values[0])){
$first_value=$values[0];
}
}
  $template=Yii::app()->getController()->widget('ext.redactor.ImperaviRedactorWidget',array(
    'name'=>$field['name'],
    'value'=>$first_value,
    // Redactor options
    'options'=>array(),
),true);
?>
<form action="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_field/<?php echo $field['name']?>/<?php echo $site['_id']->__toString();?>" method="POST" enctype="multipart/form-data">
<table class="table">
    <tr>
        <td><?php echo $field['title'];?></td>
        <td><?php echo $template;?></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit"  name="act_saving"  value="Сохранить"</td>
    </tr>
</table>
</form>
<?
if(isset($values) and count($values)>0){
?>
<table>
 <?
 $i=0;
 foreach($values as $val){
 ?>
    <tr>
        <td><?php echo $val;?></td>
        <td><a href="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_field/<?php echo $field['name']?>/<?php echo $site['_id']->__toString();?>?number=<?php echo $i;?>&delete=1">Удалить</a></td>
    </tr>
 <?
 $i++;
 }
 ?>
</table>
<?
}
?>
