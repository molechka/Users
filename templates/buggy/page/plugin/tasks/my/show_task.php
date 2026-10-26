<h4>Просмотр задачи</h4>
<table class="table">
<tr>
<td>Название задачи</td>
<td><?php echo $task['name'];?></td>
</tr>
<tr>
<td>Описание задачи</td>
<td><?php echo $task['description'];?></td>
</tr>
<tr>
<td>Расписание</td>
<td>  <?php
  if (isset($task['cron']) and is_array($task['cron']) and count($task['cron'])) {
      foreach ($task['cron'] as $key=>$cr) {
          if (isset($cr['time']->sec)) {
              ?>
  <p>дата <?=date('Y-m-d H:i:s', $cr['time']->sec); ?></p>
  <?php

          }
      }
  } ?></td>
</tr>
<tr>
<td>Создал задачу</td>
<td><?php echo $task['creator']['email'];?></td>
</tr>
<tr>
<td>Ответственный</td>
<td><?php echo $task['user']['email'];?></td>
</tr>
</table>
