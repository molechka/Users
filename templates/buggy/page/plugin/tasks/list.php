<div class="row">
    <h2>Задачи</h2>
    <p><a href="/tasks/add.html" class="btn btn-warning">Добавить задачу</a><p>
    <table class="table">
        <thead>
            <tr>
                <td>Название</td>
                <td>Расписание</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($rows)) {
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><ins><a class="" href="/tasks/view/index/<?php echo $row['last_id'] ?>"><?= $row['name']; ?></a></ins></td>
                        <td>
                            <?php
                            if (isset($row['cron']) and is_array($row['cron']) and count($row['cron'])) {
                                foreach ($row['cron'] as $key => $cr) {
                                    if (isset($cr['time']->sec)) {
                                        ?>
                                        <p><a href="/tasks/cron/edit/<?= $row['last_id']; ?>/<?= $key; ?>" class="btn btn-warning">дата <?= date('Y-m-d H:i:s', $cr['time']->sec); ?></a>&nbsp;&nbsp;<a class="btn btn-danger" href="/tasks/cron/del/<?= $row['last_id']; ?>/<?= $key; ?>">[x]</a></p>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <a class="btn btn-success" href="/tasks/cron/<?= $row['last_id']; ?>">Добавить в расписание</a>
                        </td>
                        <td><a class="btn btn-danger" href="/tasks/edit/<?= $row['last_id']; ?>">Изменить</a></td>
                        <td><a class="btn btn-danger" href="/tasks/delete/<?= $row['last_id']; ?>">Удалить</a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <?= $pages; ?>
</div>
