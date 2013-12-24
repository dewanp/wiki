
<div id="wrapper" class="viewpage">
  <div class="left-content-main"><?php echo $sidebar;?>  </div>
  
  <?php if($post['is_active']==1){?>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><a href="javascript:void(0);" class="active">Home</a></li>
        <li><a href="javascript:void(0);" class="active">Post view</a></li>
		<li style="float:right; background:none;">
			<?php if($this->session->userdata('reported_abuse_'.$post_id)){ ?>
				<div class="report-abuse-link"><a href="javascript:void(0);" style="cursor:auto;" title="This is reported as abuse"></a></div>
			<?php }else{ ?>
				<div class="report-abuse-link"><a href="javascript:void(0);" onclick="popupClear();  openPopDiv('pop-report-abuse');" title="Report abuse"></a></div>
			<?php }	?>
		</li>
        
		<li style="float:right; background:none;" id ="my_favorites"><?php echo $my_favorites; ?></li>
      </ul>
      
    </div>
    <div class="rightinner">
        <div id="post-basic-info"> 
			<script>	
				postBasicInfo('<?php echo $post_id?>','view')
			</script>
		</div>
    </div>
  </div>
  <?php }else{?>  
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Post view</a></li>
      </ul>
      
    </div>
    <div class="rightinner">
       <div class="zipmessage"><div class="infoleft" style="width:96%;"><span class="icon"></span> The Page You Are Looking for Has Been Moved or No Longer Exists. <?php echo anchor("post/showposts/all","All Post!");?></div></div>
    </div>
  </div>
  
  <?php }?>
  
  <div class="clear"></div>
</div>

<script> 
function addgoogle(id)
{ 
	google_client = $("#top-ad").html();//alert(google_client);
	$("#"+id).html(google_client);//alert(google_client);
}
</script>


<!--popup Report Abuse-->
<div class="popup" id="pop-report-abuse" style="display:none;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('pop-report-abuse');"></a>
    <h2>Report Abuse</h2>
    <div class="popupinner">
		<form  id="frm_report_abuse" onsubmit ="if(reportAbuse()){closePopDiv('pop-report-abuse');} return false;" >
			<input type="hidden" name="post_id" value="<?php echo $post_id?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblmessage">
				<tr>
					<td>Email*</td>
					<td>
						<input type="text" name="email" id="email" class="inputmain" maxlength="150" >  
						<div id="email_msg" style="color:#F00" > </div>
				  </td>
				</tr>
				<tr>
					<td>Message</td>
					<td>
						<textarea name="message" id="message"  cols="" rows="" class="inputmain" onkeyup="countCharCompose(this)"  onblur="$('#error_description').html('')"   ></textarea>
						<div id="error_description"  > </div>
				  </td>
				</tr>
			</table>

			<div class="btnbox"> 
				<input type="submit" value="Send" class="btnorange"> 
				<a href="javascript:void(0);" class="cancel" onclick="closePopDiv('pop-report-abuse');">Cancel</a>
			</div>
		</form>
    </div>
</div>
<!--popup report abuse-->