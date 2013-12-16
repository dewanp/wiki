<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">    
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="polls"></span>Polls<span class="edit" onclick="savePollsContent('<?php echo $post_id?>','<?php echo $capsule_id?>');"></span></a></div>
		<a onclick="savePollsContent('<?php echo $post_id?>','<?php echo $capsule_id?>')" href="javascript:void(0);" class="btnorange savecaps">Save</a>
		<div class="editbox">		
			<div class="opinion">
				<div class="pollbox">
					<?php //print_r($capsule_content);?>
					<?php if(!empty($capsule_content)){?>
						
						
						<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
						<input type="text" class="inputmain d-req" value="<?php echo $capsule_content['0']['title']?>" name="title" onfocus="$(this).removeClass('error-border');"/>
						<input type="hidden" name="polls_id" value="<?php echo $capsule_content['0']['polls_id']?>"/>
						<textarea cols="" rows="" class="inputmain d-req" name="description" onfocus="$(this).removeClass('error-border');"><?php echo  $capsule_content['0']['description']?></textarea>
						
						<input type="hidden" name="is_options" value="<?php echo count($capsule_content['options']) > 2 ? 1:0 ?>" id="is_options-<?php echo $capsule_id?>"/>
						
						<div id="no-options-<?php echo $capsule_id?>" <?php if(count($capsule_content['options']) > 2){?>style="display:none;"<?php }else{?><?php }?>>
						<!-- <a href="javascript:void(0);" class="addmore" onclick="addPollsOption('<?php //echo $capsule_id?>')">Add Option</a> -->
						<span class="note"><span class="bold">Note :</span> In case you don't add these, there would only be options of YES and NO</span>
						</div>
						
						<div id="question-wrapper-<?php echo $capsule_id?>" <?php if(count($capsule_content['options']) > 2){?><?php }else{?>style="display:none;"<?php }?>>
							options <br />
							<div id="options-<?php echo $capsule_id?>">
							<?php foreach($capsule_content['options'] as $key => $option){?>
									<?php if($key < 2){?>
										<div>
										<input type="hidden" name="option_id[]" value="<?php echo $option['option_id']?>" />
										<input type="hidden" value="<?php echo $option['title']?>" name="option_title[]"/>
										</div>
									<?php }else{?>
										<div class="bulletbox">
											<span class="bullets"></span>
											<input type="hidden" name="option_id[]" value="<?php echo $option['option_id']?>" />
											<input type="text" class="inputmain d-req" value="<?php echo $option['title']?>" name="option_title[]" onfocus="$(this).removeClass('error-border');"/>
											<a class="delete" href="javascript:void(0);"  onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
											<div class="adl">
												<a class="btnorange" href="javascript:void(0);" rel="<?php echo $option['option_id']?>" onclick="deletePollsOption(this,'<?php echo $capsule_id?>')">Yes</a>
											</div>
										</div>
									<?php }?>
							<?php }?>							
							</div>							
							<!-- <a href="javascript:void(0);" class="addmore" onclick="addMorePollsOption('<?php// echo $capsule_id?>')">Add more items</a>  -->							
						</div>
						
					
					
					<?php }else{?>
						
						
						<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
						<input type="text" class="inputmain d-req" value="" name="title" onfocus="$(this).removeClass('error-border');"/>
						<input type="hidden" name="polls_id" value="0"/>
						<textarea cols="" rows="" class="inputmain d-req" name="description" onfocus="$(this).removeClass('error-border');"></textarea>
						
						<input type="hidden" name="is_options" value="0"/>
						
						<div id="no-options-<?php echo $capsule_id?>">
						<a href="javascript:void(0);" class="addmore" onclick="addPollsOption('<?php echo $capsule_id?>')">Add Option</a>
						<span class="note"><span class="bold">Note :</span> In case you don't add these, there would only be options of YES and NO</span>
						</div>
						
						<div id="question-wrapper-<?php echo $capsule_id?>" style="display:none;">
							options <br />
							<div id="options-<?php echo $capsule_id?>">
								<div>
									<input type="hidden" name="option_id[]" value="0" />
									<input type="hidden" value="Yes" name="option_title[]"/>
								</div>
								<div>
									<input type="hidden" name="option_id[]" value="0" />
									<input type="hidden" value="No" name="option_title[]"/>
								</div>
							</div>							
							<!-- <a href="javascript:void(0);" class="addmore" onclick="addMorePollsOption('<?php // echo $capsule_id?>')">Add more items</a> 	 -->						
						</div>
					
					
					<?php }?>
					
				</div>
				
			</div>
			
		</div>
		
</form>
</div>