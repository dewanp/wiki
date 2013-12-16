<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Manage Users</h1>
			<div class="search">
				<div class="field" style="margin: 3px; float:right">
					<form action="" name="serach_user_by_title" onSubmit="searchUser();return false;">
						<label for="filter" class="infield">Type the name of the users to search</label>
						<input name="filter" type="text" class="inputmain" id="filter" value="<?php if($search_user) echo $search_user;?>" style="width: 300px;" />
						<input type="submit" class="icon" value="" style="border:none;">
					</form>
				</div>	
			</div>
            <!-- <div class="btnbox">
                <?php  echo anchor('admin/displayadduserview' , '<span class="add-icon"></span>Add User' , 'class="btnorange" ');?>
            </div> -->
        </div>
        <?php echo form_open('admin/suspendusers');?>
        <div class="grid grid4">
			<?php  if(!empty($manage_user)){?>
           
			<div style="margin:10px;color:green;float: left;"> <?php if($success_message) echo $success_message; ?> </div>		
			
			<div class="btnbox" style="float:right;">
                <?php  echo anchor('admin/displayadduserview' , '<span class="add-icon"></span>Add User' , 'class="btnorange" ');?>
            </div>
            <div class="clear"></div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th> <?php 
					$js = 'onClick="check_all_function(this)"';
					echo form_checkbox("checkall",'','',$js); ?></th>
                    <th>Full name</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th class="textcenter">Content Posted</th>
                    <!-- <th>Space used</th> -->
                    <th>Options</th>
                </tr>
                <?php  foreach ($manage_user as $i =>$row ) {    
					  if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
				?>
                <tr  <?php echo $class_alt ;?>>
                    <td><?php echo form_checkbox("check[]",$row['user_id'],'','class="u"'); ?></td>
                    <td >
							<span id="user-img-<?php echo  $row['user_id']; ?>" style="margin-right: 8px;" >
										<script type="text/javascript">			myShowImage('<?php echo $row["file_upload_id"];?>','30','30','user-img-<?php echo $row["user_id"];?>')					</script>
							</span>
							<?php echo anchor('admin/manageuserviewdetails/'.$row['user_id'], $row['profile_name'], 'style="position: relative;bottom:10px;"'); ?>
                    </td>
                    <td><?php echo anchor('admin/manageuserviewdetails/'.$row['user_id'], $row['user_name']); ?></td>
                    <td><?php  echo $row['email'];?></td>
                    <td><?php echo int_to_date($row['registered_date']); ?></td>
                    <td class="textcenter"><?php echo anchor('admin/manageuserscontenthistory/'.$row['user_id'],$row['content_posted']); ?></td>
                    <!-- <td>1</td> -->
                    <td><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li> <?php echo anchor('admin/manageuserviewdetails/'.$row['user_id'],'View Details'); ?> </li>
                                        <li> <?php echo anchor('admin/suspendusers/'.$row['user_id'],'Suspend Account'); ?> </li>
                                        <li><?php echo anchor('admin/manageusersloginhistory/'.$row['user_id'],'Login History'); ?> </li>
                                    </ul>
                                </div>
                                <div class="mpbot"></div>
                            </div>
                            <a href="javascript:void(0);" class="arrowpost"></a> </div></td>
                </tr>
                <?php  }?>
                <!-- foreach loop end here -->
            </table>
			<?php }else{ ?>
			<div class="noresult" >This search has no results</div>
			<?php }?>
        </div>
        </form>
        <div class="pagi-main">
		<?php  $to =$start + $limit ;   if($to > $count_user) $to = $count_user ; ?>
            <div class="pleft">
				<?php  if(!empty($manage_user)){?>
				<span class="left"> Showing  <?php echo ($start+1); ?> to <?php echo $to;?>  result from <?php echo $count_user; ?></span>  
				<?php } ?>
			</div>
            <!-- Pagination Region : Start -->
            <div class="pagination-region">
                <div class="paginationdiv">
                    <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
                </div>
                <!-- Pagination Region : End --> 
            </div>
        </div>
    </div>
	<div class="clear"> </div>
</div>
<!--Wrapper End--> 