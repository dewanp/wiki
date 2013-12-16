<div id="wrapper">
    <div class="left-content-main">
        <div class="left-content">
            <div class="user-detail user-profile">
                <div class="user-thmb" id="sidebar-user-image">
					<script> showImage('<?php echo $user['picture']?>','180','180','sidebar-user-image');</script>
				</div>
				
                <div class="details">
				<span class="proname"><?php echo $user['profile_name']?></span> 
				
				<span class="dtlinfo"><?php echo $user['self_writeup']?></span>
                   
					
					<?php if($user['zip_code']){?>
					<div class="btngreylite"> <span class="zip">Zip Code:</span> <span class="number"><?php echo $user['zip_code']?></span> </div>
					<?php }?>
                    
                </div>
                 
            </div>
            <div class="left-nav-wrapper">
                <div class="left-nav-main">
                    <?php if(!empty($mostpost)){?>
					<div class="all-links" id="all-links">
                        <div class="nav-links posts">
                            <h2 class="title">Most Posts on</h2>
                            <ul>
                                <?php foreach($mostpost as $p){?>
								<li><?php echo anchor('post/searchCategoryPosts/'.ucfirst(strtolower($p['name'])),ucfirst(strtolower($p['name']))." (".$p['post_count'].")") ;?></li>
								<?php }?>
                                
                            </ul>
						</div>
                    </div>
					<?php }?>
                </div>
            </div>
        </div>
</div>
    <div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li><?php echo anchor('user/feeds','Home'); ?></li>
                <li id="feedText"><a href="javascript:void(0);" class="active">All Posts</a></li>
				<?php if($followthisuser){?><li style="float:right; background:none;"> 
        				<?php echo $followthisuser ?>
        		 </li><?php }?>
            </ul>
        </div>
        <div class="rightinner"><!--Ink-Smash-dashboard-normal-user -->
             <div class="account-sec-tab">
                <div class="account-info-tab">
                    <div class="float <?php echo $all_post; ?>">
						<span class="back"></span> 
						<span class="mid">
								<a href="javascript:void(0);" onclick="userPosts('allPosts','<?php echo $user_name; ?>','<?php echo $user['user_id']?>');">All Posts</a>
								<?php //echo anchor($user["user_name"],'All Posts');?>
                        </span> 
						<span class="front"></span>
					</div>
					<div class="float <?php echo $favorite;?> ">
						<span class="back"><span class="unlimited"></span></span> 
						<span class="mid">
							<a href="javascript:void(0);" onclick="userPosts('myFavorites','<?php echo $user_name; ?>','<?php echo $user['user_id']?>');">My Favorites</a>
							<?php //echo anchor($user["user_name"].'/favorites','My Favorites');?>
                        </span>
						<span class="front"></span>
					</div>
                </div>
            </div>
            <div class="usder-dashboard">
                <div class="network-feed-block" id="network-feed-block"> 
                  <!-- load view here -->
				  <div id="loadmorepost">
				  		<?php $this->load->view('user/user-profile-wrapper'); ?>
				  </div>
                </div>
            </div>
            	<?php  if(!empty($posts) && count($posts) >= 10) { ?>
                    <div class="txtshow showmore user_profile_class" id="show-post-more"> 
                        <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreUserProfile('<?php echo $user['user_id']; ?>', '<?php echo $favorite ;?>');"> 
                        <span class="txtload">Show more</span> <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a> 
                    </div>
				<?php }else if(empty($posts) && count($posts) == 0 ) { ?>
                    <div class="feeds-main-block" id="user_profile">
                           <div class="zipmessage"><div class="infoleft" style="width:96%;"><span class="icon"></span> At this moment the user is writing a post which may not be published. So please hold on as this page is populated by the user. <?php echo anchor("post/showposts/all","All Post!");?></div></div>    
                    </div>
	  			<?php }?>
            
            
            
            
            
            <!--Ink-Smash-dashboard-normal-user End --> 
        </div>        
    </div>
    <div class="clear"></div>
</div>