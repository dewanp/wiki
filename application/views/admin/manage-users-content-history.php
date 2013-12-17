<!--Wrapper Start-->

<div id="wrapper">
    <div class="container">
        <div class="breadcrumb"> </div>
        <div class="maintitle">
            <h1><?php echo $user_detail['user_name'];?></h1>
            <div class="btnbox"> <?php echo anchor('admin/manageusers','<span class="back-icon"></span>Back to all users','class="btnorange"'); ?> </div>
        </div>
        <div class="account-sec-tab">
            <div class="account-info-tab">
                <div class="float"> <span class="back"><span class="unlimited"></span></span> <span class="mid"> <?php echo anchor('admin/manageuserviewdetails/'.$this->session->userdata('user_id'), 'View User') ?> </span> <span class="front"></span> </div>
                <div class="float "> <span class="back"></span> <span class="mid"> <?php echo anchor('admin/manageuserseditdetails/'.$this->session->userdata('user_id'), 'Edit User')?> </span> <span class="front"></span> </div>
                <div class="float active"> <span class="back"></span> <span class="mid"> <?php echo anchor('admin/manageuserscontenthistory/'.$this->session->userdata('user_id') , 'View Content Posted') ?> </span> <span class="front"></span> </div>
                <div class="float"> <span class="back"></span> <span class="mid"> <?php echo anchor('admin/manageusersloginhistory/'.$this->session->userdata('user_id'), 'Login History') ?> </span> <span class="front"></span> </div>
            </div>
        </div>
        <div class="search">
            <div class="field">
                <div class="field">
                    <form action="<?php echo site_url('admin/manageuserscontenthistory/'.$this->session->userdata('user_id'));?>" name="serach_post_by_title" method="get">
                        <label for="search" class="infield">Search within your posts</label>
                        <input name="search" type="text" id="search" class="inputmain" value="<?php echo $this->input->get('search','Search within your posts')?>" />
                        <input type="submit" class="icon" value="" style="border:none;">
                    </form>
                </div>
            </div>
        </div>
        <div class="grid grid5">
            <div class="clear"></div>
			<?php if(!empty($posts)){ ?>
            <table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Post Title</th>
                    <th>Posted on</th>
                    <th class="textcenter">Comments</th>
                    <th class="textcenter">Hits</th>
                    <!-- <th>Rating</th>
                    <th>Reported abuses</th> -->
                    <th>Action</th>
                </tr>
                <?php  foreach($posts as $i=> $row) {
							if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
							 ?>
					<?php $title = (strlen($row['title'])<50)?$row['title']:substr($row['title'],0,50)."...." ;?>
                <tr <?php echo $class_alt ;?>>
                    <td ><?php echo anchor('admin/editpost/'.$row['post_id'],$title); ?>	</td>
                    <td ><?php echo  int_to_date($row['created_date']); ?></td>
                    <td class="textcenter"><?php echo $row['comment']; ?></td>
                    <td class="textcenter"><?php echo $row['hit']; ?></td>
                    <!-- <td class="textcenter">4</td>
                    <td class="textcenter" >0</td> -->
                    <td ><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li><?php echo anchor('admin/editpost/'.$row['post_id'],'view'); ?></li>
                                        <li><?php echo anchor('admin/viewpostmultimedia/'.$row['post_id'], 'View Multimedia');?></li>
                                        <li><?php echo anchor('admin/blockposts/'.$row['post_id'],'Block post');?>
										</li>
                                        <!-- <li><a href="javascript:void(0);">Delete post</a></li> -->
                                    </ul>
                                </div>
                                <div class="mpbot"></div>
                            </div>
                            <a href="javascript:void(0);" class="arrowpost"></a></div></td>
                </tr>
                <?php  } ?>
            </table>
			<?php }else { ?>
			<div class="noresult">This search has no results </div>

			<?php }?>
        </div>
        <div class="pagi-main"> 
            <!-- Pagination Region : Start -->
            <div class="pagination-region">
                <div class="paginationdiv">
                    <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
                </div>
                <!-- Pagination Region : End --> 
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!--Wrapper End--> 