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
									$fileName = $capsule_content_row['file_name'];
									$ext = '.' . end(explode('.', $fileName));
									$newName = str_replace($ext, '_700X700'. $ext, $fileName);
									
									$amazon_url = S3_URL.BUCKET_NAME."/";
									$local_file_path = 'uploads/'.$newName;
									$orgnl_file_from_amazon = $amazon_url.$local_file_path;
                                ?>
        
                                <li><a href="<?php echo $orgnl_file_from_amazon;?>"><img src="" alt="" width="113" height="72" class="image<?php echo $r?>" id="gallery-<?php echo $capsule_content_row['file_upload_id'];?>"/></a> </li>
                                <script> showImagePath('<?php echo $capsule_content_row["file_upload_id"]?>','113','72','gallery-<?php echo $capsule_content_row["file_upload_id"]?>')</script> 
        
                               
                                <?php } ?>
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
			<div class="thumb left"> <a href="<?php echo site_url('post/show/image/'.$capsule_image['image_id'])?>" id="capsule-img-<?php echo $capsule_image['file_upload_id']?>"><script> showImage('<?php echo $capsule_image["file_upload_id"]?>','123','100','capsule-img-<?php echo $capsule_image["file_upload_id"]?>');</script></a></div>
			<div>
			<?php echo anchor('post/show/image/'.$capsule_image['image_id'],$capsule_image['title'])?>
			</div>
		</div>
        </div>		
	<?php }?>
<?php }?>	
<?php }?>