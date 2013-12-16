<!--Wrapper	Start-->


<div id="wrapper">
		<div class="container">
		
			<div class="j-loginbox ">
			<span class="loginbg"></span>
		<?php    $data = array("onsubmit"=>"return validateLoginForm()", "name" => "Login");
		echo form_open('admin/login',$data); 	
		
		?>
		
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="j-logintbl">
						<tr>
							<td><span class ="error" id="main_error_msg"> <?php echo validation_errors(); ?> </span> </td>
						</tr>
						<tr>
							<td><span class="head">Username</span></td>
						</tr>
						<tr>
								<td><div class="field">
									<input type ="text" id="adminname" name="adminname" class="inputmain" onkeyup="$('#msg_username').html('');$('#main_error_msg').html('');" value ="<?php echo set_value('adminname');?>"/>
								<span id="msg_username" class ="error"> </span>

								</div></td>
						</tr>
 					    <tr>
								<td><span class="head">Password</span></td>
						</tr>
						<tr>
									<td><div class="field">
										<input type ="password" id="adminpassword" name="adminpassword" class="inputmain" onkeyup="$('#msg_password').html(''); $('#main_error_msg').html('');" value ="<?php  echo set_value('adminpassword');?>"/>
							
								<span id="msg_password" class="error"> </span>
									</div></td>
						</tr>
						<tr>
									<td><input type="Submit" class="btnorange" value="Login"   /></td>
						</tr>
					</table>
				
					<?php echo form_close(); ?>
			</div>
		</div>
</div> 


<!--Wrapper	End--> 