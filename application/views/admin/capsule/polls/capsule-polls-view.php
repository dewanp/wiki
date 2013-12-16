<div id="content-edit-<?php echo $capsule_id?>" class="showcomment viewmode">
<h4><span class="polls-icon"></span>Polls</h4>
<div class="contentbox">					
	<?php if(!empty($capsule_content)){?>
		<h5><?php echo $capsule_content['0']['title']?></h5>
		
		<p><?php echo $capsule_content['0']['description']?></p>
		
		<div id="polls-container-<?php echo $capsule_id?>"></div>
			
		<script>
			pollsContent('<?php echo $capsule_id?>',"<?php echo $capsule_content[0]['polls_id']?>");
		</script>
	<?php }?>
</div>
</div>