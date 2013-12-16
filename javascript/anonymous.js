// JavaScript Document
/* inFieldLabels Start */
(function($){$.InFieldLabels=function(b,c,d){var f=this;f.$label=$(b);f.label=b;f.$field=$(c);f.field=c;f.$label.data("InFieldLabels",f);f.showing=true;f.init=function(){f.options=$.extend({},$.InFieldLabels.defaultOptions,d);if(f.$field.val()!=""){f.$label.hide();f.showing=false};f.$field.focus(function(){f.fadeOnFocus()}).blur(function(){f.checkForEmpty(true)}).bind('keydown.infieldlabel',function(e){f.hideOnChange(e)}).change(function(e){f.checkForEmpty()}).bind('onPropertyChange',function(){f.checkForEmpty()})};f.fadeOnFocus=function(){if(f.showing){f.setOpacity(f.options.fadeOpacity)}};f.setOpacity=function(a){f.$label.stop().animate({opacity:a},f.options.fadeDuration);f.showing=(a>0.0)};f.checkForEmpty=function(a){if(f.$field.val()==""){f.prepForShow();f.setOpacity(a?1.0:f.options.fadeOpacity)}else{f.setOpacity(0.0)}};f.prepForShow=function(e){if(!f.showing){f.$label.css({opacity:0.0}).show();f.$field.bind('keydown.infieldlabel',function(e){f.hideOnChange(e)})}};f.hideOnChange=function(e){if((e.keyCode==16)||(e.keyCode==9))return;if(f.showing){f.$label.hide();f.showing=false};f.$field.unbind('keydown.infieldlabel')};f.init()};$.InFieldLabels.defaultOptions={fadeOpacity:0.5,fadeDuration:300};$.fn.inFieldLabels=function(c){return this.each(function(){var a=$(this).attr('for');if(!a)return;var b=$("input#"+a+"[type='text'],"+"input#"+a+"[type='password'],"+"textarea#"+a);if(b.length==0)return;(new $.InFieldLabels(this,b[0],c))})}})(jQuery);
/* inFieldLabels End */


function clearText(field){
	if (field.defaultValue == field.value) field.value = '';
	else if (field.value == '') field.value = field.defaultValue;
}	
	
$(function(){
	
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
	$('.field label').addClass('infield');
	$("label.infield").inFieldLabels();
	
	//fade div append
	$('<div id="fade"></div>').prependTo($('body'));
	$(".designer").customInput();
	
	
	
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
/*$('#user-login a').click(function(){
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
    }); */  		
					
	// login btn onclick popup event
	/*$('.arrowclick').click(function(){
		if($('.loginpop').is(":visible"))
		{
			$(this).removeClass('active');
			$('.loginpop').fadeOut();
		}
		else{
			$(this).addClass('active');
			$('.loginpop').fadeIn();
		}
	});*/
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
