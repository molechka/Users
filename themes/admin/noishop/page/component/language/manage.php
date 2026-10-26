<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
  <li class="active"> Manage Language </li>
</ol>
<h2>Manage Language </h2>
<p><a href="<?php echo NoiCore::app()->getRoute('language/add')?>">Add Phrase</a></p>
<table class="table"> 
<?
 if(isset($site['language_'.$langs[0]]) and is_array($site['language_'.$langs[0]]) and count($site['language_'.$langs[0]])>0){
 
foreach($site['language_'.$langs[0]] as $key=>$val){
?>
    <tr>
        <td><?php echo $key;?></td>
        <td><?php echo strip_tags($val);?></td>
        <td><code>&lt;?=NoiCore::app()->lang("<?=$key;?>");?&gt;</code></td>
        <td><a href="<?php echo NoiCore::app()->getRoute('language/update/'.$key)?>">Update</a></td>
        <td><a href="<?php echo NoiCore::app()->getRoute('language/delete/'.$key)?>">Delete</a></td>
    </tr>    
<?    
}    
}
?>
</table>