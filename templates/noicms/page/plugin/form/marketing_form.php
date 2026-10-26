  <section id="contact-page">
        <div class="container">
            <div class="center">
                <h2><?=$form['title'];?></h2>
             <?=$before;?>
             <?=$after;?>
            </div>
            <div class="row contact-wrap">
                <div class="status alert alert-success" style="display: none"></div>
              <form id="main-contact-form" class="contact-form row" name="contact-form" action="<?=$controller->getRoute('send/'.$form['_id']->__toString());?>"  method="POST"  enctype='multipart/form-data'>
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label>ФИО *</label>
                            <input type="text" name="field_name" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="field_email" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Телефон</label>
                            <input type="number" name="field_phone" class="form-control">
                        </div>

                    </div>
                    <div class="col-sm-5">

                         <div class="form-group">
                            <label>Имя компании</label>
                            <input type="text" name="field_company" class="form-control">
                        </div>
                         <div class="form-group">
                            <label>Примерное количество товаров</label>
                            <input type="int" name="field_items" class="form-control">
                        </div>
                          <div class="form-group">
                            <label>Тип маркетинга</label>
                            <select name="field_type_marketing" class="form-control">
                                <option value="Бинарный маркетинг">Бинарный маркетинг</option>
                                <option value="Матричный маркетинг">Матричный маркетинг</option>
                                <option value="Классический маркетинг">Классический маркетинг</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Сообщение</label>
                            <textarea name="field_message" id="message" required="required" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="act_send" class="btn btn-primary btn-lg" value="Отправить заявку">

                        </div>
                    </div>
                </form>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
