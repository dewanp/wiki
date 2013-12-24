<?php 
	$post_id = isset($post_id) ? $post_id : "";
	$checked = "";
	?>
	<?php for($i=1;$i<=5;$i++){?>
		<input name="star1" type="radio" class="wow<?php echo $post_id;?>" value="<?php echo $i;?>" <?php if((int)$rate==$i && $rate) {echo 'checked="checked"'; $rate = 6;}?>/>
	<?php } ?>
<?php 
	if($edit)
	{ 
		$read_only = "";
	}else{ 
		$read_only = "readOnly: true,";
	}
?>
<script type="text/javascript">
	$('input.wow<?php echo $post_id;?>').rating({
		required: true,
		split: 1,
		<?php echo $read_only;?>
		callback: function(value, link){
			ajaxCall('post/applyRatingPost','post_id=<?php echo $post_id;?>&rate='+value+'&ip_address='+'<?php echo $ip_address;?>');
		}
	});
</script>