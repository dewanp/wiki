<div id="wrapper-login" style="min-height:600px;">
    <div class="logsignbox">
        
		<div class="loginmain forgot-pass">
		
            <h2>Reset Password</h2>
			<?php if(isset($msg))
			{
				echo '<div style="color:green;margin-top:15px;">'.$msg.'</div>';
			}?>
            <div class="login">
                
				<?php 
				
				echo form_open('user/saveResetPassword/','name="form_change_password" onSubmit="" class="loginform"');
				
				if(!$token)
				{
				?>
					<div class="field">
                        <label for="cur_password" class="infield">New Password</label>
                        <input name="cur_password" type="password" id="cur_password" class="inputmain" value="" />
                        <span class="error"><?php echo form_error('cur_password'); ?></span> 
					</div>
				<?php
				}
				else
				{
				?>
					<input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
				<?php
				}
				?>
                    <div class="field">
                        <label for="new_password" class="infield">New Password</label>
                        <input name="new_password" type="password" id="new_password" class="inputmain" value="" />
                        <span class="error"><?php echo form_error('new_password'); ?></span> 
					</div>
                    <div class="field">
                        <label for="confirm_password" class="infield">Confirm Password</label>
                        <input name="confirm_password" type="password" id="confirm_password" class="inputmain" value="" />
                        <span class="error"><?php echo form_error('confirm_password'); ?></span> 
					</div>
                    <div class="btnbox" style="margin-bottom:25px;">
                        <input type="submit" name="button" id="button" value="Save" class="submit-buttom" />
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
