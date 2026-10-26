


<div class="row">
    <h2>Профиль пользователя</h2>
    <div class="row">

        <div class="col-md-4 center">
            <?php
            if (isset($user['avatar'])) {
                ?>
                <img src="<?= $user['avatar']; ?>">
                <?php
            }
            ?>
        </div>
        <div class="col-md-8 center">



            <table class="table center">

                <tr>
                    <td>Email</td>
                    <td><?
                        if (isset($user['email'])) {
                            echo $user['email'];
                        }
                        ?></td>
                </tr>
                <tr>
                    <td>ФИО</td>
                    <td><?
                        if (isset($user['name'])) {
                            echo $user['name'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Пол</td>
                    <td>
                        <select name="gender" class="form-control" disabled>
                            <option  value="none">Не определен</option>
                            <option <?php
                            if (isset($user['gender']) and $user['gender'] == "m") {
                                echo 'selected';
                            }
                            ?>  value="m">Мужской</option>
                            <option  <?php
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
                        <?php
                        if (isset($user['birthday']->sec)) {
                            echo date("Y-m-d", $user['birthday']->sec);
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Начал работать в компании</td>
                    <td>
                        <?php
                        if (isset($user['date_start']->sec)) {
                            echo date("Y-m-d", $user['date_start']->sec);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Хобби</td>
                    <td>
                        <textarea name="hobby" readonly><?
                            if (Isset($user['hobby'])) {
                                echo $user['hobby'];
                            }
                            ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>имя1</td>
                    <td><?
                        if (isset($user['name1'])) {
                            echo $user['name1'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>фамилия1</td>
                    <td><?
                        if (isset($user['surname1'])) {
                            echo $user['surname1'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>отчество1</td>
                    <td><?
                        if (isset($user['fathername1'])) {
                            echo $user['fathername1'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Кошечка</td>
                    <td><?
                        if (isset($user['cat'])) {
                            echo $user['cat'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Собачка</td>
                    <td><?
                        if (isset($user['dog'])) {
                            echo $user['dog'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Попугайчик</td>
                    <td><?
                        if (isset($user['parrot'])) {
                            echo $user['parrot'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Морская свинка</td>
                    <td><?
                        if (isset($user['cavy'])) {
                            echo $user['cavy'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Хомячок</td>
                    <td><?
                        if (isset($user['hamster'])) {
                            echo $user['hamster'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Белочка</td>
                    <td><?
                        if (isset($user['squirrel'])) {
                            echo $user['squirrel'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Телефон</td>
                    <td><?
                        if (isset($user['phone'])) {
                            echo $user['phone'];
                        }
                        ?></td>

                </tr>
                <tr>
                    <td>Адрес</td>
                    <td><?
                        if (isset($user['adres'])) {
                            echo $user['adres'];
                        }
                        ?></td>

                </tr>

                <tr>
                    <td>ИНН</td>
                    <td><?
                        if (isset($user['inn'])) {
                            echo $user['inn'];
                        }
                        ?></td>

                </tr>


            </table>

            <?php
            if (count($all) > 0) {
                ?>
                <h4>Задачи</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Название</td>
                            <td>Расписание</td>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($all)) {
                            foreach ($all as $row) {
                                ?>
                                <tr>
                                    <td><a class="btn btn-danger" href="/tasks/view/index/<?php echo $row['last_id']; ?>"><?= $row['name']; ?></a></td>
                                    <td>
                                        <?php
                                        if (isset($row['cron']) and is_array($row['cron']) and count($row['cron'])) {
                                            foreach ($row['cron'] as $key => $cr) {
                                                $time = null;
                                                if (is_object($cr['time'])) {
                                                    $time = $cr['time']->sec;
                                                } else if (isset($cr['time']['sec'])) {
                                                    $time = $cr['time']['sec'];
                                                }
                                                if (!is_null($time)) {
                                                    ?>
                                                    <p>дата <?= date('Y-m-d H:i:s', $time); ?></p>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <?php
            } else {
                ?>
                <p>Нету задач,за которые отвечает пользователь</p>
                <?php
            }
            ?>

            <?php
            if (count($companys) > 0) {
                ?>
                <h4>Компании</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Название</td>



                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($companys)) {
                            foreach ($companys as $row) {
                                ?>
                                <tr>
                                    <td><a class="btn btn-danger" href="/companys/view/<?php echo $row['last_id']; ?>"><?= $row['name']; ?></a></td>

                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <?php
            } else {
                ?>
                <p>Компании не найдены</p>
                <?php
            }
            ?>   

        </div>
    </div>
    <!--<?php
    if (NoiCore::user()->isLogin()) {
        ?>
                            <div class="row">
                                <div class="col-md-2">&nbsp</div>
                                <div class="col-md-8">
                                <h2>Смена пароля</h2>
                                <form action="" method="POST" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td>Новый пароль</td>
                                    <td>
        <?php
        if (isset($password_field['obj'])) {
            echo $password_field['obj']->getInput();
        }
        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input  class="btn btn-danger" type="submit" name="act_changepw" value="Изменить пароль"></td>
                                </tr>
                            </table>
                            </form>
                                </div>
                            </div>
        <?php
    }
    ?>-->


</div>
