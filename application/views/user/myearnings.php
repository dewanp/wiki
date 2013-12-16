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
                <div class="float active">
                    <span class="back"></span>
                    <span class="mid">
					
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
                <div class="float">
                    <span class="back"></span>
                    <span class="mid">
					<?php echo anchor('user/showChangePassword','Change Password'); ?></span>
                    <span class="front"></span>
                </div>
    			</div>
            </div>
            <div class="account-info-block">
                <div class="my-earning-block">
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
                                    <td><?php echo htmlspecialchars($user_adsence_detail['user_code']);?></td>
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
                                    <td><?php echo $user_amazon_detail['user_code'] ?></td>
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
                                <div class="popupinner">
                                    <div class="note">
                                        <h5>Amazon account would ensure that you can put your Amazon product as block on your post at InkSmash. In case you don't have an account, you'd need to set it up before you begin work on this. Click on the <a href="https://affiliate-program.amazon.com/" target="_blank">button</a> to set up the Amazon Account. Its simple process.</h5>
                                    </div>
                                    <div class="google-adsense amazonmain">
                                        <div class="txtcode">Enter your Amazon Tracking ID in area below</div>
                                        <form action="" id="amazon-content-form" name="amazon-content-form">
                                        <?php if(!empty($user_amazon_detail)){?>                                
                                       			<div class="field">
                                                    <label for="user_code" class="infield">Put code in this area</label>
                                                    <input type="text" class="inputmain" id="user_code" value="<?php echo $user_amazon_detail['user_code'] ?>" name="user_code"/>
                                                    <a href="javascript:void(0);" class="help tooltip" title="If you just finished signing up, you should see your tracking ID on the completion screen. If not, you can find a list of all your Tracking IDs in your Amazon Associate Account."></a> 
                                                    
                                                </div>
                                                <div class="field" style="margin:10px 0;">
                                                	<div class="checkboxmain">
                                                        <div class="<?php echo $user_amazon_detail['is_active']==1?'cbox-selected':'cbox'?>" style="margin:0;">
                                                            <input type="checkbox" <?php echo $user_amazon_detail['is_active']==1?'checked="checked"':''?> name="is_active" value="1"/>
                                                            Enable/Disable</div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user_earnings_account_id" value="<?php echo $user_amazon_detail['user_earnings_account_id'] ?>" />
                                        <?php }else{?>
                                        		<div class="field">
                                                    <label for="user_code" class="infield">Put code in this area</label>
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
                                                <input type="hidden" name="user_earnings_account_id" value="0" />
                                        <?php }?>
                                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                                            <input type="hidden" name="account_type" value="1" />
                                        </form>
                                    </div>
                                    <div class="btnbox amazon"> <a href="javascript:void(0);" class="btnorange" onclick="saveEarningContent('amazon-content-form')">Save</a> </div>
                                </div>
                            </div>
                            <!--popup Amazon account-->
                            
                            <!--popup google Adsense account-->
                            <div class="popup" id="google-ad-ac" style="display:none;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('google-ad-ac');"></a>
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
                                                            Enable/Disable</div>
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

									<div class="google_bottom_border btnbox" id="google_ad"> <a href="javascript:void(0);" class="btnorange" onclick="updateGoogleAdAccount('google_ad_acc_form');"> Save</a> <a href="javascript:void(0);" class="cancel" onclick="closePopDiv('google-ad-ac');">Cancel</a> </div>
                                
                            </div>

                            <!--popup google Adsense account--> 
                        </div>
                    </div>
                </div>
            </div>
                        
            
             <!--Account Section End -->
          </div>
          </div>
        <div class="clear"></div>
    </div>
