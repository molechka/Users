<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("language/index");?>">Manage Languages</a></li>
   <li class="active"> Edit phrase(<?php echo $lang?>)</li>
</ol>
<h2>Edit phrase</h2>
<form action="" method="POST">
<table class="table">
    <tr>
        <td>Index phrase</td>
        <td><input type="text" name="index_phrase" readonly="readonly" value="<?php echo $key;?>"></td>
    </tr>   
     <?
   foreach($langs as $lang){
   $value="";
   if(isset($site_data['language_'.$lang][$key])){
   $value= $site_data['language_'.$lang][$key];   
   }
   ?>
    <tr>
        <td>HTML Value(<?=$lang;?>)</td>
        <td><input type="checkbox" name="enable_<?=$lang;?>" value="html"><textarea class="editore" name="html_value_<?=$lang;?>"><?php echo $value;?></textarea></td>
    </tr>
     <tr>
        <td>String Value(<?=$lang;?>)</td>
        <td><input type="checkbox" name="enable_<?=$lang;?>" value="string"><input type="text" name="string_value_<?=$lang;?>" value="<?php echo strip_tags($value);?>"></td>
    </tr>
    <?
   }
    ?>
    <tr>
        <td></td>
        <td><input type="submit" class="btn btn-primary" name="edit_phrase" value="Edit"></td>
    </tr>
</table></form>
    
