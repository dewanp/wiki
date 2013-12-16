	<?php if(!empty( $posts)){?>
	<?php $i = 1; foreach($posts as $post){?>
		<div class="searchdtl" id="div-id-<?php echo $i; ?>">
			<div class="sdleft">
				<?php if($post['post_image']){?>
					<div class="thumb" id="post-img-<?php echo $post['post_image']?>">
					<img src="images/loader.gif" alt= "" >
					<script> showImage('<?php echo $post['post_image']?>','111','90','post-img-<?php echo $post["post_image"]?>');</script></div>
				<?php }else{?>
					<div class="thumb">
                    <img width="90" height="90" alt="" src="images/thumbs/no-image110x110.jpg">
                    </div>
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
				<div class="by"><b>Posted By:</b> <a href="<?php echo site_url($post['user_name'])?>"><?php if($post['profile_name']) echo $post['profile_name']; else echo $post['user_name'];?></a> at <b><?php echo date("M d,Y",$post['created_date'])?></b> In <b><?php echo $post['category_name']?></b></div>
			</div>
           <?php $premission_array = array(); $permission = $this->commonmodel->check_permission($post['category_id'],$login_user_id);
		   			 if($permission){
		   ?>
			<span class="or-icons">
                <div class="makepostdd">
                    <a href="javascript:void(0);" class="arrowpost"></a>
                    <div class="mpddinner">
                        <div class="mptop"></div>
                        <div class="mpmid">
                          <ul>
                            <?php if($permission == 1){?>
                            
                            	<!--<li><?php echo anchor('post/add','Add Post' ,'class="edit"')?></li>-->
                                <li><?php echo anchor('post/edit/'.$post['post_id'],'Edit Post' ,'class="edit"')?></li>
                                <li><?php $p_url =  getPostUrl($post['post_id']); echo anchor($p_url,'View' ,'class="publish"')?></li>
                                <li><a href="javascript:void(0)" onclick="prepareConfirmPopup(this,'Are you sure?')" class="delete">Delete</a>
                                <div class="adl"><a href="javascript:void(0)" onclick="deletePost('<?php echo $post['post_id']?>'),hidePost('<?php echo 'div-id-'.$i; ?>')" class="btnorange">Yes</a></div></li>
                            <?php }elseif($permission == 2){?>
                            
                          		<!--<li><?php echo anchor('post/add','Add Post' ,'class="edit"')?></li>-->
                           	<li><?php $p_url =  getPostUrl($post['post_id']); echo anchor($p_url,'View' ,'class="publish"')?></li>
                                
                            <?php }elseif($permission == 3){?>
                            	<li><?php $p_url =  getPostUrl($post['post_id']); echo anchor($p_url,'View' ,'class="publish"')?></li>
                            <?php }?>
                          </ul>
                        </div>
                        <div class="mpbot"></div>
                    </div>
                </div>
            </span>
            <?php }?>
		</div>
		<div class="divider"></div>  
	<?php $i++; }?>
	<?php }else{?>
    	
	<?php }?>	