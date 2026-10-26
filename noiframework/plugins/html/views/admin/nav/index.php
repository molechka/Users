<li class="<? if($current_page=="p_html" or $widget_page=="html"){ echo "active";} ?> dropdown">
                        <a class="sa-side2-html" href="">
                            <span class="menu-item">html</span>
                        </a>
                        <ul class="list-unstyled menu-item">
                        <?
                         
                        if(isset($widgets) and count($widgets)>0){
                        foreach($widgets as $w){
                        ?>
                        <li><a href="<?php echo NoiCore::app()->getRoute('wi/'.$w['position'].'/'.$w['number']);?>"><?php echo $w['options']['title']?></a></li>
                        <?
                        }
                        }
                        ?>

                      



                        </ul>
                    </li>