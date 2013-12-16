<!-- this page is for login -->
<script type="text/javascript" src="javascript/fisheye-iutil.js"></script>
<script type="text/javascript">
$(document).ready(function(){setFishEye();})
function setFishEye() { 
	// Dock initialize
	$('#dock').Fisheye(
		{
			maxWidth: 30,
			items: 'a',
			itemsText: 'span',
			container: '.dock-container',
			itemWidth: 50,
			proximity: 60,
			alignment : 'left',
			valign: 'bottom',
			halign : 'left'
		}
	);
}
</script>

<div id="wrapper-login">
	<div class="logsignbox">
     <div class="loginmain">
     <h2>Login</h2>
     <div class="login">
     <div class="loginbg"></div>
	 <form class="loginform" onSubmit="ajaxLogin('login_user_name','login_password','login_remember');return false;">
     <div class="field">
		<label for="login_user_name" class="infield" id="login_user_name_label">Username</label>
		<input name="login_user_name" type="text" id="login_user_name" class="inputmain" value="<?php echo set_value('user_name'); ?>" onBlur="validateUsername('login_user_name');"/>
		<span class="error" id="login_user_name_err"><?php echo form_error('login_user_name'); ?></span>
     </div>
     <div class="field">
        <label for="login_password" class="infield" id="login_password_label">Password</label>
		<input name="login_password" type="password" id="login_password" class="inputmain" value=""  onBlur="validatePassword('login_password');"/>
        <span class="error" id="login_password_err"><?php echo form_error('login_password'); ?></span>
     </div>
     <div class="cbox"><input type="checkbox"  id="login_remember"/>Remember me</div>
     <div class="btnbox">
		<input type="submit" class="submit-buttom" value="Login" />
		<?php echo anchor('user/forgotPassword', 'Forgot Password?'); ?>
		&nbsp;&nbsp;		
        <?php echo anchor('user/forgotUsername', 'Forgot Username?'); ?>
     </div>
     </form>
      
     <!--<div id="dock">
            <div class="dock-container">
              <div class="dock-contaner-left"></div>
              <div class="addthis_toolbox">
                <div class="custom_images">
				
                <a href="javascript:void(0);" title="Login using Facebook" class="addthis_button_facebook fb-button" id="fb-auth"><span style="display: none;">Facebook</span><img src="images/aquaticus_facebook.png" alt="Login using Facebook" /></a>
				</div>
                <div class="atclear"></div>
              </div>
            </div>
          </div>-->
     </div>
     </div>
     <!--<div class="signupmain">
     <h2>Sign up for free</h2>
     <div class="signup">
	 <?php	$hidden = array('save'=>'save');  
			echo form_open('user/saveRegistration','name="form" class="loginform signform" onSubmit="if(!validateSignUpform())return false;"',$hidden);?>
     <div class="field">
        <label for="user_name" class="infield">Username</label>
		<input name="user_name" type="text" id="user_name" class="inputmain" value="<?php echo set_value('user_name');?>" maxlength="30"  onBlur="validateUsername('user_name');" autocomplete="off"/>
        <span class="note">Your profile would be at inksmash.com/username</span>
        <span class="error" id="user_name_err"><?php echo form_error('user_name'); ?></span>
     </div>
     <div class="field">
        <label for="email" class="infield">Email</label>
		<input name="email" type="text" id="email" class="inputmain" value="<?php echo set_value('email'); ?>" maxlength="50" onBlur="validateEmail('email');" autocomplete="off"/>
        <span class="error" id="email_err"><?php echo form_error('email'); ?></span>
     </div>
     <div class="field">
        <label for="password" class="infield">Password</label>
        <input name="password" type="password" id="password" class="inputmain" maxlength="20" onBlur="validatePassword('password');" autocomplete="off"/>
        <span class="error" id="password_err"><?php echo form_error('password'); ?></span>
     </div>
	 <div class="field">
		 <label for="confirm_password" class="infield">Confirm Password</label>
		 <input name="confirm_password" type="password" id="confirm_password" class="inputmain" value="" maxlength="20"  onBlur="validateConfirmPassword('password','confirm_password');" autocomplete="off"/>
		 <span class="error" id="confirm_password_err"><?php echo form_error('confirm_password'); ?></span>
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
         <div class="btnbox"><input type="submit" class="submit-buttom" value="Join" />
         </div>
     </form>
     </div>
     </div>-->
     </div>
</div>

<script>
if ($('#terms').attr('checked'))
{ 
	$('#terms').parent().removeClass('cbox').addClass('cbox-selected');
}
</script>
