<div class="row">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="/tasks/my/index">Текущие задачи</a></li>
        <li role="presentation"><a href="/tasks/my/completes">Выполненные</a></li>
        <li role="presentation"><a href="/tasks/my/fails">Пропущенные</a></li>
    </ul>
    <h2>Пришло время для следующих задач</h2>

    <table class="table">
        <thead>
            <tr>
                <td>Название</td>
                <td>Расписание</td>
                <td>Исполнитель<a href="?sort_type=asc&sort_field=user.email"><i class="fa <?php
                        if (isset($_GET['sort_type']) and $_GET['sort_type'] == "asc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "user.email") {
                            echo 'fachoose';
                        }
                        ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=user.email"><i class="fa <?php
                                                                                 if (isset($_GET['sort_type']) and $_GET['sort_type'] == "desc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "user.email") {
                                                                                     echo 'fachoose';
                                                                                 }
                        ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></td>


            </tr>
        </thead>
        <tbody>
<?php
if (count($all)) {
    foreach ($all as $row) {
        ?>
                    <tr>
                        <td><a href="/tasks/my/show/<?php echo $row['last_id']; ?>"><?= $row['name']; ?></a></td>
                        <td>
                            <?php
                            if (isset($row['cron']) and is_array($row['cron']) and count($row['cron'])) {
                                foreach ($row['cron'] as $key => $cr) {
                                    $time = null;
                                    if (is_object($cr['time'])) {
                                        $time = $cr['time']->sec;
                                    } else if (is_array($cr['time'])) {
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
                        <td>
                            <?php
                            if (isset($row['user']['email'])) {
                                ?>
            <?php echo $row['user']['email']; ?>
            <?php
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

</div>
