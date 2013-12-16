<!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE -->
<div id="mediaplayer">JW Player goes here</div>

<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">
	jwplayer("mediaplayer").setup({
		flashplayer: "/jwplayer/player.swf",
		file: "/jwplayer/video.mp4",
		'width': '650',
	    'height': '240',
		'playlist.position': 'right',
		'playlist.size': '250',
		'playlist': [
			{
			   file: '/jwplayer/video.mp4',
			   title: 'Big Buck Bunny Trailer',
			   image: 'http://thumbnails.server.com/thumbs/bunny.jpg',
			   //duration: '33.03',
			   description: 'An animated short from the Blender project'
			},
			{
			   file: '/jwplayer/video.mp4',
			   title: 'Sintel',
			   image: 'http://thumbnails.server.com/thumbs/sintel.jpg',
			   //duration: '888.06',
			   description: 'An animated short from the Blender project'
			},
			{
			   file: '/jwplayer/video.mp4',
			   title: 'Elephant´s Dream',
			   image: 'http://thumbnails.server.com/thumbs/elephant.jpg',
			   //duration: '653.79',
			   description: 'An animated short from the Blender project'
			}
		]

	});
</script>
<!-- END OF THE PLAYER EMBEDDING -->
<table>
<script type="text/javascript">
	$(function()
	{
			$('.password').pstrength();
	});
</script>
<script type="text/javascript" >
	function deletePostImage(file_upload_id){
		ajaxCall('upload/delete','file_upload_id='+file_upload_id)
		$("#files").html('');
		$("#upload").show();
	}
	$(function(){
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
				alert(response);
				var output = $.parseJSON(response);
				if(output.status){
					$("#upload").hide();
					var newelement = document.createElement('img');
					newelement.src = output.data.file_upload_file_path;
					newelement.alt = "";
					newelement.height=100;
					newelement.width=100;
					var delimg = '<a href="javascript:void(0)" onclick="deletePostImage(\''+output.data.file_upload_id+'\');">Delete</a>';
					$("#files").html(newelement);
					var hiddenele = document.createElement('input');
					hiddenele.type = 'hidden';
					hiddenele.name = 'file_upload_id';
					hiddenele.value = output.data.file_upload_id;
					$("#files").append(hiddenele);
					$("#files").append(delimg);

				}else{
					$("#files").html(output.data);
				}
				
			}
		});
		
	});
</script>
<tr>
	<td>
		Name:
	</td>
	<td>
		
		<span id="status" ></span>
	<div id="files"></div><div id="upload" ><span>Upload File<span></div>
	</td>
</tr>
<tr>
	<td>
		Name:
	</td>
	<td>
		<div id="profile-name-div">
			<?php echo '<span id="profile_name_span">'.$user_detail['profile_name'].'</span>';?>
			<span style="color:green;" onclick="onlyShow('profile-name-edit-div');onlyHide('profile-name-div')">(Change)</span>
		</div>
		<div id="profile-name-edit-div" style="display:none;">
			<input type="text" name="profile_name" id="profile_name" value="<?php echo $user_detail['profile_name'];?>"/>
			<span style="color:green;" onclick="editInputs('user','profile_name','profile_name','profile_name_span'); onlyHide('profile-name-edit-div');onlyShow('profile-name-div')">(Save)</span>
		</div>
	</td>
</tr>


</table>

