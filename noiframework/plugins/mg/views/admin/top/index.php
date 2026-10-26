<?php

use mg\models\Collections;

 
  $result_all=  Collections::getAll();
                  if(count($result_all)>0){
                    foreach($result_all as $res){
                    ?>
  <li ><a href="<?php echo NoiCore::app()->getRoute('p_mg/manage/index/'.$res['name']);?>"><?=$res['title'];?></a></li>
                    <?
                    }
                  }
