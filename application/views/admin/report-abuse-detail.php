<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Report Abuse</h1>
			<?php  if(!empty($abuse_list)){?>
			<div class="btnbox btnbox2">
				<a href="<?php echo $redirect_url;?>" class="btnorange" style="padding-left:15px; ">Back</a>
				<a href="javascript:void(0);" onClick="blockPosts('<?php echo $post_id?>');" class="btnorange" style="padding-left:15px;margin-left: 12px;">Block Post</a>
				<a href="javascript:void(0);" onClick="resumeBlockedPosts('<?php echo $post_id?>');" class="btnorange" style="padding-left:15px;margin-left: 12px;">Not an abuse</a>
			</div>
			<?php } ?>
		</div>
       <?php //echo '<pre>';print_r($abuse_list);exit;?>
		
        <div class="grid grid5">
            <div class="clear"></div>
        <?php  if(!empty($abuse_list)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Post Title</th>
					<th>Reported by</th>
                    <th class="textcenter">Comments</th>
                    <th>Reported on</th>
                </tr>
                <?php $i=0; foreach($abuse_list as $row) {
					if($i%2==0)
					{ $class_alt = "class = 'alt' ";	}
					else
					{ $class_alt = "";	}
				?>
                <tr <?php echo $class_alt ;?>>
	                <td >
						<?php echo anchor('home/editpost/'.$row['post_id'],$row['title']); ?>
					</td>
					<td ><?php echo $row['email']; ?></td>
                    <td class="textcenter" ><?php echo $row['message'];?></td>
                    <td ><?php echo date('F j, Y, g:i a',$row['time']); ?></td>
                </tr>
                <?php $i++; }?>
            </table>
			<?php }else{ ?>
			<div class="noresult" >There is no report abuse for any post.</div>
			<?php }?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--Wrapper End--> 