<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
     
  <li class="active">List Languages</li>
</ol>
<h2>List of Languages</h2>

<table class="table"> 
<?
foreach($languages as $language){
?>
    <tr>
        <td>
         <?php echo $language?>   
        </td>   
        <td><a class="btn btn-primary" href="<?php echo NoiCore::app()->getRoute('language/manage/'.$language)?>">Manage</a></td>
    </tr>    
<?    
}
?>
</table>

