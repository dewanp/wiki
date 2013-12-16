<!--[if lt IE 8]><style>
.searchdtl.thumbview .sdleft .thumb span {
    display: inline-block;
    height:65%;
}
</style><![endif]-->
<?php if(!empty($videos)){?>
<div class="thumbview-rows">
	<?php 
	$exist_post = array();
	$count = 0; 
	foreach($videos as $video)
	{ 
		if(array_key_exists($video['post_id'], $exist_post)){
			$p_url = $exist_post[$video['post_id']];
		}else{
			$p_url = getPostUrl($video['post_id']);	
			$exist_post[$video['post_id']] = $p_url;
		}
	?>
		<div class="searchdtl thumbview">
        
			<div class="sdleft" style="cursor:pointer;" onClick="window.location.href='post/show/video/<?php echo $video['video_id']?>'">
				<?php if($video['type']== 'video/youtube'){?>	
				<div class="thumb" id="vdo-<?php echo $video['file_upload_id']?>">
                	<span></span>
					<img src="http://img.youtube.com/vi/<?php echo $video['file_name'];?>/1.jpg" alt="" width="113" height="72" class="image"/>
				</div>
				<?php }else{?>
				<div class="thumb" id="vdo-<?php echo $video['file_upload_id']?>">
                <?php $video_base_path = S3_URL.BUCKET_NAME.'/uploads/'.$video['file_path'];?>
					<img src="<?php echo $video_base_path;?>.jpg" alt="" width="113" height="72" class="image"/>
				</div>
				<?php }?>
			</div>
            
            
			<div class="sdright">
			   	<h5><?php echo $video['title'];?></h5>
				<div class="by">
                    <b>Posted By:</b> 
                    <a href="<?php echo site_url($video['user_name'])?>"><?php if($video['profile_name']) echo $video['profile_name']; else echo $video['user_name'];?></a>
                </div>
				<?php echo anchor($p_url,'View Entire Post','class="btngrey"');?>
			</div>
            
		</div>
	<?php 
		$count++;
		if($count%4 == 0 && $count<count($videos))
		{
			echo '</div><div class="thumbview-rows">';
		}
	}
	?>
</div>
<?php }else{?>
	<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
<?php }?>


