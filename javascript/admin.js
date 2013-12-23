function validateLoginForm()
{
	var name = document.forms["Login"]["adminname"].value;
	var pwd =  document.forms["Login"]["adminpassword"].value;
    var x=0;
	if( name =="" ||  name == null )
	{
		document.getElementById("msg_username").innerHTML = "Please enter valid username";
		x++;
	}
	if(pwd== "" || pwd == null)
	{	
		document.getElementById("msg_password").innerHTML = "Please enter valid password";
		x++;
	}
	if(x!=0){ x=0; return false;}
	
}

 
  
  function check_all_function(ths){
				
				if($(ths).attr('checked')=="checked"){
					$(".u").attr('checked','checked');
				}else{
					$(".u").removeAttr('checked');
				}
			}
 
  function myShowImage(img_id, width, height,target){

	$.ajax({type: "POST",url: site_url+'adminupload/myShowImage',data: 'file_upload_id='+img_id+'&t_width='+width+'&t_height='+height,
		success: function (data){ 
			$("#"+target).html(data);
		}
	});
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
		url: site_url + "home/editInputs",
		data: data,
		success: function (data){ 
			$("#"+span_id).html(val.replace(/\n/g,'<br />')); //replace is used for nl2br in JS 			
		}
	});
}

function validateAdminPercent()
{
	percent = $('#admin_percent').val();
	
	if(percent <0 || percent >100)
	{
		$('#admin_percent_err').html('Please enter percent between 0 to 100');
		return false;
	}
	if(percent %5 !=0)
	{
		$('#admin_percent_err').html('Please enter percent multiple of 5');
		return false;
	}
	if(percent == "")
	{
		$('#admin_percent_err').html('Please enter valid percent');
		return false;
	}
	
	if(percent >=0 && percent <=100 && percent %5 ==0 && percent != "")
	{
		return true;
	}
	
}

function validateGoogleId()
{
	code = $('#google_code').val();
	if(code == "" )
	{
		$('#google_code_err').html('Please enter valid code');
		return false;
	}
	else
	{
		return true ;
	}
}

/* Function for remove category and all sub categories*/
function deleteCategory(category_id)
{
	var confirmation = confirm('Are you sure you want to delete category?');
	if(confirmation){
	
	$.ajax({
			type: "POST",
			url: site_url + "admin/deleteCategory",
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

//Function for checked overwrite child or not
function overwrite_child()
{
	if( $('#overwirte_child').is(':checked')){
		var confirmation = confirm('Are you sure you want to overwrite child categories?');		
		if(confirmation){
			$('#overwirte_child').attr('checked','checked');
		}else{
			$('#overwirte_child').removeAttr('checked');
		}
	}
	if( !$('#overwirte_child').is(':checked')){
		$('#overwirte_child').removeAttr('checked');
	}
}

//Function for checked atleast one admin is selected or not
function valid_admin_selection()
{
	if( $("#admin_chosen ul.chosen-choices li").length == 1 && $('#prev_admin').text().trim().length <= 0 ){
		alert('Please select at least one admin for category.');
		return false;
	}
	
	if( $("#admin_chosen ul.chosen-choices li").length > 1 || $('#prev_admin').text().trim().length > 0 ){
		return true;
	}
	return false;
}

