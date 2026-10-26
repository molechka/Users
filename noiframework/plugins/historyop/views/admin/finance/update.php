<h2>Транзакция #<?=$his['last_id'];?></h2>
<?
  $type_op="Зачисление";
                                    if($his['op']=="minus"){
                                    $type_op="Списание";
                                    }   
                                     $igoto=0;
                                    if($his['op']=="plus"){
                                    $itogo=$his['user']['user_money']+$his['amount'];
                                    }else {
                                     $itogo=$his['user']['user_money']-$his['amount'];
                                    }
                                    
?>
<form action="<?=NoiCore::app()->getRoute('p_historyop/finance/doupd/'.$his['last_id'])?>" method="POST">
<table class="table">
    <tr>
        <td>Логин\ид юзера</td>   
        <td><?=$his['user']['login'];?>/<?=$his['user']['last_id'];?></td>
    </tr>   
    <tr>
        <td>Баланс</td>
        <td><?=$his['user']['user_money'];?></td>
    </tr>
    <tr>
        <td>Операция</td>
        <td><?=$type_op;?></td>
    </tr>
    <tr>
        <td>Сумма</td>
        <td><?=$his['amount'];?></td>
    </tr>
    <tr>
        <td>Всего</td>
        <td><?=$itogo;?></td>
    </tr>
    <tr>
        <td>Событие</td>
        <td><textarea name="comment"><?=$his['comment'];?></textarea></td>
    </tr>
    <tr>
        <td>Дата</td>
        <td><?=date('Y/m/d',$his['date']->sec);?></td>
    </tr>
    <tr>
        <td></td>
        <td><input class="btn btn-danger" type="submit" value="Изменить!"></td>
    </tr>
</table>
</form>

