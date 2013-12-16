<?php if($capsule_data['is_gallery']){?>
	<?php if(!empty($capsule_content)){?>
        <!--Gallery : Start-->
        <div class="gallerymain">
            <div class="galleryinner">
                <div id="gallery" class="ad-gallery">
                    <div class="ad-image-wrapper"></div>
                    <div class="ad-nav">
                        <div class="ad-thumbs">
                            <ul class="ad-thumb-list">
                                <?php 
                                foreach($capsule_content as $r =>$capsule_content_row)
                                {
                                ?>
        
                                <li><a href="<?php echo $capsule_content_row['file_path'];?>"><img src="<?php echo $capsule_content_row['file_path'];?>" alt="" width="113" height="72" class="image<?php echo $r?>"/></a> </li> 
        
                                <!-- <li> <a href="images/album-img/img-1.jpg"> <img src="images/album-thumb/img-1.jpg" alt="" class="image0"/> </a> </li> -->
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(function() {
            
            var galleries = $('.ad-gallery').adGallery();	
            
          });
        </script>
        <!--Gallery : End-->
    <?php }?>
<?php }else{?>
	<?php if(!empty($capsule_content)){?>
	<?php foreach($capsule_content as $capsule_image){?>
		
	<div class="imageedit">
		<div class="contentbox contentbox2">
			<div class="thumb left" id="capsule-img-<?php echo $capsule_image['file_upload_id']?>"><script> showImage('<?php echo $capsule_image["file_upload_id"]?>','123','100','capsule-img-<?php echo $capsule_image["file_upload_id"]?>');</script></div>
			<div>
			<?php echo $capsule_image['title']?>
			<p><?php echo  $capsule_image['description']?></p>			
			</div>
		</div>
        </div>		
	<?php }?>
<?php }?>	
<?php }?>