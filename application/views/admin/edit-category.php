
<div id="wrapper">
<div class="breadcrumb"></div>
    
    
    <div class="container">
        <div class="maintitle">
        <?php 
			$title = 'Add Category';
			if($category_detail['category_id'] != ''){
				$title = 'Edit Category';
			}
		?>
            <h1><?php echo $title;?></h1>
            <div class="btnbox">
				<?php echo anchor('admin/displaycategorylist','<span class="back-icon"></span>Back to Category List','class="btnorange"'); ?>
            </div>
        </div>
        <div class="clear"></div>
         <script>
			$(document).ready(function(){
				toggledropdown();
			});
		</script>
        <div class="rightdtls">
           <?php $this->load->view('admin/edit-category-form',$data); ?>
   <div class="clear"></div>
        
        </div>
    </div>

<div class="clear"></div>
</div>