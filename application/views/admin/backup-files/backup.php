<?php //if($user_added == "") { ?>
        <?php echo form_open('home/addContest');?>
        <table border="0" cellspacing="0" cellpadding="0" class="tbldtl add-user">
            <tr>
                <td> Choose a Suitable Title:</td>
                <td><div class="field">
                       <input type="text" id="title" name="title" class="inputmain" value="<?php echo set_value('title'); ?>"  maxlength="150"/><br />
                     	<span class="error" id="name_msg"> <?php echo form_error('title'); ?> </span> 
                    </div>
                   	
                   </td>
            </tr>
            <tr>
                <td>Provide tags (at least 2):</td>
                <td> 
                    <div class="field">                      
                          <input type="text" name="tag[]" value="" id="tagedit-input" class="tag tbi" />
                          <span class="error" id="tag_msg"> <?php echo form_error('tag'); ?></span>
                   </div>
               </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><div class="field">
                        <textarea class="inputmain" rows="5" id="description" name="description"><?php echo set_value('description'); ?></textarea><br />
                        <span class="error" id="user_name_msg"><?php echo form_error('description'); ?></span>
                    </div>
                      
                    </td>
            </tr>
            <tr>
                <td>Contest runs from:</td>
                <td><div class="field">
                        <input type="text" id="contest_runs_from" name="contest_runs_from" class="inputmain inputmain-cal" value="<?php echo set_value('contest_runs_from'); ?>"  />
                         <a href="javascript:void(0);" class="cal-icon" id="cal_icon"></a>  
                        <span>to</span>
                       
                        <input type="text" id="contest_runs_to" name="contest_runs_to" class="inputmain inputmain-cal" value="<?php echo set_value('contest_runs_to'); ?>"  />
                        </div>
                        <span class="error" id="contest_runs_frommsg"><?php echo form_error('contest_runs_from'); ?></span>
                        <span class="error" id="contest_runs_to_msg" style="float:right;">  <?php echo form_error('contest_runs_to'); ?></span>                         
                        </td>
            </tr>
            <tr>
              <td>Enter Prize amount:</td>
              <td>
              	<div class="field">
                    <input type="text" id="prize_amount" name="prize_amount" class="inputmain" value="<?php echo set_value('prize_amount'); ?>"  /> USD<br />
                    <span class="error" id="user_name_msg"><?php echo form_error('prize_amount'); ?></span>
                </div>
              </td>
            </tr>
            
            <tr>
              <td>Parameter of contests:</td>
              <td>
              	<div class="field">
                	<div class="order-this" id="list-capsule">
                        <div class="bulletbox">
                            <span class="bullets">List Item</span>
                            <input type=hidden name="list_id[]" value="" />					
                            <input type="text" value="" class="inputmain d-req etraddmore" name="list_description[]" onfocus="$(this).removeClass('error-border');">
                        </div>
					</div>
                    <input type="text" id="parameter_contests" name="parameter_contests" class="inputmain" value="<?php echo set_value('parameter_contests'); ?>"  /><br />
                    <a class="addmore" href="javascript:void(0);" onclick="addMoreList()">Add more items</a>
                    <span class="error" id="user_name_msg"><?php echo form_error('parameter_contests'); ?></span>
                </div>
                
              </td>
            </tr>
            
            
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="Submit" name="add_contest" id="add_contest" class="btnorange" value="Add New Contest" />
                    <input type="Submit" class="btngrey" value="Cancel" name="cancel" id="cancel" />
                </td>
            </tr>
        </table>
        <?php echo form_close(); ?>
		<?php //} else {?>
		<table border="0" cellspacing="0" cellpadding="0" class="tbldtl add-user">
            <tr>
                <td> </td>
                <td><p>Congratulations! You have successfully added new user.</p>
					<br />
					<p>For adding more user  <?php //echo anchor('home/displayadduserview','click here');?></p>
				</td>
            </tr>
		</table>

		<?php //}?>