<script type="text/javascript" >
$(function(){
		var btnUpload=$('#upload-<?php echo $capsule_id?>');
		var status = $('#status-<?php echo $capsule_id?>');
		var img_container = $('#image-data-wrapper-<?php echo $capsule_id?>'); 
		new AjaxUpload(btnUpload, {
			action: 'upload/do_upload',
			name: 'capsuleImages',
			data: {field_name:'capsuleImages',folder_name:'post/post-id-<?php echo $post_id?>/images'},
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
				
				var output = jQuery.parseJSON(response);					
				
				if(output.status){
								
					var newimgelement = "<div class=\"imageedit\" id=\"uploaded-img-"+output.data.file_upload_id+"\"><div class=\"thumb\" id=\"capsule-img-"+output.data.file_upload_id+"\"></div><input type=hidden name=file_upload_id[] value=\""+output.data.file_upload_id+"\"/><input type=hidden name=image_id[] value=\"0\"/><div class=\"img-title\"><input type=text name=capsule_image_title[] value=\"\" class=\"img-title-inputmain d-req\" onfocus=\"$(this).removeClass('error-border');\"/></div><div class=\"img-description\"><textarea name=capsule_image_description[] class=\"inputmain d-req\" onfocus=\"$(this).removeClass('error-border');\"></textarea></div><div class=\"infobox\"><span class=\"size\">Size : "+output.data.file_upload_file_size+" Kb</span><span class=\"nav\"><a href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\">Remove</a><div class=\"adl\"><a href=\"javascript:void(0);\" onclick=\"deleteCapsuleImage('<?php echo $post_id?>','<?php echo $capsule_id?>',"+output.data.file_upload_id+",'0');\" class=\"btnorange\">Yes</a></div></span></div></div>";					
					
					img_container.append(newimgelement);
					$("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text(parseInt($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text())+1);

					if($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text()>=$("#capsule-wrapper-<?php echo $capsule_id?> #total-allowed").text()){
						$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-img-button").hide();
					}else{
						$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-img-button").show();
					}
					showImage(output.data.file_upload_id,'123','100','capsule-img-'+output.data.file_upload_id);
					
					

				}else{
					status.text(output.data);				
				}
				
			}
		});
		
	});
</script>
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">
<div id="content-add-<?php echo $capsule_id?>" class="showcomment showcomment2">
	
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="image"></span>Image Set<span class="edit" onclick="saveImageContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');"></span></a></div>
	

<?php //print_r($capsule_data);?>
<div class="infoboxmain">
	<div class="infobox">
		<span class="value" id="total-uploaded"><?php echo count($capsule_content);?></span>
		<span class="txtinfo">Uploaded</span>
	</div>
	<div class="infobox">
		<span class="value" id="total-allowed">5</span> 
		<span class="txtinfo">Allow</span>
	</div>
	<div class="<?php if($capsule_data['is_gallery']) echo 'cbox-selected'; else echo 'cbox';?>">
		<input type="checkbox" id="is_gallery" name="is_gallery" value="<?php if($capsule_data['is_gallery']) echo '0'; else echo '1';?>" <?php if($capsule_data['is_gallery']) echo 'checked="checked"'; ?> />
		Gallery
	</div>
</div>

<a href="javascript:void(0);" onclick="saveImageContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');" class="btnorange savecaps">Save</a>


<div class="editbox">

<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>

<div id="image-data-wrapper-<?php echo $capsule_id?>">	
<?php if(!empty($capsule_content)){?>
	<?php foreach($capsule_content as $capsule_image){?>
		<div class="imageedit" id="uploaded-img-<?php echo $capsule_image['file_upload_id']?>">			
			<div class="thumb" id="capsule-img-<?php echo $capsule_image['file_upload_id']?>"><script> showImage('<?php echo $capsule_image["file_upload_id"]?>','105','127','capsule-img-<?php echo $capsule_image["file_upload_id"]?>');</script></div>
			<input type=hidden name=file_upload_id[] value="<?php echo $capsule_image['file_upload_id']?>"/>
			<input type=hidden name=image_id[] value="<?php echo $capsule_image['image_id']?>"/>
			<div class="img-title">
				<input type=text name=capsule_image_title[] value="<?php echo $capsule_image['title']?>" class="img-title-inputmain d-req" style="margin-bottom:5px;" onfocus="$(this).removeClass('error-border');"/>
			</div>
			<div class="img-description">
				<textarea name=capsule_image_description[] class="inputmain d-req" onfocus="$(this).removeClass('error-border');"><?php echo $capsule_image['description']?></textarea>
			</div>
			<div class="infobox">
				<span class="size"><?php echo $capsule_image['size']?> KB</span>
				<span class="nav">
					<a href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Remove</a>
					<div class="adl"><a href="javascript:void(0);" onclick="deleteCapsuleImage('<?php echo $post_id?>','<?php echo $capsule_id?>','<?php echo $capsule_image['file_upload_id']?>','<?php echo $capsule_image['image_id']?>');" class="btnorange">Yes</a></div>
				</span>
			</div>
		</div>
	<?php }?>
<?php }?>	
</div>
<div id="add-more-img-button"><span id="status-<?php echo $capsule_id?>" ></span>
<!-- <a href="javascript:void(0);" class="btnorange" id="upload-<?php //echo $capsule_id?>">Add More Image</a> -->
</div>

</div>
<script>
if($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text()>=$("#capsule-wrapper-<?php echo $capsule_id?> #total-allowed").text()){
		$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-img-button").hide();
}else{
	$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-img-button").show();
}
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
</script>
</div>
</form>