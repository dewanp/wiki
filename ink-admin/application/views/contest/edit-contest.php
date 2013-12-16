<script type="text/javascript">
$(function(){

	$('input.tag').tagedit({
					autocompleteURL: site_url+'home/tagAutocomplete',
					allowEdit: true,
					allowDelete: false,
					additionalListClass : 'inputmain',
					// return, comma, space, period, semicolon
					breakKeyCodes: [ 13, 44, /* 32,*/ 46, 59 ]
				});
	
	
	var btnUpload=$('#upload');
	var status=$('#status');
	new AjaxUpload(btnUpload, {
		action: 'upload/do_upload',
		name: 'contestImage',
		data: {field_name:'contestImage'},                           	
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
				// extension is not allowed 
				status.text('Only JPG, PNG or GIF files are allowed');
				return false;
			}
			$(".thumbmain").hide();
			status.html('<div class="thumbmain ajax"><div class="user-profile-thmb"><img src="images/loader.gif" alt="Loading.." /></div></div>');
			$("#upload").hide();
		},
		
		onComplete: function(file, response){
			//On completion clear the status
			status.html('');
			var output = $.parseJSON(response);
			if(output.status){
				$("#upload").show();
				$("#file_upload_id").val(output.data.file_upload_id);
				$("#thumb-left").html(showImage(output.data.file_upload_id,'150','150','thumb-left')).show();
			}else{
				$("#thumb-left").html(output.data);
			}				
		}
	});				
				
				
				
});
</script>
<script type="text/javascript">
	/* function for the get editor data and assign in hidden field as value. */
	function getEditorData()
	{
		var editordata =  nicEditors.findEditor('description').getContent();
		$("#editorData").val(editordata);
	}
</script>
<div id="wrapper">
<div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Edit Contest</h1>
            <span class="icons">                
               	<a href="javascript:void(0);" class="save-cont" onclick="getEditorData(); document.getElementById('editcontest').submit();">Save this</a>
                <a href="javascript:void(0);" class="del-cont" id="clear-contest" onclick="clearContest();">Reset Contest</a>
            </span>
        </div>
        <div class="clear"></div>
        <!--ADD CONTEST START-->
        <div class="add-contest">
        <?php $attributes = array('id' => 'editcontest'); ?>
        <?php echo form_open('home/editcontest',$attributes);?>
        	
            
         <!--leftdtls START-->
         <div class="leftdtls">
        
                <div class="thumbmain" id="thumb-left" style="width:150px; height:150px;">
				
				<?php if($contest_detail['contest_image'] == 0 && $this->input->post('file_upload_id') == '' ){?>
                            <img src="images/contest-img.png" alt="" style="margin:20px 0 0 20px;"/>
                	
					<?php }elseif( $this->input->post('file_upload_id') > 0){?>
                    		<script> showImage('<?php echo $this->input->post("file_upload_id"); ?>','150','150','thumb-left');</script>
                    
					<?php }elseif(isset($contest_detail['contest_image']) && $contest_detail['contest_image'] != 0){?> 
                    		<script> showImage('<?php echo $contest_detail['contest_image']; ?>','150','150','thumb-left');</script>
					<?php }?>
                </div>
                
              <input type="hidden" name="file_upload_id" id="file_upload_id" 
              <?php if(isset($contest_detail['contest_image'])){?>  value="<?php echo $contest_detail['contest_image']; ?>" <?php }else{?> value="<?php echo set_value('file_upload_id',$this->input->post("file_upload_id")); ?>" <?php } ?> />
             
               <div class="error_class" id="err_file_upload_id"></div>
                    <div class="btnbox">
                         <input type="button" class="btnorange tbi" value="Change Picture" id="upload" style="margin-left:18px; padding-left:10px;"/>
                    </div>
                    <div id="status" style="display:inline-block;"></div>
          </div>
      	<!--leftdtls END--> 
        
        
             
	    <!--rightdtls START-->
		<div class="rightdtls">
		<div class="clear"></div>
   <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
    <tr>
        <td>Choose a suitable title:</td>
        <td>
            <div class="field">
                    <label for="title" class="infield">Please Enter title</label>
                    <input type="text" id="title" name="title" class="inputmain"  <?php if(isset($contest_detail['title'])) {?> value="<?php echo $contest_detail['title'];?>" <?php }else{?> value="<?php echo set_value('title'); ?>" <?php }?> maxlength="150"/>
                    <span class="error" id="name_msg"> <?php echo form_error('title'); ?> </span>
           </div>
        </td>
    </tr>
    <tr>
        <td>Provide Tags (at least 2)</td>
        <td>
			<?php 
				if(isset($tag_term_id))
				{
					$selectedtag = $tag_term_id;
				}else
				{
					$selectedtag = $this->input->post('tag');
				}				
			  	if(!empty($selectedtag)){
			  		?>
				<?php foreach($selectedtag as $postkey=>$posttag){?>
					<input type="text" name="tag[<?php echo $postkey?>]" value="<?php echo $posttag?>"  class="tag" />
				<?php }?>
		  <?php }?>
        <div class="field">
                <input type="text" name="tag[]" value="" id="tagedit-input" class="tag tbi" />
                <span class="error" id="tag_msg"> <?php echo form_error('tag'); ?></span>
        </div>
        </td>
    </tr>
    <tr>
        <td>Description of the Contest</td>
        <td>
           	<div class="field">
                <textarea  rows="5" id="description" name="description"> <?php if(isset($contest_detail['description'])){ echo $contest_detail['description'];}else{ echo set_value('editorData'); }  ?> </textarea>
                <span class="error" id="user_name_msg"><?php echo form_error('editorData'); ?></span>
            </div>
        </td>
    </tr>
    <tr>
        <td>Contest runs from</td>
        <td>
            <div class="field" style="width:160px;">
            <?php if(isset($contest_detail['runs_from']))
				{
             		$time = date("M d, Y",$contest_detail['runs_from']);
				}else{
					$time = set_value('contest_runs_from');
				}
			?>
               <input type="text" id="contest_runs_from" name="contest_runs_from" class="inputmain inputmain-cal w107" value="<?php echo $time; ?>" readonly="readonly"/><br />
               <span class="error"><?php echo form_error('contest_runs_from'); ?></span>
            </div>  
            <label class="name">To</label>
            <div class="field" style="margin-left: 10px;">
			<?php if(isset($contest_detail['runs_to']))
            {
                $time = date("M d, Y",$contest_detail['runs_to']);
            }else{
                $time = set_value('contest_runs_to');
            }
			?>
              <input type="text" id="contest_runs_to" name="contest_runs_to" class="inputmain inputmain-cal w107" value="<?php echo $time ; ?>" readonly="readonly"/><br />
              <span class="error"  style="margin-left:2px;">  <?php echo form_error('contest_runs_to'); ?></span> 
           </div>   
        </tr>
    <tr>
        <td>Enter Prize Amount</td>
        <td><div class="field">
                <input type="text" id="prize_amount" name="prize_amount" class="inputmain w107 inputmain-cal" <?php if(isset($contest_detail['prize'])){ ?> value="<?php echo $contest_detail['prize']; ?>" <?php }else{?> value="<?php echo set_value('prize_amount'); ?>" <?php }?> /> USD<br />
                <span class="error" id="user_name_msg"><?php echo form_error('prize_amount'); ?></span>
             </div>
        </td>
    </tr>
    <tr>
        <td>Parameters of the contest</td>
        <td>
        	<div class="field">
                <div class="order-this" id="list-capsule">
                	
					<?php if(isset($contest_detail['parameters']))
					{
							$explode_listparameter = $contest_detail['parameters'];
					}else{
							$explode_listparameter = $this->input->post('list_description');
					}
					?>
                    <?php if(!empty($explode_listparameter)){?>
                                <?php foreach($explode_listparameter as $listkey=>$listpara){?>
                                    <div class="bulletbox" style="margin-bottom:10px; width:330px;">
                                        <input type="text" name="list_description[<?php echo $listkey; ?>]" value="<?php echo $listpara; ?>"  class="inputmain d-req etraddmore" />
                                        <a class="delete" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
                                        <div class="adl"><a class="btnorange" onclick="deleteParameter(this,<?php echo $listkey; ?>);">Yes</a></div>
                                    </div>
                                <?php }?>
                    <?php }else{?>
                    <div class="bulletbox">
                        <input type="text" class="inputmain d-req etraddmore" name="list_description[]" />                      
                    </div>
                   <?php }?> 
                </div>
                <div class="button-position">
                    <a class="addmore" href="javascript:void(0);" onclick="addMoreList()">Add more items</a>
                    <span class="error" id="user_name_msg"><?php echo form_error('list_description[]'); ?></span>
               </div> 
          </div>
        </td>
    </tr>
    </table>
     	<input type="hidden" name="edit_contest" id="edit_contest"  value="Edit Contest" />
        <input type="hidden" name="editorData" id="editorData"  value="" />
        <input type="hidden" name="contest_token" id="contest_token" <?php if(isset($contest_detail['unique_contest_token'])){?>  value="<?php echo $contest_detail['unique_contest_token']; ?>" <?php }else{?>
        value="<?php echo set_value('unique_contest_token'); ?>" <?php } ?> />        
        <input type="hidden" name="contest_id" id="contest_id"  <?php if(isset($contest_detail['contest_id'])){?> value="<?php echo $contest_detail['contest_id'];?>" <?php }else{?> value="<?php echo set_value('contest_id',$this->input->post('contest_id'));?>" <?php } ?>/>
    	<?php echo form_close(); ?>
    	</div>
     	<!-- rightdtls END-->
     </div>
    <!--ADD CONTEST END-->
  
   </div>
   <!--Container end-->
    <div class="clear"></div>
</div>

<script>
	$(function(){ 
	
				$('#list-capsule input').live('keyup',function(e) {
					if(e.keyCode == 13) {
						addMoreList();
					}
				});
				
				$("#contest_runs_from").datepicker({dateFormat: 'M dd, yy',changeMonth: true,changeYear: true,selectOtherMonths:true,minDate: 0,yearRange: "0:+10", buttonImageOnly: true, buttonImage:'images/cal-icon.png',showOn: "both"});
				
				$("#contest_runs_to").datepicker({dateFormat: 'M dd, yy',changeMonth: true,changeYear: true,selectOtherMonths:true,minDate: 0,yearRange: "0:+10", buttonImageOnly: true, buttonImage:'images/cal-icon.png',showOn: "both"});
								
			});
				new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','upload'], iconsPath : 'images/nicEditorIcons.gif'}).panelInstance('description');
    </script>