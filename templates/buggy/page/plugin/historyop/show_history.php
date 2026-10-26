<div class="row">
    <h2>Пополнение счета</h2>   
    <form id="w0" action="" method="post" >
 					
					<div class="form-group field-addbalanceform-method required">
						<label class="control-label" for="addbalanceform-method">Платежная система</label>
						<select id="addbalanceform-method" class="form-control" name="type_pay" >
							<option value="yandexmoney">Яндекс.Деньги</option>
                                                      
						</select>
						<div class="help-block"></div>
					</div>
				  
					<div class="form-group field-addbalanceform-sum required">
						<label class="control-label" for="addbalanceform-sum"><?=$controller->lang('summ');?></label>
						<input type="text" id="addbalanceform-sum" class="form-control" name="money" required>
						<div class="help-block"></div>
					</div>
				  
					<button type="submit" class="btn btn-primary btn-gold">Пополнить счет</button>
				</form>
    <h2>Финансы</h2>
    <table class="table table-bordered table-hover">
                                                        <thead>
                                                          <tr>
                                                            <th>Дата операции</th>
                                                            <th>Тип операции</th>
                                                            
                                                            <th>Сумма</th>
                                                     
                                                        
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?
                                                          if(count($history)>0){
                                                          foreach($history as $h){
                                                           $type_op="";
                                                                if($h['op']=="minus"){
                                                                $type_op="-";
                                                                }    
                                                          ?>
                                                            <tr>
                                                            <td><?=date('Y/m/d H:i',$h['date']->sec);?></td>
                                                           <td><?=$h['comment'];?></td>
                                                            
                                                            <td><?=$type_op;?><?=round($h['amount'],2,PHP_ROUND_HALF_DOWN);?></td>
                                                            
                                                        
                                                          </tr>  
                                                          <?  
                                                          }    
                                                          }
                                                          ?>
                                                        
                                                         
                                                        </tbody>
                                                      </table>
      <?=$pages;?>
</div>
