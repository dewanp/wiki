 <div class="righttop">
	<div class="righttopin">
		<h4><?php echo $subject; ?></h4>
		<span class="from">From: 
			<?php echo anchor($user_name, $user_name); ?>
		</span>
	<span class="from">To: 
	<?php	  $recepient_array = explode(',',$recepient); 
	  foreach($recepient_array as $recepient_name)
	  {
		   $rec_name = explode('#',$recepient_name);
		  $usernamearray[] = anchor($rec_name[1], $rec_name[1]);
	  }
	  echo implode(" , ",$usernamearray );
	?>
	</span> <span class="dt"><?php echo int_to_date($time) ;?></span> </div>
</div>

<div class="msgdtl">
	<div class="msgicons">
		<div class="icons">
		<a href="javascript:void(0)" title="Delete Message" onclick="prepareConfirmPopup(this,'Are you sure?')" class="icon1"></a><div class="adl"><a href="javascript:void(0)" onclick ="delete_message('<?php echo $message_id ; ?>','inbox')" class="btnorange">Yes</a></div>
		<a href="javascript:void(0);"  class="icon2" onclick="document.getElementById('txtdescription').focus()"></a>
		<a href="javascript:void(0)" title="Remove Archive" onclick ="remove_archive_message('<?php echo $message_id; ?>')" class="icon3"></a>
	   </div>
	</div>
	<div class="msgpara">
		<?php echo htmlentities($description); ?>
	</div>
	<div class="msgreply" >
	<div class="replyin">
			<form  method="POST" onsubmit="return postMessageReply() ">
			<h4>Reply</h4>
			<div id="show_post_reply"></div>

			<div class="field">
				<input type="text" id="reply_subject" class="inputmain" maxlength="155" value="Re: <?php echo $subject;?>"  >
				 <div id="div_reply_subject"> </div>
			</div>
			
			<textarea name="txtdescription" id="txtdescription" rows="" cols="" class="inputmain" onkeyup="countCharArchive(this)" style="min-height :115px;"  ></textarea>
			<div>
			<span id="div_reply_description" style="width:auto"> </span>
			<input type="submit" class="btnorange" value="Post a reply" />
			</div>
			<input type="hidden" id="to" name="to" value="<?php echo $user_id?>" >
			<input type="hidden" id="message_parent_id" name="message_parent_id" value="<?php echo $message_id?>" >
		</form>
		</div>
   </div>
</div>
                          
							
<!-- Java script for creating scroll bar  -->
<script type="text/javascript">
		$(function(){
			//jscrollpane
			var api = $(' .replymsgpara').jScrollPane(
				{
					showArrows:false,
					maintainPosition: false
				}).data('jsp');
			//end
			});

		function countCharArchive(val){
			 var len = val.value.length;
			 if (len >= 1000) {
					  $('#div_reply_description').html("limit of 1000 character exceed");
			 } else {
					  $('#div_reply_description').html("Character :"+ (1000 - len));
			 }
		};
</script>