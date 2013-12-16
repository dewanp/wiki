<div id="wrapper" class="viewpage">
  <div class="container">
  <div class="rightmain">
    <!-- <div class="breadcrumb"> 
    </div> -->
    <div class="rightinner">
   
		<div class="btnbox btnbox2">
			<?php if($abused){?>
				<a href="javascript:void(0);" onClick="resumeBlockedPosts('<?php echo $post_id?>');" class="btnorange" style="padding-left:15px;">Not an abuse</a>
			<?php }?>
			<?php if($post['is_block']){?>
				<a href="javascript:void(0);" onClick="resumeBlockedPosts('<?php echo $post_id?>');" class="btnorange" style="padding-left:15px;">Resume Post</a>
			<?php }else{?>
				<a href="javascript:void(0);" onClick="blockPosts('<?php echo $post_id?>');" class="btnorange" style="padding-left:15px;">Block Post</a>
			<?php }?>
			<a href="javascript:back();" class="btnorange" style="padding-left:15px;">Back</a>
		</div>
      
		<div id="post-basic-info">
		
		<script>postBasicInfo('<?php echo $post_id?>','edit')</script>
		
		
		</div>
		
		<div id="capsule-wrapper">
			<script>
				updatePostCapsuleWrapper('<?php echo $post_id?>','edit')
			</script>
		</div>
     </div>
  </div>
  <div class="clear"></div>
  <script type="text/javascript">
  	
	$(window).bind("beforeunload", function(){
		var beforleav = false;
		$(".savecaps").each(function(){beforleav=true;});
		if(beforleav){
		return "This page is asking you to confirm that you want to leave - data you have entered may not be saved.";
		}
	});

	
</script>
</div>
</div>
