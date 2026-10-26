<?
$load = NoiCore::user()->load();
?>


<div class="row">
    <h2>Профиль</h2>

    <div class="row">

        <div class="col-md-4 center">

            <img src="/user/avatar/<?php echo $load['last_id']; ?>"><br>
            <p>&nbsp;</p>
            <p ><a href="/user/admin/view/<?php echo $load['last_id']; ?>" class="btn btn-danger"><?php echo $load['email']; ?></a></p>

        </div>
        <div class="col-md-8 center">


            <form action="<?= $controller->getRoute('profile/index') ?>" method="POST" enctype="multipart/form-data" >
                <?
                if ($iserror == 1) {

                    if (isset($_POST['main_form_error'])) {
                        ?>
                        <p><?= $_POST['main_form_error']; ?></p>
                        <?
                    } else {
                        if (isset($_POST['error_message'])) {
                            if (isset($_POST['error_key'])) {
                                $_POST['error_' . $_POST['error_key']] = 1;
                            }
                            ?>

                            <p><?= $_POST['error_message']; ?> (<?= $_POST['error_key']; ?>)</p>
                            <?
                        }
                    }
                    ?>
                    <?
                }
                ?>
                <table class="table center">
                    <tr>
                        <td>Фотография</td>
                        <td><input type="file" name="avatar"></td>

                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td><input type="text"  class="form-control" name="name" value="<?
                            if (isset($load['name'])) {
                                echo $load['name'];
                            }
                            ?>"></td>

                    </tr>
                    <tr>
                        <td>Пол</td>   
                        <td>
                            <select name="gender" class="form-control">
                                <option  value="none">Не определен</option>  
                                <option <?
                                if (isset($user['gender']) and $user['gender'] == "m") {
                                    echo 'selected';
                                }
                                ?>  value="m">Мужской</option>
                                <option  <?
                                if (isset($user['gender']) and $user['gender'] == "f") {
                                    echo 'selected';
                                }
                                ?> value="f">Женский</option>
                            </select>   
                        </td>
                    </tr>

                    <tr>
                        <td>Дата рождения</td>
                        <td>
                            <input type="date"  class="form-control" name="birthday" value="<?
                            if (isset($user['birthday']->sec)) {
                                echo date("Y-m-d", $user['birthday']->sec);
                            }
                            ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Начал работать в компании</td>
                        <td>
                            <input type="date"  class="form-control" name="date_start" value="<?
                            if (isset($user['date_start']->sec)) {
                                echo date("Y-m-d", $user['date_start']->sec);
                            }
                            ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Хобби</td>
                        <td>
                            <textarea name="hobby"><?
                                if (Isset($user['hobby'])) {
                                    echo $user['hobby'];
                                }
                                ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>ИНН</td>
                        <td>
                            <input type='text' name='inn' class='form-control' value='<?php
                            if (isset($user['inn'])) {
                                echo $user['inn'];
                            }
                            ?>'>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><input class="btn btn-danger" type="submit" name="act_profile_now" value="Сохранить"></td>
                    </tr>
                </table>

                <?
                if (!isset($user['ulogin_id'])) {
                    ?>
                    <p>Связать аккаунт с одним из социальных сервисов</p>  
                    <?
                    $umodel = new ulogin\models\UModel();
                    echo $umodel->getWidget();
                } else {
                    ?>
                    <p>Ваш аккаунт уже привязан к одной из социальных сетей</p>
                    <?
                }
                ?>

            </form>

        </div>
    </div>


</div>