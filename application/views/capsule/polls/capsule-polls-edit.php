<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">    
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="polls"></span>Polls<span class="edit" onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');"></span></a></div>
		
        <?php if($capsule_data['mandatory'] == 0){ ?>
        <a href="javascript:void(0)" onclick="prepareConfirmPopupCapsule(this,'Are you sure?')" class="image-orange" title="Delete Poll"></a><div class="adl"><a href="javascript:void(0)" onclick="capsuleDelete('6','<?php echo $capsule_id?>','<?php echo $post_id?>')" class="btnorange">Yes</a></div>
        <?php }?>
        
        <a onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');" href="javascript:void(0);" class="btnorange">Edit</a>
		<div class="editbox">		
			<div class="contentbox">		
							
				<?php if(!empty($capsule_content)){?>
					<h5><?php echo $capsule_content['0']['title']?></h5>
					
					<div id="polls-container-<?php echo $capsule_id?>"></div>
						
					<script>
						pollsContent('<?php echo $capsule_id?>',"<?php echo $capsule_content[0]['polls_id']?>");
					</script>
				<?php }?>
			</div>
		</div>
</form>
</div>