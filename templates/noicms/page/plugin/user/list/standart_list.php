<ol class="breadcrumb">
  <li><a href="/">Главная</a></li>

  <li class="active">Участники</li>
</ol>
<section id="about-us">

     <div class="container">
         <h2>Участники</h2>
 
<table class="table">
  <?


    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
     $status="не в сети";
     if(isset($row['status_user']) and $row['status_user']==1){
     $status="в сети";
     }
     ?>
    <tr>
        <td><img style="width:100px;" src="<?=$row['avatar'];?>"></td>
        <td><?=$row['name'];?></td>
        <td><?=$status;?></td>
        <td><a href="/user/list/profile/<?=$row['last_id'];?>.html">Посмотреть профиль</a></td>
    </tr>
    <?
     }
    }
    ?>
</table>
<?
$count=0;
if(isset($mg->result[0]['_count_'])){
$count=$mg->result[0]['_count_'];
}
?>
<mgplugin count="<?=$count;;?>" limit="<?=$mg->page_item;?>">paginator</mgplugin>
     </div></section>