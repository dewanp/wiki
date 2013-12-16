<div class="network-feed-block"> 
	<div id="load_more_feeds">
	<?php foreach($posts as $key=>$post){?>
	
	<!--Post-block Start -->
	<div class="feeds-main-block">
		<div class="feed-thm" id="post-img-<?php echo $post['post_id']?>">
		<img src="images/loader.gif" alt= "" >
		<script> showImage('<?php echo $post['post_image']?>','90','90','post-img-<?php echo $post["post_id"]?>');</script></div>
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
         <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreUserFeeds('localfeeds');"><span class="txtload">Show more</span> 
         <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a> 
     </div>
<?php }else{?>
	<div class="searchdtl">There are no more Local Feeds available right now for you. Create another one for this <?php echo anchor('post/add/localpost','Create Post','class="btnorange" style="float:none;"')?></div>
<?php }?>
<?php if(empty($posts) && count($posts) == 0) { ?>
	<div style="padding: 15px;">
        <div id="zip-info-box" class="info-block test">	
                <span class="info-show">No Local Feeds available right now for you. You may <?php echo anchor('post/add/localpost','Create a local post');?> and be the first one to let the world know about your area.</span>
        </div>
    </div>
<?php }?>