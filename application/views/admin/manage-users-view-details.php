<!--Wrapper Start-->
<div id="wrapper">
	<?php
	if(!empty($user_detail))
	{
	?>
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1><?php echo $user_detail['user_name']; ?></h1>
            <div class="btnbox"> <?php echo anchor('admin/manageusers','<span class="back-icon"></span>Back to all users','class="btnorange"'); ?></div>
        </div>
        <div class="account-sec-tab">
            <div class="account-info-tab">
                <div class="float active"> <span class="back"><span class="unlimited"></span></span> <span class="mid"> <?php echo anchor('admin/manageuserviewdetails/'.$this->session->userdata('user_id'), 'View User') ?> </span> <span class="front"></span> </div>
                <div class="float "> <span class="back"></span> <span class="mid"> <?php echo anchor('admin/manageuserseditdetails/'.$this->session->userdata('user_id'), 'Edit User')?> </span> <span class="front"></span> </div>
                <div class="float"> <span class="back"></span> <span class="mid"> <?php echo anchor('admin/manageuserscontenthistory/'.$this->session->userdata('user_id') , 'View Content Posted') ?> </span> <span class="front"></span> </div>
                <div class="float"> <span class="back"></span> <span class="mid"> <?php echo anchor('admin/manageusersloginhistory/'.$this->session->userdata('user_id'), 'Login History') ?> </span> <span class="front"></span> </div>
            </div>
        </div>
        <div id="manageuserdetails"> 
            <!-- Manage user View Details , edit detail, login history and view content posted comes here --> 
            <!-- Manage user view details   -->
            <div class="leftdtls">
                <div class="thumbmain"> 
					<div id="user-img-<?php echo $user_detail['user_id']; ?>">
							<script type="text/javascript">	myShowImage('<?php echo $user_detail["picture"];?>', '140', '140','user-img-<?php echo $user_detail["user_id"];?>')</script>
					</div>
				</div>
            </div>
            <div class="rightdtls">
                <div class="titlebar">
                    <h4>Personal Information</h4>
                    <?php echo anchor('admin/manageuserseditdetails/'.$this->session->userdata('user_id'), 'Edit User details')?> </div>
                <div class="clear"></div>
                <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                    <tr>
                        <td>User Name:</td>
                        <td><?php echo $user_detail['profile_name'];?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $user_detail['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><?php echo $user_detail['user_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Date of Birth:</td>
                        <td><?php echo date('d M Y',$user_detail['birth_date']); ?></td>
                    </tr>
                </table>
                <div class="titlebar">
                    <h4>Account Information</h4>
                </div>
                <div class="clear"></div>
               <div id="status_action_div" style="text-align:left;">
			  
				<?php $this->load->view('admin/account-information'); ?>
               </div>
				
				<div class="titlebar">
                    <h4>Social Networking Details</h4>
                </div>
                <div class="clear"></div>
                <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                    <tr>
                        <td>Twitter ID:</td>
                        <td><a href="javascript:void(0);">tomcruise</a></td>
                    </tr>
                    <tr>
                        <td>Facebook ID:</td>
                        <td><a href="javascript:void(0);">tomc</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
	<?php
	}
	else
	{
		echo '<div class="logsignbox">
				<div class="loginmain error404main">
					<h2>No User Found</h2>
					<div class="btnbox" style="float:right;"> '.anchor('admin/manageusers','<span class="back-icon"></span>Back to all users','class="btnorange"').'</div>
				</div>
			</div>';
	}
	?>
    <div class="clear"></div>
</div>
<!--Wrapper End--> 

