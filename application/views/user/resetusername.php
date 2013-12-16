<div id="wrapper-login" style="min-height:600px;">
    <div class="logsignbox">
        
		<div class="loginmain forgot-pass">
		
            <h2>Reset Username</h2>
			<?php if(isset($msg))
			{
				echo '<div style="color:green;margin-top:15px;">'.$msg.'</div>';
			}?>
            <div class="login">
                
				<?php 
				
				echo form_open('user/saveResetUsername/','name="form_change_username" class="loginform"');
				
				if(!$token)
				{
				?>
					<div class="field">
                        <label for="new_username" class="infield">New Username</label>
                        <input name="new_username" type="text" id="cur_password" class="inputmain" value="" />
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
                        <label for="new_username" class="infield">New Username</label>
                        <input name="new_username" type="text" id="new_username" class="inputmain" value="" />
                        <span class="error"><?php echo form_error('new_username'); ?></span> 
					</div>
                   
                    <div class="btnbox" style="margin-bottom:25px;">
                        <input type="submit" name="button" id="button" value="Save" class="submit-buttom" />
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
