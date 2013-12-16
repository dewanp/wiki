<div class="titlebox mart20">
	<div class="tleft">
		<div class="thumb left" id="post-img">
		<img src="images/loader.gif" alt= "" >
		<script> showImage('<?php echo $post["post_image"];?>','123','100','post-img');</script></div>		
	</div>
	<div class="tright" style="margin-bottom:8px;">
		<h2><span class="txtorange"><?php echo $post['title']?></span></h2>
		<div class="tag">
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
         <?php  }		 
		 	  $i++;  		 
		 	} 
		 ?>
		</div>
	</div>
	<!-- author name and created date of this post -->
		<div class="by"><b>Posted By:</b> <a href="<?php echo site_url($user_info['user_name'])?>"><?php if($user_info['profile_name']) echo $user_info['profile_name']; else echo $user_info['user_name'];?></a> at <b><?php echo date("M d,Y",$post['created_date'])?></b></div><br>
	<?php echo $post['description']?>
</div>
