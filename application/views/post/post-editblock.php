<div id="wrapper">
  <div class="left-content-main"><?php echo $sidebar;?>  </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Post Edit</a></li>
      </ul>
    </div>
    <div class="rightinner">
     
		<div class="btnbox btnbox2">
		  <a href="<?php echo getPostUrl($post_id);?>" class="btngrey">View</a>
		  <a href="<?php echo site_url('post/preview/'.$post_id);?>" class="btngrey">Preview</a>
		  <a href="<?php echo site_url('post/edit/'.$post_id);?>" class="btngrey">Edit Content</a> 
		  <a href="<?php echo site_url('post/editblock/'.$post_id);?>" class="btnorange">Edit Blocks</a> 
		  <a href="<?php echo site_url('post/mypost');?>" class="btngrey">My Post</a>
		  
		</div>
      
		<div id="post-basic-info"> 
			<script>	
				postBasicInfo('<?php echo $post_id?>','editblock')
			</script>
		</div>

		<div id="capsule-wrapper">
			<script>
				updatePostCapsuleWrapper('<?php echo $post_id?>','editblock')
			</script>
		</div>
    </div>
  </div>
  <div class="clear"></div>
</div>