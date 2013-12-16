<div class="network-feed-block"> 
	<div id="load_more_feeds">
	<?php foreach($posts as $key=>$post){?>
	
	<!--Post-block Start -->
	<div class="feeds-main-block">
		<div class="feed-thm" id="post-img-<?php echo $post['contest_image']?>">
			 <?php if($post['contest_image'] != ''){?>
                <img src="images/loader.gif" alt= "" >
                <script> showImage('<?php echo $post['contest_image']?>','90','90','post-img-<?php echo $post["contest_image"]?>');</script>
            <?php }else {?>
                <img src="images/view-contest.jpg" alt= "No image">
            <?php }?>
        </div>
        
		<div class="feeds-content">
        <span class="title">
						<?php 
                               $list_title = strlen($post['title']) < 70 ? $post['title'] : substr($post['title'],0,70)."..";
                               echo anchor(getContestUrl($post['contest_id'],$type = 0),$list_title);
                        ?>
      	</span>
			<div class="fee-post-content">
			<?php 					
					if(strlen(strip_tags($post['description'])) <= 400 ){
						$list_description = $post['description'];
					}else{
						$list_description = substr(strip_tags($post['description']), 0, 400);
						$list_description .= "....";	
					}					
					echo $list_description;
			?>
            </div>
			<div class="price">$ <?php echo number_format($post['prize'],2);?></div>
            
            <?php if(isset($posts['user_ids']) && !empty($posts['user_ids'])) {?>
                    <div class="post-by-block">
                        <ul>
                            <li><span>Winner List : </span>
                			<?php $explode_arr = explode(",", $post['user_ids']);                
                				  foreach( $explode_arr as $key=>$val)
								  {
                    					$sql = " SELECT u.* FROM user AS u where u.user_id = $val";
                   						$result = $this->db->query($sql);
                    					$userstring = $result->result_array();				
                 			?>
                    			<a href="<?php echo site_url($userstring[0]['user_name'])?>" hidefocus="true" style="outline: medium none; display:inline; background-image:none; padding-left:0;"><?php echo ucfirst($userstring[0]['user_name']);?> </a> ,
                			<?php }?>
                    		</li>
                     		<li><a href="contest/viewwinners/<?php echo $post['unique_contest_token'];?>" hidefocus="true" style="outline: medium none;">View All</a></li>
                    	</ul>
                    </div>
            <?php }?>
            
		</div>
	</div>
	<!--Post-block End --> 	
	<?php }?>
	 </div>
</div>
<?php if(!empty($posts) && count($posts) >= 10){ ?>
     <div class="txtshow showmore" id="show-post-more"> 
         <a href="javascript:void(0);" class="txtgrey" onclick="runningcontest('overcontest');"><span class="txtload">Show more</span> 
         <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a> 
     </div>
<?php }elseif(count($posts) != 0){?>
	<div class="searchdtl" style="background-color:#F1F4F8;">There are no more Over Contest available right now for you.</div>
<?php }?>
<?php if(empty($posts) && count($posts) == 0) { ?>
	<div style="padding: 15px;">
        <div id="zip-info-box" class="info-block test">	
                <span class="info-show">There are no more Over Contest available right now for you.</span>
        </div>
    </div>
<?php }?>