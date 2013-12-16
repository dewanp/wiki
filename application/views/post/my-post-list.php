<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb">
			<span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li>My Posts</li>
			</ul>
		</div>
		
		<div class="rightinner">
			
            <?php if(!$isZipCode) { ?>
                <div class="info-block" id="zip-info-box">	
					<span class="info-show">We need your zip code so that you help others know your area in case they wish to know. <a href="javascript:void(0);" class="click-enter-zip" onclick="openPopDiv('zip_code_div');">Click here to enter your zip code</a></span> 
				</div>
				<?php } ?>
			
			<?php if(!empty($posts)){?>   
			<div class="myposts">
				<div class="search">
					<div class="field">
						<form action="<?php echo site_url('post/mypost');?>" name="serach_post_by_title" method="get">
						<label for="search" class="infield">Search within your posts</label>
						<input name="search" type="text" id="search" class="inputmain" value="<?php echo $this->input->get('search','Search within your posts')?>" />
						<input type="submit" class="icon" value="" style="border:none;">
						</form>
					</div>
					<?php echo anchor('post/add','Make a Post' ,'class="btnorange"')?>
				</div>
				<div class="tablepost">
					
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblpost">
						<tr>
						<th width="10%">&nbsp;</th>
						<th width="21%">Title</th>
						<th width="10%">Status</th>
						<th width="17%" style="text-align:center;">Hits to article</th>
						<th width="25%">Last Edited</th>
						</tr>
							<?php $c=false; $i=1; foreach($posts as $post){
								$p_url =  getPostUrl($post['post_id']);
							?>
								<tr <?php echo (($c = !$c)?' class="alt"':'');?> id="<?php echo 'tr-id-'.$i; ?>">
								<td><a href="<?php echo $p_url;?>"><div class="thumb" id="post-img-<?php echo $post['post_image']?>">
								<img src="images/loader.gif" alt= "" >
								<script> showImage('<?php echo $post['post_image']?>','50','50','post-img-<?php echo $post["post_image"]?>');</script></div></a></td>
								<td><?php echo anchor($p_url,$post['title']) ?></td>
								<td width="10%"><?php echo $post['is_active']?'Published':'Draft'?></td>
								<td width="17%" style="text-align:center;"><?php echo $post['hit'];?></td>
								<td><?php echo date("M d,Y",$post['changed_date'])?>
									<div class="makepostdd">
										<a href="javascript:void(0);" class="arrowpost"></a>
										<div class="mpddinner">
											<div class="mptop"></div>
											<div class="mpmid">
												<ul>
												<li><?php echo anchor('post/edit/'.$post['post_id'],'Edit Post' ,'class="edit"')?></li>												
												<?php if($post['is_active']){?>
												<li><a href="javascript:void(0)" onclick="prepareConfirmPopup(this,'Are you sure?')" class="publish">Unpublish</a><div class="adl"><a href="javascript:void(0)" onclick="postOp('<?php echo $post['post_id']?>','unpublish')" class="btnorange">Yes</a></div></li>
												<?php }else{?>
												<li><a href="javascript:void(0)" onclick="prepareConfirmPopup(this,'Are you sure?')" class="publish">Publish</a><div class="adl"><a href="javascript:void(0)" onclick="postOp('<?php echo $post['post_id']?>','publish')" class="btnorange">Yes</a></div></li>											
												<?php }?>
												<li><?php echo anchor($p_url,'View' ,'class="publish"')?></li>
												<li><a href="javascript:void(0)" onclick="prepareConfirmPopup(this,'Are you sure?')" class="delete">Delete</a><div class="adl"><a href="javascript:void(0)" onclick="deletePost('<?php echo $post['post_id']?>'),hidePost('<?php echo 'tr-id-'.$i; ?>')" class="btnorange">Yes</a></div></li>
												</ul>
											</div>
											<div class="mpbot"></div>
										</div>
									</div>
								</td>
								</tr>
								
							<?php $i++; }?>
							</table>
								</div>
			</div>
						<?php }else{?>
                        <?php if($indication == "mypost"){?>
<!--Account Section Start -->
            <div class="first-timeuser-block">				
                <div class="msg-page-block">
                    <div class="welocme-msg-block">
						<h2 class="welocme-msg">Welcome <?php echo anchor("user/myprofile",ucfirst($this->session->userdata('user_name')));?> to Inksmash.com</h2>
                        <p>Since you're new to the site, We'd suggest a few things that you could do to begin using your account.</p>
                    </div>
                    <div class="wc-block-content">
                        <ul>
                            <li class="about-you">Give us <?php echo anchor('user/myprofile', 'More details about you.');?> Well  we'd like to know more about you</li>
                            <li class="making-post">You can start directly by <?php echo anchor('post/add','Making a Post')?> of your choice.</li>
                            <li class="understand"><?php echo anchor('page/underconstruction/About Us','Understand more about InkSmash.com');?> to know what this site is all about.</li>
                            <li class="start-serach"><?php echo anchor("user/search",'Start searching for users');?> and trace them to know more</li>
                            <li class="post-video"><?php echo anchor('post/add','Post a video');?> about yourself and give it more details so that you get traced.</li>
                            <li class="start-looking"><?php echo anchor('post/allcategories','Start Looking');?> for topics of your choice and add to your newsfeeds</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--Account Section End -->
            <?php }else{?>
            	<div class="first-timeuser-block">				
                <div class="msg-page-block">
                    <div class="welocme-msg-block">
						<h2 class="welocme-msg"> Your search keyword not found  any result. Go to <?php echo anchor('post/mypost/','Your Posts');?> </h2>                        
                    </div>
                    
                </div>
            </div>
			<?php }?>
			<?php }?>	
		</div>
	</div>
	<div class="clear"></div>
</div>