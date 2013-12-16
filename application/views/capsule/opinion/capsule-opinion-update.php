<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">    
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="opinion"></span>Reviews<span class="edit" onclick="saveOpinionContent('<?php echo $post_id?>','<?php echo $capsule_id?>')"></span></a></div>
		<a onclick="saveOpinionContent('<?php echo $post_id?>','<?php echo $capsule_id?>')" href="javascript:void(0);" class="btnorange savecaps">Save</a>
		<div class="editbox">		
			<div class="opinion">
                        
					<?php if(!empty($capsule_content)){?>
						
						
						<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
						<input type="text" class="inputmain d-req" value="<?php echo $capsule_content['0']['title']?>" name="title" onfocus="$(this).removeClass('error-border');"/>
						<input type="hidden" name="opinion_id" value="<?php echo $capsule_content['0']['opinion_id']?>"/>
			
						<div id="no-options-<?php echo $capsule_id?>-type-2" <?php if(count($capsule_content['options']['negative']) > 0){?>style="display:none;"<?php }else{?><?php }?>>
							<a href="javascript:void(0);" class="addmore" onclick="addOpinionOption('<?php echo $capsule_id?>','2')">Add Cons</a>
						</div>

						<div id="no-options-<?php echo $capsule_id?>-type-1" <?php if(count($capsule_content['options']['positive']) > 0){?>style="display:none;"<?php }else{?><?php }?>>
							<a href="javascript:void(0);" class="addmore" onclick="addOpinionOption('<?php echo $capsule_id?>','1')">Add Pros</a>
						</div>

						
						
						<div id="question-wrapper-<?php echo $capsule_id?>-type-1" <?php if(count($capsule_content['options']['positive']) > 0){?><?php }else{?>style="display:none;"<?php }?>>
							<div class="positives first">
								<h4>Positives</h4>
								<div id="options-<?php echo $capsule_id?>-type-1">
								
								<?php foreach($capsule_content['options']['positive'] as $key => $option){?>
									<div class="bulletbox">
											<span class="bullets"></span>
											<input type="hidden" name="option_id[]" value="<?php echo $option['option_id']?>" />
											<input type="hidden" name="option_type[]" value="<?php echo $option['type']?>" />
											<input type="text" class="inputmain d-req" value="<?php echo $option['title']?>" name="option_title[]" onfocus="$(this).removeClass('error-border');"/>
											
											<!-- Delete link -->
											<a class="delete" href="javascript:void(0);"  onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
											<div class="adl">
												<a class="btnorange" href="javascript:void(0);" rel="<?php echo $option['option_id']?>" onclick="deleteOpinionOption(this,'<?php echo $capsule_id?>','1')">Yes</a>
											</div>
											<!-- Delete link -->
									</div>
								<?php }?>
								
								</div>
								<a href="javascript:void(0);" class="addmore" onclick="addMoreOpinionOption('<?php echo $capsule_id?>','1')">Add more items</a>
							</div>							
						</div>

						<div id="question-wrapper-<?php echo $capsule_id?>-type-2" <?php if(count($capsule_content['options']['negative']) > 0){?><?php }else{?>style="display:none;"<?php }?>>
							<div class="positives first">
								<h4>Negatives</h4>
								<div id="options-<?php echo $capsule_id?>-type-2">
									<?php foreach($capsule_content['options']['negative'] as $key => $option){?>
										<div class="bulletbox">
												<span class="bullets"></span>
												<input type="hidden" name="option_id[]" value="<?php echo $option['option_id']?>" />
												<input type="hidden" name="option_type[]" value="<?php echo $option['type']?>" />
												<input type="text" class="inputmain d-req" value="<?php echo $option['title']?>" name="option_title[]" onfocus="$(this).removeClass('error-border');"/>
												
												<!-- Delete link -->
												<a class="delete" href="javascript:void(0);"  onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
												<div class="adl">
													<a class="btnorange" href="javascript:void(0);" rel="<?php echo $option['option_id']?>" onclick="deleteOpinionOption(this,'<?php echo $capsule_id?>','2')">Yes</a>
												</div>
												<!-- Delete link -->
										</div>
									<?php }?>
								</div>
								<a href="javascript:void(0);" class="addmore" onclick="addMoreOpinionOption('<?php echo $capsule_id?>','2')">Add more items</a>
							</div>
						</div>

						<div class="rating"> 
							<span class="txtrate" style="width:128px;">Rating <span id="rating<?php echo $capsule_id?>" style="float:right; margin-left: 5px;"><script>loadRating('<?php echo $capsule_id?>', true);</script></span></span>
							<div class="checkboxmain">
								<div class="<?php if($capsule_content['0']['is_rating']){?>cbox-selected<?php }else{?>cbox<?php }?>" style="margin:0;">
									<input type="checkbox" name="is_rating" value="1" <?php if($capsule_content['0']['is_rating']){?>selected="selected"<?php }else{?><?php }?>/>
									No rating to be shown
								</div>
							</div>							
						</div>
												
									
					
					<?php }else{?>
						
						
						<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
						<input type="text" class="inputmain d-req" value="" name="title" />
						<input type="hidden" name="polls_id" value="0"/>
						
						<div id="no-options-<?php echo $capsule_id?>-type-2">
							<a href="javascript:void(0);" class="addmore" onclick="addOpinionOption('<?php echo $capsule_id?>','2')">Add Cons</a>
						</div>

						<div id="no-options-<?php echo $capsule_id?>-type-1">
							<a href="javascript:void(0);" class="addmore" onclick="addOpinionOption('<?php echo $capsule_id?>','1')">Add Pros</a>
						</div>
						
						

						<div id="question-wrapper-<?php echo $capsule_id?>-type-1" style="display:none">
							<div class="positives first">
								<h4>Positives</h4>
								<div id="options-<?php echo $capsule_id?>-type-1"></div>
								<a href="javascript:void(0);" class="addmore" onclick="addMoreOpinionOption('<?php echo $capsule_id?>','1')">Add more items</a>
							</div>							
						</div>

						<div id="question-wrapper-<?php echo $capsule_id?>-type-2" style="display:none">
							<div class="positives first">
								<h4>Negatives</h4>
								<div id="options-<?php echo $capsule_id?>-type-2"></div>
								<a href="javascript:void(0);" class="addmore" onclick="addMoreOpinionOption('<?php echo $capsule_id?>','2')">Add more items</a>
							</div>
						</div>

						<div class="rating"> 
							<span class="txtrate" style="width:128px;">Rating <span id="rating<?php echo $capsule_id?>" style="float: right;"><script> setTimeout("loadRating('<?php echo $capsule_id?>', true)",1000);</script></span></span>
							<div class="checkboxmain">
								<div class="cbox" style="margin:0;">
									<input type="checkbox" name="is_rating" value="1"/>
									No rating to be shown
								</div>
							</div>
						</div>
					
					
					<?php }?>
					<script>
							$(function(){
								$('.cbox, .cbox-selected').bind("click", function () {
									if ($(this).attr('class') == 'cbox') {
										$(this).children('input').attr('checked', true);
										$(this).removeClass().addClass('cbox-selected');
										$(this).children('input').trigger('change');
									}
									else {
										$(this).children('input').attr('checked', false);
										$(this).removeClass().addClass('cbox');
										$(this).children('input').trigger('change');
									}
								});
							});
					</script>
                    </div>
			
		</div>
		
</form>
</div>