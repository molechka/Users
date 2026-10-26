<?
use noicms\mongogrid\OneField;
?>


<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("links_widgets_manage");?></li>
</ol>

<ul class="nav nav-tabs">
    <li class="active"><a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>"><?php echo NoiCore::app()->lang("links_widgets_manage");?></a></li>
      <li ><a href="<?php echo   NoiCore::app()->getRoute('wi/positions')?>"><?php echo NoiCore::app()->lang("links_widgets_manage_positions");?></a></li>
</ul>


<?
$widget=  new OneField();
$widget->init("widget","widgetsselect",array('site'=>$site,'id_site'=>$site['_id']->__toString()));
?>
<h4><?php echo NoiCore::app()->lang("widgets_add");?></h4>
<form action="<?php echo   NoiCore::app()->getRoute('wi/all')?>" method="POST">
    <table class="table">
        <tr>
            <td><?php echo NoiCore::app()->lang("widgets_add_title");?></td>
            <td><input type="text" class="form-control input-lg" name="title" required="required" value=""></td>
        </tr>
        <tr>
            <td><?php echo NoiCore::app()->lang("widgets_add_widget")?></td>
            <td>
                <?
               echo $widget->getInput();
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo NoiCore::app()->lang("widgets_add_position");?></td>
            <td><select class="form-control input-lg" name="position">
              <?
              if(isset($positions) and is_array($positions) and count($positions)>0){
              foreach($positions as $pos){
              ?>
                    <option value="<?php echo $pos;?>"><?php echo $pos;?></option>
              <?
              }
              }
              ?>
                </select></td>
        </tr>
        <tr>
            <td>Language</td>
            <td><select class="form-control input-lg" name="language">
                    <option value="all">all</option>
                <?
                foreach(NoiCore::app()->getListLanguges() as $language){
                 ?>
                    <option value="<?php echo $language;?>"><?php echo $language;?></option>
                  <?
                }
                ?>
                </select>

            </td>
        </tr>
        <tr>
            <td></td>
            <td><input class="btn btn-success" type="submit" name="act_add_widget" value="<?php echo NoiCore::app()->lang("widgets_add_button");?>"></td>
        </tr>
    </table>
</form>
<h2><?php echo NoiCore::app()->lang("widgets_list");?></h2>
<table class="table">
    <thead>
        <tr>
            <th>#id</th>
            <th><?php echo NoiCore::app()->lang("widgets_add_title");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_add_position");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>

            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>
            <th><?php echo NoiCore::app()->lang("widgets_btn");?></th>
        </tr>
    </thead>
    <tbody>
   <?
   $url=  ShoutPlugin::getRoute2()."widget/mysites_components/widgets/".$site['_id']->__toString();
   if(isset($widgets) and is_array($widgets) and count($widgets)>0){
    foreach($widgets as $pos=>$w){
     if(isset($w) and is_array($w) and count($w)>0){
      foreach($w as $number=>$plugin){
      if(isset($plugin['name']) and isset($plugin['show'])){
      $current_id=$plugin['name']."_".$number;
      if(isset($plugin['options']['id'])){
      $current_id=$plugin['options']['id'];
      }
      ?>
    <tr>

        <td>#<?php echo $current_id;?></td>
        <td>
      <? if(!isset($plugin['options']['title'])) { echo $plugin['name']; }else {
        echo $plugin['options']['title'];
      }?>
        </td>
        <td><?php echo $pos;?></td>
        <td>
        <?
        $tmp_number=$number+1;
        if($number>0){
        ?>
            <a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=up"><i class="fa fa-arrow-up"></i></a>
        <?
        }
        ?>


        <?
        $next_number=$number+1;
        if(isset($w[$next_number]['name'])){
        ?>
            <a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=down"><i class="fa fa-arrow-down"></i></a>
        <?
        }
        ?>
        </td>
        <td>
           <?
           if($plugin['show']=="0"){
           ?>
            <a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=show"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if($plugin['show']=="1"){
            ?>
            <a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=hide"><i class="fa  fa-eye"></i></a>
            <?
            }
           ?>
        </td>
        <td><a href="<?php echo   NoiCore::app()->getRoute('wi/'.$pos."/".$number)?>"><i class="fa fa-edit"></i></a></td>
        <td><a href="<?php echo   NoiCore::app()->getRoute('wi/all')?>?position=<?php echo $pos;?>&number=<?php echo $number;?>&op=delete"><i class="fa fa-trash-o"></i></a></td>
    </tr>
     <?
      }
      }
     }
    }
   }
   ?>
    </tbody>
</table>

