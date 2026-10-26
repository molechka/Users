<?
use noicms\mongogrid\OneField;
?>
<form action="" method="POST">
<div class="listview list-container">
   
                    <header class="listview-header media">
                        <input type="checkbox" class="pull-left list-parent-check" value="">

                      

                        <ul class="list-inline list-mass-actions pull-left">

                          


                            <li class="show-on" style="display: none;">
                                <button type="submit"   title="<?php echo NoiCore::app()->lang('mongogrid_delete');?>" class="tooltips">
                                    <i class="sa-list-delete"></i>
                                </button>
                            </li>
                        </ul>

                        <input name="search_value"  class="input-sm col-md-4  " type="text" placeholder="<?php echo NoiCore::app()->lang('mongogrid_search');?>" value="<?if(isset($_POST['search_value'])){ echo $_POST['search_value'];}?>">
                       
                        <input type="hidden" name="search_field" value="fields.value">
 <input type="submit" value="Найти" class="input-sm col-md-4 pull-right message-search ">
                        <div class="clearfix"></div>
                    </header>
                  <?


    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
      $message=$row;
     ?>
    <div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted"><?php echo NoiCore::app()->lang('mongogrid_date');?> <?php echo date('Y-m-d H:i',$message['date']->sec)?></small><br>
                                    <?

                                    ?>
                                    <p><a href="<?php echo NoiCore::app()->getRoute('p_form/manage/edit/'.$message['id_form']);?>"><?php echo $message['name'];?></a></p>
                                    <table class="table">
                                        <tr>
                                            <td><?php echo NoiCore::app()->lang('mongogrid_date');?></td>
                                            <td><?php echo date('Y-m-d',$message['date']->sec);?></td>
                                        </tr>
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
                                      <a   href="<?php echo $mg->setRoute('/delete/'.$row['_id']->__toString());?>" class="btn btn-sm delete"><?php echo NoiCore::app()->lang('mongogrid_delete');?></a>
                                </div>
                            </div>
     <?
     }
    }
     ?>







                    <div class="media text-center">
                  <?
                  $count=0;
if(isset($mg->result[0]['_count_'])){
$count=$mg->result[0]['_count_'];
}

                  ?>
                      <mgplugin count="<?php echo $count;?>" limit="<?php echo $mg->page_item;?>">paginator</mgplugin>
                    </div>
                </div>
</form>
