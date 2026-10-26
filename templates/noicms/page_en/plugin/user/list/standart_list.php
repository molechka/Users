<ol class="breadcrumb">
  <li><a href="/">Home</a></li>

  <li class="active">Users</li>
</ol>
<section id="about-us">

     <div class="container">
         <h2>Users</h2>
 
<table class="table">
  <?


    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
     $status="offline";
     if(isset($row['status_user']) and $row['status_user']==1){
     $status="online";
     }
     ?>
    <tr>
        <td><img style="width:100px;" src="<?=$row['avatar'];?>"></td>
        <td><?=$row['name'];?></td>
        <td><?=$status;?></td>
        <td><a href="/user/list/profile/<?=$row['last_id'];?>.html">Explore</a></td>
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