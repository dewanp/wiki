<div id="wrapper"><div class="left-content-main">
        	<?php echo $sidebar;?>
        </div> 
<div class="rightmain">
        <div class="breadcrumb">
          <span class="arrowleft"></span>
          <ul>
          <li><?php echo anchor('user/feeds','Home'); ?></li>
          <li><a href="javascript:void(0);" class="active">People you Follow</a></li>
          </ul>
          </div>
          <div class="rightinner">


            <div class="account-sec-tab">
                <div class="account-info-tab">
                    <div class="float active">
						<span class="back"><span class="unlimited"></span></span> 
						<span class="mid"><?php echo anchor('user/youfollow','People you follow');?></span>
						<span class="front"></span>
					</div>
                    <div class="float">
						<span class="back"></span> 
						<span class="mid"><?php echo anchor('user/followingyou','People following you');?></span> 
						<span class="front"></span>
					</div>
                    <div class="float">
						<span class="back"><span class="unlimited"></span></span> 
						<span class="mid"><?php echo anchor('user/search','Search for People');?></span>
						<span class="front"></span>
					</div>					
                </div>
            </div>

<div class="usder-dashboard" id="user-dashboard">
<div class="info-block mart18">You following  <b> <?php echo $users_total_count;?></b>  users</div>
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
					<script>showImage('<?php echo $user["picture"]?>','80','80','search-result-user-thumb-<?php echo $user["user_id"]?>');</script>
			</div>
		</div>
		<div class="uright">
			<h4><?php echo $user['profile_name']!=''?anchor($user['user_name'],$user['profile_name']):anchor($user['user_name'],$user['user_name']); ?></h4>
			<div class="postinfo">
				<?php if($user['used_post_type']){?><div class="infocol"> <span class="txtinfo"> <span class="txtleft">Most Post :</span><?php  $used_post_type =explode("|",$user['used_post_type']);
					  echo implode(" | ",array_slice($used_post_type,0,6)); ?></span> </div><?php }?>
				<?php if($user['used_tags']){?><div class="infocol"> <span class="txtinfo"> <span class="txtleft">    Tags :</span><?php $user_tages = explode(" | ",$user['used_tags']);
					echo implode(" | ",array_slice($user_tages,0,8));?></span> </div><?php }?>
			</div>
		</div>
	</div>
	<div class="ubot">
		<div class="ubotnav">
				<div class="follow-link">
						<a href="javascript:void(0);" onclick="unFollowUserbyAnyLocation(this,'<?php echo $user['user_follow_id']?>','page')">UnFollow This User</a>
				</div>
		</div>
	</div>
	<div class="or-icons"> <span class="uicon"><img src="images/uicon.png" alt="" /></span> <span class="txtwhite"><?php echo $user['postcount']?></span> </div>
</div>
<?php }?>
</div>
<div class="catnav"><?php echo $this->pagination->create_links(); ?></div>
</div>
</div></div><div class="clear"></div></div>