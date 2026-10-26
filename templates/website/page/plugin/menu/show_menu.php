 <?
                 $current_url=NoiCore::route()->get();

                 if(isset($value) and is_array($value) and count($value)>0){
                 foreach($value as $val){
                  if(isset($val['title']) and isset($val['link'])){
                  ?>
  <li><a href="<?=$val['link'];?>"><?=$val['title'];?></a></li>
                  <? }
                 }
                 }
                  ?>

