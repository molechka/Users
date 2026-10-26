<div class="row">
    <h2>Редактирование задачи</h2>
    <form action="/tasks/doedit/<?= $task['last_id']; ?>" method="POST">
        <table class="table">
            <tr>
                <td>Название задачи</td>
                <td><input type="text" name="name" required class="form-control" value="<?= $task['name']; ?>"> </td>
            </tr> 
            <tr>
                <td>Описание задачи</td>
                <td><textarea name="description" class="form-control" required><?= $task['description']; ?></textarea></td>
            </tr> 
            <tr>
                <td>Ответственный</td>
                <td>
                    <select name="user"   class="form-control">
                        <option  value="null">не выбрано</option>
                        <?
                        if (count($users) > 0) {
                            foreach ($users as $user) {
                                $selected = "";
                                if (isset($task['user']['_id'])) {
                                    if ($task['user']['_id'] == $user['_id']) {
                                        $selected = 'selected';
                                    }
                                }
                                ?>
                                <option <?php echo $selected; ?>  value="<?= $user['last_id'] ?>"><?= $user['name']; ?></option>  
                                <?
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="btn btn-submit" value="Изменить задачу"></td>
            </tr>
        </table>
    </form>
</div>
