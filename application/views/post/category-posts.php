<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><a href="javascript:void(0);" class="active"><?php echo ucwords($type);?> Posts</a></li>
			</ul>
		</div>
		<?php if(!empty($posts)){?>
		<div class="rightinner" id="show-post">   
			<?php $this->load->view('post/post-list-content');?>
		</div>
        <?php }?>
        <?php if(!empty($posts) && count($posts) >= 8){?>
		<div class="txtshow showmore" id="show-post-more">
			<a href="javascript:void(0);" class="txtgrey" onclick="loadMoreCategoryPosts('<?php echo $category_id;?>');"><span class="txtload">Show more</span>
			<img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a>
		</div>
		<?php } else if( empty($posts) && count($posts) == 0) {?>
        <div class="rightinner">
        	<div class="zipmessage"><div class="infoleft" style="width:96%;"><span class="icon" style="margin-top:-8px !important;"></span> No posts available for this category. Go to <?php echo anchor("post/showposts/all","All Posts!");?></div></div>
        </div>
        <?php }else{?>
        	<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
        <?php }?>
	</div>
	<div class="clear"></div>
</div>