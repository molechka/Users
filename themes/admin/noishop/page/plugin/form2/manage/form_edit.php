<?
use noicms\mongogrid\OneField;

?>

<h2><?php echo NoiCore::app()->lang('form_edit_s');?></h2>
<?php echo NoiCore::admin()->getManageLink("/form/".$form['_id']->__toString().".html");?>
 <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang('form_edit_setup');?></a></li>
      <li role="presentation" ><a href="#home2" aria-controls="home2" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang('form_edit_seo');?></a></li>
    <li role="presentation"><a href="#fields" aria-controls="fields" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang('form_edit_fields');?></a></li>
    <li role="presentation"><a href="#html" aria-controls="html" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang('form_edit_html');?></a></li>
   <li role="presentation"><a href="#html2" aria-controls="html2" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang('form_edit_messages');?></a></li>
   <li role="presentation"><a href="#html3" aria-controls="html3" role="tab" data-toggle="tab"><?php echo NoiCore::app()->lang('form_edit_sender');?></a></li>
     
    

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
          <form action="<?php echo NoiCore::app()->getRoute('p_form/manage/edit2/'.$form['_id']->__toString())?>" method="POST">
              <table class="table">
                  <tr>
                      <td><?php echo NoiCore::app()->lang('form_title');?></td>
                      <td><input type="text" name="title" value="<?php echo $form['title'];?>" ></td>
                  </tr>
                  <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_prefix');?></td>
                      <td><input type="text" name="prefix" value="<?if(isset($form['prefix'])){ echo $form['prefix'];}?>" ></td>
                  </tr>

                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_status');?></td>
                      <td> <?
           if($form['visible']==0){
           ?>
            <a href="<?php echo   NoiCore::app()->getRoute('p_form/manage/change/1?id='.$form['_id']->__toString())?>"><i class="fa fa-eye-slash"></i></a>
           <?
            }else if($form['visible']==1){
            ?>
            <a href="<?php echo   NoiCore::app()->getRoute('p_form/manage/change/0?id='.$form['_id']->__toString())?>"><i class="fa  fa-eye"></i></a>
            <?
            }
           ?></td>
                  </tr>
                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_text_before');?></td>
                      <td><textarea class="editore" name="before" ><?if(isset($form['before'])){ echo $form['before'];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_text_after');?></td>
                      <td><textarea class="editore" name="after" ><?if(isset($form['after'])){ echo $form['after'];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_success');?></td>
                      <td><textarea class="editore" name="notify_success" ><?if(isset($form['notify_success'])){ echo $form['notify_success'];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_error');?></td>
                      <td><textarea class="editore" name="notify_error" ><?if(isset($form['notify_error'])){ echo $form['notify_error'];}?></textarea></td>
                  </tr>
                  <tr>

                      <td></td>
                      <td><input class="btn btn-success" type="submit" name="act_send" value="<?php echo NoiCore::app()->lang('form_edit_save');?>"></td>
                  </tr>
              </table>
          </form>
      </div>
       <div role="tabpanel" class="tab-pane" id="home2">
          <form action="<?php echo NoiCore::app()->getRoute('p_form/manage/edit2/'.$form['_id']->__toString())?>" method="POST">
              <table class="table">

                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_mkeywords');?></td>
                      <td><textarea  name="meta_keywords" rows="3"><?if(isset($form['meta_keywords'])){ echo $form['meta_keywords'];}?></textarea></td>
                  </tr>
                   <tr>
                      <td><?php echo NoiCore::app()->lang('form_edit_mdescription');?></td>
                      <td><textarea  name="meta_description" rows="3"><?if(isset($form['meta_description'])){ echo $form['meta_description'];}?></textarea></td>
                  </tr>
                  <tr>

                      <td></td>
                      <td><input class="btn btn-success" type="submit" name="act_send" value="<?php echo NoiCore::app()->lang('form_edit_save');?>"></td>
                  </tr>
              </table>
          </form>
      </div>
    <div role="tabpanel" class="tab-pane" id="fields">
        <form action="<?php echo NoiCore::app()->getRoute('p_form/manage/add/'.$form['_id']->__toString())?>" method="POST">
            <table class="table">
                <tr>
                    <td><?php echo NoiCore::app()->lang('form_edit_name_field');?></td>
                    <td><input type="text" name="name" required="required" value=""></td>
                </tr>
                <tr>
                    <td><?php echo NoiCore::app()->lang('form_edit_title_field');?></td>
                    <td><input type="text" name="label" required="required" value=""></td>
                </tr>
                <tr>
                    <td><?php echo NoiCore::app()->lang('form_edit_type_field');?></td>
                    <td>
                     <?
                     $type=new OneField();
                   
                     $type->init("type","type");
                    echo $type->getInput();
                     ?>
                    </td>
                </tr>
                <tr>
                 <td><?php echo NoiCore::app()->lang('form_edit_required');?></td>
                 <td><select name="required" required>
                         <option value="1"><?php echo NoiCore::app()->lang('form_edit_required_yes');?></option>
                         <option value="0"><?php echo NoiCore::app()->lang('form_edit_required_no');?></option>
                     </select></td>
                </tr>
                <tr>
                    <td><?php echo NoiCore::app()->lang('form_edit_default');?></td>
                    <td><input type="text" name="default" value=""></td>
                </tr>
                <tr>
                    <td><?php echo NoiCore::app()->lang('form_edit_json_opt');?></td>
                    <td><textarea name="opt" rows="3"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" class="btn btn-success" name="act_add"  value="<?php echo NoiCore::app()->lang('form_edit_add_f');?>"></td>
                </tr>
            </table> 
        </form>
        <table class="table">
          <?
          if(isset($form['fields']) and count($form['fields'])>0){
          foreach($form['fields'] as $key=>$field){
          ?>
            <tr>
                <td><?php echo $field['name'];?></td>
                <td><?php echo $field['label'];?></td>
                <td><?php echo $field['type'];?></td>
                <td><a href="<?php echo $controller->getRoute('manage/delete/'.$form['_id']->__toString()."?id=".$key)?>"><?php echo NoiCore::app()->lang('form_edit_delete_f');?></a></td>
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
                    <td><?php echo NoiCore::app()->lang('form_edit_name_file');?></td>
                    <td><?php echo $name_file;?></td>
                </tr>
                <tr>
                    <td><?php echo NoiCore::app()->lang('form_edit_code_form');?></td>
                    <td><textarea rows="10"><?php echo $html;?></textarea></td>
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
                                    <small class="text-muted"><?php echo NoiCore::app()->lang('mongogrid_date');?> <?php echo date('Y-m-d H:i',$message['date']->sec)?></small><br>
                                    <p><a href="<?php echo $controller->getRoute('manage/edit/'.$message['id_form'])?>#messages"><?php echo $message['name'];?></a></p>
                                    <table class="table">
                                      <?
                                      foreach($message['fields'] as $field){
                                      $tmp=new OneField();
                                      $tmp->init($field['name'], $field['type']);

                                      ?>
                                        <tr>
                                            <td><?php echo $field['label'];?></td>
                                            <td><?php echo $tmp->showInput($field['value']);?>

                                            </td>
                                        </tr>
                                      <?
                                      }
                                      ?>
                                    </table>
                                </div>
                            </div>
<?
}
?>
      </div>
       <div role="tabpanel" class="tab-pane" id="html3">
           <form action="<?php echo $controller->getRoute('manage/sendemails/'.$form['_id']->__toString());?>" method="POST">
               <table class="table">
                   <tr>
                       <td><?php echo NoiCore::app()->lang('form_edit_sender_subject');?></td>
                       <td><input type="text" name="email_subject"></td>
                   </tr>
                    <tr>
                       <td><?php echo NoiCore::app()->lang('form_edit_sender_text');?></td>
                       <td><textarea class="editore" name="email_text"></textarea></td>
                   </tr>
                   <tr>
                       <td></td>
                       <td><input type="submit" name="act_send" value="<?php echo NoiCore::app()->lang('form_edit_sender_btn');?>"></td>
                   </tr>
               </table>
           </form>
      </div>
 

  </div>

</div>
