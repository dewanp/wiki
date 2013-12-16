<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Manage Content</h1>
            <?php echo anchor('admin/allblockedposts','View blocked posts','class="viewlink"'); ?>
			<?php echo anchor('admin/reportabuselist','View reported abuse posts','class="viewlink"'); ?>
		</div>
        <div class="search">
            <div class="field">
                <form action="<?php echo site_url('admin/managecontent');?>" name="serach_post_by_title" method="get">
                    <label for="search" class="infield">Search within your posts</label>
                    <input name="search" type="text" id="search" class="inputmain" value="<?php echo $this->input->get('search','Search within your posts')?>" />
                    <input type="submit" class="icon" value="" style="border:none;">
                </form>
            </div>
        </div>
		
        <div class="grid grid5">
            <div class="clear"></div>
        <?php  if(!empty($all_posts)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Post Title</th>
                    <th>Posted by</th>
                    <th>Posted on</th>
                    <th>Last edit on</th>
                    <th class="textcenter">Comments</th>
                    <th class="textcenter">Hits</th>
                    <!-- <th>Rating</th>
                    <th>Reported abuses</th> -->
                    <th>Action</th>
                </tr>
                <?php $i=0; foreach($all_posts as $row) {
							if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
							 ?>
                <tr <?php echo $class_alt ;?>>
	                <td>
						<?php $title = (strlen($row['title'])<50)?$row['title']:substr($row['title'],0,50)."...." ;?>
						<?php echo anchor('admin/editpost/'.$row['post_id'],$title); ?>
					</td>
                    <td ><?php echo $row['user_name']; ?></td>
                    <td ><?php echo int_to_date($row['created_date']); ?></td>
                    <td ><?php echo int_to_date($row['changed_date']); ?></td>
                    <td class="textcenter" ><?php echo $comment =($row['comment'] == null)?'0': $row['comment'] ?></td>
                    <td class="textcenter" ><?php echo $row['hit']; ?></td>
                    <!-- <td >4</td>
                    <td >0</td> -->
                    <td ><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li><?php echo anchor('admin/editpost/'.$row['post_id'], 'View'); ?></li>
                                        <li><?php echo anchor('admin/viewpostmultimedia/'.$row['post_id'], 'View Multimedia');?>
										</li>
										<li><?php echo anchor('admin/viewComments/'.$row['post_id'], 'View Comments'); ?></li>
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
			<div class="noresult" >This search has no results</div>
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