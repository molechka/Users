<div class="row" style="height: 100%;">


    <div class="col-xs-12">
        <div class="ds-block">
            <h3> Пользователи</h3>
            <form action="" method="GET">
                <table class="table">
                    <tr>
                        <td>Email</td> 
                        <td><input type="email" name="email" value="<?php echo $filter_email; ?>" class="form-control"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" class="btn btn-danger">Найти</button></td>
                    </tr>
                </table>
            </form>
            <table class="table table-history">
                <thead>
                    <tr>


                        <td>email</td>
                        <td>фио</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($rows) > 0) {
                        foreach ($rows as $res) {
                            $row = $res;
                            $status = "Не верифицирован";
                            if (isset($res['setac'])) {
                                $status = 'Верифицирован';
                            }
                            ?>
                            <tr>
                                <td><?= $row['email']; ?></td>

                                <td><?= $row['name']; ?></td>
                                <td><?php
                                    if (isset($row['ismanager']) and $row['ismanager'] == 1) {
                                        ?>
                                        <a href="<?= NoiCore::app()->getRoute('p_user/users/manager/' . $row['last_id']); ?>">Отключить менеджера</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?= NoiCore::app()->getRoute('p_user/users/manager/' . $row['last_id']); ?>">Включить менеджера</a>

                                    <?php }
                                    ?></td>
                                <td>
                                    <a href="<?= NoiCore::app()->getRoute('p_user/users/delete/' . $row['last_id']) ?>">Удалить</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>


            <p>Всего <?= $count; ?></p>
            <p><a href="<?= NoiCore::app()->getRoute('p_user/users/deleteall') ?>">Удалить всех</a></p>
            <?= $pages; ?>
        </div>
    </div>



</div>
