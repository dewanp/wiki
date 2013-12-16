<!--Wrapper	Start-->

<div id="wrapper">
<div class="breadcrumb"></div>
    <div class="container">
        <div class="j-loginbox google-ad">
			<div class="detail-edit-block">
                     	<div class="edit-block-main"  id="google_ad_Normal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Google client-id</td>
                            <td id="google_code_span"><?php if(array_key_exists("user_code",$google_ad)){ echo $google_ad['user_code'];}?>&nbsp;</td>
                            <td><a href="javascript:void(0);" class="orange-link" onclick="$('#google_ad_Normal').hide(); $('#edit_google_ad').fadeIn();">Edit</a></td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main edit-google" id="edit_google_ad" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Google client-id</td>
                            <td>
                                <input type="text" name="google_code" id="google_code" class="inputmain " value="<?php echo $google_ad['user_code'];?>"style="width:250px"/>
								<span class="error" id="google_code_err"></span>
                            </td>
                            <td><a href="javascript:void(0);" class="orange-link" onclick="if(validateGoogleId()){editInputs('user_earnings_account','user_code','google_code', 'google_code_span','<?php echo $google_ad['user_earnings_account_id'];?>'); $('#edit_google_ad').hide(); $('#google_ad_Normal').fadeIn();}">Save</a></td>
                          </tr>
						</table>
                        </div>
                     </div>
					 <!-- Admin percent  -->
					 <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="percent_Normal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Admin Percent</td>
                            <td id="admin_percent_span"><?php echo $admin_percent['admin_percent'];?> &nbsp;</td>
                            <td><a href="javascript:void(0);" class="orange-link" onclick="$('#percent_Normal').hide(); $('#edit_percent').fadeIn();">Edit</a></td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main edit-percent" id="edit_percent" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>Admin Percent</td>
                            <td>
                                <input type="text" name="admin_percent" id="admin_percent" class="inputmain " value="<?php echo $admin_percent['admin_percent'];?>" style="width:250px"/>
								<span class="error" id="admin_percent_err"></span>
                            </td>
                            <td><a href="javascript:void(0);" class="orange-link" onclick="if(validateAdminPercent()){editInputs('google_ad','admin_percent','admin_percent', 'admin_percent_span','<?php echo $admin_percent['google_ad_id'];?>'); $('#edit_percent').hide(); $('#percent_Normal').fadeIn(); }">Save</a></td>
                          </tr>
						</table>
                        </div>
                     </div>


        </div>
    </div>
</div>

<!--Wrapper	End--> 

