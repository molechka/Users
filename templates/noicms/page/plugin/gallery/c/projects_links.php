<h3><?=$category['title'];?></h3>
                  <ul >

                 <?



                 foreach($alboms as $albom){
                $link="/gallery/show/".$albom['_id']->__toString().".html";
                  ?>
  <li  class=""><a href="<?=$link;?>" title=""><?=$albom['title'];?></a>
 <?

?>
                    </li>


 <?
                  }

 ?>
                  </ul>
