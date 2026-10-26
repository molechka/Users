<div class="row">
    <h2>Добавление в cron</h2>
    <form action="/tasks/docron/<?=$task['last_id'];?>" method="POST">
    <table class="table">
        <tr>
            <td>Часы</td>
            <td> <input name="hours" required  class="form-control"/>
                  </td>
        </tr> 
          <tr>
            <td>Минуты</td>
            <td>
                <input name="minuts" required  class="form-control"/>
              
            </td>
        </tr> 
        <tr>
            <td>Месяцы</td>
            <td>
                <select name="month" required class="form-control">
                   <option value="*">*</option>  
                   <option value="1">январь</option>
                   <option value="2">февраль</option>
                   <option value="3">март</option>
                   <option value="4">апрель</option>
                   <option value="5">май</option>
                   <option value="6">июнь</option>
                   <option value="7">июль</option>
                   <option value="8">август</option>
                   <option value="9">сентябрь</option>
                   <option value="10">октябрь</option>
                   <option value="11">ноябрь</option>
                   <option value="12">декабрь</option>
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
                    <option   value="<?=$i;?>"><?=$i;?></option>  
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
                   <option value="1">понедельник</option>
                   <option value="2">вторник</option>
                   <option value="3">среда</option>
                   <option value="4">четверг</option>
                   <option value="5">пятница</option>
                   <option value="6">суббота</option>
                   <option value="7">воскресенье</option>
                    
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn btn-submit" value="Добавить расписание"></td>
        </tr>
    </table>
    </form>
</div>
