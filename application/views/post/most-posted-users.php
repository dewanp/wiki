<?php foreach($most_posted_users as $most_posted_users_row){?>
	<div class="thumbmain">
		<a href="<?php echo site_url($most_posted_users_row['user_name']);?>" title="<?php if($most_posted_users_row['profile_name']) echo $most_posted_users_row['profile_name']; else echo $most_posted_users_row['user_name'];?>">
			<div class="thumb" id="most-posted-<?php echo $most_posted_users_row["user_name"];?>">
				<script> showImage('<?php echo   $most_posted_users_row["picture"];?>','40','40','most-posted-<?php echo $most_posted_users_row["user_name"];?>');</script>
			</div>
		</a>
		<span class="name"><a href="<?php echo site_url($most_posted_users_row['user_name']);?>" title="<?php if($most_posted_users_row['profile_name']) echo $most_posted_users_row['profile_name']; else echo $most_posted_users_row['user_name'];?>"><?php if($most_posted_users_row['profile_name'])       echo substr($most_posted_users_row['profile_name'],0,6).'..'; else echo substr($most_posted_users_row['user_name'],0,6).'..';?></a></span> 
	</div>
<?php } ?>