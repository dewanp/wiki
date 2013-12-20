<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><a href="javascript:void(0);" class="active">Home</a></li>
				
                <li><a href="javascript:void(0);" class="active"><?php if(strtolower($type)=='paragraph'){echo 'Articles';}else{ echo 'Posts';}?> </a></li>
			</ul>
            <?php
			if(is_numeric($type)){
		   			 if($permission){
		   ?>
            <span class="" style="float:right;margin-top:12px;">
                <div class="makepostdd">
                    <a href="javascript:void(0);" class="arrowpost"></a>
                    <div class="mpddinner">
                        <div class="mptop"></div>
                        <div class="mpmid">
                          <ul>
                            <?php if($permission == 1){?>
                            
                                <li><?php echo anchor('post/displayEditCategory/'.$type,'Manage Category')?></li>
                                <li><a href="javascript:void(0);" onclick="deleteCategory(<?php echo $type;?>)">Delete Category</a></li>
                                <li><?php echo anchor('post/add/'.$type,'Write Post')?></li>
                               
							<?php }elseif($permission == 2){?>
                          		 <li><?php echo anchor('post/add/'.$type,'Write Post')?></li>
                           	
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
              <?php }?>
            
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