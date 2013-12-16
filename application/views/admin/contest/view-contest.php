<div id="wrapper">
    <div class="container">
        <div class="breadcrumb"> </div>
        <div class="contestmain">
            <div class="maintitle">
                <h1>View Contest</h1>
                <div class="btnbox"> <a href="home/displayaddcontest" class="btnorange"><span class="add-icon"></span>Create new contest</a></div>
            </div>
            <?php if(!empty($contest_detail)){ ?>            
            <div class="showcomment preview">
                
                <div class="contentbox" style="width:945px;">
                     
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
                                <?php echo $contest_detail['title']; ?>
                            </span>
                            <a href="home/contestviewdetail/<?php echo $contest_detail['contest_id'];?>" class="viewlink">View Details</a>
                        </h4>
                        
                        <div class="text">
                           		<?php echo $contest_detail['description']; ?>
                        </div>
                    </div>
                    
                   
					<?php if(isset($contest_detail) && $contest_detail['status'] == 1 && $contest_detail['is_deleted'] == 0 ){?>
                            <div class="icons" style="min-height:165px;">
                                <a href="home/contestedit/<?php echo $contest_detail['contest_id'];?>" class="edit-con">Edit Details</a> 
                                <a href="home/contestviewdetail/<?php echo $contest_detail['contest_id'];?>/#winners-list" class="win">Select Winners</a> 
                               
                                <a class="close-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Close Contest</a>
                                <div class="adl"><a class="btnorange" onClick="contestClose('<?php echo $contest_detail['contest_id']?>', '0','Close');">Yes</a></div>
                                
                                <div>
                                    <a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Delete Contest</a>
                                    <div class="adl"><a class="btnorange" onClick="contestDelete('<?php echo $contest_detail['contest_id']?>');">Yes</a></div>
                                </div>
                                
                            </div>  
                    <?php }?>
                    
                    <?php if(isset($contest_detail) &&  $contest_detail['status'] == 0 && $contest_detail['is_deleted'] == 0){?>                     
                            <div class="icons" style="min-height:165px;">
                                <a class="close-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Open Contest</a>
                                <div class="adl"><a class="btnorange" onClick="contestClose('<?php echo $contest_detail['contest_id']?>', '1','Open');">Yes</a></div>
                                
                                <div>
                                    <a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Delete Contest</a>
                                    <div class="adl"><a class="btnorange" onClick="contestDelete('<?php echo $contest_detail['contest_id']?>');">Yes</a></div>
                                </div>
                            </div>
                    <?php }?>
                    
                    <?php if(isset($contest_detail) && $contest_detail['is_deleted'] == 1 ){?>                     
                            <div class="icons" style="min-height:165px;">
                                <a class="close-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Restore Contest</a>
                                <div class="adl"><a class="btnorange" onClick="contestRestore('<?php echo $contest_detail['contest_id']?>');">Yes</a></div>
                            </div>
                    <?php }?>
                    
                    
                     
                    <div class="btnbox">
                        <div class="field">
                            <label for="txtF01" class="infield"></label>
                            <input type="text" id="txtF01" class="inputmain" 
							<?php if($contest_detail['status']== 0 && $contest_detail['is_deleted'] == 0){?> 
                            		value="Contest Over"
                             <?php }if($contest_detail['status']== 1 && $contest_detail['is_deleted'] == 0){?> 
                             		value="Now Running"
                             <?php }if($contest_detail['is_deleted'] == 1){?>
                             		value="Contest Deleted"
                             <?php }?>
                            readonly="readonly"/>
                        </div>
                        
                        <div class="field">
                            <label for="txtF2" class="infield">Prize: $100.00</label>
                            <input type="text" id="txtF2" class="inputmain" 
							<?php if(!empty($contest_detail['prize'])){?> value="Prize: $<?php echo number_format($contest_detail['prize'],2);?>" <?php }else{?> value="Prize: $000" <?php }?> 
                            readonly="readonly"/>
                        </div>
                        <a href="home/contestviewdetail/<?php echo $contest_detail['contest_id'];?>/#winners-list" class="btnorange" style="margin:0!important;">Winners list</a>
                </div>
                        
                        
                </div>
            </div>
            <?php }else{?>
            	<div>No Details are available for this contest.</div>
            <?php }?>      
        </div>
    </div>
    <div class="clear"></div>
</div>
