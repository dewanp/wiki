<?php if(!empty($posts)){?>
<div id="loadmorepost">
	<?php foreach($posts as $post){?>
        <!--Post-block Start -->
        <div class="feeds-main-block">
            <div class="feed-thm" id="post-img-<?php echo $post['post_image']?>"><script> showImage('<?php echo $post["post_image"]?>','90','91','post-img-<?php echo $post["post_image"]?>');</script></div>
            <div class="feeds-content"> <span class="title"><?php echo anchor(getPostUrl($post['post_id']),$post['title'])?></span>
            <div class="fee-post-content">
            <?php 
            echo $description = (strlen($post['description'])<300)? $post['description']: substr($post['description'],0,300)." ...." ;
            ?> 
            
            </div>
            <?php if($all_post == "active"){ ?>
                <div class="by">
                    <b>Posted By:</b> 
                    <a href="<?php echo site_url($post['user_name'])?>"><?php if($post['profile_name']) echo $post['profile_name']; else echo $post['user_name'];?></a> at 
                    <b><?php echo date("M d,Y",$post['created_date'])?></b>
           		</div>                                               
                <?php }?>
            </div>
        </div>
        <!--Post-block End -->
    <?php }?>
	</div>
	<?php }?>
    
    <?php if(!empty($posts) && count($posts) >= 10){ ?>
         <div class="txtshow showmore" id="show-post-more"> 
            <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreUserProfile('<?php echo $post['user_id']; ?>', '');"> 
            <span class="txtload">Show more</span> <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a> 
       </div>
    <?php }else if(empty($posts) && count($posts) == 0){?>
    	 <div class="feeds-main-block" id="allposts">
       <div class="zipmessage"><div class="infoleft" style="width:96%;"><span class="icon"></span> At this moment the user is writing a post which may not be published. So please hold on as this page is populated by the user. <?php echo anchor("post/showposts/all","All Post!");?></div></div>    
    </div>
    <?php }else{?>
    	<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
    <?php }?>
	