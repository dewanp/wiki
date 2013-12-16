<div id="wrapper">
    	<div class="left-content-main">
        	<?php echo $sidebar;?>
        </div> 
        <div class="rightmain">
        <div class="breadcrumb">
          <span class="arrowleft"></span>
          <ul>
          <li><?php echo anchor('user/feeds','Home'); ?></li>
          <li><a href="javascript:void(0);" class="active">My Account</a></li>
          </ul>
          </div>
          <div class="rightinner">
          <!--Account Section Start -->
          	<div class="account-sec-tab">
            	<div class="account-info-tab">
                <div class="float  ">
                    <span class="back"><span class="unlimited"></span></span>
                    <span class="mid"><?php echo anchor('user/myprofile','Account Information');?></span>
                    <span class="front"></span>
                </div>
                <div class="float">
                    <span class="back"></span>
                    <span class="mid">
					<!--<a href="javascript:void(0);">My Earnings Account</a>-->
					<?php echo anchor('user/earningacc','My Earning Account'); ?>
					</span>
                    <span class="front"></span>
                </div>
                <div class="float">
                    <span class="back"></span>
                    <span class="mid">
					<?php echo anchor('user/myaccsetting','My Setting'); ?></span>
                    <span class="front"></span>
                </div>
                <div class="float active">
                    <span class="back"></span>
                    <span class="mid">
					<?php echo anchor('user/showChangePassword','Change Password'); ?></span>
                    <span class="front"></span>
                </div>
    			</div>
            </div>
           <form name="account-setting" id="account-setting">
            <div class="account-info-block">
                <div class="imp-userinfo-main-block">
                <div class="important-user-info">
                    	<div class="user-info-title"><h2 class="title">Important User Information</h2></div>
                        <div class="user-information">
						<?php 
						if(isset($msg))
						{
							echo '<span style="color:green;">'.$msg.'</span>';
						}
						echo form_open('user/changepassword/','name="form_change_password" onSubmit=""');
						?>
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="20%">Current Password</td>
                                <td width="30%">
                                	<div class="field">
                                        <label for="cur_password" class="infield">Current Password</label>
                                        <input type="password" name="cur_password" id="cur_password" class="inputmain" value="" onkeyup ="$('#cur_password_msg').html('');"/>
										<span class="error" id="cur_password_msg"><?php echo form_error('cur_password'); ?></span>
                                    </div>
                                 </td>
                                <td width="50%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Password</td>
                                <td>
                                	<div class="field">
                                        <label for="new_password" class="infield">Select new password</label>
                                        <input type="password" name="new_password" id="new_password" class="inputmain new_password" value="" onkeyup ="$('#new_password_msg').html('');"/>
                                    </div><br />
                                    <span class="pwd-ch"><!--*Should be atleast 6 characters--></span>
									<span class="error" id="new_password_msg"><?php echo form_error('new_password'); ?></span>
                                   </td>
                                <td><div class="pwd-info"><!-- <img src="images/pwd-info.png" alt="" /> --></div></td>
                              </tr>
                              <tr>
                                <td>Retype Password</td>
                                <td>
                                	<div class="field">
                                        <label for="confirm_password" class="infield">Retype new password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="inputmain " value="" onkeyup ="$('#confirm_password_msg').html('');"/>
										<span class="error" id= "confirm_password_msg"><?php echo form_error('confirm_password'); ?></span>
                                    </div>
                                   </td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
							<input type="submit" value="Change Password" class="btnorange right" style="margin:12px 0;">
						</form>
                        </div>
                </div>
                <div class="user-login-info">
                 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="18%" class="gray-clr">Last Login</td>
                        <td width="44%">:  <?php echo date('M j, Y, g:i a T',$this->session->userdata("last_visit"));?></td>
                        <td width="21%" class="gray-clr">Login IP:</td>
                        <td width="17%">:  <?php echo $this->session->userdata("last_visit_ip");?></td>
                      </tr>
                    </table>
                 </div>
                </div>
            </div>
            </form>
            <!--Account Section End -->
          </div>
          </div>
        <div class="clear"></div>
    </div>