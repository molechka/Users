<div class="row">
    <h2>Редактирование cron</h2>
    <form action="/tasks/cron/doupdate/<?=$link;?>" method="POST">
    <table class="table">
        <tr>
            <td>Часы</td>
            <td> <input name="hours" value="<?=$format[1];?>" required  class="form-control"/>
                  </td>
        </tr> 
          <tr>
            <td>Минуты</td>
            <td>
                <input name="minuts" value="<?=$format[0];?>" required  class="form-control"/>
              
            </td>
        </tr> 
        <tr>
            <td>Месяцы</td>
            <td>
                <select name="month" required class="form-control">
                   <option value="*">*</option>  
                   <option <? if((int)$format[3]==1) { echo 'selected';} ?>  value="1">январь</option>
                   <option <? if((int)$format[3]==2) { echo 'selected';} ?> value="2">февраль</option>
                   <option <? if((int)$format[3]==3) { echo 'selected';} ?> value="3">март</option>
                   <option <? if((int)$format[3]==4) { echo 'selected';} ?> value="4">апрель</option>
                   <option <? if((int)$format[3]==5) { echo 'selected';} ?> value="5">май</option>
                   <option <? if((int)$format[3]==6) { echo 'selected';} ?> value="6">июнь</option>
                   <option <? if((int)$format[3]==7) { echo 'selected';} ?> value="7">июль</option>
                   <option <? if((int)$format[3]==8) { echo 'selected';} ?> value="8">август</option>
                   <option <? if((int)$format[3]==9) { echo 'selected';} ?> value="9">сентябрь</option>
                   <option <? if((int)$format[3]==10) { echo 'selected';} ?> value="10">октябрь</option>
                   <option <? if((int)$format[3]==11) { echo 'selected';} ?> value="11">ноябрь</option>
                   <option <? if((int)$format[3]==12) { echo 'selected';} ?> value="12">декабрь</option>
                </select>
            </td>
        </tr>
         <tr>
            <td>Дни</td>
            <td>
                <select name="days" required class="form-control">
                    <option value="*">*</option>  
                   <?
                  $i=1;
                  
                  while($i<32){
                  ?>
                    <option <? if((int)$format[2]==$i) { echo 'selected';} ?>   value="<?=$i;?>"><?=$i;?></option>  
                  <?  
                  $i++;
                  }    
                  
                  ?>
                </select>
            </td>
        </tr>
          <tr>
            <td>Дни недели</td>
            <td>
                <select name="dayweek" required class="form-control">
                   <option value="*">*</option>  
                   <option <? if((int)$format[4]==1) { echo 'selected';} ?> value="1">понедельник</option>
                   <option <? if((int)$format[4]==2) { echo 'selected';} ?> value="2">вторник</option>
                   <option <? if((int)$format[4]==3) { echo 'selected';} ?> value="3">среда</option>
                   <option <? if((int)$format[4]==4) { echo 'selected';} ?> value="4">четверг</option>
                   <option <? if((int)$format[4]==5) { echo 'selected';} ?> value="5">пятница</option>
                   <option <? if((int)$format[4]==6) { echo 'selected';} ?> value="6">суббота</option>
                   <option <? if((int)$format[4]==7) { echo 'selected';} ?> value="7">воскресенье</option>
                    
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn btn-submit" value="Изменить расписание"></td>
        </tr>
    </table>
    </form>
</div>
