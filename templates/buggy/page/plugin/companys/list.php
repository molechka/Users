<div class="row">
    <h2>Компании</h2>
    <p><a href="/companys/add.html" class="btn btn-warning">Добавить компанию</a><p>
    <table class="table">
        <thead>
            <tr>
                <td>Тип</td>
                <td>Название</td>
                <td>Автор</td>
                <td>Дата изменения</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($rows)) {
                foreach ($rows as $row) {

                    $iscan = false;
                    if ($user['last_id'] == $row['creator']['last_id'] or $ismanager) {
                        $iscan = true;
                    }
                    ?>
                    <tr>
                        <td><?php echo $row['type']; ?></td>
                        <td><ins><a   href="/companys/view/<?php echo $row['last_id'] ?>"><?= $row['name']; ?></a></ins></td>
                        <td><?php echo $row['creator']['email']; ?></td>
                        <td><?php echo date('d.m.Y ', $row['date_update']->sec); ?></td>
                        <td>
                            <?php
                            if ($iscan) {
                                ?>
                                <a class="btn btn-danger" href="/companys/edit/<?= $row['last_id']; ?>">Изменить</a>
                                <?php
                            }
                            ?></td>
                        <td>
                            <?php
                            if ($iscan) {
                                ?>
                                <a class="btn btn-danger" href="/companys/delete/<?= $row['last_id']; ?>">Удалить</a>
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
    <?= $pages; ?>
</div>
