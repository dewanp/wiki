<?php if($this->session->userdata('msg') == "No user found for this authentication."){ ?>
    <div id="wrapper-login">
        <div class="logsignbox">
            <div class="loginmain regis">
            <h2><?php echo $this->session->userdata('msg');?></h2>
            </div>
        </div>
    </div>
<?php }else{?>
    <div id="wrapper-login">
        <div class="logsignbox">
            <div class="loginmain regis">
                <h2>Thank you for registering with Ink Smash</h2>
                <div class="login">
                    <div class="loginbg"></div>
                        <div class="message">
                                    <img src="images/icon-smile.png" alt="" />
                                    <p>A verification email has been sent to <a href="mailto:<?php echo $this->session->userdata('email');?>"><?php echo $this->session->userdata('email');?></a><br />
                            Please click on the link provided in the email to set up your account.<br />
                            If you have not received the email, please be patient. Sometimes it takes a while for the email to download.</p>
                            <p>If you've received the link click on <?php echo anchor('user/login','Go to Login page')?></p>
                        </div> 
                </div>
          </div>
        </div>
    </div>
<?php }?>