<p>Статистика посещения</p>
<table class="table">
<?
if(isset($result) and is_array($result) and count($result)>0){
foreach($result as $row){
 if(isset($row['date']) and isset($row['hosts']) and isset($row['views'])){
?>
    <tr>
        <td><?php echo $row['date'];?></td>
        <td>Hosts <?php echo $row['hosts'];?></td>
        <td>Views <?php echo $row['views'];?></td>
        <td><a href="<?php echo $controller->getUrl("/show/day/".$row['_id']->__toString())?>">More</a></td>
    </tr>
<?
 }
}
}
?>
</table>
