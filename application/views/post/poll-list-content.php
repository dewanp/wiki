<!--[if lt IE 8]><style>
.searchdtl.thumbview .sdleft .thumb span {
    display: inline-block;
    height:65%;
}
</style><![endif]-->
<?php if(!empty( $polls)){?>
<div class="thumbview-rows">
	<?php
	$exist_post = array();
	$count = 0; 
	foreach($polls as $poll)
	{ 
	
		if(array_key_exists($poll['post_id'], $exist_post)){
			$p_url = $exist_post[$poll['post_id']];
		}else{
			$p_url = getPostUrl($poll['post_id']);	
			$exist_post[$poll['post_id']] = $p_url;
		}
	?>
    
		<div class="searchdtl thumbview">
        
			<div class="sdleft" style="cursor:pointer;" onClick="window.location.href='post/show/poll/<?php echo $poll['capsule_id']?>'">
				
                <div  style="height:120px; width:148px;">
					<b><a href="post/show/poll/<?php echo $poll['capsule_id'];?>" title="<?php echo $poll['title']; ?>"><?php echo $title = (strlen($poll['title'])<30)? $poll['title']: trim(substr($poll['title'],0,30))."..." ;?></a></b>
					<p><b> Description :</b> 
					<?php echo $description = (strlen($poll['description']) <70)?	$poll['description']: trim(substr($poll['description'],0,70))."..." ;	?></p>
				</div>
                
			</div>
            
			<div class="sdright">
				<div class="by">
                    <b>Posted By:</b> 
                    <a href="<?php echo site_url($poll['user_name'])?>"><?php if($poll['profile_name']) echo $poll['profile_name']; else echo $poll['user_name'];?></a>
                </div>
				<?php echo anchor($p_url,'View Entire Post','class="btngrey"');?>
			</div>
		</div>
	<?php 
		$count++;
		if($count%4 == 0 && $count<count($polls))
		{
			echo '</div><div class="thumbview-rows">';
		}
	}
	?>
</div>
<?php }else{?>
		<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
<?php }?>