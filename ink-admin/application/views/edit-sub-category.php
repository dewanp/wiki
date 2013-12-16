<!--Wrapper Start-->
<!--
<script type="text/javascript" >
	$(function(){
		
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'upload/do_upload',
			name: 'postImage',
			data: {field_name:'postImage',folder_name:'Sub_Category'},
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				var output = $.parseJSON(response);
				if(output.status){

					var previewHTML = '<div class="user-thmb-block"><div class="user-profile-thmb" id="sub_category_image"></div><div class="change-pro-pic"></div></div>';					
					$("#files").html(previewHTML);
					$("#file_upload_id").val(output.data.file_upload_id);
					showImage(output.data.file_upload_id,'140','140','show_image');
				}else{
					$("#files").html(output.data);
				}				
			}
		});
	});
		
	</script>-->

<div id="wrapper">
<div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1><a href="javascript:void(0);"> <?php echo $sub_category_detail['name'];?> </a></h1>
            <div class="btnbox"> <?php echo anchor('home/displayposttypelist','<span class="back-icon"></span>Back to Post Type List','class="btnorange"'); ?> </div>
        </div>
        <?php echo form_open('home/editsubcategory'); ?>
        <div class="leftdtls"></div>
        <div class="rightdtls">
            <div class="titlebar">
                <h4>Post Type Information</h4>
            </div>
            <div class="clear"></div>
            <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                <tr>
                    <td>Sub Category Id</td>
                    <td><div class="field">
                            <input type="text" readonly name="sub_category_id" id="sub_category_id" class="inputmain" value="<?php echo set_value('sub_category_id',$sub_category_detail['sub_category_id']) ;?>" />
                            <?php echo form_error('sub_category_id'); ?> </div></td>
                </tr>
                <tr>
                    <td>Sub Category Name:</td>
                    <td><div class="field">
                            <input type="text" id="sub_category_name" name="sub_category_name" class="inputmain"   value="<?php echo set_value('sub_category_name',$sub_category_detail['name']) ; ?>"  />
                            <?php echo form_error('sub_category_name'); ?> </div></td>
                </tr>
                <tr>
                    <td>Mandatory Capsule:</td>
                    <td><div class="field">
                            <ul>
                                <?php foreach($capsule_list as $row){ ?>
                                <li>
                                    <?php
              				$checkbox_data = array('name'=>"check[".$row['capsule_type_id']."]",'class' => "u");
					        foreach($selected_capsule as $checked)
							{
								if($row['capsule_type_id'] == $checked['capsule_type_id'])
								{
									 $checkbox_data = array('name'=>"check[".$row['capsule_type_id']."]",'class' => "u",'checked'=>"checked");
									 break;
								}
						    }
				            
							 if($row['capsule_type_id'] == 5)
								{
						            $checkbox_data = array('name'=>"check[".$row['capsule_type_id']."]",
														   'class' => "u",
														   'checked'=>"checked",
														   'disabled' => "disabled"
														   );
								}

							echo form_checkbox($checkbox_data)." ".$row['name']; ?>
                                </li>
                                <?php }?>
                            </ul>
                            
                            <!-- checkbox and name of capsule type generated by database on run time --> 
                        </div></td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td><div class="field">
                            <select name="is_active" id="is_active">
                                <option value="1" id="active" <?php echo $status =($sub_category_detail['is_active']==1)?'selected':'' ?> >Active </option>
                                <option value="0" id="deactive" <?php echo $status =($sub_category_detail['is_active']==0)?'selected':'' ?>>De-active</option>
                            </select>
                        </div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" class="btnorange" value="Save" name="save" />
                        <input type="submit" class="btngrey" value="Cancel"  name="cancel" /></td>
                </tr>
            </table>
            <div class="clear"></div>
        </div>
        </form>
    </div>
    <div class="clear"></div>
</div>
<!--Wrapper End--> 