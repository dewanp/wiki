<div class="left-content">
	<?php if($this->commonmodel->isLoggedIn()){?>
	<div class="user-detail">
		<div class="user-thmb" id="sidebar-user-image">
			<script> showImage('<?php echo $this->session->userdata("picture");?>','50','50','sidebar-user-image');</script>
		</div>
		<div class="details"><?php echo $this->session->userdata("profile_name");?><br /><span>NewYork</span></div>
	</div>
	<?php }?>
	<div class="left-nav-wrapper">
		<div class="left-nav-main">
			<?php if($this->commonmodel->isLoggedIn()){?>
			<a href="javascript:void(0);" class="active"  onclick="$('#all-links').slideToggle();$(this).toggleClass('active');">Hide All Menu Items</a>
			<div class="all-links" id="all-links">
				<?php if($profile_links){?>
				<?php echo $profile_links?>
				<?php }?>
			</div>
			<?php }?>
			
			<?php if(!empty($categories)){?>
				<div class="nav-links helps">
					<h2 class="title">Categories</h2>
					<ul>
						<?php foreach($categories as $category){?>
						<li><?php echo anchor('post/category/'.$category['category_id'],$category['name']);?></li>
						<?php }?>
					</ul>
				</div>
			<?php }?>	
		</div>
	</div>
	<?php if($post_capsule_list){?>
				<div class="blocks">
				<?php echo $post_capsule_list;?>
				</div>
			<?php }?>
	<div class="advertise"><img src="images/advertise.jpg" alt="" /></div>
</div>
