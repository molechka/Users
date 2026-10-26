<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang('multisites');?></li>
</ol>
<h2><?php echo NoiCore::app()->lang('multisites');?></h2>
<table class="table">
    <thead>
        <tr>
            <th>domain</th>
            <th></th>
            <th></th>
            <th></th>
              <th></th>
        </tr>
    </thead>
    <tbody>
   <?
   foreach($sites as $site){
    $url_to_admin="http://".$site['subroute']."/".$admin_folder."/index";
    if($site['subroute']=="*"){
    $url_to_admin="http://".$_SERVER['HTTP_HOST']."/".$admin_folder."/index";
    }
    ?>
        <tr>
            <td><?php echo $site['subroute'];?></td>
            <td><a href="<?php echo $url_to_admin;?>">Go to Admin Panel</a></td>
            <td><a href="<?php echo   NoiCore::app()->getRoute("sites/copy/".$site['_id']->__toString());?>">copy</a></td>
            <td>
             <a href="<?php echo   NoiCore::app()->getRoute("sites/update/".$site['_id']->__toString());?>">Update</a>
            </td>
            <td><a href="<?php echo   NoiCore::app()->getRoute("sites/delete/".$site['_id']->__toString());?>">Delete</a></td>

        </tr>
    <?
   }
   ?>
    </tbody>
</table>
