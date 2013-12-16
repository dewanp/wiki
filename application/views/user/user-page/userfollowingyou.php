<div class="info-block mart18"> <b><?php echo count($users);?></b> users following you</div>
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
			<span class="txtgrey"><?php echo anchor($user['user_name'],$user['user_name']);?></span>
			<div class="postinfo">
				<?php if($user['used_post_type']){?><div class="infocol"> <span class="txtinfo"> <span class="txtleft">Most Post :</span><?php echo $user['used_post_type'] ?></span> </div><?php }?>
				<?php if($user['used_tags']){?><div class="infocol"> <span class="txtinfo"> <span class="txtleft">Tags :</span><?php echo $user['used_tags'] ?></span> </div><?php }?>
			</div>
		</div>
	</div>
	<div class="ubot">
		<div class="ubotnav"> Block User <img src="images/cross.png" alt="" />  Report Abuse<img src="images/cross.png" alt="" />  </div>
	</div>
	<div class="or-icons"> <span class="uicon"><img src="images/uicon.png" alt="" /></span> <span class="txtwhite"><?php echo $user['postcount']?></span> </div>
</div>
<?php }?>
</div>
       