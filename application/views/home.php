<div id="wrapper-home">
    <div class="wrapperin">
        <div class="lefthome">
            <h1>Get paid to share your interests with the world.</h1>
            <h4>Write a blog, share a video, post an image gallery and more. There are infinite possibilities.</h4>
            <div class="join">
                <div class="circle"></div>
            </div>
            <div class="viewbtnbox"> 
				<?php echo anchor('post/showposts/all' , '<span class="all-post-icon"></span> <span class="titleor">View all posts</span> <span class="titlegrey">View a list of all Post. </span> <span class="arrow"></span>' , 'class="viewbtn" '); ?>
                
				<?php echo anchor('post/allcategories' , '<span class="cat-icon"></span> <span class="titleor">View all categories</span> <span class="titlegrey">View a list of all categories of your choice. </span> <span class="arrow"></span>' , 'class="viewbtn" '); ?>

				<?php echo anchor('post/localpostsmap' , '<span class="list-icon"></span> <span class="titleor">View the local lists</span> <span class="titlegrey">View a list of all categories of your Local area lists.</span> <span class="arrow"></span>' , 'class="viewbtn" '); ?>
				
				<?php echo anchor('post/showposts/video','<span class="video-icon"></span> <span class="titleor">View the Videos</span> <span class="titlegrey">View a list of Videos posted.</span> <span class="arrow"></span>','class="viewbtn"');?> 
                
				<?php echo anchor('contest/contestlist','<span class="contest-icon"></span> <span class="titleor">View the Contests</span> <span class="titlegrey">View a list of all contest that are running.</span> <span class="arrow"></span>','class="viewbtn"');?> 
			</div>
        </div>
        <div class="righthome">
            <div class="videosec"> <iframe width="510" height="346" src="http://www.youtube.com/embed/nPPM_qahJE0?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe></div>
            <div class="form-home">
                <?php	$hidden = array('save'=>'save');  
					echo form_open('user/saveregistration','name="form" class="form" onSubmit="if(!validateSignUpform())return false;"',$hidden);?>
                    <div class="field">
                        <label for="user_name" class="infield">Username</label>
                        <input  name="user_name" type="text" id="user_name" class="inputmain" value="<?php echo set_value('user_name');?>"  onBlur="validateUsername('user_name');" autocomplete="off"/>
                        <span class="note">Your profile would be at inksmash.com/ username</span> 
						<span class="error" id="user_name_err"><?php echo form_error('user_name'); ?></span>
					</div>
                    <div class="field">
                        <label for="email" class="infield">Email</label>
                        <input name="email" type="text" id="email" class="inputmain" value="<?php echo set_value('email'); ?>" onBlur="validateEmail('email');" autocomplete="off"/>
                        <span class="error" id="email_err"><?php echo form_error('email'); ?></span>
					</div>
                    <div class="field">
                        <label for="password" class="infield">Password</label>
                        <input name="password" type="password" id="password" class="inputmain" onBlur="validatePassword('password');" autocomplete="off"/>
                        <span class="error" id="password_err"><?php echo form_error('password'); ?></span>
                    <div class="field">
                        <label for="confirm_password" class="infield">Confirm Password</label>
                        <input name="confirm_password" type="password" id="confirm_password" class="inputmain" onBlur="validateConfirmPassword('password','confirm_password');" autocomplete="off"/>
                        <span class="error" id="confirm_password_err"><?php echo form_error('confirm_password'); ?></span>
					</div>
                    <div class="captcha">
						<span id = "captcha-div">
							<?php echo $captcha['image']; ?>
							<input type="hidden" value="<?php echo md5($captcha['word']);?>" name="redirect">
						</span>
						<div class="field fieldcap">
							<label for="captcha_code" class="infield">Enter the text</label>
							<input name="captcha_code" type="text" id="captcha_code" class="inputmain" value="" onBlur="validateCaptcha('captcha_code');"/>
						</div>
						<a href="javascript:void(0);" onClick="reloadCaptcha();" class="refresh"> Refresh</a>
						<span class="error clear" id="captcha_code_err"><?php echo form_error('captcha_code'); ?></span>
					 </div>
                    <div class="cbox">
                        <input type="checkbox" name="terms" id="terms" <?php echo set_checkbox('terms', '1'); ?> value="1"/>
                        I agree to the <?php echo anchor('terms-of-service','Terms of Services','target="_blank"');?> 
						<span class="error" id="terms_err"><?php echo form_error('terms'); ?></span>
					</div>
                    <div class="btnbox">
                        <input type="submit" class="submit-buttom" value="Join" />
                        <span class="fconnect"> OR use  <a href="javascript:void(0);" id="fb-auth"><img src="images/fconnect.png" alt="" /></a></span> </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>