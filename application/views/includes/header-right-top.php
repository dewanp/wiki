<?php if($this->commonmodel->isLoggedIn()){?>
	<div class="user-login" id="user-login">
		<ul>
			<li>
				<div id="header-user-image">
					<script> showImage('<?php echo $this->session->userdata("picture");?>','30','30','header-user-image');</script>
				</div>
				<a href="javascript:void(0);" onclick="$('#loginbox2').toggle();"><?php echo $this->session->userdata("profile_name");?></a>
			</li>
		</ul>
	   <div class="loginbox" id="loginbox2" style="display:none;">
	   <ul>
	   <li><?php echo anchor('user/myprofile','<span class="account"></span>My Account')?></li>
	   <!--<li><?php echo anchor('post/mypost','<span class="unpublish"></span>Content')?></li>-->
	   <li><?php echo anchor('user/logout','<span class="logout"></span>Logout','id="logout"')?></li>
	   </ul>
	   </div> 
	</div>
	<div class="serach-box">
		<form action="<?php echo site_url('search')?>" method="post">
			<div class="field">
				<label for="header-keyword" class="infield">Search for Posts</label>
				<input name="keyword" type="text" id="header-keyword" value="<?php echo $this->input->post('keyword','')?>" />
			</div>
			<input type="submit" value="" />
		</form>
	</div>
<?php }else{?>
	<div class="signinbox">
		<div class="loginbtn"><?php echo anchor('user/login','Login','class="txtlogin"')?> <a href="javascript:void(0);" class="sep arrowclick"> <img src="images/login-arrow.png" alt="" class="arrow" /></a> </div>

			
		<div class="loginpop"> <img src="images/login-tip.png" alt="" class="logintip"/>
			<div class="logininner">
				<form onSubmit="ajaxLogin('loginpop_username','loginpop_password','loginpop_remember');return false;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top"><div class="field email">
								<label for="loginpop_username" class="infield" id="loginpop_username_label">Username</label>
								<input name="loginpop_username" id="loginpop_username" type="text" class="inputmain" value="" onBlur="validateUsername('loginpop_username');" autocomplete="off"/>
								<span style="height:13px; padding-top:3px; display:block"><span class="error" id="loginpop_username_err"></span></span> </div></td>
						<td valign="top"><div class="field">
								<label for="loginpop_password" class="infield" id="loginpop_username_password">Password</label>
								<input type="password" name="loginpop_password" id="loginpop_password" class="inputmain" value=""  onBlur="validatePassword('loginpop_password');" autocomplete="off"/>
								<span style="height:13px; padding-top:3px; display:block"> <span class="error" id="loginpop_password_err"></span></span> </div></td>
					</tr>        
				</table>
				
				<div class="remem">
					<div class="cbox" style="color:#C3C4C6;">
						<input type="checkbox" id="loginpop_remember"/>
						Remember me
					</div>
                    <div class="clear"></div>
				</div>
                <div class="remem">
                    <?php echo anchor('user/forgotPassword', 'Forgot Password?','class="forgot"'); ?>
                    <?php echo anchor('user/forgotUsername', 'Forgot Username?','class="forgot"'); ?>
					<input name="" type="submit" value="Login" class="submit-black"/>
                </div>
				</form>
			</div>
			<!--<div id="popupdock">
				<div class="dock-container">
					<div class="dock-contaner-left"></div>
					<div class="addthis_toolbox">
						<div class="custom_images"> 
						<a href="javascript:void(0);" title="Login using Facebook"  class="addthis_button_facebook tooltip" id="fb-auth-top"><img src="images/aquaticus_facebook-sm.png" alt="Login using Facebook" /></a>
						</div>
						<div class="atclear"></div>
					</div>
				</div>
			</div>-->
		</div>
	</div>
<?php }?>