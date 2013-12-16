<div id="capsule-container">		
		<?php if(!empty($post_capsules)){?>
			<?php foreach($post_capsules as $post_capsule){ ?>
				<div id="capsule-wrapper-<?php echo $post_capsule['capsule_id']?>" class="capsule">
					<div class="capsule-content-<?php echo $post_capsule['capsule_id']?>">					
						<div class="content"></div>
					</div>					
				</div>
				<script type="text/javascript">
					capsuleContent('<?php echo $post_id?>','<?php echo $post_capsule["capsule_id"]?>','editblock');
				</script>
			<?php }?>
		<?php }?>				
</div>