<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1><?php echo $user_detail['user_name'];?></h1>
            <div class="btnbox"> <?php echo anchor('home/manageusers','<span class="back-icon"></span>Back to all users','class="btnorange"'); ?> </div>
        </div>
        <div class="account-sec-tab">
            <div class="account-info-tab">
                <div class="float"> <span class="back"><span class="unlimited"></span></span> <span class="mid"> <?php echo anchor('home/manageuserviewdetails/'.$this->session->userdata('user_id'), 'View User') ?> </span> <span class="front"></span> </div>
                <div class="float active"> <span class="back"></span> <span class="mid"> <?php echo anchor('home/manageuserseditdetails/'.$this->session->userdata('user_id'), 'Edit User')?> </span> <span class="front"></span> </div>
                <div class="float"> <span class="back"></span> <span class="mid"> <?php echo anchor('home/manageuserscontenthistory/'.$this->session->userdata('user_id') , 'View Content Posted') ?> </span> <span class="front"></span> </div>
                <div class="float"> <span class="back"></span> <span class="mid"> <?php echo anchor('home/manageusersloginhistory/'.$this->session->userdata('user_id'), 'Login History') ?> </span> <span class="front"></span> </div>
            </div>
        </div>
        <div class="leftdtls">
            <div class="thumbmain"> 
					 <div id="user-img-<?php echo $user_detail['user_id']; ?>">
							<script type="text/javascript">	myShowImage('<?php echo $user_detail["picture"];?>', '140', '140','user-img-<?php echo $user_detail["user_id"];?>')</script>
					</div>
			</div>
            
            <!--
<div class="btnbox"><a href="javascript:void(0);" class="btnorange">
<span class="add-icon"></span>Add Photo
<input type="file" class="photo-browse" />
</a>
</div>--> 
        </div>
        <div class="rightdtls">
            <div class="titlebar">
                <h4>Personal Information</h4>
            </div>
            <div class="clear"></div>
            <?php echo form_open('home/updateuserdata'); ?>
            <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                <tr>
                    <td> Name:</td>
                    <td><div class="field">
                            <input type="text" name="name" id="name" class="inputmain" value="<?php echo set_value('name',$user_detail['profile_name']) ;?>" />
                            <?php echo form_error('name'); ?> </div></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><div class="field">
                            <input type="text" name="email"id="email" class="inputmain" value=" <?php echo set_value('email',$user_detail['email']) ; ?>" />
                            <?php echo form_error('email'); ?> </div></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><div class="field">
                            <input type="text" id="user_name" name="user_name" class="inputmain"   value="<?php echo set_value('user_name',$user_detail['user_name']) ; ?>"  />
                            <?php echo form_error('user_name'); ?> </div></td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td><?php echo date('d M Y',$user_detail['birth_date']);?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" class="btnorange" value="Save" name="save" />
                        <input type="submit" class="btngrey" value="Cancel"  name="cancel" /></td>
                </tr>
            </table>
            <input type="hidden" name="is_active" value="<?php echo $user_detail['is_active']; ?>" hidden />
            </form>
            <div class="titlebar">
                <h4>Account Information</h4>
            </div>
            <div class="clear"></div>
            <table border="0" cellspacing="0" cellpadding="0" class="tbldtl">
                <tr>
                    <td>User's Account Status:</td>
                    <td><a href="javascript:void(0);" class="txtgreen">Active</a> <a href="javascript:void(0);">Suspend User?</a></td>
                </tr>
                <tr>
                    <td>Email Verification Status:</td>
                    <td><a href="javascript:void(0);" class="not-verified">Not Verified</a> <a href="javascript:void(0);" class="padr10">Send Verification Email</a> <a href="javascript:void(0);" class="padr10">Manually Verify User</a> <a href="javascript:void(0);" class="padr10">Reset Password</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="clear"></div>
</div>
<!--Wrapper End--> 