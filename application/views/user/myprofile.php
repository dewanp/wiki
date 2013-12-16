<script type="text/javascript">
	$(function() {
	$('.new_password').pstrength();
	});
</script>

<script type="text/javascript" >
	function deletePostImage(file_upload_id)
	{
		ajaxCall('upload/delete','file_upload_id='+file_upload_id)
		$("#files").html('');
		$("#upload").show();
	}
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		 
		new AjaxUpload(btnUpload, {
			action: 'upload/do_upload',
			name: 'postImage',
			data: {field_name:'postImage',folder_name:'user'},
			
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
					status.html('<div class="user-thmb-block"><div class="user-profile-thmb"><img src="images/loader.gif" alt="Loading.." /></div></div>');
					$("#user-image").hide();
					$("#upload").hide();
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.html('');
				var output = $.parseJSON(response);
				if(output.status){
					editInputOnly('user','picture',output.data.file_upload_id);
					showImage(output.data.file_upload_id,'110','110','user-image');
					window.location.reload();

				}else{
					$("#files").html(output.data);
				}
				
			}
		});
		
		$( "#zip_code" ).autocomplete({
			source: site_url + "post/cityAutocomplete",
			minLength: 3,
			select: function( event, ui ) {
				// call back function
			}
       });
		
		
		
		
		
	});
</script>



	<div id="wrapper">
    	<div class="left-content-main">
        	<?php echo $sidebar;?>
        </div> 
        <div class="rightmain">
        <div class="breadcrumb">
          <span class="arrowleft"></span>
          <ul>
          <li><a href="javascript:void(0);" class="active">Home</a></li>
          <li><a href="javascript:void(0);" class="active">My Account</a></li>          
          </ul>
          </div>
          <div class="rightinner">
          <!--Account Section Start -->
          	<div class="account-sec-tab">
            	<div class="account-info-tab">
                <div class="float  active">
                    <span class="back"><span class="unlimited"></span></span>
                    <span class="mid">
                    <a href="javascript:void(0);" id="accountInformation">Account Information</a>					
                    </span>
                    <span class="front"></span>
                </div>
                
                
                <div class="float">
                    <span class="back"></span>
                    <span class="mid">
                    	<a href="javascript:void(0);" id="changePassword">Change Password</a>
					</span>
                    <span class="front"></span>
                </div>
    		</div>
            </div>
            
            <div class="account-info-block">
            	
            	<span id="status"></span>
                <div class="user-thmb-block">
                	<div class="user-profile-thmb" id="user-image">
						<script> showImage('<?php echo $user_detail["picture"];?>','110','110','user-image');</script>
					</div>
					
                    <div class="change-pro-pic" id="upload"><a href="javascript:void(0);">Change Profile Pic</a></div>
                    <div id="progressbar"><div class="progress-label">Loading...</div></div>
                </div>
                <div class="user-detail-block">
                	 <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="jhonNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="font-22" id="profile_name_span" colspan="2">
								<?php echo $user_detail['profile_name'];?>
							</td>
                            <!-- <td width="60%">&nbsp;</td> -->
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="$('#jhonNormal').hide(); $('#editJhon').fadeIn();">Edit</a></td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main" id="editJhon" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="60%" >
								<input type="text" name="profile_name" id="profile_name" class="inputmain " value="<?php echo $user_detail['profile_name'];?>"/>
								<span class="error" id="profile_name_err"></span>
                            </td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link right" onclick="if(validateProfileName('profile_name')){ editInputs('user','profile_name','profile_name','profile_name_span'); $('#editJhon').hide(); $('#jhonNormal').fadeIn();}">Save</a></td>
                          </tr>
						</table>
                        </div>
                        <div class="url-section">
                        	<div class="edit-block-main"  id="urlNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">url </td>
                            <td width="70%"><?php echo anchor($user_detail['user_name']);?></td>
                            <td width="9%">&nbsp;</td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main" id="editUrl" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="240" valign="middle"><a href="javascript:void(0);">urlhttp://inksmash.com/john.abraham</a></td>
                            <td width="49%">
								<input name="" type="text" class="inputmain " style="width:150px;" value=""/>
                            </td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="$('#editUrl').hide(); $('#urlNormal').fadeIn();">Save</a></td>
                          </tr>
						</table>
                        </div>
                        </div>
                     </div>
                     
                	 <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="basicInfoNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Basic Info</td>
                            <td width="70%" id="self_writeup_td">
								<?php echo $user_detail['self_writeup'];?>
							</td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="$('#basicInfoNormal').hide(); $('#editBasicInfo').fadeIn();">Edit</a></td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main" id="editBasicInfo" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Basic Info</td>
                            <td width="70%">
								<textarea rows="3" cols="50" class="inputmain" name="self_writeup" id="self_writeup"><?php echo $user_detail['self_writeup'];?></textarea>
                            </td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="editInputs('user','self_writeup','self_writeup','self_writeup_td');$('#editBasicInfo').hide(); $('#basicInfoNormal').fadeIn();">Save</a></td>
                          </tr>
						</table>
                        </div>
                     </div>
                	 <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="nameNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Username</td>
                            <td width="70%"><?php echo $user_detail['user_name'];?></td>
                            <td width="9%">&nbsp;</td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main" id="editName" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Name</td>
                            <td width="70%">
                                <input name="" type="text" class="inputmain " value="rfedrer"/>
                            </td>
                            <td width="9%"><a href="javascript:void(0);"  onclick="$('#editName').hide(); $('#nameNormal').fadeIn();">Save</a></td>
                          </tr>
						</table>
                        </div>
                     </div>
                     <div class="detail-edit-block">
                     	<div class="privacy-float" id="emailNormal">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td  width="113"valign="top">Emails</td>
                                <td  width="70%">
									<div id="user-email-div">
										<?php 
											foreach($emails as $email_row)
											{
												echo '<div class="email-rows">';
												echo '<div id="user-email-div-'.$email_row['user_email_id'].'">';
												echo '<span id="user_email_span_'.$email_row['user_email_id'].'">'.$email_row['user_email'].'</span>';
												if($email_row['is_default'])
												{
													echo '<span class="c-orange font12">(default)</span>';
												}
												else
												{
													echo '<span style="cursor:pointer;" class="c-orange font12" onclick="onlyShow(\'user-email-edit-div-'.$email_row['user_email_id'].'\');onlyHide(\'user-email-div-'.$email_row['user_email_id'].'\')">&nbsp;(Edit)</span>';

													echo '&nbsp;<span style="cursor:pointer;" class="close12" onclick="deleteEmail(this,\''.$email_row['user_email_id'].'\')"></span>';

													echo '</div>';
													echo '<div id="user-email-edit-div-'.$email_row['user_email_id'].'" style="display:none;">
														<input type="text" name="user_email" class="inputmain" id="user_email_'.$email_row['user_email_id'].'" value="'.$email_row['user_email'].'"/>
														<span style="cursor:pointer;" class="c-orange font12" onclick="if(validateEmail(\'user_email_'.$email_row['user_email_id'].'\')){editInputs(\'user_email\', \'user_email\', \'user_email_'.$email_row['user_email_id'].'\', \'user_email_span_'.$email_row['user_email_id'].'\', '.$email_row['user_email_id'].'); onlyHide(\'user-email-edit-div-'.$email_row['user_email_id'].'\');onlyShow(\'user-email-div-'.$email_row['user_email_id'].'\');}">&nbsp;(Save)</span>';
												}
												echo '</div>';
												echo '<span class="error" id="user_email_'.$email_row['user_email_id'].'_err"></span>';
												echo '</div>';
											}
										?>
									</div>
									<div id="user-email-parent-div">
									</div>
									<a href="javascript:void(0);" class="addmore" onclick="addMoreEmail(<?php echo $user_detail['user_id'];?>);">Add More</a>
								</td>
                                <td width="9%">&nbsp;</td>
                              </tr>
                            </table>
						</div>

                        <div class="privacy-float" id="emailEdit" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113"  valign="top">Emails</td>
                            <td width="70%">
                            john.abraham@gmail.com <span class="c-orange font12">(default)</span>
                            <br /><br />
                             john.abraham321@gmail.com <span class="c-orange font12">(verified)</span> <a href="javascript:void(0);" class="close12"></a> <br /><br />
                              john.abraham123@gmail.com <span class="c-orange font12">(verified pending)</span> <a href="javascript:void(0);" ></a><br /><br />
                              <div id="addEmail"><input name="input2" type="text" class="inputmain" value="rojer.Federer007@gmail.com"/></div>
                              </td>
                            <td width="9%" valign="bottom" style="float:none;"><a href="javascript:void(0);"  onclick="$('#emailEdit').hide(); $('#emailNormal').fadeIn();">Save</a></td>
                          </tr>
                        </table>
                        </div>
                     </div>

                     <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="zipNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Area Zip Code</td>
                            <td width="70%" id="zip_code_span"><?php echo $user_detail['zip_code'];?>&nbsp;</td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="$('#zipNormal').hide(); $('#editZip').fadeIn();">Edit</a></td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main" id="editZip" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Area Zip Code</td>
                            <td width="70%">
                                <input type="text" name="zip_code" id="zip_code" class="inputmain " value="<?php echo $user_detail['zip_code'];?>"/>
								<span class="error" id="zip_code_err"></span>
                            </td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="if(validateZipCode('zip_code')){editInputs('user','zip_code','zip_code','zip_code_span'); $('#editZip').hide(); $('#zipNormal').fadeIn();}">Save</a></td>
                          </tr>
						</table>
                        </div>
                     </div>

					 

                     <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="birthdNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Birthday</td>
                            <td width="70%" id="birth_date_span"><?php if($user_detail['birth_date']) echo date('M d, Y', $user_detail['birth_date']);?></td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="$('#birthdNormal').hide(); $('#editBirthd').fadeIn();">Edit</a></td>
                          </tr>
                        </table>
                        </div>
                        <div class="edit-block-main" id="editBirthd" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Birthday</td>
                            <td width="70%">
                                <input readonly name="birth_date" id="birth_date" type="text" class="inputmain " value="<?php if($user_detail['birth_date']) echo date('M d, Y', $user_detail['birth_date']);?>" style="width: 140px;"/>
                            </td>
                            <td width="9%"><a href="javascript:void(0);" class="orange-link" onclick="editInputs('user','birth_date','birth_date','birth_date_span'); $('#editBirthd').hide(); $('#birthdNormal').fadeIn();">Save</a></td>
                          </tr>
						</table>
                        </div>
                     </div>
                     <div class="detail-edit-block">
                     	<div class="edit-block-main"  id="statusNormal">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Status</td>
                            <td width="70%">
                            	<span class="dd-text"></span>
                                  <select name="" class="designer opacity0" id="dSelect1" size="1" onChange="editRelationshipStatus(this);">
                                    <option value="0" <?php echo set_select('relationship_status', '0', TRUE); ?> >Single</option>
                                    <option value="1" <?php echo set_select('relationship_status', '1', $user_detail['relationship_status']); ?>>Married</option>
                                  </select>
                              </td>
                            <td width="9%">&nbsp;</td>
                          </tr>
                        </table>
                        </div>
                     </div>

                     <div class="detail-edit-block">
                     <div class="privacy-float" id="linkedNormal">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="113">Linked Account</td>
                            <td width="62%"><img src="images/facebook-icn.png" alt="" />  http://www.facebook.com</td>
                            <td width="18%">
                                <a href="javascript:void(0);" class="orange-link attach" id="fb-auth" <?php echo $user_detail['is_fb']?'style="display:none;"':''?>>Attach</a>
                                <?php if($user_detail['password']){?>
                                <a href="javascript:void(0);" class="sf detach" onclick="editInputOnly('user','is_fb','0');$('.detach').hide();userNotification('Successfully detached..');$('.attach').show();" <?php echo $user_detail['is_fb']?'':'style="display:none;"'?>>Detach</a>
                                <?php }?>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                     </div>
					
					</div>
                </div>
                
                <div class="my-earning-block" style="display:none;">
                    <div class="detail-edit-block">
                        <div class="edit-block-main">
                            <h2 class="title">Affiliate setting external to <a href="javascript:void(0);">InkSmash</a></h2>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr class="thead">
                                    <td width="25%">Affiliate Site Name</td>
                                    <td width="34%">Affiliate Code given by you<br />
                                        <span>(Given by site on sign up)</span></td>
                                    <td width="22%">Status of set-up</td>
                                    <td width="13%">&nbsp;</td>
                                    <td width="5%" >&nbsp;</td>
                                    <td width="1%">&nbsp;</td>
                                </tr>
								<?php if(!empty($user_adsence_detail)){ ?>
                                <tr>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('google-ad-ac');">Google Adsense</a></td>
                                    <td id="affiliate_detail"><?php echo htmlspecialchars($user_adsence_detail['user_code']);?></td>
                                    <td><?php echo $user_adsence_detail['is_active']==1?'Actived':'Deactived' ?></td>
                                    <td>&nbsp;</td>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('google-ad-ac');">Edit</a></td>
                                    <td>
									<a href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')"><img src="images/delete-icn.png" alt="" class="tooltip" title="Remove Affiliate" /></a><div class="adl">
									<a class="btnorange" href="javascript:void(0);" onclick="deleteEarningContent('<?php echo $user_adsence_detail['user_earnings_account_id'] ?>')">Yes</a>
						</div>
									</td>
                                </tr>
								<?php } else {?>
								<tr>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('google-ad-ac');">Google Adsense</a></td>
                                    <td>Not Set-up</td>
                                    <td>Not Set-up</td>
                                    <td>&nbsp;</td>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('google-ad-ac');">Edit</a></td>
                                    <td><a href="javascript:void(0);"><img src="images/delete-icn.png" class="tooltip" title="Remove Affiliate" alt="" /></a></td>
                                </tr>
								<?php }?>
                                <?php if(!empty($user_amazon_detail)){?>
                                <tr>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('amazon-ac');">Amazon</a></td>
                                    <td id="amazon_detail"><?php echo $user_amazon_detail['user_code'] ?></td>
                                    <td><?php echo $user_amazon_detail['is_active']==1?'Actived':'Deactived'?></td>
                                    <td>&nbsp;</td>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('amazon-ac');">Edit</a></td>
                                    <td><a href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')"><img src="images/delete-icn.png" alt="" class="tooltip" title="Remove Affiliate" /></a><div class="adl">
							<a class="btnorange" href="javascript:void(0);" onclick="deleteEarningContent('<?php echo $user_amazon_detail['user_earnings_account_id'] ?>')">Yes</a>
						</div></td>
                                </tr>
                                <?php }else{?>
                                <tr>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('amazon-ac');"> Amazon </a></td>
                                    <td>Not Set-up</td>
                                    <td>Not Set-up</td>
                                    <td>&nbsp;</td>
                                    <td><a href="javascript:void(0);" onclick="openPopDiv('amazon-ac');">Edit</a></td>
                                    <td><a href="javascript:void(0);"><img src="images/delete-icn.png" alt="" class="tooltip" title="Remove Affiliate" /></a></td>
                                </tr>
                                <?php }?>
                            </table>
                            
                            
                            <!--popup Amazon account-->
                            <div class="popup" id="amazon-ac" style="display:none;">
                                <a href="javascript:void(0);" class="close" onclick="closePopDiv('amazon-ac');"></a>
                                <h2>Amazon Account</h2>
                                <form action="" id="amazon-content-form" name="amazon-content-form">
                                
                                    <?php if(!empty($user_amazon_detail)){?> 
                                        <div class="popupinner">
                                        	<div class="note">
                                                <h5>Amazon account would ensure that you can put your Amazon product as block on your post at InkSmash. In case you don't have an account, you'd need to set it up before you begin work on this. Click on the <a href="https://affiliate-program.amazon.com/" target="_blank">button</a> to set up the Amazon Account. Its simple process.</h5>
                                    		</div>
                                            <div class="google-adsense amazonmain">
                                       			 <div class="txtcode">Enter your Amazon Tracking ID in area below</div>
                                            
                                                                       
                                       			<div class="field">
                                                    <label for="user_code" class="infield" style="display:block;">Put code in this area</label>
                                                    <input type="text" class="inputmain" id="user_code" value="<?php echo $user_amazon_detail['user_code'] ?>" name="user_code"/>
                                                    <a href="javascript:void(0);" class="help tooltip" title="If you just finished signing up, you should see your tracking ID on the completion screen. If not, you can find a list of all your Tracking IDs in your Amazon Associate Account."></a> 
                                                </div>
                                                
                                                <div class="field" style="margin:10px 0;">
                                                	<div class="checkboxmain">
                                                        <div class="<?php echo $user_amazon_detail['is_active']==1?'cbox-selected':'cbox'?>" style="margin:0;">
                                                            <input type="checkbox" <?php echo $user_amazon_detail['is_active']==1?'checked="checked"':''?> name="is_active" value="1"/>
                                                            Enable/Disable
                                                        </div>
                                                    </div>
                                                </div>
                                             </div>
                                          </div>      
                                          <input type="hidden" name="user_earnings_account_id" value="<?php echo $user_amazon_detail['user_earnings_account_id'] ?>" />
                                        <?php }else{?>
                                        <div class="popupinner">
                                        	<div class="note">
                                                <h5>Amazon account would ensure that you can put your Amazon product as block on your post at InkSmash. In case you don't have an account, you'd need to set it up before you begin work on this. Click on the <a href="https://affiliate-program.amazon.com/" target="_blank">button</a> to set up the Amazon Account. Its simple process.</h5>
                                    		</div>
                                            
                                            <div class="google-adsense amazonmain">
                                       			 <div class="txtcode">Enter your Amazon Tracking ID in area below</div>
                                        
                                        		<div class="field">
                                                    <label for="user_code" class="infield" style="display:block;">Put code in this area</label>
                                                    <input type="text" class="inputmain" id="user_code" value="" name="user_code"/>
                                                    <a href="javascript:void(0);" class="help tooltip" title="If you just finished signing up, you should see your tracking ID on the completion screen. If not, you can find a list of all your Tracking IDs in your Amazon Associate Account."></a> 
                                                </div>
                                                <div class="field" style="margin:10px 0px;">
                                                	<div class="checkboxmain">
                                                        <div class="cbox" style="margin:0;">
                                                            <input type="checkbox" name="is_active" value="1"/>
                                                            Enable/Disable</div>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>        
                                         <input type="hidden" name="user_earnings_account_id" value="0" />
                                        <?php }?>
                                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                                            <input type="hidden" name="account_type" value="1" />
                                        </form>
                                        <div class="btnbox amazon"> 
                                            <a href="javascript:void(0);" class="btnorange" onclick="saveEarningContent('amazon-content-form')">Save</a>
                                    		<a href="javascript:void(0);" class="cancel" onclick="closePopDiv('amazon-ac');">Cancel</a>  
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                            <!--popup Amazon account-->
                            
                            <!--popup google Adsense account-->
                            <div class="popup" id="google-ad-ac" style="display:none;"> 
                            <a href="javascript:void(0);" class="close" onclick="closePopDiv('google-ad-ac');"></a>
                               <h2>Google Adsense Account</h2>
								<form action="" id="google_ad_acc_form" name="google_ad_acc_form" >
                               <?php if(!empty($user_adsence_detail)) {?>
								<div class="popupinner">
                                    <div class="note">
                                        <h5>Google Adsense account would ensure that you can put your own code inside your post at InkSmash. In case you don't have an Adsense account, you'd need to set it up before you begin work on this. Click on the <a href="http://google.com/adsense" target="_blank">button</a> to set up the Google Account. Its simple process.</h5>
                                    </div>
                                    <div class="google-adsense">
                                        <div class="txtcode">Enter your Publisher ID.  You can find this number on the top right when you log in to your AdSense account.  It will look like the following: "pub-xxxxxxxxxxxxxxxx"</div>
                                        <div class="field">
                                            <label for="google_ad_client" class="infield">Put code in this area</label>
                                            <input type="text" class="inputmain" id="google_ad_client" name="google_ad_client" value="<?php echo $user_adsence_detail['user_code'];?>" />
                                          <a href="javascript:void(0);" class="help tooltip" title="Enter your Publisher ID. You can find this number on the top right when you log in to your AdSense account."></a> 
                                        </div>
                                        
                                        <div class="field" style="margin:10px 0px;">
                                                	<div class="checkboxmain">
                                                        <div class="<?php echo $user_adsence_detail['is_active']==1?'cbox-selected':'cbox'?>" style="margin:0;">
                                                            <input type="checkbox" <?php echo $user_adsence_detail['is_active']==1?'checked="checked"':''?> name="is_active" value="1"/>
                                                            Enable/Disable
                                                        </div>
                                                    </div>
                                        </div>
                                   </div>
                             </div>
								 <input type="hidden" name="user_earnings_account_id" value="<?php echo $user_adsence_detail['user_earnings_account_id'] ?>" />
								<?php }else { ?>
								<div class="popupinner">
                                    <div class="note">
                                        <h5>Google Adsense account would ensure that you can put your own code inside your post at InkSmash. In case you don't have an Adsense account, you'd need to set it up before you begin work on this. Click on the <a href="http://google.com/adsense" target="_blank">button</a> to set up the Google Account. Its simple process.</h5>
                                    </div>
                                    <div class="google-adsense">
                                        <div class="txtcode">Enter your Publisher ID.  You can find this number on the top right when you log in to your AdSense account.  It will look like the following: "pub-xxxxxxxxxxxxxxxx"</div>
                                        <div class="field">
                                            <label for="google_ad_client" class="infield">Put code in this area</label>
                                            <input type="text" class="inputmain" id="google_ad_client" name="google_ad_client" value="" />
                                            <a href="javascript:void(0);" class="help tooltip" title="Enter your Publisher ID. You can find this number on the top right when you log in to your AdSense account."></a> 
                                        </div>
                                        <div class="field" style="margin:10px 0;">
                                                	<div class="checkboxmain">
                                                        <div class="cbox" style="margin:0;">
                                                            <input type="checkbox" name="is_active" value="1"/>
                                                            Enable/Disable</div>
                                                    </div>
                                       </div>
                                    </div>
                                </div>
								<input type="hidden" name="user_earnings_account_id" value="0" />
								<?php }?>
								<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                                <input type="hidden" name="account_type" value="2" />
								</form>

                                <div class="google_bottom_border btnbox" id="google_ad"> 
                                    <a href="javascript:void(0);" class="btnorange" onclick="updateGoogleAdAccount('google_ad_acc_form');"> Save</a> 
                                    <a href="javascript:void(0);" class="cancel" onclick="closePopDiv('google-ad-ac');">Cancel</a> 
                                </div>
                            </div>
                            <!--popup google Adsense account--> 
                        </div>
                 </div>
                

				<div class="my-seting-block" style="display:none;">
                    <form name="account-setting" id="account-setting">
                    <div class="detail-edit-block">
                        <div class="edit-block-main">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                  <tr>
                                    <td width="230">Show Notifications</td>
                                    <td>
                                    	<div class="show-content-feed">
                                            <div class="<?php echo $account_setting['someone_make_comment']==1?'cbox-selected':'cbox'?>">
<input type="checkbox"  name="someone_make_comment"  value="1" <?php echo $account_setting['someone_make_comment']==1?'checked="checked"':''?>/>
                                                <span>When someone makes a comment on your post</span> 
                                             </div>
                                            <div class="<?php echo $account_setting['someone_answer_question']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" name="someone_answer_question"  value="1" <?php echo $account_setting['someone_answer_question']==1?'checked="checked"':''?>/>
                                                <span>When someone answers your question</span>
                                            </div>
                                            <div class="<?php echo $account_setting['someone_comment_post']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" name="someone_comment_post"  value="1" <?php echo $account_setting['someone_comment_post']==1?'checked="checked"':''?>/>
                                                <span>When someone comments on a post you commented on</span> 
                                            </div>
                                            
                                            <div class="<?php echo $account_setting['someone_answer_question_you_answer']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" name="someone_answer_question_you_answer"  value="1" <?php echo $account_setting['someone_answer_question_you_answer']==1?'checked="checked"':''?>/>
                                                <span>When someone answers a question you also answered</span> 
                                            </div>
                                            
                                            <div class="<?php echo $account_setting['someone_start_following']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" name="someone_start_following"  value="1" <?php echo $account_setting['someone_start_following']==1?'checked="checked"':''?>/>
                                                <span>When someone starts following you</span>
                                           </div>
                                            
                                            <div class="<?php echo $account_setting['receive_an_email']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" name="receive_an_email"  value="1" <?php echo $account_setting['receive_an_email']==1?'checked="checked"':''?>/>
                                                <span>When you receive an email within InkSmash</span>
                                           </div>
                                            
                                            <div class="<?php echo $account_setting['someone_answer_publisher_poll']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" name="someone_answer_publisher_poll" value="1" <?php echo $account_setting['someone_answer_publisher_poll']==1?'checked="checked"':''?>/>
                                                <span>When someone answers the publisher's poll</span>
                                           </div>            
                                        </div>
                                      </td>
                                   </tr>
                               </tbody>
                            </table>
                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                        </div>
                    </div>
                                        
                    <div class="detail-edit-block">
                        <div class="edit-block-main">
                            <input  type="button" class="btnorange right" value="Save Details" onclick="addEditAccountSetting('account-setting')">
                        </div>
                    </div>
                  </form>
                </div>
                
               
                <div class="imp-userinfo-main-block" style="display:none;">
                <div class="important-user-info">
                    	<div class="user-info-title"><h2 class="title">Important User Information</h2></div>
                        <div class="user-information">
                        <form name="form_change_password" id="form_change_password">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="20%">Current Password</td>
                                <td width="30%">
                                	<div class="field">
                                        <label for="cur_password" class="infield">Current Password</label>
                                        <input type="password" name="cur_password" id="cur_password" class="inputmain" value="" onkeyup ="$('#cur_password_msg').html('');"/>
										<span class="error" id="cur_password_msg"></span>
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
                                    <span class="pwd-ch"></span>
									<span class="error" id="new_password_msg"></span>
                                   </td>
                                <td><div class="pwd-info"></div></td>
                              </tr>
                              <tr>
                                <td>Retype Password</td>
                                <td>
                                	<div class="field">
                                        <label for="confirm_password" class="infield">Retype new password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="inputmain " value="" onkeyup ="$('#confirm_password_msg').html('');"/>
										<span class="error" id= "confirm_password_msg"></span>
                                    </div>
                                   </td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
							<input type="button" value="Change Password" class="btnorange right" style="margin:12px 0;" onclick="changePassword();">
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
            </div>
             <!--Account Section End -->
          </div>
          </div>
        <div class="clear"></div>
    </div>
	<script>
	$(function(){ 
				$("#birth_date").datepicker({ dateFormat: 'M dd, yy',buttonImageOnly: true , showOn :'button', buttonImage:'images/cal-icon.png', changeMonth: true, changeYear: true ,minDate:'-100y', maxDate:'+0d' , showMonthAfterYear: true, showOn: "both", yearRange:'c-100'});
			
		<?php // if($this->uri->segment(2)=='earningacc'){?>
					//$(".mid  #earningAccount").trigger('click');
		<?php // }?>
			});
    </script>