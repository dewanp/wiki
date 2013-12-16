<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Report Abuse</h1>
		</div>
		
        <div class="grid grid5">
            <div class="clear"></div>
        <?php  if(!empty($abuse_list)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Post Title</th>
					<th>Report Count</th>
					<th>Detail</th>
                    <!-- <th>Reported by</th>
                    <th class="textcenter">Comments</th>
                    <th>Reported on</th> -->
                    <th style="text-align: right;">Action</th>
                </tr>
                <?php $i=0; foreach($abuse_list as $row) {
					if($i%2==0)
					{ $class_alt = "class = 'alt' ";	}
					else
					{ $class_alt = "";	}
				?>
                <tr <?php echo $class_alt ;?>>
	                <td >
						<?php echo anchor('admin/editpost/'.$row['post_id'],$row['title']); ?>
					</td>
					<td ><?php echo $row['report_count']; ?></td>
					<td ><?php echo anchor('admin/reportabusedpost/'.$row['post_id'],'View Detail'); ?></td>
                    <!-- <td ><?php echo $row['email']; ?></td>
                    <td class="textcenter" ><?php echo $row['message'];?></td>
                    <td ><?php echo date('d-m-y',$row['time']); ?></td> -->
                    <td ><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li><?php echo anchor('admin/editpost/'.$row['post_id'], 'View'); ?></li>
                                        <li><?php echo anchor('admin/viewpostmultimedia/'.$row['post_id'], 'View Multimedia');?>
										</li>
                                        <li><a href="javascript:void(0);" onClick="blockPosts('<?php echo $row['post_id']?>');">Block post</a></li>
                                        <!-- <li><a href="javascript:void(0);">Delete post</a></li> -->
                                    </ul>
                                </div>
                                <div class="mpbot"></div>
                            </div>
                            <a href="javascript:void(0);" class="arrowpost"></a></div></td>
                </tr>
                <?php $i++; }?>
            </table>
			<?php }else{ ?>
			<div class="noresult" >There is no report abuse for any post.</div>
			<?php }?>
        </div>
		
        <!-- Pagination Region : Start -->
        <div class="pagination-region">
            <div class="rleft"><span class="left"></span></div>
            <div class="paginationdiv">
                <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
            </div>
        </div>
        <!-- Pagination Region : End --> 
    </div>
    <div class="clear"></div>
</div>
<!--Wrapper End--> 