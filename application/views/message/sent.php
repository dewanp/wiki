<div id="wrapper">
    <div class="left-content-main">     <?php echo $sidebar; ?>   </div>
    <div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li><?php echo anchor('user/feeds','Home'); ?></li>
                <li><a href="javascript:void(0);">Message</a></li>
                <li><a href="javascript:void(0);" class="active">Sent</a></li>
            </ul>
        </div>
        <div class="rightinner">
            <div class="messagesec">
                <div class="topbar">
                    <div class="mstabs">
                        <ul>
                            <li><?php echo anchor('message/inbox','Inbox'); ?></li>
                            <li><?php echo anchor('message/sent','Sent','class="active"'); ?></li>
                            <li><?php echo anchor('message/archive','Archive'); ?></li>
                        </ul>
                    </div>
                    <a href="javascript:void(0);" class="btngrey" onclick="popupClear();  openPopDiv('new-message');">Post a new message</a> </div>
                <div class="msgmid">
                    <div class="msgleft realtive">
                        <div class="msgsort">
                            <div class="dropdown">
                               <form action="" method="get">
                                <label class="">Sort by</label>
                                <select name="sort" class="" id="" size="1" onchange="this.form.submit();">
                                    <option value="mm.time" <?php echo $sort=='mm.time'?'selected="selected"':''?>>Date Received</option>
                                    <option value="mm.subject" <?php echo $sort=='mm.subject'?'selected="selected"':''?>>Subject</option>
									<option value="u.user_name" <?php echo $sort=='u.user_name'?'selected="selected"':''?>>User Name </option>
                                </select>
                                <label class="">Order by</label>
                                <select name="order" class="" id="" size="1" onchange="this.form.submit();">
                                    <option value="asc" <?php echo $order=='asc'?'selected="selected"':''?>>ASC</option>
                                    <option value="desc" <?php echo $order=='desc'?'selected="selected"':''?>>DESC</option>								
                                </select>
                                </form>
                            </div>
                        </div>
                        <div class="updates" id="scroll-1">
                            <ul class="upd">
								<?php foreach($res as $row){  ?>
								    <li id="li<?php echo $row['message_id'];?>" onclick="showMessage('<?php echo $row['message_id']; ?>','sentitem')"  >
									 <span class="cols">
											<span class="txt">
												<a href="javascript:void(0)" id="<?php echo $row['message_id']; ?>" onclick="showMessage('<?php echo $row['message_id']; ?>','sentitem')">
   											    <?php echo htmlentities($row['subject']); ?>
												</a> 
											</span>
											<span class="from">To:
												 <?php 
														$to_name = explode(',',$row['user_name']);
														
														$userarray = array();
														foreach($to_name as $username)
														{
														  $userarray[]= anchor($username,  $username);
														}
														
														echo implode(" , ",$userarray);
												 ?> 
											</span>
											<span class="dt">						 
												 <?php echo int_to_date($row['time']) ;  ?> 
											</span>
									  </span>
								</li>
						<?php } ?>
                                <!-- Sent message i.e. subject, from and time -->
                            </ul>
                        </div>
                        <div class="msgbot"></div>
                    </div>
                    <div class="msgright" id="description">
                       <!-- send - description comes here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

