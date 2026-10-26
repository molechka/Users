<?
use noicms\mongogrid\OneField;
?>
<form action="" method="POST">
<div class="listview list-container">
   
                    <header class="listview-header media">
                        <input type="checkbox" class="pull-left list-parent-check" value="">

                      

                        <ul class="list-inline list-mass-actions pull-left">

                          


                            <li class="show-on" style="display: none;">
                                <button type="submit"   title="<?=NoiCore::app()->lang('mongogrid_delete');?>" class="tooltips">
                                    <i class="sa-list-delete"></i>
                                </button>
                            </li>
                        </ul>

                        <input name="search_value"  class="input-sm col-md-4  " type="text" placeholder="<?=NoiCore::app()->lang('mongogrid_search');?>" value="<?if(isset($_POST['search_value'])){ echo $_POST['search_value'];}?>">
                       
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
                                             <?
           if(isset($row['visible']) and $row['visible']==0){
           ?>
            <a href="<?=  NoiCore::app()->getRoute('p_form/messages/change/1?id='.$row['_id']->__toString())?>"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if(isset($row['visible']) and $row['visible']==1){
            ?>
            <a href="<?=  NoiCore::app()->getRoute('p_form/messages/change/0?id='.$row['_id']->__toString())?>"><i class="fa  fa-eye"></i></a>
            <?
            }
           ?>
            <a   href="<?=$mg->setRoute('/update/'.$row['_id']->__toString());?>" class="btn btn-sm"><?=NoiCore::app()->lang('mongogrid_edit');?></a>

                                      <a   href="<?=$mg->setRoute('/delete/'.$row['_id']->__toString());?>" class="btn btn-sm delete"><?=NoiCore::app()->lang('mongogrid_delete');?></a>
                                   
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
                      <mgplugin count="<?=$count;?>" limit="<?=$mg->page_item;?>">paginator</mgplugin>
                    </div>
                </div>
</form>
