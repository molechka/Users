<div class="row" id="how_it_works">
    <div class="row">
    <div class="col-sm-8 main-content">
        <h2>Как это работает</h2>
        <form action="/bugs/form/check" method="POST">   
     <table class="table">
                    <tbody><tr>
                        <th><label for="id_name">ФИО:</label></th>
                        <td><input class="form-control form_name"    name="name"   placeholder="Кис446;*№%*5873елев а Ольга" type="text"></td>
                    </tr>
               
                    <tr>
                        <th><label for="id_address">Дата рождения:</label></th>
                        <td><input class="form-control form_dr"  maxlength="300" name="date"   placeholder="11.03.2000" type="text"></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td class="button_wrap">
                            <button type="submit"   class="btn btn-submit">Проверить</button>
                        </td>
                    </tr>
                </tbody></table>
        </form>
         
        </div>
        <div class="col-sm-4">
            <p><a href="#" class="btn btn-danger">Выбрать файл</a></p>
            <p>Поддерживаются файлы Excel и CSV до 10 Мб.</p>
        </div>
    </div>
     <div class="col-sm-12 formresponse" style="display:none;">
         
     </div>    
             
     

    
</div>