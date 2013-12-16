<script>
// Start : code for ordering post type
$(function() {
	$( "#tbl-post-type" ).sortable({
		items: "tr:not(#tbl-header)",
		beforeStop:function(event, ui) { 
			$.ajax({
				type: "POST",
				url: site_url + "home/orderposttype",
				data: $("form#frm_post_type").serialize(),
				success: function (data){ 
					//updatePostCapsuleWrapper($("#post_id").val(),'edit');
				}
			});
		}			
	});
});
// End : code for ordering post type
</script>

<!--Wrapper Start-->
<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Post Type List</h1>
        </div>
        <!-- <div class="btnbox" style="float:right">
            <?php  echo anchor ('home/displayaddsubcategory' , '<span class="add-icon"></span>Add New SubCategory' , 'class="btnorange" ')?>
        </div> -->
        <?php echo form_open('home/sub_category_status_change','id="frm_post_type"'); ?>
        <div class="grid grid4">
			<input type="submit" name="active" value="Activate Selected" class="btnorange" style="margin-right:10px;" /> 
			<input type="submit" name="deactive" value="Deactivate Selected" class="btnorange" />
			 <div class="btnbox" style="float:right">
				<?php  echo anchor ('home/displayaddsubcategory' , '<span class="add-icon"></span>Add New SubCategory' , 'class="btnorange" ')?>
                <?php  echo anchor ('home/displaycategorylist' , '<span class="add-icon"></span>View All Category' , 'class="btnorange" style="margin-left:10px;" ')?>
			</div>
            <div class="clear"></div>
            <script>
		     function check_all_function(ths){
					if($(ths).attr('checked')=="checked"){
						$(".u").attr('checked','checked');
					}else{
						$(".u").removeAttr('checked');
					}
		    	}
            </script>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tblgrid" id="tbl-post-type" style="cursor:move;">
                <tr id="tbl-header">
                    <th> <?php 
					$js = 'onClick="check_all_function(this)"';
					echo form_checkbox("checkall",'','',$js); ?></th>
                    <th>Sub Category Name</th>
                    <th>Mandatory Blocks </th>
                    <th> Status </th>
                    <th>Options</th>
                </tr>
                <?php  $i=0; foreach ($post_type_list as $row ) {    
					  if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
				?>
                <tr>
                    <td <?php echo $class_alt ;?>><?php echo form_checkbox("check[]",$row['sub_category_id'],'','class="u"'); ?> <?php echo form_hidden("is_active[]", $row['is_active']); ?></td>
                    <td <?php echo $class_alt ;?>><?php echo $row['name']; ?></td>
                    <td <?php echo $class_alt ;?>><?php echo $row['capsule_type_name']; ?></td>
                    <td <?php echo $class_alt ;?>><?php   $status = ($row['is_active'] == 1)? 'active': 'Deactive' ;?>
                        <?php echo anchor('home/sub_category_status_change/'.$row['sub_category_id']."/".$row['is_active'], $status); ?></td>
                    <td <?php echo $class_alt ;?>><?php echo anchor('home/displayeditsubcategory/'.$row['sub_category_id'], 'Edit Category'); ?></td>
					<input type="hidden" value="<?php echo $row['sub_category_id'];?>" name="sub_category_id[]">
                </tr>
                <?php $i++; }?>
                <!-- foreach loop end here -->
            </table>
        </div>
        </form>
        <div class="pagi-main">
            <div class="pleft"><span class="left">Total Category : <?php echo $count_user; ?> </span>  </div>
            <!-- Pagination Region : Start -->
            <div class="pagination-region">
                <div class="paginationdiv">
                    <div class="pagination"> <?php //echo $this->pagination->create_links(); ?> </div>
                </div>
                <!-- Pagination Region : End --> 
            </div>
        </div>
    </div>
	<div class="clear" > </div>
</div>
<!--Wrapper End--> 