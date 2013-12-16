<?php if(!empty($capsule_content)){?>
<div class="showcomment preview" id="content-preview-<?php echo $capsule_id?>">
	<h4><span class="para-icon"></span>Paragraph</h4>
	<div class="contentbox paragraph">
		<?php echo $capsule_content['0']['value']?>
	</div>
</div>
<?php }else{?>
<div class="showcomment preview" id="content-preview-<?php echo $capsule_id?>">
	<h4><span class="para-icon"></span>Paragraph</h4>	
</div>
<?php }?>