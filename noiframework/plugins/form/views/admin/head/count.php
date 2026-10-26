 <div class="pull-left tm-icon">
                        <a data-drawer="messages" class="drawer-toggle" href="">
                            <i class="sa-top-message"></i>
                            <i class="n-count animated"><?=NoiCore::app()->db()->count("plugin_form_messages",array('date'=>array('$gt'=>new MongoDate(strtotime($prev_day)))))?></i>
                            <span><?=NoiCore::app()->lang("h_messages");?></span>
                        </a>
                    </div>
