<div class="row">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Банки</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">ФИО</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Email</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
          <table class="table">
              <tr>
                  
                  <td colspan="2"><input type="text"  style="" class=" form-control name_tab_bank" value=""/></td>
              </tr>   
              <tr>
                  <td>Наименования</td> 
                  <td><input class="form-control bank_name " readonly></td>
              </tr>
              <tr>
                  <td>БИК\SWIFT</td> 
                  <td><input class="form-control bank_bik" readonly></td>
              </tr>
               <tr>
                  <td>Корсчет</td> 
                  <td><input class="form-control bank_kor" readonly></td>
              </tr>
                <tr>
                  <td>Рег.номер</td> 
                  <td><input class="form-control bank_reg" readonly></td>
              </tr>
               <tr>
                  <td>Дата регистрации</td> 
                  <td><input class="form-control bank_date" readonly></td>
              </tr>
          </table>  
          
      </div>
      <div role="tabpanel" class="tab-pane" id="profile">
           <table class="table">
              <tr>
                  
                  <td colspan="2"><input type="text"  style="" class=" form-control name_tab_fio" value=""/></td>
              </tr>   
              <tr>
                  <td>Фамилия</td> 
                  <td><input class="form-control fio_surname " readonly></td>
              </tr>
              <tr>
                  <td>Имя</td> 
                  <td><input class="form-control fio_name" readonly></td>
              </tr>
               <tr>
                  <td>Отчество</td> 
                  <td><input class="form-control fio_fathername" readonly></td>
              </tr>
                <tr>
                  <td>Пол</td> 
                  <td><select class="form-control fio_gender" disabled>
                         <option></option>
                         <option value="MALE">Мужской</option>
                         <option value="FEMALE">Женский</option>
                      </select></td>
              </tr>
               
          </table> 
      </div>
      <div role="tabpanel" class="tab-pane" id="messages">
            <table class="table">
              <tr>
                  
                  <td colspan="2"><input type="text"  style="" class=" form-control name_tab_email" value=""/></td>
              </tr>   
              <tr>
                  <td>Ящик</td> 
                  <td><input class="form-control email_user " readonly></td>
              </tr>
              <tr>
                  <td>Домен</td> 
                  <td><input class="form-control email_domain" readonly></td>
              </tr>
              
               
          </table> 
      </div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div>
  </div>

</div>