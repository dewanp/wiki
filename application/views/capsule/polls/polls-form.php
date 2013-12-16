<div id="formcontainer" >
<form method="post" id="pollform-<?php echo $polls_id?>">
<input type="hidden" name="polls_id" value="<?php echo $polls_id?>" />
<?php foreach($options as $key => $option){?>
<?php if(count($options)>2 && $key < 2){ continue; }?>
<?php 
		if($total_votes['totalvote']){
			$percent= round(($option['votecount']*100)/$total_votes['totalvote']);
		}else{
			$percent = 0;
		}
	?>	
<div class="pollchoice">
	<div class="radio">
    <div class="custom-radio">
		<input type="radio" id="choice-<?php echo $option['option_id']?>" name="option_id[<?php echo $polls_id?>]" class="designer" value="<?php echo $option['option_id']?>"/>
		<label for="choice-<?php echo $option['option_id']?>">
			<div class="poll">
				<span class="ptxt"><?php echo $option['title']?> (<em><?php echo $percent?>%, <?php echo $option['votecount']?> votes</em> )</span>
				<div class="progressmain">
					<span class="progress" style="width: <?php echo $percent?>%; display:none;"></span>
				</div>
			</div>
		</label>
	</div>
    </div>
	<a href="javascript:void(0);" class="cvalue tooltip" title="<?php echo $option['votecount']?> People voted"><?php echo $option['votecount']?></a> 
</div>	
<?php }?>
<div class="pollchoice">
	<a href="javascript:void(0)" onclick="submitPolls(this,'<?php echo $capsule_id?>','<?php echo $polls_id?>')" class="btngrey">Vote</a>
</div>	

</form>
<script>
$(function(){
	$(".designer").customInput();
});
</script>
</div>