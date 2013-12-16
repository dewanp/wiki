/* This is function is used for showing particular message to user*/
function showMessage(message_id ,page_type){
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

function postMessageReply(){
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
		
	if(reply_subject== "" || reply_subject== null){
		$('#div_reply_subject').html('Subject Cannot be empty ');
		return false;	
	}
	if(description == "" || description == null){
		$('#div_reply_description').html('Description field Cannot be empty ');
		return false;
	}
	if(description.length >1000){
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


function delete_message(message_id ,page_type){
	$('#description').html('');
	$("#li"+message_id).hide();
	$('li').removeClass('active');
	closePopDiv('confirm');
	$.ajax({
		type: "post",
		data: "message_id="+message_id+"&page_type="+page_type,
		url :site_url+ "message/delete_message",
		success : function(data){	
			userNotification("You Message has been deleted successfully.");
		}
	});
}

function archive_message(message_id, page_type){
	$('#description').html('');
	$("#li"+message_id).hide();
	$('li').removeClass('active');
	$.ajax({
		type:'post',
		data: "message_id="+message_id+"&page_type="+page_type,
		url : site_url +"message/makeArchive",
		success : function(data){
			userNotification("You Message has been archive successfully.");
		}		
	});
}

function remove_archive_message(message_id){
	$('#description').html('');
	$("#li"+message_id).hide();
	$('li').removeClass('active');
	$.ajax({
		type:'post',
		url : site_url +"message/removeArchive/"+message_id,
		success : function(data){	
			userNotification("You Message has been moved to inbox successfully.");
		}		
	});
}

function compose_message(){
	var to = $(".tagedit-list li").length;
	var subject = $('#compose_subject').val();
	var description = $('#compose_description').val();
	$('#error_to').html("");
	$('#error_subject').html("");
	$('#error_description').html("");
	
	if(to <= 1){
		$('#error_to').html("At least 1 receiver name  required");
		return false;	
	}
	if(subject=="" || subject == null ){
		$('#error_subject').html(" Subject Field required");
		return false;	
	}
	if(description=="" || description ==null){
		$('#error_description').html("Message Field required");
		return false;
	}
	if(description.length >1000){
		$('#error_description').html("Message length exceed from 1000 character ");
		return false;
	}else{
		closePopDiv('new-message');
		$.ajax({
			type: "post",
			url : site_url+ "message/compose",
			data:$("#compose").serialize(),
			success: function(data){	
				userNotification("You Message has been posted successfully.");			
			}
		});
	}
	return false;
}

function popupClear(){
	$('.compose_success').html('');
	$('ul.holder').find('li.bit-box').remove().end();
	$('select#compose_to').find('option').remove().end();
	$('#error_to').html("");
	$('#error_subject').html("");
	$('#error_description').html("");
	$('#compose_subject').val('');
	$('#compose_description').val('');
}

function show_reply_post(){
	$('.righttop').slideToggle("slow");
	$('.msgpara').slideToggle("slow");
	$('.msgreply').slideToggle("slow");
	$('.icon1').slideToggle("slow");
	$('.icon3').slideToggle("slow");
}

