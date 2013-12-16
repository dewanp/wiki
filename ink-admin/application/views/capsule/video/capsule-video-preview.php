<script>
function showvideo(id,file_path){
		jwplayer(id).setup({flashplayer: "jwplayer/player.swf",file: file_path,width:699,height:400});
	}
</script>
<!--Gallery : Start-->
<?php //echo "<pre>"; print_r($capsule_content);echo "</pre>";?>
<?php if(!empty($capsule_content)){?>
<div class="gallerymain" id="video-container-<?php echo $capsule_content[0]['capsule_id']?>">
	<div class="galleryinner">
		<div id="gallery" class="ad-gallery">
			<div class="ad-image-wrapper" id="cur-video-id-<?php echo $capsule_content[0]['capsule_id']?>"></div>
			<div class="ad-nav">
				<div class="ad-thumbs">
					<ul class="ad-thumb-list">
						<?php foreach($capsule_content as $r =>$capsule_content_row){?>
                        	<?php if($capsule_content_row['type']== 'video/youtube'){?>						
								<li><a id="video-thumb-<?php echo $r?>" href="javascript:void(0);" onclick="showvideo('cur-video-id-<?php echo $capsule_content_row['capsule_id']?>','<?php echo $capsule_content_row['file_path'];?>')"><img src="http://img.youtube.com/vi/<?php echo $capsule_content_row['file_name'];?>/1.jpg" alt="" width="113" height="72" class="image<?php echo $r?>"/></a> </li> 
							<?php }else{?>
                            	<li><a id="video-thumb-<?php echo $r?>" href="javascript:void(0);" onclick="showvideo('cur-video-id-<?php echo $capsule_content_row['capsule_id']?>','<?php echo site_url($capsule_content_row['file_path']);?>')"><img src="<?php echo $capsule_content_row['file_path'];?>.jpg" alt="" width="113" height="72" class="image<?php echo $r?>"/></a></li>
                            <?php }?>
						<?php }	?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function() {
    
	var galleries = $('.ad-gallery').adGallery();	
    $("#video-container-<?php echo $capsule_content[0]['capsule_id']?> #video-thumb-0").trigger('click');
  });
</script>
<!--Gallery : End-->
<?php }?>