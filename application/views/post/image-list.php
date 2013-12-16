<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><?php echo anchor('post/showposts/all','All Posts');?></li>
				<li><a href="javascript:void(0);" class="active">Images</a></li>
			</ul>
		</div>
		<?php if(!empty($images)){?>
		<h1 class="orangetitle-f20" style="margin: 10px 28px 0;">Images</h1>
		<div class="rightinner" id="show-images">   
			<?php $this->load->view('post/image-list-content');?>
		</div>
        <?php }?>
        
		<?php if(!empty($images) && count($images) >= 12){?>
		<div class="txtshow showmore" id="show-image-more">
			<a href="javascript:void(0);" class="txtgrey" onclick="loadMoreShowImagePosts();"><span class="txtload">Show more</span>
			<img src="images/loader.gif" alt="" id="show-image-loading" style="display:none;"/></a>
		</div>
		<?php }else{ ?>
        	<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
        <?php }?>
        <?php //else echo '<span style="margin:10px;font-size:16px;">No '.$type.' posts available</span>';?>
	</div>
	<div class="clear"></div>
</div>