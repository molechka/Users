<?
use noicms\mongogrid\OneField;
?>
<h3><?=$mg->title;?></h3>

<?=NoiCore::admin()->getManageLink("/content/page/".$mg->result[0]['_id']->__toString().".html");?>
<?
$message=$mg->result[0];
$row=$mg->result[0];
 
?>
<div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted"><?=NoiCore::app()->lang('mongogrid_date');?> <?=date('Y-m-d H:i',$message['date']->sec)?></small><br>
                                    <?

                                    ?>
                                    <p><a href="<?=NoiCore::app()->getRoute('p_form/manage/edit/'.$message['id_form']);?>"><?=$message['name'];?></a></p>
                                    <table class="table">
                                        <tr>
                                            <td><?=NoiCore::app()->lang('mongogrid_date');?></td>
                                            <td><?=date('Y-m-d',$message['date']->sec);?></td>
                                        </tr>
                                      <?
                                      foreach($message['fields'] as $field){
                                      $tmp=new OneField();
                                      $tmp->init($field['name'], $field['type']);

                                      ?>
                                        <tr>
                                            <td><?=$field['label'];?></td>
                                            <td><?=$tmp->showInput($field['value']);?>

                                            </td>
                                        </tr>
                                      <?
                                      }
                                      ?>
                                    </table>
            

                                </div>
                            </div>
<form action="<?=$mg->setRoute('/update/'.$mg->view->tmp_var[2]);?>" method="POST" enctype="multipart/form-data">
    <table class="table">
     <?

     if($mg->fields->showid){

     ?>
     <tr>
     <td>_id</td>

     <td><?=$mg->result[0]['_id']->__toString();?></td>
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
    <td><?=$title;?></td>
    <td><?=$mg->fields->render[$field];?> </td>
    </tr>
    <?
    }
     }
     }
     ?>
    <tr>
     <td></td>
     <td><input type="submit" name="act_update" value="<?=NoiCore::app()->lang('mongogrid_edit');?>"></td>
    </tr>
    </table>
</form>
