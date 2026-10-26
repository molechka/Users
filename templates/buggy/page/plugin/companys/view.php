<div class="row">
    <h2>Просмотр  компании</h2>

    <table class="table">
        <tr>
            <td>Название</td>
            <td><?php echo $company['name']; ?></td>
        </tr> 
        <tr>
            <td>Тип</td>
            <td><?php echo $company['type']; ?></td>
        </tr>
        <?php
        if (isset($company['inn']) and strlen($company['inn']) > 1) {
            ?>
            <tr>
                <td>ИНН</td>
                <td><?php echo $company['inn']; ?></td>
            </tr> 
            <?php
        }
        ?>
        <?php
        if (isset($company['ogrn']) and strlen($company['ogrn']) > 1) {
            ?>
            <tr>
                <td>ОГРН</td>
                <td><?php echo $company['ogrn']; ?></td>
            </tr> 
            <?php
        }
        ?>
        <?php
        if (isset($company['kpp']) and strlen($company['kpp']) > 1) {
            ?>
            <tr>
                <td>КПП</td>
                <td><?php echo $company['kpp']; ?></td>
            </tr> 
            <?php
        }
        ?>
        <?php
        if (isset($company['phone']) and strlen($company['phone']) > 1) {
            ?>
            <tr>
                <td>Телефон</td>
                <td><?php echo $company['phone']; ?></td>
            </tr> 
            <?php
        }
        ?>
        <?php
        if (isset($company['adress']) and strlen($company['adress']) > 1) {
            ?>
            <tr>
                <td>Адрес</td>
                <td><?php echo $company['adress']; ?></td>
            </tr> 
            <?php
        }
        ?>
        <tr>
            <td>Сотрудники</td>
            <td>
                <?php
                if (count($company['users'])) {
                    foreach ($company['users'] as $user) {
                        ?>
                        <p><a class="btn btn-danger" href="/user/admin/view/<?php echo $user['last_id']; ?>"><?php echo $user['name']; ?></a></p>
                            <?php
                        }
                    }
                    ?>
            </td>
        </tr>

    </table>

</div>

