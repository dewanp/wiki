<?php //echo'<pre>'; print_r($contest_detail);?>
<div id="wrapper">
    <div class="container">
        <div class="breadcrumb"> </div>
        <div class="contestmain">
            <div class="maintitle">
                <h1>View Contest</h1>
                <div class="btnbox"> <a href="add-new-contest.html" class="btnorange"><span class="add-icon"></span>Create new contest</a></div>
            </div>
            <?php if(!empty($contest_detail)){ ?>
            <?php //echo'<pre>'; print_r($contest_detail);exit;?>
            <div class="showcomment preview">
                <div class="contentbox" style="width:945px;">
                    <div class="col-thumb">
                        <div class="thumb left" id="thumb-left">
							<?php if($contest_detail["contest_image"] == ''){?>
                                <img src="images/contest-img.png" alt="" />
                            <?php }else{?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        showImage('<?php echo $contest_detail["contest_image"];?>', '100','100','thumb-left');
                                    });
                                </script>
                             <?php }?>
                        </div>
                    </div>
                    <div class="rightdtls">
                        <h4><span class="title">
						<?php $title = (strlen($contest_detail['title'])<50)?$contest_detail['title']:substr($contest_detail['title'],0,50)."...." ;?>
						<?php echo $title; ?></span> <a href="home/contestViewDetail/<?php echo $contest_detail['contest_id'];?>" class="viewlink">View Details</a></h4>
                        <div class="text">
                           <?php echo $contest_detail['description']; ?>
                        </div>
                    </div>
                    <div class="icons" style="min-height:165px;">
                    <?php if($contest_detail['status'] == 1){?>
                    		<a href="home/contestEdit/<?php echo $contest_detail['contest_id'];?>" class="edit-con">Edit Details</a> 
                            <a href="javascript:void(0);" class="win">Select Winners</a> 
                            <a href="javascript:void(0);" class="close-cont">Close Contest</a> 
                    <?php }?>        
                            <a href="javascript:void(0);" class="del-cont" <?php if($contest_detail['status'] == 0){?> style="margin-top:123px;" <?php }?> onClick="contestDelete('<?php echo $contest_detail['contest_id']?>');">Delete Contest</a>
                    </div>
                    <div class="btnbox">
                        <div class="field">
                            <label for="txtF01" class="infield">  </label>
                            <input type="text" id="txtF01" class="inputmain" <?php if($contest_detail['status']==0){?> value="Contest Over" <?php }else{?> value="Now Running" <?php }?> readonly="readonly"/>
                        </div>
                        <div class="field">
                            <label for="txtF2" class="infield">Prize: $100.00</label>
                            <input type="text" id="txtF2" class="inputmain" <?php if(!empty($contest_detail['prize'])){?> value="Prize: $<?php echo number_format($contest_detail['prize'],2);?>" <?php }else{?> value="Prize: $000" <?php }?> readonly="readonly"/>
                        </div>
                        <a href="javascript:void(0);" class="btnorange" style="margin:0!important;">Winners list</a> </div>
                </div>
            </div>
            <?php }else{?>
            	<div>No Details are available for this contest.</div>
            <?php }?>      
        </div>
    </div>
    <div class="clear"></div>
</div>