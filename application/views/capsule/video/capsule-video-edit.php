<div id="content-add-<?php echo $capsule_id?>" class="showcomment showcomment2">
	<div class="editbtnmain"><a href="javascript:void(0);" class="btnedit"> <span class="video"></span>Video<span class="edit" onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');"></span></a></div>


<div class="infoboxmain">
	<div class="infobox">
		<span class="value" id="total-uploaded"><?php echo count($capsule_content);?></span>
		<span class="txtinfo">Uploaded</span>
	</div>
	<div class="infobox">
		<span class="value" id="total-allowed">5</span> 
		<span class="txtinfo">Allow</span>
	</div>
</div>

<?php if($capsule_data['mandatory'] == 0){ ?>
        <a href="javascript:void(0)" onclick="prepareConfirmPopupCapsule(this,'Are you sure?')" class="image-orange" title="Delete Video"></a><div class="adl"><a href="javascript:void(0)" onclick="capsuleDelete('4','<?php echo $capsule_id?>','<?php echo $post_id?>')" class="btnorange">Yes</a></div>
        <?php }?>


<a onclick="capsuleContent('<?php echo $post_id?>','<?php echo $capsule_id?>','update');" href="javascript:void(0);" class="btnorange">Edit Videos</a>
<div class="editbox">
	<div id="files-<?php echo $capsule_id?>">
		<?php if(!empty($capsule_content)){?>
			<?php foreach($capsule_content as $capsule_video){?>
            <?php $video_base_path = S3_URL.BUCKET_NAME.'/uploads/'.$capsule_video['file_path'];?>
			<?php //$video_base_path = str_replace("./",site_url(),$capsule_video['file_path']);?>
				<div class="imageedit video2" id="uploaded-img-<?php echo $capsule_video['file_upload_id']?>"><div class="thumb"><div id="mediaplayer-<?php echo $capsule_video['file_upload_id']?>"></div></div><div id="capsule-img-<?php echo $capsule_video['file_upload_id']?>"><script type="text/javascript">
				jwplayer("mediaplayer-<?php echo $capsule_video['file_upload_id']?>").setup({flashplayer: "jwplayer/player.swf",file: "<?php echo $video_base_path?>",width:200,height:150,image: "<?php echo $video_base_path?>.jpg"});
				</script></div><div class="image-right"><div class="img-title"><?php echo $capsule_video['title']?></div>
                <div class="img-delete">
				</div></div></div>
			<?php }?>
		<?php }?>
	</div>
</div>
</div>