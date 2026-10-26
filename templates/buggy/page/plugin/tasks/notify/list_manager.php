<div class="row">
    <h2>Все непрочитанные уведомления</h2>
    <form action="/tasks/notify/index.html" method="GET">
    <table class="table">
      <tr >
        <td colspan="2" style="text-align:center;">Дата</td>
      </tr>
      <tr>
      <td>C&nbsp;<input style="width:80%;display:inline;" class=" form-control" type="date" name="date_start" value='<?php if (isset($_GET['date_start']) and is_string($_GET['date_start'])) {
    echo strip_tags($_GET['date_start']);
}?>'></td>
      <td>По&nbsp;<input style="width:80%;display:inline;" class="form-control" type="date" name="date_end" value='<?php if (isset($_GET['date_end']) and is_string($_GET['date_end'])) {
    echo strip_tags($_GET['date_end']);
}?>'></td>

      </tr>
      <tr >
        <td colspan="2" style="text-align:center;">Поисковая строка</td>
      </tr>
    <tr>
    <td colspan="2"><input type="text" placeholder="Введите email" value='<?php if (isset($_GET['q']) and is_string($_GET['q'])) {
    echo trim(strip_tags($_GET['q']));
}?>' name="q" class="form-control" value=""></td>

    </tr>
    <tr>
    <td ><button type="submit" class="btn btn-submit" >Найти</button></td>
    <td><a href="/tasks/notify/index.html">Сбросить фильтры</a></td>

    </tr>
    </table>
    </form>


    <table class="table">
        <thead>
            <tr>
                <td>Дата<a href="?sort_type=asc&sort_field=date"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="asc" and isset($_GET['sort_field']) and $_GET['sort_field']=="date") {
    echo 'fachoose';
} ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=date"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="desc" and isset($_GET['sort_field']) and $_GET['sort_field']=="date") {
    echo 'fachoose';
} ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></td>
                <td>Уведомление<a href="?sort_type=asc&sort_field=title"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="asc" and isset($_GET['sort_field']) and $_GET['sort_field']=="title") {
    echo 'fachoose';
} ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=title"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="desc" and isset($_GET['sort_field']) and $_GET['sort_field']=="title") {
    echo 'fachoose';
} ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></td>
                <td>Задача<a href="?sort_type=asc&sort_field=task.name"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="asc" and isset($_GET['sort_field']) and $_GET['sort_field']=="task.name") {
    echo 'fachoose';
} ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=task.name"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="desc" and isset($_GET['sort_field']) and $_GET['sort_field']=="task.name") {
    echo 'fachoose';
} ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></td>
                <td>Кто выполнил действие<a href="?sort_type=asc&sort_field=user.email"><i class="fa <?php if (isset($_GET['sort_type']) and $_GET['sort_type']=="asc" and isset($_GET['sort_field']) and $_GET['sort_field']=="user.email") {
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
                <td><?=date('d.m.y H:i', $row['date']->sec); ?></td>
                <td>
                  <?php echo $row['title']; ?>
                 </td>
                 <td>
                   <?php echo $row['task']['name']; ?>
                  </td>
                  <td>
                    <?php echo $row['user']['email']; ?>
                  </td>
            </tr>
         <?php

             }
         }
         ?>
        </tbody>
    </table>

</div>
