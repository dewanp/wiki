<script type="text/javascript">
$(function(){
		var btnUpload=$('#upload-<?php echo $capsule_id?>');
		var status = $('#status-<?php echo $capsule_id?>');
		var img_container = $('#image-data-wrapper-<?php echo $capsule_id?>'); 
		new AjaxUpload(btnUpload, {
			action: 'upload/do_video_upload',
			name: 'capsuleVideos',
			data: {field_name:'capsuleVideos',folder_name:'post/post-id-<?php echo $post_id?>/videos',file_type:'video'},
			onSubmit: function(file, ext){
				// if (! (ext && /^(mp4)$/.test(ext))){ 
				 if (! (ext && /^(mp4|flv|3gp)$/.test(ext))){ 
                    // extension is not allowed 
					//status.text('Only mp4 files are allowed');
					status.text('mp4|flv|3gp files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				
				var output = jQuery.parseJSON(response);
				if(output.status){
									
					
					var newimgelement = "<div class=\"imageedit video2\" id=\"uploaded-img-"+output.data.file_upload_id+"\"><div class=\"thumb\"><div id=\"mediaplayer-"+output.data.file_upload_id+"\"></div></div><input type=hidden name=file_upload_id[] value=\""+output.data.file_upload_id+"\"/><input type=hidden name=video_id[] value=\"0\"/><div class=\"img-title\"><input type=text name=video_title[] value=\"\" class=\"img-title-inputmain d-req\" onfocus=\"$(this).removeClass('error-border');\"/></div><div class=\"infobox\"><span class=\"size\">Size : "+output.data.file_upload_file_size+"</span><span class=\"nav\"><a href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\">Remove</a><div class=\"adl\"><a href=\"javascript:void(0);\" onclick=\"deleteCapsuleVideo('<?php echo $post_id?>','<?php echo $capsule_id?>',"+output.data.file_upload_id+",'0');\" class=\"btnorange\">Yes</a></div></span></div></div>";					
						
					img_container.append(newimgelement);
					$("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text(parseInt($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text())+1);

					if($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text()>=$("#capsule-wrapper-<?php echo $capsule_id?> #total-allowed").text()){
						$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-video-button").hide();
					}else{
						$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-video-button").show();
					}
					
					setTimeout(function(){
						
						jwplayer("mediaplayer-"+output.data.file_upload_id).setup({flashplayer: "jwplayer/player.swf",file: '<?php echo S3_URL.BUCKET_NAME; ?>/uploads/'+output.data.file_upload_file_path,width:200,height:150,image: '<?php echo S3_URL.BUCKET_NAME; ?>/uploads/'+output.data.file_upload_file_path+".jpg"});
					},500);

				}else{
					img_container.html(output.data);
				}
				
			}
		});


	// create post edit page tabs 
	$('.account-info-tab .float').bind("click",function(){
		  $(this).parent('.account-info-tab').children('.float').removeClass('active');
		  $(this).addClass('active');
		  $('#comp, #utube').hide();
		  var show2Tab=$('#'+$(this).attr('rel'));
		  setTimeout(function(){show2Tab.fadeIn();});
	
	});
});//ready function end

	function setActiveMenu(ths)
	{
		$(".tabBox ul.tabs li").each(function(){
			$(this).removeClass('selected');
			$("#"+$(this).attr('rel')).hide();
		});		
		$("#"+$(ths).attr('rel')).show();
		$(ths).addClass('selected');
	}

	function saveYoutubeVideo(field_id)
	{
		if($("#"+field_id).val()==""){
			$("#"+field_id).addClass('error-border');
			return false;
		}else{
			var img_container = $('#image-data-wrapper-<?php echo $capsule_id?>'); 
			$.ajax({
				type: "POST",
				url: site_url + 'upload/saveYoutubeVideo',
				data: 'data='+$("#"+field_id).val(),
				success: function (response){ 
				var output = jQuery.parseJSON(response);			
					if(output.status){													
						
						
						var newimgelement = "<div class=\"imageedit video2\" id=\"uploaded-img-"+output.data.file_upload_id+"\"><div class=\"thumb\"><div id=\"mediaplayer-"+output.data.file_upload_id+"\"></div></div><input type=hidden name=file_upload_id[] value=\""+output.data.file_upload_id+"\"/><input type=hidden name=video_id[] value=\"0\"/><div class=\"img-title\"><input type=text name=video_title[] value=\"\" class=\"img-title-inputmain d-req\" onfocus=\"$(this).removeClass('error-border');\"/></div><div class=\"infobox\"><span class=\"nav\"><a href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\">Remove</a><div class=\"adl\"><a href=\"javascript:void(0);\" onclick=\"deleteCapsuleVideo('<?php echo $post_id?>','<?php echo $capsule_id?>',"+output.data.file_upload_id+",'0');\" class=\"btnorange\">Yes</a></div></span></div></div>";					
						
						img_container.append(newimgelement);
						$("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text(parseInt($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text())+1);

						if($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text()>=$("#capsule-wrapper-<?php echo $capsule_id?> #total-allowed").text()){
							$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-video-button").hide();
						}else{
							$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-video-button").show();
						}
						
						jwplayer("mediaplayer-"+output.data.file_upload_id).setup({flashplayer: "jwplayer/player.swf",file: output.data.file_upload_file_path,width:200,height:150});

						$("#"+field_id).val('');

					}
			}});
		}
	}
</script>

<div id="content-add-<?php echo $capsule_id?>" class="showcomment showcomment2">
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="video"></span>Video<span class="edit" onclick="saveVideoContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');"></span></a></div>


<div class="infoboxmain">
	<div class="infobox">
		<span class="value" id="total-uploaded"><?php echo count($capsule_content);?></span>
		<span class="txtinfo">Uploaded</span>
	</div>
	<div class="infobox">
		<span class="value" id="total-allowed">5</span> 
		<span class="txtinfo">Allow</span>
	</div>
</div>

<a href="javascript:void(0);" onclick="saveVideoContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');" class="btnorange savecaps">Save</a>


<div class="editbox">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">
<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
<div>
	<div id="image-data-wrapper-<?php echo $capsule_id?>">
		<?php if(!empty($capsule_content)){?>
			<?php foreach($capsule_content as $capsule_video){?>
			<?php $video_base_path = S3_URL.BUCKET_NAME.'/uploads/'.$capsule_video['file_path'];?>
				<div class="imageedit video2" id="uploaded-img-<?php echo $capsule_video['file_upload_id']?>"><div class="thumb"><div id="mediaplayer-<?php echo $capsule_video['file_upload_id']?>"></div></div><div id="capsule-img-<?php echo $capsule_video['file_upload_id']?>"><script type="text/javascript">
				jwplayer("mediaplayer-<?php echo $capsule_video['file_upload_id']?>").setup({flashplayer: "jwplayer/player.swf",file: "<?php echo $video_base_path?>",width:200,height:150,image:"<?php echo $video_base_path?>.jpg"});
				</script><input type=hidden name=file_upload_id[] value="<?php echo $capsule_video['file_upload_id']?>"/><input type=hidden name=video_id[] value="<?php echo $capsule_video['video_id']?>"/></div><div class="image-right"><div class="img-title"><input type=text class="img-title-inputmain d-req" name=video_title[] value="<?php echo $capsule_video['title']?>" onfocus="$(this).removeClass('error-border');"/></div>
                <?php /*?><div class="img-description "><textarea class="inputmain d-req" name=video_description[] onfocus="$(this).removeClass('error-border');"><?php echo $capsule_video['description']?></textarea></div><?php */?></div>
				<div class="infobox"><span class="nav"><a href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Remove</a>
				<div class="adl"><a href="javascript:void(0);" onclick="deleteCapsuleVideo('<?php echo $post_id?>','<?php echo $capsule_id?>','<?php echo $capsule_video['file_upload_id']?>','<?php echo $capsule_video['video_id']?>');" class="btnorange">Yes</a></div></span></div></div>
			<?php }?>
		<?php }?>
	</div>
	
	
	<div id="add-more-video-button">
	<!--video tabs begin-->
	<div class="videotabs" id="videouploaddiv-<?php echo $capsule_id?>">
	<div class="account-sec-tab">
		<div class="account-info-tab">
			<div class="float active" rel="comp"> <span class="back"><span class="unlimited"></span></span> <span class="mid"><a href="javascript:void(0);">From your Computer</a></span> <span class="front"></span> </div>
			<div class="float" rel="utube"> <span class="back"></span> <span class="mid"><a href="javascript:void(0);">From You tube</a></span> <span class="front"></span> </div>
		</div>
	</div>
	<div class="computer" id="comp"> <span id="status-<?php echo $capsule_id?>" style="margin-left:54px;"></span>
		<div id="upload-<?php echo $capsule_id?>" style="width:210px;"><span style="margin-left:54px;">Upload File<span></div> </div>
	<div class="utube" id="utube" style="display:none;">
		<div class="tubeleft">Youtube video url:</div>
		<div class="tuberight">
			<input type="text" class="inputmain" name="youtube" id="youtube" onfocus="$(this).removeClass('error-border');"/>
			<a href="javascript:void(0);" class="loadvid" onclick="saveYoutubeVideo('youtube');">Load Video</a></div>
	</div>
	</div>
	<!--video tabs end-->
	</div>
	
	
</div>
</form>
</div>
<script>
if($("#capsule-wrapper-<?php echo $capsule_id?> #total-uploaded").text()>=$("#capsule-wrapper-<?php echo $capsule_id?> #total-allowed").text()){
			$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-video-button").hide();
		}else{
			$("#capsule-wrapper-<?php echo $capsule_id?> #add-more-video-button").show();
		}
</script>
</div>