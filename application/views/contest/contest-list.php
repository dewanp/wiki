<div id="wrapper">
<div class="view-run-contest">
  <div class="left-content-main"> <?php echo $sidebar;?> </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li> <?php echo anchor('contest/contestlist','Home'); ?> </li>
        <li id="feedTextContest"><a href="javascript:void(0);" class="active">Running Contests</a></li>
      </ul>
    </div>
    <div class="rightinner">
      <!--Ink-Smash-dashboard-normal-user -->
      <div class="account-sec-tab">
        <div class="account-info-tab">
          <div class="float active" id="runningactive"> <span class="back"></span> <span class="mid"><a href="javascript:void(0);" onclick="contestPage('runningcontest');">Now Running</a></span> <span class="front"></span> </div>
          <div class="float" id="overactive"> <span class="back"></span> <span class="mid"><a href="javascript:void(0);" onclick="contestPage('overcontest');">Contest which are over</a></span> <span class="front"></span></div>
        </div>
      </div>
      <div class="usder-dashboard" id="user-dashboard">
        <div class="network-feed-block">
          <!-- load feeds wrapper here -->
		<div id="load_more_feeds">
			<?php $this->load->view('contest/contest-wrapper'); ?>
		</div>
       
        </div>
	       
	  <?php if(!empty($posts) && count($posts) >= 10 ) { ?>
        <div class="txtshow showmore" id="show-post-more">
            <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreContest('runningcontest');">
            <span class="txtload">Show more</span> 
            <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a> 
        </div>
	  <?php }elseif(count($posts) != 0){?>
      		<div class="searchdtl" style="background-color:#F1F4F8;">There are no more Running Contest available right now for you.</div>
      <?php }?>
	  
	  <?php if(empty($posts) && count($posts) == 0) { ?>
		<div style="padding: 15px;">
			<div id="zip-info-box" class="info-block">
				<span class="info-show"> There are no Contest available right now for you.</span>
			</div>
		</div>
	  <?php }?>
      
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>
</div>