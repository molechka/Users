  <div class="payments_bg">
            	<div class="payments_filter">
                    <button class="BTN" style="float:left; margin: 0 30px 20px 0;"><a href="<?=$controller->getRoute("index");?>">Общая</a></button>
                    <button class="BTN" style="float:left; margin: 0 30px 20px 0;"><a href="<?=$controller->getRoute("index?filter=7",0);?>">Транзакции</a></button>
                    <button class="BTN" style="float:left; margin: 0 30px 20px 0;"><a href="<?=$controller->getRoute("index?filter=6",0);?>">Структурный бонус</a></button>
                    <button style="float:left; margin: 0 30px 20px 0; width:190px; height:27px; color:#fff; background:#456f9a; border: none;"><a href="<?=$controller->getRoute("index?filter=5",0);?>">Реферальный бонус</a></button>
                    <div class="clear"></div>
                </div>

                	<table>
	<tbody><tr>
		<th>
		ID
		</th>
		<th>
		Баланс
		</th>
		<th>
		Операция
		</th>
		<th>
		Сумма
		</th>
		<th>
		Итого
		</th>
		<th>
		Событие
		</th>
		<th>
		Дата
		</th>
	</tr>
        <?
if(isset($history) and count($history)>0){
foreach($history as $key=>$row){
 $row['old_amount']=$row['amount'];
 $row['amount']=number_format($row['amount'], 2, '.', '');
 $itogo=0;
 if($row['op']=="plus"){
  $row['op']="+";
  $itogo=$row['user']['user_money']+$row['old_amount'];
 }else {
  $row['op']="-";
   $itogo=$row['user']['user_money']-$row['old_amount'];
 }
?>
<tr>
		<td>
		<?=$key;?>		</td>
		<td>
		<?=$row['user']['user_money'];?>		</td>
		<td>
		<?=$row['op'];?>		</td>
		<td>
		<?=$row['amount'];?>		</td>
		<td>
		<?=$itogo;?>		</td>
		<td>
		<?=$row['comment'];?>	</td>
		<td>
		<? echo date('Y-m-d H:i:s',$row['date']->sec);?>		</td>
	</tr>
<?

}
}
?>


	</tbody></table>
                </div>
 