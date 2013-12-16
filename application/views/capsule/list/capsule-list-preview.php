<div class="showcomment preview" id="content-preview-<?php echo $capsule_id?>">
<h4><span class="list-icon"></span>List Item</h4>
	<div class="contentbox">
	<?php if(!empty($capsule_content)){?>
		<h5><span class="txtorange"><?php echo  $capsule_content[0]['title'];?></span></h5>
		<ul>
		<?php foreach($capsule_content as $capsule_list){?>
			<li class="list" id="capsule-list-<?php echo $capsule_list['list_id'];?>">
				<?php echo $capsule_list['description'];?>
			</li>
		<?php }?>
		</ul>
	<?php }?>
	</div>
</div>