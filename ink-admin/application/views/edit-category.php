
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
				<?php echo anchor('home/displaycategorylist','<span class="back-icon"></span>Back to Category List','class="btnorange"'); ?>
            </div>
        </div>
        <div class="clear"></div>
         <script>
			$(document).ready(function(){
				toggledropdown();
			});
		</script>
		<?php
			$action = 'addCategory';
			if($category_detail['category_id'] != ''){
				$action = 'editcategory';
				?>
                <script>
                	$(document).ready(function(){
						toggledropdown();
					});
                </script>
			<?php }
			echo form_open('home/'.$action);
		 ?>
        
        <div class="rightdtls">
            
            <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                
                
                <tr>
					<td> Parent Category </td>
					<td>
                    <input type="hidden" id="edit_category" name="edit_category" value="<?php echo $category_detail['category_id'];?>" />
					  <select  id="parent_category" name ="parent_category" class="inputmain" style="width:298px;" onchange="toggledropdown();"> 
						 <?php foreach($category_result as $optkey=>$optval){ ?>
							 <option value = "<?php echo $optkey; ?>" <?php if(isset($parent_category) && $parent_category == $optkey){?> selected="selected"<?php }?>>
							 	<?php echo $optval; ?>
                              </option>
						 <?php }?>
					   </select>
                       
                        <?php /*?><?php if(isset($inherited_userr) && !empty($inherited_userr) )
							  {
						?>
                            <div style="margin-top:5px;">
                                <?php foreach($user_result as $user)
									  {
                                        if( in_array($user['user_id'],$inherited_userr))
                                        {
                                            echo '<label>'.$user['profile_name'].' , </label>';
                                        }
                               		  }
                              }?>
                            </div><?php */?>
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
                    <td>Status:</td>
                    <td>
                      <div class="field">
                        <select name="is_active" id="is_active" class="inputmain" style="width:298px;"> 
                          	<option value="1" id="active" <?php echo $status =($category_detail['is_active']==1)?'selected':'' ?> >Active </option>
                           <option value="0" id="deactive" <?php echo $status =($category_detail['is_active']==0)?'selected':'' ?>>De-active</option>
                        </select>
                      </div>
                    </td>
                </tr>
                
                
                <tr>
                    <td>&nbsp;</td>
                    <td>
                    	<input type="submit" class="btnorange" value="Save" name="save" />
                    	<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_detail['category_id']; ?>"/>
                        <input type="submit" class="btngrey" value="Cancel"  name="cancel" />
                        <input type="hidden" name="add_category" id="add_category" class="btnorange" value="Add New Category" />
                   </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
   <div class="clear"></div>
        
        </div>
    </div>

<div class="clear"></div>
</div>