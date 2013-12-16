<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<form name="capsuleForm<?php echo $capsule_id?>" id="capsuleForm<?php echo $capsule_id?>">    
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="opinion"></span>Reviews<span class="edit" onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');"></span></a></div>
		<a onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');" href="javascript:void(0);" class="btnorange">Edit</a>
		<div class="editbox opinion">		
			<div class="contentbox">
				<?php if(!empty($capsule_content)){?>
					
					<h5><?php echo $capsule_content['0']['title']?> <span id="rating<?php echo $capsule_id?>" style="float: right;"><script>loadRating('<?php echo $capsule_id?>');</script></span> </h5>
                    <p><?php echo  $capsule_content['0']['description']?></p>
                    
					<?php if(count($capsule_content['options']['positive'])){?>
					<div class="listbox">
                        <div class="titlebar">
                            <h5>Positives</h5>
                        </div>
                        <ul>
                            <?php foreach($capsule_content['options']['positive'] as $option){?>
							<li><span class="arrow"></span><?php echo  $option['title']?></li>
							<?php }?>
                        </ul>
                    </div>
					<?php }?>
                    <?php if(count($capsule_content['options']['negative'])){?>
					<div class="listbox">
                        <div class="titlebar">
                            <h5>Negatives</h5>
                        </div>
                        <ul>
                            <?php foreach($capsule_content['options']['negative'] as $option){?>
							<li><span class="arrow"></span><?php echo $option['title']?></li>
							<?php }?>                            
                        </ul>
                    </div>
					<?php }?>
				<?php }?>
			</div>
		</div>
</form>
</div>