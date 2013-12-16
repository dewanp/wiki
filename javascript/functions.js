	var deleteRow
	var loadingimg = '<div class="loading"><img src="images/ink-loading.gif" alt="" /></div>';
	function prepareConfirmPopup(ths, msg)
	{
		deleteRow = ths;
		$("#confirm-user-message").html(msg);
		var yesButtonObj = $(ths).parent().find(".adl");
		$("#confirm-yes-button").html($(yesButtonObj).html());
		openPopDiv('confirm');
	}
	
	function getInfoAllLinks()
	{
		if($(".left-nav-main a").hasClass('testing'))
		{			
			$(".left-nav-main a.showhidemenu").text("Show All Menu Item");
			$(".left-nav-main a").removeClass('testing');
		}else{
			$(".left-nav-main a.showhidemenu").text("Hide All Menu Item");
			$(".left-nav-main a").addClass('testing');
		}
	}
	
	
	function prepareConfirmPopupCapsule(ths, msg)
	{
		deleteRow = ths;
		$("#confirm-user-message").html(msg);
		var yesButtonObj = $(ths).parent().parent().find(".adl");
		$("#confirm-yes-button").html($(yesButtonObj).html());
		openPopDiv('confirm');
	}
	function saveZipCode()
	{ 
		zip_code = $('#zip_code').val();
		if(zip_code == "")
		{
			$('#zip_error').html('Please enter zip code!');
			return false;
		}
		$.ajax({
			type: "GET",
			url: site_url + "user/saveZipCode/" + zip_code,
			data: "",
			async: false,
			success: function (data){ 
				if(data == 0)
				{
					$('#zip_error').html('Invalid zip code!');
					return false;
				}
				else
				{
					$("#zip-info-box").remove();
					closePopDiv('zip_code_div');
					
				}
			}
		});
	}
	
	
			
	function saveZipCodeAny()
	{ 
		zip_code = $('#zip_code').val();
		if(zip_code == "")
		{
			$('#zip_error').html('Please enter zip code!');
			return false;
		}
		$.ajax({
			type: "GET",
			url: site_url + "user/saveZipCode/" + zip_code,
			data: "",
			async: false,
			success: function (data){ 
				if(data == 0)
				{
					$('#zip_error').html('Invalid zip code!');
					return false;
				}
				else
				{
					$('#enterzipcodeblock').fadeOut();
					$('#addpostblock').fadeIn();
					
				}
			}
		});
	}
	
	

	function deletePost(post_id)
	{
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "post/delete",
			data: "post_id="+post_id,
			success: function (data){
				//window.location.reload();
				return true;
			}
		});
	}
	
	
	/* function for hide post from list
	*  created date :- 2012-12-07
	*/
	function hidePost(tr_id)
	{
		$("#"+tr_id).css("display", "none");
		closePopDiv('confirm');
	}

	
	function postOp(post_id,op)
	{
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "post/postOp",
			data: "post_id="+post_id+"&op="+op,
			success: function (data){
				window.location.reload();
			}
		});
	}



	function onlyShow(divId)
	{
		document.getElementById(divId).style.display="";
	}
	
	
	function onlyHide(divId)
	{
		document.getElementById(divId).style.display="none";
	}

	function cancelTo(page)
	{
		window.location =site_url+page;
	}

	function deleteRecord(table,id,txt,redirect)
	{
		if(confirm("Are you sure you want to delete "+txt+"."))
		{ 
			window.location =site_url+'admin/deleteRecord/'+table+"/"+id+"/"+redirect;
		}
		return false;
	}

	// this function disables when radio is not checked
	function toggleEnableById(chk, enable_id, disable_id)
	{ 
		if(chk.checked)
		{
			document.getElementById(enable_id).disabled = false;
			document.getElementById(disable_id).disabled = true;
			document.getElementById(enable_id).className = "input-shadow";
			if (disable_id == 'company_name')
			{
				document.getElementById(disable_id).className = "";
				document.getElementById(disable_id).style.width = "200px";
			}
		}
	}

	
	
	function editInputs(table, field, input_id, span_id, row_id)
	{ 
		if(row_id === undefined)
		{ row_id = "";
		}
		var val = $("#"+input_id).val();
		var data = 'table='+table+'&'+field+'='+val+'&row_id='+row_id;
	
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "user/editInputs",
			data: data,
			success: function (data){ 
				$("#"+span_id).html(val.replace(/\n/g,'<br />')); //replace is used for nl2br in JS 			
			}
		});
	}

	
	function editRelationshipStatus(dis)
	{ 
		var val = dis.value;
		var data = 'table=user&relationship_status='+val+'&row_id=';
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "user/editInputs",
			data: data,
			success: function (data){
			}
		});
	}

	
	function editInputOnly(table, field, value)
	{ 
		var data = 'table='+table+'&'+field+'='+value;
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "user/editInputs",
			data: data,
			success: function (data){ 
							
			}
		});
	}


	function checkSubCategory(obj)
	{
		var tid = $("#"+obj.id).val();
		
		$.ajax({
			type: "POST",
			url: site_url + "post/subCategory",
			data: 'tid='+tid,
			success: function (data){ ;
				
			}
		});
	}

	
	function addMoreTag()
	{
			var element = "<div><input type=\"text\" name=\"postTag[]\" /> <a href=\"javascript:void(0)\" onClick=\"deleteThisTag(this)\">Delete</a><br /></div>"
			$("#postTagDiv").append(element);			 
	}

	
	function deleteThisTag(ele)
	{
		$(ele).parent().remove();
	}

	function updateSorting(className)
	{
		$( "."+className ).each(function(i){$(this).find("input.order-weight").val(i);});
	}

	
	function ajaxCall(callMethod,mydata,async)
	{
		if(async === undefined)
		{ 
			async = true;
		}
		var $op;
		$.ajax({type: "POST",url: site_url + callMethod,data: mydata,async: async,success: function (out){ $op = out;}});
		return $op;
	}



	function reloadCaptcha()
	{
		$.ajax({
			type: "POST",
			url: site_url + "user/reloadCaptcha",
			success: function (data){ 
				$("#captcha-div").html(data);
			}
		});
	}

	/* Video save script*/
	function saveVideoContent(ths,post_id, capsule_id)
	{
			var allValid = true;
			var firstError = false;
			var firstErrorObj = '';
			$("#capsuleForm"+capsule_id+" .d-req").each(function(){
				if($(this).val()!=''){
				}else{
					if(firstError){
					}else{
						firstErrorObj = $(this);
						firstError = true;
					}
					allValid = false;
					$(this).addClass('error-border');
				}
			});
			
			if(allValid && !$(ths).hasClass('processing')){
				$(ths).addClass('processing');
				$.ajax({
					type: "POST",
					url: site_url + "capsule/saveVideo",
					data: $("#capsuleForm"+capsule_id).serialize(),
					success: function (data){ 
						$(ths).removeClass('processing');
						capsuleContent(post_id, capsule_id, 'edit');
					}
				});	
			}else{				
				return false;
			}
	} //end of saveVideoContent function


	/* video save script*/
	function saveParagraphContent(post_id, capsule_id)
	{
		nicEditors.findEditor('paragraph-'+capsule_id).saveContent();
		$.ajax({
			type: "POST",
			url: site_url + "capsule/saveParagraph",
			data: $("#capsuleForm"+capsule_id).serialize(),
			success: function (data){ 
				capsuleContent(post_id, capsule_id, 'edit');
			}
		});	
	} //end of saveParagraphContent function


	/* view use full function for calling view,edit form for all the capsules */
	function capsuleContent(post_id, capsule_id, content_type)
	{
		$.ajax({
			type: "POST",
			url: site_url + "capsule/capsuleContent",
			data: "post_id="+post_id+"&capsule_id="+capsule_id+"&content_type="+content_type,
			success: function (data){ 
				var capsule_content = $.parseJSON(data);
				$(".capsule-content-"+capsule_id+" .content").html(capsule_content.html);
			}
		});	
	} // end of capsuleContent function

	/* view use full function for calling view,edit form for all the capsules */
	function commentContent(post_id, capsule_id, content_type)
	{
		$.ajax({
			type: "POST",
			url: site_url + "capsule/commentContent",
			data: "post_id="+post_id+"&capsule_id="+capsule_id+"&content_type="+content_type,
			success: function (data){ 
				var comment_content = $.parseJSON(data);
				$(".comment-list-wrapper").html(comment_content.html);
			}
		});	
	} // end of capsuleContent function

	// uploading time delete file function which will delete direct
	function deleteImage(file_upload_id)
	{
			ajaxCall('upload/delete','file_upload_id='+file_upload_id);
			$("#uploaded-img-"+file_upload_id).remove();
			
	} // end of function

	// uploading time delete file function which will delete direct
	function deleteCapsuleImage(post_id, capsule_id, file_upload_id, image_id)
	{
			if(image_id!=0){
				ajaxCall('capsule/deleteCapsuleImage','image_id='+image_id);
			}
			ajaxCall('upload/delete','file_upload_id='+file_upload_id);		
			$("#uploaded-img-"+file_upload_id).remove();
			$("#capsule-wrapper-"+capsule_id+" #total-uploaded").text(parseInt($("#capsule-wrapper-"+capsule_id+" #total-uploaded").text())-1)
			
			if($("#capsule-wrapper-"+capsule_id+" #total-uploaded").text()>=$("#capsule-wrapper-"+capsule_id+" #total-allowed").text()){
				$("#capsule-wrapper-"+capsule_id+" #add-more-img-button").hide();
			}else{
				$("#capsule-wrapper-"+capsule_id+" #add-more-img-button").show();
			}
			
			closePopDiv('confirm');
	} // end of function


	function deleteCapsuleVideo(post_id, capsule_id, file_upload_id, video_id)
	{
			if(video_id!=0){
				ajaxCall('capsule/deleteCapsuleVideo','video_id='+video_id);
			}
			ajaxCall('upload/delete','file_upload_id='+file_upload_id);		
			$("#uploaded-img-"+file_upload_id).remove();
			$("#capsule-wrapper-"+capsule_id+" #total-uploaded").text(parseInt($("#capsule-wrapper-"+capsule_id+" #total-uploaded").text())-1)
			
			if($("#capsule-wrapper-"+capsule_id+" #total-uploaded").text()>=$("#capsule-wrapper-"+capsule_id+" #total-allowed").text()){
				$("#capsule-wrapper-"+capsule_id+" #add-more-video-button").hide();
			}else{
				$("#capsule-wrapper-"+capsule_id+" #add-more-video-button").show();
			}
			
			closePopDiv('confirm');
	}// end of function


	/* paragraph save script*/
	function saveImageContent(ths,post_id, capsule_id)
	{
		
			var allValid = true;
			var firstError = false;
			var firstErrorObj = '';
			$("#capsuleForm"+capsule_id+" .d-req").each(function(){
				if($(this).val()!=''){
				}else{
					if(firstError){
					}else{
						firstErrorObj = $(this);
						firstError = true;
					}
					allValid = false;
					$(this).addClass('error-border');
				}
			});
			
			if(allValid && !$(ths).hasClass('processing')){
				$(ths).addClass('processing');
				$.ajax({
					type: "POST",
					url: site_url + "capsule/saveImage",
					data: $("#capsuleForm"+capsule_id).serialize(),
					success: function (data){ 
						$(ths).removeClass('processing');
						capsuleContent(post_id, capsule_id, 'edit');
					}
				});
			}else{
				firstErrorObj.focus();
				return false;
			}
	}// end of saveParagraphContent function

	/* list save script*/
	function saveListContent(ths,post_id, capsule_id)
	{
		var allValid = true;
		var firstError = false;
		var firstErrorObj = '';
		$("#capsuleForm"+capsule_id+" .d-req").each(function(){
			if($(this).val()!=''){
			}else{
				if(firstError){
				}else{
					firstErrorObj = $(this);
					firstError = true;
				}
				allValid = false;
				$(this).addClass('error-border');
			}
		});
		
		if(allValid && !$(ths).hasClass('processing')){
		$(ths).addClass('processing');
		$.ajax({
			type: "POST",
			url: site_url + "capsule/saveList",
			data: $("#capsuleForm"+capsule_id).serialize(),
			success: function (data){ 
				$(ths).removeClass('processing');
				capsuleContent(post_id, capsule_id, 'edit');
			}
		});	
		}else{
			firstErrorObj.focus();
			return false;
		}
	}// end of saveParagraphContent function

	/* list save script*/
	function saveCommentContent(ths,post_id, capsule_id)
	{
		var commentDescription = $("#capsuleForm"+capsule_id+" #comment_description").val();
		if(commentDescription!='' && !$(ths).hasClass('processing')){
			$(ths).addClass('processing');
			$.ajax({
				type: "POST",
				url: site_url + "capsule/saveComment",
				data: $("#capsuleForm"+capsule_id).serialize(),
				success: function (data){ 
					$(ths).removeClass('processing');
					capsuleContent(post_id, capsule_id, 'view');
				}
			});	
		}else{
			$("#capsuleForm"+capsule_id+" #comment_description").addClass('error-border');
		}
	}// end of saveParagraphContent function



	function showHideComment(ths,capsule_id)
	{
		$.ajax({
				type: "POST",
				url: site_url + "capsule/showHideComment",
				data: "capsule_id="+capsule_id+"&is_comment="+ths.attr('rel'),
				success: function (data){ 
					if(ths.attr('rel')==1){
						ths.text('Hide Comment');
						ths.attr('rel',0);
					}else{
						ths.text('Show Comment');
						ths.attr('rel',1);
					}				
				}
		});
	}



	/* list save script*/
	function savePollsContent(post_id, capsule_id)
	{
		var allValid = true;
		var firstError = false;
		var firstErrorObj = '';
		$("#capsuleForm"+capsule_id+" .d-req").each(function(){
			if($(this).val()!=''){
			}else{
				if(firstError){
				}else{
					firstErrorObj = $(this);
					firstError = true;
				}
				allValid = false;
				$(this).addClass('error-border');
			}
		});
		
		if(allValid){
		$.ajax({
			type: "POST",
			url: site_url + "capsule/savePolls",
			data: $("#capsuleForm"+capsule_id).serialize(),
			success: function (data){ 
				capsuleContent(post_id, capsule_id, 'edit');
			}
		});
		}else{
			firstErrorObj.focus();
			return false;
		}
	}// end of saveParagraphContent function

	/* list save script*/
	function saveOpinionContent(post_id, capsule_id)
	{
		var allValid = true;
		var firstError = false;
		var firstErrorObj = '';
		$("#capsuleForm"+capsule_id+" .d-req").each(function(){
			if($(this).val()!=''){
			}else{
				if(firstError){
				}else{
					firstErrorObj = $(this);
					firstError = true;
				}
				allValid = false;
				$(this).addClass('error-border');
			}
		});
		
		if(allValid){
		$.ajax({
			type: "POST",
			url: site_url + "capsule/saveOpinion",
			data: $("#capsuleForm"+capsule_id).serialize(),
			success: function (data){ 
				capsuleContent(post_id, capsule_id, 'edit');
			}
		});
		}else{
			firstErrorObj.focus();
			return false;
		}
	}// end of saveParagraphContent function



	/* list save script*/
	function saveOpinionContent(post_id, capsule_id)
	{
		var allValid = true;
		var firstError = false;
		var firstErrorObj = '';
		$("#capsuleForm"+capsule_id+" .d-req").each(function(){
			if($(this).val()!=''){
			}else{
				if(firstError){
				}else{
					firstErrorObj = $(this);
					firstError = true;
				}
				allValid = false;
				$(this).addClass('error-border');
			}
		});
		
		if(allValid){
		$.ajax({
			type: "POST",
			url: site_url + "capsule/saveOpinion",
			data: $("#capsuleForm"+capsule_id).serialize(),
			success: function (data){ 
				capsuleContent(post_id, capsule_id, 'edit');
			}
		});
		}else{
			firstErrorObj.focus();
			return false;
		}
	}// end of saveParagraphContent function



	/* paragraph save script*/
	function saveAmazonContent(ths,post_id, capsule_id)
	{
		
		var allValid = true;
		var firstError = false;
		var firstErrorObj = '';
		
		var rt =$('#capsuleForm'+capsule_id+' input:radio[name=amazon_search_type]:checked').val();
		if(rt=='url'){		
			$("#capsuleForm"+capsule_id+" .d-req").each(function(){
				
				if($(this).val()!=''){
				}else{
					if(firstError){
					}else{
						firstErrorObj = $(this);
						firstError = true;
					}
					allValid = false;
					$(this).addClass('error-border');
				}
			});
		}
			
		if(allValid && !$(ths).hasClass('processing')){
			$(ths).addClass('processing');
			$.ajax({
				type: "POST",
				url: site_url + "capsule/saveAmazon",
				data: $("#capsuleForm"+capsule_id).serialize(),
				success: function (data){ 
					$(ths).removeClass('processing');
					capsuleContent(post_id, capsule_id, 'edit');
				}
			});
		}else{
			firstErrorObj.focus();
			return false;
		}
		
	}// end of saveParagraphContent function

	
	function addPollsOption(capsule_id)
	{
		$("#no-options-"+capsule_id).hide();
		addMorePollsOption(capsule_id);
		$("#question-wrapper-"+capsule_id).show();	
		$("#is_options-"+capsule_id).val('1');
	}



	function addOpinionOption(capsule_id,type)
	{
		$("#no-options-"+capsule_id+"-type-"+type).hide();
		addMoreOpinionOption(capsule_id,type);
		$("#question-wrapper-"+capsule_id+"-type-"+type).show();	
	}




	function deletePollsOption(ths,capsule_id)
	{
		var option_id = $(ths).attr('rel');
		if(option_id>0){
			deleteOptionFromDb(option_id);
		}
		$(deleteRow).parent().remove();
		if($("#options-"+capsule_id).children().length==2){
			$("#no-options-"+capsule_id).show();
			$("#question-wrapper-"+capsule_id).hide();	
			$("#is_options-"+capsule_id).val('0');
		}
		closePopDiv('confirm');
	}

	function deleteAmazonUrl(ths,capsule_id)
	{
		$(deleteRow).parent().parent().remove();
		closePopDiv('confirm');
	}

	
	function deleteOpinionOption(ths,capsule_id,type)
	{
		var option_id = $(ths).attr('rel');
		
		if(option_id>0){
			deleteOptionFromDb(option_id);
		}
		$(deleteRow).parent().remove();
		if($("#options-"+capsule_id+"-type-"+type).children().length==0){
			$("#no-options-"+capsule_id+"-type-"+type).show();
			$("#question-wrapper-"+capsule_id+"-type-"+type).hide();			
		}
		closePopDiv('confirm');
	}




	function deleteListItem(ths,capsule_id)
	{
		var list_id = $(ths).attr('rel');	
		if(list_id>0){
			deleteListItemFromDb(list_id);
		}
		$(deleteRow).parent().remove();
		closePopDiv('confirm');
	}


	function deleteOptionFromDb(option_id)
	{
		$.ajax({
			type: "POST",
			url: site_url + "capsule/deleteOption",
			data: "option_id="+option_id,
			success: function (data){ 
			}
		});
	}
	
	
	
	function deleteListItemFromDb(list_id)
	{
		$.ajax({
			type: "POST",
			url: site_url + "capsule/deleteListItem",
			data: "list_id="+list_id,
			success: function (data){ 
			}
		});
	}

	function animateResults(data)
	{
		$(data).find('.progress').hide().fadeIn('slow', function(){
			var bar_width=$(this).css('width');
			$(this).css('width', '0').animate({ width: bar_width }, 1000);
		});	
	}




	function pollsContent(capsule_id,polls_id)
	{
		var pollcontainer=$('#polls-container-'+capsule_id);
		//Load the poll form	
		$.ajax({
			type: "POST",
			url: site_url + "capsule/pollsContent",
			data: "capsule_id="+capsule_id+"&polls_id="+polls_id,
			success: function (data){ 
				pollcontainer.html(data);
				animateResults(pollcontainer);
			}
		});
	}




	function submitPolls(ths,capsule_id,polls_id)
	{
		var loader=$('#loader'+capsule_id);
		var pollcontainer=$('#polls-container-'+capsule_id);
		var selected_val=pollcontainer.find('input:checked').val();
		
		if(selected_val!='' && !$(ths).hasClass('processing')){
			$(ths).addClass('processing');
			//post data only if a value is selected
			loader.fadeIn();
			
			$.ajax({
			type: "POST",
			url: site_url + "capsule/pollsSave",
			data: "capsule_id="+capsule_id+"&polls_id="+polls_id+"&option_id="+selected_val,
			success: function (data){ 
				$(ths).removeClass('processing');
				pollsContent(capsule_id,polls_id);
			}
			});
		}
		//prevent form default behavior
		return false;
	}




	function addMorePollsOption(capsule_id)
	{
		var newlistelement = "<div class=\"bulletbox\"><span class=\"bullets\"></span><input type=hidden name=\"option_id[]\" value=\"0\" /><input type=\"text\" value=\"\" class=\"inputmain d-req\" name=\"option_title[]\" onfocus=\"$(this).removeClass('error-border');\"><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deletePollsOption(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div>";	
		$("#options-"+capsule_id).append(newlistelement);
	}

	
	
	function addMoreOpinionOption(capsule_id,type)
	{
		var newlistelement = "<div class=\"bulletbox\"><span class=\"bullets\"></span><input type=hidden name=\"option_id[]\" value=\"0\" /><input type=hidden name=\"option_type[]\" value=\""+type+"\" /><input type=\"text\" value=\"\" class=\"inputmain d-req\" name=\"option_title[]\" onfocus=\"$(this).removeClass('error-border');\"><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteOpinionOption(this,"+capsule_id+","+type+");\" rel=\"0\">Yes</a></div></div>";	
		$("#options-"+capsule_id+'-type-'+type).append(newlistelement);
	}




	function addMoreList(capsule_id)
	{
		var newlistelement = "<div class=\"bulletbox\"><span class=\"bullets\">List Item</span><input type=hidden name=\"list_id[]\" value=\"0\" /><input type=\"text\" value=\"\" class=\"inputmain d-req etraddmore\" name=\"list_description[]\" onfocus=\"$(this).removeClass('error-border');\"><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteListItem(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div>";
		
		$("#list-capsule-"+capsule_id).append(newlistelement);
		$("#list-capsule-"+capsule_id+" div.bulletbox:last-child").find("input[type=text]").focus();
	}





	function showImage(img_id, width, height, target)
	{
		$.ajax({type: "POST",url: site_url + 'upload/showImage',data: 'file_upload_id='+img_id+'&t_width='+width+'&t_height='+height,
			success: function (data){ 
				$("#"+target).html(data);
			}
		});
	}




	function showImagePath(img_id, width, height, target)
	{
		$.ajax({type: "POST",url: site_url + 'upload/showImagePath',data: 'file_upload_id='+img_id+'&t_width='+width+'&t_height='+height,
			success: function (data){ 
				$("#"+target).attr('src',data);
			}
		});
	}
	
	
		
	function val_post_add_step_1()
	{
		setTimeout(" $('#postAdd').submit();", 50);
		var category 	 = $("#togleDivValue").val();
		$('#postAdd').ajaxForm({
			data: {category:category},
			success: showTaskResponse,
			dataType: 'json',
			complete: function(xhr) {					
				var outputJson = $.parseJSON(xhr.responseText);
				if (outputJson.success == "success") {
					url = site_url +'post/edit/'+outputJson.new_post_id;
					window.location = url;
				}		
			}
		}); 
	}
	
	
	
	// post-submit callback 
	function showTaskResponse(responseText, statusText, xhr, $form)
	{	
			if (responseText.sub_category != "") {
				$("#err_postType").css('visibility','visible');
				$("#err_postType").html(responseText.sub_category);
			} else{
				$("#err_postType").css('visibility','hidden');
				$("#err_postType").html("");
			}
			if (responseText.category != "") {
				$("#err_category").css('visibility','visible');
				$("#err_category").html(responseText.category);
			} else{
				$("#err_category").css('visibility','hidden');
				$("#err_category").html("");
			}
			
			if (responseText.title != "") {
				$("#err_title").css('visibility','visible');
				$("#err_title").html(responseText.title);
			} else{
				$("#err_title").css('visibility','hidden');
				$("#err_title").html("");
			}
			if (responseText.file_upload_id != "") {
				$("#err_file_upload_id").css('visibility','visible');
				$("#err_file_upload_id").html(responseText.file_upload_id);
			} else{
				$("#err_file_upload_id").css('visibility','hidden');
				$("#err_file_upload_id").html("");
			}
			if (responseText.description != "") {
				$("#err_description").css('visibility','visible');
				$("#err_description").html(responseText.description);
			} else{
				$("#err_description").css('visibility','hidden');
				$("#err_description").html("");
			}
			if (responseText.tag != "") {
				$("#err_tag").css('visibility','visible');
				$("#err_tag").html(responseText.tag);
			} else{
				$("#err_tag").css('visibility','hidden');
				$("#err_tag").html("");
			}
			if (responseText.general_post != "") {
				$("#err_general_post").css('visibility','visible');
				$("#err_general_post").html(responseText.general_post);
			} else{
				$("#err_general_post").css('visibility','hidden');
				$("#err_general_post").html("");
			}
			if (responseText.local_post != "") {
				$("#err_local_post").css('visibility','visible');
				$("#err_local_post").html(responseText.local_post);
			} else{
				$("#err_local_post").css('visibility','hidden');
				$("#err_local_post").html("");
			}
			if (responseText.post_zip_code != "") {
				$("#err_post_zip_code").css('visibility','visible');
				$("#err_post_zip_code").html(responseText.post_zip_code);
			} else{
				$("#err_post_zip_code").css('visibility','hidden');
				$("#err_post_zip_code").html("");
			}
	}

	
	function confirmPopup(msg,obj)
	{
		var msg = '<div class="note"><h5>'+msg+'</h5></div>';
		var yesHtml = '<a href="javascript:void(0);" class="btnorange" onclick="$('+obj+').trigger(\"click\")">Yes</a>';
		var noHtml = '<a href="javascript:void(0);" class="cancel" onclick="closePopDiv(\'confirm\');">No</a>';
		var confirmBoxContent = msg+'<div class="btnbox">'+yesHtml+noHtml+'</div>';
		$("#confirm-message-wrapper").html(confirmBoxContent);
		openPopDiv('confirm');
	}




	function deletePostImage(file_upload_id)
	{
			ajaxCall('upload/delete','file_upload_id='+file_upload_id)
			$("#file_upload_id").val('0');
			$("#files").html('');
			$("#upload").show();
			closePopDiv('confirm');
	}

	
	function capsuleDelete(capsule_type,capsule_id,post_id)
	{
		$.ajax({type: "POST",url: site_url + 'capsule/delete',data: 'capsule_type='+capsule_type+'&capsule_id='+capsule_id,
			success: function (data){ 
				closePopDiv('confirm');
				updatePostCapsuleList(post_id);
				updatePostCapsuleWrapper(post_id,'edit');			
			}
		});
	}

	
	function updatePostCapsuleWrapper(post_id,view_type, capsule_type)
	{
		
		if(capsule_type === undefined){
			capsule_type = '';
		}
		$.ajax({type: "POST",url: site_url + 'post/updateCapsuleWrapper',data: 'post_id='+post_id+'&view_type='+view_type+'&capsule_type='+capsule_type,
			success: function (data){ 
				$("#capsule-wrapper").html(data);	
			}
		});
	}
	
	/* Function for commet wrapper */
	function updatePostCapsuleCommentWrapper(post_id,view_type, capsule_type)
	{
		
		if(capsule_type === undefined){
			capsule_type = '';
		}
		$.ajax({type: "POST",url: site_url + 'post/updateCapsuleCommentWrapper',data: 'post_id='+post_id+'&view_type='+view_type+'&capsule_type='+capsule_type,
			success: function (data){ 
				$("#capsule-comment-wrapper").html(data);	
			}
		});
	}
	
	
	
	function updatePostCapsuleList(post_id)
	{
		$.ajax({type: "POST",url: site_url + 'post/updateCapsuleList',data: 'post_id='+post_id,
			success: function (data){ 
				$("#sidebar-capsule-container").html(data);	
			}
		});
	}
	
	
	
	
	function postBasicInfo(post_id,view_type)
	{
		$.ajax({type: "POST",url: site_url + 'post/postBasicInfo',data: 'post_id='+post_id+'&view_type='+view_type,
			success: function (data){ 
				$("#post-basic-info").html(data);	
			}
		});
	}




	function savePostBasicInfo(post_id)
	{
		err = 0;
		$('#title_error').html('');
		$('#description_error').html('');
	
		title = $("#title").val();
		if(title == "")
		{
			$('#title_error').html('The Title field is required.');
			err = 1;
		}
	
		description = $("#description").val();
		if(description == "")
		{
			$('#description_error').html('The Description field is required.');
			err = 1;
		}
		
		tags = $(".tagedit-listelement-old").length;
		if(tags < 2)
		{
			$('#tag_error').html('Please add At least Two tags.');
			err = 1;
		}
	
		local_post = $('#local-post-checkbox').attr('class');
		post_zip_code = $("#post_zip_code").val();
		if(local_post == "cbox-selected")
		{
			if(post_zip_code == "")
			{
				$('#post_zip_code_error').html('The Zip Code field is required.');
				err = 1;
			}
		}
		if(err == 1)
			return false;
		
		$.ajax({type: "POST",url: site_url + 'post/savePostBasicInfo',data: $("#postEditBasicInfo").serialize(),
			success: function (data){ 
				//alert(data);
				postBasicInfo(post_id,'edit');
			}
		});
	}

	
	
	function loadMoreReadingPosts(view)
	{ 
		$("#"+view+"-loading").show();
		offset = $("#"+view).children().size();
		data = 'offset='+offset+'&view='+view;
		posts = ajaxCall('reading/loadMoreReadingPosts',data,false);
		cnt = posts.split('searchdtl').length - 1;
		if($.trim(posts)=="" || cnt < 8) $("#"+view+"-showmore").hide();
		$("#"+view).append(posts);
		$("#"+view+"-loading").hide();
	}




	function loadMoreShowPosts(type)
	{  
		$("#show-post-loading").show();
		offset = $("#show-post").children(".searchdtl").size();
		data = 'offset='+offset+'&type='+type;
		posts = ajaxCall('post/loadMoreShowPosts',data,false);
		cnt = posts.split('searchdtl').length - 1;
		if($.trim(posts)=="" || cnt < 8 ) $("#show-post-more").hide();
		$("#show-post").append(posts);
		$("#show-post-loading").hide();
	}




	function loadMoreShowImagePosts()
	{  
		$("#show-image-loading").show();
		offset = $("#show-images").children().size();
		data = 'offset='+(offset*4);
		image = ajaxCall('post/loadMoreShowImagePosts',data,false);
		cnt = image.split('searchdtl').length - 1;
		if($.trim(image)=="" || cnt < 12 ) $("#show-image-more").hide();
		$("#show-images").append(image);
		$("#show-image-loading").hide();
	}




	function loadMoreShowQnaPosts()
	{
		$("#show-qna-loading").show();
		offset = $("#showQna").children().size();		
		data = 'offset='+offset/2;
		posts = ajaxCall('post/loadMoreShowQnaPosts',data,false);
		cnt = posts.split('searchdtl').length - 1;
		if($.trim(posts)=="" || cnt < 8 ) $("#show-qna-more").hide();
		$("#showQna").append(posts);
		$("#show-qna-loading").hide();
	}




	function loadMoreShowPollsPost()
	{
		$("#show-image-loading").show();
		offset = $("#show-images").children().size();
		data = 'offset='+(offset*4);
		image = ajaxCall('post/loadMoreShowPollsPost',data,false);
		cnt = image.split('searchdtl').length - 1;
		if($.trim(image)=="" || cnt < 12 ) $("#show-image-more").hide();
		$("#show-images").append(image);
		$("#show-image-loading").hide();
	}


	
	function loadMoreShowVideoPosts()
	{  
		$("#show-video-loading").show();
		offset = $("#show-videos").children().size();
		data = 'offset='+(offset*4);
		video = ajaxCall('post/loadMoreShowVideoPosts',data,false);
		cnt = video.split('searchdtl').length - 1;
		if($.trim(video)=="" || cnt < 12 ) $("#show-video-more").hide();
		$("#show-videos").append(video);
		$("#show-video-loading").hide();
	}


	function getMostPostedUsers(type)
	{ 
		offset = $("#most-posted-users").children().size();
		data = 'offset='+offset+'&type='+type; 
		posts = ajaxCall('post/getMostPostedUsers',data,false); 
		cnt = posts.split('thumbmain').length - 1; 
		if($.trim(posts)=="" || cnt < 9 ) $("#view-more-posted-users").hide();
		$("#most-posted-users").append(posts);
	}
	
	
	

	function loadMoreLocalPosts(zip_code)
	{  
		$("#show-post-loading").show();
		offset = $("#show-post").children(".searchdtl").size();
		data = 'offset='+offset+'&zip_code='+zip_code;
		posts = ajaxCall('post/loadMoreLocalPosts',data,false);
		cnt = posts.split('searchdtl').length - 1;
		if($.trim(posts)=="" || cnt < 8 ) $("#show-post-more").hide();
		$("#show-post").append(posts);
		$("#show-post-loading").hide();
	}

	/* Function for get more tag related posts 28-11-2012 */
	function loadMoreTagPosts(tag_name)
	{  
		$("#show-post-loading").show();
		offset = $("#show-post").children(".searchdtl").size();
		data = 'offset='+offset+'&tag_name='+tag_name;
		posts = ajaxCall('post/loadMoreTagPosts',data,false);
		cnt = posts.split('searchdtl').length - 1;
		if($.trim(posts)=="" || cnt < 8 ) $("#show-post-more").hide();
		$("#show-post").append(posts);
		$("#show-post-loading").hide();
	}


	function showLocalPosts()
	{
		city = $("#tags").val();
		var zip_code = city.split("-");
		if (city == "")
		{
			return false;
		}
		window.location = site_url+'post/showLocalPosts/'+zip_code[0];
	}

	function redirectMap(dis)
	{
		alert('"'+dis.id+'"');
	}

	function loadRating(capsule_id, edit)
	{ 
		if(edit === undefined)
		{ 
			edit = 0;
		} 
		
		data = 'capsule_id='+capsule_id+'&edit='+edit;
		rating = ajaxCall('post/loadRating', data, false);
		$("#rating"+capsule_id).html(rating);	
	}




	function loadRatingPost(post_id, edit,ip_address)
	{ 
		if(edit === undefined)
		{ 
			edit = 0;
		} 
		
		data = 'post_id='+post_id+'&edit='+edit+'&ip_address='+ip_address;
		rating = ajaxCall('post/loadRatingPost', data, false);
		$("#ratingPost"+post_id).html(rating);
	}
	
	


	function loadMoreCategoryPosts(category_id)
	{  
		$("#show-post-loading").show();
		offset = $("#show-post").children().size();
		data = 'offset='+offset+'&category_id='+category_id;
		posts = ajaxCall('post/loadMoreCategoryPosts',data,false);
		cnt = posts.split('searchdtl').length - 1;
		if($.trim(posts)=="" || cnt < 8 ) $("#show-post-more").hide();
		$("#show-post").append(posts);
		$("#show-post-loading").hide();
	}



	function searchCategoryPosts()
	{
		cat = $("#auotcomp").val();
		if(cat == '')
		{
			window.location = site_url+'post/showposts/all';
			return false;
		}
		cat = encodeURIComponent(cat);
		window.location = site_url+'post/searchcategoryposts/'+cat;
	}



	function userPage(page_id)
	{
		$.ajax({type: "POST",url: site_url + 'user/userPage',data: "page_id="+page_id,
			success: function (data){
				$("#user-dashboard").html(data);
			}
		});
		if(page_id == 'networkfeeds'){
			$(".breadcrumb li#feedText a").text('Network Feeds');
		}else{
			$(".breadcrumb li#feedText a").text('Local Feeds');
		}
	}
	
	/* 
		Function for show contest page for running and over contest 
		Created by : Ashvin soni- 05-02-2013
	*/
	function contestPage(page_id)
	{		
		$.ajax({type: "POST",url: site_url + 'contest/contestPage',data: "page_id="+page_id,
			success: function (data){
				$("#user-dashboard").html(data);
			}
		});
		if(page_id == 'runningcontest'){
			$(".breadcrumb li#feedTextContest a").text('Running Contests');
			$(".account-info-tab #runningactive").addClass('active');
			$(".account-info-tab #overactive").removeClass('active');
		}else{
			$(".breadcrumb li#feedTextContest a").text('Over Contests');
			$(".account-info-tab #runningactive").removeClass('active');
			$(".account-info-tab #overactive").addClass('active');			
		}
	}
	
	
	function userPosts(page_id, username, user_id)
	{
		
		if(page_id == 'allPosts'){
			$(".breadcrumb li#feedText a").text('All Posts');
		}else if(page_id == 'myFavorites'){
			$(".breadcrumb li#feedText a").text('My Favorites');
		}
		$.ajax({type: "POST",url: site_url + 'user/userPosts',data: "page_id="+page_id+"&username="+username+"&user_id="+user_id,
			success: function (data){
				$(".usder-dashboard").html(data);
				$("#user_profile").hide();
				$(".user_profile_class").hide();
			}
		});
		
	}
	
	
	function followUser(following,follower)
	{
		$.ajax({type: "POST",url: site_url + 'user/followuser',data: "following="+following+"&follower="+follower,
			success: function (data){ 
				userPage('search');
			}
		});
	}
	
	
	function unfollowUser(user_follow_id)
	{
		$.ajax({type: "POST",url: site_url + 'user/unfollowUser',data: "user_follow_id="+user_follow_id,
			success: function (data){ 
				userPage('peopleyoufollow');
			}
		});
	}
	
	
	function followUserbyAnyLocation(ths,following,follower,place)
	{
		$.ajax({type: "POST",url: site_url + 'user/followUser',data: "following="+following+"&follower="+follower+"&place="+place,
			success: function (data){ 
				$(ths).parent().parent().html(data);
				userNotification("You are following this user successfully now.");
			}
		});
	}

	function unFollowUserbyAnyLocation(ths,user_follow_id,place)
	{
		$.ajax({type: "POST",url: site_url + 'user/unfollowUser',data: "user_follow_id="+user_follow_id+"&place="+place,
			success: function (data){ 
				$(ths).parent().parent().html(data);
				userNotification("You are unfollowing this user successfully now.");
			}
		});
	}
	

	function loadMoreSearch(dis)
	{ 
		
		if(dis === undefined)
		{ 
			keyword = $("#header-keyword").val();
			keyword = 'keyword='+keyword;
			type='all';
		}else if (dis == 'more')
		{
		}else{
			keyword = $(dis).serialize();		
			type='all';
			$("#show-post").html('');
			$("#show-post-more").show();
		}
	
		keyword = keyword.replace(/\'/g,"");
		offset = $("#show-post").children().size()/2;
		
		$("#show-post-loading").show();
		
		data = 'offset='+offset+'&type='+type+'&'+keyword; 
		posts = ajaxCall('search/loadMoreSearch',data,false); 
		if (posts == 0)
		{
			//posts = offset ? "" : "No post found.";
			posts = offset ? "" : '<div class="searchdtl">There are no more Posts to show for this. Create another one for this <a href="post/add" class="btnorange" style="float:none;">Add Post</a></div>';
			$("#show-post-more").hide();
		}
		else
		{ 
			cnt = posts.split('searchdtl').length - 1;
			if($.trim(posts)=="" || cnt < 8 ) $("#show-post-more").hide();
		}
		$("#show-post").append(posts);
		$("#show-post-loading").hide();
	}


	// function for subscription email address
	function subscribe(emailid)
	{
		$('#error_msg').html('');
		if(emailid =="" || emailid == null)
		{
			$('#error_msg').css('color','red');
			$('#error_msg').html ('Email field  cannot be empty');
			return false;
		}
		if(!isValidEmailAddress(emailid))
		{
			$('#error_msg').css('color','red');
			$('#error_msg').html('Email-id is not valid ');
			return false;
		}
		else
		{
			$.ajax
			({
				type : 'POST',
				url : site_url +'page/subscribeemail',
				data : "emailid=" +emailid,
				success: function(data){
							var out = data.split("###");
							if(out[1]=='success'){
								$('#error_msg').css('color','green');
								userNotification("Subscription has been sent successfully.");
								$('#error_msg').hide();
								$('#emailid').val("");
							}else{
								$('#error_msg').show();
								$('#error_msg').css('color','red');
							}
							$('#error_msg').html(out[0]);
				}
			
			});
	   return false ;
		}
	}
	
	
	
	
	function isValidEmailAddress(emailAddress) 
	{
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
	
	

	function saveDraft(id)
	{	
		var nosave = false;
		$("#"+id).find(".savecaps").each(function(){
			$(this).trigger('click');
			nosave=true;
		});
		if(nosave){
			userNotification("Draft of your post saved successfully.");
		}else{
			window.location =site_url+'post/mypost';
		}	
	}



	
	function saveDraftAddBlock(id)
	{	
		$("#"+id).find(".savecaps").each(function(){
			$(this).trigger('click');											  
		});
	}
	
	
	
		
	function saveEarningContent()
	{
		var amazon_ad = document.getElementById('user_code').value;
		if(amazon_ad =="" || amazon_ad == null)
		{
			return false;
		}
	
		if($('#amazon-ac').hasClass('processing') == true)
				return false;
		$('#amazon-ac').addClass('processing');
		$.ajax({
				type:'post',
				data: $("#amazon-content-form").serialize(),
				url : site_url +"user/saveEarningContent",
				success : function(data)
				{  
					$('#amazon-ac').removeClass('processing');
					closePopDiv('amazon-ac');
					$("#amazon_detail").html('');
					$("#amazon_detail").append(data);
					
				}		
			});
		}
		
		
			
		
	function deleteEarningContent(user_earnings_account_id)
	{
			$.ajax({
				type:'post',
				data: 'user_earnings_account_id='+user_earnings_account_id,
				url : site_url +"user/deleteEarningContent",
				success : function(data)
				{
					closePopDiv('amazon-ac');
				}		
			});
		}
		
	


	function addMoreAmazonUrl(capsule_id)
	{
		var newlistelement = "<div class=\"field-wrapper\"><div class=\"fieldmain\"><label class=\"name\">Enter <span class=\"txtorange\">Amazon URL</span> or <span class=\"txtorange\">ASIN</span> or <span class=\"txtorange\">ISBN</span></label><input type=\"text\" class=\"inputmain d-req\" name=\"amazon_url[]\" onfocus=\"$(this).removeClass('error-border');\"/><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteAmazonUrl(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div></div>";	
		$("#amazon-url-wrapper-"+capsule_id).append(newlistelement);
	}




	function amazonSecStep(capsule_id)
	{
		var rt =$('#capsuleForm'+capsule_id+' input:radio[name=amazon_search_type]:checked').val();
		if(rt){
			$('#ctrlbar-'+capsule_id).find(".step").hide();
			$('#ctrlbar-'+capsule_id).find("#by-"+rt+"-"+capsule_id).show();
		}	
	}



	function amazonfirstStep(capsule_id)
	{
		$('#resultbar-'+capsule_id).html('');
		$('#ctrlbar-'+capsule_id).find(".step").hide();
		$('#ctrlbar-'+capsule_id).find("#selection-div-"+capsule_id).show();
	}




	function amazonShowResult(ths,capsule_id)
	{
		$('#resultbar-'+capsule_id).html(loadingimg);
		if(!$(ths).hasClass('processing')){
			$(ths).addClass('processing');
			$.ajax({
					type:'post',
					data: $('#capsuleForm'+capsule_id).serialize(),
					url : site_url +"capsule/amazonShowResult",
					success : function(data){
						$('#resultbar-'+capsule_id).html(data);
						$(ths).removeClass('processing')
					}		
				});
		}
	}




	function userNotification(msg)
	{
		$("#fade").show();
		$("#site-message").html(msg);
		$('body,html').animate({
			scrollTop: 0
		}, 300);
		$("#zipcode-main-block").slideDown();
		$("#fade, #close-alert").bind("click", function() {
				$("#zipcode-main-block").slideUp();
				$("#fade").hide();
		});
		var userNotification = setTimeout(function(){
			$("#zipcode-main-block").slideUp();
			$("#fade").hide();							  
		},7000);
	}


 

	function suggestCategory()
	{		
		var main_cat = $('#main-cat').val();
		var category_id = $('#category_id').val();
		var sub_cat_name = $('#suggest_category_description').val();
		var admin = $('#admin').val();
		var read_write = $('#read_write').val();
		var read = $('#read').val();
		var user_id = $('#user_id').val();
		
		/*if(main_cat == 0)
		{
			$('#suggest_category_name_msg').html("Please select parent category");
			return false;
		}*/
		/*if(sub_cat_name.length < 1 )
		{
			$('#suggest_category_description_msg').html("Sub-category name should not be blank");
			return false;
		}
		if(sub_cat_name.length >1000)
		{
			$('#suggest_category_description_msg').html("Sub-category name should not be exceed by 1000 character");
			return false ;
		}*/
		
		$.ajax({
				type : 'post',
				//url : site_url + "post/suggestCategory",
				url : admin_site_url + "home/addCategory",
				data: "main_category="+main_cat+"&sub_cat_name="+sub_cat_name+"&admin="+admin+"&read_write="+read_write+"&read="+read+"&user_id="+user_id+"&category_id="+category_id,
				success : function(data){
							$('#suggest_category_description_msg').html("");
							$('#suggest_category_name_msg').html("");
							$('#main-cat option:first-child').attr("selected", "selected");
							$('#suggest_category_description').val("");
							//window.location.reload();
				}
			});
		return false;
	}
	
	function edit_category(category_id)
	{
		$('#sub_category_id').val(category_id);
		
		$.ajax({
				type : 'post',
				url : site_url + "post/editCategory",
				data: "category_id="+category_id,
				success : function(data){							
							var response = $.parseJSON(data);							
							
							$('#category_id').val(response.category_id);
							$('#suggest_category_description').val(response.name);
							$('#main-cat option').each(function(){
								if($(this).attr('value') == response.parent)
								{
									$(this).attr('selected',true);
								}
							});
							
							$('#admin_names').removeClass('hide');
							$('#admin_names').html(response.admin_names);
							
							$('#admin_ids').val(response.admin_ids);
							
							$('#admin option').remove();
							$('#admin').html(response.admin).trigger("chosen:updated");
							
							$('#read_write option').remove();
							$('#read_write').html(response.rw).trigger("chosen:updated");
							
							$('#read option').remove();
							$('#read').html(response.r).trigger("chosen:updated");
							
							$('#category_form').removeAttr('onsubmit');
							$('#category_form').attr('onsubmit','return ajaxedit_category()');
				}
			});
		return false;
	}
	
	
	function ajaxedit_category()
	{
		var main_cat = $('#main-cat').val();
		var sub_category_id = $('#sub_category_id').val();
		var sub_cat_name = $('#suggest_category_description').val();
		var admin = $('#admin').val();
		var read_write = $('#read_write').val();
		var read = $('#read').val();
		var user_id = $('#user_id').val();
		var prev_ids = $('#admin_ids').val();
		
		/*if(main_cat == 0)
		{
			$('#suggest_category_name_msg').html("Please select parent category");
			return false;
		}*/
		if(sub_cat_name.length < 1 )
		{
			$('#suggest_category_description_msg').html("Sub-category name should not be blank");
			return false;
		}
		if(sub_cat_name.length >1000)
		{
			$('#suggest_category_description_msg').html("Sub-category name should not be exceed by 1000 character");
			return false ;
		}
		
		$.ajax({
				type : 'post',
				url : site_url + "post/ajaxedit_category",
				data: "main_category="+main_cat+"&sub_cat_name="+sub_cat_name+"&admin="+admin+"&read_write="+read_write+"&read="+read+"&user_id="+user_id+"&sub_category_id="+sub_category_id+"&prev_ids="+prev_ids,
				success : function(data){
							$('#suggest_category_description_msg').html("");
							//$('#suggest_category_name_msg').html("");
							
							$('#main-cat option').each(function (){
								if( $(this).val == main_cat){
									$(this).attr('selected','selected');
								}
								
							})
							//$('#main-cat option:first-child').attr("selected", "selected");
							//$('#suggest_category_description').val("");
							//window.location.reload();
				}
			});
		return false;
	}
	
	
	
	function googleAd(id,google_ad_client)
	{
		$.ajax({
			type : 'post',
			async: false,
			url : site_url + "post/googleAd",
			data : 'google_ad_client='+google_ad_client,
			success : function(data){ alert(data);
					$('#'+id).html(data);			
			}
		});
	}
	
	
		
	
	function myFavorites(user_id, post_id)
	{
		if($('#my_favorites').hasClass('favorites') == true)
				return false;
		$('#my_favorites').addClass('favorites');
			$.ajax({
				type : 'post',
				url : site_url + "post/myFavorites",
				data : 'user_id='+user_id+'&post_id='+post_id,
				success : function(data){ 
					fav = '<div class="removefavorites"><a href="javascript:void(0);" onclick ="removeFavorites(\''+user_id+'\',\''+post_id+'\')" title="Remove from My Favorite"></a></div>';
					$('#my_favorites').html(fav);
					userNotification("You successfully added this post in My Favorites.");
					 $('#my_favorites').removeClass('favorites');	
				}
			});
	}

	
	
	function removeFavorites(user_id,post_id)
	{
		if($('#my_favorites').hasClass('favorites') == true)
				return false;
		$('#my_favorites').addClass('favorites');
			$.ajax({
				type : 'post',
				url : site_url + "post/removeFavorites",
				data : 'user_id='+user_id+'&post_id='+post_id,
				success : function(data){ 
					fav = '<div class="addfavorite"><a href="javascript:void(0);" onclick ="myFavorites(\''+user_id+'\',\''+post_id+'\')" title="Add to My Favorite"></a></div>';
					$('#my_favorites').html(fav);
					userNotification("You successfully remove this post from My Favorites.");
					 $('#my_favorites').removeClass('favorites');	
				}
			});
	}




	/* Function for unsubscribe post for particular user*/
	function unsubscribePost(user_id,post_id)
	{
		$.ajax({
			type : 'post',
			url : site_url + "post/unsubscribePost",
			data : 'user_id='+user_id+'&post_id='+post_id,
			success : function(data){ 
				fav = '<div class="unSubPost"><a href="javascript:void(0);" onclick ="subscribePost(\''+user_id+'\',\''+post_id+'\')" title="Subscribe Post"></a></div>';
				$('#subscribe_unsubscribe').html(fav);
				userNotification("You successfully unsubscribe this post.");
				 $('#subscribe_unsubscribe').removeClass('favorites');	
			}
		});
	}

	
	/* Function for subscribe post for particular user*/
	function subscribePost(user_id,post_id)
	{
		$('#subscribe_unsubscribe').addClass('favorites');
		$.ajax({
			type : 'post',
			url : site_url + "post/subscribePost",
			data : 'user_id='+user_id+'&post_id='+post_id,
			success : function(data){ 
				fav = '<div class="subPost"><a href="javascript:void(0);" onclick ="unsubscribePost(\''+user_id+'\',\''+post_id+'\')" title="Unsubscribe Post"></a></div>';
				$('#subscribe_unsubscribe').html(fav);
				userNotification("You successfully subscribe this post.");
				 $('#subscribe_unsubscribe').removeClass('favorites');	
			}
		});
	}


	function updateGoogleAdAccount()
	{
		var google_ad = document.getElementById('google_ad_client').value;
		if(google_ad == "" || google_ad == null)
		{
			return false;
		}
		if($('#google-ad-ac').hasClass('processing') == true)
				return false;
		$('#google-ad-ac').addClass('processing');
		$.ajax({
				type : 'post',
				url : site_url + "user/updateGoogleAdAccount",
				data : $("#google_ad_acc_form").serialize(),
				success : function(data){
					$('#google-ad-ac').removeClass('processing');
							closePopDiv('google-ad-ac');
							$("#affiliate_detail").html('');
							$("#affiliate_detail").append(data);
					}
				});
	}



	
	function addEditAccountSetting()
	{			
		$('#account-setting').addClass('processing');
		$.ajax({
				type : 'post',
				url : site_url + "user/addEditAccountSetting",
				data : $("#account-setting").serialize(),
				success : function(data){ 
						$('#account-setting').removeClass('processing');
						}
				});
	}
	
	
	
	/* function for check password */
	function changePassword()
	{	
		var cur_password = $('#cur_password').val();
		var new_password = $('#new_password').val();
		var confirm_password = $('#confirm_password').val();
		
		if(cur_password.length < 1 || cur_password == '')
		{
			$('#cur_password_msg').html("Current Password should not be blank");
			return false;
		}
		if(new_password.length < 1 || new_password == '')
		{
			$('#new_password_msg').html("New password should not be blank");
			return false;
		}
		if(confirm_password.length < 1 || confirm_password == '')
		{
			$('#confirm_password_msg').html("Confirm password should not be blank");
			return false ;
		}
		if(new_password  !=  confirm_password)
		{
			$('#confirm_password_msg').html("Password mismatch");
			return false;
		}
		$.ajax({
				type : 'post',
				url : site_url + "user/changePassword",
				data: "cur_password="+cur_password+"&new_password="+new_password+"&confirm_password="+confirm_password,
				success : function(data){
					   if(data == 'false')
					   {
							$('#cur_password_msg').html("Current password is incorrect.");
					   }else{
							$('#cur_password').val("");
							$('#new_password').val("");
							$('#confirm_password').val("");
							$('#cur_password_msg').html("");
							$('#new_password_msg').html("");
							$('#confirm_password_msg').html("");
							$('#new_password_bar').html("");
							$('#new_password_text').html("");
							userNotification("Your Password change successfully");
					   }
				}
			});
		return false;
	} //end



	function showMandatoryBlocks(sub_category_id)
	{
		if(sub_category_id == 0 || sub_category_id == '')
			return false;
	
		$.ajax({
			type :'post',
			url : site_url+"post/showMandatoryBlocks",
			data: "sub_category_id="+sub_category_id,
			success : function(data){
				var ids = data.split(',');
				var icons = "";
	
				for(var i =0; i<ids.length;i++)
				{
					if(i==0){	$('#mandatory_capsules').removeAttr('style'); }
					
					if(ids[i] == 1)
					{
						icons += '<span class ="para">Paragraph</span> ';
					}
					else if(ids[i] == 2)
					{
						icons += '<span class ="list">List</span> ';
					}
					else if(ids[i] == 3)
					{
						icons += '<span class ="image">Image</span> ';
					}
					else if(ids[i] == 4)
					{
						icons += '<span class ="video">Video</span> ';
					}
					else if(ids[i] == 5)
					{
						icons += '<span class ="comm">Comments</span> ';
					}
					else if(ids[i] == 6)
					{
						icons += '<span class ="polls">Polls</span> ';
					}
					else if(ids[i] == 7)
					{
						icons += '<span class ="opinion">Opinion</span> ';
					}
					else if(ids[i] == 8)
					{
						icons += '<span class ="amazon">Amazon</span> ';
					}
				} //end for
				$('.post-tags').html(icons);
			}
	
		});
	
	}

// message js

	/* This function is used for the show post by zip code */
	function showPostsByZip(zip_code)
	{	
		if(zip_code == 0 || zip_code == '')
			return false;
	
		$.ajax({
			type :'post',
			url : site_url+"post/showLocalPosts/"+zip_code,
			data: "zip_code="+zip_code,
			success : function(data){
				var localPostData = $.parseJSON(data);
				$("#show-post").html(localPostData.data);
				$("#bcity_name").html(localPostData.city_name);
				document.title = localPostData.city_name;
				/*change url by ajax*/
				history.pushState('', '', localPostData.cur_url);
			}
		})
	}

	/* This function is used for follow location by zipcode */
	function followLocation(zip_code,single_post)
	{
	
		if(zip_code == 0 || zip_code == '')
			return false;
		$.ajax({
			type :'post',
			url : site_url+"post/followLocation",
			data: "zip_code="+zip_code+"&single_post="+single_post,
			success : function(data){
				var unFollowLocation = $.parseJSON(data);
				if(single_post == 'single_post'){
					$("#fol_unfol_location").html(unFollowLocation.data);
					userNotification("You are successfully Follow this location.");
				}else{
					$("#followLocationDiv").html(unFollowLocation.data);
					userNotification("You are successfully Follow this location.");
					
				}
			}
		})
	}


	/* This function is used for unfollow location by zipcode */
	function unFollowLocation(zip_code,single_post)
	{
		if(zip_code == 0 || zip_code == '')
			return false;
		$.ajax({
			type :'post',
			url : site_url+"post/unFollowLocation",
			data: "zip_code="+zip_code+"&single_post="+single_post,
			success : function(data){
				var unFollowLocation = $.parseJSON(data);
				if(single_post == 'single_post'){
					$("#fol_unfol_location").html(unFollowLocation.data);
					userNotification("You are successfully Unfollow this location.");
				}else{
					$("#followLocationDiv").html(unFollowLocation.data);
					userNotification("You are successfully Unfollow this location.");
				}
			}
		})
	}

	/* This function is used for publish post using ajax */
	function publishPost(post_id)
	{
		if(post_id == 0 || post_id == '')
			return false;
		$.ajax({
			type :'post',
			url : site_url+"post/publishPost",
			data: "post_id="+post_id,
			success : function(data){
					var unpublishPost = $.parseJSON(data);
					$("#pub_unpub_post").html(unpublishPost.data);
					userNotification("You are done successfully Publish this post.");
				}
		})
	}


	/* This function is used for unpublish post using ajax */
	function unpublishPost(post_id)
	{
		if(post_id == 0 || post_id == '')
			return false;
		$.ajax({
			type :'post',
			url : site_url+"post/unpublishPost",
			data: "post_id="+post_id,
			success : function(data){
				var publishPost = $.parseJSON(data);
				$("#pub_unpub_post").html(publishPost.data);
				userNotification("You are done successfully Unpublish this post.");
			}
		})
	}


	/* This is function is used for showing particular message to user*/
	function showMessage(message_id ,page_type)
	{
		if($('#li'+message_id).hasClass('active') == true)
			return false;

		$('#anchor'+message_id).removeClass('inbox');
		$('li').removeClass('active');
		$('#li'+message_id).addClass('active');
	  	$.ajax({
			type : 'post',
			url: site_url +'message/messageDescription',
			data :'message_id='+message_id+'&page_type='+page_type,
			success: function(data){
				$('#description').html(data);

				
			}
		});
	}
	
	

    function  postMessageReply()
	{
		if($('#reply_submit').hasClass('posted') == true)
			return false;
		
		$('#div_reply_subject').html('');
		$('#div_reply_description').html('');
		var reply_subject = $('#reply_subject').val();
		var description = $('textarea#txtdescription').val();
		var message_parent_id =$('#message_parent_id').val();
		
		if($('#reply_all').is(':checked'))
			var to = $('#to_all').val();
		else
			var to = $('#to').val();
        
		
		if(reply_subject== "" || reply_subject== null)
		{
			$('#div_reply_subject').html('Subject Cannot be empty ');
			return false;
		
		}
		if(description == "" || description == null)
		{
			$('#div_reply_description').html('Description field Cannot be empty ');
			return false;
		}
		if(description.length >1000)
		{
				$('#div_reply_description').html("Message length exceed from 1000 character ");
			return false ;
		}
		$('#reply_submit').addClass('posted');
		$.ajax({
			type : 'post',
			url : site_url + "message/postMessageReply",
			data: "reply_subject="+reply_subject+"&description="+description.replace(/<br>/gi, '\n')+"&message_parent_id="+message_parent_id+"&to="+to,
			success : function(data){
				userNotification("You Message has been posted successfully.");
				$('textarea#txtdescription').val('');
				$('#reply_submit').removeClass('posted');			
			}
					
		});
		return false;
	}


	
	function delete_message(message_id ,page_type)
	{
			$('#description').html('');
			$("#li"+message_id).hide();
			$('li').removeClass('active');
			closePopDiv('confirm');
			$.ajax({
				type: "post",
				data: "message_id="+message_id+"&page_type="+page_type,
				url :site_url+ "message/delete_message",
				success : function(data)
							{	
								userNotification("You Message has been deleted successfully.");
							}
				});
		
	}

	
	function archive_message(message_id, page_type)
	{
		$('#description').html('');
		$("#li"+message_id).hide();
		$('li').removeClass('active');
		
		$.ajax({
			type:'post',
			data: "message_id="+message_id+"&page_type="+page_type,
			url : site_url +"message/makeArchive",
			success : function(data)
			{
				userNotification("You Message has been archive successfully.");
			}		
		});
	}
	
	
	function remove_archive_message(message_id)
	{
		$('#description').html('');
		$("#li"+message_id).hide();
		$('li').removeClass('active');

		$.ajax({
			type:'post',
			url : site_url +"message/removeArchive/"+message_id,
			success : function(data)
			{	
				userNotification("You Message has been moved to inbox successfully.");
			}		
		});
	}
	
	
	function compose_message()
	{
		var to = $(".tagedit-list li").length;
		var subject = $('#compose_subject').val();
		var description = $('#compose_description').val();
		$('#error_to').html("");
		$('#error_subject').html("");
		$('#error_description').html("");

		
		if(to <= 1)
		{
			$('#error_to').html("At least 1 receiver name  required");
			return false;
			
		}
		if(subject=="" || subject == null )
		{
			$('#error_subject').html(" Subject Field required");
			return false;
			
		}
		if(description=="" || description ==null)
		{
			$('#error_description').html("Message Field required");
			return false ;
		}
		if(description.length >1000)
		{
				$('#error_description').html("Message length exceed from 1000 character ");
			return false ;
		}
		else
		{
			closePopDiv('new-message');
			$.ajax({
				 type: "post",
				 url : site_url+ "message/compose",
				 data:$("#compose").serialize(),
				 success: function(data)
						{	
							userNotification("You Message has been posted successfully.");
						}
				});
		}
		return false;
	}
	
	
	function popupClear()
	{
			$('.compose_success').html('');
			$('ul.holder').find('li.bit-box').remove().end();
		    $('select#compose_to').find('option').remove().end();
			$('#error_to').html("");
			$('#error_subject').html("");
			$('#error_description').html("");
			$('#compose_subject').val('');
			$('#compose_description').val('');
	}
		
	function show_reply_post()
	{
		$('.righttop').slideToggle("slow");
		$('.msgpara').slideToggle("slow");
		$('.msgreply').slideToggle("slow");
		$('.icon1').slideToggle("slow");
		$('.icon3').slideToggle("slow");
	}

	function showCategoryChild(category_id)
	{
		if(category_id == 0)
			return false;
	
		$.ajax({
			type :'get',
			url : site_url+"post/categoryChild",
			data: "category_id="+category_id,
			success : function(data){
				var n=data.split("##");
				if(parseInt(n[0]))
				{
					$("#catchild #subslideDiv ul").html(n[1]);
					$("#category-child-wrapper").fadeIn();
					subScrollDiv();
					subCategoryClick();
				}else{
					$("#catchild").html('');
					$("#category-child-wrapper").fadeOut();
				}
			}
		});
	}//end

	
	
	function postAnswer(post_id)
	{
		if($('#answer_error_msg').hasClass('postanswer') == true)
				return false;
	
		var description = document.getElementById('qna_description').value;
		if(description =="" || description == null)
		{
			$('#answer_error_msg').html('Answer cannot be empty');
			return false;
		}
		
		$('#answer_error_msg').addClass('postanswer');
		$.ajax({
			type :'post',
			url : site_url+"post/postAnswer",
			data: "post_id="+post_id +"&description="+description,
			success: function(data){
				$('#answer_error_msg').removeClass('postanswer');
				document.getElementById('qna_description').value = "";
				$('#dynamic_answer').append(data);
			}
	
		});
		return false;
	
	}



	function deleteAnswer(answer_id)
	{
		if($('#answer-box-'+answer_id).hasClass('answer') == true)
				return false;
		$('#answer-box-'+answer_id).addClass('answer');
		
			$.ajax({
				type :'post',
				url : site_url+"post/deleteAnswer",
				data: "answer_id="+answer_id,
				success: function(data){
					closePopDiv('confirm');
					$('#answer-box-'+answer_id).removeClass('answer');
					$('#answer-box-'+answer_id).hide();
				}
		
			});
	}


	function loadMoreUserFeeds(page_type)
	{
		$("#show-post-loading").show();
		offset = $("#load_more_feeds").children(".feeds-main-block").size();
		data = 'offset='+offset+'&page_type='+page_type;
		posts = ajaxCall('user/loadMoreUserFeeds',data,false);
		cnt = posts.split('feeds-main-block').length - 1;
		if($.trim(posts)=="" || cnt < 10 ) $("#show-post-more").hide();
		$("#load_more_feeds").append(posts);
		$("#show-post-loading").hide();
	}
	
	/*
		Function for get show more results 
		Created by : Ashvin soni - 02-05-2013
	*/
	function loadMoreContest(page_type)
	{
		$("#show-post-loading").show();
		offset = $("#load_more_feeds").children(".feeds-main-block").size();
		data = 'offset='+offset+'&page_type='+page_type;
		posts = ajaxCall('contest/loadMoreContest',data,false);
		cnt = posts.split('feeds-main-block').length - 1;
		if($.trim(posts)=="" || cnt < 2 ) $("#show-post-more").hide();
		$("#load_more_feeds").append(posts);
		$("#show-post-loading").hide();
	}
	
	
	

	function loadMoreUserProfile(user_id,page_type)
	{
		$("#show-post-loading").show();
		offset = $("#loadmorepost").children().size()+1;
		data = 'offset='+offset+'&user_id='+user_id+'&page_type='+page_type;
		posts = ajaxCall('user/loadMoreUserProfile',data,false);
		cnt = posts.split('feeds-main-block').length - 1;
		if($.trim(posts)=="" || cnt < 10 ) $("#show-post-more").hide();
		$("#loadmorepost").append(posts);
		$("#show-post-loading").hide();
	}

	function reportAbuse()
	{ 
		$('#email_msg').html('');
		email = $('#email').val();
		if(email == "" || email == null)
		{
			$('#email_msg').html ('Email field  cannot be empty.');
			return false;
		}
		if(!isValidEmailAddress(email))
		{
			$('#email_msg').html('Please enter a valid email.');
			return false;
		}
	
		$.ajax({
			type: "POST",
			url: site_url + "post/reportAbuse",
			data: $("#frm_report_abuse").serialize(),
			success: function (data){ 
				userNotification("This post marked as abused and mail sent to the admin.");
				$('.report-abuse-link').html('<a href="javascript:void(0);" style="cursor:auto;" title="This is reported as abuse"></a>');
			}
		});	
		return true;
	}


	function contact_us_submit()
	{
		$.ajax({
			type: "POST",
			url: site_url + "page/contact_us_submit",
			data: $("#frm-contact-us").serialize(),
			success: function (data){
				if(data){
					$("#name").val('').trigger('onPropertyChange');
					$("#email").val('').trigger('onPropertyChange');
					$("#country").val('').trigger('onPropertyChange');
					$("#phone").val('').trigger('onPropertyChange');
					$("#comment").val('').trigger('onPropertyChange');
					$("#remLen").html('300');
					userNotification("Your information has been recorded successfully and you'd hear back from us soon. Thanks for writing to us:)");			
				}else{
					userNotification("Oops!!! something went wrong. Please try again.");			
				}
			}
		});	
		return false;
	}


// user.js

	function addMoreEmail(user_id)
	{
			var mailElement = '<div class="editfield"><input type="text" name="postTag[]" class="inputmain" /><span style="cursor:pointer;" class="c-orange font12" onClick="if(saveEmails(\'user_email\', \'user_email\', '+user_id+', this)){deleteThisTag(this);}">&nbsp;(save)</span>&nbsp;<span  style="cursor:pointer;" class="close12" onClick="deleteThisTag(this)"></span><br><span class="error"></span></div>';
	
			$("#user-email-parent-div").append(mailElement);			 
	}

	function deleteEmail(dis, email_id)
	{ 
		var data = 'email_id='+email_id;
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "user/ajaxDeleteEmail",
			data: data,
			success: function (data){ 
				$(dis).parent().parent().remove();
			}
		});
	}


	function saveEmails(table, field, user_id, dis)
	{ 
		
		var val = $(dis).parent().find('input').val();
		str_error = $(dis).parent().find('.error');
	
		err = 0;
		str_error.html('');
	
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,20})$/;
		if(val == '')
		{ 
			str_error.html('Please enter your email');
			err=1;
		}
		else if (reg.test(val) == false)
		{
			str_error.html('Please enter a valid email');
			err=1;
		}
	
		if(err == 1)
			return false;
	
		var data = 'table='+table+'&'+field+'='+val+'&user_id='+user_id+'&row_id=';
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "user/editInputs",
			data: data,
			success: function (email_id){ 
	
				var mailElement = '<div class="email-rows">'+
					'<div id="user-email-div-'+email_id+'">'+
					'<span id="user_email_span_'+email_id+'">'+val+'</span>'+
					'<span style="cursor:pointer;" class="c-orange font12" onclick="onlyShow(\'user-email-edit-div-'+email_id+'\'); onlyHide(\'user-email-div-'+email_id+'\')">&nbsp;(Edit)</span>'+
					'&nbsp;<span style="cursor:pointer;" class="close12" onclick="deleteEmail(this,\''+email_id+'\')"></span>'+
				'</div>'+
				'<div id="user-email-edit-div-'+email_id+'" style="display:none;">'+
					'<input type="text" name="user_email" class="inputmain" id="user_email_'+email_id+'" value="'+val+'"/>'+
					'<span style="cursor:pointer;" class="c-orange font12" onclick="editInputs(\'user_email\', \'user_email\', \'user_email_'+email_id+'\',\'user_email_span_'+email_id+'\', '+email_id+'); onlyHide(\'user-email-edit-div-'+email_id+'\');onlyShow(\'user-email-div-'+email_id+'\')">&nbsp;(Save)</span>'+
				'</div>'
				'</div>';
				$("#user-email-div").append(mailElement);
				
			}
		});
		return true;
	}


	
	function validateEmail(id) 
	{
		err = 0;
		$('#'+id+'_err').html('');
	
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,20})$/;
		email = $.trim($('#'+id).val());
		if(email == '')
		{ 
			$('#'+id+'_err').html('Please enter your email');
			err=1;
		}
		else if (reg.test(email) == false)
		{
			$('#'+id+'_err').html('Please enter a valid email');
			err=1;
		}
	
		if(err == 1)
			return false;
		else 
			return true;
	}



	function validateUsername(id) 
	{
		err = 0;
		$('#'+id+'_err').html('');
		
		strRegExp = "[^A-Za-z0-9\\s]";
		user_name = $.trim($('#'+id).val());
		charpos = user_name.search(strRegExp);
		if(user_name.length <= 0)
		{ 
			$('#'+id+'_err').html('Please enter username');
			err=1;
		}
		else
		{
			if (charpos >=0)
			{
				$('#'+id+'_err').html('Invalid username');
				err=1;
			}
		}
	
		if(err == 1)
			return false;
		else 
			return true;
	}

	
	function validatePassword(id) 
	{
		err = 0;
		$('#'+id+'_err').html('');
		
		password = $.trim($('#'+id).val());
		if(password.length <= 0)
		{ 
			$('#'+id+'_err').html('Please enter password');
			err=1;
		}
		else if (password.length < 6)
		{
			$('#'+id+'_err').html('Should be atleast 6 characters');
			err=1;
		}
	
		if(err == 1)
			return false;
		else 
			return true;
	}



	function validateConfirmPassword(pass_id, conf_id) 
	{
		err = 0;
		$('#'+conf_id+'_err').html('');
		
		password = $.trim($('#'+pass_id).val());
		confirm_password = $.trim($('#'+conf_id).val());
		if(confirm_password.length <= 0)
		{ 
			$('#'+conf_id+'_err').html('Please enter confirm password');
			err=1;
		}
		else if (password.length < 6)
		{
			$('#'+pass_id+'_err').html('Should be atleast 6 characters');
			err=1;
		}
		else if (password != confirm_password)
		{
			$('#'+pass_id+'_err').html('The password field does not match the Confirm Password field');
			err=1;
		}
		else
		{
			$('#'+pass_id+'_err').html('');
		}
	
		if(err == 1)
			return false;
		else 
			return true;
	}
	
	
	

	function validateCaptcha(id) 
	{
		err = 0;
		$('#'+id+'_err').html('');
		
		captcha_code = $.trim($('#'+id).val());
		
		if(captcha_code.length <= 0)
		{ 
			$('#'+id+'_err').html('Please enter security code');
			err=1;
		}
		if(err == 1)
			return false;
		else 
			return true;
	}

	function validateTerms(id) 
	{
		err = 0;
		$('#'+id+'_err').html('');
		
		if ($('#'+id).attr('checked'))
		{ 
			return true;
		}
		else
		{
			$('#'+id+'_err').html('For registration you have to agree to the Terms and Conditions');
			return false;
		}
	}

	/* cookie login */
	(function ($, document, undefined)
	{
		var pluses = /\+/g;
	
		function raw(s) {
			return s;
		}
	
		function decoded(s) {
			return decodeURIComponent(s.replace(pluses, ' '));
		}
	
		var config = $.cookie = function (key, value, options) {
	
			// write
			if (value !== undefined) {
				options = $.extend({}, config.defaults, options);
	
				if (value === null) {
					options.expires = -1;
				}
	
				if (typeof options.expires === 'number') {
					var days = options.expires, t = options.expires = new Date();
					t.setDate(t.getDate() + days);
				}
	
				value = config.json ? JSON.stringify(value) : String(value);
	
				return (document.cookie = [
					encodeURIComponent(key), '=', config.raw ? value : encodeURIComponent(value),
					options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
					options.path    ? '; path=' + options.path : '',
					options.domain  ? '; domain=' + options.domain : '',
					options.secure  ? '; secure' : ''
				].join(''));
			}
	
			// read
			var decode = config.raw ? raw : decoded;
			var cookies = document.cookie.split('; ');
			for (var i = 0, parts; (parts = cookies[i] && cookies[i].split('=')); i++) {
				if (decode(parts.shift()) === key) {
					var cookie = decode(parts.join('='));
					return config.json ? JSON.parse(cookie) : cookie;
				}
			}
	
			return null;
		};
	
		config.defaults = {};
	
		$.removeCookie = function (key, options) {
			if ($.cookie(key) !== null) {
				$.cookie(key, null, options);
				return true;
			}
			return false;
		};
	
	})(jQuery, document);
	//end cookie function


	function ajaxLogin(u_id,p_id,r_id) 
	{
		err = 0;
		$('#'+u_id+'_err').html('');
		$('#'+p_id+'_err').html('');
		
		strRegExp = "[^A-Za-z0-9\\s]";
		user_name = $.trim($('#'+u_id).val());
		charpos = user_name.search(strRegExp);
		if(user_name.length <= 0)
		{ 
			$('#'+u_id+'_err').html('Please enter username');
			err=1;
		}
		else
		{
			if (charpos >=0)
			{
				$('#'+u_id+'_err').html('Invalid username');
				err=1;
			}
		}
	
		password = $.trim($('#'+p_id).val());
		if(password.length <= 0)
		{ 
			$('#'+p_id+'_err').html('Please enter password');
			err=1;
		}
	
		if(err == 1)
			return false;
	
	
		if ($('#'+r_id).attr('checked'))
		{ 
			remember_me = 1;
		}
		else
		{
			remember_me = 0;
		}
		
		if (remember_me == 1)
		{
			//set cookies to expire in 14 days
			$.cookie('user_name_cookie', user_name, { expires: 14, path: '/'});
			$.cookie('password_cookie', password, { expires: 14, path: '/' } );
			$.cookie('remember', true, { expires: 14, path: '/'});
		}else
		{
			// reset cookies
			$.cookie('user_name_cookie', null);
			$.cookie('password_cookie', null);
			$.cookie('remember', null);
		}
		mydata = 'user_name='+user_name+'&password='+password+'&remember_me='+remember_me;
		$.ajax({
			type: "POST",
			async: false,
			url: site_url + "user/ajaxLogin",
			data: mydata,
			success: function (data){
				if(data==0)
				{
					$('#'+u_id+'_err').html('Invalid username or password');
					return false;
				}
				else if(data==1)
				{
					window.location = site_url+'post/showposts/all';
				}				
				else
				{ 
					window.location = site_url+'post/showposts/all';
				}
			}
		});
	}


	function validateSignUpform(id) 
	{
		form_err = 0;
		if(!validateUsername('user_name')) form_err = 1;
		if(!validateEmail('email')) form_err = 1;
		if(!validatePassword('password')) form_err = 1;
		if(!validateConfirmPassword('password','confirm_password')) form_err = 1;
		if(!validateCaptcha('captcha_code')) form_err = 1;
		if(!validateTerms('terms')) form_err = 1;
	
		if(form_err == 1)
			return false;
		else 
			return true;
	}

	function validateSocialSignUpform(id) 
	{
		form_err = 0;
		if(!validateUsername('user_name')) form_err = 1;
		if(!validateProfileName('user_name')) form_err = 1;
		if(!validateCaptcha('captcha_code')) form_err = 1;
		if(!validateTerms('terms')) form_err = 1;
	
		if(form_err == 1)
			return false;
		else 
			return true;
	}




	function validateProfileName(id) 
	{
		err = 0;
		$('#'+id+'_err').html('');
		
		strRegExp = "[^A-Za-z0-9\\s]";
		profile_name = $.trim($('#'+id).val());
		charpos = profile_name.search(strRegExp);
		if(profile_name.length <= 0)
		{ 
			$('#'+id+'_err').html('Please enter profile name');
			err=1;
		}
		else
		{
			if (charpos >=0)
			{
				$('#'+id+'_err').html('Invalid profile name');
				err=1;
			}
		}
	
		if(err == 1)
			return false;
		else 
			return true;	
	}



	function validateZipCode(id) 
	{
		
		err = 0;
		$('#'+id+'_err').html('');
		
		strRegExp = /^\d{5}$|^\d{5}-\d{4}$/;
		val = $.trim($('#'+id).val());
		zip_val = val.split('-')
		
		charpos = strRegExp.test(zip_val[0])
		
		if (strRegExp.test(zip_val[0]) == false)
		{
			$('#'+id+'_err').html('Invalid zip code');
			err=1;
		}
	
		if(err == 1){
			return false;
		}else{ 
			$("#zip_code").val(zip_val[0]);
			return true;
		}
	}



// common js
// JavaScript Document

	function clearText(field)
	{
		if (field.defaultValue == field.value) field.value = '';
		else if (field.value == '') field.value = field.defaultValue;
	}
		
	
	
	$(function(){
		$('<div id="fade"></div>').prependTo($('body'));
		$(".designer").customInput();
	});

	
	function changeText()
	{
		  $('.showhidemenu').click(function(){
		  var findText = $(this).text();
		  var altText = $(this).attr('rel');
		  $(this).text(altText);
		  $(this).attr('rel',findText);
		  });
	} 
	
	/** Function for show horizontal share this */
	/*function HorizontalShareThis()
	{
		stLight.options({publisher: "1f450bf1-53d0-48d0-ad2c-603685f88f3d"});
	}*/

	$(document).ready(function(){
		
		var urlParameter = document.URL.split('/')[6];
		if(urlParameter == 'localpost')
		{
			$("#local-post-checkbox").removeClass("cbox");
			$("#local-post-checkbox").addClass("cbox-selected");
			$(".checkboxmain").trigger('click');
		}
		
		
		changeText();
		//HorizontalShareThis();
		
		$(':radio.designer').css({'opacity':'0'});	
		
		//Outline None	
		$('a, input').each(function() {
			$(this).attr("hideFocus", "true").css("outline", "none");
		});	
		$('.user-detail-block .detail-edit-block tr td:last-child').css("text-align", "right");
		$('.dropDown li').find('img').css({'opacity':'0.5'})
		$('.dropDown li').hover(function(){
			$(this).find('img').css({'opacity':'1'})
			},function(){
				$(this).find('img').css({'opacity':'0.5'})
			});
	
		//login div hide on body click
		$(".loginpop, .arrowclick, #catpopup").mouseup(function() {
			return false
		});
		
		//mouseup function
		$(document).mouseup(function() {
			$(".arrowclick").removeClass("active");
			$(".loginpop").hide();
			$("#catpopup").slideUp();
		});	
		//end
		// search box 
		$('#txtad').click(function(){
			$(".advancesearch").show();
			$(".search-mini").hide();
		});
		
		//click function
		$('#txtnm').click(function(){
			$(".search-mini").show();
			$(".advancesearch").hide();
		});	
		//end
		
		
		//sort function
		$('.sortby .sortmain div').click(function(){
			$('.sortby .sortmain div').removeClass('selected');
			$(this).addClass('selected');
		});
		//end
		
		
		//sort catagory function
		$('.catsearch .sortby .sortmain div').click(function(){
			$('.sortby .sortmain div').removeClass('active');
			$(this).addClass('active');
		});
		//end
		
		
		// create post edit page tabs 
		$('.account-info-tab .float').bind("click",function(){
		  $(this).parent('.account-info-tab').children('.float').removeClass('active');
		  $(this).addClass('active');
		  $('#comp, #utube').hide();
		  var show2Tab=$('#'+$(this).attr('rel'));
		  setTimeout(function(){show2Tab.fadeIn();});
		 });			
	
		// map js
		jQuery(function ($) {
		
			var TooltipTimer;
			var planetImage = $('#planetimage'),
			imageOffset = planetImage.position();
			$('area.tip').bind('mouseenter',function(e){
				 offset = $(this).areaOffset(true);
			  if(TooltipTimer)
				clearTimeout(TooltipTimer);
				$('.tipBody').html($("#map-content"+$(this).attr('alt')).html());
				$('#tooltip').css({top:imageOffset.top + offset.top+20,left:imageOffset.left + offset.left-100,"z-Index":99});
				$('#tooltip').show();
			});
			//end
			
		//bind function
		$('.tip').bind("mouseleave",function(){
				 TooltipTimer=setTimeout(function(){$('#tooltip').hide()},100);
			});
		
		$('#tooltip').bind("mouseenter",function(){
				if(TooltipTimer)
				clearTimeout(TooltipTimer);
			});
		$('#tooltip').bind("mouseleave",function(){
				$(this).hide();
			});
			});	
	
		
		/* accordion for faq page Start */
		$('.left-faq').click(function(){
			if($(this).next().is(":visible"))
			{
				$(this).next().slideUp();
			}
			else
			{
				$(this).next().slideDown();
			}
		});
		 /* accordion for faq page End */
		 accordin(); // accrodion
		 
		 
		$(document).keypress(function(e){
		if(e.keyCode==27){
			closePopDiv(compDiv)}});
		$(window).scroll(function(){$("#"+compDiv).stop().animate({"top":(arrPageSizes[3]/ 2 - $("#" + compDiv).height() /2+getScrollTop())+"px",opacity:1.0},500)});
		
		/* script for account information tab */
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
		$(".account-info-tab #accountInformation").bind("click", function(){
				$(".user-thmb-block").css("display","block");
				$(".user-detail-block").css("display","block");
				$(".my-earning-block").css("display","none");
				$(".my-seting-block").css("display","none");
				$(".imp-userinfo-main-block").css("display","none");
		});
		
		$(".account-info-tab #earningAccount").bind("click", function(){			
				$(".my-earning-block").css("display","block");
				$(".user-thmb-block").css("display","none");
				$(".user-detail-block").css("display","none");
				$(".my-seting-block").css("display","none");
				$(".imp-userinfo-main-block").css("display","none");				
		});
		
		$(".account-info-tab #mySetting").bind("click", function(){
				$(".my-seting-block").css("display","block");
				$(".user-thmb-block").css("display","none");
				$(".user-detail-block").css("display","none");
				$(".my-earning-block").css("display","none");
				$(".imp-userinfo-main-block").css("display","none");
				
		});
		
		$(".account-info-tab #changePassword").bind("click", function(){
				$(".imp-userinfo-main-block").css("display","block");
				$(".user-thmb-block").css("display","none");
				$(".user-detail-block").css("display","none");
				$(".my-earning-block").css("display","none");
				$(".my-seting-block").css("display","none");
						
		});
		var classInfo = $("#accountInformation").closest("div").attr("class");
		if(classInfo = "float active")
		{
			$(".user-thmb-block").css("display","block");
			$(".user-detail-block").css("display","block");
			$(".my-earning-block").css("display","none");
			$(".my-seting-block").css("display","none");
			$(".imp-userinfo-main-block").css("display","none");
		}
		/* script for account information tab end here */
		
		$(".designer").customInput(); 
		
		/* select dropodown */
		designerSelect(); 
		$('select.designer').css({'opacity':'0'});
		
		// The select element to be replaced:
		var select = $('select.add-post-category-fancy');
	
	
		var selectBoxContainer = $('<div>',{
			width		: select.outerWidth(),
			className	: 'tzSelect',
			html		: '<div class="selectBox"></div>'
		});
	
		var dropDown = $('<ul>',{className:'dropDown'});
		var selectBox = selectBoxContainer.find('.selectBox');
		
		// Looping though the options of the original select element
		
		select.find('option').each(function(i){
			var option = $(this);
			
			if(i==select.attr('selectedIndex')){
				selectBox.html(option.text());
			}
			
			// As of jQuery 1.4.3 we can access HTML5 
			// data attributes with the data() method.
			
			if(option.data('skip')){
				return true;
			}
			
			// Creating a dropdown item according to the
			// data-icon and data-html-text HTML5 attributes:
			
			var li = $('<li>',{
				html:	'<img src="'+option.data('icon')+'" /><span>'+
						option.data('html-text')+'</span>'
			});
					
			li.click(function(){
				
				selectBox.html(option.text());
				dropDown.trigger('hide');
				
				// When a click occurs, we are also reflecting
				// the change on the original select element:
				select.val(option.val());
				select.trigger('onchange');
				
				return false;
			});
			
			dropDown.append(li);
		});
		
		selectBoxContainer.append(dropDown.hide());
		select.hide().after(selectBoxContainer);
		
		// Binding custom show and hide events on the dropDown:
		
		dropDown.bind('show',function(){
			
			if(dropDown.is(':animated')){
				return false;
			}
			
			selectBox.addClass('expanded');
			dropDown.slideDown();
			
		}).bind('hide',function(){
			
			if(dropDown.is(':animated')){
				return false;
			}
			
			selectBox.removeClass('expanded');
			dropDown.slideUp();
			
		}).bind('toggle',function(){
			if(selectBox.hasClass('expanded')){
				dropDown.trigger('hide');
			}
			else dropDown.trigger('show');
		});
		
		selectBox.click(function(){
			dropDown.trigger('toggle');
			return false;
		});
	
		// If we click anywhere on the page, while the
		// dropdown is shown, it is going to be hidden:
		$(document).click(function(){
			dropDown.trigger('hide');
		});
		
		
		// The select element to be replaced:
		var select = $('select.add-post-sub-category-fancy');
	
		var selectBoxContainer = $('<div>',{
			width		: select.outerWidth(),
			className	: 'tzSelect',
			html		: '<div class="selectBox"></div>'
		});
	
		var dropDown = $('<ul>',{className:'dropDown'});
		var selectBox = selectBoxContainer.find('.selectBox');
		
		// Looping though the options of the original select element
		
		select.find('option').each(function(i){
			var option = $(this);
			
			if(i==select.attr('selectedIndex')){
				selectBox.html(option.text());
			}
			
			// As of jQuery 1.4.3 we can access HTML5 
			// data attributes with the data() method.
			
			if(option.data('skip')){
				return true;
			}
			
			// Creating a dropdown item according to the
			// data-icon and data-html-text HTML5 attributes:
			
			var li = $('<li>',{
				html:	'<img src="'+option.data('icon')+'" /><span>'+
						option.data('html-text')+'</span>'
			});
					
			li.click(function(){
				
				selectBox.html(option.text());
				dropDown.trigger('hide');
				
				// When a click occurs, we are also reflecting
				// the change on the original select element:
				select.val(option.val());
				select.trigger('onchange');
				return false;
			});
			
			dropDown.append(li);
		});
		
		selectBoxContainer.append(dropDown.hide());
		select.hide().after(selectBoxContainer);
		
		// Binding custom show and hide events on the dropDown:
		
		dropDown.bind('show',function(){
			
		if(dropDown.is(':animated')){
			return false;
		}
			
			selectBox.addClass('expanded');
			dropDown.slideDown();
			
		}).bind('hide',function(){
			
		if(dropDown.is(':animated')){
			return false;
		}
			
			selectBox.removeClass('expanded');
			dropDown.slideUp();
			
		}).bind('toggle',function(){
			if(selectBox.hasClass('expanded')){
				dropDown.trigger('hide');
			}
			else dropDown.trigger('show');
		});
		
		selectBox.click(function(){
			dropDown.trigger('toggle');
			return false;
		});
	
		// If we click anywhere on the page, while the
		// dropdown is shown, it is going to be hidden:
		
		$(document).click(function(){
			dropDown.trigger('hide');
		});
		
		
		postTypeClick();
		categoryClick();
		$("#subtoogleDiv").bind("click", function(e){													  
				$('#subslideDiv').slideToggle("fast");
				e.stopPropagation();
				setTimeout(function(){subScrollDiv();},150);
		});		
		
		
		/* code for show loader when any ajax request is made in application */
		$('#spinner').ajaxStart(function () {
			$(this).fadeIn('fast');
		}).ajaxStop(function () {
			$(this).stop().fadeOut('fast');
			//HorizontalShareThis();
		});
		
		
		/* Code for set cookie login functionality */
		var remember = $.cookie('remember');
		if (remember == 'true') 
		{
			var user_name = $.cookie('user_name_cookie');
			var password = $.cookie('password_cookie');
			$("#loginpop_remember").parent().trigger('click');
			$('#loginpop_username').val(user_name);
			$('#loginpop_password').val(password);
			$('#loginpop_username_label').text('');
			$('#loginpop_username_password').text('');
			
			$("#login_remember").parent().trigger('click');
			$('#login_user_name').val(user_name);		
			$('#login_password').val(password);
			$('#login_user_name_label').text('');
			$('#login_password_label').text('');
		}
		
		$("#admin").chosen({disable_search_threshold: 10});
		$("#read_write").chosen({disable_search_threshold: 10});
		$("#read").chosen({disable_search_threshold: 10});
		
		
	});	//document ready end


	// Global functions
	// accrodion script start
	function accordin()
	{
		$('.opendiv').hide(); 
		//On Click
		$('.expandablediv .grnhead').click(function(){
			if( $(this).next() .is(':hidden') ) { 
				$('.expandablediv .grnhead').removeClass('active').next() .slideUp(); 
				$(this).toggleClass('active').next() .slideDown();
			}
			else{
				$('.expandablediv .grnhead').removeClass('active') .next() .slideUp();
			}
			return false; 
		});
	}

	// popup div start
	var compDiv;
	var arrPageScroll;
	var arrPageSizes=new Array();
	function openPopDiv(divId)
	{
		if(document.getElementById('fade'))
					$('#fade').remove();
		$('<div id="fade"></div>').appendTo($('body'));
		$('#fade').click(function(){closePopDiv(divId);});
		compDiv=divId;
		centerPopup(divId);
		loadPopup(divId);
	}
	
	
	
	function closePopDiv(divId)
	{
		compDiv=divId;
		disablePopup(divId)
		$('#popupEdit').hide();
	}
	
	
	
	function loadPopup(popDiv)
	{
		$("#fade").show();
		$("div#"+popDiv).show()
	}


	function disablePopup(popDiv)
	{
		$("#fade").hide();
		$("div#"+popDiv).hide()
	}



	function centerPopup(popDiv)
	{
		var windowWidth=$(document).width();
		var windowHeight=$(document).height();
		var popupHeight=$("div#"+popDiv).height();
		var popupWidth=$("div#"+popDiv).width();
		arrPageScroll=___getPageScroll();
		arrPageSizes=___getPageSize();
		$("div#"+popDiv).css({"position":"absolute","top":(arrPageSizes[3]/ 2 - $("#" + compDiv).height() /2+getScrollTop())+"px","left":windowWidth/2-popupWidth/1.95,"z-Index":1005});
	   	$("#fade").css({"height":windowHeight,opacity:0.75,"width":windowWidth,"backgroundColor":"#fff","position":"absolute","z-index":"999","left":"0", "top":"0"});
	}


function ___getPageSize(){var xScroll,yScroll;if(window.innerHeight&&window.scrollMaxY){xScroll=window.innerWidth+window.scrollMaxX;yScroll=window.innerHeight+window.scrollMaxY}else if(document.body.scrollHeight>document.body.offsetHeight){xScroll=document.body.scrollWidth;yScroll=document.body.scrollHeight}else{xScroll=document.body.offsetWidth;yScroll=document.body.offsetHeight}var windowWidth,windowHeight;if(self.innerHeight){if(document.documentElement.clientWidth){windowWidth=document.documentElement.clientWidth}else{windowWidth=self.innerWidth}windowHeight=self.innerHeight}else if(document.documentElement&&document.documentElement.clientHeight){windowWidth=document.documentElement.clientWidth;windowHeight=document.documentElement.clientHeight}else if(document.body){windowWidth=document.body.clientWidth;windowHeight=document.body.clientHeight}if(yScroll<windowHeight){pageHeight=windowHeight}else{pageHeight=yScroll}if(xScroll<windowWidth){pageWidth=xScroll}else{pageWidth=windowWidth}arrayPageSize=new Array(pageWidth,pageHeight,windowWidth,windowHeight);return arrayPageSize};

function ___getPageScroll(){var xScroll,yScroll;if(self.pageYOffset){yScroll=self.pageYOffset;xScroll=self.pageXOffset}else if(document.documentElement&&document.documentElement.scrollTop){yScroll=document.documentElement.scrollTop;xScroll=document.documentElement.scrollLeft}else if(document.body){yScroll=document.body.scrollTop;xScroll=document.body.scrollLeft}arrayPageScroll=new Array(xScroll,yScroll);return arrayPageScroll};

	function getScrollTop()
	{
		var ScrollTop=document.body.scrollTop;
		if(ScrollTop==0)
		{
			if(window.pageYOffset)
				ScrollTop=window.pageYOffset;
			else 
				ScrollTop=(document.body.parentElement)?document.body.parentElement.scrollTop:0;
		 }
			return ScrollTop;
	}
	// popup div close
 


	//radio button
	jQuery.fn.customInput = function(){
		$(this).each(function(i){	
			if($(this).is('[type=checkbox],[type=radio]')){
				var input = $(this);
				
				input.css({'opacity':'0'});
				// get the associated label using the input's id
				var label = $('label[for='+input.attr('id')+']');
				
				//get type, for classname suffix 
				var inputType = (input.is('[type=checkbox]')) ? 'checkbox' : 'radio';
				
				// wrap the input + label in a div 
				$('<div class="custom-'+ inputType +'"></div>').insertBefore(input).append(input, label);
				
				// find all inputs in this set using the shared name attribute
				var allInputs = $('input[name='+input.attr('name')+']');
				
				// necessary for browsers that don't support the :hover pseudo class on labels
				label.hover(
					function(){ 
						$(this).addClass('hover'); 
						if(inputType == 'checkbox' && input.is(':checked')){ 
							$(this).addClass('checkedHover'); 
						} 
					},
					function(){ $(this).removeClass('hover checkedHover'); }
				);
				
				//bind custom event, trigger it, bind click,focus,blur events					
				input.bind('updateState', function(){	
					if (input.is(':checked')) {
						if (input.is(':radio')) {				
							allInputs.each(function(){
								$('label[for='+$(this).attr('id')+']').removeClass('checked');
							});		
						};
						label.addClass('checked');
					}
					else { label.removeClass('checked checkedHover checkedFocus'); }
											
				})
				.trigger('updateState')
				.click(function(){ 
					$(this).trigger('updateState'); 
				})
				.focus(function(){ 
					label.addClass('focus'); 
					if(inputType == 'checkbox' && input.is(':checked')){ 
						$(this).addClass('checkedFocus'); 
					} 
				})
				.blur(function(){ label.removeClass('focus checkedFocus'); });
			}
		});
	};



	function designerSelect()
	{
		$("select.designer").change(function () {
			var ds1 = "";
			var deId = this.id;
			$("#"+ deId +" option:selected").each(function () {
				ds1 = $(this).text();
			});
			$(this).prev().text(ds1);
		}).change();
	}//end

	function make_best(iValue, answerId)
	{
		if(document.getElementById('is_best_check'+iValue).checked == true){
			var checked_value = 1;
		}else{
			var checked_value = 0;
		}
		if(checked_value == 1){
			$("#answer-box-"+answerId).css('border','1px solid #EF792F');
			$("#is_best_check"+iValue).attr('title', 'Remove From Best Answer');
		}else
		{
			$("#answer-box-"+answerId).css('border','1px solid #CCCCCC');
			$("#is_best_check"+iValue).attr('title', 'Select This as Best Answer');
		}
		$.ajax({
				type: "POST",
				url: site_url + "post/make_best",
				data: "answerId="+answerId+"&checked_value="+checked_value,
				success: function (data){
					
				}
			});
	}

	
	/** function for the show designer scroll bar in post type */
	function scrollDivPostType()
	{
		$('#slidePostType').hover(function(){
			$(this).find('.jspVerticalBar').fadeIn();
		},function(){
			$(this).find('.jspVerticalBar').fadeOut(200);
		});
		var api = $('#slidePostType').jScrollPane(
		{
			showArrows:false,
			maintainPosition: false
		}).data('jsp');				   
	}//end
	
	
	/* Function for click on category show hide li */
	function postTypeClick()
	{
		$("#togglePostType").bind("click", function(e) {
				$('#slidePostType').slideToggle("fast");
				e.stopPropagation();
				setTimeout(function(){scrollDivPostType();},150);
		});
		$("#slidePostType ul li").click(function(){
			var textLi = $(this).text();
			var textvalue = $(this).attr('value');
			$("#togglePostType").html('');
			$("#togglePostType").append(textLi);
			$("#togglePostValue").val(textvalue);
			$('#slidePostType').slideUp("fast");
			showMandatoryBlocks(textvalue);
		});
		$(document).click(function() {
			   $('#slidePostType').slideUp("fast");
		});
	}//end
		
	
	/** function for the show designer scroll bar in category */
	function scrollDiv()
	{
		$('#slideDiv').hover(function(){
			$(this).find('.jspVerticalBar').fadeIn();
		},function(){
			$(this).find('.jspVerticalBar').fadeOut(200);
		});
		var api = $('#slideDiv').jScrollPane(
		{
			showArrows:false,
			maintainPosition: false
		}).data('jsp');				   
	}//end
	
	
	/* Function for click on category show hide li */
	function categoryClick()
	{
		$("#toogleDiv").bind("click", function(e) {
				$('#slideDiv').slideToggle("fast");
				e.stopPropagation();
				setTimeout(function(){scrollDiv();},150);
		});
		$("#slideDiv ul li").click(function(){
			var textLi = $(this).text();
			var category_id = $(this).attr('value');
			$("#toogleDiv").html('');
			$("#toogleDiv").append(textLi);
			$("#toogleDivValue").val(category_id);
			$('#slideDiv').slideUp("fast");
			showCategoryChild(category_id);
		});
		$(document).click(function() {
			   $('#slideDiv').slideUp("fast");
		});
	}//end
	
	
	/** function for the show designer scroll bar in subcategory */
	function subScrollDiv()
	{
		$('#subslideDiv').hover(function(){
			$(this).find('.jspVerticalBar').fadeIn();
		},function(){
			$(this).find('.jspVerticalBar').fadeOut(200);
		});
		//jscrollpane
		var api = $('#subslideDiv').jScrollPane(
		{
			showArrows:false,
			maintainPosition: false
		}).data('jsp');		   
	}//end	
	
	
	/* Function for show hide subcategory li */
	function subCategoryClick()
	{
		$("#subslideDiv ul li").click(function(){
			var textLi = $(this).text();
			var category_id = $(this).attr('value');
			$("#subtoogleDiv").html('');
			$("#subtoogleDiv").append(textLi);
			$("#subSubCategory").val(category_id);
			$('#subslideDiv').slideUp("fast");
		});
		$(document).click(function() {
			$('#subslideDiv').slideUp("fast");
		});
	}//end	


	/*Window Scroller */
	$(window).scroll(function(event){
		
		if($.active > 0 )
		{
			event.preventDefault();
			return false;
		}
		var documentHeight = $(document).height();
		var windowHeight = 	$(window).height();
		var scrollTop = $(window).scrollTop();
		var footerOffset = $("#footer-wrapper").offset().top;
		
		if(scrollTop == documentHeight - windowHeight){		
			if($("#show-post-more, #show-qna-more, #show-image-more, #show-video-more").hasClass("hide_button"))
			{				
				if($("#last_div").is(":visible"))
				{
					return false;
				}
				$("#show-post-more a, #show-qna-more a, #show-image-more a, #show-video-more a").trigger('click');
			}
		}	
	});
	/*Window Scroller END*/	
	
function removeCheckAdmin()
{
	if($('#admin_all').is(':checked')){
		$('#admin_all').attr("checked",false);
	}
}

function removeCheckRw()
{
	if($('#read_write_all').is(':checked')){
		$('#read_write_all').attr("checked",false);
	}
}

function removeCheckR(){
	if($('#read_all').is(':checked')){
		$('#read_all').attr("checked",false)
	}	
}

function checkbox_click_admin()
{
	if( $('#admin_all').is(':checked') ){
		$.ajax({
				type : 'post',
				url : site_url + "post/getUsersList",
				data: "",
				success : function(data){
						var response = $.parseJSON(data);
						
						$('#admin option').remove();
						$('#admin').html(response.users).trigger("chosen:updated");
				}
			});
	}else{
		 $('#admin option:selected').removeAttr('selected').trigger("chosen:updated");
	}	
}






function checkbox_click(){
	if( $('#read_write_all').is(':checked') ){
		$.ajax({
				type : 'post',
				url : site_url + "post/getUsersList",
				data: "",
				success : function(data){
						var response = $.parseJSON(data);
						
						$('#read_write option').remove();
						$('#read_write').html(response.users).trigger("chosen:updated");
				}
			});
	}else{
		 if( $('#copy_parent_rw') .is(':checked') ){
		 	$('#copy_parent_rw').attr('checked',false);
		 }
		 $('#read_write option:selected').removeAttr('selected').trigger("chosen:updated");
	}	
}

function checkbox_click_two(){
	if( $('#read_all').is(':checked') ){
		$.ajax({
				type : 'post',
				url : site_url + "post/getUsersList",
				data: "",
				success : function(data){
						var response = $.parseJSON(data);
						
						$('#read option').remove();
						$('#read').html(response.users).trigger("chosen:updated");
				}
			});
	}else{
		 if( $('#copy_parent_r') .is(':checked') ){
		 	$('#copy_parent_r').attr('checked',false);
		 }
		 $('#read option:selected').removeAttr('selected').trigger("chosen:updated");
	}
}



function copy_parent_readwrite(){
	
	var category_id = $('#category_id').val();
	
	if( $('#copy_parent_rw').is(':checked') ){
		if(category_id != ''){
			$.ajax({
				type : 'post',
				url : site_url + "post/getCategryUsers",
				data: "category_id="+category_id,
				success : function(data){
						var response = $.parseJSON(data);
						
						var array = response.parentusers.split(",");
						
						$.each(array,function(){
							var v = this
							$('#read_write option').each(function(){
							  if ($(this).attr("value") == v){ 
								$(this).attr("selected",true);
							  }
							});			  
						});
						$('#read_write').trigger("chosen:updated");
				}
			});
		}else{
			$('#read_write_error').text('You need to select parent category first');
		}
	}else{
		 if($('#read_write_all').is(':checked')){
			$('#read_write_all').attr("checked",false);
		 }
		 $('#copy_parent_rw option').removeAttr('selected');
		 $('#read_write_error').text('');
		 $('#read_write option:selected').removeAttr('selected').trigger("chosen:updated");
	}
}

function copy_parent_read(){
	var category_id = $('#category_id').val();
	
	if( $('#copy_parent_r').is(':checked') ){
		if(category_id != ''){
			$.ajax({
				type : 'post',
				url : site_url + "post/getCategryReadUsers",
				data: "category_id="+category_id,
				success : function(data){
						var response = $.parseJSON(data);
						
						var array = response.parentusers.split(",");
						
						$.each(array,function(){
							var v = this
							$('#read option').each(function(){
							  if ($(this).attr("value") == v){ 
								$(this).attr("selected",true);
							  }
							});			  
						});
						$('#read').trigger("chosen:updated");
				}
			});
		}else{
			$('#read_error').text('You need to select parent category first');
		}
	}else{
		 if( $('#read_all') .is(':checked') ){
		 	$('#read_all').attr('checked',false);
		 }
		 $('#copy_parent_r option').removeAttr('selected');
		 $('#read_error').text('');
		 $('#read option:selected').removeAttr('selected').trigger("chosen:updated");
	}
}




function toggledropdown()
{
	var value = $('#main-cat').val()
	
	if(value == 0){
		$('#category_id').val('');
		$('#admin').trigger("chosen:updated");
	}else{
		$('#category_id').val(value);
		$.ajax({
				type : 'post',
				url : site_url + "post/getAdminInfo",
				data: "category="+value,
				success : function(data){
						var response = $.parseJSON(data);
						if(response.status == 'admin_exist')
						{
							$('#admin option').remove();
							$('#admin').html(response.users).trigger("chosen:updated");
						}
				}
			});
	}
}