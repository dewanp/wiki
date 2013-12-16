<div id="container">
        <div class="headingStrip">
    <div class="right"> <div><h1>Sign Up</h1> </div>  </div>
   </div>
		 <?php	$hidden = array('save'=>'save');  
				echo form_open('user/saveRegistration','name="form"',$hidden);?>
        <table width="100%" border="0" cellspacing="0" cellpadding="8">
          <tr>
            <td align="right"><strong>Full Name</strong></td>
            <td>
				<input name="user_name" type="text" id="user_name" class="input2" value="<?php echo set_value('user_name'); ?>" maxlength="30"/>
				<span style="color:red;"><?php echo form_error('user_name'); ?></span>
			</td>
          </tr>          
          <tr>
            <td width="20%" align="right"><strong>Email</strong></td>
            <td width="80%">
				<input name="email" type="text" id="email" class="input2" value="<?php echo set_value('email'); ?>" maxlength="50"/>
				<span style="color:red;"><?php echo form_error('email'); ?></span>
			</td>
          </tr>
          <tr>
            <td align="right"><strong>Choose a Password</strong></td>
            <td width="80%">
				<input name="password" type="password" id="password" class="input2" maxlength="20"/>
				<span style="color:red;"><?php echo form_error('password'); ?></span>
			</td>
          </tr>
          <tr>
            <td width="20%" align="right"><strong>Confirm Password</strong></td>
            <td width="80%">
				<input name="confirm_password" type="password" id="confirm_password" class="input2" maxlength="20"/>
				<span style="color:red;"><?php echo form_error('confirm_password'); ?></span>
			</td>
          </tr>
		  <tr>
            <td align="right" valign="top"><b>Enter Code</b></td>
            <td valign="top">
				<span id = "captcha-div">
					<?php echo $captcha['image']; ?>
					<input type="hidden" value="<?php echo md5($captcha['word']);?>" name="redirect">
				</span>
				<a href="javascript:void(0);" onClick="reloadCaptcha();"> Refresh</a> 
			</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td>
				<input name="captcha_code" type="text" id="captcha_code" class="input2" maxlength="6"/>
				<span style="color:red;"><?php echo form_error('captcha_code'); ?></span>
			</td>
          </tr>
          <tr>
            <td width="20%" align="right">&nbsp;</td>
            <td width="80%">
				<input type="checkbox" name="terms" id="terms" <?php echo set_checkbox('terms', '1'); ?> value="1"/>
				I agree to the <?php echo anchor('#','terms of service','target="blank"');?>
				<span style="color:red;"><?php echo form_error('terms'); ?></span>
			</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td valign="bottom">
				<div class="left">
					<input type="submit" value="Sign Up" name="save" onClick="form.submit();" />
				</div>
           
				<div class="left padL5 padT5" style="margin-left:5px; padding-top:12px;">
					<span class="txt-grey">Already signed up?</span>&nbsp;&nbsp; <?php echo anchor('user/login','<b><span class="txt_15">Login here</span></b>'); ?>
				</div>
			</td>
          </tr>
        </table>
		</form>
      <div class="clear"></div>  
  </div>

