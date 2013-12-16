<div id="wrapper" >
   <div class="breadcrumb">   </div>
   <div class="container">
   <h2><?php // echo htmlentities($post['title'])?></h2> 
		<div class="titlebox mart20" style="padding-bottom:10px;">	
			<div class="postleft">
				<div class="thumb left" id="post-img-<?php echo $post['post_id'];?>">
					<?php $width = 350; ?>
					<?php $height = 300; ?>
					<script type="text/javascript">		
					myShowImage('<?php echo $post["file_upload_id"];?>','<?php echo $width ?>','<?php echo $height ?>','post-img-<?php echo $post["post_id"];?>')					</script>
				</div>		
			</div>
			<div class="postright">
				<p>Post title: <span class="txtorange"><?php  echo $post['title']?></span></p>
				<div class="description">
					<p>Description :<?php  echo $post['description']?></p>
				</div>
			</div>
		</div>
		<div id="image">
			<!-- Images uploaded in this post -->
			 <?php foreach($image as $row) { ?>
					<div class="clear"></div>
					<div class="divider"> </div>
					<div style="float:left;">
					<div id="image-<?php echo $row['file_upload_id'];?>" class="image_sep">
							<script type="text/javascript">	myShowImage('<?php echo $row["file_upload_id"];?>', '350', '300', 'image-<?php echo $row["file_upload_id"];?>');</script>
					</div>
					<div style="float:right;  margin: 20px 0 0 50px; width:530px;">
						<span class="txtorange"> <?php echo $row['title']; ?> </span>
						<p> <?php echo $row['description']; ?></p>
					</div>
					</div>
			<?php } ?>
		</div>
<!-- View Video uploaded in this post -->
         <div id="video">
			 <?php foreach($video as $video_row) { $src = str_replace('./','./../',$video_row['file_path']); ?>
			        <br> <hr> <br>
					<div class="clear"></div>	
					<div id="cur-video-id-<?php echo $video_row['file_upload_id']?>" >
						<script >
							showvideo("cur-video-id-<?php echo $video_row['file_upload_id']?>",site_url+"<?php echo $src ;?>")
						</script>
					</div>					
			<?php } ?>
		 </div>
	</div>
	<div class="clear"></div>
</div>


<!-- <div id="main">
	<div id="left">
	</div>
	<div id="right">
	   <div id="right_top">
	   </div>
	   <div id="right_bottom">
	   </div>
	</div>
</div> -->