<div class="row">
  <ul class="nav nav-tabs">
  <li role="presentation" ><a href="/tasks/my/index">Текущие задачи</a></li>
  <li role="presentation" class="active"><a href="/tasks/my/completes">Выполненные</a></li>
  <li role="presentation"><a href="/tasks/my/fails">Пропущенные</a></li>
</ul>
   <p>Выполненные задачи</p>

    <table class="table">
        <thead>
            <tr>
                <td>Название</td>
                <td>Время</td>
                <td>Исполнитель<a href="?sort_type=asc&sort_field=user.email"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="asc" and isset($_GET['sort_field']) and $_GET['sort_field']=="user.email") {
    echo 'fachoose';
} ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=user.email"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="desc" and isset($_GET['sort_field']) and $_GET['sort_field']=="user.email") {
    echo 'fachoose';
} ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></td>


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
                  if (isset($row['date'])) {
                      echo date('d.m.y H:i:s', $row['date']->sec);
                  } ?>
                </td>

                <td><?=$row['user']['email']; ?></td>
            </tr>
         <?php

             }
         }
         ?>
        </tbody>
    </table>

</div>
