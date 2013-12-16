<div id="wrapper-login">
    <div class="logsignbox">
        <div class="loginmain"> <span class="orangetitle">Please select your information at inksmash.com</span>
            <div class="login">
                <div class="loginbg2"></div>
				<?php	$hidden = array('save'=>'save');  
				echo form_open('user/saveSocialRegistration','name="form" class="loginform signform" onSubmit="if(!validateSocialSignUpform()) return false;"',$hidden);?>
                    <div class="field">
                        <label for="user_name" class="infield">Username</label>
                        <input name="user_name" type="text" id="user_name" class="inputmain" value="<?php echo set_value('user_name');?>" maxlength="30"  onBlur="validateUsername('user_name');"/>
                        <span class="note">Your profile would be at inksmash.com/ username</span>  
						<span class="error" id="user_name_err"><?php echo form_error('user_name'); ?></span>
					</div>
                    <div class="field">
                        <label for="profile_name" class="infield">Profile Name</label>
                        <input name="profile_name" type="text" id="profile_name" class="inputmain" value="<?php echo set_value('profile_name');?>" maxlength="30"  onBlur="validateProfileName('profile_name');" />
						<span class="error" id="profile_name_err"><?php echo form_error('profile_name'); ?></span>
                    </div>
					<div class="field">
                        <label for="email" class="infield">Email</label>
						<input name="email" type="text" id="email" class="inputmain" value="<?php echo set_value('email');?>" readonly/>
						<span class="error" id="email_err"><?php echo form_error('email'); ?></span>
                    </div>
                   
                    <div class="captcha">
						<span id = "captcha-div">
							<?php echo $captcha['image']; ?>
							<input type="hidden" value="<?php echo md5($captcha['word']);?>" name="redirect">
						</span>
						<div class="field fieldcap">
							<label for="captcha_code" class="infield">Enter the text</label>
							<input name="captcha_code" type="text" id="captcha_code" class="inputmain" value="" onBlur="validateCaptcha('captcha_code');"/>
						</div>
						<a href="javascript:void(0);" onClick="reloadCaptcha();" class="refresh"> Refresh</a>
						<span class="error clear" id="captcha_code_err"><?php echo form_error('captcha_code'); ?></span>
                    </div>
                    <div class="cbox">
                        <input type="checkbox" name="terms" id="terms" <?php echo set_checkbox('terms', '1'); ?> value="1"/>
						I agree to the <?php echo anchor('terms-of-service','Terms of Services');?> 
						<span class="error" id="terms_err"><?php echo form_error('terms'); ?></span> 
					</div>
                    <div class="btnbox">
                        <input type="submit" class="submit-buttom" value="Join" />
                    </div>
                </form>
            </div>
        </div>
        <div class="signupmain">
            <div class="signup signnote">
                <h3>Why should you sign up ?</h3>
                <ul>
                    <li><span class="arrow">Add your content, share your expertise</span></li>
                    <li><span class="arrow">Give your thoughts, share them</span></li>
                    <li><span class="arrow">Use your choice of expression - photo, words, blogs and many more...</span></li>                    
                </ul>
            </div>
        </div>
    </div>
</div>