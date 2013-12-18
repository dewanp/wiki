<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li><a href="javascript:void(0);" class="active">Home</a></li>
                <li><a href="javascript:void(0);" class="active">All Categories</a></li>
            </ul>
        </div>
        <div class="rightinner"> 
            <?php if( !empty($category_result) && count($category_result) > 1 ){?>
            	<div class="showcomment"> 
			   <?php $this->load->view('admin/edit-category-form',$data); ?>
			</div>
            <?php }?>
        </div>
    </div>
	<div class="clear"></div>
</div>