<div class="row">
    <h2>Все непрочитанные уведомления</h2>

    <table class="table">
        <thead>
            <tr>
                <td>Дата</td>
                <td>Уведомление</td>
                <td>Задача</td>


            </tr>
        </thead>
        <tbody>
         <?php
         if (count($all)) {
             foreach ($all as $row) {
                 ?>
            <tr>
                <td><?=date('d.m.y H:i', $row['date']->sec); ?></td>
                <td>
                  <?php echo $row['title']; ?>
                 </td>
                 <td>
                   <?php echo $row['task']['name']; ?>
                  </td>
            </tr>
         <?php

             }
         }
         ?>
        </tbody>
    </table>

</div>
