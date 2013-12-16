<div>
<table border="1" >
	<tr>
	   <td><b> Subject: </b> <?php echo $subject; ?> </td>
	</tr>
	<tr>
	   <td> <b>From :</b> <?php echo $user_name; ?> </td>
    </tr>
	<tr>
		<td><b>To :</b> <?php echo $recepient; ?></td>	
	</tr>
    <tr>
		<td><b>time :</b><?php echo TimeAgo($time); ?> </td>
	</tr>
	
	<tr>
		<td><?php echo anchor('message/makearchive/'.$message_id,'mark as Archive'); ?></td>
	</tr>
	
	<tr>
	  <td><b>Description</b> </td>
	</tr>
	<tr>
	   <td>
	   <?php echo $description; ?>
	   </td>
	</tr>
</table>
</div>
 <div id="show_post_reply"> </div>
<div>
<form  method="POST" onsubmit="return postMessageReply() ">
	<table >
	      <tr>
		     <td colspan="2" align="center" >Reply </td>
		</tr>  
	      <tr>
		     <td><input type="text" id="to" name="to" value="<?php echo $user_id?>" hidden> </td>
		     <td><input type="text" id="message_parent_id" name="message_parent_id" value="<?php echo $message_id?>" hidden> </td>		     
		</tr>
		<tr>
			<td> Subject: </td>
		      <td> <input type="text" id="reply_subject" value ="Re : <?php echo $subject;?>" >
			 <div id="reply_subject"> </div>
			</td>
		</tr>
		 <tr>
		      <td> Description : </td>
			<td><textarea name="description" id="description" rows="10" cols="10"></textarea>
			<div id="reply_description"> </div>
			</td>
		 </tr>
		 <tr>
			 <td colspan="2" align="center"> 
			 <input type="submit" value=" Reply "> 
			 </td>
		 </tr>
	</table>
	</form>
</div>