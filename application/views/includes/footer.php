<div id="footer-wrapper">
    <div id="footer-main">
    	<div class="footer-content">
        <div class="footer-copyright">
                  <div class="copyrith-left">&copy; Copyright Wiki <?php echo date("Y")?>. All Rights Reserved</div>
                </div>
        	<!--<div class="content-f-left">
            	<div class="footer-links">
                	<h2 class="title">About InkSmash</h2>
                	<ul>
                    	<li><?php echo anchor('about-inksmash','About InkSmash');?></li>
                        <li><?php echo anchor('take-tour','Take a Tour');?></li>
                        <li><?php echo anchor('what-we-do','What we do ?');?></li>
                        <li><?php echo anchor('press-information','Press Information');?></li>
                        <li> <?php echo anchor('official-blog','Official Blog');?></li>
                    </ul>
                </div>
                <div class="footer-links">
                	<h2 class="title">Explore InkSmash</h2>
                	<ul>
                    	<li><?php echo anchor('post/localPostsMap','Local Posts');?></li>
                        <li><?php echo anchor('post/showposts/paragraph','Articles');?></li>
                        <li><?php echo anchor('post/showQnaPosts', 'QNA');?></li>
                        <li><?php echo anchor('post/showposts/Polls','Polls');?></li>
                        <li><?php echo anchor('post/showposts/video','Videos');?></li>
                        <li><?php echo anchor('post/showposts/image','Images');?></li>                                              
                    </ul>
                </div>
                <div class="footer-links">
                	<h2 class="title">Help</h2>
                	<ul>
                    	<li><?php echo anchor('help-center','Help Center');?></li>
                        <li><?php echo anchor('contact-us','Contact Us');?></li>
                     </ul>
                </div>
                <div class="footer-links">
                	<h2 class="title">Company</h2>
                	<ul>
                    	<li><?php echo anchor('terms-of-service','Terms of Services');?></li>
                        <li><?php echo anchor('how-it-works','How it Works');?></li>        
                     </ul>
                </div>
                
            </div>
             
            <div class="footer-right">
                <div class="signup-for-news">
                    <h2 class="title">Signup for Newsletter</h2>
                    <div class="email-to-subscribe">
                    	<form method="post" onsubmit ="return subscribe(emailid.value)">
                        <div class="field">
                <label for="emailid" class="infield">Enter email to Subscribe</label>
                <input name="emailid" type="text" class="input-global wid-210" id="emailid"  />
              </div>
                            <div id="error_msg" style="color:red;float:left; margin-top:5px;">&nbsp;</div>
                            <input type="submit" value="Subscribe" class="submit-buttom"  />
							
                       </form>
                    </div>
                </div>
                <div class="footer-social-icon">
                	<ul>
                    	<li><a href="mailto:info@inksmash.com" id=email>&nbsp;</a></li>
                        <li><a href="http://www.linkedin.com/company/2672817" id="link-ind" target="_blank">&nbsp;</a></li>
                        <li><a href="http://www.facebook.com/InkSmash" id="facebook" target="_blank">&nbsp;</a></li>
                        <li><a href="https://twitter.com/inksmash" id="twitter" target="_blank">&nbsp;</a></li>
                    </ul>
                </div>
            </div>-->
            <div class="clear"></div>
        </div>
    </div>
    	<!--<div class="copyright-section">
        	<div class="footer-copyright-main">
            	<div class="copyrith-left">&copy; Copyright InkSmash <?php //echo date("Y")?>. All Rights Reserved.</div>
                
            </div>
          <div class="clear"></div>
        </div>-->
      
    </div>
<!--Loader image -->    
<div id="spinner">
    <img src="images/ajax-loader.gif" alt="Loading..."/>
</div>
<!--popup confirmation-->
<div class="popup confirm" id="confirm" style="display:none;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('confirm');"></a>
    <div class="popupinner">
        <div class="note">
            <h5 id="confirm-user-message">Are you sure to delete this row?</h5>
        </div>
        <div class="btnbox"> 
			<div id="confirm-yes-button"><a href="javascript:void(0);" class="btnorange">Yes</a></div>
			<a href="javascript:void(0);" class="cancel" onclick="closePopDiv('confirm');">No</a> 
		</div>
    </div>
</div>
<!--popup confirmation-->

<!--popup zip code popup-->
<div class="popup zip_code_div" id="zip_code_div" style="display:none;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('zip_code_div');"></a>
    <div class="popupinner">
        <div class="note j-note">
            <h5 id="confirm-user-message">Please enter zip code</h5>
        </div>
		<div class="j-zipbox">
		<div id="zip-code" class="field">
			<label for="zip_code" class="infield">Enter Zip Code</label>
			<input type="text" class="inputmain required" name="zip_code" id="zip_code"/>
			
		</div>
        <div class="btnbox j-btn"> 
			<div id="confirm-yes-button"><a href="javascript:void(0);" class="btnorange" onClick="return saveZipCode();">Save</a></div>
		</div>
		<span class="error" id="zip_error"></span>
		</div>
    </div>
</div>
<!--popup zip code-->
<script>
	$(document).ready(function(){
		var cur_url = window.location;
		if(typeof cur_url != 'undefined' && cur_url !=''){
			$('a').each(function(){
				var thshref = $(this).attr('href');			
				if(typeof thshref != 'undefined' && thshref == cur_url){
					$(this).addClass('active');					
				}
				
			});
		}
		<!-- Javascript for autocomplete suggestion box -->
		// Custom Break Characters
		$('input#compose_to').tagedit({
			autocompleteURL: site_url+'message/getHint',
			allowEdit: false,
			allowDelete: false,
			additionalListClass : 'inputmain',
			// return, comma, space, period, semicolon
			breakKeyCodes: [ 13, 44, 32, 46, 59 ]
		});	
	});
</script>

<div id="fb-root"></div>
<!--<script>
window.fbAsyncInit = function() {
  FB.init({ appId: '<?php echo FB_APP_ID?>', 
	    status: true, 
	    cookie: true,
	    xfbml: true,
	    oauth: true});

  function updateButton(response) {
      var button = document.getElementById('fb-auth');
	  var button_top = document.getElementById('fb-auth-top');
	  var button_logout = document.getElementById('logout');
	   
	  	if(window.location=='<?php echo site_url('user/social')?>' || window.location=='<?php echo site_url('user/saveSocialRegistration')?>'){
			if(response.authResponse){				
					var email = $("#email");
					var user_profile_name = $("#profile_name");
					//user is already logged in and connected      
					FB.api('/me', function(response) {
						
						$.ajax({
								type: "POST",
								url: site_url + "user/checkfbuser",
								data: "fbemail="+response.email,
								async: true,
								success: function (data){ 
									if(data==0){
										window.location =site_url;
									}else if(data==1){
										userNotification("Email "+response.email+" already in use.");
									}else{
										email.val(response.email).trigger('onPropertyChange');
										user_profile_name.val(response.name).trigger('onPropertyChange');
									}
								}
							});						
						
					});					
			}else{
				window.location =site_url+'user/login';
			}						
		}
	  
	  	if(button_logout === undefined || button_logout==null){
		// no fb button
		}else{
			button_logout.onclick = function() {
				FB.logout(function(response) {});
				setTimeout(function(){
					window.location =site_url+'user/logout';
				},500);
			}
		}
	  
		//user is not connected to your app or logged out	  
		if(button === undefined || button==null){
		// no fb button
		}else{
			button.onclick = function() {

				FB.login(function(response) {
					if (response.authResponse) {
						// successfull login
						FB.api('/me', function(response) {
							
							$.ajax({
								type: "POST",
								url: site_url + "user/checkfbuser",
								data: "fbemail="+response.email,
								async: false,
								success: function (data){ 
									//alert(data);
									if(data==0){
										
										if(window.location=='<?php echo site_url('user/myprofile')?>'){
											// attach functionality
											
											$.ajax({type: "POST",url: site_url+"user/fbattach",data: "fbemail="+response.email, success: function(data){ 
												$('.attach').hide();
												userNotification('Successfully attached..');
												$('.detach').show();											
											}});
																						
										}else{
											window.location.reload();
										}
									}else if(data==1){
										
										if(window.location=='<?php echo site_url('user/myprofile')?>'){
											
											// attach functionality
											$.ajax({type: "POST",url: site_url+"user/fbattach",data: "fbemail="+response.email, success: function(data){ 
												if(data==1){
													userNotification("Email "+response.email+" already in use.");
												}else{
													$('.attach').hide();
													userNotification('Successfully attached..');
													$('.detach').show();											
												}
											}});
										}else{
											userNotification("Email "+response.email+" already in use.");
										}
										
									}else{
										
										if(window.location=='<?php echo site_url('user/myprofile')?>'){
											// attach functionality
											
											$.ajax({
											type: "POST",url: site_url+"user/fbattach",
											data: "fbemail="+response.email, 
											success: function(data){ 
													//alert(data);
													$('.attach').hide();
													userNotification('Successfully attached..');
													$('.detach').show();											
												}
											});
										}else{
											window.location =site_url+'user/social';
										}
										
									}
								}
							});						
						});						
					} else {
							//user cancelled login or did not grant authorization
					}
				}, {scope:'email'});
			}
		}
		
		//user is not connected to your app or logged out	  
		if(button_top === undefined || button_top==null){
		// no fb button
		}else{
			button_top.onclick = function() {
				FB.login(function(response) {
					if (response.authResponse) {
						// successfull login
						FB.api('/me', function(response) {
							
							$.ajax({
								type: "POST",
								url: site_url + "user/checkfbuser",
								data: "fbemail="+response.email,
								async: false,
								success: function (data){ 
									if(data==0){
										window.location.reload();
									}else if(data==1){
										userNotification("Email "+response.email+" already in use.");
									}else{
										window.location =site_url+'user/social';
									}
								}
							});						
						});						
					} else {
							//user cancelled login or did not grant authorization
					}
				}, {scope:'email'});
			}
		}
		
		
		
	  
	   
  }
  // run once with current status and whenever the status changes
  FB.getLoginStatus(updateButton);
  FB.Event.subscribe('auth.statusChange', updateButton);	
};
	
(function() {
  var e = document.createElement('script'); e.async = true;
  e.src = document.location.protocol 
    + '//connect.facebook.net/en_US/all.js';
  document.getElementById('fb-root').appendChild(e);
}());

</script>-->

<!--popup New message-->
<div class="popup" id="new-message" style="display:none;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('new-message');"></a>
    <h2>New Message</h2>
    <div class="popupinner">

	<form  id="compose" onsubmit ="return compose_message()" action ="">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblmessage">
    <tr>
        <td>To</td>
        <td>
		<input type="text" id="compose_to" name="compose_to[]"  value=""  class="compose"/>
		<div id="error_to" style="color:#F00" > </div>
		</td>
    </tr>
    <tr>
        <td>Subject</td>
        <td>
			<input type="text" name="compose_subject" id="compose_subject" class="inputmain" maxlength="150" onkeyup="$('#error_subject').html('Max. 150 character')" onblur="$('#error_subject').html('')" >  
			<div id="error_subject" style="color:#F00" > </div>
	  </td>
    </tr>
    <tr>
        <td>Message</td>
        <td>
		<textarea name="compose_description" id="compose_description"  cols="" rows="" class="inputmain" onkeyup="countCharCompose(this)"  onblur="$('#error_description').html('')"   ></textarea>
		  <div id="error_description"  > </div>
	  </td>
    </tr>
</table>

        <div class="btnbox"> 
		<input type="submit" value="Send" class="btnorange"> 
		<a href="javascript:void(0);" class="cancel" onclick="closePopDiv('new-message');">Cancel</a>
	  </div>
    </div>
</form>
</div>
<!--popup New message-->
<script type="text/javascript">
function countCharCompose(val){
     var len = val.value.length;
     if (len >= 1000){
		 $('#error_description').html('limit of 1000 character exceed');

     } else{
         $('#error_description').html("Character :"+ (1000 - len));
     }
};
</script>

<!--<script type="text/javascript">var switchTo5x=true; </script>
<script type="text/javascript" src="http://wd.sharethis.com/button/buttons.js"></script>
<script type="text/javascript" src="http://s.sharethis.com/loader.js"></script>-->

<script>
	//stLight.options({publisher: "1f450bf1-53d0-48d0-ad2c-603685f88f3d"});
</script>

<script>
	/* this is for the share this vertical*/
	$(document).ready(function(){
	//var options={ "publisher": "1f450bf1-53d0-48d0-ad2c-603685f88f3d", "position": "left", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ["facebook", "twitter", "linkedin", "pinterest", "email"]},"image":"true"};
	//var st_hover_widget = new sharethis.widgets.hoverbuttons(options);
	});
</script>

<!-- Google Analytics code starts --> 
<!--<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33321910-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>-->
	<?php 
		/* We are call this function for restrict the user, user can not login
		*  more than with 1 browser simanteously.
		*/
		$this->commonmodel->check_browser_login();
    ?>
<?php //$this->output->enable_profiler(TRUE); ?>
<!-- Google Analytics code ends -->
	</body>
</html>