<table>
<?
if(isset($plugins) and count($plugins)>0){
foreach($plugins as $plugin){
?>
    <tr>
        <td><?php echo $plugin;?></td>
        <td><a href="?plugin_selected=<?php echo $plugin;?>&page=config">Настройки</a></td>
    </tr>
<?
}
}
?>
</table>