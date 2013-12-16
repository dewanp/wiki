<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ; ?></title>
<!-- Setting Base Url -->
<base href="<?php echo base_url();?>">
<!-- Site_url variable initilisation -->
<script language="javascript" type="text/javascript">
 var site_url = '<?php echo site_url();?>';
</script>

<link rel="stylesheet" type="text/css" href="css/chosen/style.css" /> 
<link rel="stylesheet" type="text/css" href="css/chosen/prism.css" /> 
<link rel="stylesheet" type="text/css" href="css/chosen/chosen.css" />

<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="css/editpost.css"/>
<link rel="stylesheet" type="text/css" href="css/fixes.css"/>


<script type="text/javascript" src="javascript/jquery-1.7.2.min.js"></script>
<script language="javascript" type="text/javascript" src="javascript/chosen/chosen.jquery.js"></script>
<script language="javascript" type="text/javascript" src="javascript/chosen/prism.js"></script>

<script type="text/javascript" src="javascript/jquery-ui.js"></script>
<script type="text/javascript" src="javascript/common.js"></script>
<script type="text/javascript" src="javascript/label-infields.js"></script>
<script type="text/javascript" src="javascript/custom-form-elements.js"></script>
<script type="text/javascript" src="javascript/admin.js"></script>
<script type="text/javascript" src="javascript/functions.js"></script>
<script type="text/javascript" src="javascript/ajaxupload.js"></script>
<script type="text/javascript" src="javascript/nicEdit.js"></script>


<!-- Tag edit jquery plug in  -->
<script language="javascript" type="text/javascript" src="javascript/jquery.autoGrowInput.js"></script>
<script language="javascript" type="text/javascript" src="javascript/jquery.tagedit.js"></script>

<script type="text/javascript" src="jwplayer/jwplayer.js"></script>

</head>
<body>
<!--Header Start-->
<div id="header-main">
    <div class="header">
        <div class="headerin">
            <div class="inksmash-logo">
			<?php echo anchor('home/dashboard', '<img src="images/wiki.png" alt="" width="171" height="66" />') ?>
			</div>
            <div class="header-right">
                <div class="header-right-top">
                    <div class="user-login">
                        <ul>
                            <li id="user-login">
								<span id="user_header_image"  style="margin-right: 8px;" >
														<script type="text/javascript">			myShowImage('<?php echo  $this->session->userdata("file_upload_id")?>' ,'30' ,'30' ,'user_header_image');	</script>
									</span>
					 				<a href="javascript:void(0);"><?php echo $this->session->userdata("profile_name");?> </a>		
                           </li>
                        </ul>
                        <div class="loginbox" id="loginbox" style="display:none;">
                            <ul>
                                <!-- <li><a href="javascript:void(0);"><span class="account"></span>My Account</a></li> -->
                                <li>
                                    <?php echo anchor('home/viewchangepassword','<span class="account"></span>Change Password'); ?>
                                </li>
                                <!-- <li><a href="javascript:void(0);"><span class="unpublish"></span>Unpublished Content</a></li> -->
								<li> 
									<?php echo anchor('home/logout', '<span class="logout"></span>Logout'); ?> 
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- <div class="serach-box">
                        <div class="field">
                            <label for="txtF1" class="infield">Search for Contents</label>
                            <input name="textfield" type="text" id="txtF1" value="" />
                        </div>
                        <input type="submit" value="" />
                    </div> -->

                </div>
            </div>
        </div>
        <div class="main-nav">
        <?php  $home= "";
			   $manage_user= "";
			   $category ="";		 
			   $post_type= "";
			   $manage_content = "";
			   $google_ads = "";
			   $report_abuse = "";
			   $contact_detail ="";
			   $subscribed_user = "";
			   $contests = "";
		
			   if($active == "home")
				   	$home= "class='active'";
				else if($active =="manage_user")
					$manage_user= "class='active'";
				else if($active =="category")
				     $category = "class='active'";
				else if($active == "post_type")
				     $post_type = "class='active'";
				else if($active == "manage_content")
				      $manage_content = "class='active'";
				else if ($active == "google_ads")
				      $google_ads = "class='active'";
				else if ($active == "report_abuse")
				      $report_abuse = "class='active'";
				else if ($active == "contact_detail")
				      $contact_detail = "class='active'";
				else if ($active == "subscribed_user")
				      $subscribed_user = "class='active'";
				else if ($active == "contests")
				      $contests = "class='active'";	  
			   
		?>
            <ul>
                <li class="home">
					<?php echo anchor('home/dashboard','Home<span class="arrow"></span>',$home);?>
				</li>
                <li class="local-post">
					<?php echo anchor ('home/manageusers','Manage Users<span class="arrow"></span>',$manage_user); ?>
				</li>
                <li class="local-post">
					<?php echo anchor ('home/managecontent','Manage Content<span class="arrow"></span>',$manage_content);?>
				</li>                
                <li class="local-post">
	                <?php echo anchor ('home/displaycategorylist','Manage Category<span class="arrow"></span>',$category);?>
                </li>
				<?php /*?><li class="local-post">
					<?php echo anchor('home/displayposttypelist','Post Type<span class="arrow"></span>',$post_type);?>
				</li>
				<li class = "local-post">
				  <?php echo anchor('home/updateGoogleAdClientId','Google Ads<span class="arrow"></span>', $google_ads);?>
				</li>
				<li class = "local-post">
				  <?php echo anchor('home/reportabuselist','Report Abuse<span class="arrow"></span>', $report_abuse);?>
				</li>
                <li class = "local-post">
				  <?php echo anchor('home/contactdetail','Contact Detail<span class="arrow"></span>', $contact_detail);?>
				</li>
                 <li class = "local-post">
				  <?php echo anchor('home/subscribeduser','Subscribed User<span class="arrow"></span>', $subscribed_user);?>
				</li>
                 <li class = "local-post">
				  <?php echo anchor('home/showcontestlisting','Contests<span class="arrow"></span>', $contests);?>
				</li><?php */?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<!--Header End--> 