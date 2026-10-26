<form action="" method="POST">
<div class="listview list-container">

                            <h2><?php echo $mg->title;?></h2>

                    <header class="listview-header media">
                        <input type="checkbox" class="pull-left list-parent-check" value="">



                        <ul class="list-inline list-mass-actions pull-left">
                            <li>
                                <a   href="<?php echo $mg->setRoute('/create/1');?>" title="<?php echo NoiCore::app()->lang('mongogrid_create');?>" class="tooltips">
                                    <i class="sa-list-add"></i>
                                </a>
                            </li>



                            <li class="show-on" style="display: none;">
                                <button type="submit"   title="<?php echo NoiCore::app()->lang('mongogrid_delete');?>" class="tooltips">
                                    <i class="sa-list-delete"></i>
                                </button>
                            </li>
                        </ul>

                        <input name="search_value"  class="input-sm col-md-4 pull-right message-search" type="text" placeholder="<?php echo NoiCore::app()->lang('mongogrid_search');?>" value="<?if(isset($_POST['search_value'])){ echo $_POST['search_value'];}?>">
                        <input type="hidden" name="search_field" value="title">

                        <div class="clearfix"></div>
                    </header>
                  <?


    if(isset($mg->result) and isset($mg->result[0]['_id'])){
     foreach($mg->result as $row){
     ?>
     <div class="media">
                        <input type="checkbox" name="delete[]"  class="pull-left list-check" value="<?php echo $row['_id']->__toString();?>">
                        <div class="media-body">
                            <?php echo $row['title'];?>
                              <div class="clearfix"></div>
                              <div class="attrs">
                                <?
           if($row['visible']==0){
           ?>
            <a href="<?php echo   NoiCore::app()->getRoute('p_blog/entry/change/1?id='.$row['_id']->__toString())?>"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if($row['visible']==1){
            ?>
            <a href="<?php echo   NoiCore::app()->getRoute('p_blog/entry/change/0?id='.$row['_id']->__toString())?>"><i class="fa  fa-eye"></i></a>
            <?
            }
           ?>
                              </div>
                            <div class="list-options">
                    <?
                    if($row['visible']==1){

                    ?>
                                <a href="<?php echo NoiCore::admin()->getPreview("/blog/post/".$row['_id']->__toString().".html");?>" target="_blank" class="btn btn-sm"><?php echo NoiCore::app()->lang('mongogrid_look');?></a>
                            <?
                    }
                            ?>
                                <a href="<?php echo $mg->setRoute('/update/'.$row['_id']->__toString());?>" class="btn btn-sm"><?php echo NoiCore::app()->lang('mongogrid_edit');?></a>
                                <a  href="<?php echo $mg->setRoute('/delete/'.$row['_id']->__toString());?>" class="delete btn btn-sm"><?php echo NoiCore::app()->lang('mongogrid_delete');?></a>
                            </div>
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


