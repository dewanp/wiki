<?php 
	$capsule_id = isset($capsule_id) ? $capsule_id : "";
	$checked = "";
?>
	<?php for($i=1;$i<=10;$i++){ ?>
		<input name="star2" type="radio" class="wow<?php echo $capsule_id;?>" value="<?php echo $i;?>" <?php if($rate==$i && $rate) {echo 'checked="checked"'; $rate = 11;}?>/>
	<?php }?>

<?php 
	if($edit)
	{ 
		$read_only = "";
	}
	else
	{ 
		$read_only = "readOnly: true,";
	}
?>
<script>
	$('input.wow<?php echo $capsule_id;?>').rating({
		required: true,
		split: 2,
		<?php echo $read_only;?>
		callback: function(value, link){
			ajaxCall('post/applyRating','capsule_id=<?php echo $capsule_id;?>&rate='+value);
			//$('input.wow<?php echo $capsule_id;?>').rating('readOnly',true);
		}
	});
</script>