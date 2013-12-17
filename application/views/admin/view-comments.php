<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Manage Content</h1>
            <?php echo anchor('home/allblockedposts','View blocked posts','class="viewlink"'); ?>
			<?php echo anchor('home/reportabuselist','View reported abuse posts','class="viewlink"'); ?>
		</div>
       
		
        <div class="grid grid5">
            <div class="clear"></div>
        <?php  if(!empty($all_posts)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Comment</th>
                    <th>Posted by</th>
                    <th>Posted on</th>
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
	                <td >
						<?php echo $comment =  $row['description'];
							 
							 ?>
						<?php //echo anchor('home/editpost/'.$row['comment_id'],$comment); ?>
					</td>
                    <td><?php if(trim($row['user_name'])!='') { echo $row['user_name']; }else{ echo 'anonymous';} ; ?></td>
                    <td><?php echo int_to_date($row['created_date']); ?></td>
                                        <!-- <td >4</td>
                    <td >0</td> -->
                    <td ><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                       <li>
									   <a href="javascript:void(0);" onclick="deleteCommentsByPost('/admin/deleteComments/<?php echo $row['comment_id'].'/'.$post_id ?>')">Delete Comment</a>
									   <?php //echo anchor('home/deleteComments/'.$row['comment_id'].'/'.$post_id, 'Delete Comment');?>
										</li>
									   
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
<script>
function deleteCommentsByPost(url){
var r=confirm("Are you sure want to delete this comment?")
	if (r==true)
	  {
		window.location=site_url+'/'+url;
	  }
	else
	  {
		return false;
	  }
}
</script>