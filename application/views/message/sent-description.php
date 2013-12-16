 <div class="righttop">
                            <div class="righttopin">
                                <h4><?php echo htmlentities($subject); ?></h4>
                                <span class="from">From: 
									<?php echo anchor($user_name, $user_name); ?>
								</span>
							<span class="from">To: 
							<?php
							  $recepient_array = explode(',',$recepient); 
							  
							  foreach($recepient_array as $recepient_name)
							  {
								  $rec_name = explode('#',$recepient_name);
								  $usernamearray[] = anchor($rec_name[1], $rec_name[1]);			 
							  }
							echo implode(" , ",$usernamearray );
							?>
							
							</span> <span class="dt"><?php echo int_to_date($time) ;?></span> </div>
                        </div>
                        <div class="msgdtl">
                            <div class="msgicons">
                                <div class="icons">
               	                <a href="javascript:void(0)" title="Delete Message" onclick="prepareConfirmPopup(this,'Are you sure?')" class="icon1"></a><div class="adl"><a href="javascript:void(0)" onclick ="delete_message('<?php echo $message_id ; ?>','sent')" class="btnorange">Yes</a></div>
																
								</div>
                            </div>
                            <div class="msgpara">
							<?php echo htmlentities($description); ?>
                            </div>
                          
							
<!-- Java script for creating scroll bar  -->
<script type="text/javascript">
		$(function(){
			//jscrollpane
			var api = $('.replymsgpara').jScrollPane(
				{
					showArrows:false,
					maintainPosition: false
				}).data('jsp');
			//end
			});

</script>