<div id="capsule-container">		
		<?php if(!empty($post_capsules)){ ?>
			<?php foreach($post_capsules as $key=>$post_capsule){ ?>
				<div id="capsule-wrapper-<?php echo $post_capsule['capsule_id']?>" class="capsule">
					<div class="capsule-content-<?php echo $post_capsule['capsule_id']?>">					
						<div class="content"></div>
					</div>					
				</div>
				<?php if($key == 0 || $key ==(count($post_capsules)-2)){ ?>
				<div>
					<div>
						<div id="google-ad-<?php echo $post_capsule['capsule_id']?>"></div>
					</div>
					<script> 
						setTimeout('addgoogle("google-ad-<?php echo $post_capsule['capsule_id']?>")',100);
					</script>
				</div>
				<?php }?>
				
				<script type="text/javascript">
					capsuleContent('<?php echo $post_id?>','<?php echo $post_capsule["capsule_id"]?>','view');
				</script>
				
			<?php }?>
		<?php }?>				
</div>