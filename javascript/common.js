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
 
 $(document).ready(function(){
	changeText();

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
	//Enter Zip Code
//$('.click-enter-zip').click(function(){
//	 $('#zipcode-main-block').slideToggle();
//	});	
/*$("#zipcode-main-block").mouseup(function() {
        return false
    });
    $(document).mouseup(function() {
        $("#zipcode-main-block").slideUp();
	
    }); */					
	// login btn onclick popup event
	$('.arrowclick').click(function(){
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
	$(".loginpop, .arrowclick, #catpopup").mouseup(function() {
		return false
	});
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
});	



function unfollowUser(user_follow_id){
	$.ajax({type: "POST",url: site_url + 'user/unfollowUser',data: "user_follow_id="+user_follow_id,
		success: function (data){ 
			userPage('peopleyoufollow');
		}
	});
}

// Global functions
/*$(function() {
	accordin(); // accrodion
});*/
// accrodion script start
/*function accordin() {
$('.opendiv').hide(); 
//$('.expandablediv .grnhead:first').addClass('active') .next() .show(); 
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
};*/

 /* accordion for faq page Start */
/*$(document).ready(function()
{
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
});*/
 /* accordion for faq page End */

