<!--Wrapper Start-->
<div id="wrapper">
<div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Add User</h1>
            <div class="btnbox"> <?php echo anchor('admin/manageusers' , '<span class="back-icon"></span>Back to all users' , 'class="btnorange"') ?> </div>
        </div>
        <div class="clear"></div>
		<?php if($user_added == "") { ?>
        <?php 

		echo form_open('admin/adduser');?>
        <table border="0" cellspacing="0" cellpadding="0" class="tbldtl add-user">
            <tr>
                <td> Name:</td>
                <td><div class="field">
                       <input type="text" id="name" name="name" class="inputmain" value="<?php echo set_value('name'); ?>" onkeyup ="$('#name_msg').html('')" autocomplete="off" />
                    </div>
                   <span class="error" id="name_msg"> <?php echo form_error('name'); ?> </span> 
                   </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><div class="field">
                      <input type="text" id="email" name="email"class="inputmain" value="<?php echo set_value('email'); ?>" onkeyup ="$('#email_msg').html('')" />
                    </div>
                      <span class="error" id="email_msg"> <?php echo form_error('email'); ?></span>
                    </td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><div class="field">
                        <input type="text" id="user_name" name="user_name" class="inputmain" value="<?php echo set_value('user_name'); ?>" onkeyup ="$('#user_name_msg').html('')" />
                    </div>
                      <span class="error" id="user_name_msg"><?php echo form_error('user_name'); ?></span>
                    </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><div class="field">
                        <input type="password" id="password" name="password" class="inputmain" value="<?php echo set_value('password'); ?>"/>
                    </div>
                      <span class="error" id="password_msg"><?php echo form_error('password'); ?></span>
                    </td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><div class="field">
                        <input type="text" id="birth_date" name="birth_date" class="inputmain inputmain-cal" value="<?php echo set_value('birth_date'); ?>" readonly />
                        <!-- <a href="javascript:void(0);" class="cal-icon" id="cal_icon"></a> --> </div>
                        <span class="error" id="birth_date_msg">  <?php echo form_error('birth_date'); ?></span>
                        </td>
            </tr>
            <tr>
              <td>Status  </td>
              <td>
               <select name="is_active" id="is_active" class="inputmain"> 
                  <option value="1" id="active" >Active </option>
                  <option value="0" id="deactive" >De-active</option>
                </select>
              </td>
            </tr>
            
            
            <tr>
                <td>&nbsp;</td>
                <td><input type="Submit" name="add_user" id="add_user" class="btnorange" value="Add New User" />
    
					<input type="Submit" class="btngrey" value="Cancel" name="cancel" id="cancel" /></td>
            </tr>
        </table>
        <?php echo form_close(); ?>
		<?php } else {?>
		<table border="0" cellspacing="0" cellpadding="0" class="tbldtl add-user">
            <tr>
                <td> </td>
                <td><p>Congratulations! You have successfully added new user.</p>
					<br />
					<p>For adding more user  <?php echo anchor('admin/displayadduserview','click here');?></p>
				</td>
            </tr>
		</table>

		<?php }?>
    </div>
    <div class="clear"></div>
</div>
<!--Wrapper End--> 

<script>
	$(function(){ 
				$("#birth_date").datepicker({ dateFormat: 'M dd, yy',buttonImageOnly: true , showOn :'button', buttonImage:'images/cal-icon.png', changeMonth: true, changeYear: true ,minDate:'-50y', maxDate:'+0d' , showMonthAfterYear: true, showOn: "both", yearRange:'c-20'});
			});
    </script>