<script type="text/javascript" >
$(document).ready(function(){

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
				status.text('Uploading...');
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
					myShowImage(output.data.file_upload_id,'110','110','post-img');
				}else{
					$("#files").html(output.data);
				}				
			}		
		});
	/* js code for autocomplete*/
	
	/*$("#post-tags").fcbkcomplete({json_url: site_url+"home/tagAutocomplete",addontab: true, maxitems: 10,input_min_size: 0,height: 10,cache: false, newel: true, select_all_text: "",width: 347});
	/* end js code for autocomplete*/
	// Custom Break Characters
		$('input.tag').tagedit({
			autocompleteURL: site_url+'home/tagAutocomplete',
			allowEdit: false,
			allowDelete: false,
			additionalListClass : 'inputmain',
			// return, comma, space, period, semicolon
			breakKeyCodes: [ 13, 44, 32, 46, 59 ]
		});
		
});
</script>
<?php //print_r($post);?>
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
	<div class="user-thmb-block"><div class="user-profile-thmb" id="post-img"></div>
		<div class="change-pro-pic">
			<a href="javascript:void(0);"  onclick="prepareConfirmPopup(this,'Are you sure?')">Delete</a>
			<div class="adl">
				<a class="btnorange" href="javascript:void(0)" onclick="deletePostImage('<?php echo $post['post_image'];?>');">Yes</a>
			</div>
		</div>
	</div>
		<script> myShowImage('<?php echo $post["post_image"]; ?>','102','127','post-img');</script>
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
	<td valign="top" style="width:30%"><label class="name">Choose a suitable title</label></td>
	<td><input type="text" class="inputmain required" name="title" id="title" value="<?php echo $post['title']; ?>"/>
	<?php echo form_error('title'); ?>	
	<span class="note">*Keep the title small and concise to make it easily searchable.</span>
	</td>
	</tr>

	<tr>
	<td valign="top"><label class="name">Description</label></td>
	<td><textarea cols="" rows="" class="inputmain required" name="description" id="description"><?php echo $post['description']; ?></textarea>
	<?php echo form_error('description'); ?>
	<span class="note">*Provide the tags which best describe your post.</span>
	</td>
	</tr>

	<tr>
	<td valign="top"><label class="name">Provide tags ( at least 2)</label></td>
	<td><?php foreach($tags as $row){	?>
	<input type="text" name="tag[<?php echo $row['tag_id'];?>-a]" value="<?php echo $row['name'];?>" id="tagedit-input" class="tag"/>
	<?php }?>
	
	<input type="text" name="tag[]" value="" id="tagedit-input" class="tag"/>		
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

