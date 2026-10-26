<?
use noicms\mongogrid\OneField;
?>
<?
if(NoiCore::lang()->is()){
?>
<p><a href="<?=$controller->getRoute('manage/edit/'.$form['_id']->__toString());?>">Default</a></p>
<?
foreach($languages as $lang2){
?>

<p><a href="<?=$controller->getRoute('manage/edit/'.$form['_id']->__toString());?>/<?=$lang2;?>">Language (<?=$lang2;?>)</a></p>
<?
}
}
?>
<h2><?=NoiCore::app()->lang('form_edit_s');?><?=$tittle_suffix;?></h2>
<?=NoiCore::admin()->getManageLink("/form/".$form['_id']->__toString().".html");?>
 <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?=NoiCore::app()->lang('form_edit_setup');?></a></li>
      <li role="presentation" ><a href="#home2" aria-controls="home2" role="tab" data-toggle="tab"><?=NoiCore::app()->lang('form_edit_seo');?></a></li>
    <li role="presentation"><a href="#fields" aria-controls="fields" role="tab" data-toggle="tab"><?=NoiCore::app()->lang('form_edit_fields');?></a></li>
    <li role="presentation"><a href="#html" aria-controls="html" role="tab" data-toggle="tab"><?=NoiCore::app()->lang('form_edit_html');?></a></li>
   <li role="presentation"><a href="#html2" aria-controls="html2" role="tab" data-toggle="tab"><?=NoiCore::app()->lang('form_edit_messages');?></a></li>
   <li role="presentation"><a href="#html3" aria-controls="html3" role="tab" data-toggle="tab"><?=NoiCore::app()->lang('form_edit_sender');?></a></li>
     
    

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
          <form action="<?=NoiCore::app()->getRoute('p_form/manage/edit2/'.$form['_id']->__toString()."/".$lang)?>" method="POST">
              <table class="table">
                  <tr>
                      <td><?=NoiCore::app()->lang('form_title');?></td>
                      <td><input type="text" name="title<?=$suffix_field;?>" value="<? if(isset($form['title'.$suffix_field])){ echo $form['title'.$suffix_field];}?>" ></td>
                  </tr>
                   <tr>
                      <td>Email</td>
                      <td><input type="checkbox" name="sendonemail" <? if(isset($form['sendonemail']) and $form['sendonemail']==1){ echo "checked"; }?>   value="1"><input type="email" name="sendemail" value="<? if(isset($form['sendemail'])){ echo $form['sendemail']; } ?>"></td>
                  </tr>
                  <tr>
                      <td>Captcha Security</td>
                      <td><select name="captcha">
                              <option <? if(isset($form['captcha']) and $form['captcha']==0) { echo "selected";} ?> value="0">Disable</option>
                               <option <? if(isset($form['captcha']) and $form['captcha']==1) { echo "selected";} ?> value="1">Enable</option>
                          </select>

                      </td>
                  </tr>
                  <tr>
                      <td><?=NoiCore::app()->lang('form_edit_prefix');?></td>
                      <td><input type="text" name="prefix" value="<?if(isset($form['prefix'])){ echo $form['prefix'];}?>" ></td>
                  </tr>

                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_status');?></td>
                      <td> <?
           if($form['visible']==0){
           ?>
            <a href="<?=  NoiCore::app()->getRoute('p_form/manage/change/1?id='.$form['_id']->__toString())?>"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if($form['visible']==1){
            ?>
            <a href="<?=  NoiCore::app()->getRoute('p_form/manage/change/0?id='.$form['_id']->__toString())?>"><i class="fa  fa-eye"></i></a>
            <?
            }
           ?></td>
                  </tr>
                 
                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_text_before');?></td>
                      <td><textarea class="editore" name="before<?=$suffix_field;?>" ><?if(isset($form['before'.$suffix_field])){ echo $form['before'.$suffix_field];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_text_after');?></td>
                      <td><textarea class="editore" name="after<?=$suffix_field;?>" ><?if(isset($form['after'.$suffix_field])){ echo $form['after'.$suffix_field];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_success');?></td>
                      <td><textarea class="editore" name="notify_success<?=$suffix_field;?>" ><?if(isset($form['notify_success'.$suffix_field])){ echo $form['notify_success'.$suffix_field];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_error');?></td>
                      <td><textarea class="editore" name="notify_error<?=$suffix_field;?>" ><?if(isset($form['notify_error'.$suffix_field])){ echo $form['notify_error'.$suffix_field];}?></textarea></td>
                  </tr>
                  <tr>

                      <td></td>
                      <td><input class="btn btn-success" type="submit" name="act_send" value="<?=NoiCore::app()->lang('form_edit_save');?>"></td>
                  </tr>
              </table>
          </form>
      </div>
       <div role="tabpanel" class="tab-pane" id="home2">
          <form action="<?=NoiCore::app()->getRoute('p_form/manage/edit2/'.$form['_id']->__toString()."/".$lang)?>" method="POST">
              <table class="table">

                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_mkeywords');?></td>
                      <td><textarea  name="meta_keywords<?=$suffix_field;?>" rows="3"><?if(isset($form['meta_keywords'.$suffix_field])){ echo $form['meta_keywords'.$suffix_field];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?=NoiCore::app()->lang('form_edit_mdescription');?></td>
                      <td><textarea  name="meta_description<?=$suffix_field;?>" rows="3"><?if(isset($form['meta_description'.$suffix_field])){ echo $form['meta_description'.$suffix_field];}?></textarea></td>
                  </tr>
                  <tr>

                      <td></td>
                      <td><input class="btn btn-success" type="submit" name="act_send" value="<?=NoiCore::app()->lang('form_edit_save');?>"></td>
                  </tr>
              </table>
          </form>
      </div>
    <div role="tabpanel" class="tab-pane" id="fields">
        <form action="<?=NoiCore::app()->getRoute('p_form/manage/add/'.$form['_id']->__toString())?>" method="POST">
            <table class="table">
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_name_field');?></td>
                    <td><input type="text" name="name" required="required" value=""></td>
                </tr>
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_title_field');?></td>
                    <td><input type="text" name="label" required="required" value=""></td>
                </tr>
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_type_field');?></td>
                    <td>
                     <?
                     $type=new OneField();
                     $type->init("type","type");
                    echo $type->getInput();
                     ?>
                    </td>
                </tr>
                <tr>
                 <td><?=NoiCore::app()->lang('form_edit_required');?></td>
                 <td><select name="required" required>
                         <option value="1"><?=NoiCore::app()->lang('form_edit_required_yes');?></option>
                         <option value="0"><?=NoiCore::app()->lang('form_edit_required_no');?></option>
                     </select></td>
                </tr>
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_default');?></td>
                    <td><input type="text" name="default" value=""></td>
                </tr>
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_json_opt');?></td>
                    <td><textarea name="opt" rows="3"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="btn btn-success" name="act_add"  value="<?=NoiCore::app()->lang('form_edit_add_f');?>"></td>
                </tr>
            </table> 
        </form>
        <table class="table">
          <?
          if(isset($form['fields']) and count($form['fields'])>0){
          foreach($form['fields'] as $key=>$field){
          ?>
            <tr>
                <td><?=$field['name'];?></td>
                <td><?=$field['label'];?></td>
                <td><?=$field['type'];?></td>
                <td><a href="<?=$controller->getRoute('manage/delete/'.$form['_id']->__toString()."?id=".$key)?>"><?=NoiCore::app()->lang('form_edit_delete_f');?></a></td>
            </tr>
          <?
          }
          }
          ?>
        </table>

    </div>
        <div role="tabpanel" class="tab-pane" id="html">
            <table class="table">
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_name_file');?></td>
                    <td><?=$name_file;?></td>
                </tr>
                <tr>
                    <td><?=NoiCore::app()->lang('form_edit_code_form');?></td>
                    <td><textarea rows="10"><?=$html;?></textarea></td>
                </tr>
            </table>
      </div>
      <div role="tabpanel" class="tab-pane" id="html2">
          <?

foreach($messages as $message){
?>
<div class="media">
                                <div class="pull-left">
                                    <img width="40" src="/themes/admin/noishop/assets/img/profile-pics/1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <small class="text-muted"><?=NoiCore::app()->lang('mongogrid_date');?> <?=date('Y-m-d H:i',$message['date']->sec)?></small><br>
                                    <p><a href="<?=$controller->getRoute('manage/edit/'.$message['id_form'])?>#messages"><?=$message['name'];?></a></p>
                                    <table class="table">
                                      <?
                                      foreach($message['fields'] as $field){
                                      $tmp=new OneField();
                                      $tmp->init($field['name'], $field['type']);

                                      ?>
                                        <tr>
                                            <td><?=$field['label'];?></td>
                                            <td><?=$tmp->showInput($field['value']);?>

                                            </td>
                                        </tr>
                                      <?
                                      }
                                      ?>
                                    </table>
                                      <?
           if(isset($message['visible']) and $message['visible']==0){
           ?>
            <a href="<?=  NoiCore::app()->getRoute('p_form/messages/change/1?id='.$message['_id']->__toString())?>"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if( isset($message['visible']) and $message['visible']==1){
            ?>
            <a href="<?=  NoiCore::app()->getRoute('p_form/messages/change/0?id='.$message['_id']->__toString())?>"><i class="fa  fa-eye"></i></a>
            <?
            }

           ?>
            <a href="<?=NoiCore::app()->getRoute('p_form/messages/index?path_grid_asd=/update/'.$message['_id']->__toString());?>">Редактировать</a>
                                </div>
                            </div>
<?
}
?>
      </div>
       <div role="tabpanel" class="tab-pane" id="html3">
           <form action="<?=$controller->getRoute('manage/sendemails/'.$form['_id']->__toString());?>" method="POST">
               <table class="table">
                   <tr>
                       <td><?=NoiCore::app()->lang('form_edit_sender_subject');?></td>
                       <td><input type="text" name="email_subject"></td>
                   </tr>
                    <tr>
                       <td><?=NoiCore::app()->lang('form_edit_sender_text');?></td>
                       <td><textarea class="editore2" rows="5" cols="50" name="email_text"></textarea></td>
                   </tr>
                   <tr>
                       <td></td>
                       <td><input type="submit" name="act_send" value="<?=NoiCore::app()->lang('form_edit_sender_btn');?>"></td>
                   </tr>
               </table>
           </form>
      </div>
 

  </div>

</div>
