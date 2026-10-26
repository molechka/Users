<?
$newdata=array('site'=>$site);
echo SiteComponent::render_setup("editsite_bar",$newdata);
?>
<h2>Список страниц</h2>

<?
if(isset($files) and is_array($files) and count($files)>0){
?>
<table>
<?
foreach($files as $file){
?>
    <tr>
        <td><a href='?path_page=<?php echo $file;?>'><?php echo $file;?></a></td>
    </tr>
<?
}
?>

</table>
<?
}

?>

