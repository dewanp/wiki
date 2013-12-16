<script type="text/javascript" >

$(document).ready(function(){

/* js code for autocomplete*/
$("#to").fcbkcomplete({json_url: site_url+"message/getHint",addontab: true, maxitems: 10,input_min_size: 2,height: 10,cache: false, newel: false, select_all_text: "",width: 347,filter_selected: true});
/* end js code for autocomplete*/

});
</script>


<div id="wrapper">
	<div class="left-content-main"> <?php echo $sidebar; ?></div> 
	<div class="rightmain">
		<div class="breadcrumb">
			<span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('','Home');?></li>
				<li> <?php  echo $name?></li>
			</ul>
		</div>
		
		<div class="rightinner">

	<form action="<?php echo site_url('message/compose')?>" method="POST">
		<table border="1"  style="width : 90%">
			<tr>
				<td colspan ="2" align="center"><b> New Message</b>  </td>
			</tr>
			<tr>
				<td> To :</td>
				<td> 
				<select id="to" name="to" class="inputmain required">
                <?php if(!empty($tags)){?>
					<?php foreach($tags as $tag){?>
						<?php if($tag){?>
						<option value="<?php echo $tag?>" class="selected"><?php echo $tag?></option>
						<?php }?>
					<?php }?>
				<?php }?>
			</select>		
				
				
					 <?php echo form_error('to'); ?> </td>
					</tr>
			<tr>
				<td>Subject : </td>
				<td><input type="text" name="subject" style="width: 98%" >   <?php echo form_error('subject'); ?></td>
				
			</tr>
			<tr>
				<td> Description :	</td>
				<td> <textarea name="description"  rows="20"  style="width: 98%"></textarea><?php echo form_error('description'); ?></td>
			</tr>
			<tr>
				<td>  </td>
				<td> <input type="submit" value=" Send ">             <input type="submit" value = "Cancel"> </td>
			</tr>
		</table>
	</form>

	</div>
	</div>
	<div class="clear"></div>
</div>


