<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
      <?php $this->load->view('post/breadcrumb');?>
         <div class="" style="margin-left:25px;">
           <?php $this->load->view('post/folder-view');?>
         </div>
        <div class="rightinner"> 
            	<div class="showcomment"> 
			   <?php $this->load->view('admin/edit-category-form',$data); ?>
			</div>
        </div>
    </div>
	<div class="clear"></div>
</div>