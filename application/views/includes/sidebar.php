<div class="left-content">
	<?php if($this->commonmodel->isLoggedIn()){?>
	<div class="user-detail">
		<div class="user-thmb" id="sidebar-user-image">
			<script> showImage('<?php echo $this->session->userdata("picture");?>','50','50','sidebar-user-image');</script>
		</div>
		<div class="details" style="margin-top:10px;"><?php echo $this->session->userdata("profile_name");?></div>
	</div>
	<?php }?>
	
	<div class="left-nav-wrapper normal">
     
     <div class="nav-links helps crepostmain">
            <h2 class="title border-none">
                <?php echo anchor('post/allcategories','<strong>View All Categories</strong>');?>
            </h2>
     </div>
		
		<div class="left-nav-main"> 
        </div>  
	</div>
</div>