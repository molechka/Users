
<a class="fupload" data-name="<?=$field->getNameField();?>" href="#">Выбрать изображение</a>
<input type="hidden"  value="<?=$value;?>" id="var_fupload_<?=$field->getNameField();?>" name="<?=$field->getNameField();?>">
<?
if(file_exists(DOCUMENT_ROOT.$value)){
?>
<img src="<?=$value;?>" id="fupload_<?=$field->getNameField();?>" style="width:50px">
<?
}else {
?>
<img src="" id="fupload_<?=$field->getNameField();?>" style="display:none;width:50px">
<?
}
?>
