<h2>My Area</h2>
<ul>
	<li>
		My Posts	
		<ul>
			<li><?php echo anchor('post/add','Create New');?></li>
			<li><?php echo anchor('post/mypost','Manage');?></li>
		</ul>
	</li>
	<li>
		My Earnings
		<ul>
			<li><?php echo anchor('post','All Post');?></li>
		</ul>
	</li>
	<li>
		Messages
		<ul>
			<li><?php echo anchor('message','Messages');?></li>
		</ul>
	</li>
</ul>