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
			<ul>
				<li> <?php echo anchor('message/inbox','Inbox');     ?></li>
				<li> <?php echo anchor('message/sentitem',' Sent '); ?></li>
				<li> <?php echo anchor('message/archive','Archive'); ?></li>
				<li> <?php echo anchor('message/compose','Compose ');?></li>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>