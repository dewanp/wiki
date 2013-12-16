var deleteRow
var loadingimg = '<div class="loading"><img src="images/ink-loading.gif" alt="" /></div>';
function prepareConfirmPopup(ths, msg){
	deleteRow = ths;
	$("#confirm-user-message").html(msg);
	var yesButtonObj = $(ths).parent().find(".adl");
	$("#confirm-yes-button").html($(yesButtonObj).html());
	openPopDiv('confirm');
}
function saveZipCode(){ 
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

function deletePost(post_id){
	$.ajax({
		type: "POST",
		async: false,
		url: site_url + "post/delete",
		data: "post_id="+post_id,
		success: function (data){
			window.location.reload();
		}
	});
}

function postOp(post_id,op){
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

/*function editInputs(table, field, input_id, span_id, row_id)
{ 
	if(row_id === undefined)
	{ row_id = "";
	}
	var val = $("#"+input_id).val();
	var data = 'table='+table+'&'+field+'='+val+'&row_id='+row_id;

	$.ajax({
		type: "POST",
		async: false,
		url: site_url + "home/editInputs",
		data: data,
		success: function (data){ 
			$("#"+span_id).html(val.replace(/\n/g,'<br />')); //replace is used for nl2br in JS 			
		}
	});
}
*/
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


function checkSubCategory(obj){
	var tid = $("#"+obj.id).val();
	
	$.ajax({
		type: "POST",
		url: site_url + "post/subCategory",
		data: 'tid='+tid,
		success: function (data){ ;
			
		}
	});
}

function addMoreTag() {
		var element = "<div><input type=\"text\" name=\"postTag[]\" /> <a href=\"javascript:void(0)\" onClick=\"deleteThisTag(this)\">Delete</a><br /></div>"
		$("#postTagDiv").append(element);			 
}

function deleteThisTag(ele){
	$(ele).parent().remove();
}

function updateSorting(className){
	$( "."+className ).each(function(i){$(this).find("input.order-weight").val(i);});
}

function ajaxCall(callMethod,mydata,async){
	
	if(async === undefined)
	{ async = true;
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
function saveVideoContent(ths,post_id, capsule_id){
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
		firstErrorObj.focus();
		return false;
	}
}// end of saveVideoContent function


/* video save script*/
function saveParagraphContent(post_id, capsule_id){
	nicEditors.findEditor('paragraph-'+capsule_id).saveContent();
	$.ajax({
		type: "POST",
		url: site_url + "capsule/saveParagraph",
		data: $("#capsuleForm"+capsule_id).serialize(),
		success: function (data){ 
			capsuleContent(post_id, capsule_id, 'edit');
		}
	});	
}// end of saveParagraphContent function


/* view use full function for calling view,edit form for all the capsules */
function capsuleContent(post_id, capsule_id, content_type){
	$.ajax({
		type: "POST",
		url: site_url + "home/capsuleContent",
		data: "post_id="+post_id+"&capsule_id="+capsule_id+"&content_type="+content_type,
		success: function (data){ 
			var capsule_content = $.parseJSON(data);
			$(".capsule-content-"+capsule_id+" .content").html(capsule_content.html);
		}
	});	
}// end of capsuleContent function

/* view use full function for calling view,edit form for all the capsules */
function commentContent(post_id, capsule_id, content_type){
	$.ajax({
		type: "POST",
		url: site_url + "capsule/commentContent",
		data: "post_id="+post_id+"&capsule_id="+capsule_id+"&content_type="+content_type,
		success: function (data){ 
			var comment_content = $.parseJSON(data);
			$(".comment-list-wrapper").html(comment_content.html);
		}
	});	
}// end of capsuleContent function

// uploading time delete file function which will delete direct
function deleteImage(file_upload_id){
		ajaxCall('upload/delete','file_upload_id='+file_upload_id);
		$("#uploaded-img-"+file_upload_id).remove();
		
}// end of function

// uploading time delete file function which will delete direct
function deleteCapsuleImage(post_id, capsule_id, file_upload_id, image_id){
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
}// end of function


function deleteCapsuleVideo(post_id, capsule_id, file_upload_id, video_id){
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
function saveImageContent(ths,post_id, capsule_id){
	
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
function saveListContent(ths,post_id, capsule_id){
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
function saveCommentContent(ths,post_id, capsule_id){
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
function showHideComment(ths,capsule_id){
	
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
function savePollsContent(post_id, capsule_id){
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
function saveOpinionContent(post_id, capsule_id){
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
function saveOpinionContent(post_id, capsule_id){
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
function saveAmazonContent(ths,post_id, capsule_id){
	
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

function addPollsOption(capsule_id){
	$("#no-options-"+capsule_id).hide();
	addMorePollsOption(capsule_id);
	$("#question-wrapper-"+capsule_id).show();	
	$("#is_options-"+capsule_id).val('1');
}

function addOpinionOption(capsule_id,type){
	$("#no-options-"+capsule_id+"-type-"+type).hide();
	addMoreOpinionOption(capsule_id,type);
	$("#question-wrapper-"+capsule_id+"-type-"+type).show();	
}

function deletePollsOption(ths,capsule_id){
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

function deleteAmazonUrl(ths,capsule_id){
	$(deleteRow).parent().parent().remove();
	closePopDiv('confirm');
}

function deleteOpinionOption(ths,capsule_id,type){
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

function deleteListItem(ths,capsule_id){
	var list_id = $(ths).attr('rel');	
	if(list_id>0){
		deleteListItemFromDb(list_id);
	}
	$(deleteRow).parent().remove();
	closePopDiv('confirm');
}


function deleteOptionFromDb(option_id){
	$.ajax({
		type: "POST",
		url: site_url + "capsule/deleteOption",
		data: "option_id="+option_id,
		success: function (data){ 
		}
	});
}
function deleteListItemFromDb(list_id){
	$.ajax({
		type: "POST",
		url: site_url + "capsule/deleteListItem",
		data: "list_id="+list_id,
		success: function (data){ 
		}
	});
}

function deleteParameter(ths, parameter_id)
{
	if(parameter_id>0){
		$.ajax({
			type: "POST",
			url: site_url + "home/deleteParameter",
			data: "parameter_id="+parameter_id,
			success: function (data){
				$(deleteRow).parent().remove();
				closePopDiv('confirm');
			}
		});
	}
}




function animateResults(data){
	$(data).find('.progress').hide().fadeIn('slow', function(){
		var bar_width=$(this).css('width');
		$(this).css('width', '0').animate({ width: bar_width }, 1000);
	});	
}

function pollsContent(capsule_id,polls_id){
	
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

function submitPolls(ths,capsule_id,polls_id){
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

function addMorePollsOption(capsule_id){
	var newlistelement = "<div class=\"bulletbox\"><span class=\"bullets\"></span><input type=hidden name=\"option_id[]\" value=\"0\" /><input type=\"text\" value=\"\" class=\"inputmain d-req\" name=\"option_title[]\" onfocus=\"$(this).removeClass('error-border');\"><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deletePollsOption(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div>";	
	$("#options-"+capsule_id).append(newlistelement);
}

function addMoreOpinionOption(capsule_id,type){
	var newlistelement = "<div class=\"bulletbox\"><span class=\"bullets\"></span><input type=hidden name=\"option_id[]\" value=\"0\" /><input type=hidden name=\"option_type[]\" value=\""+type+"\" /><input type=\"text\" value=\"\" class=\"inputmain d-req\" name=\"option_title[]\" onfocus=\"$(this).removeClass('error-border');\"><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteOpinionOption(this,"+capsule_id+","+type+");\" rel=\"0\">Yes</a></div></div>";	
	$("#options-"+capsule_id+'-type-'+type).append(newlistelement);
}

var i = 2; 
function addMoreList(capsule_id){
	var newlistelement = "<div class=\"bulletbox\"style=\"margin:10px 0; width:330px;\"><span class=\"bullets\"></span><input type=hidden name=\"list_id[]\" value=\"0\" /><input type=\"text\" value=\"\" class=\"inputmain d-req etraddmore\" name=\"list_description[]\" onfocus=\"$(this).removeClass('error-border');\"><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteListItem(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div>";
	
	$("#list-capsule").append(newlistelement).find("input[type=text]").focus();
	//$("#list-capsule-"+capsule_id+" div.bulletbox:last-child").find("input[type=text]").focus();
	i=i+1;

}


function showImage(img_id, width, height, target){
	$.ajax({type: "POST",url: site_url+'upload/showImage',data: 'file_upload_id='+img_id+'&t_width='+width+'&t_height='+height,
		success: function (data){ 
			$("#"+target).html(data);
		}
	});
}
function val_post_add_step_1(){
		var valid = true;
		/*var fields = $("#postAdd").serializeArray();
		$.each(fields, function(i, field){
			if(field.name=='file_upload_id' && field.value<1){
				
			}
			if(field.name=='category' && field.value==''){
				
			}
			if(field.name=='sub_category' && field.value==''){
				
			}
			if(field.name=='title' && field.value==''){
				
			}
			if(field.name=='description' && field.value==''){
				
			}
			if(field.name=='tag[]' && field.value==''){
				
			}
			
			alert(field.name+":"+field.value);
			//$("#results").append(field.value + " ");
		});	*/
		return valid;
	}
function confirmPopup(msg,obj){
	var msg = '<div class="note"><h5>'+msg+'</h5></div>';
	var yesHtml = '<a href="javascript:void(0);" class="btnorange" onclick="$('+obj+').trigger(\"click\")">Yes</a>';
	var noHtml = '<a href="javascript:void(0);" class="cancel" onclick="closePopDiv(\'confirm\');">No</a>';
	var confirmBoxContent = msg+'<div class="btnbox">'+yesHtml+noHtml+'</div>';
	$("#confirm-message-wrapper").html(confirmBoxContent);
	openPopDiv('confirm');
}


function deletePostImage(file_upload_id){
		ajaxCall('upload/delete','file_upload_id='+file_upload_id)
		$("#file_upload_id").val('0');
		$("#files").html('');
		$("#upload").show();
		closePopDiv('confirm');
}

function capsuleDelete(capsule_type,capsule_id,post_id){
	if(confirm("Are you sure?")){
	$.ajax({type: "POST",url: site_url + 'capsule/delete',data: 'capsule_type='+capsule_type+'&capsule_id='+capsule_id,
		success: function (data){ 
			updatePostCapsuleList(post_id);
			updatePostCapsuleWrapper(post_id,'edit');			
		}
	});
	}else{
		return false;
	}
}

function updatePostCapsuleWrapper(post_id,view_type, capsule_type){
	
	if(capsule_type === undefined){
		capsule_type = '';
	}

	$.ajax({type: "POST",url: site_url + 'home/updateCapsuleWrapper',data: 'post_id='+post_id+'&view_type='+view_type+'&capsule_type='+capsule_type,
		success: function (data){ 
			$("#capsule-wrapper").html(data);	
		}
	});
}
function updatePostCapsuleList(post_id){
	$.ajax({type: "POST",url: site_url + 'home/updateCapsuleList',data: 'post_id='+post_id,
		success: function (data){ 
			$("#sidebar-capsule-container").html(data);	
		}
	});
}
function postBasicInfo(post_id,view_type){
	$.ajax({type: "POST",url: site_url + 'home/postBasicInfo',data: 'post_id='+post_id+'&view_type='+view_type,
		success: function (data){ 
			$("#post-basic-info").html(data);	
		}
	});
}

function savePostBasicInfo(post_id){
	$.ajax({type: "POST",url: site_url + 'home/savePostBasicInfo',data: $("#postEditBasicInfo").serialize(),
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
	offset = $("#show-post").children().size();
	data = 'offset='+offset+'&type='+type;
	posts = ajaxCall('post/loadMoreShowPosts',data,false);
	cnt = posts.split('searchdtl').length - 1;
	if($.trim(posts)=="" || cnt < 8 ) $("#show-post-more").hide();
	$("#show-post").append(posts);
	$("#show-post-loading").hide();
}


function getMostPostedUsers(type)
{ 
	//$("#show-post-loading").show();
	offset = $("#most-posted-users").children().size();
	data = 'offset='+offset+'&type='+type; 
	posts = ajaxCall('post/getMostPostedUsers',data,false); 
	cnt = posts.split('thumbmain').length - 1; 
	if($.trim(posts)=="" || cnt < 9 ) $("#view-more-posted-users").hide();
	$("#most-posted-users").append(posts);
	//$("#show-post-loading").hide();
}

function loadMoreLocalPosts(zip_code)
{  
	$("#show-post-loading").show();
	offset = $("#show-post").children().size();
	data = 'offset='+offset+'&zip_code='+zip_code;
	posts = ajaxCall('post/loadMoreLocalPosts',data,false);
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
	//window.location = site_url+'post/localPosts/'+dis.id;

}

function loadRating(capsule_id)
{ 
	rating = ajaxCall('post/loadRating','capsule_id='+capsule_id, false);
	$("#rating"+capsule_id).html(rating);	
}

function enterzip()
{
	alert('in');
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

function userPage(page_id){
	$.ajax({type: "POST",url: site_url + 'user/userPage',data: "page_id="+page_id,
		success: function (data){ 
			$("#user-dashboard").html(data);
		}
	});
}

function followUser(following,follower){
	$.ajax({type: "POST",url: site_url + 'user/followuser',data: "following="+following+"&follower="+follower,
		success: function (data){ 
			userPage('search');
		}
	});
}

function followUserbyAnyLocation(ths,following,follower){
	$.ajax({type: "POST",url: site_url + 'user/followuser',data: "following="+following+"&follower="+follower,
		success: function (data){ 
			$(ths).parent().remove();
			userNotification("You successfully following this user.");
		}
	});
}


function loadMoreSearch(dis){ 
	
	if(dis === undefined)
	{ 
		keyword = $("#header-keyword").val();
		keyword = 'keyword='+keyword;
		type='all';
	} 
	else if (dis == 'more')
	{
	}
	else
	{
		keyword = $(dis).serialize(); //alert(keyword);
		type = document.getElementsByName("searchtype");
		type = $(type+':checked').val();
		$("#show-post").html('');
		$("#show-post-more").show();
	}

	offset = $("#show-post").children().size();
	$("#show-post-loading").show();
	
	data = 'offset='+offset+'&type='+type+'&'+keyword;  ///alert(data);
	posts = ajaxCall('search/loadMoreSearch',data,false); 
	if (posts == 0)
	{
		posts = offset ? "" : "No post found.";
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
		$('#error_msg').html ('Email field  cannot be empty');
		return false;
	}
	if(!isValidEmailAddress(emailid))
	{
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
						
						$('#error_msg').html(data);
			}
		
		});
   return false ;
	}
	

}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function saveDraft(id){	
	//$("#"+id).find(".savecaps").trigger('click');
	var nosave = false;
	$("#"+id).find(".savecaps").each(function(){
		$(this).trigger('click');
		nosave=true;
		//alert($(this).attr('onclick'));										  
	});
	if(nosave){
		userNotification("Post content is saved in draft.");
	}else{
		window.location =site_url+'post/mypost';
	}	
}

	
function saveEarningContent(){
		$.ajax({
			type:'post',
			data: $("#amazon-content-form").serialize(),
			url : site_url +"user/saveEarningContent",
			success : function(data)
			{
				window.location.reload();
			}		
		});
	}
	
function deleteEarningContent(user_earnings_account_id){
		$.ajax({
			type:'post',
			data: 'user_earnings_account_id='+user_earnings_account_id,
			url : site_url +"user/deleteEarningContent",
			success : function(data)
			{
				window.location.reload();
			}		
		});
	}
	
function showNumberOfItem(num){
	alert(num);
}
/*function addMoreAmazonUrl(capsule_id){
	var newlistelement = "<div class=\"field-wrapper\"><div class=\"fieldmain\"><label class=\"name\">Enter <span class=\"txtorange\">Amazon URL</span> or <span class=\"txtorange\">ASIN</span> or <span class=\"txtorange\">ISBN</span></label><input type=\"text\" class=\"inputmain\" name=\"amazon_url[]\"/><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteAmazonUrl(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div><div class=\"fieldmain\"><label class=\"name\">Enter Description</label><textarea class=\"inputmain\" name=\"amazon_description[]\"></textarea></div></div>";	
	$("#amazon-url-wrapper-"+capsule_id).append(newlistelement);
}*/

function addMoreAmazonUrl(capsule_id){
	var newlistelement = "<div class=\"field-wrapper\"><div class=\"fieldmain\"><label class=\"name\">Enter <span class=\"txtorange\">Amazon URL</span> or <span class=\"txtorange\">ASIN</span> or <span class=\"txtorange\">ISBN</span></label><input type=\"text\" class=\"inputmain d-req\" name=\"amazon_url[]\" onfocus=\"$(this).removeClass('error-border');\"/><a class=\"delete\" href=\"javascript:void(0);\" onclick=\"prepareConfirmPopup(this,'Are you sure?')\"></a><div class=\"adl\"><a class=\"btnorange\" onclick=\"deleteAmazonUrl(this,"+capsule_id+");\" rel=\"0\">Yes</a></div></div></div>";	
	$("#amazon-url-wrapper-"+capsule_id).append(newlistelement);
}


function amazonSecStep(capsule_id){
	var rt =$('#capsuleForm'+capsule_id+' input:radio[name=amazon_search_type]:checked').val();
	if(rt){
		$('#ctrlbar-'+capsule_id).find(".step").hide();
		$('#ctrlbar-'+capsule_id).find("#by-"+rt+"-"+capsule_id).show();
	}	
}

function amazonfirstStep(capsule_id){
	$('#resultbar-'+capsule_id).html('');
	$('#ctrlbar-'+capsule_id).find(".step").hide();
	$('#ctrlbar-'+capsule_id).find("#selection-div-"+capsule_id).show();
}

function amazonShowResult(ths,capsule_id){
	
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


function userNotification(msg){
	$("#site-message").html(msg);
	$('body,html').animate({
        scrollTop: 0
    }, 800);
	$("#zipcode-main-block").slideDown();
	var userNotification = setTimeout(function(){
		$("#zipcode-main-block").slideUp();
	},5000);
}

function searchUser()
{
	search_user = $("#filter").val(); 
	search_user=search_user.replace("'","");
	search_user=search_user.replace('"','');
	window.location = site_url+'home/manageusers/'+search_user;
}

function showvideo(id,file_path){
		jwplayer(id).setup({flashplayer: "jwplayer/player.swf",file: file_path,width:500,height:400});
	}


function blockPosts(post_id)
{ 
	$.ajax({
		type:'get',
		url : site_url +"home/blockposts/"+post_id,
		success : function(data){
			window.location.reload()
		}		
	});
}

function resumeBlockedPosts(post_id)
{ 
	$.ajax({
		type:'get',
		url : site_url +"home/resumeblockedposts/"+post_id,
		success : function(data){
			window.location.reload()
		}		
	});
}

function searchSuspendedUser()
{
	search_user = $("#filter").val(); 
	search_user=search_user.replace("'","");
	search_user=search_user.replace('"','');
	window.location = site_url+'home/suspendeduserlist/'+search_user;
}

function sendVerificationEmail(user_id)
{
	$("#loading-status").show();
	$.ajax({
		type:'get',
		url : site_url +"home/sendVerificationEmail/"+user_id,
		success : function(data){
				$("#status_action_div").html(data);
		}		
	});
}

function resetPassword(user_id)
{
	$("#loading-status").show();
	$.ajax({
		type:'get',
		url : site_url +"home/resetPassword/"+user_id,
		success : function(data){
			$("#status_action_div").html(data);
		}		
	});
}

function suspendUsers(user_id)
{
	$("#loading-status").show();
	$.ajax({
		type:'get',
		url : site_url +"home/suspendUsers/"+user_id+'/1',
		success : function(data){
			$("#status_action_div").html(data);
		}		
	});
}
function resumeSuspendedUsers(user_id)
{
	$("#loading-status").show();
	$.ajax({
		type:'get',
		url : site_url +"home/resumeSuspendedUsers/"+user_id+'/1',
		success : function(data){
			$("#status_action_div").html(data);
		}		
	});
}

function manuallyVerifyAccount(user_id)
{
	$("#loading-status").show();
	$.ajax({
		type:'get',
		url : site_url +"home/resumeSuspendedUsers/"+user_id+'/1/1',
		success : function(data){
			$("#status_action_div").html(data);
		}		
	});
}

/* function for delete contact data*/
function contactDetailDelete(contact_data_id)
{ 
	$.ajax({
		type:'get',
		url : site_url +"home/contactDetailDelete/"+contact_data_id,
		success : function(data){
			window.location.reload()
		}		
	});
}


/* function for delete contact data*/
function subscribedUserDelete(subscribe_id)
{ 
	$.ajax({
		type:'get',
		url : site_url +"home/subscribedUserDelete/"+subscribe_id,
		success : function(data){
			window.location.reload()
		}		
	});
}

/* function for delete contest data
*	created by Ashvin soni : 10 Apr, 2013
*/
function contestDelete(contest_id)
{ 
	$.ajax({
			type:'get',
			url : site_url +"home/contestdelete/"+contest_id,
			success : function(data){
				window.location = site_url+'home/showcontestlisting';
			}		
		});	
}


/* function for restore contest data
*	created by Ashvin soni : 17 May, 2013
*/
function contestRestore(contest_id)
{ 
	$.ajax({
			type:'get',
			url : site_url +"home/contestrestore/"+contest_id,
			success : function(data){
				window.location = site_url+'home/showcontestlisting';
			}		
	});	
}


/* function for delete contest data permanently
*	created by Ashvin soni : 17 May, 2013
*/
function deletePermanent(contest_id)
{ 
	
	$.ajax({
			type:'get',
			url : site_url +"home/deletepermanent/"+contest_id,
			success : function(data){
				window.location = site_url+'home/showcontestlisting';
			}		
	});	
}




/* function for close contest data
*	created by Ashvin soni : 24 Apr, 2013
*/
function contestClose(contest_id,status,msg)
{ 
	$.ajax({
			type:'get',
			url : site_url +"home/contestClose/"+contest_id+"/"+status,
			success : function(data){
				window.location = site_url+'home/showcontestlisting';
			}		
		});	
}


/* function for reset contest form data
*	created by Ashvin soni : 12 Apr, 2013
*/
function clearContest()
{ 
	$("ul.tagedit-list").empty();
	$(".nicEdit-main").empty();
	document.getElementById("addcontest").reset();
}


/* function for get posts using user id 
*	created by Ashvin soni : 19 Apr, 2013
*/
function getUsersPost(user_id, select_id)
{ 	
	var selectstring = select_id; 
	var lastChar = selectstring.substr(-1);
	if(user_id == 0)
	{
		return false;
	}else
	{
		$.ajax({
				type:'post',
				url : site_url +"home/usersPost/",
				data: 'user_id='+user_id,
				success : function(data){
						var output = $.parseJSON(data);
						$('#user-postlist-'+lastChar).html(output);
				}		
			});	
	}
}

/* Function for add li for click on add-icon */
var i = 2;
function addli_userpost()
{
	var first_sel = $("#user-selectlist-1").html();
	
	var sure = 'Are you sure?';
	
	var newlielement = '<li id=\"li_user_'+i+'\"><select class=\"\" size=\"1\" id=\"user-selectlist-'+i+'\" name=\"userSelectlist[]\"  onchange=\"getUsersPost(this.value,this.id);\">'+first_sel+'</select></li><li id=\"li_post_'+i+'\"><select class="" size=\"1\" id=\"user-postlist-'+i+'\"  name=\"userPostlist[]\" ><option selected=\"selected\">Select the title of the post form the user which won</option></select><a href=\"javascript:void(0);\" class=\"minus-icon\" onclick="removeLi('+i+')"></a><div class="adl"><a class="btnorange" onclick=\"removeli_userpost(2, 2);\">Yes</a></div><a class=\"add-icon\" onclick=\"addli_userpost(); designerSelect();\" href=\"javascript:void(0);\" hidefocus=\"true\" style=\"outline: medium none;\"></a></li>';

	$("#para-list").append(newlielement);
	$("#user-selectlist-"+i).val(0);
	i=i+1;
}

/*Fucntion  for remove LI on dynamic time */
function removeLi(select_list)
{
	
	if( select_list != "")
	{
		$("#li_user_"+select_list).remove();
		$("#li_post_"+select_list).remove();
	}
	select_list = null;
	
}

/* Function for remove li from winners list */
function removeli_userpost(user_id, post_id)
{
	$.ajax({
			type: "POST",
			url: site_url + "home/deletewinneroption",
			data: "user_id="+user_id+"&post_id="+post_id,
			success: function (data){ 
				//$('#user-selectlist-1').removeAttr('selected').find('option:first').attr('selected', 'selected');
				window.location.reload();
			}
		});
}

/* Function for remove category and all sub categories*/
function deleteCategory(category_id)
{
	var confirmation = confirm('Are you sure you want to delete category?');
	if(confirmation){
	
	$.ajax({
			type: "POST",
			url: site_url + "home/deleteCategory",
			data: "category_id="+category_id,
			success: function (data){ 
				var response = $.parseJSON(data)
				if(response.status == 'success'){
					$('#list_'+category_id).remove();
				}
			}
		});
	}
}