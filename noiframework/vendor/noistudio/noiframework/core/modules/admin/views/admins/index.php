<ol class="breadcrumb">
    <li><a href="<?php echo NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("links_config_admins")?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_admins")?></h2>
<form action="<?php echo   NoiCore::app()->getRoute('admins/add')?>" method="POST">
<table class="table">
<tr>
    <td><?php echo NoiCore::app()->lang("admins_login")?></td>
    <td><input type="text" name="admin_login" ></td>
</tr>
<tr>
    <td><?php echo NoiCore::app()->lang("admins_password")?></td>
    <td><input type="text" name="admin_password" ></td>
</tr>
<tr>
    <td><?php echo NoiCore::app()->lang("admins_working_end_date");?></td>
    <td><input type="date" name="admin_date"></td>
</tr>
<tr>
    <td><?php echo NoiCore::app()->lang("admins_access_all");?><td>
    <td><input type="checkbox" name="admin_access_all" value="1"></td>
</tr>
<tr style="display:none;">
    <td><?php echo NoiCore::app()->lang("admins_access_widget");?><td>
    <td><input type="checkbox" name="admin_access_widget" value="1"></td>
</tr>
<tr style="display:none;">
    <td><?php echo NoiCore::app()->lang("admins_access_plugins");?><td>
    <td><input type="checkbox" name="admin_access_plugins" value="1"></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" class="btn btn-success" name="btn_add" value="<?php echo NoiCore::app()->lang("admins_btn_add");?>"></td>
</tr>
</table>
</form>
<h4><?php echo NoiCore::app()->lang("admins_list")?></h4>
<table class="table">
    <thead>
    <tr>
        <th><?php echo NoiCore::app()->lang("admins_login")?></th>
         <th><?php echo NoiCore::app()->lang("admins_working_end_date")?></th>
         <th><?php echo NoiCore::app()->lang("admins_access_list")?></th>
         <th></th>
    </tr>
    </thead>
    <tbody>
    <?
    if(isset($admins) and is_array($admins) and count($admins)>0){
     foreach($admins as $adm){
     ?>
    <tr>
        <td>
         <?
         if(isset($adm['admin_login'])){
         echo $adm['admin_login'];
         }
         ?>
        </td>
         <td>
         <?
        echo date('Y-m-d',$adm['end_date']->sec);
         ?>
        </td>
        <td>
         <?
       if(isset($adm['access']) and is_array($adm['access']) and count($adm['access'])>0){
        echo implode(",", $adm['access']);
       }
         ?>
        </td>
        <td><a href="<?php echo   NoiCore::app()->getRoute('admins');?>?delete=<?php echo $adm['_id']->__toString();?>" class="btn btn-danger"><?php echo NoiCore::app()->lang("admins_delete")?></a></td>
    </tr>

     <?
     }
    }
    ?>
    </tbody>
</table>

