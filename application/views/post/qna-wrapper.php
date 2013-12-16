<div class="showcomment" id="answer-box-<?php echo $new_answer_id?>">
	 <div class="icons-right">
				<a href="javascript:void(0);" class="tooltip delete" title="Delete Answer" onclick="prepareConfirmPopup(this,'Are you sure?')"></a>
				<div class="adl"><a class="btnorange" href="javascript:void(0);" onclick="deleteAnswer('<?php echo $new_answer_id; ?>')" >Yes</a>	</div>
	 </div>
      <div id="is_best" class="is_best">
          <form id="is_best_form" class="qna wrapper file">
          <input type="checkbox"  class="tooltip"  title="Select this as Best Answer" id="is_best_check<?php echo $new_answer_id; ?>"  onchange="make_best('<?php echo $new_answer_id ?>','<?php echo $new_answer_id ?>');"/>
          </form>
      </div>
	<div class="scthumb" id="answer-img-<?php echo $new_answer_id?>">
			<img src="images/loader.gif" alt= "" >
			<script> showImage('<?php echo $user["picture"]?>','30','30','answer-img-<?php echo $new_answer_id?>');</script>
	</div>
	<div class="sctxt ans">
			<h4><?php if($user['user_name'] ==''){ echo $user['profile_name'];}else{ echo anchor($user['user_name'], $user['profile_name']) ;}  ?></h4>
			<p><?php echo $description; ?></p>
			<div class="time"><?php echo TimeAgo($created_date); ?></div>
	</div>
</div>