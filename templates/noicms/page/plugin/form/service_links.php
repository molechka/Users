<h3><?=$category['title'];?></h3>
                  <ul >

                 <?



                 foreach($forms as $form){
                $link="/form/".$form['_id']->__toString().".html";
                  ?>
  <li  class=""><a href="<?=$link;?>" title=""><?=$form['title'];?></a>
 <?

?>
                    </li>


 <?
                  }

 ?>
                  </ul>
