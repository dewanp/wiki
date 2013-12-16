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
//$total_hits = $pageview;

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

/*echo '<pre>';
echo 'user hits:'.$user_hits;
echo '<br>admin hits:'.$admin_hits;
echo '<br>total hits:'.$total_hits;
echo '<br>hit count:'.$hit_count;
echo '<br>google ad client:'.$google_ad_client;
echo '<br>';
echo '</pre>';*/
?>
<div style="display:none;" id="google_ad_client_val"><?php echo $google_ad_client;?></div>
<div id="wrapper" class="viewpage">
  <div class="left-content-main"><?php echo $sidebar;?>  </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Post view</a></li>
		<li style="float:right; background:none;">
			<?php if($this->session->userdata('reported_abuse_'.$post_id)){ ?>
				<div class="report-abuse-link"><a href="javascript:void(0);" style="cursor:auto;">This is reported as abuse</a></div>
			<?php }else{ ?>
				<div class="report-abuse-link"><a href="javascript:void(0);" onclick="popupClear();  openPopDiv('pop-report-abuse');">Report abuse</a></div>
			<?php }	?>
		</li>
        <?php if($followthisuser){?>
        <li style="float:right; background:none;"><?php echo $followthisuser; ?></li>
        <?php }?>
		<li style="float:right; background:none;" id ="my_favorites"><?php echo $my_favorites; ?></li>
        <li style="float:right; background:none;" id ="subscribe_unsubscribe"><?php echo $subscribe_unsubscribe; ?></li>
        <?php if ($this->commonmodel->isLoggedIn()) {?>
			<?php if($localpost == 1){?>
                <?php if($fol_unfol_status == 'follow'){?>
                    <li style="float:right; background:none;" id ="fol_unfol_location">
                        <div class="unfollow-location">
                            <a onclick="followLocation('<?php echo $zip_code ?>','single_post')" href="javascript:void(0);" hidefocus="true" style="outline: medium none;" title="Follow Location"></a>
                        </div>
                    </li>
                <?php }else{?>
                      <li style="float:right; background:none;" id ="fol_unfol_location">
                          <div class="follow-location">
                              <a onclick="unFollowLocation('<?php echo $zip_code ?>','single_post')" href="javascript:void(0);" hidefocus="true" style="outline: medium none;" title="Unfollow Location"></a>
                          </div>
                      </li>
                <?php }?>
          <?php }?>
      <?php }?>
      <?php if ($this->commonmodel->isLoggedIn() && $user_id == $post['user_id']) {?>
			<?php if( $post['is_active'] == 1 ){?>
              <li style="float:right; background:none;" id ="pub_unpub_post">
                  <div class="unpublish-post">
                      <a href="javascript:void(0);"  onclick="unpublishPost('<?php echo $post_id ?>')" hidefocus="true" style="outline: medium none;" title="Unpublish Post"></a>
                  </div>
              </li>
          <?php }else{?>
              <li style="float:right; background:none;" id ="pub_unpub_post">
                  <div class="publish-post">
                      <a href="javascript:void(0);" onclick="publishPost('<?php echo $post_id ?>')" hidefocus="true" style="outline: medium none;" title="Publish Post"></a>
                  </div>
              </li>
          <?php }?>
      <?php }?>
      
      <?php if ($this->commonmodel->isLoggedIn() && $user_id == $post['user_id']) {?>
          <li style="float:right; background:none;" id ="edit_post">
              <div class="edit-post">
                  <a href="<?php echo site_url('post/edit/'.$post_id); ?>" hidefocus="true" style="outline: medium none;" title="Edit Post"></a>
              </div>
          </li>
      <?php }?>
      
      </ul>
      
    </div>
	<!-- right inner start -->
    <div class="rightinner">
        <div id="post-basic-info"> 
			<script>	
				postBasicInfo('<?php echo $post_id?>','view')
			</script>
		</div>
        <div id="sherethisDiv" class="clear">
            <div class="socialNatworkIcon borderRadius">
                <!--<span class='st_fblike_vcount' displayText='Facebook Like'></span>
                <span class='st_fbsend_vcount' displayText='Facebook Send'></span>
                <span class='st_twitter_vcount' displayText='Tweet'></span>
                <span class='st_linkedin_vcount' displayText='LinkedIn'></span>
                <span class='st_pinterest_vcount' displayText='Pinterest'></span>
                <span class='st_googleplus_vcount' displayText='Google +'></span>
                <span class='st_email_vcount' displayText='Email'></span>-->
                
                <span class='st_facebook_hcount' displayText='Facebook'></span>
                <span class='st_twitter_hcount' displayText='Tweet'></span>
                <span class='st_linkedin_hcount' displayText='LinkedIn'></span>
                <span class='st_googleplus_hcount' displayText='Google +'></span>
                <span class='st_pinterest_hcount' displayText='Pinterest'></span>
                <span class='st_email_hcount' displayText='Email'></span>
            </div>
        </div>
        
		<div id="top-ad" style="margin-top:15px;">
			<?php $this->load->view('post/google-ad', array('google_ad_client'=>$google_ad_client));?>
		</div>


		<div class="commentbox mart18" id="answer_list">
         <form id="is_best_form" class="view file">
        <?php if(!empty($answer_detail)){ ?>
		<h2>Answers for the question</h2>
      
        <?php $i =1; ?>
		<?php foreach($answer_detail as $answer){ ?>
        <div class="showcomment" id="answer-box-<?php echo $answer['answer_id']?>" <?php if($answer['is_best'] == 1){?> style="border:1px solid #EF792F;" <?php }else{?>  style="border:1px solid #CCCCCC;"<?php }?>>
	        <?php if($answer['user_id'] == $this->session->userdata('user_id') && $answer['user_id']!=0 ) {?>			  
				
              <div class="icons-right">
						<a href="javascript:void(0);" class="tooltip delete" title="Delete Answer" onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
						<div class="adl">
							<a class="btnorange" href="javascript:void(0);" onclick="deleteAnswer('<?php echo $answer['answer_id'] ?>')">Yes</a>
						</div>
				<!-- <img src="images/cross.png" alt="" /> -->
		    </div>
			<?php }?>
            
            <?php if($post_author_id == $user_id){?>
                <div id="is_best" class="is_best">
                    <input class="tooltip" <?php if($answer['is_best'] == 1){?> title="Remove From Best Answer" <?php }else{?>  title="Select This as Best Answer" <?php }?> type="checkbox"  onchange="make_best('<?php echo $i ?>','<?php echo $answer['answer_id']?>');" id="is_best_check<?php echo $i; ?>" <?php if($answer['is_best'] == 1){?> checked="checked" <?php }?>/>
              </div>
              
              
             <?php }?>
          
		    <div class="scthumb" id="answer-img-<?php echo $answer['answer_id']?>">
			<img src="images/loader.gif" alt= "" >
			<script> showImage('<?php echo $answer["picture"]?>','30','30','answer-img-<?php echo $answer["answer_id"]?>');</script></div>
		    
		    <div class="sctxt ans">
				<h4>
				<?php if($answer['user_name'] == null){ echo "Anonymous";}else{ echo anchor($answer['user_name'], $answer['profile_name']) ;}  ?>
				</h4>
				<p><?php echo $answer['description']; ?></p>
				<div class="time"><?php echo TimeAgo($answer['created_date']); ?></div>
		     </div>
             <?php /*?><?php if($answer['is_best'] == 1){ ?>
             	<div style="float: right; color: #666666;">Best answer</div>
             <?php }?><?php */?>
         </div>
	   <?php $i++;
	    } 
	   }?>
       </form>
      <div id="dynamic_answer"> </div>
  <?php if($this->commonmodel->isLoggedIn()){ ?>
	<span class="commentbox"><h2>Your Answer</h2></span>
        <form id ="qna_answer" name="qna_answer" onsubmit = "return postAnswer('<?php echo $post_id ?>')">
          <div class="comm-inner">
           <div class="commthumb" id="user_picture_commentbox">
							<img src="images/loader.gif" alt= "" >
							<script> showImage('<?php echo $this->session->userdata("picture")?>', '50', '50', 'user_picture_commentbox'); </script>
		</div>
            <div class="commfield">
              <textarea cols="" rows="" class="inputmain" id="qna_description" onkeyup="$('#answer_error_msg').html('');"></textarea>
            </div>
            <span class="error" id="answer_error_msg"> </span> </div>
          <div class="left">
            <input type="submit" value="Submit" class="btnorange" />
          </div>
        </form>
		<?php } else { ?>  
		<p class="showcomment"><a href="<?php echo site_url('user/login'); ?>" > Login here </a> to Answer this question</p>
		<?php }?>
	  </div>


		

    </div>
	<!-- right inner end here -->
  </div>
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