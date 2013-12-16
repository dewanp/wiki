<div id="content-add-<?php echo $capsule_id?>" class="showcomment showcomment2">
	
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="image"></span>Image Set<span class="edit" onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');"></span></a></div>
	

<div class="infoboxmain">
	<div class="infobox">
		<span class="value" id="total-uploaded"><?php echo count($capsule_content);?></span>
		<span class="txtinfo">Uploaded</span>
	</div>
	<div class="infobox">
		<span class="value" id="total-allowed">5</span> 
		<span class="txtinfo">Allow</span>
	</div>
	<!-- <div class="cbox" onClick="//this.className='cbox-selected';">
		<input type="checkbox" id="ar"/>
		Remember me
	</div> -->
	<div class="<?php if($capsule_data['is_gallery']) echo 'cbox-selected'; else echo 'cbox';?>">
		<input type="checkbox" id="is_gallery" name="is_gallery" disabled="disabled" value="<?php if($capsule_data['is_gallery']) echo '0'; else echo '1';?>" <?php if($capsule_data['is_gallery']) echo 'checked="checked"'; ?> />
		Gallery
	</div>
</div>

<a onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');" href="javascript:void(0);" class="btnorange">Edit Images</a>


<div class="editbox">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">
<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>

<div id="image-data-wrapper-<?php echo $capsule_id?>">	
<?php if(!empty($capsule_content)){?>
	<?php foreach($capsule_content as $capsule_image){?>
		
		<div class="imageedit">
                        <div class="contentbox contentbox2">
                            <div class="thumb" id="capsule-img-<?php echo $capsule_image['file_upload_id']?>"><script> showImage('<?php echo $capsule_image["file_upload_id"]?>','105','127','capsule-img-<?php echo $capsule_image["file_upload_id"]?>');</script></div>
                            <?php echo $capsule_image['title']?>
							<p><?php echo $capsule_image['description']?></p>
                            <div class="infobox"> <span class="size"><?php echo $capsule_image['size']?> KB</span></div>
                        </div>
        </div>		
	<?php }?>
<?php }?>	
</div>
</form>
</div>
</div>