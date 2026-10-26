<h3><?php echo NoiCore::app()->lang('users_create');?></h3>

<form action="" method="POST" enctype="multipart/form-data">
    <table class="table">
   <?
   if(isset($fields) and count($fields)>0){
   foreach($fields as $field){
   if(isset($field['field']['label']) and is_object($field['obj'])){
   ?>
        <tr>
            <td><?php echo $field['field']['label'];?></td>
            <td><?php echo $field['obj']->getInput();?></td>
        </tr>
   <?
   }
   }
   }
   ?>
        <tr>
            <td></td>
            <td><input type="submit" name="act_create" class="btn btn-danger" value="<?php echo NoiCore::app()->lang('mongogrid_create');?>"></td>
        </tr>
    </table>
</form>

