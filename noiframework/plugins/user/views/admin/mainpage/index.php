<p><a class="btn btn-danger" target="_blank" href="/tasks/soap/WrapperSoapServer.php?wsdl">SOAP API URL</a></p>
<p><a class="btn btn-danger" target="_blank" href="/tasks/rest/list">REST API URL</a></p>
<p><a class="btn btn-danger" href="<?=NoiCore::app()->getRoute('p_user/config/token')?>">Указать токен для подсказок и URL</a></p>

<h4>Последние пользователи</h4>
<table class="table">
    <thead>
        <tr>
            <th>email</th>
            <th>ФИО</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
     <?php
     if (count($rows)>0) {
         foreach ($rows as $row) {
             if (!isset($row['usd_money'])) {
                 $row['usd_money']=0;
             }
             if (!isset($row['rub_money'])) {
                 $row['rub_money']=0;
             }
             if (!isset($row['btc_money'])) {
                 $row['btc_money']=0;
             } ?>
        <tr>
            <td><?=$row['email']; ?></td>

            <td><?=$row['name']; ?></td>
            <td>
                <a href="<?=NoiCore::app()->getRoute('p_user/users/delete/'.$row['last_id'])?>">Удалить</a>
            </td>
        </tr>
    <?php

         }
     }
     ?>
    </tbody>
</table>
<p><a class="btn btn-success" href="<?=NoiCore::app()->getRoute('p_user/users/index');?>">Посмотреть всех</a></p>
