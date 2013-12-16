<!-- 
	View file for user status. used in user detail page in admin section. This file is included in manage-users-view-details.php file
-->				
					
					<table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                    
					<tr id="loading-status" style="display:none;">
						<td style="background: #FFFFFF;text-align:center;" colspan="2"><img src="images/loader.gif"></td>
					</tr>
				<?php if(isset($message)){ ?>
					<script>setTimeout(function(){ $("#status-msg").hide();	},2500); </script>
					<tr id="status-msg">
					   <td></td>
					   <td><a style="cursor:pointer;" class="txtgreen" href="javascript:void(0);"><?php echo $message; ?></a></td>
					 </tr> 
				<?php } ?>
					<tr>
                        <td>User's Account Status:</td>
                        <td><?php 
							if($user_detail['is_active']=='1')
							{
								echo '<a href="javascript:void(0);" class="txtgreen">Active</a>
								<a href="javascript:void(0);" onclick="suspendUsers('.$user_detail['user_id'].');">Suspend User?</a>';
							}
							else if($user_detail['is_active']=='0')
							{ 
								echo '<a href="javascript:void(0);" class="not-verified" onclick="resumeSuspendedUsers('.$user_detail['user_id'].');">Inactive</a>
								<a href="javascript:void(0);" onclick="manuallyVerifyAccount('.$user_detail['user_id'].');">Activate User?</a>'; 
							}
							else
							{
								echo '<a href="javascript:void(0);" class="not-verified">Suspended</a>
								<a href="javascript:void(0);" onclick="resumeSuspendedUsers('.$user_detail['user_id'].');">Activate User?</a>'; 
							} ?>
						</td>
                    </tr>
                   <?php if($user_detail['is_active']!='2'){ ?>
					<tr>
                        <td>Email Verification Status:</td>
                        <td>
						
						<?php 
							if($user_detail['is_active']=='0')
							{ 
								echo '<a href="javascript:void(0);" class="not-verified">Not Verified</a>
								<a href="javascript:void(0);" onclick="sendVerificationEmail('.$user_detail['user_id'].');" class="padr10">Send Verification Email</a>
								<a href="javascript:void(0);" class="padr10" onclick="manuallyVerifyAccount('.$user_detail['user_id'].');">Manually Verify User</a>'; 
							}
							else if($user_detail['is_active']=='1') 
							{ 
								echo '<a href="javascript:void(0);" class="txtgreen"> Verified</a><a href="javascript:void(0);" onclick="resetPassword('.$user_detail['user_id'].');" class="padr10">Reset Password</a>'; 
							} ?>
						
						<!--
						<a href="javascript:void(0);" class="not-verified">Not Verified</a> <a href="javascript:void(0);" class="padr10">Send Verification Email</a> <a href="javascript:void(0);" class="padr10">Manually Verify User</a> <a href="javascript:void(0);" class="padr10">Reset Password</a></td>-->
                    </tr>
					<?php } ?>
                </table>