<?

use noicms\mongogrid\GridConf;
$gridconf=new GridConf;
?>
              

                <h4 class="page-title"><?php echo NoiCore::app()->lang("dashboard")?></h4>

                <!-- Shortcuts -->
                <div class="block-area shortcut-area">
                    <a class="shortcut tile" href="<?php echo NoiCore::app()->getRoute('p_shop/orders/index')?>">
                        <img src="/themes/admin/noishop/assets/img/shortcuts/money.png" alt="">
                        <small class="t-overflow"><?php echo NoiCore::app()->lang("dashboard_orders")?></small>
                    </a>
                    <a class="shortcut tile" href="<?php echo NoiCore::app()->getRoute('p_blog/entry')?>">
                        <img src="/themes/admin/noishop/assets/img/shortcuts/posts.png" alt="">
                        <small class="t-overflow"><?php echo NoiCore::app()->lang("dashboard_entrys")?></small>
                    </a>
                    <a class="shortcut tile" href="<?php echo NoiCore::app()->getRoute('p_content/manage/show/0');?>">
                        <img src="/themes/admin/noishop/assets/img/shortcuts/pages.png" alt="">
                        <small class="t-overflow"><?php echo NoiCore::app()->lang("dashboard_pages")?></small>
                    </a>
                    <a class="shortcut tile" href="<?php echo NoiCore::app()->getRoute('p_stats/show/index');?>">
                        <img src="/themes/admin/noishop/assets/img/shortcuts/stats.png" alt="">
                        <small class="t-overflow"><?php echo NoiCore::app()->lang("dashboard_stats")?></small>
                    </a>
                    <a class="shortcut tile" href="<?php echo NoiCore::app()->getRoute('p_shop/items/index');?>">
                        <img src="/themes/admin/noishop/assets/img/shortcuts/items.png" alt="">
                        <small class="t-overflow"><?php echo NoiCore::app()->lang("dashboard_items")?></small>
                    </a>
                    
                </div>

                <hr class="whiter" />

                <!-- Quick Stats -->
                <div class="block-area">
                      <div class="row">
                        <div class="col-md-8">
                            <!-- Main Chart -->
                            <div class="tile">
                                <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_stats")?></h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tile-menu"></a>
                                    <ul class="dropdown-menu pull-right text-right">

                                    </ul>
                                </div>
                                <div class="p-10">
                                    <div id="line-chart" class="main-chart" style="height: 250px"></div>
<?
$stats_results=NoiCore::app()->db()->query2(array(),"stats_plugin",array('date'=>date('Y-m-d')));
$all_hosts=0;
$all_views=0;
 
if(count($stats_results)>0){
foreach($stats_results as $st){
$all_hosts+=$st['hosts'];
$all_views+=$st['views'];
}
}
?>
                                    <div class="chart-info">

                                        <ul class="list-unstyled">
                                            <li class="m-b-10">
                                                <?php echo NoiCore::app()->lang("dashboard_all_hosts")?> <?php echo $all_hosts;?>
                                                <?
                                                if(isset($stats_results[0]['hosts'])){
                                                ?>
                                                <span class="pull-right text-muted t-s-0">
                                                    <i class="fa fa-chevron-up"></i>
                                                    +<?php echo $stats_results[0]['hosts'];?>
                                                </span>
                                                <?
                                                }
                                                ?>
                                            </li>
                                            <li class="m-b-10">
                                                <?php echo NoiCore::app()->lang("dashboard_all_views")?> <?php echo $all_hosts;?>
                                                <?
                                                if(isset($stats_results[0]['views'])){
                                                ?>
                                                <span class="pull-right text-muted t-s-0">
                                                    <i class="fa fa-chevron-up"></i>
                                                    +<?php echo $stats_results[0]['views'];?>
                                                </span>
                                                <?
                                                }
                                                ?>
                                            </li>
                                            <?
                                            if(count($stats_results)>0){
                                            foreach($stats_results as $key=>$stl){
                                             $newkey=$key+1;
                                             $plus_hosts="";
                                             $plus_views="";
                                             if(isset($stats_results[$newkey])){
                                             if(isset($stats_results[$newkey]['hosts']) and isset($stats_results['views'])){
                                            if($stl['hosts']>$stats_results[$newkey]['hosts']){
                                                $tmp_res=$stl['hosts']-$stats_results[$newkey]['hosts'];
                                           $plus_hosts='<span class="pull-right text-muted t-s-0"><i class="fa m-l-15 fa-chevron-up"></i> +'.$tmp_res.'</span>';
                                            }else {
                                           $tmp_res=$stats_results[$newkey]['hosts']-$stl['hosts'];
                                           $plus_hosts='<span class="pull-right text-muted t-s-0"><i class="fa m-l-15 fa-chevron-down"></i> -'.$tmp_res.'</span>';
                                            }
                                             if($stl['views']>$stats_results[$newkey]['views']){
                                                $tmp_res=$stl['views']-$stats_results[$newkey]['views'];
                                           $plus_views='<span class="pull-right text-muted t-s-0"><i class="fa m-l-15 fa-chevron-up"></i> +'.$tmp_res.'</span>';
                                            }else {
                                           $tmp_res=$stats_results[$newkey]['views']-$stl['views'];
                                           $plus_views='<span class="pull-right text-muted t-s-0"><i class="fa m-l-15 fa-chevron-down"></i> -'.$tmp_res.'</span>';
                                            }
                                             }
                                             }
                                            ?>
                                             <li>
                                                <small>
                                                    <?php echo $stl['date']?> - <?php echo NoiCore::app()->lang("dashboard_hosts")?> <?php echo $stl['hosts'];?>
                                                    <?php echo $plus_hosts?>
                                                </small>
                                                <div class="progress progress-small">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $stl['hosts'];?>" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>
                                                </div>
                                            </li>
                                             <li>
                                                <small>
                                                    <?php echo $stl['date']?> - <?php echo NoiCore::app()->lang("dashboard_views")?> <?php echo $stl['views'];?>
                                                    <?php echo $plus_views?>
                                                </small>
                                                <div class="progress progress-small">
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $stl['views'];?>" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>
                                                </div>
                                            </li>
                                            <?
                                            }
                                            }
                                            ?>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Pies -->
                            <div class="tile text-center">
                                <div class="tile-dark p-10">

                                    <div class="pie-chart-tiny" data-percent="<?php echo $percent_new_hosts;?>">
                                        <span class="percent"></span>
                                        <span class="pie-title"><?php echo NoiCore::app()->lang("dashboard_hosts")?> <i class="m-l-5 fa fa-retweet"></i></span>
                                    </div>

                                    <div class="pie-chart-tiny" data-percent="<?php echo $percent_new_views;;?>">
                                        <span class="percent"></span>
                                        <span class="pie-title"><?php echo NoiCore::app()->lang("dashboard_views")?> <i class="m-l-5 fa fa-retweet"></i></span>
                                    </div>
                                    <div class="pie-chart-tiny" data-percent="<?php echo $percent_new_users;?>">
                                        <span class="percent"></span>
                                        <span class="pie-title"><?php echo NoiCore::app()->lang("dashboard_users")?> <i class="m-l-5 fa fa-retweet"></i></span>
                                    </div>
                                    <div class="pie-chart-tiny" data-percent="<?php echo $percent_blocked;?>">
                                        <span class="percent"></span>
                                        <span class="pie-title"><?php echo NoiCore::app()->lang("dashboard_blocked")?> <i class="m-l-5 fa fa-retweet"></i></span>
                                    </div>
                                    <div class="pie-chart-tiny" data-percent="<?php echo $percent_messages;?>">
                                        <span class="percent"></span>
                                        <span class="pie-title"><?php echo NoiCore::app()->lang("dashboard_messages")?> <i class="m-l-5 fa fa-retweet"></i></span>
                                    </div>
                                </div>
                            </div>

                            <!--  Recent Postings -->
                            <div class="row">
                              

                                <!-- Tasks to do -->
                                
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="col-md-4">
                            <!-- USA Map -->
                            <div class="tile">
                                <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_locate")?></h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tile-menu"></a>
                                    <ul class="dropdown-menu pull-right text-right">

                                    </ul>
                                </div>

                                <div id="usa-map"></div>
                            </div>

                            <!-- Dynamic Chart -->
                            <div class="tile">
                                <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_load_server")?></h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tile-menu"></a>
                                    <ul class="dropdown-menu pull-right text-right">

                                    </ul>
                                </div>

                                <div class="p-t-10 p-r-5 p-b-5">
                                    <div id="dynamic-chart" style="height: 200px"></div>
                                </div>

                            </div>

                           
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <?

                   
                        $stats=NoiCore::app()->db()->query(array(),"stats_plugin",array('date'=>date('Y-m-d')));
                        $views=0;
                        if(isset($stats[0]['hosts'])){
                        $views=$stats[0]['hosts'];
                        }
                        ?>

                        <div class="col-md-3 col-xs-6">
                            <div class="tile quick-stats">
                                <div id="stats-line-2" class="pull-left"></div>
                                <div class="data">
                                    <h2 data-value="<?php echo $count_items;?>">0</h2>
                                    <small><?php echo NoiCore::app()->lang("dashboard_all_items")?></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="tile quick-stats media">
                                <div id="stats-line-3" class="pull-left"></div>
                                <div class="media-body">
                                    <h2 data-value="<?php echo $count_pages;?>">0</h2>
                                    <small><?php echo NoiCore::app()->lang("dashboard_count_pages")?></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="tile quick-stats media">

                                <div id="stats-line-4" class="pull-left"></div>

                                <div class="media-body">
                                    <h2 data-value="<?php echo $count_orders;?>">0</h2>
                                    <small><?php echo NoiCore::app()->lang("dashboard_all_orders")?></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-6">
                            <div class="tile quick-stats media">
                                <div id="stats-line" class="pull-left"></div>
                                <div class="media-body">
                                    <h2 data-value="<?php echo $views;?>">0</h2>
                                    <small><?php echo NoiCore::app()->lang("dashboard_stats_today")?></small>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <hr class="whiter" />

                <!-- Main Widgets -->
  <div class="block-area" id="content-boxes">
      <h3 class="block-title"><a href="<?php echo NoiCore::app()->getRoute('p_gallery/alboms/index');?>"><?php echo NoiCore::app()->lang("dashboard_gallery");?></a></h3>

                     <div class="row">
                         <?
                         if(isset($alboms) and count($alboms)>0){
                         foreach($alboms as $albom){
                         $photo1="";
                         if(isset($albom['photos'][0]['photo'])){
                         if(is_array($albom['photos'][0]['photo'])){
                         foreach($albom['photos'][0]['photo'] as $photo){
                          $photo1=$photo;
                          break;
                         }
                         }else {
                         $photo1=$albom['photos'][0]['photo'];
                         }
                         }
                        ?>
                         <div class="col-sm-6 col-md-4">
                               <div class="thumbnail tile">
                                   <a href="<?php echo NoiCore::app()->getRoute('p_gallery/alboms/photo/'.$albom['_id']->__toString());?>"> <img src="<?php echo $photo1;?>" alt=""></a>
                                    <div class="p-15">
                                        <h4><?php echo $albom['title'];?></h4>
                           <?
                           if(isset($albom['description'])){
                             echo $albom['description'];
                           }
                           ?>
                                        <p>
                                            <a href="<?php echo NoiCore::app()->getRoute('p_gallery/alboms/photo/'.$albom['_id']->__toString());?>" class="btn   btn-success"><?php echo NoiCore::app()->lang("dashboard_gallery_foto");?></a>
                                            <a href="<?php echo NoiCore::app()->getRoute('p_gallery/alboms/size/'.$albom['_id']->__toString());?>" class="btn   btn-danger"><?php echo NoiCore::app()->lang("dashboard_gallery_setup");?></a>
                                        </p>
                                    </div>
                               </div>
                          </div>
                        <?
                         }
                         }
                         ?>
                         

                        
                     </div>
                </div>
                <div class="block-area">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?php echo NoiCore::app()->getRoute('p_content/manage/show/0?path_grid_asd=/create/2')?>" method="POST">
                             <div class="tile">
                                <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_content_create");?></h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right">
                                    
                                    </ul>
                                </div>

                          
                                    <div class="form-group m-b-15">
                                        <label><?php echo NoiCore::app()->lang("dashboard_content_name");?></label>
                                        <input type="text" name="<?php echo $gridconf->name_field;?>title" class="form-control input-sm">
                                    </div>

                                    <div class="form-group m-b-15">
                                        <label><?php echo NoiCore::app()->lang("dashboard_content_category");?></label>
                                        <select name="<?php echo $gridconf->name_field;?>category" class="select">
                                            <?
                                            $category_content=NoiCore::app()->db()->query2(array(),"user_content_category",array());
                                            if(count($category_content)>0){
                                             foreach($category_content as $category){
                                              ?>
                                            <option value="<?php echo $category['_id']->__toString()?>"><?php echo $category['title'];?></option>
                                              <?
                                             }
                                            }
                                            ?>
                                             
                                        </select>
                                    </div>

                                    <div class="block-area form-group m-b-15" >
                                        <label><?php echo NoiCore::app()->lang("dashboard_content_text");?></label>
                                       
                                         <textarea class="editore" name="<?php echo $gridconf->name_field;?>content" rows="10"></textarea>
                                    </div>
<input type="hidden" name="act_create" value="123213213">
<input type="hidden" name="act_create_asd" value="Создать">
                                    <button type="submit" class="btn btn-sm"><?php echo NoiCore::app()->lang("dashboard_add_content");?></button>


                               
                             </div></form>
                        </div>
                         <div class="col-md-6">
                             <div class="tile">
                                <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_blog_add");?></h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right">

                                    </ul>
                                </div>

                                <form action="<?php echo NoiCore::app()->getRoute('p_blog/entry/index?path_grid_asd=/create/2')?>"   class="p-15" method="POST">
                                    <div class="form-group m-b-15">
                                        <label><?php echo NoiCore::app()->lang("dashboard_blog_name");?></label>
                                        <input type="text" required name="<?php echo $gridconf->name_field;?>title" class="form-control input-sm">
                                    </div>
                                     <div class="form-group m-b-15">
                                         <label><?php echo NoiCore::app()->lang("dashboard_blog_author");?></label>
                                        <input type="text" required  name="<?php echo $gridconf->name_field;?>name_author" class="form-control input-sm">
                                    </div>

                                    <div class="form-group m-b-15">
                                        <label><?php echo NoiCore::app()->lang("dashboard_blog_category");?></label>
                                        <select class="select"  name="<?php echo $gridconf->name_field;?>category">
                                         <?
                                         $categorysp=NoiCore::app()->db()->query2(array(),"user_blog_category",array());

                                         ?>
                                         <?
                                         if(count($categorysp)>0){
                                         foreach($categorysp as $pcat){
                                         ?>
                                            <option value="<?php echo $pcat['_id']->__toString();?>"><?php echo $pcat['title'];?></option>
                                         <?

                                         }
                                         }
                                         ?>
                                        </select>
                                    </div>

                                    <div class="form-group m-b-15">
                                        <label><?php echo NoiCore::app()->lang("dashboard_blog_text");?></label>
                                     <textarea class="editore" name="<?php echo $gridconf->name_field;?>full" rows="10"></textarea>
                                    </div>
<input type="hidden" name="act_create" value="123213213">
<input type="hidden" name="act_create_asd" value="Создать">
                                    <button type="submit" class="btn btn-sm"><?php echo NoiCore::app()->lang("dashboard_add_blog");?></button>


                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Main Chart -->
                           



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="tile">
                                        <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_last_pages");?></h2>
                                        <div class="tile-config dropdown">
                                            <a data-toggle="dropdown" href="" class="tile-menu"></a>
                                            <ul class="dropdown-menu animated pull-right text-right">

                                            </ul>
                                        </div>

                                        <div class="listview narrow">
                                        <?
                                        
                                        if(isset($last_pages) and count($last_pages)>0){
                                        foreach($last_pages as $page){
                                        ?>
                                       <div class="media p-l-5">
                                                <div class="pull-left">
                                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <small class="text-muted"><a href="<?php echo NoiCore::app()->getRoute('p_content/content/manage/show/0?path_grid_asd=/update/'.$page['_id']->__toString());?>" class="btn-danger"><?php echo NoiCore::app()->lang("dashboard_edit");?></a></small><br/>
                                                    <a class="t-overflow" href="<?php echo NoiCore::admin()->getPreview("/content/page/".$page['_id']->__toString().".html");?>"><?php echo $page['title'];?></a>

                                                </div>
                                            </div>
                                        <?
                                        }
                                        }
                                        ?>

                                          
                                            <div class="media p-5 text-center l-100">
                                                <a href="<?php echo NoiCore::app()->getRoute('p_content/page');?>"><small><?php echo NoiCore::app()->lang("w_all_messages");?></small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<div class="col-md-6">
                                    <div class="tile">
                                        <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_last_items");?></h2>
                                        <div class="tile-config dropdown">
                                            <a data-toggle="dropdown" href="" class="tile-menu"></a>
                                            <ul class="dropdown-menu animated pull-right text-right">

                                            </ul>
                                        </div>

                                        <div class="listview narrow">
                                        <?
                                        $last_items=NoiCore::app()->db()->query(array(),"user_shop",array(),array('_id'=>-1),10);
                                        if(isset($last_items) and count($last_items)>0){
                                        foreach($last_items as $item){
                                        ?>
                                       <div class="media p-l-5">
                                           <?
                                        
                                           if(isset($item['fotos'][0]['foto']['84x84'])){

                                           ?>
                                                <div class="pull-left">
                                                    <img width="40" src="<?php echo $item['fotos'][0]['foto']['84x84'];?>" alt="">
                                                </div>
                                           <?
                                           }else {
                                           ?>
                                           <div class="pull-left">
                                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                                </div>
                                           <?
                                           }
                                           ?>
                                                <div class="media-body">
                                                    <small class="text-muted"><a href="<?php echo NoiCore::app()->getRoute('p_shop/items/edit/'.$item['_id']->__toString());?>" class="btn-danger"><?php echo NoiCore::app()->lang("dashboard_edit");?></a></small><br/>
                                                    <a class="t-overflow" href="<?php echo NoiCore::admin()->getPreview("/shop/item/".$item['_id']->__toString().".html");?>"><?php echo $item['title'];?></a>

                                                </div>
                                            </div>
                                        <?
                                        }
                                        }
                                        ?>


                                            <div class="media p-5 text-center l-100">
                                                <a href="<?php echo NoiCore::app()->getRoute('p_shop/items/index');?>"><small><?php echo NoiCore::app()->lang("w_all_messages");?></small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                          
                            </div>
                            <div class="clearfix"></div>
                        </div>

                     <div class="col-md-4">
                                    <div class="tile">
                                        <h2 class="tile-title"><?php echo NoiCore::app()->lang("dashboard_last_posts");?></h2>
                                        <div class="tile-config dropdown">
                                            <a data-toggle="dropdown" href="" class="tile-menu"></a>
                                            <ul class="dropdown-menu animated pull-right text-right">

                                            </ul>
                                        </div>

                                        <div class="listview narrow">
                                        <?
                                        $last_posts=NoiCore::app()->db()->query(array(),"user_blog",array(),array('_id'=>-1),10);
                                        if(isset($last_posts) and count($last_posts)>0){
                                        foreach($last_posts as $post){
                                        ?>
                                       <div class="media p-l-5">
                                              <div class="pull-left">
                                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <small class="text-muted"><a href="<?php echo NoiCore::app()->getRoute('p_blog/entry?path_grid_asd=/update/'.$post['_id']->__toString());?>" class="btn-danger"><?php echo NoiCore::app()->lang("dashboard_edit");?></a></small><br/>
                                                    <a class="t-overflow" href="<?php echo NoiCore::admin()->getPreview("/blog/post/".$post['_id']->__toString().".html");?>"><?php echo $post['title'];?></a>

                                                </div>
                                            </div>
                                        <?
                                        }
                                        }
                                        ?>


                                            <div class="media p-5 text-center l-100">
                                                <a href="<?php echo NoiCore::app()->getRoute('p_shop/items/index');?>"><small><?php echo NoiCore::app()->lang("w_all_messages");?></small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

               
          

