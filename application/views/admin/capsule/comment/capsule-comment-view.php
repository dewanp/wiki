<div id="content-preview-<?php echo $capsule_id?>" class="commentbox">
<?php if($capsule_data['is_comment']){?>
<h2>Add a Comment</h2>
<div class="comment-form-wrapper comm-inner">
	<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">
		
		<div class="commthumb" id="commthumb-user-image">
			<script> showImage('<?php echo $this->session->userdata("picture");?>','50','50','commthumb-user-image');</script>
		</div>
		<div class="commfield">
			<input type="hidden" name="capsule_id" value="<?php echo $capsule_id?>"/>
			<input type="hidden" name="user_id" value="<?php echo $this->session->userdata("user_id") ? $this->session->userdata("user_id"):0?>"/>
			<textarea cols="80" rows="3" name="comment_description" id="comment_description" class="inputmain" onfocus="$(this).removeClass('error-border');"></textarea>
		<div style="float:right;margin-top:5px;">
		<a href="javascript:void(0);" class="btnorange" onclick="saveCommentContent(this,'<?php echo $post_id?>','<?php echo $capsule_id?>')">Post Comment</a></div>
		</div>
		
	</form>
</div>
<div class="commtitle">
	<span class="txtgrey">Showing <?php echo count($capsule_content)?> Comments</span>
	
</div>
<div class="comment-list-wrapper">
<?php if(!empty($capsule_content)){ //print_r($capsule_content);?>	
	<?php foreach($capsule_content as $capsule_comment){?>
		<div class="showcomment" style="width:695px;">
		<a href="<?php echo site_url('user/profile/'.$capsule_comment['user_name']);?>" title="<?php if($capsule_comment['profile_name']) echo $capsule_comment['profile_name']; else echo $capsule_comment['user_name'];?>">
			<div class="scthumb" id="scthumb-comment-<?php echo $capsule_comment['comment_id']?>">
				<script> showImage('<?php echo $capsule_comment["picture"]?>','50','50','scthumb-comment-<?php echo $capsule_comment["comment_id"]?>');</script>
			</div>
		</a>
		<div class="sctxt">
			<h4>
			<?php 
			$commuser = "anonymous";
			if($capsule_comment["user_name"]){
				$commuser = anchor('user/profile/'.$capsule_comment["user_name"],$capsule_comment["user_name"]);
			}
			if($capsule_comment["profile_name"]){
				$commuser = anchor('user/profile/'.$capsule_comment["user_name"],$capsule_comment["profile_name"]);
			}
			echo $commuser?></h4>
			<p><?php echo $capsule_comment['description']?></p>
			<div class="time"><?php echo Timeago($capsule_comment['created_date'])?></div>
        </div>
		</div>
	<?php }?>	
<?php }?>
</div>
<?php }?>
</div>