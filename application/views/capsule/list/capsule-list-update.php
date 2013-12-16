<div id="content-add-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">
<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
	<div class="editbtnmain">
		<a href="javascript:void(0);" class="btnedit">
			<span class="list"></span>List Item<span class="edit" onclick="saveListContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');"></span>
		</a>
	</div>

	<a onclick="saveListContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');" href="javascript:void(0);" class="btnorange savecaps" title="This is a paragraph block. To populate it, Click on the button and that would open the edit area">Save</a>
<div class="editbox">
	<div class="listedit">
		<?php if(!empty($capsule_content)){?>
			<span class="listhead">List heading goes here</span>
            <input type="text" value="<?php echo $capsule_content[0]['title'];?>" class="inputmain d-req" name="list_title[]" onfocus="$(this).removeClass('error-border');">			
			<div class="order-this" id="list-capsule-<?php echo $capsule_id?>">
			<?php foreach($capsule_content as $capsule_list){?>			
				<div class="bulletbox">
					<span class="bullets">List Item</span>
					<input type=hidden name="list_id[]" value="<?php echo $capsule_list['list_id'];?>" />					
					<input type="text" value="<?php echo $capsule_list['description'];?>" class="inputmain d-req etraddmore" name="list_description[]" onfocus="$(this).removeClass('error-border');">
						<!-- Delete link -->
						<a class="delete" href="javascript:void(0);"  onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
						<div class="adl">
							<a class="btnorange" href="javascript:void(0);" rel="<?php echo $capsule_list['list_id'];?>" onclick="deleteListItem(this,'<?php echo $capsule_id?>')">Yes</a>
						</div>
						<!-- Delete link -->
						
				</div>			
			<?php }?>
			</div>
		<?php }else{?>
			<!-- First time list add form -->
			<span class="listhead">List heading goes here</span>
            <input type="text" value="" class="inputmain" name="list_title[]">	
			<div class="order-this" id="list-capsule-<?php echo $capsule_id?>">
				<div class="bulletbox">
					<span class="bullets">List Item</span>
					<input type=hidden name="list_id[]" value="" />					
					<input type="text" value="" class="inputmain d-req etraddmore" name="list_description[]" onfocus="$(this).removeClass('error-border');">
				</div>
			</div>
			<!-- End First time list add form -->
		<?php }?>		
	</div>
	<a class="addmore" href="javascript:void(0);" onclick="addMoreList('<?php echo $capsule_id?>')">Add more items</a>
</div>
<script>
$(document).ready(function(){
$('.etraddmore').live('keyup',function(e) {
	if(e.keyCode == 13) {
		addMoreList('<?php echo $capsule_id?>');
		
	}
});
});
</script>
</form>
</div>