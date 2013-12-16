<!--[if lt IE 8]><style>
.searchdtl.thumbview .sdleft .thumb span {
    display: inline-block;
    height:65%;
}
</style><![endif]-->
<?php if(!empty($images)){?>
<div class="thumbview-rows">
	<?php 
	$count = 0;
	$exist_post = array();
	
	foreach($images as $image)
	{
		if(array_key_exists($image['post_id'], $exist_post)){
			$p_url = $exist_post[$image['post_id']];
		}else{
			$p_url = getPostUrl($image['post_id']);	
			$exist_post[$image['post_id']] = $p_url;
		}
	?>
		<div class="searchdtl thumbview">
			<div class="sdleft" style="cursor:pointer;" onClick="window.location.href='post/show/image/<?php echo $image['image_id']?>'">
				<div class="thumb" id="img-<?php echo $image['file_upload_id']?>"><span><img src="images/loader.gif" alt= ""/></span>
					<script> showImage('<?php echo $image['file_upload_id']?>','148','120','img-<?php echo $image["file_upload_id"]?>');</script>
                </div>
			</div>
			<div class="sdright">
			   <h5><?php echo $image['title'];?></h5>
				<div class="by"> <b>Posted By:</b> 
                	<a href="<?php echo site_url($image['user_name'])?>"><?php if($image['profile_name']) echo $image['profile_name']; else echo $image['user_name'];?></a>
                </div>
                <?php echo anchor($p_url,'View Entire Post','class="btngrey"');?>
               
                
			</div>
		</div>
	<?php 
		$count++;
		if($count%4 == 0 && $count<count($images))
		{
			echo '</div><div class="thumbview-rows">';
		}
	}
	?>
</div>
<?php }else{?>
		<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
<?php }?>