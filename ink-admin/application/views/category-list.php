<!--Wrapper Start-->

<div id="wrapper">
<div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Category List</h1>
           	<div class="pleft" style="margin-top:5px;">
            <span class="left" style="margin:-5px 0 0 5px;">(<?php echo $count_user; ?>)  </span>  </div>
            
            <a class="btnorange" href="<?php echo site_url('home/displayAddCategory')?>" style="float:right;">
            <span class="back-icon"></span>Add Category</a>
            
        </div>       
        <?php echo form_open('home/category_status_change'); ?>
        <div class="grid grid4">
        <ul><li> <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tblgrid"><tbody>
            	<tr>
                    <th style="width:91%!important;">Category Name</th>
                    <th>Options</th>
                </tr>
            
				
           	</tbody></table></li>
           <?php echo build_admin_tree($category_list);?>
           </ul>
        </div>
        </form>
        <div class="pagi-main">
            <div class="pleft"><span class="left">Total Category : <?php echo $count_user; ?> </span>  </div>
            <!-- Pagination Region : Start -->
            <div class="pagination-region">
                <div class="paginationdiv">
                    <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
                </div>
                <!-- Pagination Region : End --> 
            </div>
        </div>
    </div>
	<div class="clear" > </div>
</div>
<!--Wrapper End--> 