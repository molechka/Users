<h2>Транзакции</h2>
<form >
<table class="table">
<tr>
    <td><input type="text" name="login_or_id" placeholder="Поиск по Логину\ID" value="<? if($_GET['login_or_id']){ echo $_GET['login_or_id'];}?>"></td>   
    
    <td>Дата  с <input type="date" name="date_start" value="<? if(isset($_GET['date_start'])) { echo $_GET['date_start'];} ?>" placeholder="Дата"> по <input type="date" name="date_end" value="<? if(isset($_GET['date_end'])) { echo $_GET['date_end'];} ?>" placeholder="Дата "> </td>
</tr><tr>
    <td><input type="int" name="id_trans" placeholder="Айди транзакции" value="<? if(isset($_GET['id_trans'])) { echo $_GET['id_trans'];} ?>"></td>
    <td>Тип <select name="type">
            <option></option>
                                      <option <? if(isset($_GET['type']) and $_GET['type']=="all"){ echo "selected";} ?> value="all">Все</option>
                                                    <option <? if(isset($_GET['type']) and $_GET['type']=="deposit"){ echo "selected";} ?> value="deposit">Взносы</option>
                                                    <option <? if(isset($_GET['type']) and $_GET['type']=="1_lines"){ echo "selected";} ?> value="1_lines">C 1-й линии</option>
                                                   <option <? if(isset($_GET['type']) and $_GET['type']=="2_lines"){ echo "selected";} ?> value="2_lines">C 2-й линии</option>
                                                   <option <? if(isset($_GET['type']) and $_GET['type']=="3_lines"){ echo "selected";} ?> value="3_lines">C 3-й линии</option> 
                                                   <option <? if(isset($_GET['type']) and $_GET['type']=="fillup"){ echo "selected";} ?> value="fillup">Пополнения</option>
                                                   <option <? if(isset($_GET['type']) and $_GET['type']=="withdraw"){ echo "selected";} ?> value="withdraw">Выводы</option>
                                                    <option <? if(isset($_GET['type']) and $_GET['type']=="transfer"){ echo "selected";} ?> value="transfer">Переводы</option>
        </select></td>
</tr>   
<tr>
    <td>В xls <input type="checkbox" name="isxls" value="1"></td>
    <td><input type="submit" value="Применить" class="btn btn-success"></td>
</tr>
</table>
</form>
<?
if(isset($itogo) and !is_null($itogo)){
?>
<div class="alert alert-success">
    <p>Итого <?=$itogo;?> </p> 
   
</div>
<?
}
?>
<div class="alert alert-success">
 
    <p>Всего записей <?=$count;?></p>
</div>
<table class="table table-history">
					<thead>
						<tr>
							<td>Id</td>
                                                        <td>Логин\id юзера</td>
							<td>Баланс</td>
							<td>Операция</td>
							<td>Сумма</td>
							<td>Всего</td>
							<td>Событие</td>
							<td>Дата</td>
                                                        <td></td>
					</thead>
					<tbody>
                                             <?
                                    $history=$rows;         
                                    if(count($history)>0){
                                    foreach($history as $key=>$his){
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
                                     $his['comment']=$controller->lang($his['comment']);
                                    if(isset($his['data']['vauchers'])){
                                    $his['comment']=str_replace("{n}",$his['data']['vauchers'],$his['comment']);     
                                    }
                                    if(isset($his['data']['vauchers'])){
                                    $his['comment']=str_replace("{n}",$his['data']['vauchers'],$his['comment']);     
                                    } else if(isset($his['data']['linebonus']) and isset($his['data']['who'])){
                                     $his['comment']=str_replace("{n}",$his['data']['level'],$his['comment']);     
                                     $his['comment']=str_replace("{m}",$his['data']['who'],$his['comment']);    
                                    }else if(isset($his['data']['who']) and isset($his['data']['percent']) and isset($his['data']['qualification_name'])) {
                                     $his['comment']=str_replace("{n}",$his['data']['qualification_name'],$his['comment']);     
                                     $his['comment']=str_replace("{m}",$his['data']['percent'],$his['comment']);   
                                     $his['comment']=str_replace("{s}",$his['data']['who'],$his['comment']);   
                                    }else if((isset($his['data']['bustr']) or isset($his['data']['ustr'])) and isset($his['data']['who'])){
                                     $his['comment']=str_replace("{m}",$his['data']['who'],$his['comment']);    
                                    }else if(isset($his['data']['type']) and $his['data']['type']=="payment" and isset($his['data']['title2'])){
                                    $his['comment']=str_replace("{name}",$his['data']['title2'],$his['comment']);       
                                    }else if(isset($his['data']['type']) and $his['data']['type']=="payment" and isset($his['data']['title'])){
                                    $his['comment']=str_replace("{name}",$his['data']['title'],$his['comment']);       
                                    }
                                    if($his['data']['type']=="payment"){
                                     if(isset($his['data']['inv_id'])){
                                      $his['comment']= $his['comment']." #".$his['data']['inv_id'];    
                                     }   
                                    }
                                    ?>
                                    <tr>
							<td><?=$his['last_id'];?></td>
                                                        <td><?=$his['user']['login'];?>/<?=$his['user']['last_id'];?></td>
							<td><?=$his['user']['user_money'];?></td>
							<td><?=$type_op;?></td>
							<td><?=$his['amount'];?></td>
							<td><?=$itogo;?></td>
							<td><?=$his['comment'];?></td>
							<td><span class="span-danger"><?=date('Y/m/d',$his['date']->sec);?></span></td>
                                                        <td><a href="<?=NoiCore::app()->getRoute("p_historyop/finance/update/".$his['last_id']);?>">Изменить</a></td>
						</tr>        
                                    <?        
                                    }
                                    }
                                    ?>
                                            
						 
					</tbody>
				</table>
				
				 <?=$pages;?>
