<h2>Добавить пользователя</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <table class="table">
        <?php
        if (isset($fields) and count($fields) > 0) {
            foreach ($fields as $field) {
                if (isset($field['field']['label']) and is_object($field['obj'])) {
                    $render = $field['obj']->getInput();

                    $name_field = $field['field']['name'];
                    if ($name_field == "dog") {
                        $render = '<input data-maxl="10" maxlength="10"  class="form-control" name="noibiz_dog" type="text" value="">';
                    }
                    if ($name_field == "parrot") {
                        $render = '<input data-maxl="10" maxlength="10"   class="form-control checkjs" name="noibiz_parrot" type="text" value="">';
                    }
                    if ($name_field == "cavy") {
                        $render = '<input data-maxl="10" maxlength="10" data-jsmax="20"   class="form-control" name="noibiz_cavy" type="text" value="">';
                    }
                    if ($name_field == "hamster") {
                        $render = '<input data-maxl="10" maxlength="10" data-jsmax="10"   class="form-control" name="noibiz_hamster" type="text" value="">';
                    }
                    if ($name_field == "squirrel") {
                        $render = '<input data-maxl="10" maxlength="10" data-jsmax="20"  class="form-control" name="noibiz_squirrel" type="text" value="">';
                    }
                    ?>
                    <tr>
                        <td><?php echo $field['field']['label']; ?></td>
                        <td data-field="<?php echo $field['field']['name']; ?>" class="field_need  field_<?php echo $field['field']['name']; ?>"><?php echo $render; ?></td>
                        <td class="<?php echo $field['field']['name']; ?>_error"></td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        <tr>
            <td></td>
            <td><input type="submit" name="act_create" class="btn btn-danger" value="Добавить пользователя"></td>
        </tr>
    </table>
</form>
