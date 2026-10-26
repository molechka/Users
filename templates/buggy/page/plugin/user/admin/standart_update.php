<h2>Обновление</h2>

<form data-action="<?php echo $mg->setRoute('/update/'.$mg->view->tmp_var[2]);?>" class="formcontrol" action="javascript:return void();" method="POST" enctype="multipart/form-data">
    <table class="table">
     <?php


     if ($mg->fields->showid) {
         ?>
     <tr>
     <td>_id</td>

     <td><?php echo $mg->result[0]['_id']->__toString(); ?></td>
     </tr>
     <?php

     }
     if (isset($mg->fields->array_fields)) {
         foreach ($mg->fields->array_fields as $field) {
             $type="hidden";
             if (isset($mg->fields->array_type[$field]['type'])) {
                 $type=$mg->fields->array_type[$field]['type'];
             }
             $opt=$mg->fields->array_type[$field]['opt'];
             if (isset($opt['plugin']) and $opt['plugin']->isVisible()) {
                 $title=$mg->fields->array_type[$field]['label']; ?>
                 <tr>
                 <td><?php echo $title; ?></td>
                 <td data-field="<?php echo $field; ?>" class="field_need  field_<?php echo $field; ?>"><?php echo $mg->fields->render[$field]?> </td>
                 <td class="<?php echo $field; ?>_error"></td>

                 </tr>
    <?php

             }
         }
     }
     ?>
    <tr>
     <td></td>
     <td><input type="submit" name="act_update" value="Сохранить"></td>
    </tr>
    </table>
</form>
