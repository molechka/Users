<h3><a href="<?=$controller->getRoute('s/'.$category['_id']->__toString());?>"><?=$category['title'];?></a></h3>
                  <ul >

                 <?
                 $current_url=NoiCore::route()->get();


                 foreach($all_posts as $post){
               $link=$controller->getRoute('page/'.$post['_id']->__toString());
                  ?>
  <li  class="<? if($link==$current_url) echo 'active'?>"><a href="<?=$link;?>" title=""><?=$post['title'];?></a>
 <?

?>
                    </li>


 <?
                  }

 ?>
                  </ul>

