	<div id="wrapper">
    	<div class="left-content-main">
        	<?php echo $sidebar;?>
        </div> 
        <div class="rightmain">
        <div class="breadcrumb">
          <span class="arrowleft"></span>
          <ul>
          <li><a href="javascript:void(0);">Home</a></li>
          <li><a href="javascript:void(0);" class="active">My Account</a></li>
          </ul>
          </div>
          <div class="rightinner">
          <!--Account Section Start -->
          	<div class="account-sec-tab">
            	<div class="account-info-tab">
                <div class="float">
                    <span class="back"><span class="unlimited"></span></span>
                    <span class="mid"><?php echo anchor('user/myprofile','Account Information');?></span>
                    <span class="front"></span>
                </div>
                <div class="float  active">
                    <span class="back"></span>
                    <span class="mid">
					<?php echo anchor('page/myearningaccount','My Earning Account'); ?>
					</span>
                    <span class="front"></span>
                </div>
                <div class="float">
                    <span class="back"></span>
                    <span class="mid">
 					<?php echo anchor('page/mysetting','My Setting'); ?></span>
                    <span class="front"></span>
                </div>
    		</div>
            </div>
			<!-- new under construction bar start -->

				<div class="logsignbox">
					<div class="loginmain error404main">
						<h2>We're Currently Under Construction</h2>
						<span class="error404"><img src="images/constructbar.jpg" width="614" height="35" alt="" /></span>
					</div>
				</div>
			
		<!-- new under construction bar end -->
			
          </div>
          </div>
        <div class="clear"></div>
    </div>

	
