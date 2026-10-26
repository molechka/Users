<div class="row">
  <ul class="nav nav-tabs">
  <li role="presentation" ><a href="/tasks/my/index">Текущие задачи</a></li>
  <li role="presentation" class="active"><a href="/tasks/my/completes">Выполненные</a></li>
  <li role="presentation"><a href="/tasks/my/fails">Пропущенные</a></li>
</ul>
   <p>Пропущенные задачи</p>

    <table class="table">
        <thead>
            <tr>
                <td>Название</td>
                <td>Время</td>


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

            </tr>
         <?php

             }
         }
         ?>
        </tbody>
    </table>

</div>
