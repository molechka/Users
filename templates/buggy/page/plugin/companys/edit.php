<div class="row">
    <h2>Редактирование  компании</h2>
    <form action="/companys/doedit/<?php echo $company['last_id']; ?>" class="formsend" method="POST">
        <table class="table">
            <tr>
                <td>Название</td>
                <td><input type="text" name="name" value='<?php echo $company['name']; ?>' required class="form-control"></td>
            </tr> 
            <tr>
                <td>ТИП</td>
                <td><select name="type"   required class="form-control select2">
                        <option <?php
                        if (isset($company['type']) and $company['type'] == "ИП") {
                            echo 'selected';
                        }
                        ?> value='ИП'>ИП</option>
                        <option <?php
                        if (isset($company['type']) and $company['type'] == "ООО") {
                            echo 'selected';
                        }
                        ?> value='ООО'>ООО</option>
                        <option <?php
                        if (isset($company['type']) and $company['type'] == "ОАО") {
                            echo 'selected';
                        }
                        ?> value='ОАО'>ОАО</option>
                    </select></td>
            </tr>
            <tr>
                <td>ИНН</td>
                <td><input type="text" value='<?php echo $company['inn']; ?>' name="inn"   class="form-control"></td>
            </tr> 
            <tr>
                <td>ОГРН</td>
                <td><input type="text" value='<?php echo $company['ogrn']; ?>' name="ogrn"   class="form-control"></td>
            </tr> 
            <tr>
                <td>КПП</td>
                <td><input type="text" value='<?php echo $company['kpp']; ?>' name="kpp"   class="form-control"></td>
            </tr> 
            <tr>
                <td>Телефон</td>
                <td><input type="text" value='<?php echo $company['phone']; ?>' name="phone"   class="form-control"></td>
            </tr> 
            <tr>
                <td>Адрес</td>
                <td><input type="text" value='<?php echo $company['adress']; ?>' name="adress"   class="form-control"></td>
            </tr> 

            <tr>
                <td>Сотрудники</td>
                <td>
                    <select name="users[]" multiple  class="form-control users_select select2">
                        <?
                        if (count($users) > 0) {
                            ?>
                            <option selected >не указано</option>
                            <?php
                            foreach ($users as $user) {
                                if (strlen($user['name']) < 200) {
                                    $sub = "";
                                    if (isset($user['email'])) {
                                        $sub = "(" . $user['email'] . ")";
                                    }
                                    $selected = "";
                                    if (isset($company['users']['id_' . $user['last_id']])) {
                                        $selected = "selected";
                                    }
                                    ?>
                                    <option <?php echo $selected; ?> value="<?= $user['last_id'] ?>"><?= $user['name']; ?> <?php echo $sub; ?> </option>  
                                    <?
                                }
                            }
                        } else {
                            ?>
                            <option selected >не указано</option>
                            <?php
                        }
                        ?>
                    </select>
                    <br> 
                    <a href="#" class="clear_field" data-target=".users_select">Очистить поле</a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="btn btn-submit" value="Редактировать компанию"></td>
            </tr>
        </table>
    </form>
</div>

