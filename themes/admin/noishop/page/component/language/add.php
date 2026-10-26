<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("language/index");?>">Manage Languages</a></li>
   <li class="active"> Add phrase</li>
</ol>
<h2>Add phrase</h2>
<form action="" method="POST">
<table class="table">
     <tr>
        <td>Index phrase</td>
        <td><input type="text" name="index_phrase" required="required"></td>
    </tr>  
   <?
   foreach($langs as $lang){
   ?>
    
    <tr>
        <td>HTML Value(<?=$lang;?>)</td>
        <td><input type="checkbox" name="enable_<?=$lang;?>" value="html"><textarea class="editore" name="html_value_<?=$lang;?>"></textarea></td>
    </tr>
     <tr>
        <td>String Value(<?=$lang;?>)</td>
        <td><input type="checkbox" name="enable_<?=$lang;?>" value="string"><input type="text" name="string_value_<?=$lang;?>" value=""></td>
    </tr>

   <?  
   }
   ?>
        <tr>
        <td></td>
        <td><input type="submit" class="btn btn-primary" name="add_phrase" value="Add"></td>
    </tr> 
   
</table></form>
    
