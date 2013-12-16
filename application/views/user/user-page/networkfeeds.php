<div class="network-feed-block"> 
	<div id="load_more_feeds">
	<?php foreach($posts as $key=>$post){?>
	
	<!--Post-block Start -->
	<div class="feeds-main-block">
		<div class="feed-thm" id="post-img-<?php echo $post['post_image']?>">
		<img src="images/loader.gif" alt= "" >
		<script> showImage('<?php echo $post['post_image']?>','90','90','post-img-<?php echo $post["post_image"]?>');</script></div>
		<div class="feeds-content"> <span class="title"><?php 
						$list_title = strlen($post['title']) < 70 ? $post['title'] : substr($post['title'],0,70)."..";
						echo anchor(getPostUrl($post['post_id']),$list_title);
					?></span>
			<div class="fee-post-content"><?php 
					if(strlen($post['description'])<300){	
						echo $post['description']; 
					}else{
						echo substr($post['description'],0,300)." ....";
					}?></div>
			<div class="by"><b>Posted By:</b> <a href="<?php echo site_url($post['user_name'])?>"><?php if($post['profile_name']) echo $post['profile_name']; else echo $post['user_name'];?></a> at <b><?php echo date("M d,Y",$post['created_date'])?></b></div>
		</div>
	</div>
	<!--Post-block End --> 
	<?php }?>
	 </div>
	  
</div>
<?php if(!empty($posts) && count($posts) >= 10){ ?>
    <div class="txtshow showmore" id="show-post-more"> 
        <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreUserFeeds('networkfeeds');"><span class="txtload">Show more</span> 
        <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a>
    </div>
 <?php }else{?>
 	<div class="searchdtl">There are no more Network feeds available right now for you. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
 <?php }?>

<?php if(empty($posts) && count($posts) == 0) { ?>
	<div style="padding: 15px;">
		<div id="zip-info-box" class="info-block">
				<span class="info-show">No Network feeds available right now for you. To start viewing more feeds in this area you need to follow other users. For that <?php echo anchor('user/search','Search for Users');?> and then start following. Or You can look for certain content and follow users from there.</span> 
		</div>
	</div>
<?php }?>