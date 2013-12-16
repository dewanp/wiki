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
			<div id= "left-inbox" float="left">
				<table border="1" style="width: 350px">
					<tr>
						<th>
							From
						</th>
						<th>
						   Subject
						</th>
						<th>
							Time
						</th>
					</tr>
					<?php foreach($inbox as $row) { ?>
					      <tr>
							<td><?php echo $row['user_name']; ?> </td>
							<td>
								<?php if($row['is_read'] == 1){ ?>

									<a href="javascript:void(0)" id="<?php echo $row['message_id']; ?>" onclick="showMessage('<?php echo $row['message_id']; ?>','inbox')" >
									<?php echo $row['subject']; ?> </a>
								<?php } else { ?>
									<a class="inbox" href="javascript:void(0)" id="<?php echo $row['message_id']; ?>" onclick="showMessage('<?php echo $row['message_id']; ?>', 'inbox')" >
							       <?php echo $row['subject']; ?> </a> 
								   
								<?php } ?>
						   </td>
							<td><?php echo TimeAgo($row['time']) ;?> </td>
						  </tr>
					<?php } ?>




				</table>
			</div>
			  <div id="description" style="float:right">
			  </div>

		</div>
	</div>
	<div class="clear"></div>
</div>


