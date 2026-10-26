<?
use noicms\mongogrid\OneField;
foreach($messages as $message){
?>
<div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted"><?php echo NoiCore::app()->lang('mongogrid_date');?> <?php echo date('Y-m-d H:i',$message['date']->sec)?></small><br>
                                    <p><a href="<?php echo $controller->getRoute('manage/edit/'.$message['id_form'])?>#html2"><?php echo $message['name'];?></a></p>
                                    <table class="table">
                                      <?
                                      foreach($message['fields'] as $field){
                                      $tmp=new OneField();
                                      $tmp->init($field['name'], $field['type']);
                                      
                                      ?>
                                        <tr>
                                            <td><?php echo $field['label'];?></td>
                                            <td><?php echo $tmp->showInput($field['value']);?>

                                            </td>
                                        </tr>
                                      <?
                                      }
                                      ?>
                                    </table>
                                </div>
                            </div>
<?
}
?>

