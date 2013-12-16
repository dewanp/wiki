<!--Wrapper	Start-->

<div id="wrapper">
<div class="breadcrumb"></div>
    <div class="container">
        <div class="j-loginbox">
		<?php if($success_message == ""){ ?>

			<?php   echo form_open('home/changepassword');?>
            <table cellpadding="0" cellspacing="0" border="0" width="100%" class="j-logintbl">
                <tr>
                    <td><span class="head"> Old Password</span></td>
                </tr>
                <tr>
                    <td><div class="field">
                            <input type ="password" id="old_password" name="old_password" class="inputmain" onkeyup="$('#old_password_msg').html('');" value="<?php echo set_value('old_password'); ?>" />
                        <span class="error" id="old_password_msg">   <?php echo form_error('old_password'); ?></span>    
						</div>						
                    </td>
                </tr>
				
				<tr>
                    <td><span class="head"> New Password</span></td>
                </tr>
                <tr>
                    <td><div class="field">
                            <input type ="password" id="new_password" name="new_password" class="inputmain" onkeyup="$('#new_password_msg').html('');" value="<?php echo set_value('new_password'); ?>"/>
                        <span class="error" id="new_password_msg">   <?php echo form_error('new_password'); ?></span>    
						</div>						
                    </td>
                </tr>
                
                <tr>
                    <td><span class="head"> Comfirm Password</span></td>
                </tr>
                <tr>
                    <td><div class="field">
                            <input type ="password" id="confirm_password" name="confirm_password" class="inputmain" onkeyup="$('#confirm_password_msg').html('');" value="<?php echo set_value('confirm_password'); ?>" />
                        <span class="error" id="confirm_password_msg"><?php echo form_error('confirm_password'); ?></span>
						</div>						
                    </td>
                </tr>
                <tr align="center">
                    <td><input type="Submit" class="btnorange" value="Change Password"   /></td>
                </tr>
            </table>
            <?php echo form_close(); ?> 
			<?php }else { ?>
				<div style="color: green; font-size: medium; margin: 30px;" > <?php echo $success_message; ?> </div>
			<?php }?>

			</div>
    </div>
</div>

<!--Wrapper	End--> 