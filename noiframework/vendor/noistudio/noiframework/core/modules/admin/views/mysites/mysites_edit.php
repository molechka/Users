<?
$newdata=array('site'=>$site);
echo $cur->render_setup("editsite_bar",$newdata);
   $array_roles=  ShoutController::getLogged('array_roles');

?>
<p><?php echo Lang::t("mysites_main_params");?>:</p>
<form  method="POST" action="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites/edit/<?php echo $site['_id']->__toString();?>">
<table class="table">
    <tr>
        <td><?php echo Lang::t("mysites_name_site");?></td>
        <td><input type="text" name="title" value="<?php echo $site['title']?>"></td>
    </tr>
    <tr>
        <?
        $domain="";
        if(isset($site['domain_site'])){
        $domain=$site['domain_site'];
        }
        ?>
        <td><?php echo Lang::t("mysites_free_domain");?></td>
        <td><input type="domain" name="domain_site" value="<?php echo $domain;?>">.<?php echo yii::app()->params['main_url'];?></td>
    </tr>
    <tr>
      <?
      $domain_www="";
      if(isset($site['domain_www'])){
      $domain_www=$site['domain_www'];
      }
      if(!isset($site['route_site']) or $site['route_site']==""){
      $route_site="/";
      }else {
      $route_site=$site['route_site'];
      }
      ?>
        <td><?php echo Lang::t("mysites_domain");?></td>
         <td><input type="domain" name="domain_www" value="<?php echo $domain_www;?>"></td>

    </tr>
  <?
  if(isset($array_roles) and is_array($array_roles)){
if(in_array("developer",$array_roles)){

  ?>
    <tr>
        <td><?php echo Lang::t("mysites_route");?></td>
        <td>
        <input type="text" name="route_site" value="<?php echo $route_site;?>">
        </td>
    </tr>
    <tr>
        <td><?php echo Lang::t("mysites_template");?></td>
        <td>
            <select name="theme_site">
            <?
            if(isset($themes[0]['name'])){
               foreach($themes as $th){
               $selected="";
               if(isset($site['theme_site']) and $site['theme_site']==$th['name']){
               $selected="selected";
               }
                ?>
                <option <?php echo $selected;?> value="<?php echo $th['name'];?>"><?php echo $th['title'];?></option>
                <?
               }
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Категории</td>
        <td><?
        $field=new OneField();
        $opt_field=array('collection'=>'widget_sites_category_type','select'=>array('title'),'condition'=>array());
        $field->init("type_category", "multiselect", $opt_field);
        
        if(!isset($site['type_category']) or !is_array($site['type_category'])){
         $site['type_category']=array();
        }
         
        echo $field->getInput($site['type_category']);
        ?></td>
    </tr>
    <tr>
        <td>Обновить данные из config? оригинала</td>
        <td><input type="checkbox" name="update_theme" value="1"> </td>
    </tr>
    <tr>
        <td>Обновить данные из config? пользовательского</td>
        <td><input type="checkbox" name="update_theme_custom" value="1"> </td>
    </tr>
     <tr>
        <td>Восстановить динамические файлы(php) из оригинала?</td>
        <td><input type="checkbox" name="update_theme_dynamic" value="1"> </td>
    </tr>
    <tr>
        <td>Восстановить tpl из оригинала?</td>
        <td><input type="checkbox" name="update_theme_tpl" value="1"> </td>
    </tr>
       <tr>
        <td>Скопировать статичные данные</td>
        <td><input type="checkbox" name="update_theme_static" value="1"> </td>
    </tr>
   
    <?

}
}
    ?>
    <tr>
        <td></td>
        <td><input type="submit"  name="act_edit" class="btn btn-active" value="<?php echo Lang::t("mysites_continue");?>"></td>
    </tr>

</table>
</form>