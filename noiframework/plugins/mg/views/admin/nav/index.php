<?
use mg\models\Collections;

$ismg=(bool)NoiCore::app()->getParam("mg_manage");
?>
<li class="<? if($ismg==true){ echo "active";} ?> ">
                        <a class="sa-side-typography" href="<?php echo NoiCore::app()->getRoute('p_mg/collections/index');?>">
                            <span class="menu-item">AutoCRUD</span>
                        </a>
                     
                    </li>
                    
                        <?
                    $result_all=  Collections::getAll();
                    if(count($result_all)>0){
                    foreach($result_all as $res){
                        
                     $isactive=(bool)NoiCore::app()->getParam("mg_manage_".$res['name']);  
                    ?>
               <li class="<? if($isactive===true) { echo 'active';} ?> ">
                        <a class="sa-side-superpuper" style="background-image: url(<?=$res['icon'];?>)" href="<?php echo NoiCore::app()->getRoute('p_mg/manage/index/'.$res['name']);?>">
                            <span class="menu-item"><?=$res['title'];?></span>
                        </a>
                        
                    </li>     
 
   
                    
  
                    <?
                    }    
                    }
                    ?>
                       

