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
					
					<?php echo anchor('user/earningacc','My Earning Account'); ?>
					</span>
                    <span class="front"></span>
                </div>
                <div class="float active">
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
                <div class="my-seting-block">
                    <div class="detail-edit-block">
                        <div class="edit-block-main">
                        
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody><tr>
                                    <td width="230">Show Notifications</td>
                                    <td><div class="show-content-feed">                                           
                                            <div class="<?php echo $account_setting['someone_make_comment']==1?'cbox-selected':'cbox'?>">
                                               <input type="checkbox" hidefocus="true" style="outline: medium none;" name="someone_make_comment"  value="1" <?php echo $account_setting['someone_make_comment']==1?'checked="checked"':''?>/>
                                                <span>When someone makes a comment on your post</span> </div>
                                            <div class="<?php echo $account_setting['someone_answer_question']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" hidefocus="true" style="outline: medium none;" name="someone_answer_question"  value="1" <?php echo $account_setting['someone_answer_question']==1?'checked="checked"':''?>/>
                                                <span>When someone answers your question</span> </div>
                                            <div class="<?php echo $account_setting['someone_comment_post']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" hidefocus="true" style="outline: medium none;" name="someone_comment_post"  value="1" <?php echo $account_setting['someone_comment_post']==1?'checked="checked"':''?>/>
                                                <span>When someone comments on a post you commented on</span> </div>
                                            
                                            <div class="<?php echo $account_setting['someone_answer_question_you_answer']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" hidefocus="true" style="outline: medium none;" name="someone_answer_question_you_answer"  value="1" <?php echo $account_setting['someone_answer_question_you_answer']==1?'checked="checked"':''?>/>
                                                <span>When someone answers a question you also answered</span> </div>
                                            
                                            <div class="<?php echo $account_setting['someone_start_following']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" hidefocus="true" style="outline: medium none;" name="someone_start_following"  value="1" <?php echo $account_setting['someone_start_following']==1?'checked="checked"':''?>/>
                                                <span>When someone starts following you</span> </div>
                                            
                                            <div class="<?php echo $account_setting['receive_an_email']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" hidefocus="true" style="outline: medium none;" name="receive_an_email"  value="1" <?php echo $account_setting['receive_an_email']==1?'checked="checked"':''?>/>
                                                <span>When you receive an email within InkSmash</span> </div>
                                            
                                            <div class="<?php echo $account_setting['someone_answer_publisher_poll']==1?'cbox-selected':'cbox'?>">
                                                <input type="checkbox" hidefocus="true" style="outline: medium none;" name="someone_answer_publisher_poll" value="1" <?php echo $account_setting['someone_answer_publisher_poll']==1?'checked="checked"':''?>/>
                                                <span>When someone answers the publisher’s poll</span> </div>            
                                        </div></td>
                                </tr>
                            </tbody></table>
                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                        </div>
                        
                    </div>
                                        
                    <div class="detail-edit-block">
                        <div class="edit-block-main">
                            <input type="" class="btnorange right" value="Save Details" hidefocus="true" style="outline: medium none;" onclick="addEditAccountSetting('account-setting')">
                        </div>
                    </div>
                </div>
            </div>
            </form>
           <!--Account Section End -->
          </div>
          </div>
        <div class="clear"></div>
    </div>