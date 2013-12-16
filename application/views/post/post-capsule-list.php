<?php if(!empty($post_capsules)){?>
	<script>
		
	function add_capsule_popup_done()
	{
				var new_added_capsules = $("form#form-selected-elements").serialize();
					$.ajax({
						type: "POST",
						url: site_url + "capsule/add",
						data: new_added_capsules,
						success: function (data){ 
							$("#selected-elements").html('');
							
							updatePostCapsuleList($("#post_id").val());
							updatePostCapsuleWrapper($("#post_id").val(),'edit');	
							closePopDiv('add-blocks');
														
						}
					});
	}

	function add_capsule_popup_cancel()
	{
		$("#selected-elements").html('');
		closePopDiv('add-blocks');
	}

	function selectCapsule(capsule_type,capsule_data)
	{
		if($("#selected-elements .rows").length<6)
		{
			var selectedHtml = '<div class="rows"><a href="javascript:void(0);" class="'+capsule_type+'">'+capsule_type+'</a><a href="javascript:void(0);" class="add" onclick="$(this).parent().remove();"></a><input type="hidden" name="post_new_capsules[]" value="'+capsule_data+'" /></div>';		
			$("#selected-elements").append(selectedHtml);
		}
	}
	// fixed code please dont touch
			$(function() {
				$( "#sidebar-capsule-container" ).sortable({
					items: "li:not(.comment)",
					beforeStop:function(event, ui) { 
						$.ajax({
							type: "POST",
							url: site_url + "capsule/order",
							data: $("form#sidebar-sort").serialize(),
							success: function (data){ 
								updatePostCapsuleWrapper($("#post_id").val(),'edit');
							}
						});
					}			
				});
			});
		// fixed code please dont touch
</script>


<div class="drag-blocks">
	<form id="sidebar-sort">
		<input type="hidden" id="post_id" value="<?php echo $post_id?>" />
		<div id="sidebar-capsule-container"><script> updatePostCapsuleList('<?php echo $post_id?>');</script></div>
	</form>
	<div class="note">
		<p>You can drag and drop the various blocks to arrange as you would like. So you can change the sequence of these as per the need. To add more elements here, click on the button below. </p>
	</div>
</div>
<div class="btnbox"> 
	<a onclick="openPopDiv('add-blocks');" class="btnorange" href="javascript:void(0);" hidefocus="true" style="outline: medium none;">Add more blocks</a> 
</div>


<!--popup Add blocks-->
<div class="popup" id="add-blocks" style="display:none;">
	<a href="javascript:void(0);" class="close" onclick="add_capsule_popup_cancel()"></a>
	<h2>Add More Blocks</h2>
	<div class="popupinner">
		<div class="note">
			<h5>You can add module by clicking on the '<span class="txtorange">+</span>' button. You can add module multiple number of times to add multiple times on your post</h5>
		</div>
		<div class="module">
			<div class="addmore-capsule-list">
				<?php foreach($capsules as $capsule){?>
					<?php if($capsule['name']!='comment'){?>
						<div class="rows">
							<a href="javascript:void(0);" class="<?php echo $capsule['name']?>"><?php echo $capsule['name']?></a>
							<a href="javascript:void(0);" class="add" onclick="selectCapsule('<?php echo $capsule['name']?>','<?php echo $capsule['name']?>-<?php echo $capsule['capsule_type_id']?>-<?php echo $post_id?>')"></a>
						</div>
					<?php }?>
				<?php }?>			
			</div>
		</div>
		<div class="module dropbox">
			<form id="form-selected-elements" name="form-selected-elements">	
				<div id="selected-elements"></div>
			</form>
		</div>
		<div class="btnbox">
			<a href="javascript:void(0);" class="btnorange" onclick="add_capsule_popup_done();">Done</a>
			<a href="javascript:void(0);" class="cancel" onclick="add_capsule_popup_cancel()">Cancel</a>
		</div>
	</div>
</div>
<!--popup Add blocks-->
<?php }?>