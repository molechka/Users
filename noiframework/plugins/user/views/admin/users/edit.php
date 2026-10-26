<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>
    <li><a href="<?php echo   NoiCore::app()->getRoute("p_user/users/index");?>">Пользователи</a></li>
   <li class="active"> <?=$user['login'];?></li>
</ol>
<?
if(!isset($user['setac'])){
?>
<div class="alert alert-danger">
    <h2>Пользователь не верифицирован!</h2>
    <?
    if(isset($user['file_1'])){
    ?>
    <p><a target="_blank" href="<?=$user['file_1'];?>">Лицевая сторона</a></p>
    <?
    }
    ?>
     <?
    if(isset($user['file_2'])){
    ?>
    <p><a target="_blank" href="<?=$user['file_2'];?>">Сторона с пропиской</a></p>
    <?
    }
    ?>
    <p><a href="<?=NoiCore::app()->getRoute('p_user/users/setact/'.$user['last_id']);?>">Верифицировать пользователя!</a><p>
    
    
    
</div>
<?
}else {
?>
<div class="alert alert-success">
  <h2>Пользователь верифицирован!</h2>   
</div>
<?
}

?>
<h2>Редактирование пользователя </h2>
<form action="<?=$controller->getRoute('users/editact/'.$user['_id']->__toString());?>" method="POST">
         <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-name-cyrillic">Имя (Кириллица)</label>
                                                        <input type="text" name="user_data[name]" value="<?=$user['name'];?>" class="form-control" id="iput-name-cyrillic" placeholder="Иван" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-name-latin">Имя (Латиница)</label>
                                                        <input type="text" class="form-control" name="user_data[name_en]" value="<?=$user['name_en'];?>" id="iput-name-latin" placeholder="Ivan" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-surname-cyrillic">Фамилия (Кириллица)</label>
                                                        <input type="text" class="form-control" name="user_data[surname]" value="<?=$user['surname'];?>" id="iput-surname-cyrillic" placeholder="Петров" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-surname-latin">Фамилия (Латиница)</label>
                                                        <input type="text" class="form-control" name="user_data[surname_en]" value="<?=$user['surname_en'];?>"  id="iput-surname-latin" placeholder="Petrov" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-patronymic-cyrillic">Отчество (Кирилица)</label>
                                                        <input type="text" class="form-control" name="user_data[fathername]" value="<?=$user['fathername'];?>"  id="iput-patronymic-cyrillic" placeholder="Сергеевич" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-patronymic-latin">Отчество (Латиница)</label>
                                                        <input type="text" class="form-control" name="user_data[fathername_en]" value="<?=$user['fathername_en'];?>" id="iput-patronymic-latin" placeholder="Sergeevich" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="input-email">Email</label>
                                                        <input type="email" class="form-control" id="input-email" placeholder="<?=$user['email'];?>" >
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group city_list-group">
                                                    <label for="city">Город:</label>
                                                        <input type="text" id="city" value="<?=$user['city'];?>" name="user_data[city]" list="city_list" placeholder="Москва">
                                                            <datalist id="city_list">
                                                             <?
                                                             $citys=NoiCore::app()->db()->query2(array(),"city",array());
                                                             if(count($citys)>0){
                                                             foreach($citys as $c){
                                                             ?>
                                                             <option value="<?=$c['title'];?>"><?=$c['title'];?></option>   
                                                             <?   
                                                             }    
                                                             }
                                                             ?>
                                                                
                                                                 
                                                                <!-- и остальные -->
                                                            </datalist>
                                                    </div>
                                                </div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="input-tel">Номер телефона в международном формате</label>
                                                        <input type="tel" name="user_data[phone]" class="form-control" id="input-tel" placeholder="<?=$user['phone'];?>">
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="iput-skype">Скайп</label>
                                                        <input type="text" name="user_data[skype]" value="<?=$user['skype'];?>" class="form-control" id="iput-skype" placeholder="omni_lama" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                                    <div class="form-group country_list-group">
                                                        <label for="country">Страна:</label>
                                                            <select id="country_list" name="user_data[country]">
                                                                <?
                                                                $countys=NoiCore::app()->db()->query2(array(),"country",array());
                                                                if(count($countys)>0){
                                                                foreach($countys as $us){
                                                                $selected="";
                                                                if($us['title']==$user['country']){
                                                                $selected="selected";    
                                                                }
                                                                ?>
                                                               <option <?=$selected;?> value="<?=$us['title'];?>"><?=$us['title'];?></option> 
                                                                <?
                                                                }   
                                                                }
                                                                ?>
                                                                
                                                                
                                                                <!-- и остальные -->
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-lg-5 col-sm-6 col-xs-6">
                                                    <div class="form-group">
              
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-6 col-xs-6" id="for_what">
                                                 
                                                </div>
                                                <div id="upload_avatar" class="col-md-2">
                                                    <img class="img-responsive" style="width:165px;" src="<?=$user['avatar'];?>" alt="">
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                  
                                                </div>
                                            </div>
      <div class="row">
                                                        <div class="col-md-12">
                                                            <h3>Паспортные данные</h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="iput-passport-1">Серия и номер паспорта</label>
                                                                <input name='user_data[number_passport]' value="<?=$user['number_passport'];?>" type="text" class="form-control" id="iput-passport-1" placeholder="Иван" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="iput-passport-2">Дата рождения</label>
                                                                <input name="user_data[date_birthday]" value="<?=$user['date_birthday'];?>"   type="date" class="form-control" id="iput-passport-2" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="iput-passport-3">Дата выдачи паспорта</label>
                                                                <input name="user_data[date_passport]" value="<?=$user['date_passport'];?>" type="date" class="form-control" id="iput-passport-3" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="iput-passport-4">Место рождения</label>
                                                                <input name="user_data[place_birthday]" value="<?=$user['place_birthday'];?>" type="text" class="form-control" id="iput-passport-4" placeholder="Москва/Россия" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="iput-passport-5">Кем выдан паспорт</label>
                                                                <input name="user_data[who_passport]"  value="<?=$user['who_passport'];?>" type="text" class="form-control" id="iput-passport-5" placeholder="Московским РО УМВД России в г. Москва" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="iput-passport-6">Адрес регистрации</label>
                                                                <input name="user_data[adress_passport]" value="<?=$user['adress_passport'];?>" type="text" class="form-control" id="iput-passport-6" placeholder="ул. Сегедская, 8А, кв. 103" required>
                                                            </div>
                                                        </div>
                                                    </div>
     <div class="row">
                                                        <div class="col-md-3">
                                                            
                                                            <input type="submit"  name="act_profile_now" class="btn" id="save" value="Сохранить изменения">
                                                        </div>
                                                    </div>
    </form> 
    <h4>Операции с финансами (счет <?=$user['user_money'];?>$)</h4>
    <form action="<?=$controller->getRoute('users/addmoney/'.$user['_id']->__toString())?>" method="POST">
    <table class="table">
        <tr>
            <td>
                <input type="text" name="comment" placeholder="комментарий" required>    
            </td> 
            <td>Тип операции <select  name="type_op" required>
                    <option value="plus">+</option>
                    <option value="minus">-</option>
                </select>
            </td>
            <td>
                  <input type="number" name="amount" placehold="Сумма $" required>  
            </td>
            <td><input type="submit" class="btn btn-primary" value="Выполнить"></td>
        </tr>   
    </table>
    </form>
   
