<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Suspended User List</h1>
            <div class="btnbox">
				 <?php echo anchor('home/manageusers','<span class="back-icon"></span>Back to all users','class="btnorange"');?>
			</div>
			 <div class="search" style="float:none!important;">
				<div class="field" style="margin: 3px; float:right">
						<form action="" name="serach_user_by_title" onSubmit="searchSuspendedUser();return false;">
							<label for="filter" class="infield">Type the name of the users to search</label>
							<input name="filter" type="text" class="inputmain" id="filter" value="<?php if($search_user!='--') echo $search_user;?>" style="width: 300px;" />
							<input type="submit" class="icon" value="" style="border:none;">
						</form>
				</div>	
			 </div>	
        </div>
        <?php echo form_open('home/resumesuspendedusers') ?>
        <div class="grid grid4"> 
        <?php  if(!empty($suspended_user)){?>
            <input type="submit" name="resume_selected" class="btnorange" value="Resume selected"/>
			<div style="margin:10px;color:green;float: left;"> <?php if($success_message) echo $success_message; ?> </div>
            <div class="clear"></div>
            <script type="text/javascript">
			 
            function check_all_function(ths){
				
				if($(ths).attr('checked')=="checked"){
					$(".u").attr('checked','checked');
				}else{
					$(".u").removeAttr('checked');
				}
			}
            </script>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th><?php  	$js = 'onClick="check_all_function(this)"';
										echo form_checkbox("checkall",'','',$js); 
								?>
                    </th>
                    <th>Full name</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Content Posted</th>
                    <th>Space used</th>
                    <th>Options</th>
                </tr>
               <?php  foreach ($suspended_user as $i => $row ) {    
					  if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
				?>
                <tr>
                    <td <?php echo $class_alt ;?>><?php echo form_checkbox("check[]",$row['user_id'],'','class="u"'); ?></td>
                    <td <?php echo $class_alt ;?> >
					<span id="user-img-<?php echo  $row['user_id']; ?>"  style="margin-right: 8px;" >
					 <script type="text/javascript">			myShowImage('<?php echo $row["picture"];?>','30','30','user-img-<?php echo $row["user_id"];?>')					</script>
					 </span>
					
					<?php echo anchor('home/manageuserviewdetails/'.$row['user_id'], $row['profile_name']); ?></td>
                    <td <?php echo $class_alt ;?>><?php echo anchor('home/manageuserviewdetails/'.$row['user_id'], $row['user_name']); ?></td>
                    <td <?php echo $class_alt ;?>><a href="javascript:void(0);">
                        <?php  echo $row['email'];?>
                        </a></td>
                    <td <?php echo $class_alt ;?>><?php echo int_to_date($row['registered_date']); ?></td>
                    <td <?php echo $class_alt ;?>><a href="javascript:void(0);"><?php echo $row['content_posted'] ; ?></a></td>
                    <td <?php echo $class_alt ;?>>1</td>
                    <td <?php echo $class_alt ;?>><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li> <?php echo anchor('home/manageuserviewdetails/'.$row['user_id'],'View Details'); ?> </li>
                                        <li> <?php echo anchor('home/resumesuspendedusers/'.$row['user_id'],'Resume suspend'); ?> </li>
                                        <li><?php echo anchor('home/manageusersloginhistory/'.$row['user_id'],'Login History'); ?></li>
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
            	
            </form>
        </div>
        <div class="pagi-main">
		<?php  $to =$start + $limit ;   if($to > $count_user) $to = $count_user ; ?>
            <div class="pleft">
				<?php  if(!empty($suspended_user)){?>
                    <span class="left"> Showing  <?php echo ($start+1); ?> to <?php echo $to;?>  result from <?php echo $count_user; ?></span> 
                <?php } ?>   
             </div>
            
            <!-- Pagination Region : Start -->
            <div class="pagination-region">
                <div class="paginationdiv">
                    <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
                </div>
            </div>
            <!-- Pagination Region : End --> 
        </div>
    </div>
	<div class="clear" > </div>
</div>
<!--Wrapper End--> 

