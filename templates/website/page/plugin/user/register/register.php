<div class="row" style="height: 100%;">
		<div class="col-xs-12">&nbsp;</div>
	
        <div class="col-xs-3 incorrect" data-incorrect="<?=$controller->lang('incorrect');?>"></div>

        <div class="col-xs-6">
			<div class="ds-block">
				<h3><?=$controller->lang('register');?></h3>
					<form class="form-horizontal" role="form" method="POST">
					  <?
                                if(isset($iserror) and $iserror==1){
                                ?>
                                <div class="alert alert-danger">
                                    <p><?=$_POST['error_key'];?> <?=$_POST['error_message'];?></p>    
                                </div>
                                <?
                                }
                                ?>	
                                            <div class="form-group col-sm-12">
                                                 
                                                        <input type="text" pattern=".{0}|.{5,15}"   required title="<?=$controller->lang('login_error');?>" class="form-control check logincheck" name="login" id="login" value='<? if(isset($_POST['login'])) { echo $_POST['login'];}?>' placeholder="<?=$controller->lang('field_login');?>" required>
						   <p class="alert alert-danger notify_login" style="display:none;"></p>
                                                </div>

						<div class="form-group col-sm-12">
							<input type="email" class="form-control check" id="email" name="email" placeholder="Email" value='<? if(isset($_POST['email'])) { echo $_POST['email'];}?>' required>
                                                         <p class="alert alert-danger notify_email" style="display:none;"></p>
						</div>
						
						<div class="form-group col-sm-12">
							<input type="text" class="form-control " id="name" name="name" placeholder="<?=$controller->lang('field_name');?>" value='<? if(isset($_POST['name'])) { echo $_POST['name'];}?>' required>
                                                         <p class="alert alert-danger notify_name" style="display:none;"></p>
						</div>
						
						<div class="form-group col-sm-12">
							<input type="text" class="form-control check" id="surname" name="surname" value='<? if(isset($_POST['surname'])) { echo $_POST['surname'];}?>' placeholder="<?=$controller->lang('field_surname');?>" required>
                                                         <p class="alert alert-danger notify_surname" style="display:none;"></p>
						</div>
						
						<div class="form-group col-sm-12">
							<input type="password" class="form-control check " id="password" name="password"  placeholder="<?=$controller->lang('field_password');?>" required>
						</div>
						
						<div class="form-group col-sm-12">
							<input type="password" class="form-control check"  id="password_2" name="password_2" placeholder="<?=$controller->lang('field_password2');?>" required>
                                                       <p class="alert alert-danger notify_password" style="display:none;"></p> 
						</div>
						<?
                                                if($iscaptcha==true){
                                                ?>
						<div class="form-group col-sm-12">
					 
										<label for="verify">		
											<img src="data:image/jpg;base64,<?=base64_encode($captcha );?>" alt="Image verification"/>
										</label>
										<input class="required form-control check"  id="captcha" name="noicms_captcha" type="text" placeholder="<?=$controller->lang('field_captcha');?>">
										 <p class="alert alert-danger notify_captcha" style="display:none;"></p>
                                                                                <div class="form-line"></div>
									 
						</div>
                                            <?
                                                }
                                            ?>
                                            <div class="form-group col-sm-12">
                                                <p><?=$controller->lang('your_sponsor');?> <?=$_GET['id'];?></p>
						</div>
						<div class="form-group col-sm-12">
                                                    <input type="hidden" name="referal" value="<?=$_GET['id'];?>">
							<input type="submit" name="act_register_now" value="<?=$controller->lang('btn_reg');?>" class="btn btn-primary btn-gold center-block">
                                                           <br>
						</div>
                                         
					</form>
				<div class="clearfix"></div>
			</div>
        </div>
    </div>