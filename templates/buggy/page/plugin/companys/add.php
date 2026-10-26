<div class="row">
    <h2>Добавление компании</h2>
    <form action="/companys/do" class="formsend" method="POST">
        <table class="table">
            <tr>
                <td>Название</td>
                <td><input type="text" name="name" required class="form-control"></td>
            </tr> 
            <tr>
                <td>ТИП</td>
                <td><select name="type"   required class="form-control select2">
                        <option value='ИП'>ИП</option>
                        <option value='ООО'>ООО</option>
                        <option value='ОАО'>ОАО</option>
                    </select></td>
            </tr>
            <tr>
                <td>ИНН</td>
                <td><input type="text" name="inn"   class="form-control"></td>
            </tr> 
            <tr>
                <td>ОГРН</td>
                <td><input type="text" name="ogrn"  class="form-control"></td>
            </tr> 
            <tr>
                <td>КПП</td>
                <td><input type="text" name="kpp" class="form-control"></td>
            </tr> 
            <tr>
                <td>Телефон</td>
                <td><input type="text" name="phone"  class="form-control"></td>
            </tr> 
            <tr>
                <td>Адрес</td>
                <td><input type="text" name="adress"  class="form-control"></td>
            </tr> 

            <tr>
                <td>Сотрудники</td>
                <td>
                    <select name="users[]" multiple  class="form-control select2 users_select">
                        <option selected> не указано</option>
                        <?
                        if (count($users) > 0) {
                            foreach ($users as $user) {
                                if (strlen($user['name']) < 200) {
                                    $sub = "";
                                    if (isset($user['email'])) {
                                        $sub = "(" . $user['email'] . ")";
                                    }
                                    ?>
                                    <option value="<?= $user['last_id'] ?>"><?= $user['name']; ?> <?php echo $sub; ?> </option>  
                                    <?
                                }
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <a href="#" class="clear_field" data-target=".users_select">Очистить поле</a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="btn btn-submit" value="Добавить компанию"></td>
            </tr>
        </table>
    </form>
</div>

