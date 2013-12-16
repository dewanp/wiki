<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">    
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="para"></span>Paragraph<span class="edit" onclick="saveParagraphContent('<?php echo $post_id?>','<?php echo $capsule_id?>');"></span></a></div>
		<a onclick="saveParagraphContent('<?php echo $post_id?>','<?php echo $capsule_id?>')" href="javascript:void(0);" class="btnorange savecaps">Save</a>
		<div class="editbox">		
			
				<?php if(!empty($capsule_content)){?>
					<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
					<input type="hidden" name="paragraph_id" value="<?php echo $capsule_content['0']['paragraph_id']?>"/>
					<textarea name="paragraph_value" id="paragraph-<?php echo $capsule_id?>"  rows="5"><?php echo $capsule_content['0']['value']?></textarea>
				<?php }else{?>
					<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
					<input type="hidden" name="paragraph_id" value="0"/>
					<textarea name="paragraph_value" id="paragraph-<?php echo $capsule_id?>"  rows="5"></textarea>
				<?php }?>
			
		</div>
		
</form>
<script>
new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','upload','link','unlink'], iconsPath : 'images/nicEditorIcons.gif'}).panelInstance('paragraph-<?php echo $capsule_id?>');
</script>
</div>