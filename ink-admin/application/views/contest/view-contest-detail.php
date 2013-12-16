<div id="wrapper">
    <div class="container">
        <div class="breadcrumb">
           
        </div>
        <?php $attributes = array('id' => 'savewinners'); ?>
        <?php echo form_open('home/savewinners',$attributes);?>
        <div class="add-contest">
            <div class="maintitle">
                <h1>View and Edit Contest 
                <span class="icons">
                    
                   
                    <?php if($contest_detail['status'] == 1 && $contest_detail['is_deleted'] == 0){?>
                    		<a href="javascript:void(0);"  onclick="document.getElementById('savewinners').submit();" class="save-cont">Save this</a>                  		
                            <a class="close-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Close Contest</a>
                            <div class="adl"><a class="btnorange" onClick="contestClose('<?php echo $contest_detail['contest_id']?>', '0','Close');">Yes</a></div>
                            
                            <div style="display:inline;">        
                                <a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')" style="margin-left:10px;">Delete Contest</a>
                                <div class="adl"><a class="btnorange" onClick="contestDelete('<?php echo $contest_detail['contest_id']?>');">Yes</a></div> 
                            </div>
                            
                    <?php }?>
                    <?php if($contest_detail['status'] == 0 && $contest_detail['is_deleted'] == 0){?>
                    
                    		<a href="javascript:void(0);"  onclick="document.getElementById('savewinners').submit();" class="save-cont">Save this</a>
                            <a class="close-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Open Contest</a>
                            <div class="adl"><a class="btnorange" onClick="contestClose('<?php echo $contest_detail['contest_id']?>', '1','Open');">Yes</a></div>
                            
                            <div style="display:inline;">        
                                <a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')" style="margin-left:10px;">Delete Contest</a>
                                <div class="adl"><a class="btnorange" onClick="contestDelete('<?php echo $contest_detail['contest_id']?>');">Yes</a></div> 
                            </div>
                    <?php }?>
                    <?php if($contest_detail['is_deleted'] == 1){?>
                    		<div style="display:inline;">        
                                <a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')" style="margin-left:10px;">Restore Contest</a>
                                <div class="adl"><a class="btnorange" onClick="contestRestore('<?php echo $contest_detail['contest_id']?>');">Yes</a></div> 
                            </div>
                    <?php }?>
                    
                           
                </h1>
            </div>
            <?php if(!empty($contest_detail)){ ?>
            <div class="contestmain view-contest">
                <div class="showcomment preview">
                    <div class="contentbox" style="width:945px;">
                        <div class="btnbox">
                            <div class="field">
                                <label for="txtF01" class="infield">Contest over</label>
                                <input type="text" id="txtF01" class="inputmain" <?php if($contest_detail['status']==0){?> value="Contest Over" <?php }else{?> value="Now Running" <?php }?> readonly="readonly" />
                            </div>
                            <div class="field">
                                <label for="txtF2" class="infield">Prize: $100.00</label>
                                <input type="text" id="txtF2" class="inputmain" <?php if(!empty($contest_detail['prize'])){?> value="Prize: $<?php echo number_format($contest_detail['prize'],2);?>" <?php }else{?> value="Prize: $000" <?php }?> readonly="readonly"/>
                            </div>
                            <a href="home/contestviewdetail/<?php echo $contest_detail['contest_id'];?>/#winners-list" class="btnorange">Winners list</a> </div>
                        <div class="viewdtls">
                            <div class="col-thumb">
                                <div class="thumb left" id="thumb-left">
                                	
									<?php if($contest_detail['contest_image'] == 0 ){?>
                                        
                                        <img src="images/contest-img.png" alt="No Image" />
                                        
                                    <?php }elseif(isset($contest_detail['contest_image']) && $contest_detail['contest_image'] != 0){?> 
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    showImage('<?php echo $contest_detail["contest_image"];?>', '100','100','thumb-left');
                                                });
                                            </script>
                                    <?php }?>
                               </div>
                            </div>
                            <div class="rightdtls">
                                <h4>
                                <span class="title">
                                <?php $title = (strlen($contest_detail['title'])<50)?$contest_detail['title']:substr($contest_detail['title'],0,50)."...." ;?>
                                <?php echo $title; ?>
                                </span> <span class="icons"><a href="home/contestedit/<?php echo $contest_detail['contest_id'];?>" class="edit-con">Edit Details</a></span></h4>
                                <div class="text">
                                    <?php echo $contest_detail['description']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w100per">               
                    <p><strong>Parameters of the contest:</strong></p>
                    <ul class="para-list">
						<?php foreach($contest_detail['parameters'] as $key=>$value){?>
                            <li><?php echo $value; ?></li>
                        <?php }?>
                    </ul>
                </div>
                
                <div class="winner-list wedit" id="winners-list">              
                    <p><strong>List of winners</strong></p>
                    <?php if(!empty($contest_detail['winners'] )){?>
                    <?php //echo'<pre>'; print_r($contest_detail['winners']);exit;?>
                    
                    	<ul class="para-list" id="para-list">
                        	
							<?php foreach($contest_detail['winners'] as $conkey => $conval){?>
                            
							<?php foreach ($conval as $userid => $postid){  //echo $postid; ?>
								<li> 
                                	<select class="" size="1" id="user-selectlist-1" onchange="getUsersPost(this.value, this.id);" name="userSelectlist[]">
                                        <option value="0">Select an exiting user of Inksmash</option>
                                        <?php foreach($manage_user as $key => $value){?>
                                            <option <?php if($userid == $value['user_id']){?>  selected="selected" <?php }?> value="<?php echo $value['user_id']?>"><?php echo $value['profile_name']?></option>
                                        <?php }?>
                            		</select>
                                </li>
                                
                                <li>
                                	<select  class="" size="1" id="user-postlist-1" name="userPostlist[]">
                                        <option>Select the title of the post from the user which won</option>
                                    <?php 
										$rs_posts = $this->db->select('p.*')
																	 ->from('post as p')									 									 
																	 ->where('p.user_id' ,$userid)
																	 ->where('p.is_active' ,1)
																	 ->where('p.is_block' ,0)
																	 ->group_by('p.post_id')
																	 ->order_by("p.created_date", "desc")
																	 ->get();
										
										$result = $rs_posts->result_array();
										//print_r($result);
										foreach($result as $posts){?>
                                        <?php //echo $postid ;?>
											<option <?php if($postid == $posts['post_id']) {?> selected="selected" <?php }?> value="<?php echo $posts['post_id']; ?>"><?php echo $posts['title']?></option>
										<?php }?>
                                        </select>
                                    	<a class="minus-icon" href="javascript:void(0);" onclick="removeli_userpost('<?php echo $userid;?>', <?php echo $postid; ?>);"></a>
                                    	<div class="adl"><a class="btnorange" onclick="removeli_userpost('<?php echo $userid;?>', <?php echo $postid; ?>);">Yes</a></div>
                                        
                                    	<a class="add-icon" onclick="addli_userpost(); designerSelect();" href="javascript:void(0);" hidefocus="true" style="outline: medium none;"></a>
                                </li>
                                <?php }?>
                                
                            <?php }?>    
                        </ul>
                    <?php }?>
                </div>
                
            </div>
            
            <?php } else{?>
            		<div>No Details are available for this contest.</div>
            <?php }?>
            
        </div>
        <input type="hidden" name="contest_id" id="contest_id" value="<?php echo $contest_detail['contest_id']; ?>" />
        <?php echo form_close(); ?>
    </div>
    <div class="clear"></div>
</div>