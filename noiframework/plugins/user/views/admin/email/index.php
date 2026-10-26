<h2><?php echo NoiCore::app()->lang('users_emails_title')?></h2>
<form action="" method="POST">
<table class="table">
    <tr>
        <td><?php echo NoiCore::app()->lang('users_emails_send');?></td>
        <td><select name="who">
                <option value="none"><?php echo NoiCore::app()->lang('mongogrid_all');?></option>
                <?
                if(count($roles)>0){
                foreach($roles  as $role){
                ?>
                <option value="<?php echo $role;?>"><?php echo $role;?></option>
                <?

                }
                }
                ?>
            </select></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang('users_emails_field');?></td>
        <td>
            <select name="field">
            <?
            if(isset($fields) and count($fields)>0){
            foreach($fields as $field){
            ?>
                <option value="<?php echo $field;?>"><?php echo $field;?></option>
            <?
            }
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang('users_subject');?></td>
        <td><input type="text" name="email_subject"></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang('users_text');?></td>
        <td><textarea class="editore" rows="5" name="email_text"></textarea></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" class="btn btn-submit" value="<?php echo NoiCore::app()->lang('users_sent_all');?>"></td>
    </tr>
</table>
</form>