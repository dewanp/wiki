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
<!--[if lt IE 8]><style>
.gallerymain.entire-post .galleryinner .imgbig span {
    display: inline-block;
    height:50%;
}
</style><![endif]-->
<div style="display:none;" id="google_ad_client_val"><?php echo $google_ad_client;?></div>
<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><?php echo anchor('post/showposts/all','All Posts');?></li>
				<li><a href="javascript:void(0);" class="active">Image</a></li>
			</ul>
		</div>
		<?php if(!empty($image)){?>
		<h1 class="orangetitle-f20" style="margin: 10px 28px 0;">Images</h1>
		<div class="rightinner" id="show-images">   
			<div class="gallerymain entire-post">
            <div class="galleryinner">
			<div id="img-<?php echo $image['file_upload_id']?>" class="imgbig"><span></span><script> showImage('<?php echo $image['file_upload_id']?>','700','400','img-<?php echo $image["file_upload_id"]?>');</script></div>
			<h5><?php echo $image['title']?></h5>
            <div class="by"><b>Posted By:</b> <a href="<?php echo site_url($image['user_name'])?>"><?php if($image['profile_name']) echo $image['profile_name']; else echo $image['user_name'];?></a></div>
            <?php echo anchor(getPostUrl($image['post_id']),'View Entire Post','class="btngrey"');?>
            </div>
            </div>
            <div class="contentbox">
            <?php echo $image['description']?>
			
            <div class="advertise"><?php $this->load->view('post/google-ad', array('google_ad_client'=>$google_ad_client));?></div> 
            </div>
			  
		</div>
		<?php } else echo '<span style="margin:10px;font-size:16px;">No '.$type.' available</span>';?>
	</div>
	<div class="clear"></div>
</div>