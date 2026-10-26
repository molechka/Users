<div class="row">
    <h2>Добавление задачи</h2>
    <form action="/tasks/do" method="POST">
        <table class="table">
            <tr>
                <td>Название задачи</td>
                <td><input type="text" name="name" required class="form-control"></td>
            </tr> 
            <tr>
                <td>Описание задачи</td>
                <td><textarea name="description" class="form-control" required></textarea></td>
            </tr> 
            <tr>
                <td>Ответственный</td>
                <td>
                    <select name="user" required class="form-control select2">
                        <option value="null">Не указывать</option>
                        <?
                        if (count($users) > 0) {
                            foreach ($users as $user) {
                                if (strlen($user['name']) < 200) {
                                    $sub = "";
                                    if (isset($user['email'])) {
                                        $sub = "(" . $user['email'] . ")";
                                    }
                                    ?>
                                    <option value="<?= $user['last_id'] ?>"><?= $user['name']; ?> <?php echo $sub; ?> </option>  
                                    <?
                                }
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="btn btn-submit" value="Добавить задачу"></td>
            </tr>
        </table>
    </form>
</div>
