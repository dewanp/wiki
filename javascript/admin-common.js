// JavaScript Document

function clearText(field){
	if (field.defaultValue == field.value) field.value = '';
	else if (field.value == '') field.value = field.defaultValue;
	}
		
	
$(function(){
	//fade div append
	$('<div id="fade"></div>').prependTo($('body'));
	$(".designer").customInput();
});

function changeText(){
		  $('.showhidemenu').click(function(){
		  var findText = $(this).text();
		  var altText = $(this).attr('rel');
		  $(this).text(altText);
		  $(this).attr('rel',findText);
		  });
		} 

function toggletr()
{
	var value = $('#parent_category').val()
	if(value == 0){
		$('#admin_tr').show();
	}else{
		$('#admin_tr').hide();
	}
}

function toggledropdown()
{
	var value = $('#parent_category').val();
	 
	 
	$.ajax({
			type : 'post',
			url : site_url + "admin/getAdminInfo",
			data: "parent_category_id="+value+'&edit_category_id='+$('#edit_category_id').val(),
			success : function(data){
					var response = $.parseJSON(data);
					if(response.status == 'admin_exist')
					{
						$('#admin option').remove();
						$('#admin').html(response.users);
                        var admval; 
                        
                        
						$('#prev_admin').html(response.prevadmin); 
						
						$('#read_write option').remove();
						$('#read_write').html(response.rwusers);
						
						$('#read option').remove();
						$('#read').html(response.rusers);
                        
                        
                          $("select#admin option:selected").each(function(){              
                             admval = $(this).val();    
                              $("select#read_write option, select#read option").each(function(){
                                    if ($(this).val() == admval)
                                       $(this).attr("disabled","disabled");
                                }); 
                            }); 
                            $("select#read_write option:selected").each(function(){              
                             admval = $(this).val();    
                              $("select#admin option, select#read option").each(function(){
                                    if ($(this).val() == admval)
                                       $(this).attr("disabled","disabled");
                                }); 
                            }); 
                            $("select#read option:selected").each(function(){              
                             admval = $(this).val();    
                              $("select#read_write option, select#admin option").each(function(){
                                    if ($(this).val() == admval)
                                       $(this).attr("disabled","disabled");
                                }); 
                            });                          
                        
                        $('.inputmain').trigger('chosen:updated');
					}
					 
			}
		});
	
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

function checkbox_admin_click()
{
	if( $('#admin_all').is(':checked') ){
		$.ajax({
				type : 'post',
				url : site_url + "admin/getUsersList",
				data: "parent_category_id="+$('#parent_category').val(),
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
				url : site_url + "admin/getUsersList",
				data: "parent_category_id="+$('#parent_category').val(),
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
				url : site_url + "admin/getUsersList",
				data: "parent_category_id="+$('#parent_category').val(),
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
	
	var category_id = $('#parent_category').val();
	if( $('#copy_parent_rw').is(':checked') ){
		if(category_id != '' && category_id != 0 ){
			$.ajax({
				type : 'post',
				url : site_url + "admin/getCategryUsers",
				data: "category_id="+category_id,
				success : function(data){
						var response = $.parseJSON(data);
						
						if(response.status == 'success')
						{
							$('#read_write option').remove();
							$('#read_write').html(response.users).trigger("chosen:updated");
						}
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
	var category_id = $('#parent_category').val();
	
	if( $('#copy_parent_r').is(':checked') ){
		if(category_id != ''  && category_id != 0){
			$.ajax({
				type : 'post',
				url : site_url + "admin/getCategryReadUsers",
				data: "category_id="+category_id,
				success : function(data){
						var response = $.parseJSON(data);
						
						if(response.status == 'success')
						{
							$('#read option').remove();
							$('#read').html(response.users).trigger("chosen:updated");
						}
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


$(document).ready(function(){
	changeText();	
	
$('.photo-browse, :radio.designer').css({'opacity':'0'});
	
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
$('#user-login a').click(function(){
        if($('#loginbox').is(":visible"))
        {
            $(this).removeClass('active');
            $('#loginbox').slideUp();
        }
        else{
            $(this).addClass('active');
            $('#loginbox').slideDown();
        }
    });    
            
    $("#loginbox").mouseup(function() {
        return false
    });
    $(document).mouseup(function() {
        $("#loginbox").removeClass("active");
        $("#loginbox").slideUp();
    }); 		
	
	// login btn onclick popup event
	$('.loginbtn').click(function(){
		if($('.loginpop').is(":visible"))
		{
			$(this).removeClass('active');
			$('.loginpop').fadeOut();
		}
		else{
			$(this).addClass('active');
			$('.loginpop').fadeIn();
		}
	});
	//end
	//login div hide on body click
	$(".loginpop, .loginbtn, #catpopup").mouseup(function() {
		return false
	});
	$(document).mouseup(function() {
		$(".loginbtn").removeClass("active");
		$(".loginpop").hide();
		$("#catpopup").slideUp();
	});	
	//end
	 
	$("#admin").chosen({disable_search_threshold: 10});
	$("#read_write").chosen({disable_search_threshold: 10});
	$("#read").chosen({disable_search_threshold: 10});
    
     $('#admin').on('change', function(evt, params) { 
        admin_change(evt, params);            
    });
     $('#read_write').on('change', function(evt, params) { 
        rw_change(evt, params);            
    });
     $('#read').on('change', function(evt, params) { 
        r_change(evt, params);            
    });
  
  function admin_change(evt, params){
      
       $("select#read_write option, select#read option").each(function(){              
            if ($(this).val() == params.selected)
              $(this).attr("disabled","disabled");
           if ($(this).val() == params.deselected)
              $(this).removeAttr("disabled");          
            }); 
          
          $('.inputmain').trigger('chosen:updated');
  }
  function rw_change(evt, params){
       $("select#admin option, select#read option").each(function(){              
            if ($(this).val() == params.selected)
              $(this).attr("disabled","disabled");
           if ($(this).val() == params.deselected)
              $(this).removeAttr("disabled");          
            }); 
          
          $('.inputmain').trigger('chosen:updated');
  }
  function r_change(evt, params){
       $("select#read_write option, select#admin option").each(function(){              
            if ($(this).val() == params.selected)
              $(this).attr("disabled","disabled");
           if ($(this).val() == params.deselected)
              $(this).removeAttr("disabled");          
            }); 
          
          $('.inputmain').trigger('chosen:updated');
  }
	
});	


 
