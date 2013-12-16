<div id="wrapper">
   <div class="view-run-contest"> <div class="left-content-main">
        <div class="left-content">
            <?php echo $sidebar;?>
        </div>
        
    </div>
    <div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li> <?php echo anchor('contest/contestlist','Home'); ?> </li>
                <li><a href="javascript:void(0);" class="active">Contest</a></li>
            </ul>
        </div>        
        <div class="rightinner">
           <div class="titlesec"><h1 class="orangetitle-f20"><?php if($posts['status'] == 1) { echo  "Now Running";} else{ echo "Contest Over";} ?></h1>
        		</div>
                <div class="now-run-dtls">
                <div class="feeds-main-block">
                        <div class="feed-thm" id="post-img-<?php echo $posts['contest_image']?>">
                        	<?php if($posts['contest_image'] != ''){?>
                                <img src="images/loader.gif" alt= "" >
                                <script> showImage('<?php echo $posts['contest_image']?>','90','90','post-img-<?php echo $posts["contest_image"]?>');</script>
                            <?php }else {?>
                                <img src="images/view-contest.jpg" alt= "No image">
                            <?php }?>
                        
                        </div>
                        <div class="feeds-content">
                        <span class="title">
							<?php echo anchor(getContestUrl($posts['contest_id'], $type = 1),$posts['title']);?>
							<?php //echo $posts['title']?>
                        </span>
                            <div class="fee-post-content">
                            	<?php echo $posts['description']; ?>
                            </div>
                            
                            <div class="post-by-block">
                                <ul>
                                    <li> <a href="javascript:void(0);"><span>Price : </span>$ <?php echo number_format($posts['prize'],2);?></a></li>
                                    
                                    
									<?php if(isset($posts['user_ids']) && !empty($posts['user_ids'])) {?>
                                    	<li><span>Winner List : </span>
									<?php $explode_arr = explode(",", $posts['user_ids']);  
											if(isset($explode_arr) && !empty($explode_arr)) {              
                                          foreach( $explode_arr as $key=>$val)
                                          {
                                                $sql = " SELECT u.* FROM user AS u where u.user_id = $val AND u.is_active = 1";
                                                $result = $this->db->query($sql);
                                                $userstring = $result->result_array();
                                    ?>
                                        <a href="<?php echo site_url($userstring[0]['user_name'])?>" hidefocus="true" style="outline: medium none; display:inline; background-image:none; padding-left:0;"><?php echo ucfirst($userstring[0]['user_name']);?></a> ,
                                    <?php }
										}?>
                                        </li>
                                   		<li> <a href="contest/viewwinners/<?php echo $posts['unique_contest_token'];?>">View All</a></li>
                                    <?php }?>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                <div class="feeds-main-block">
                        <div class="feeds-content w100per"> <span class="orangetitle-f20">Parameters of the contest</span>                            
                            <ul class="runlist">
                            <?php $expl_para = explode("|--|",$posts['parameters']);
								foreach($expl_para as $val){
							?>
                            <li><?php echo $val; ?></li>
                            <?php }?>
                            </ul>
                        </div>
                    </div>
                <!--feedds winner statr-->
                 <div class="feeds-main-block">
                 	<div class="winner-list">
                 
				  	<div class="feeds-content w100per"> <span class="orangetitle-f20">List of winners</span>
                    		<?php if($posts['status'] == 1){?>
                           <div class="searchdtl" style="background:#F1F4F8 !important;">We're still looking out for the winners in this space. Those who wish to participate need to <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
                           <?php }else{ ?>
                           <div class="searchdtl" style="background:#F1F4F8 !important;">This Contest is over now. You can participate in other contest. For this you need to <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
                           <?php }?>
                         
                        <?php if(isset($posts['user_ids']) && !empty($posts['user_ids'])) {?> 
                        <?php $explode_posts_arr = explode(",", $posts['post_ids']); 
							  if(isset($explode_posts_arr) && !empty($explode_posts_arr)){
							  foreach( $explode_posts_arr as $key=>$val)
							  {
									$sql = " SELECT p.*,
											 (SELECT u.picture FROM user AS u WHERE u.user_id = p.user_id) AS picture_id
											  FROM post AS p
											  WHERE p.post_id = ".$val." AND p.is_block = 0 AND p.is_active = 1";
									$resultpost = $this->db->query($sql);
									$poststring = $resultpost->row_array();
						?>
                        
                        
                        <?php if(!empty($poststring)) {?> 
                            <div class="feeds-main-block">
                                    <div class="feed-thm1" id="post-img-<?php echo $poststring['picture_id']?>">
                                    	<?php if($poststring['picture_id'] != ''){?>
                                           <img src="images/loader.gif" alt= "" >
                                			<script type="text/javascript">showImage('<?php echo $poststring["picture_id"]?>','50','50','post-img-<?php echo $poststring["picture_id"]?>');</script>
                                        <?php }else {?>
                                            <img src="images/thumbs/no-image110x110.jpg" alt= "No image" height="50" width="50">
                                        <?php }?>
                                    </div>
                                    
                                    <div class="feeds-content">
                                    <span class="title" style="margin-left:5px;">
                                        <?php 
                                            $list_title = strlen($poststring['title']) < 70 ? $poststring['title'] : substr($poststring['title'],0,70)."..";
                                            echo anchor(getPostUrl($poststring['post_id']),$list_title);
                                        ?>
                                    </span>
                                    
                                    <div class="wprice"><img src="images/winner-thumb.png" alt=""></div>
                                        <div class="fee-post-content" style="margin-left:5px;">
                                            <?php echo $list_descr = strlen($poststring['description']) < 250 ? $poststring['description'] : substr($poststring['description'],0,250).".."; ?>
                                        </div>
                                    </div>
                            </div>
                        <?php }?>
						<?php } }?>
                        <?php }?>
                        </div>
                       
                       </div>
                    </div>
                    <!--feedds winner end-->
                        
                </div>
        </div></div>
    </div>
    <div class="clear"></div>
</div>