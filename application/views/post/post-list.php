<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<?php $this->load->view('post/breadcrumb');?>
             
         <div class="" style="margin-left:25px;">
           <?php $this->load->view('post/folder-view');?>
         </div>
         
		<?php if(!empty($posts)){?>
		<div class="rightinner" id="show-post">   
			<?php $this->load->view('post/post-list-content');?>
		</div>
        <?php }else{?>
        	<div class="searchdtl2"><span style="margin-left:50%;">Results are not available.</span></div>
        <?php }?>
        <?php if(!empty($posts) && count($posts) >= 8){?>
            <div class="txtshow showmore" id="show-post-more">
                <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreShowPosts('<?php echo $type;?>');"><span class="txtload">Show more</span>
                <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a>
            </div>
		<?php } ?>
	</div>
	<div class="clear"></div>
   
    
</div>