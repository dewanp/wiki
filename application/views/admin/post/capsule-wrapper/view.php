<div id="capsule-container">		
		<?php if(!empty($post_capsules)){ ?>
			<?php foreach($post_capsules as $key=>$post_capsule){ ?>
				<div id="capsule-wrapper-<?php echo $post_capsule['capsule_id']?>" class="capsule">
					<div class="capsule-content-<?php echo $post_capsule['capsule_id']?>">					
						<div class="content"></div>
					</div>					
				</div>
				<script type="text/javascript">
					capsuleContent('<?php echo $post_id?>','<?php echo $post_capsule["capsule_id"]?>','view');
				</script>
				<?php if($key == 0 || $key ==(count($post_capsules)-2)){ ?>
				<div class="gallerymain" style="min-height:10px;">
					<div id="galleryinner google-ad-<?php echo $post_id;?>"></div>
					<script>
						//google_ad_client = $("#google_ad_client_val").html();
						//googleAd('galleryinner google-ad-<?php echo $post_id;?>',google_ad_client);
					</script>
				</div>
				<?php }?>
			<?php }?>
		<?php }?>				
</div>