<div class="row" style="height: 100%;">
	 
	
        <div class="col-xs-4" style=""></div>

        <div class="col-xs-4" style="width:50%; ">
			<div class="ds-block" style="height: 100%;padding: 55px;">
				<h3><?=$controller->lang('login_title');?></h3>
<?
if(NoiCore::app()->getParam("user_plugin_login_err")===1){
?>
                                <div class="alert alert-danger"><p>логин или пароль неверный!</p></div>                               
<?                                
}

?>
					<form class="form-horizontal" action="<?=$controller->getRoute('login/index')?>" method="POST" role="form">
						<div class="form-group col-sm-12">
							<input type="text" class="form-control" name="login" placeholder="<?=$controller->lang('field_login');?>" required>
						</div>

						<div class="form-group col-sm-12">
							<input type="password" class="form-control" name="password" placeholder="<?=$controller->lang('field_password');?>" required>
						</div>
						
						<div class="form-group col-sm-12">
							<div style="display:inline-block">
								 
								<a href="/user/lost/index.html"  style="font-size:13px;"><?=$controller->lang('login_btn_lost');?></a>
							</div>
							<button type="submit" class="btn btn-primary btn-gold pull-right"><?=$controller->lang('login_btn');?></button>
                                                      
                                                </div>
					</form>
				<div class="clearfix"></div>
			</div>
        </div>
		
		<div class="col-xs-12">&nbsp;</div>
		
		<div class="col-xs-4"></div>

       
    </div>