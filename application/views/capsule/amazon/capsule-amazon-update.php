<form name="capsuleForm<?php echo $capsule_id; ?>" id="capsuleForm<?php echo $capsule_id; ?>">
<input type="hidden" name="capsule_id" value="<?php echo $capsule_id; ?>" />
<div id="content-add-<?php echo $capsule_id?>" class="showcomment showcomment2">	
    <div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="amazon"></span>Amazon Block<span class="edit"></span></a></div>
    
    <a onclick="saveAmazonContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');" href="javascript:void(0);" class="btnorange">Finish and Add this</a>
   
    <div class="editbox"> 
        <div class="amazon-edit">
        <?php 
			if(!empty($capsule_content)){
				
			// key word serach edit case
				$amazon_search_type = $capsule_content[0]['result_type'];
				if($amazon_search_type=='keyword'){
					$amazon_search_keyword = $capsule_content[0]['title'];
					$amazon_search_description = $capsule_content[0]['description'];
					$amazon_num_of_search_result = $capsule_content[0]['total_result'];
					$triggerfirststep = 1;			
				}else{
					$amazon_search_keyword = '';
					$amazon_search_description = '';
					$amazon_num_of_search_result = 3;	
					$triggerfirststep = 1;
				}
				
			}else{
				// key word serach first time
				$amazon_search_type = 'url';
				$amazon_search_keyword = '';
				$amazon_search_description = '';
				$amazon_num_of_search_result = 3;
				$triggerfirststep = 0;							
			}	
			
		?>
        
        <div id="ctrlbar-<?php echo $capsule_id; ?>">
        	
           <div id="selection-div-<?php echo $capsule_id; ?>" class="step">
                 
                
                <div class="radio" style="margin:5px 0;">
                	<input type="radio"  name="amazon_search_type" id="amazon_search_type_by_url" value="url" <?php echo $amazon_search_type=='url'?'checked="checked"':''?> />
                    <label for="amazon_search_type_by_url">Choose product whose Amazon URL, ASIN or ISBN you know already</label>
                	
                </div>
                <div class="radio" style="margin:5px 0;">
                	<input type="radio"  name="amazon_search_type" id="amazon_search_type_by_keyword" value="keyword" <?php echo $amazon_search_type=='keyword'?'checked="checked"':''?>/>
                    <label for="amazon_search_type_by_keyword">If you don't know about this and wish to search click here</label>
                	
                </div>               
                <a href="javascript:void(0);" class="btnorange" onclick="amazonSecStep('<?php echo $capsule_id; ?>');">Next Step</a>
               
           </div>    
            
           <div id="by-url-<?php echo $capsule_id; ?>" style="display:none;" class="step">
                <div class="fieldbox">
                    <div id="amazon-url-wrapper-<?php echo $capsule_id; ?>">
                        <?php if(!empty($capsule_content)){?>
                        	<?php foreach($capsule_content as $amazon){?>
                            <div class="field-wrapper">
                                <div class="fieldmain">
                                <label class="name">Enter <span class="txtorange">Amazon URL</span> or <span class="txtorange">ASIN</span> or <span class="txtorange">ISBN</span></label>
                                <input type="text" class="inputmain d-req" name="amazon_url[]" value="<?php echo $amazon['title']; ?>" onfocus="$(this).removeClass('error-border');"/><a class="delete" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')"></a><div class="adl"><a class="btnorange" onclick="deleteAmazonUrl(this,'<?php echo $capsule_id; ?>');" rel="0">Yes</a></div>
                                </div>
                                
                            </div>
                            <?php }?> 
                        <?php }?>                  
                    </div>                                     
                </div>
                 <div class="btnbox"> <a href="javascript:void(0);" class="btngrey" onclick="amazonfirstStep('<?php echo $capsule_id; ?>');">Back to Selection</a> <a href="javascript:void(0);" class="btngrey" onclick="amazonShowResult(this,'<?php echo $capsule_id; ?>')">Show Result</a> <a href="javascript:void(0);" class="btngrey" onclick="addMoreAmazonUrl('<?php echo $capsule_id; ?>');">Add More</a>  </div>                
           </div>
           
           <div id="by-keyword-<?php echo $capsule_id; ?>" style="display:none;" class="step">
           		<div class="fieldbox">
                    <div style="dropdown">
                       <label class="name">Select the number of items to display</label>
                       	<select name="amazon_num_of_search_result">
							<?php foreach(range(1,10) as $num){?>
                            	<option value="<?php echo $num; ?>" <?php echo $num==$amazon_num_of_search_result?'selected="selected"':''; ?>><?php echo $num; ?></option>
							<?php }?>
                        </select>
                    </div>
                    <div class="fieldmain">
                        <label class="name">Enter <span class="txtorange">item name to search</span> here</label>
                        <div class="field"><input type="text" class="inputmain" value="<?php echo $amazon_search_keyword ?>" name="search_keyword"/></div>
                    </div>
                    <div class="fieldmain">
                        <label class="name">Enter<span class="txtorange"> General Description</span></label>
                        <textarea cols="" rows="" class="inputmain" name="search_description"><?php echo $amazon_search_description ?></textarea>
                        
                    </div>
                </div>
                <div class="btnbox btnbox3"> <a href="javascript:void(0);" class="btngrey" onclick="amazonfirstStep('<?php echo $capsule_id; ?>');">Back to Selection</a> <a href="javascript:void(0);" class="btngrey" onclick="amazonShowResult(this,'<?php echo $capsule_id; ?>')">Search</a></div>                
           </div>
           </div><!--/controll bar -->
                            
        
        
        <div id="resultbar-<?php echo $capsule_id?>">
        	
        </div> <!--/resultbar bar -->  
        <script type="text/javascript">
		<?php if($triggerfirststep){?>
			amazonSecStep('<?php echo $capsule_id; ?>');
			amazonShowResult($(".test"),'<?php echo $capsule_id; ?>');			
		<?php }?></script>                 
        </div><!--/amazon-edit -->
    </div>
    <a onclick="saveAmazonContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>');" href="javascript:void(0);" class="btnorange">Finish and Add this</a>
</div>
</form>