<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">

    
	<a href="javascript:void(0);" class="btnedit">
    <span class="para"></span>Paragraph<span class="edit"></span></a>

	
	<a onclick="saveParagraphContent('<?php echo $post_id?>','<?php echo $capsule_id?>')" href="javascript:void(0);" class="btnorange tooltip" title="This is a paragraph block. To populate it, Click on the button and that would open the edit area">Save</a>
    <div class="editbox">    
		<div class="contentbox">
		<div class="editbar">
		Paragraph Title: <input type="text" name="paragraph_title" value="" class="inputmain"/></div>		
			<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
			<input type="hidden" name="paragraph_id" value="0"/>
			<textarea name="paragraph_value" id="paragraph-<?php echo $capsule_id?>" cols="105" rows="5"></textarea>
		</div>

	</div>

</form>
<script>
new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','upload'], iconsPath : 'images/nicEditorIcons.gif'}).panelInstance('paragraph-<?php echo $capsule_id?>');
</script>
</div>