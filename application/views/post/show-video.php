<?php  
$google_ad_admin_percent = $this->commonmodel->getRecords('google_ad', 'admin_percent', array('google_ad_id' => 1), '', true);

$admin_percent=$google_ad_admin_percent['admin_percent'];

$user_percent = 100-$admin_percent;

if(!isset($_SESSION['google_add'][$post_id]['count']))
{
	$_SESSION['google_add'][$post_id]['count'] = 0;
}
else
{
	$_SESSION['google_add'][$post_id]['count'] = $_SESSION['google_add'][$post_id]['count']+1;
}

$total_hits = $_SESSION['google_add'][$post_id]['count'];

if($admin_percent%10 == 0)
{ 
	$admin_hits = $admin_percent/10;
	$user_hits = $user_percent/10;
	$hit_count = $total_hits%10;
}
else
{
	$admin_hits = $admin_percent/5;
	$user_hits = $user_percent/5;
	$hit_count = $total_hits%20;
}

if($hit_count<$user_hits)
{	
	// user google ad client
	$user_client = $this->commonmodel->getRecords('user_earnings_account', 'user_code', array('user_id' => $post['user_id'], 'account_type'=>2, 'is_active' =>1), '', true);
	if(!empty($user_client)){
		$google_ad_client = $user_client['user_code'];
	}else{
		$admin_client = $this->commonmodel->getRecords('user_earnings_account', 'user_code', array('user_id' => 1, 'account_type'=>2), '', true);
		$google_ad_client = $admin_client['user_code'];	
	}	
	
	//$google_ad_client = 'ca-pub-124862319174302';
	//$google_ad_client = 'user add';
}
else
{
	// admin google ad client
	$admin_client = $this->commonmodel->getRecords('user_earnings_account', 'user_code', array('user_id' => 1, 'account_type'=>2), '', true);
	$google_ad_client = $admin_client['user_code'];
	
	//$google_ad_client = 'ca-pub-124862319174302';
	//$google_ad_client = 'admin add';
}

?>
<script>
function showvideo(id,file_path){
		jwplayer(id).setup({flashplayer: "jwplayer/player.swf",file: file_path,width:699,height:400,image: file_path+".jpg"});
	}
</script>
<div style="display:none;" id="google_ad_client_val"><?php echo $google_ad_client;?></div>
<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><?php echo anchor('post/showposts/all','All Posts');?></li>
				<li><a href="javascript:void(0);" >Video</a></li>
			</ul>
		</div>
		<?php if(!empty($video)){?>
		
        
        <h1 class="orangetitle-f20" style="margin: 10px 28px 0;">Videos</h1>
		<div class="rightinner" id="show-videos">   
			<div class="gallerymain entire-post">
            <div class="galleryinner">
			<div id="vdo-<?php echo $video['file_upload_id']?>"></div>
			<?php 
			if($video['type']== 'video/youtube')
			{
				$file_path = $video['file_path'];
			}
			else
			{
				//$file_path = site_url($video['file_path']);
				$file_path = S3_URL.BUCKET_NAME.'/uploads/'.$video['file_path'];
			} 
			?>
            
            
			<script> showvideo('vdo-<?php echo $video['file_upload_id']?>','<?php echo $file_path;?>');</script>
			<h5><?php echo $video['title']?></h5>
            <div class="by"><b>Posted By:</b> <a href="<?php echo site_url($video['user_name'])?>"><?php if($video['profile_name']) echo $video['profile_name']; else echo $video['user_name'];?></a></div>
            <?php echo anchor(getPostUrl($video['post_id']),'View Entire Post','class="btngrey"');?>
            </div>
            </div>
            <div class="contentbox">
            <?php echo $video['description']?>
			<div class="advertise"><?php $this->load->view('post/google-ad', array('google_ad_client'=>$google_ad_client));?></div> 
            </div>
			  
		</div>
		<?php } else echo '<span style="margin:10px;font-size:16px;">No '.$type.' available</span>';?>
	</div>
	<div class="clear"></div>
</div>