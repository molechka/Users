<div id="messages" class="tile drawer animated">
                    <div class="listview narrow">

                        <div class="overflow" id="message_container" style="height: 254px">
<?
echo $message;
?>

                        </div>
                        <div class="media text-center whiter l-100">
                            <a href="<?=NoiCore::app()->getRoute('p_form/messages/index');?>"><small><?=NoiCore::app()->lang('w_all_messages');?></small></a>
                        </div>
                    </div>
                </div>
