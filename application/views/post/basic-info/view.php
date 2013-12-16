<div class="titlebox mart20">
	<span id="ratingPost<?php echo $post_id?>" class="right"><script>loadRatingPost('<?php echo $post_id?>', true,'<?php echo $ip_address ?>');</script></span>
	<!--<div class="tleft">
		<div class="thumb left" id="post-img">
		<span> <img src="images/loader.gif" alt= "" ></span>
		<script> showImage('<?php echo $post["post_image"];?>','123','100','post-img');</script></div>		
	</div>-->
	<div class="tright" style="margin:-17px 0 8px 0; width:735px;">
		
		<h2><span class="txtorange"><?php echo $post['title']?></span></h2>
		
		<?php /*?><div class="tag">
            <img src="images/item-icon.png" alt="" /> 
            <?php $count = count($tags);?>
				<?php $i =1; ?>
                <?php 
					foreach($tags as $tag)
                	{
                    	if($tag['name'] != '')
						{
                ?> 
                            <a href="<?php echo base_url(); ?>post/tag/<?php echo url_title($tag['name'])?>">
                                <?php echo $tag['name']; if($count == $i) echo'.'; else echo ', ';?>
                            </a>
                <?php 	} 
				 		$i++;  
				 	}  
				?>		
		</div><?php */?>
	</div>
    <br />
	<!-- author name and created date of this post -->
		<div class="by"><b>Posted By:</b> <a href="<?php echo site_url($user_info['user_name'])?>"><?php if($user_info['profile_name']) echo $user_info['profile_name']; else echo $user_info['user_name'];?></a> at <b><?php echo date("M d,Y",$post['created_date'])?></b></div>
	<?php if($post['local_post']){?>
	<div class="by">
		<b>City:</b> <?php echo $post['city']?> <b>State:</b> <?php echo $post['state']?>
	</div>
	<?php }?>
	<br>
	<div class="description">
		<p><?php echo $post['description']?></p>
	</div>
	
</div>