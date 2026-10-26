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
                <td></td>
                <td></td>

            </tr>
        </thead>
        <tbody>
         <?php
         if (count($all)) {
             foreach ($all as $row) {
                 ?>
            <tr>
                <td><?=$row['name']; ?></td>
                <td>
                    <?php
                    if (isset($row['cron']) and is_array($row['cron']) and count($row['cron'])) {
                        foreach ($row['cron'] as $key=>$cr) {
                            if (isset($cr['time']->sec)) {
                                ?>
                    <p>дата <?=date('Y-m-d H:i:s', $cr['time']->sec); ?></p>
                    <?php

                            }
                        }
                    } ?>
                 </td>
                 <td>

                   <a href="/tasks/my/complete/<?php echo $row['last_id']; ?>" class="btn btn-success">сделал</a>

                 </td>
                  <td>

                    <a href="/tasks/my/fail/<?php echo $row['last_id']; ?>" class="btn btn-danger">продолбал</a>

                  </td>
            </tr>
         <?php

             }
         }
         ?>
        </tbody>
    </table>

</div>
