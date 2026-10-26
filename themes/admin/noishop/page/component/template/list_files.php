<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("links_config_template");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("links_config_template");?></h2>
<table class="table">
  <?
  if(is_array($files) and count($files)){
  foreach($files as $key=>$file){
   $name_file=str_replace($_SERVER['DOCUMENT_ROOT'],"",$file);
  ?>
    <tr>
        <td><?php echo $name_file;?></td>
        <td><a class="btn btn-active" href="?key=<?php echo $key;?>"><?php echo NoiCore::app()->lang("template_list_edit");?>&nbsp;<i class="fa fa-edit"></i></a></td>
        <td><a class="btn btn-danger" href="?delete=<?php echo $key;?>"><?php echo NoiCore::app()->lang("template_list_delete");?></a></td>
    
    </tr>
 <?
  }
  }
  ?>
</table>


