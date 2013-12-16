<ul>
<?php foreach($post_capsules as $post_capsule){?>
		<li class="<?php echo $post_capsule['capsule_name']?> sidebar-capsule">
			<a href="javascript:void(0);"><span class="<?php echo $post_capsule['capsule_name']?>"></span><?php  echo ucfirst($post_capsule['capsule_name']=='opinion'?'reviews':$post_capsule['capsule_name']);?>
			<input type="hidden" name="capsule_id[]" value="<?php echo $post_capsule['capsule_id']?>" />
			<?php if(!$post_capsule['mandatory']){?>					                  
                    <span class="del" onClick="prepareConfirmPopupCapsule(this,'Are you sure for delete?')"></span>
			<?php }?>
			</a>
            <?php if(!$post_capsule['mandatory']){?>
                <div class="adl"><a href="javascript:void(0)" onclick="capsuleDelete('<?php echo $post_capsule['capsule_type_id']?>','<?php echo $post_capsule['capsule_id']?>','<?php echo $post_id?>')" class="btnorange">Yes</a></div>	
            <?php }?>
		</li>
<?php }?>	
</ul>