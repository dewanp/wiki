<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
	<div class="editbtnmain">
		<a href="javascript:void(0);" class="btnedit">
			<span class="list"></span>List Item<span class="edit" onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');"></span>
		</a>
	</div>
		<a onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');" href="javascript:void(0);" class="btnorange">Edit</a>
		<div class="editbox">		
			<div class="contentbox">
			<?php if(!empty($capsule_content)){?>
				<h5><span class="txtorange"><?php echo $capsule_content[0]['title'];?></span></h5>
				<ul style="clear:left">
					<?php foreach($capsule_content as $capsule_list){?>
					<li class="list" id="capsule-list-<?php echo $capsule_list['list_id'];?>">
						<?php echo $capsule_list['description'];?>
					</li>
					<?php }?>
				</ul>
			<?php }?>
			</div>
		</div>
</div>
