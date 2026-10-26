<h3><?php echo $mg->title;?></h3>

<?php echo NoiCore::admin()->getManageLink("/blog/post/".$mg->result[0]['_id']->__toString().".html");?>

<form action="<?php echo $mg->setRoute('/update/'.$mg->view->tmp_var[2]);?>" method="POST" enctype="multipart/form-data">
    <table class="table">
     <?

     if($mg->fields->showid){

     ?>
     <tr>
     <td>_id</td>

     <td><?php echo $mg->result[0]['_id']->__toString();?></td>
     </tr>
     <?
     }
     if(isset($mg->fields->array_fields)){
     foreach($mg->fields->array_fields as $field){
     $type="hidden";
     if(isset($mg->fields->array_type[$field]['type'])){
     $type=$mg->fields->array_type[$field]['type'];
     }
    $opt=$mg->fields->array_type[$field]['opt'];
    if(isset($opt['plugin']) and $opt['plugin']->isVisible()){
     $title=$mg->fields->array_type[$field]['label'];

    ?>
    <tr>
    <td><?php echo $title;?></td>
    <td><?php echo $mg->fields->render[$field];?> </td>
    </tr>
    <?
    }
     }
     }
     ?>
    <tr>
     <td></td>
     <td><input type="submit" name="act_update" value="<?php echo NoiCore::app()->lang('mongogrid_edit');?>"></td>
    </tr>
    </table>
</form>
