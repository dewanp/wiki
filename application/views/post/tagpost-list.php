<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><a href="javascript:void(0);" class="active">Tag Posts</a></li>
			</ul>
		</div>
		<?php if(!empty($posts)){?>
            <div class="rightinner" id="show-post">   
                <?php $this->load->view('post/post-list-content');?>
            </div>
       <?php }?>     
       <?php if( !empty($posts) && count($posts)>= 8){?>
            <div class="txtshow showmore" id="show-post-more">
                <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreTagPosts('<?php echo $tag_name;?>');"><span class="txtload">Show more</span>
                <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a>
            </div>
		<?php } else{ ?>
        		<div class="searchdtl">There are no more Posts related to this tag. Be the first one to post something <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>  
		<?php }?>
	</div>
	<div class="clear"></div>
</div>