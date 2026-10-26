<h4>Задача:&nbsp;<?php echo $task['name']; ?></h4>
<p>Описание:&nbsp;<?php echo $task['description']; ?></p>
<?php
if (isset($task['user']['name'])) {
    ?>
    <p>Ответственный: <a class="btn btn-danger" href="/user/admin/view/<?php echo $task['user']['last_id']; ?>"><?php echo $task['user']['name']; ?></a>  </p>
    <?php
} else {
    ?>
    <p>Ответственный не указан </p>
    <?php
}
?>
<p>&nbsp;</p>
<?php
if (isset($task['cron']) and is_array($task['cron']) and count($task['cron'])) {
    foreach ($task['cron'] as $key => $cr) {

        if (isset($cr['time'])) {
            $time = null;
            if (is_object($cr['time'])) {
                $time = $cr['time']->sec;
            } else if (is_array($cr['time'])) {
                $time = $cr['time']['sec'];
            }
            if (!is_null($time)) {
                ?>
                <p>Дата следующего запуска: <?= date('Y-m-d H:i:s', $time); ?></p>
                <p>&nbsp;</p>
                <?php
            }
        }
    }
}
?>
<p>Создал:  <?php echo $task['creator']['name']; ?>  </p>
<p>Дата создания: <?php echo date('d.m.Y H:i', $task['date']->sec); ?></p>
