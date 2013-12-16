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
		<td><?php echo anchor('message/removearchive/'.$message_id,'Remove Archive'); ?></td>
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
