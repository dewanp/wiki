<!-- Feeds Wrapper -->
<?php if(!empty( $posts)){?>
	<?php foreach($posts as $key=>$post){?>
	<!--Post-block Start -->
	<div class="feeds-main-block">
		<div class="feed-thm" id="post-img-<?php echo $post['post_image']?>" > 
		<img src="images/loader.gif" alt= "" >
		<script> showImage('<?php echo $post['post_image']?>','90','90','post-img-<?php echo $post["post_image"]?>');</script></div>
		<div class="feeds-content"> <span class="title"><?php 
						$list_title = strlen($post['title']) < 70 ? $post['title'] : substr($post['title'],0,70)."..";
						echo anchor(getPostUrl($post['post_id']),$list_title);
					?></span>
			<div class="fee-post-content">
				<?php 
					echo $description = (strlen($post['description'])<300)? $post['description']: substr($post['description'],0,300)." ...." ;?>
			</div>
			
			<div class="by"><b>Posted By:</b> <a href="<?php echo site_url($post['user_name'])?>"><?php if($post['profile_name']) echo $post['profile_name']; else echo $post['user_name'];?></a> at <b><?php echo date("M d,Y",$post['created_date'])?></b></div>
		</div>
	</div>
	<!--Post-block End --> 	
	<?php }?>
<?php } ?>