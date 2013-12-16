<div id="content-edit-<?php echo $capsule_id?>" class="showcomment showcomment2">
<div class="editbtnmain">
		<a href="javascript:void(0);" class="btnedit">
			<span class="comm"></span>Comments</span>
		</a>
</div>

<div class="commnav">
	<ul>
		<li><a href="javascript:void(0);" onclick="showHideComment($(this),'<?php echo $capsule_id?>');" rel="<?php if($capsule_data['is_comment']){?>0<?php }else{?>1<?php }?>"><?php if($capsule_data['is_comment']){?>Hide Comment<?php }else{?>Show Comment<?php }?></a></li>		
	</ul>
</div>
</div>