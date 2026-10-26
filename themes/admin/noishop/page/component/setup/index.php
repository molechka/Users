<ol class="breadcrumb">
    <li><a href="<?php echo   NoiCore::app()->getRoute("");?>"><?php echo NoiCore::app()->lang("links_main");?></a></li>

  <li class="active"><?php echo NoiCore::app()->lang("setup_title");?></li>
</ol>
<h2><?php echo NoiCore::app()->lang("setup_title");?></h2>
<?
if($op==1){
?>
<div class="alert alert-success">
    <p><?php echo NoiCore::app()->lang("success_save");?></p>
</div>
<?
}
?>
<form action="" method="POST">
<table class="table">
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_title");?></td>
        <td><input type="text" name="title" value="<?if(isset($site['title'])) { echo $site['title'];}?>"> </td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_title_mainpage");?></td>
        <td><input type="text" name="title_mainpage" value="<?if(isset($site['title_mainpage'])) { echo $site['title_mainpage'];}?>"> </td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_meta_keywords");?></td>
        <td><input type="text" name="keywords" value="<? if(isset($site['keywords'])) { echo $site['keywords'];}?>"> </td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_meta_description");?></td>
        <td><input type="text" name="description" value="<? if(isset($site['description'])) { echo $site['description'];}?>"> </td>
    </tr>
    <?
    $languages=NoiCore::app()->getListLanguges();
    if(count($languages)>0 and NoiCore::lang()->is()){
    foreach($languages as $lang){
    ?>
      <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_title");?>(<?=$lang;?>)</td>
        <td><input type="text" name="title_<?php echo $lang?>" value="<?if(isset($site['title_'.$lang])) { echo $site['title_'.$lang];}?>"> </td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_title_mainpage");?>(<?=$lang;?>)</td>
        <td><input type="text" name="title_mainpage_<?php echo $lang;?>" value="<?if(isset($site['title_mainpage_'.$lang])) { echo $site['title_mainpage_'.$lang];}?>"> </td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_meta_keywords");?>(<?=$lang;?>)</td>
        <td><input type="text" name="keywords_<?php echo $lang;?>" value="<? if(isset($site['keywords_'.$lang])) { echo $site['keywords_'.$lang];}?>"> </td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_meta_description");?>(<?=$lang;?>)</td>
        <td><input type="text" name="description_<?php echo $lang?>" value="<? if(isset($site['description_'.$lang])) { echo $site['description_'.$lang];}?>"> </td>
    </tr>
    <?
    }
    }
    ?>
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_tag_widget");?> </td>
                <td><select name="tag_widget_disable">
                        <option <? if(isset($site['tag_widget_disable']) and $site['tag_widget_disable']==0) { echo 'selected';} ?>  value="0"><?php echo NoiCore::app()->lang("setup_field_tag_widget_enable");?></option>
                        <option <? if(isset($site['tag_widget_disable']) and $site['tag_widget_disable']==1) { echo 'selected';} ?> value="1"><?php echo NoiCore::app()->lang("setup_field_tag_widget_disable");?></option>
            </select></td>
    </tr>
      <tr>
        <td>short tags</td>
                <td><select name="tag_short_disable">
                        <option <? if(isset($site['tag_short_disable']) and $site['tag_short_disable']==0) { echo 'selected';} ?>  value="0"><?php echo NoiCore::app()->lang("setup_field_tag_widget_enable");?></option>
                        <option <? if(isset($site['tag_short_disable']) and $site['tag_short_disable']==1) { echo 'selected';} ?> value="1"><?php echo NoiCore::app()->lang("setup_field_tag_widget_disable");?></option>
            </select></td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_load_from_db");?> </td>
                <td><select name="load_from_db">
                        <option <? if(isset($site['load_from_db']) and $site['load_from_db']==0) { echo 'selected';} ?>  value="0"><?php echo NoiCore::app()->lang("setup_field_tag_widget_enable");?></option>
                        <option <? if(isset($site['load_from_db']) and $site['load_from_db']==1) { echo 'selected';} ?> value=1"><?php echo NoiCore::app()->lang("setup_field_tag_widget_disable");?></option>
            </select></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_themes");?></td>
                <td><select name="current_theme">
               <?
               if(isset($themes) and count($themes)>0){
               foreach($themes as $t){
               ?>
                        <option <? if($current_theme==$t) { echo 'selected'; } ?> value="<?php echo $t;?>"><?php echo $t;?></option>
               <?
               }
               }
               ?>
            </select></td>
    </tr>
      <tr>
        <td><?php echo NoiCore::app()->lang('setup_multilang');?></td>
                <td><select name="multilanguage">
                        <option <? if(isset($site['multilanguage']) and $site['multilanguage']==0) { echo 'selected';} ?> value="0"><?php echo NoiCore::app()->lang('disabled');?></option>
                        <option <? if(isset($site['multilanguage']) and $site['multilanguage']==1) { echo 'selected';} ?> value="1"><?php echo NoiCore::app()->lang('enabled');?></option>

            </select></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_type_email");?></td>
                <td><select name="type_email">
                        <option <? if(isset($site['email_conf']['type']) and $site['email_conf']['type']=="sendmail") { echo 'selected';} ?> value="sendmail">sendmail</option>
                        <option <? if(isset($site['email_conf']['type']) and $site['email_conf']['type']=="smtp") { echo 'selected';} ?> value="smtp">smtp</option>
            </select></td>
    </tr>
    <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_smtp_host");?></td>
        <td><input type="text" name="smtp_host" value="<? if(isset($site['email_conf']['host'])){ echo $site['email_conf']['host']; }?>"></td>
    </tr>
      <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_smtp_login");?></td>
        <td><input type="text" name="smtp_login" value="<? if(isset($site['email_conf']['login'])){ echo $site['email_conf']['login']; }?>"></td>
    </tr>
     <tr>
        <td><?php echo NoiCore::app()->lang("setup_field_smtp_password");?></td>
        <td><input type="text" name="smtp_password" value="<? if(isset($site['email_conf']['password'])){ echo $site['email_conf']['password']; }?>"></td>
    </tr>
    <tr>
        <td></td>
        <td><input class="btn btn-active" type="submit" name="act_save" value="<?php echo NoiCore::app()->lang("setup_button");?>"></td>
    </tr>
</table>
</form>


