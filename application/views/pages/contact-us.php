<script type="application/javascript">
function textCounter(field,countfield,maxlimit){
	if(field.value.length>maxlimit)
		field.value=field.value.substring(0,maxlimit);
	else
		document.getElementById(countfield).innerHTML=maxlimit-field.value.length;
}

function validateContactUs(ths){
	
	var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
	var phonefilter = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
	var countryFilter = /^[A-Za-z]+$/;
	var valid=true;
	var name = $("#name");
	var email = $("#email");
	var country = $("#country");
	var phone = $("#phone");
	var comment = $("#comment");
	
	$("#infoName").fadeOut();
	$("#infoEmail").fadeOut();
	$("#infoCountry").fadeOut();
	$("#infoPhone").fadeOut();
	$("#infoComment").fadeOut();
	
	
	
	if(name.val().length < 1){
		valid = false;
		$("#infoName").html("Please enter your name.");
		$("#infoName").fadeIn();
	}
	
	if(email.val().length < 1){
		valid = false;
		$("#infoEmail").html("Please enter your email.");
		$("#infoEmail").fadeIn();
	}else if(!filter.test(email.val())){
		valid = false;
		$("#infoEmail").html("Please enter valid email.");
		$("#infoEmail").fadeIn();
	}
	
	if(country.val().length < 1){
		valid = false;
		$("#infoCountry").html("Please enter your country.");
		$("#infoCountry").fadeIn();
	}
	if(country.val().length > 0 ){
		if(!countryFilter.test(country.val())){
			valid = false;
			$("#infoCountry").html("Please enter valid Country name. <br> ex: India");
			$("#infoCountry").fadeIn();
		}
	}
	
	if(phone.val().length > 0){
		if(!phonefilter.test(phone.val())){
			valid = false;
			$("#infoPhone").html("Please enter valid phone number. <br> ex:1234567890, 123-456-7890, 123.456.7890, 123 456 7890, (123) 456 7890");
			$("#infoPhone").fadeIn();
		}		
	}
	
	if(comment.val().trim().length < 1){
		valid = false;
		$("#infoComment").html("Please enter your comment.");
		$("#infoComment").fadeIn();
	}
	
	

	if(!$(ths).hasClass('processing') && valid){
		$(ths).addClass('processing');
		contact_us_submit();
		
		setTimeout(function(){
			$(th).removeClass('processing');
		},500);
	}
	return false;
}
</script>
<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar; ?></div> 
	<div class="rightmain">
		<div class="breadcrumb">
			<span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('','Home');?></li>
				<li> Contact Us</li>
			</ul>
		</div>
		
		<div class="rightinner">
        	<div class="contentpanel">
        		<div class="titlesec"><h1 class="orangetitle-f20">Contact Us</h1>
        		</div>
        	 	<div class="contact-us">
                <form name="frm-contact-us" id="frm-contact-us" action="" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcont">
    <tr>
        <td colspan="2"><div class="field"><span class="mand">*</span>
                        <label for="name" class="infield">NAME</label>
                        <input name="name" type="text" class="inputmain" id="name" value="" onkeydown="$('#infoName').fadeOut();"/>
                    </div>
                    <div class="error-message" id="infoName"></div>
                    </td>
    </tr>
    <tr>
        <td colspan="2"><div class="field"><span class="mand">*</span>
                        <label for="email" class="infield">EMAIL</label>
                        <input name="email" type="text" class="inputmain" id="email" value="" onkeydown="$('#infoEmail').fadeOut();"/>
                    </div>
                    <div class="error-message" id="infoEmail"></div>
                    </td>
    </tr>
    <tr>
        <td><div class="field"><span class="mand">*</span>
                        <label for="country" class="infield">COUNTRY</label>
                        <input name="country" type="text" class="inputmain country" id="country" value="" onkeydown="$('#infoCountry').fadeOut();"/>
                    </div><div class="field marl10">
                        <label for="phone" class="infield">TELEPHONE</label>
                        <input name="phone" type="text" class="inputmain phone" id="phone" value="" onkeydown="$('#infoPhone').fadeOut();"/>
                    </div><div class="error-message" id="infoCountry"></div><div class="error-message" id="infoPhone"></div></td>
    </tr>
    <tr>
        <td colspan="2"><div class="field"><span class="mand">*</span>
                        <label for="comment" class="infield">COMMENTS</label>
                        <textarea class="inputmain" id="comment" name="comment" onkeydown="textCounter(this.form.comment,'remLen',300);$('#infoComment').fadeOut();" onkeyup="textCounter(this.form.comment,'remLen',300);"></textarea>
                        <div class="char-count"><span id="remLen">300</span>  chars remaining</div>
                    </div><div class="error-message" id="infoComment"></div></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="Submit" class="btnorange" onclick="return validateContactUs(this);" /></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
</table></form>
                </div>
            </div>
        </div>
	</div>
	<div class="clear"></div>
</div>