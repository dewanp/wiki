<div id="wrapper">
  <div class="left-content-main"> <?php echo $sidebar;?> </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li> <?php echo anchor('user/feeds','Home'); ?> </li>
        <li id="feedText"><a href="javascript:void(0);" class="active">Network Feeds</a></li>
      </ul>
    </div>
    <div class="rightinner">
      <!--Ink-Smash-dashboard-normal-user -->
      <div class="account-sec-tab">
        <div class="account-info-tab">
          <div class="float active"> <span class="back"></span> <span class="mid"><a href="javascript:void(0);" onclick="userPage('networkfeeds');">Network feeds</a></span> <span class="front"></span> </div>
          <div class="float"> <span class="back"></span> <span class="mid"><a href="javascript:void(0);" onclick="userPage('localfeeds');" id="localfeedstab">Local feeds</a></span> <span class="front"></span> </div>
        </div>
      </div>
      <div class="usder-dashboard" id="user-dashboard">
        <div class="network-feed-block">
          <!-- load feeds wrapper here -->
		<div id="load_more_feeds">
			<?php $this->load->view('user/feeds-wrapper'); ?>
		</div>
       
        </div>
	  <?php if(!empty($posts) && count($posts) >= 10) { ?>
        <div class="txtshow showmore" id="show-post-more">
            <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreUserFeeds('networkfeeds');">
            <span class="txtload">Show more</span> 
            <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a> 
        </div>
	  <?php }else{?>
      	<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
      <?php }?>
	  <?php if(empty($posts) && count($posts) == 0) { ?>
		<div style="padding: 15px;">
			<div id="zip-info-box" class="info-block">
				<span class="info-show">No Network feeds available right now for you. To start viewing more feeds in this area you need to follow other users. For that <?php echo anchor('user/search','search for users');?> and then start following. Or You can look for certain content and follow users from there.</span>
			</div>
            
		</div>
	  <?php }?>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
