 <?
$newdata=array('site'=>$site);
echo $cur->render_setup("editsite_bar",$newdata);
?>
<form action="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites_field/<?php echo $field['name']?>/<?php echo $site['_id']->__toString();?>" method="POST" enctype="multipart/form-data">
<table class="table">
    <tr>
        <td>Изображение</td>
        <td><input type="file" name="<?php echo $field['name'];?>"></td>
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
        <td><a href="<?php echo $val;?>"><img width="200px" src="<?php echo $val;?>"></a></td>
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