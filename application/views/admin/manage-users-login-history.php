<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1><?php  echo $user_name; ?></h1>
            <div class="btnbox">
			<?php echo anchor('home/manageusers','<span class="back-icon"></span>Back to all users','class="btnorange"');?>
			</div>
        </div>
        <div class="account-sec-tab">
            <div class="account-info-tab">
                <div class="float"> <span class="back"><span class="unlimited"></span></span> <span class="mid"> <?php echo anchor('home/manageuserviewdetails/'.$this->session->userdata('user_id'), 'View User') ?> </span> <span class="front"></span> </div>
                <div class="float "> <span class="back"></span> <span class="mid"> <?php echo anchor('home/manageuserseditdetails/'.$this->session->userdata('user_id'), 'Edit User')?> </span> <span class="front"></span> </div>
                <div class="float"> <span class="back"></span> <span class="mid"> <?php echo anchor('home/manageuserscontenthistory/'.$this->session->userdata('user_id') , 'View Content Posted') ?> </span> <span class="front"></span> </div>
                <div class="float active"> <span class="back"></span> <span class="mid"> <?php echo anchor('home/manageusersloginhistory/'.$this->session->userdata('user_id'), 'Login History') ?> </span> <span class="front"></span> </div>
            </div>
        </div>
        <div class="grid grid5">
            <div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Login Date</th>
                    <th>IP Address</th>
                </tr>
				 <?php  $i=0; foreach ($login_history as $row ) {    
					  if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
				?>
                <tr <?php echo $class_alt; ?> >
                    <td ><?php echo int_to_date($row['last_visit']); ?></td>
                    <td ><?php echo $row['last_visit_ip']; ?></td>
                </tr>
				<?php $i++; } ?>
                
            </table>
        </div>
		<div class="pagi-main">
		<?php  $to =$start + $limit ;   if($to > $count_user) $to = $count_user ; ?>
            <div class="pleft"><span class="left"> Showing  <?php echo ($start+1); ?> to <?php echo $to;?>  result from <?php echo $count_user; ?>
			 </span>  </div>
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