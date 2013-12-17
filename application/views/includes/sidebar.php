
<script  type ="text/javascript">
$(document).ready(function(){
	$.ajax({
		  type: "post",
		  url : "user/countfollowingyou" ,
		  success : function(data)
		  {
			var num = data.split("/");
			$('#follower').html(" ( "+num[0] +" )");
			$('#following').html(" ( "+num[1]+" )");
			$('#unread_count').html(" ( "+num[2]+" )");
		  }
	});
});
</script>


<div class="left-content">
	<?php if($this->commonmodel->isLoggedIn()){?>
	<div class="user-detail">
		<div class="user-thmb" id="sidebar-user-image">
			<script> showImage('<?php echo $this->session->userdata("picture");?>','50','50','sidebar-user-image');</script>
		</div>
		<div class="details" style="margin-top:10px;"><?php echo $this->session->userdata("profile_name");?></div>
	</div>
		 <?php $status =  $this->commonmodel->getUserStatus($this->user_id);?>
         
		 <?php if($status == 'exist'){?>
            <div class="crepostmain">
                <?php echo anchor('post/add','<span class="cpicon"></span>Create a Post','class="btn-createpost" style="margin-left:15px;"');?>
            </div>
        <?php }?>
        
	<?php }?>
	
	<?php if(!empty($post_capsule_list)){?>
	<div class="blocks">
		<?php echo $post_capsule_list;?>
	</div>
	<?php }?>
	
	<div class="left-nav-wrapper normal">
		<?php if(isset($most_posted_users) && !empty($posts)){?>
        
		<div class="crepostmain">
		</div>
		<?php }?>
		
         <div class="nav-links helps crepostmain">
                <h2 class="title"><?php echo anchor('post/allcategories','<strong>View All Categories</strong>');?></h2><h2 class="title"><?php echo anchor('post/displayEditCategory','<strong>Create Category</strong>');?></h2>
         </div>
		<?php /*?><?php $statusread =  $this->commonmodel->getUserStatusRead($this->user_id);?>
        <?php if($statusread == 'exist'){?>
            <div class="nav-links helps crepostmain">
                <h2 class="title"><?php echo anchor('post/allcategories','<strong>View All Categories</strong>');?></h2>
            </div>
        <?php }?><?php */?>
		
		<div class="left-nav-main"> 
        </div>  
	</div>
</div>
