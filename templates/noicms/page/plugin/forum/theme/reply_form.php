<div id="contact-page clearfix">
                            <div class="status alert alert-success" style="display: none"></div>
                            <div class="message_heading">
                                <h4>Оставить сообщение</h4>
                                <p></p>
                            </div>

                           <form action="<?=$controller->getRoute('post/new/'.$theme['last_id']);?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-5">
                                       <img src="<?=$controller->user()->getLogged("avatar");?>">
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <label>Сообщение</label>
                                            <textarea name="message" id="message" required="required" class="form-control" rows="8"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="add_reply" value="Добавить сообщение">
                                            <button type="submit" class="btn btn-primary btn-lg" required="required">Оставить сообщение</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--/#contact-page-->
 

