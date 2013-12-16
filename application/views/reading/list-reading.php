<?php foreach($posts as $post){?>
	<div class="searchdtl active">
		<div class="sdleft">
			<?php if($post['post_image']){?>
				<div class="thumb" id="post-img-<?php echo $post['post_image']?>"><script> showImage('<?php echo $post['post_image']?>','111','90','post-img-<?php echo $post["post_image"]?>');</script></div>
			<?php }else{?>
				<div class="thumb"><img src="images/sdtldummy.jpg" alt="" /></div>
			<?php }?>
		</div>
		<div class="sdright">
			<h3>
				<?php 
					$list_title = strlen($post['title']) < 70 ? $post['title'] : substr($post['title'],0,70)."..";
					echo anchor(getPostUrl($post['post_id']),$list_title);
				?>
			</h3>
			<p>
				<?php 
					$list_desc = strlen($post['description']) < 200 ? $post['description'] : substr($post['description'],0,200)."..";
					echo $list_desc;
				?>
			</p>
			<div class="by">By: <a href="javascript:void(0);"><?php if($post['profile_name']) echo $post['profile_name']; else echo $post['user_name'];?></a> at <?php echo date("M d,Y",$post['created_date'])?></div>
		</div>
		<span class="or-icons"><img src="uploads/post-type/dd-img-<?php echo $post['category_id'];?>.png" alt="" /></span>
	</div>
<?php }?>
