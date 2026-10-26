<?
if(isset($result) and is_array($result) and count($result)>0){
 foreach($result as $row){
 if(isset($row['value']) and isset($row['title'])){
 ?>
<option value="<?php echo $row['value'];?>"><?php echo $row['title'];?></option>
 <?
 }
 }
}
?>

