<form action="<?=$controller->getRoute('post/new/'.$theme['last_id']);?>" method="POST">
    <table class="table">
        <tr>
            <td>Имя</td>
            <td><input text="text" name="user_name"></td>
        </tr>
         <tr>
            <td>Email</td>
            <td><input text="email" name="user_email"></td>
        </tr>
        <tr>
            <td>Сообщение</td>
            <td><textarea name="message"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="add_reply" value="Добавить сообщение"></td>
        </tr>
    </table>
</form>

