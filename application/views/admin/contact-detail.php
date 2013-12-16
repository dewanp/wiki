<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
    	<div class="maintitle">
            <h1>Contact Detail</h1>
		</div>
        
        <div class="search">
            <div class="field">
                <form action="<?php echo site_url('home/contactdetail');?>" name="serach_contact_by_name" method="get">
                    <label for="search" class="infield">Search within your contacts</label>
                    <input name="search" type="text" id="search" class="inputmain" value="<?php echo $this->input->get('search','Search within your contacts')?>" />
                    <input type="submit" class="icon" value="" style="border:none;">
                </form>
            </div>
        </div>
        
        
        <div class="grid grid5">
            <div class="clear"></div>
        <?php  if(!empty($contact_list)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Phone</th>
                    <th class="textcenter">Comment</th>
                    <!--<th>Submitted Date</th>-->
                    <th>Action</th>
                </tr>
                <?php $i=0; foreach($contact_list as $row) {
							if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
							 ?>
                <tr <?php echo $class_alt ;?>>
	                <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['country']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['comment']; ?></td>
                    <!--<td><?php //echo $row['submitted_date']; ?></td>-->
                    <td><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li><a href="javascript:void(0);" onClick="contactDetailDelete('<?php echo $row['contact_data_id']?>');">Delete</a></li>
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