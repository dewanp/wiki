<div class="titlebox mart20">
	<div class="tleft">
		<div class="thumb left" id="post-img"><script> showImage('<?php echo $post["post_image"];?>','123','100','post-img');</script></div>		
	</div>
	<div class="tright">
		<h2>Our beloved earth - <span class="txtorange"><?php echo $post['title']?></span></h2>
		
		<a href="javascript:void(0);" class="edit mar0" onclick="postBasicInfo('<?php echo $post_id?>','edit');"></a>
		
		<div class="tag">
		<img src="images/item-icon.png" alt="" /> 
		<?php $tag_array= array(); foreach($tags as $tag){ $tag_array[] = $tag['name'];} echo implode(", ",$tag_array);?>
		</div>
	</div>
	<?php echo $post['description']?>
</div>
