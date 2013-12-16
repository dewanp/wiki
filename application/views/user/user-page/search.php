<div class="info-block mart18">Your search has <a href="javascript:void(0);"><?php echo count($users);?></a> results</div>

<div class="urow">
	<?php foreach($users as $key=>$user){?>
		
		<?php if($key!=0 && $key%2==0){?>
			</div>
			<div class="urow">
		<?php }?>
		
		<div class="userbox">
		<div class="utop">
			<div class="uleft">
				<div class="thumb" id="search-result-user-thumb-<?php echo $user['user_id']?>">
				<img src="images/loader.gif" alt= "" >
					<script>showImage('<?php echo $user["picture"]?>','80','80','search-result-user-thumb-<?php echo $user["user_id"]?>');</script>
				</div>
			</div>
			<div class="uright">
				<h4><?php echo $user['profile_name']?></h4>
				<span class="txtgrey"><?php echo $user['user_name']?></span>
				<div class="postinfo">
					<div class="infocol"> <span class="txtinfo"> <span class="txtleft">Most Post :</span> <a href="javascript:void(0);">Video Blogs</a> <a href="javascript:void(0);" class="bdrleft">Polls</a> </span> </div>
					<div class="infocol"> <span class="txtinfo"> <span class="txtleft">Tags :</span> <a href="javascript:void(0);">Tag 1,</a> <a href="javascript:void(0);">Tag 2</a> </span> </div>
				</div>
			</div>
		</div>
		<div class="ubot">
			<div class="ubotnav"> <a href="javascript:void(0);" onclick="followUser('<?php echo $user['user_id']?>','<?php echo $user_id?>')"> <img src="images/followuser-icon.png" alt="" />Follow User</a> </div>
		</div>
		<div class="or-icons"> <span class="uicon"><img src="images/uicon.png" alt="" /></span> <span class="txtwhite">450</span> </div>
		</div>
	<?php }?>
</div>