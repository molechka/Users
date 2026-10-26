<li class="dropdown <? if($current_page=="p_form"){ echo "active";} ?>">
                        <a class="sa-side2-forms2" href="">
                            <span class="menu-item"><?=NoiCore::app()->lang("main_forms");?></span>
                        </a>
                        <ul class="list-unstyled menu-item">
                          <?
                          $forms=NoiCore::app()->db()->query2(array(),"forms_category",array('visible'=>1));
                          if(count($forms)>0){
                          foreach($forms as $form){
                          ?>
                          <li><a  href="<?=NoiCore::app()->getRoute('p_form/manage/index/'.$form['_id']->__toString());?>"><?=$form['title'];?></a></li>
                          <?
                          }
                          }
                          ?>
<li><a  href="<?=NoiCore::app()->getRoute('p_form/manage/index');?>"><?=NoiCore::app()->lang("main_forms_manage");?></a></li>
<li><a  href="<?=NoiCore::app()->getRoute('p_form/category/index');?>"><?=NoiCore::app()->lang('main_forms_manage_category');?></a></li>

                        </ul>
                    </li>