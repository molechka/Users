
        <form   action="" method="post" class="register-form">
            <h2><?php echo NoiCore::app()->lang("login_title");?></h2>
            <table class="table">
                <tr>
                    <td><?php echo NoiCore::app()->lang("login_title_username");?></td>
                    <td> <i class="icon-user"></i>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/></td>
                </tr>
                <tr>
                    <td><?php echo NoiCore::app()->lang("login_title_password");?></td>
                    <td> <i class="icon-lock"></i><input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button name="act_login" type="submit" id="register-submit-btn" class="btn green pull-right" value="<?php echo NoiCore::app()->lang("login_button");?>">
                <?php echo NoiCore::app()->lang("login_button");?> <i class="m-icon-swapright m-icon-white"></i>
                </button></td>
                </tr>
            </table>
        </form>



 

</form>

        