	 <div class="righttop">
		<div class="righttopin">
			<span class="from" >Subject:<?php echo htmlentities($subject); ?></span>
			<span class="from">From:<?php echo anchor($user_name, $user_name);?></span> 
			<span class="from">To: 
			<?php 
			      $recepient_name = explode(',',$recepient); 
				 
				  foreach($recepient_name as $r_name)
				  {  
					  $rec_name = explode('#',$r_name);
					  $usernamearray[] = anchor($rec_name[1], $rec_name[1]);
				  }
				  echo implode(", ",$usernamearray);
			
			?>
			
			</span> 
			<span class="dt"><?php echo int_to_date($time) ; ?></span> </div>
	</div>
	<div class="msgdtl">
			<div class="msgicons">
				<div class="icons"> 
	                <a href="javascript:void(0)" title="Delete Message" onclick="prepareConfirmPopup(this,'Are you sure?')" class="icon1"></a><div class="adl"><a href="javascript:void(0)" onclick ="delete_message('<?php echo $message_id ; ?>','inbox')" class="btnorange">Yes</a></div>
					<a href="javascript:void(0);" title="Reply" class="icon2" onclick="document.getElementById('txtdescription').focus()"></a>
                    <a href="javascript:void(0)" title="Archive This Message" onclick ="archive_message('<?php echo $message_id; ?>','inbox')" class="icon3"></a>
				</div>
			</div>
			
				<div class="msgpara">
					<?php echo htmlentities($description); ?>
				</div>
			

			
					<?php 
						
						  $recepient_id = array();
					      foreach($recepient_name as $key=> $value)
						  {
							  $id_name_array =explode('#',$value); 
							  $recepient_id[$key] = $id_name_array[0];
						  }
						  						  
						 $push =  array_search($user_id,$recepient_id);
					   	if($push <= 0)
					   {
						   array_push($recepient_id ,$user_id);
					   }
					  $pop = array_search($this->session->userdata('user_id'),$recepient_id);
					    if($pop >= 0)
						{
							$arr = array($pop => 0);
							$recepient_id = array_replace($recepient_id,$arr);
						}
					?>

			<div class="msgreply" >
				<div class="replyin">
					<form  method="POST" onsubmit="return postMessageReply() ">
					<h4>Reply</h4>
					<div id="show_post_reply" style="text-align:center"></div>

					<div class="field">
						<input type="text" id="reply_subject" class="inputmain" maxlength="155" value="Re : <?php echo $subject;?>"  >
						 <div id="div_reply_subject" style="color:#F00"> </div>
					</div>


					<div class="field" >
						<input type="checkbox" name="reply_all"  id="reply_all">
						<label for="reply_all"> Reply All  </label>
					</div>
					<textarea name="txtdescription" id="txtdescription" rows="" cols="" style="min-height:115px ;" class="inputmain" onkeyup="countChardescription(this)" ></textarea>
					<div>
                    <span id="div_reply_description" style="width:auto"> </span>
					<input type="submit" class="btnorange" value="Post a reply" id="reply_submit" />
                    </div>
					<input type="hidden" id="to" name="to" value="<?php echo $user_id;?>" >
					<input type="hidden" id="to_all" name="to_all" value="<?php echo implode(',', $recepient_id);?>" >
					<input type="hidden" id="message_parent_id" name="message_parent_id" value="<?php echo $message_id?>" >
				</form>
				</div>
			</div>
		</div>


<!-- Java script for creating scroll bar  -->
<script type="text/javascript">
		$(function(){
				//$('.msgreply').hide();
			//jscrollpane
			var api = $('.replymsgpara').jScrollPane(
				{
					showArrows:false,
					maintainPosition: false
				}).data('jsp');
			//end
			});

		function countChardescription(val){
			 var len = val.value.length;
			 if (len >= 1000) {
					  $('#div_reply_description').html("limit of 1000 character exceed");
			 } else {
					  $('#div_reply_description').html("Character :"+ (1000 - len));
			 }
		};
</script>