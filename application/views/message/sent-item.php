<div id="wrapper">
	<div class="left-content-main"> <?php echo $sidebar; ?></div> 
	<div class="rightmain">
		<div class="breadcrumb">
			<span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('','Home');?></li>
				<li> <?php  echo $name?></li>
			</ul>
		</div>
		
		<div class="rightinner">
			<table border="1" width="100%">
				<tr>
					<th> Recepient Name</th>
					<th> Subject </th>
					<th> Time</th>
				</tr>
				<?php foreach($res as $row){  ?>
				    <tr>
					    <td> <?php echo $row['user_name'];?> </td>
						
						<td><a href="javascript:void(0)" id="<?php echo $row['message_id']; ?>" onclick="showMessage('<?php echo $row['message_id']; ?>','sentitem')">
							       <?php echo $row['subject']; ?> </a> </td>
						<td> <?php echo TimeAgo($row['time']);?> </td>
					</tr>
				<?php } ?>
			</table>
			<div id="description" >
			  </div>
		</div>
	</div>
	<div class="clear"></div>
</div>


