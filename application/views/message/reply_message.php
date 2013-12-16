<div class="msgreply">
	<div class="replyin">
		<form  method="POST" onsubmit="return postMessageReply() ">
		<h4>Reply</h4>
		<div id="show_post_reply"></div>

		<div class="field">
			<input type="text" id="reply_subject" class="inputmain" value="Re : <?php echo $subject;?>"  >
			 <div id="div_reply_subject"> </div>
		</div>
		<textarea name="txtdescription" id="txtdescription" rows="" cols="" class="inputmain"></textarea>
		<div id="div_reply_description"> </div>

		<input type="submit" class="btnorange" value="Post a reply" />
		<input type="text" id="to" name="to" value="<?php echo $user_id?>" hidden>
		<input type="text" id="message_parent_id" name="message_parent_id" value="<?php echo $message_id?>" hidden>
	</form>
	</div>
</div>