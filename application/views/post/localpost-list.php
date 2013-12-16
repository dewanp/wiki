<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><?php echo anchor('post/localpostsmap','Local Posts'); ?></li>
                <li id="bcity_name"><?php echo $city_name['state'];?></li>
			</ul>
            <?php if(!is_numeric($zip_code)){?>
            <div class="uniqueSelectZip">
				<?php 					
					foreach($posts as $unique_post)
					{
						$unique_posts[] = $unique_post['post_zip_code'];
					}
				?>
                <select  id="uniqueZip" onchange="showPostsByZip(this.value)">
                	<option value="<?php echo $zip_code; ?>">All Zipcodes In This City</option>
						<?php foreach (array_unique($unique_posts) as $unique_zip){?>
                            <option value="<?php echo $unique_zip; ?>"><?php echo $zip_city_name ."&nbsp;-&nbsp;". $unique_zip ;?></option>
                        <?php }?>
                </select>
            </div>
            <?php } //if end ?>
            <?php if($this->commonmodel->isLoggedIn() && !empty($posts)){?>
                <div class="right" style="margin:10px;" id="followLocationDiv">
                    <?php if($fol_unfol_status == 'follow_link'){ ?>
                        <div class="unfollow-location">
                            <a href="javascript:void(0);" onclick="followLocation('<?php echo $zip_code; ?>','')" title="Follow Location"></a>
                        </div>
                   <?php }else{?>
                        <div class="follow-location">
                            <a href="javascript:void(0);" onclick="unFollowLocation('<?php echo $zip_code; ?>','')" title="Unfollow Location"></a>
                        </div>
                  <?php }?>             
                </div>
        <?php }?>
        </div>
		<?php if(!empty($posts)){?>
            <div class="rightinner" id="show-post">   
                <?php $this->load->view('post/post-list-content');?>
            </div>
        <?php }?>
        <?php if(!empty($posts) && count($posts) >= 8){?>
            <div class="txtshow showmore" id="show-post-more">
                <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreLocalPosts('<?php echo $zip_code;?>');"><span class="txtload">Show more</span>
                <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a>
            </div>
		<?php }else { ?>
        		<div class="searchdtl">There are no more Posts in this area. Be the first one to post something about your area <?php echo anchor('post/add/localpost','Create Post','class="btnorange" style="float:none;"')?></div>
		<?php }?>
	</div>
	<div class="clear"></div>
</div>
</div>