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
                            <label>Name *</label>
                            <input type="text" name="field_name" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="field_email" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" name="field_phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Company name</label>
                            <input type="text" name="field_name_company" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                         <label>About company</label>
                            <textarea name="field_text_about" id="message" required="required" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Provided services</label>
                            <textarea name="field_text_services" id="message" required="required" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="act_send" class="btn btn-primary btn-lg" value="Send request">

                        </div>
                    </div>
                </form>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
