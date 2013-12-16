<div id="wrapper">
  <div class="left-content-main"><?php echo $sidebar;?>  </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Post view</a></li>
      </ul>
    </div>
    <div class="rightinner">
     
	 <div class="btnbox btnbox2">
		  <a href="<?php echo site_url('post/publish/'.$post_id);?>" class="btngrey">Publish</a>
          <a href="<?php echo site_url('post/edit/'.$post_id);?>" class="btngrey">Back</a>		  
	 </div>
           
	  <div id="post-basic-info"> 
			<script>	
				postBasicInfo('<?php echo $post_id?>','preview')
			</script>
		</div>

		<div id="capsule-wrapper">
			<script>
				updatePostCapsuleWrapper('<?php echo $post_id?>','preview')
			</script>
		</div>
        
        <div class="btnbox btnbox2" style="border-top: 1px solid hsl(0, 0%, 87%);border-bottom: none;">
		  <a href="<?php echo site_url('post/publish/'.$post_id);?>" class="btngrey">Publish</a>
          <a href="<?php echo site_url('post/edit/'.$post_id);?>" class="btngrey">Back</a>		  
	 </div>
    </div>
  </div>
  <div class="clear"></div>
</div>