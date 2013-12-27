<?php 
	$action = 'editcategory';
	echo form_open('admin/'.$action);
?>
	<script>
		$(document).ready(function(){
			toggledropdown();
		});
    </script>
    
    <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
             
			 <?php if($section == 'front-end'){?>
                <input type="hidden" id="parent_category" name ="parent_category" value="<?php echo $parent_category;?>"/>
             <?php }else if($section == 'back-end'){?>
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
            <?php }?>
					
                
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
               
                <?php if($section == 'front-end' && $permission==1 && $inheritance==0){
						//$style ='style="display:none;"';
						$style ='style=""';
					  }else if( ($section == 'front-end' && $permission==1 && $inheritance==1) || ($section == 'front-end' && $add_category==1) ){
					  	$style ='style=""';
					  }
					  
				?>
                <tr id="admin_tr" class="" <?php echo $style;?>>
                    <td> Admin </td>
                    <td>
                    	<div id="prev_admin">
                        	<ul class="prev_admin_ul" id="prev_admin_ul">
                            
                            </ul>
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
                    	<div id="prev_read_user">
                        	<ul class="prev_read_ul" id="prev_read_ul">
                            
                            </ul>
                     	</div> 	
                    		
                         <select id="read" name ="read[]" class="inputmain" multiple="multiple"  data-placeholder="--- Select People ---" onchange="removeCheckR()" style="width:298px;">
                            
						<?php if($category_detail['category_id'] == '')
							  {
							  	foreach($user_result as $user)
								{
						?>
                             <option value = "<?php echo $user['user_id'];?>"><?php echo $user['profile_name'];?></option>
						 <?php }
						 	  }
						?> 
                        </select>
                         
                         <div style="display:block; vertical-align:top; margin-top:5px;">
                             <span>Or Select All</span>
                             <input type="checkbox" id="read_all" name="read_all" value="1" onclick="checkbox_click_two()"/><br/>
                         </div>
                    </td>
                </tr>
                <?php if($section == 'front-end') {?> 
                <input type="hidden" value="1" name="is_active" id="is_active"/>
                    <?php 
                } else { ?>
                      
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
                    <?php }?>
              
                
                <?php //if($category_detail['category_id'] && $have_child_cat==1){?>
                <!--<tr>
                    <td>&nbsp;</td>
                    <td>
                      <div class="field">
                       <input type="checkbox" name="overwirte_child" id="overwirte_child" value="1" onclick="return overwrite_child()"/>
                       Overwrite child categories
                      </div>
                    </td>
                </tr>-->
                <?php //}?>
                
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        
                    	<input type="submit" class="btnorange" value="<?php if($category_detail['category_id']){
                            ?>Update<?php }else{?>Save<?php } ?>" name="save" onclick="return valid_admin_selection()"/>
                        
                    	 
                        <input type="hidden" name="edit_category_id" id="edit_category_id" value="<?php echo $category_detail['category_id']; ?>"/>
                        <input type="hidden" name="section" id="section" value="<?php echo $section; ?>"/>
                        <input type="hidden" name="is_inherited_admin" id="is_inherited_admin" value="<?php echo $inheritance; ?>"/>
                         <input type="hidden" name="same_level_admin" id="same_level_admin" value=""/>
                        
                        <a href="<?php if($section == 'front-end') echo site_url('post/allcategories'); else echo site_url('admin/displaycategorylist');?>"><input type="button" class="btngrey" value="Cancel"  name="cancel" /></a>
                         
                         
                   </td>
                </tr>
            </table>
    <?php echo form_close(); ?>