<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb">
			<span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><a href="javascript:void(0);" class="active">My Posts</a></li>
			</ul>
		</div>
		
		<div class="rightinner">
			<?php if(!empty($posts)){?>
			<div class="myposts">
				<div class="search">
					<div class="field">
						<form action="" name="serach_post_by_title" method="post">
						<label for="txtF3" class="infield">Search within your posts</label>
						<input name="post_title" type="text" id="txtF3" class="inputmain" value="" />
						<input type="submit" class="icon" value="">
						</form>
					</div>
					<?php echo anchor('post/add','Make a Post' ,'class="btnorange"')?>
				</div>
				<div class="tablepost">
					
						
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblpost">
						<tr>
						<th width="10%">&nbsp;</th>
						<th width="21%">Title</th>
						<th width="10%">Likes</th>
						<th width="17%">Hits to article</th>
						<th width="17%">Earning in ($)</th>
						<th width="25%">Last Edited</th>
						</tr>
							<?php $c=false;foreach($posts as $post){?>
								<tr <?php echo (($c = !$c)?' class="alt"':'');?>>
								<td><div class="thumb" id="post-img-<?php echo $post['post_image']?>"><script> showImage('<?php echo $post['post_image']?>','50','50','post-img-<?php echo $post["post_image"]?>');</script></div></td>
								<td><?php echo $post['title']?></td>
								<td width="10%">18</td>
								<td width="17%">18</td>
								<td width="17%">0.00</td>
								<td><?php echo date("M d,Y",$post['changed_date'])?>
									<div class="makepostdd">
										<a href="javascript:void(0);" class="arrowpost"></a>
										<div class="mpddinner">
											<div class="mptop"></div>
											<div class="mpmid">
												<ul>
												<li><?php echo anchor('post/edit/'.$post['post_id'],'Edit' ,'class="edit"')?></li>
												<li><?php echo anchor('post/edit/'.$post['post_id'],'Publish' ,'class="publish"')?></li>
												<li><?php echo anchor('post/edit/'.$post['post_id'],'Delete' ,'class="delete"')?></li>
												</ul>
											</div>
											<div class="mpbot"></div>
										</div>
									</div>
								</td>
								</tr>
								</table>
								</div>
			</div>
							<?php }?>
						<?php }else{?>
<!--Account Section Start -->
            <div class="first-timeuser-block">
				<?php if(!$isZipCode) { ?>
                <div class="info-block">	
					<span class="info-show">We need your zip code so that you help others know your area in case they wish to know. <a href="javascript:void(0);" class="click-enter-zip">Click here to enter your zip code</a></span> 
				</div>
				<?php } ?>
                <div class="msg-page-block">
                    <div class="welocme-msg-block">
                        <h2 class="welocme-msg">Welcome <a href="javascript:void(0);"><?php echo ucfirst($this->session->userdata('user_name');?></a> to InkSheets.com</h2>
                        <p>Since you're new to the site, We'd suggest a few things that you could do to begin using your account.</p>
                    </div>
                    <div class="wc-block-content">
                        <ul>
                            <li class="about-you">Give us <?php echo anchor('user/myprofile', 'More details about you.');?> Well  we'd like to know more about you</li>
                            <li class="making-post">You can start directly by <?php echo anchor('post/add','Making a Post')?> of your choice.</li>
                            <li class="understand"><?php echo anchor('page/aboutus','Understand more about InkSheet.com');?> to know what this site is all about.</li>
                            <li class="start-serach"><?php echo anchor("search",'Start searching for users');?> and trace them to know more</li>
                            <li class="post-video"><?php echo anchor('post/add','Post a video');?> about yourself and give it more details so that you get traced.</li>
                            <li class="start-looking"><?php echo anchor('user/feeds','Start Looking');?> for topics of your choice and add to your newsfeeds</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--Account Section End --> 
			<?php }?>	
		</div>
	</div>
	<div class="clear"></div>
</div>