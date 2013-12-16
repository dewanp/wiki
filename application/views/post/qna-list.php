<div id="wrapper">
    <div class="left-content-main">
        <div class="left-content"><?php echo $sidebar;?></div>
    </div>
    <div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li><a href="javascript:void(0);">Home</a></li>
                <li><a href="javascript:void(0);" class="active">QNA</a></li>
            </ul>
        </div>
        <div class="rightinner" >
            <div class="sub-title">
                <h2>Question and Answers (QNA) Section</h2>
            </div>
		
			<?php if(!empty($qna)){ ?>
			<div id="showQna" >
		           <?php $this->load->view('post/qna-list-content'); ?>
			</div>
            <?php }?>
           <?php if(!empty($qna) && count($qna) >= 8){?> 
           <div class="txtshow showmore" id="show-qna-more">
                <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreShowQnaPosts();"><span class="txtload">Show more</span>
                <img src="images/loader.gif" alt="" id="show-qna-loading" style="display:none;"/></a>
		   </div>
		<?php } else { ?>
			<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div> 
            <!--<span style="margin:10px;font-size:16px;">No Question & Answer posts available</span>-->
		<?php }?>

        </div>
    </div>
    <div class="clear"></div>
</div>