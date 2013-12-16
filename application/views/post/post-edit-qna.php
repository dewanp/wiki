<div id="wrapper" class="viewpage">
  <div class="left-content-main"><?php echo $sidebar;?> </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Post Edit</a></li>
      </ul>
    </div>
    <div class="rightinner">
      <div class="sub-title" style="margin-top:20px !important;">
        <h2>Question and Answers (QNA) Section</h2>
      </div>
      <div class="btnbox btnbox2"> <a href="<?php echo site_url('post/publish/'.$post_id);?>" class="btngrey">Publish</a> <a href="<?php echo site_url('post/preview/'.$post_id);?>" class="btngrey">Preview</a> <a href="<?php echo site_url('post/edit/'.$post_id);?>" class="btnorange">Edit Post</a> <a href="javascript:void(0)" class="btngrey" onclick="saveDraft('capsule-wrapper');">Save a Draft</a> </div>
      <div id="post-basic-info">
        <script>	postBasicInfo('<?php echo $post_id?>','edit')</script>
      </div>
      <div class="commentbox mart18" id="answer_list">
      <form id="is_best_form" class="view file">
        <h2>Answers for the question</h2>
         <?php $i =1; ?>
	  <?php foreach($answer_detail as $answer){ ?>
        <div class="showcomment" id="answer-box-<?php echo $answer['answer_id']?>" <?php if($answer['is_best'] == 1){?> style="border:1px solid #EF792F;" <?php }else{?>  style="border:1px solid #CCCCCC;"<?php }?>>
	          <?php if($answer['user_id'] == $this->session->userdata('user_id') && $answer['user_id']!=0 ) {?>	
              <div class="icons-right">
				<a href="javascript:void(0);" class="tooltip delete" title="Delete Answer" onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
						<div class="adl">
							<a class="btnorange" href="javascript:void(0);" onclick="deleteAnswer('<?php echo $answer['answer_id'] ?>')" >Yes</a>
						</div>
		    </div>
            <?php }?>
           
            <?php if($post_author_id['user_id'] == $user_id){?>
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
         </div>
	   <?php 
	   $i++;
	   }?>
      
        </form>
         <div id="dynamic_answer"> </div>
	<span class="commentbox"><h2>Your Answer</h2></span>
        <form id ="qna_answer" name="qna_answer" onsubmit = "return postAnswer('<?php echo $post_id ?>')">
          <div class="comm-inner">
            <div class="commthumb" id="user_picture_commentbox">
		<img src="images/loader.gif" alt= "" >
			<script> showImage('<?php echo $this->session->userdata("picture")?>','50','50','user_picture_commentbox');</script>
		</div>
            <div class="commfield">
              <textarea cols="" rows="" class="inputmain" id="qna_description" onkeyup="$('#answer_error_msg').html('');"></textarea>
            </div>
            <span class="error" id="answer_error_msg"> </span> </div>
          <div class="left">
            <input type="submit" value="Submit" class="btnorange" />
          </div>
        </form>
	  </div>
      <div class="btnbox btnbox2" style="border-top: 1px solid hsl(0, 0%, 87%);border-bottom: none;"> </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
