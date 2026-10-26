<h3><?=$mg->title;?></h3>
<p><a href="<?=$mg->url;?>&pop=2000">Пополнение баланса</a> , <a href="<?=$mg->url;?>&pop=2001">Списание средств</a> , <a href="<?=$mg->url;?>&pop[]=1002&pop[]=1004&pop[]=1005&pop[]=1006&pop[]=1001&pop[]=1003&pop[]=1007&pop[]=1008">Выплаты</a>,<a href="<?=$mg->url;?>&pop=9000">Куплено акций</a>,<a href="<?=$mg->url;?>&pop=3002">Куплено бизнес пакетов</a>,<a href="<?=$mg->url;?>&pop=7">Перевод средств</a>

</p>
<table class="table">
 <tr><td>
 <?
 
 if(in_array("create",$mg->operations->available)){
 ?>
<a href="<?=$mg->setRoute('/create/1');?>">Создать</a>
<?
 }
 ?></td>

     <td><form action='<?=$mg->url?>?<?=  $mg->setRoute('/list/1');?>' method="POST">
         <select name="search_field">
         <?
         if(isset($mg->fields->array_fields)){
         foreach($mg->fields->array_fields as $search_field){
         $title=$search_field;
         $selected="";
         if(isset($_POST['search_field']) and $_POST['search_field']==$search_field){
         $selected="selected='selected'";
         }
         if(isset($mg->fields->array_type[$search_field]['label'])){
         $title=$mg->fields->array_type[$search_field]['label'];
         }
         ?>
             <option <?=$selected;?> value="<?=$search_field?>"><?=$title?></option>
         <?
         }
         }
          $selected="";
         if(isset($_POST['search_field']) and $_POST['search_field']=="user.login"){
         $selected="selected='selected'";
         }
         ?>
             <option <?=$selected;?> value="user.login">Логин</option>
         </select><input type="text" value="<?if(isset($_POST['search_value'])) echo $_POST['search_value'];?>"name="search_value"><input type="submit" name="search_btn" value="Найти">
         </form></td>
 </tr>
</table>
<table class="table">
    <thead>
    <tr>
        <td>ФИО</td>
        <td>Логин</td>
        <td>было</td>
        <td>Сумма</td>
        <td>стало</td>
        <td>операция</td>

        <td>Дата</td>
        <td>Комментарий</td>
    </tr>
    </thead>
    <tbody class="ajax_load_row">
    <?

   
    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
       $itogo=0;
       $op="+";
       if(isset($row['system_op']) and isset($row['system']['balance'])){
        if($row['op']=="plus"){
        $itogo=$row['user']['user_money']+ $row['amount'];
        }
         if($row['op']=="minus"){
         $op="-";
        $itogo=$row['user']['user_money']-$row['amount'];
        }
       }
     ?>
     <tr>
         <td><? if(isset($row['user']['name'])){ echo $row['user']['name'];}  ?></td>
         <td><?=$row['user']['username'];?></td>
         <td><?if(isset($row['user']['user_money'])) { echo $row['user']['user_money']; }?></td>
         <td><?=$row['amount'];?></td>
         <td><?=$itogo;?></td>
         <td><?=$op;?></td>
         <td><?=date('Y-m-d H:i:s',$row['date']->sec);?></td>
         <td><?=$row['comment'];?></td>
    </tr>
     <?
     }
    }

    ?>
    </tbody>
</table>
<?
$count=0;
if(isset($mg->result[0]['_count_'])){
$count=$mg->result[0]['_count_'];
}
?>
<?
if(count($mg->condition)>0){
?>
<p>Общая сумма $<?=NoiCore::custom()->getAllHistoryAdmin($mg->condition);?></p>
<?
}
?>
<mgplugin count="<?=$count;;?>" limit="<?=$mg->page_item;?>">paginator</mgplugin>