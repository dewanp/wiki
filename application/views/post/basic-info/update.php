<script type="text/javascript" >
$(document).ready(function(){

$(function(){
				
		$('.cbox, .cbox-selected').bind("click", function () {
				if ($(this).attr('class') == 'cbox') {
					$(this).children('input').attr('checked', true);
					$(this).removeClass().addClass('cbox-selected');
					$(this).children('input').trigger('change');
				}
				else {
					$(this).children('input').attr('checked', false);
					$(this).removeClass().addClass('cbox');
					$(this).children('input').trigger('change');
				}
			});
		});

	var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'upload/do_upload',
			name: 'postImage',
			data: {field_name:'postImage',folder_name:'post'},
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
					status.html('<div class="user-thmb-block"><div class="user-profile-thmb"><img src="images/loader.gif" alt="Loading.." /></div></div>');
					$("#upload").hide();
					//status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				var output = $.parseJSON(response);
				if(output.status){
					$("#upload").hide();
					
					var previewHTML = '<div class="user-thmb-block"><div class="user-profile-thmb" id="post-img"></div><div class="change-pro-pic"><a href="javascript:void(0);"  onclick="prepareConfirmPopup(this,\'Are you sure?\')">Delete</a><div class="adl"><a href="javascript:void(0)" onclick="deletePostImage(\''+output.data.file_upload_id+'\');" class="btnorange">Yes</a></div></div></div>';					
					$("#files").html(previewHTML);
					$("#file_upload_id").val(output.data.file_upload_id);
					showImage(output.data.file_upload_id,'110','110','post-img');
				}else{
					$("#files").html(output.data);
				}				
			}		
		});
	
	// Custom Break Characters
		$('input.tag').tagedit({
			autocompleteURL: site_url+'post/tagAutocomplete',
			allowEdit: false,
			allowDelete: false,
			additionalListClass : 'inputmain',
			// return, comma, space, period, semicolon
			breakKeyCodes: [ 13, 44, /*32,*/ 46, 59 ]
		});

		$( "#post_zip_code" ).autocomplete({
			source: site_url + "post/cityAutocomplete",
			minLength: 3,
			select: function( event, ui ) {
				// call back function
			}
		});



});
</script>
<div class="titlebox mart20">
	<form action="" method="post" enctype="multipart/form-data" class="create-step" id="postEditBasicInfo" name="postAdd">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcreate-step">
	<tr>
	<td valign="top"><label class="name">Post Image</label></td>
	<td>
	<div class="postddmain">
		<input type="hidden" name="file_upload_id" id="file_upload_id" value="<?php echo $post['post_image'];?>"/>
		<span id="status"></span>
		<div id="files"><?php if($post['post_image']>0){?>
	<div class="user-thmb-block"><div class="user-profile-thmb" id="post-img">
	<img src="images/loader.gif" alt= "" ></div>
		<div class="change-pro-pic">
			<a href="javascript:void(0);"  onclick="prepareConfirmPopup(this,'Are you sure?')">Delete</a>
			<div class="adl">
				<a class="btnorange" href="javascript:void(0)" onclick="deletePostImage('<?php echo $post['post_image'];?>');">Yes</a>
			</div>
		</div>
	</div>
		<script> showImage('<?php echo $post["post_image"]; ?>','110','110','post-img');</script>
		<?php }?>
		</div>
		<input type="button" class="btnorange" value="Upload File" id="upload"/>
		<?php if($post['post_image']){?>
			<script> $("#upload").hide();</script>
		<?php }?>
		
	</div>
	</td>
	</tr>
	<tr>
	<td valign="top"><label class="name">Choose a suitable title</label></td>
	<td><input type="text" class="inputmain required" name="title" id="title" value="<?php echo $post['title']; ?>"/>
	<span id="title_error" class="error"></span>
	<span class="note">*Keep the title small and concise to make it easily searchable.</span>
	</td>
	</tr>

	<tr>
	<td valign="top"><label class="name">Description about post</label></td>
	<td><textarea cols="" rows="" class="inputmain required" name="description" id="description"><?php echo $post['description']; ?></textarea>
	<span id="description_error" class="error"></span>
	</td>
	</tr>

	<tr>
	<td valign="top"><label class="name">Provide tags ( at least 2)</label></td>
	<td> 
	<?php foreach($tags as $row){	?>
	<input type="text" name="tag[<?php echo $row['tag_id'];?>-a]" value="<?php echo $row['name'];?>" id="tagedit-input" class="tag"/>
	<?php }?>
	
	<input type="text" name="tag[]" value="" id="tagedit-input" class="tag"/>	
	<span id="tag_error" class="error"></span>
    <span class="note">*Provide the tags which best describe your post.</span>
	</td>
	</tr>
	<tr>
		<td>&nbsp; </td>
		<td> <div class="checkboxmain">
		
              <div class="<?php if($post['general_post']){?>cbox-selected<?php }else{?>cbox<?php }?>">
                <input type="checkbox" name="general_post" id="general_post" value="1" <?php if($post['general_post']){?>checked= "checked"<?php }?> />
                <label for="general_post">This is a General post</label>
                 </div>
            </div>
		</td>
	</tr>
	<tr> 
		<td>&nbsp; </td>
		<td><div class="checkboxmain" style="width:150px;" onclick="if($('#local-post-checkbox').hasClass('cbox-selected')){ $('#localzipcode').show()}else{$('#localzipcode').hide()}">
		
              <?php if($isZipCode){?>
			  <div class="<?php if($post['local_post']){?>cbox-selected<?php }else{?>cbox<?php }?>" id="local-post-checkbox">
                <input type="checkbox" name="local_post" id="local_post" value="1" <?php if($post['local_post']){?>checked= "checked"<?php }?> />
                <label for="local_post">This is a local post</label>
              </div>
		   <?php }?>
            </div> </td>
	</tr>

	<tr id="localzipcode" <?php if($post['local_post']){?><?php }else{?>style="display:none;"<?php }?>>
		<td valign="top"><label class="name">Zip Code</label></td>
		<td>
		<input name="post_zip_code" type="text" class="inputmain zip" id="post_zip_code" value="<?php echo $post['post_zip_code'];?>" />
		<span id="post_zip_code_error" class="error"></span>
		</td>
    </tr>
	
	<tr>
	<td>&nbsp;</td>
	<td>
	<input type="hidden" name="post_id" value="<?php echo $post_id?>" />
	<input type="submit" class="btnorange" value="Save" onclick="savePostBasicInfo('<?php echo $post_id?>'); return false"/></td>
	</tr>
	</table>

	</form>
</div>