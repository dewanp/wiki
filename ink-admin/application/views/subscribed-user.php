<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
    	<div class="maintitle">
            <h1>Subscribed User</h1>
		</div>
        
        <div class="search">
            <div class="field">
                <form action="<?php echo site_url('home/subscribeduser');?>" name="serach_subscribe_user_by_name" method="get">
                    <label for="search" class="infield">Search within your subscribed users</label>
                    <input name="search" type="text" id="search" class="inputmain" value="<?php echo $this->input->get('search','Search within your subscribed users')?>" />
                    <input type="submit" class="icon" value="" style="border:none;">
                </form>
            </div>
            <div style="float:right" class="btnbox">
				<a class="btnorange" href="home/subscribedUserExcel"><span class="export-icon"></span>Export as Excel</a>
           </div>
        </div>
        
        <div class="grid grid5">
        	
            <div class="clear"></div>
        <?php  if(!empty($subscribed_user)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Email</th>
                    <!--<th>Submitted Date</th>-->
                    <th class="textcenter">Action</th>
                </tr>
                <?php $i=0; foreach($subscribed_user as $row) {
							if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
							 ?>
                <tr <?php echo $class_alt ;?>>
	                <td><?php echo $row['emailid']; ?></td>
                    <td><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li><a href="javascript:void(0);" onClick="subscribedUserDelete('<?php echo $row['subscribe_id']?>');">Delete</a></li>
                                    </ul>
                                </div>
                                <div class="mpbot"></div>
                            </div>
                            <a href="javascript:void(0);" class="arrowpost"></a></div>
                    </td>
                </tr>
                <?php $i++; }?>
            </table>
			<?php }else{ ?>
			<div class="noresult">This search has no results</div>
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