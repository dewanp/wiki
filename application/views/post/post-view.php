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

//$total_hits = $_SESSION['google_add'][$post_id]['count'];
//$total_hits = $pageview;
$total_hits = 10;

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
<div style="display:none;" id="google_ad_client_val"><?php echo $google_ad_client;?></div>
<div id="wrapper" class="viewpage">
  <div class="left-content-main"><?php echo $sidebar;?>  </div>
  
  <?php if($post['is_active']==1){?>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><a href="javascript:void(0);" class="active">Home</a></li>
        <li><a href="javascript:void(0);" class="active">Post view</a></li>
		<li style="float:right; background:none;">
			<?php if($this->session->userdata('reported_abuse_'.$post_id)){ ?>
				<div class="report-abuse-link"><a href="javascript:void(0);" style="cursor:auto;" title="This is reported as abuse"></a></div>
			<?php }else{ ?>
				<div class="report-abuse-link"><a href="javascript:void(0);" onclick="popupClear();  openPopDiv('pop-report-abuse');" title="Report abuse"></a></div>
			<?php }	?>
		</li>
        
		<li style="float:right; background:none;" id ="my_favorites"><?php echo $my_favorites; ?></li>
        
      
      <?php /*?><?php if ($this->commonmodel->isLoggedIn() && $user_id == $post['user_id']) {?>
          <li style="float:right; background:none;" id ="edit_post">
              <div class="edit-post">
                  <a href="<?php echo site_url('post/edit/'.$post_id); ?>" hidefocus="true" style="outline: medium none;" title="Edit Post"></a>
              </div>
          </li>
      <?php }?><?php */?>
      
      </ul>
      
    </div>
    <div class="rightinner">
        <div id="post-basic-info"> 
			<script>	
				postBasicInfo('<?php echo $post_id?>','view')
			</script>
		</div>
        
        
        
		
		
        
        
    </div>
  </div>
  <?php }else{?>  
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Post view</a></li>
      </ul>
      
    </div>
    <div class="rightinner">
       <div class="zipmessage"><div class="infoleft" style="width:96%;"><span class="icon"></span> The Page You Are Looking for Has Been Moved or No Longer Exists. <?php echo anchor("post/showposts/all","All Post!");?></div></div>
    </div>
  </div>
  
  <?php }?>
  
  <div class="clear"></div>
</div>

<script> 
function addgoogle(id)
{ 
	google_client = $("#top-ad").html();//alert(google_client);
	$("#"+id).html(google_client);//alert(google_client);
}
</script>


<!--popup Report Abuse-->
<div class="popup" id="pop-report-abuse" style="display:none;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('pop-report-abuse');"></a>
    <h2>Report Abuse</h2>
    <div class="popupinner">
		<form  id="frm_report_abuse" onsubmit ="if(reportAbuse()){closePopDiv('pop-report-abuse');} return false;" >
			<input type="hidden" name="post_id" value="<?php echo $post_id?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblmessage">
				<tr>
					<td>Email*</td>
					<td>
						<input type="text" name="email" id="email" class="inputmain" maxlength="150" >  
						<div id="email_msg" style="color:#F00" > </div>
				  </td>
				</tr>
				<tr>
					<td>Message</td>
					<td>
						<textarea name="message" id="message"  cols="" rows="" class="inputmain" onkeyup="countCharCompose(this)"  onblur="$('#error_description').html('')"   ></textarea>
						<div id="error_description"  > </div>
				  </td>
				</tr>
			</table>

			<div class="btnbox"> 
				<input type="submit" value="Send" class="btnorange"> 
				<a href="javascript:void(0);" class="cancel" onclick="closePopDiv('pop-report-abuse');">Cancel</a>
			</div>
		</form>
    </div>
</div>
<!--popup report abuse-->