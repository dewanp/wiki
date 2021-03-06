// Checkbox
$(function(){
	/*$('.cbox, .cbox-selected').bind("click", function () {
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
		});*/
});
//end
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

$(function(){
	$(".designer").customInput();
});
//end
//select dropdown
$(function(){
	designerSelect(); 
	$('select.designer').css({'opacity':'0'});
});
function designerSelect(){
	$("select.designer").change(function () {
		var ds1 = "";
		var deId = this.id;
		$("#"+ deId +" option:selected").each(function () {
			ds1 = $(this).text();
		});
		$(this).prev().text(ds1);
	}).change();
}
//end