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
        	<?php if(isset($flash_msg)){?>
            <div class="error">
            	<?php echo $flash_msg;?>
            </div>
            <?php }?>
            <div class="sub-title">
                <h2 class="border-none">Categories</h2>
                 <ul id="sample">
                     <li class="cadmin">Admin</li>
                     <li class="crw">RW</li>
                     <li class="cr">R</li>
                 </ul>
            </div>
            <div class="" style="margin-left:25px;">
           		<?php $this->load->view('post/folder-view');?>
           		<div class="catnav"> <?php  echo $this->pagination->create_links(); ?></div>
            </div>
           
        </div>
    </div>
	<div class="clear"></div>
</div>