<div class="row" style="height: 100%;">
		<div class="col-xs-12">&nbsp;</div>
	
        <div class="col-xs-4" style="margin-top:20%;width:25%;"></div>

      <div class="col-xs-4 return-password" style="display: block;">
			<div class="ds-block">
                      
				<h3><?=$controller->lang('change_password');?></h3>
					<form class="form-horizontal" role="form">
						<div class="form-group col-sm-12">
							<input type="text" name="restore_password" class="form-control" placeholder="<?=$controller->lang('new_password');?>" required>
						</div>
						
						<div class="form-group col-sm-12">
                                                    <input type="submit" name="act_lost_now" class="btn btn-primary btn-gold center-block" value="<?=$controller->lang('change_password');?>">
						</div
					</form>
				<div class="clearfix"></div>
			</div>
        </div>
		
		<div class="col-xs-12">&nbsp;</div>
		
		<div class="col-xs-4"></div>

        
    </div>