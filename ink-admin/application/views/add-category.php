
<div id="wrapper">
<div class="breadcrumb"></div>

 
    <div class="container">
        <div class="maintitle">
            <h1>Add Category</h1>
            <div class="btnbox">
				<?php echo anchor('home/displaycategorylist' , '<span class="back-icon"></span>Back to Category List' , 'class="btnorange"') ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <?php echo form_open('home/addcategory');?>
		
        <div class="rightdtls">
        <table border="0" cellspacing="0" cellpadding="0" class="tbldtl add-new-user">
        	
            
            <tr>
				<td> Parent Category </td>
				<td>
                     <select  id="parent_category" name ="parent_category" class="inputmain" style="width:298px" onchange="toggledropdown();"> 
						 <?php foreach($category_result as $optkey=>$optval){ ?>
							 <option value = "<?php echo $optkey; ?>" <?php if(isset($prnt_catg) && $prnt_catg == $optkey){?> selected="selected"<?php }?>>
							 	<?php echo $optval; ?>
                             </option>
						 <?php }?>
					 </select> 
				</td>
			</tr>
            
            
            <tr>
                <td>Category Name</td>
                <td>
                	<div class="field">
                       <input type="text" id="category_name" name="category_name" class="inputmain" maxlength="60" value="<?php echo set_value('category_name'); ?>"/>
                    </div><br/>
                    <span class="error">
                        <?php echo form_error('category_name'); ?>
                    </span>
                </td>
            </tr>
            
            <tr id="admin_tr">
				<td> Admin </td>
				<td> 
					 <div id="prev_admin">
                     	
                     </div>
                     
                     <select id="admin" name ="admin[]" class="inputmain" multiple="multiple" data-placeholder="--- Select People ---" style="width:298px;">
						 <?php foreach($user_result as $user){ ?>
							 <option value = "<?php echo $user['user_id']; ?>" <?php if(isset($admn) && in_array($user['user_id'],$admn)){?> selected="selected"<?php }?>>
							 	<?php echo $user['profile_name']; ?>
                             </option>
						 <?php }?>
					 </select>
                     
                      <div style="display:block; vertical-align:top; margin-top:5px;">
                         <span>Or Select All </span>
                         <input type="checkbox" id="admin_all" name="admin_all" value="1" onclick="checkbox_admin_click()" <?php if( isset($a_all) || (isset($admn) && $admn == 'all') ){?> checked="checked"<?php }?>/><br/>
                     </div>
                     
                    <span class="error">
						<?php echo form_error('admin'); ?>
                    </span>
				</td>
			</tr>
            
            
            <tr id="read_write_tr">
				<td> Read/Write </td>
				<td id="read_write_td"> 
					 <select id="read_write" name ="read_write[]" class="inputmain" multiple="multiple" onchange="removeCheckRw()" data-placeholder="--- Select People ---" style="width:298px;">
						 <?php foreach($user_result as $user){ ?>
							 <option value = "<?php echo $user['user_id']; ?>" <?php if(isset($rd_write) && in_array($user['user_id'],$rd_write)){?> selected="selected"<?php }?>>
							 	<?php echo $user['profile_name']; ?>
                             </option>
						 <?php }?>
					 </select>
                     
                     <div style="display:block; vertical-align:top; margin-top:5px;">
                         <span>Or Select All </span>
                         <input type="checkbox" id="read_write_all" name="read_write_all" value="1" onclick="checkbox_click()" <?php if(isset($rw_all)){?> checked="checked"<?php }?>/><br/>
                         
                        <?php /*?> <span>Copy from parent</span>
                         <input type="checkbox" id="copy_parent_rw" name="copy_parent_rw" value="1" onclick="copy_parent_readwrite()" <?php if(isset($cpy_parnt_rw)){?> checked="checked"<?php }?>/><?php */?>
                     </div>
                     
                     <span id="read_write_error" class="error"></span>
				</td>
			</tr>
            
            
            <tr>
				<td> Read </td>
				<td> 
					 <select id="read" name ="read[]" class="inputmain" multiple="multiple" onchange="removeCheckR()" data-placeholder="--- Select People ---" style="width:298px;">
						 <?php foreach($user_result as $user){ ?>
							 <option value = "<?php echo $user['user_id']; ?>" <?php if(isset($rd) && in_array($user['user_id'],$rd)){?> selected="selected"<?php }?>>
							 	<?php echo $user['profile_name']; ?>
                             </option>
						 <?php }?>
					 </select>
                     
                     <div style="display:block; vertical-align:top; margin-top:5px;">
                     	<span>Or Select All </span>
                     	<input type="checkbox" id="read_all" name="read_all" value="1" onclick="checkbox_click_two()" <?php if(isset($read_all)){?> checked="checked"<?php }?>/><br/>
                     	
                        <?php /*?><span>Copy from parent</span>
                     	<input type="checkbox" id="copy_parent_r" name="copy_parent_r" value="1" onclick="copy_parent_read()" <?php if(isset($copy_parent_r)){?> checked="checked"<?php }?>/><?php */?>
                     </div>
                     
                     <span id="read_error" class="error"></span>
				</td>
			</tr>
            
            
            <tr>
                <td>Status</td>
                <td>
                	<div class="field">
                     <select  id="is_active" name="is_active" class="inputmain" style="width:298px" >
                         <option id="active" value="1" selected> Active </option>
                         <option id="deactive" value="0">De-Active</option>
                     </select>
                    </div>
                </td>
            </tr>
            
            
            <tr>
                <td>&nbsp;</td>
                <td>
                	<input type="Submit" name="add_category" id="add_category" class="btnorange" value="Add New Category" />
                    <input type="Submit" class="btngrey" value="Cancel" />
                    <input type="hidden" name="category_id" id="category_id" value="" />
               </td>
            </tr>
        </table>
        </div>
        <?php echo form_close(); ?>
    </div>
    

<div class="clear"></div>
</div>