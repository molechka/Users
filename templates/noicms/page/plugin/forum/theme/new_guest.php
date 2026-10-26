<h2>Новая тема в категории <?=$category['title'];?></h2>
<form action="<?=$controller->getRoute('theme/docreate/'.$category['last_id']);?>" method="POST">
<table class="table">
    <tr>
        <td>Имя</td>
        <td><input type="text" name="user_name" required value=""></td>

    </tr>
    <tr>
        <td>Email</td>
        <td><input type="email" name="user_email" required value=""></td>
    </tr>
    <tr>
        <td>Название темы</td>
        <td><input type="text" name="theme_name" required value=""></td>

    </tr>
     <tr>
        <td>Сообщение</td>
        <td><textarea name="message" required ></textarea></td>

    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="create_theme" value="Создать тему"></td>
    </tr>
</table>
</form>

