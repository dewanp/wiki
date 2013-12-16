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
				status.html('<div class="user-thmb-block"><div class="user-profile-thmb"><img src="images/loader.gif" alt="Loading.." /></div></div>');
				$("#upload").hide();
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.html('');
				var output = $.parseJSON(response);
				if(output.status){
					$("#upload").hide();					
					var previewHTML = '<div class="user-thmb-block"><div class="user-profile-thmb" id="post-img"></div><div class="change-pro-pic"><a href="javascript:void(0)" onclick="deletePostImage(\''+output.data.file_upload_id+'\');">Delete</a></div></div>';					
					$("#files").html(previewHTML);
					$("#file_upload_id").val(output.data.file_upload_id);
					showImage(output.data.file_upload_id,'110','110','post-img');
				}else{
					$("#files").html(output.data);
				}				
			}		
		});
	/* js code for autocomplete*/
	
	$("#post-tags").fcbkcomplete({json_url: site_url+"post/tagAutocomplete",addontab: true, maxitems: 10,input_min_size: 0,height: 10,cache: false, newel: true, select_all_text: "",width: 347});
	/* end js code for autocomplete*/
	
	
	// The select element to be replaced:
	var select = $('select.add-post-category-fancy');


	var selectBoxContainer = $('<div>',{
		width		: select.outerWidth(),
		className	: 'tzSelect',
		html		: '<div class="selectBox"></div>'
	});

	var dropDown = $('<ul>',{className:'dropDown'});
	var selectBox = selectBoxContainer.find('.selectBox');
	
	// Looping though the options of the original select element
	
	select.find('option').each(function(i){
		var option = $(this);
		
		if(i==select.attr('selectedIndex')){
			selectBox.html(option.text());
		}
		
		// As of jQuery 1.4.3 we can access HTML5 
		// data attributes with the data() method.
		
		if(option.data('skip')){
			return true;
		}
		
		// Creating a dropdown item according to the
		// data-icon and data-html-text HTML5 attributes:
		
		var li = $('<li>',{
			html:	'<img src="'+option.data('icon')+'" /><span>'+
					option.data('html-text')+'</span>'
		});
				
		li.click(function(){
			
			selectBox.html(option.text());
			dropDown.trigger('hide');
			
			// When a click occurs, we are also reflecting
			// the change on the original select element:
			select.val(option.val());
			
			return false;
		});
		
		dropDown.append(li);
	});
	
	selectBoxContainer.append(dropDown.hide());
	select.hide().after(selectBoxContainer);
	
	// Binding custom show and hide events on the dropDown:
	
	dropDown.bind('show',function(){
		
		if(dropDown.is(':animated')){
			return false;
		}
		
		selectBox.addClass('expanded');
		dropDown.slideDown();
		
	}).bind('hide',function(){
		
		if(dropDown.is(':animated')){
			return false;
		}
		
		selectBox.removeClass('expanded');
		dropDown.slideUp();
		
	}).bind('toggle',function(){
		if(selectBox.hasClass('expanded')){
			dropDown.trigger('hide');
		}
		else dropDown.trigger('show');
	});
	
	selectBox.click(function(){
		dropDown.trigger('toggle');
		return false;
	});

	// If we click anywhere on the page, while the
	// dropdown is shown, it is going to be hidden:
	
	$(document).click(function(){
		dropDown.trigger('hide');
	});
});

$(document).ready(function(){
	
	// The select element to be replaced:
	var select = $('select.add-post-sub-category-fancy');


	var selectBoxContainer = $('<div>',{
		width		: select.outerWidth(),
		className	: 'tzSelect',
		html		: '<div class="selectBox"></div>'
	});

	var dropDown = $('<ul>',{className:'dropDown'});
	var selectBox = selectBoxContainer.find('.selectBox');
	
	// Looping though the options of the original select element
	
	select.find('option').each(function(i){
		var option = $(this);
		
		if(i==select.attr('selectedIndex')){
			selectBox.html(option.text());
		}
		
		// As of jQuery 1.4.3 we can access HTML5 
		// data attributes with the data() method.
		
		if(option.data('skip')){
			return true;
		}
		
		// Creating a dropdown item according to the
		// data-icon and data-html-text HTML5 attributes:
		
		var li = $('<li>',{
			html:	'<img src="'+option.data('icon')+'" /><span>'+
					option.data('html-text')+'</span>'
		});
				
		li.click(function(){
			
			selectBox.html(option.text());
			dropDown.trigger('hide');
			
			// When a click occurs, we are also reflecting
			// the change on the original select element:
			select.val(option.val());
			
			return false;
		});
		
		dropDown.append(li);
	});
	
	selectBoxContainer.append(dropDown.hide());
	select.hide().after(selectBoxContainer);
	
	// Binding custom show and hide events on the dropDown:
	
	dropDown.bind('show',function(){
		
		if(dropDown.is(':animated')){
			return false;
		}
		
		selectBox.addClass('expanded');
		dropDown.slideDown();
		
	}).bind('hide',function(){
		
		if(dropDown.is(':animated')){
			return false;
		}
		
		selectBox.removeClass('expanded');
		dropDown.slideUp();
		
	}).bind('toggle',function(){
		if(selectBox.hasClass('expanded')){
			dropDown.trigger('hide');
		}
		else dropDown.trigger('show');
	});
	
	selectBox.click(function(){
		dropDown.trigger('toggle');
		return false;
	});

	// If we click anywhere on the page, while the
	// dropdown is shown, it is going to be hidden:
	
	$(document).click(function(){
		dropDown.trigger('hide');
	});
});
</script>
<div class="titlebox mart20">
	<form action="" method="post" enctype="multipart/form-data" class="create-step" id="postAdd" name="postAdd">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcreate-step">
	<tr>
	<td valign="top"><label class="name">Post Image</label></td>
	<td>
	<div class="postddmain">
		<input type="hidden" name="file_upload_id" id="file_upload_id" value="<?php echo set_value('file_upload_id',0); ?>"/>
		<span id="status"></span>
		<div id="files"><?php if($post['post_image']>0){?>
		<div class="user-thmb-block"><div class="user-profile-thmb" id="post-img"></div><div class="change-pro-pic"><a href="javascript:void(0)" onclick="deletePostImage('<?php echo $this->input->post("file_upload_id"); ?>');">Delete</a></div></div>
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
	<td valign="top"><label class="name">Select what best describes your post</label></td>
	<td><div class="postddmain">

	<select name="category" id="category" class="required add-post-category-fancy">
	
	<?php foreach($category_list as $category){?>
	<option data-icon="images/how-to-items.png" value="<?php echo $category['category_id']?>" <?php echo set_select('category', $category['category_id']); ?> data-html-text="<?php echo $category['name']?>" <?php if($category['category_id']==$post['category_id']){?>selected="selected"<?php }?>><?php echo $category['name']?></option>
	<?php }?>
	</select>
	</div></td>
	</tr>
	<tr>
	<td valign="top"><label class="name">Select a subcategory</label></td>
	<td>

	<select name="sub_category" id="sub_category" class="required add-post-sub-category-fancy">
	<?php foreach($sub_category_list as $sub_category){?>
	<option data-icon="images/how-to-items.png" value="<?php echo $sub_category['sub_category_id']?>" <?php echo set_select('sub_category', $sub_category['sub_category_id']); ?> data-html-text="<?php echo $sub_category['name']?>" <?php if($sub_category['sub_category_id']==$post['sub_category_id']){?>selected="selected"<?php }?>><?php echo $sub_category['name']?></option>
	<?php }?>
	</select>

	<?php echo form_error('sub_category'); ?>	
	</td>
	</tr>
	<tr>
	<td valign="top"><label class="name">Choose a suitable title</label></td>
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
	<td><select id="post-tags" name="tag" class="inputmain required">
	<?php if(!empty($tags)){?>
	<?php foreach($tags as $tag){?>
	<?php if($tag){?>
	<option value="<?php echo $tag['name']?>" class="selected"><?php echo $tag['name']?></option>
	<?php }?>
	<?php }?>
	<?php }?>
	</select>		
	</td>
	</tr>
	<tr>
	<td valign="top">&nbsp;</td>
	<td>

	<div class="radio">
	<input type="radio" name="access_type" value="1"  id="at1" class="designer required" <?php if($post['access_type']==1){?>checked="checked"<?php }?>/> <label for="at1">This is a general post</label></div>
	<div class="radio">
	<input type="radio" name="access_type" value="0"   id="at2" class="designer required" <?php if($post['access_type']==0){?>checked="checked"<?php }?>/> <label for="at2">This is a local post</label></div>
	
	</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btnorange" value="Save" onclick="postBasicInfo('<?php echo $post_id?>','view'); return false"/></td>
	</tr>
	</table>

	</form>
</div>

