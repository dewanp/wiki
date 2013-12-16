<?php foreach($posts as $key =>$post){?>					
		
		<div class="searchdtl thumbview">
			 <div class="sdleft">
			<?php if($post['post_image']){?>
				<div class="thumb" id="tbl-post-img-<?php echo $post['post_image']?>"><script> showImage('<?php echo $post['post_image']?>','148','120','tbl-post-img-<?php echo $post["post_image"]?>');</script></div>
			<?php }else{?>
				<div class="thumb"><img src="images/thumbview3.jpg" alt="" /></div>
			<?php }?>
			</div>
			<div class="sdright">
				<h3>
				<?php 
					$tab_title = strlen($post['title']) < 35 ? $post['title'] : substr($post['title'],0,35)."..";
					echo anchor(getPostUrl($post['post_id']),$tab_title);
				?>
				</h3>
				
				<div class="by"><b>By:</b> <a href="javascript:void(0);"><?php if($post['profile_name']) echo $post['profile_name']; else echo $post['user_name'];?></a> at <?php echo date("M d,Y",$post['created_date'])?></div>
			</div>
			<span class="or-icons"><img src="images/icon2.png" alt="" /></span>
		</div>
	
<?php }?>
