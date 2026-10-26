<h2><?php echo Lang::t("component_admin_create_site");?></h2>
<form action="<?php echo   ShoutPlugin::getRoute2();?>widget/mysites/add" method="POST">
<table class="table">
    <tr>
        <td><?php echo Lang::t("mysites_name_site");?></td>
        <td><input type="text" name="title" value=""></td>
    </tr>
    <tr>
        <td><?php echo Lang::t('mysites_type');?></td>
        <td><select name="type_site">
            <?
            if(isset($type_sites[0]['_id'])){
             foreach($type_sites as $type){
             ?>
                <option value="<?php echo $type['type']?>"><?php echo $type['title'];?></option>
             <?
             }
            }
            ?>
            </select></td>
    </tr>
    <?
     $array_roles=  ShoutController::getLogged('array_roles');

if(isset($array_roles) and is_array($array_roles)){
if(in_array("developer",$array_roles)){
?>
    <tr>
        <td><?php echo Lang::t("mysites_client");?></td>
           <td><select name="id_user">
     <?
     $client_list=  MGQuery::execute2(array("_id","email","username","name"),  ShoutStatic::param('collection_users'),array('array_roles'=>array('$in'=>array("client"))));
     if(isset($client_list[0]['_id'])){
      foreach($client_list as $cl){
      if(isset($cl['email']) and isset($cl['username'])){
      if(!isset($cl['name'])){
      $cl['name']="";
      }
      ?>
                   <option value="<?php echo $cl['_id']->__toString();?>"><?php echo $cl['email']?> <?php echo $cl['username']?> <?php echo $cl['name'];?></option>
      <?
      }
      }
     }
     ?>
            </select></td>
    </tr>
<?
}
}
    ?>
    <tr>
        <td></td>
        <td><input class="btn btn-active" type="submit" name="act_send" value="<?php echo Lang::t("mysites_send_form");?>"></td>
    </tr>
</table>
</form>