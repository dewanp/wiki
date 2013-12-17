
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
		<?php
			$action = 'editcategory';
			
			echo form_open('admin/'.$action);
		 ?>
        
        <div class="rightdtls">
            
            <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                
                
                <tr>
					<td> Parent Category </td>
					<td>
                    
					  <select  id="parent_category" name ="parent_category" class="inputmain" style="width:298px;" onchange="toggledropdown();"> 
                          
						 <?php foreach($category_result as $optkey=>$optval){
                             if($optkey==$category_detail['category_id'] && $category_detail['category_id']!='')continue;
                             ?>
					<option value="<?php echo $optkey; ?>" <?php if(isset($parent_category) && $parent_category == $optkey){?> selected="selected"<?php }?>><?php echo $optval; ?></option>
						 <?php }?>
					   </select>
					</td>
			    </tr>
                
                <tr>
                    <td>Category Name</td>
                    <td>
                        <div class="field">
                           <input type="text" id="category_name" name="category_name" class="inputmain" maxlength="60"  value="<?php echo set_value('category_name',$category_detail['name']) ; ?>"  />
                       </div><br/>
                        <span class="error">
                            <?php echo form_error('category_name'); ?>
                        </span>
                    </td>
                </tr>
                
                
                <tr id="admin_tr" class="">
                    <td> Admin </td>
                    <td>
                    	<div id="prev_admin">
                     	
                     	</div> 
                         <select id="admin" name ="admin[]" class="inputmain" multiple="multiple" data-placeholder="--- Select People ---" style="width:298px;">
                             
                         </select>
                         
                          <div style="display:block; vertical-align:top; margin-top:5px;">
                             
                             <span>Or Select All </span>
                             <input type="checkbox" id="admin_all" name="admin_all" value="1" onclick="checkbox_admin_click()" <?php if(isset($a_all)){?> checked="checked"<?php }?>/><br/>
                         </div>
                        <span class="error">
							<?php echo form_error('admin'); ?>
                        </span>
                    </td>
                </tr>
                
                <tr>
                    <td> Read/Write </td>
                    <td> 
                         <select id="read_write" name ="read_write[]" class="inputmain" multiple="multiple" data-placeholder="--- Select People ---" onchange="removeCheckRw()" style="width:298px;">					
                        
                         <?php if($category_detail['category_id'] == ''){?>
                         	<?php foreach($user_result as $user){ echo $user; ?>
							 <option value = "<?php echo $user['user_id']; ?>">
							 	<?php echo $user['profile_name']; ?>
                             </option>
						 <?php }?>
                         <?php }?> 
                           
                         </select>
                         
                         <div style="display:block; vertical-align:top; margin-top:5px;">
                             
                             <span>Or Select All </span>
                             <input type="checkbox" id="read_write_all" name="read_write_all" value="1" onclick="checkbox_click()"/><br/>
                         </div>
                    </td>
                </tr>
                
                
                <tr>
                    <td> Read </td>
                    <td> 
                         <select id="read" name ="read[]" class="inputmain" style="width:298px" multiple="multiple"  data-placeholder="--- Select People ---" onchange="removeCheckR()" style="width:298px;">
                            
						<?php if($category_detail['category_id'] == ''){?>
                        <?php foreach($user_result as $user){ ?>
                         <option value = "<?php echo $user['user_id']; ?>">
                            <?php echo $user['profile_name']; ?>
                         </option>
						 <?php }?>
                         <?php }?> 
                            
                            
                         </select>
                         
                         <div style="display:block; vertical-align:top; margin-top:5px;">
                             <span>Or Select All </span>
                             <input type="checkbox" id="read_all" name="read_all" value="1" onclick="checkbox_click_two()"/><br/>
                         </div>
                    </td>
                </tr>
                
                
                <tr>
                    <td>Status</td>
                    <td>
                      <div class="field">
                        <select name="is_active" id="is_active" class="inputmain" style="width:298px;"> 
                          	<option value="1" id="active" <?php echo $status =($category_detail['is_active']==1)?'selected':'' ?> >Active </option>
                           <option value="0" id="deactive" <?php echo $status =($category_detail['is_active']==0 && $category_detail['is_active']!='')?'selected':'' ?>>De-active</option>
                        </select>
                      </div>
                    </td>
                </tr>
                
                <?php if($category_detail['category_id'] && $have_child_cat==1){?>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                      <div class="field">
                       <input type="checkbox" name="overwirte_child" id="overwirte_child" value="1"/>
                       Overwite child categories
                      </div>
                    </td>
                </tr>
                <?php }?>
                
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        
                    	<input type="submit" class="btnorange" value="<?php if($category_detail['category_id']){
                            ?>Update<?php }else{?>Save<?php } ?>" name="save" />
                        
                    	 
                        <input type="hidden" name="edit_category_id" id="edit_category_id" value="<?php echo $category_detail['category_id']; ?>"/>
                        <a href="<?php echo site_url('admin/displaycategorylist');?>"><input type="button" class="btngrey" value="Cancel"  name="cancel" /></a>
                         
                         
                   </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
   <div class="clear"></div>
        
        </div>
    </div>

<div class="clear"></div>
</div>