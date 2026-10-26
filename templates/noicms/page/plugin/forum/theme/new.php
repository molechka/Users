 <ol class="breadcrumb">
  <li><a href="/">Главная</a></li>
  <li><a href="<?=$controller->getRoute('index');?>">Форум</a></li>
    <li><a href="<?=$controller->getRoute('category/'.$category['last_id']);?>"><?=$category['title'];?></a></li>
  <li class="active">Создать тему</li>
</ol>
<section id="about-us">

        <div class="container"><div id="contact-page clearfix">

                            <div class="message_heading">
                             <h2>Новая тема в категории <?=$category['title'];?></h2>
                                <p></p>
                            </div>

                        <form action="<?=$controller->getRoute('theme/docreate/'.$category['last_id']);?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-5">
                                       <img src="<?=$controller->user()->getLogged("avatar");?>">
                                    </div>
                                    <div class="col-sm-7">
                                     <div class="form-group">
                                         <label>Название темы</label>>
       <input type="text" name="theme_name" class="form-control" required value="">

    </div>
                                        <div class="form-group">
                                            <label>Сообщение</label>
                                            <textarea name="message" id="message" required="required" class="form-control" rows="8"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="create_theme" value="Добавить сообщение">
                                            <button type="submit" class="btn btn-primary btn-lg" required="required">Создать тему</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--/#contact-page-->




 

        </div></section>