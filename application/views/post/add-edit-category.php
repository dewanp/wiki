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
			   <form onsubmit="return suggestCategory()" id="category_form">
               
				<span class="txtgrey" style="width:100%; font-size:16px;">Manage Categories</span>
               
               	<div class="field">
                    <span style="display:block; margin-top:15px;">Category Title</span>
                    <input type="text" id="suggest_category_description" name="suggest_category_description" class="inputmain tbi" style=" width:280px;margin-top:10px;"/><br/>
                    <span id ="suggest_category_description_msg" style="color:red;"> </span>
                </div>
                <br/>
               
				<div class="field" style="width:100%;">
                <span style="display:block; margin-bottom:8px;">Parent Category </span>
                <select name="main-cat" id="main-cat" style="width:300px;" onchange="toggledropdown();">
                    <?php foreach($category_result as $catkey=>$catval){ ?>
                        <option id="opt-<?php echo $catkey?>" value="<?php echo $catkey?>"><?php echo $catval?></option>
                    <?php }?>
                </select>
                <br/>			
				<span id="suggest_category_name_msg" style="color:red;"> </span>
				<br/></div>
                
                
                 <div class="field" style="width:425px;">
                    <span style="display:block;margin-bottom:5px; vertical-align:top;">Admin</span>
                    
                    <div id="admin_names" class="hide">
                    	
                    </div>
                    <input type="hidden" value="" name="admin_ids" id="admin_ids" />
                    
                    
                     <select id="admin" name ="admin[]" class="inputmain" style="width:298px" multiple="multiple" onchange="removeCheckAdmin()" data-placeholder="--- Select People ---">
                         <?php foreach($user_result as $user){ ?>
                             <option value = "<?php echo $user['user_id']; ?>"><?php echo $user['profile_name']; ?> </option>
                         <?php }?>
                     </select>
                     <div style="display:block; vertical-align:top;">
                         <span>Or Select All </span>
                         <input type="checkbox" id="admin_all" name="admin_all" value="1" onclick="checkbox_click_admin()"/>
                     </div>
                </div>
                
                
                
                <div class="field" style="margin:20px 0 0 0;width:425px;">
                <span style="display:block;margin-bottom:5px; vertical-align:top;">W/R</span>
                 <select id="read_write" name ="read_write[]" class="inputmain" style="width:298px" multiple="multiple" onchange="removeCheckRw()" data-placeholder="--- Select People ---">
                     <?php foreach($user_result as $user){ ?>
                         <option value = "<?php echo $user['user_id']; ?>"><?php echo $user['profile_name']; ?> </option>
                     <?php }?>
                 </select>
                 <div style="display:block; vertical-align:top;">
                     
                     <span>Or Select All </span>
                     <input type="checkbox" id="read_write_all" name="read_write_all" value="1" onclick="checkbox_click()"/><br>
                     
                     <?php /*?><span>Copy from parent</span>
                     <input type="checkbox" id="copy_parent_rw" name="copy_parent_rw" value="1" onclick="copy_parent_readwrite()" <?php if(isset($cpy_parnt_rw)){?> checked="checked"<?php }?>/><?php */?>
                 </div>
                 <span id="read_write_error" class="error"></span>
                </div>
                
                
                <div class="field" style="margin:20px 0 0 0;width:425px;">
                <span style="display:block;margin-bottom:5px;">Read Only</span>
					 <select id="read" name ="read[]" class="inputmain" style="width:298px" multiple="multiple" onchange="removeCheckR()">
						 <?php foreach($user_result as $user){ ?>
							 <option value = "<?php echo $user['user_id']; ?>"><?php echo $user['profile_name']; ?> </option>
						 <?php }?>
					 </select>
                     <div style="display:block; vertical-align:top;">
                     
                     <span>Or Select All </span>
                     <input type="checkbox" id="read_all" name="read_all" value="1" onclick="checkbox_click_two()"/><br/>
                     
                     <?php /*?><span>Copy from parent</span>
                     <input type="checkbox" id="copy_parent_r" name="copy_parent_r" value="1" onclick="copy_parent_read()" <?php if(isset($copy_parent_r)){?> checked="checked"<?php }?>/>  <?php */?>  
                     </div>
                     <span id="read_error" class="error"></span>
               </div> 
                
                
                <input type="submit" class="btnorange catbtn" value="Done" style="margin-top:110px;" />
                <input type="hidden" value="" name="category_id" id="category_id" />
                <input type="hidden" value="" name="sub_category_id" id="sub_category_id" />
                <input type="hidden" <?php if(isset($user_id)){?> value="<?php echo $user_id;?>" <?php }else{?> value="" <?php }?> name="user_id" id="user_id" />
				
				</form>
			</div>
            <?php }?>
        </div>
    </div>
	<div class="clear"></div>
</div>