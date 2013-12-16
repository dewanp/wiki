<div class="titlebox mart20">
	<div class="tleft">
		<div class="thumb left" id="post-img"><script> myShowImage('<?php echo $post["post_image"];?>','102','127','post-img');</script></div>		
	</div>
	<div class="tright">
		<h2><span class="txtorange"><?php echo $post['title']?></span></h2>
		<div class="tag">
		<img src="images/item-icon.png" alt="" /> 
		<?php $tag_array= array(); foreach($tags as $tag){ $tag_array[] = $tag['name'];} echo implode(", ",$tag_array);?>
		</div>
	</div>
	<?php echo $post['description']?>
</div>
