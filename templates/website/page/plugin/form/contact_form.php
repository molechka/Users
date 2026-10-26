<?
NoiCore::app()->setParam("ismap",true);
?>
<section class="pagebg banner">
			<div class="page-header-top"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?=$before;?>
					 
						<ol class="breadcrumb">
						  <li><a href="/">Главная</a></li>
						  <li class="active"><?=$form['title'];?></li>
						</ol>
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>

<section class="section white">
			<div class="pagebefore"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12 section-title text-center">
						<?=$after;?>
					</div><!-- end col -->
				</div><!-- end row -->

				<div id="sitewrapper" class="row">
					<div id="content" class="col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<form class="form-horizontal standardform row contactform" role="form"  action='<?=$controller->getRoute('ajax/'.$form['_id']->__toString());?>'>
				                    <div class="form-group">
				                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="name" name="field_first" placeholder="Имя" required="">
				                        </div>
				                        <div class="col-sm-6">
				                            <input type="text" class="form-control" id="lastname" name="field_surname" placeholder="Фамилия">
				                        </div>
				                    </div>
				                    <div class="form-group">
				                        <div class="col-sm-6">
				                            <input type="email" class="form-control" id="email" name="field_email" placeholder="Email">
				                        </div>
				                        <div class="col-sm-6">
				                            <input type="text" class="form-control" id="confirmemail" name="field_phone" placeholder="Телефон">
				                        </div>
				                    </div>

				                    <div class="form-group">
				                        <div class="col-sm-12">
				                            <textarea class="form-control" name='field_message' placeholder="Сообщение"></textarea>
				                        </div>
				                    </div>
                                                 <div class="form-group notifyc" style="display:none;">
				                       
				                    </div>
				                    <div class="form-group">
				                        <div class="col-sm-12">
                                                            
				                            <a href="#" class="sendnow btn btn-primary btn-block">Отправить сейчас</a>
				                        </div>
				                    </div>
				                </form>			
							</div>

							<div class="col-md-6">
								<div id="map"></div>
							</div>

						</div><!-- end row -->
					</div><!-- end col -->
				</div><!-- end row -->
			</div><!-- end container -->
		</section>