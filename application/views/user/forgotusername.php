<div id="wrapper-login">
    <div class="logsignbox">
        <div class="loginmain forgot-pass">
            <h2>Forgot Username</h2>
            <div class="login">
                <div class="loginbg"></div>
                <?php echo form_open('user/sendforgotUsernameEmail/','name="username" class="loginform"');?>
                    <div class="field">
                        <label for="email" class="infield">Please enter your email</label>
                        <input name="email" type="text" id="email" class="inputmain" value="" />
                        <span class="error"><?php echo form_error('email'); ?></span>
					</div>
                    <div class="btnbox">
						<input type="submit" name="button" id="button" value="Send" class="submit-buttom" />
					</div>
					<div class="clear"></div>
					<?php if(isset($link_sent)) echo '<span style="color:green;">'.$link_sent.'</span>';?>
                </form>
            </div>
        </div>
    </div>
</div>
