<h3><?php echo $mg->title; ?></h3>

<form action="<?php echo $mg->view->setRoute('/create/2'); ?>" method="POST" enctype="multipart/form-data">
    <table class="table">
        <?php
        if (isset($mg->fields->array_fields)) {
            foreach ($mg->fields->array_fields as $field) {
                $type = "hidden";
                if (isset($mg->fields->array_type[$field]['type'])) {
                    $type = $mg->fields->array_type[$field]['type'];
                }

                $title = $mg->fields->array_type[$field]['label'];
                $opt = $mg->fields->array_type[$field]['opt'];
                if (isset($opt['plugin']) and $opt['plugin']->isVisible()) {
                    ?>
                    <tr>
                        <td><?php echo $title; ?></td>
                        <td data-field="<?php echo $field; ?>"  class="field_need  field_<?php echo $field; ?>"><?php echo $mg->fields->render[$field] ?> </td>
                        <td class="<?php echo $field; ?>_error"></td>

                    </tr>
                    <?php
                }
            }
        }
        ?>
        <tr>
            <td><input type="hidden" name="act_create" value="123213213"></td>
            <td><input type="submit" name="act_create_<?php echo $mg->name_short; ?>" value="Создать"></td>
        </tr>
    </table>
</form>
