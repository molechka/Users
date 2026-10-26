<h2>Мои сайты</h2>
<?
if(isset($rows[0]['_count_'])){
$count=$rows[0]['_count_'];
}else {
$count=0;
}
$available=$available-$count;
 $array_roles=  ShoutController::getLogged('array_roles');

if(isset($array_roles) and is_array($array_roles)){
if(in_array("developer",$array_roles)){
  $available=777;
   $left_html='<nav class="nav-v">
    <ul class="page-sidebar-menu"><li class="active"><a  href="'.ShoutPlugin::getRoute2().'widget/mysites/show">Сайты</a></li><li><a href="'.ShoutPlugin::getRoute2().'widget/sites_category/show">Категории сайтов</a></li><li><a href="'.ShoutPlugin::getRoute2().'widget/config_constructor/show">Конструктор конфига</a></li>'
       . '<li><a href="'.ShoutPlugin::getRoute2().'ext/lists/show">Расширения</a></li></ul>';
 yii::app()->params['left_col']=$left_html;
 ?>
<form action="" method="POST">
<table>
    <tr>
        <td>Категория</td>
        <td><select name="category_type">
                <option value="all">Показывать все</option>
                <?
                if(Isset($filter_category) and is_array($filter_category) and isset($filter_category[0]['_id'])){
                 foreach($filter_category as $filter){
                 $selected="";
                 if(isset($_POST['category_type']) and $filter['_id']->__toString()==$_POST['category_type']){
                 $selected="selected";
                 }
                 ?>
                <option <?php echo $selected;?> value="<?php echo $filter['_id']->__toString();?>"><?php echo $filter['title'];?></option>
                 <?
                 }
                }
                ?>
            </select></td>
            <td><input type="submit" name="act_filter_set" value="Отфильтровать"></td>
    </tr>
</table>
</form>
<?
}
}

if($available>0){
?>
<div class="message message-info">
<?
$lang_title=Lang::t("mysites_alert_info");
$lang_title=  str_replace('[n]', $available, $lang_title);
?>
    <p><?php echo $lang_title;?></p>
    <p><a  class="btn btn-red" href="<?php echo   ShoutPlugin::getRoute2()?>startsite/step/1"><?php echo Lang::t("mysites_create");?></a></p>
</div>
<?
}
?>
<table class="table">
    <thead>
        <tr>
            <th><?php echo Lang::t("mysites_name_site");?></th>
      <?
       if(isset($array_roles) and is_array($array_roles)){
if(in_array("developer",$array_roles)){
      ?><th><?php echo Lang::t("mysites_type");?></th>
            <?
       }}
            ?>
            <th><?php echo Lang::t("mysites_button");?></th>
            <th><?php echo Lang::t("mysites_button");?></th>
            <th><?php echo Lang::t("mysites_button");?></th>
        </tr>
    </thead>
 <?
 if(isset($rows[0]['_id'])){
 foreach($rows as $row){
 ?>
    <tr>
        <td><?php echo $row['title'];?></td>
      
<?

      if(isset($array_roles) and is_array($array_roles)){
if(in_array("developer",$array_roles)){
echo "<td>".$row['type_site_title']."</td>";}
      }?>
        <td><a  class="btn btn-active" href="<?php echo   ShoutPlugin::getRoute2()?>widget/mysites/edit/<?php echo $row['_id']->__toString();?>"><?php echo Lang::t("mysites_edit");?></a></td>
        <td><a  class="btn btn-active" href=""><?php echo Lang::t("mysites_delete");?></a></td>
        <td>
      <?
      if(isset($array_roles) and is_array($array_roles)){
if(in_array("developer",$array_roles)){
?>
            <a href="<?php echo   ShoutPlugin::getRoute2()?>widget/download/<?php echo $row['_id']->__toString();?>"><?php echo Lang::t("mysites_download");?></a>
<?
}
}
      ?>
        </td>
    </tr>
 <?
 }
 }
 ?>
</table>