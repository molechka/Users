<form action='' method='POST'>
    <table class='table'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value=''></td>
        </tr>
        <tr>
            <td>Folder</td>
            <td><select name='folder'>
              <?
              if(isset($folders) and is_array($folders) and count($folders)>0){
              foreach($folders as $folder){
              ?>
                    <option value='<?php echo $folder;?>'><?php echo $folder;?></option>
              <?
              }
              }
              ?>
                </select></td>
        </tr>
        <tr>
            <td></td>
            <td><input type='submit' name='act_create_manage_page' value='Create'></td>
        </tr>

    </table>
</form>
<table class='table'>
<?php

if(isset($all_files) and is_array($all_files) and count($all_files)>0){
 foreach($all_files as $file){
 ?>
    <tr>
        <td><?php echo $file;?></td>
        <td><a href='<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString();?>?path_page=<?php echo $file;?>'>Edit</a></td>
        <td><a href='<?php echo   ShoutPlugin::getRoute2();?>widget/mysites_components/uieditor/<?php echo $site['_id']->__toString();?>?operation=manage&delete=<?php echo $file;?>'>Delete</a></td>
    </tr>
 <?
 }
}
?>
</table>
