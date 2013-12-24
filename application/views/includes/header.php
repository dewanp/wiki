<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url();?>" />
<title><?php if(property_exists($this,'page_title') && $this->page_title!="") echo $this->page_title; else echo "Vinfotech-wiki" ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<meta name="keywords" content="
<?php if(property_exists($this,'page_keywords') && !empty($this->page_keywords)){?><?php foreach($this->page_keywords as $keywords){$t[]=$keywords['name'];	} print implode(", ",$t);?><?php } else { echo "custom blog";} ?>" />
<meta name="description" content="<?php if(property_exists($this,'page_desc') && $this->page_desc!="") echo $this->page_desc; else echo "Ink Smash" ?>" />
<meta property="og:image" content="<?php echo site_url();?>images/inksmash-logo.png" />


<link rel="shortcut icon" href="images/favicon.ico" />
<!-- CSS start -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url().'css/jquery-ui.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url().'css/chosen/chosen.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url().'css/inkSmashStyle.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url().'css/fixes.css'; ?>" />
<!-- CSS end -->


<!-- Javascripts start -->
<script language="javascript" type="text/javascript">
	 var site_url = '<?php echo site_url();?>';
</script>


<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery-1.7.2.min.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery-ui.js';?>"></script>

<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/chosen/chosen.jquery.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/chosen/prism.js';?>"></script>

<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery.tipsy.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery.rating.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery.autoGrowInput.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery.tagedit.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/pstrength-min.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/label-infields.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/custom-form-elements.js';?>"></script>

<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/functions.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/user.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/nicEdit.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/ajaxupload.js';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/admin.js'; ?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/admin-common.js'; ?>"></script>

<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/image-gallery.js'; ?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/common.js'; ?>"></script>

<script type="text/javascript" src="<?php echo site_url().'jwplayer/jwplayer.js'; ?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url().'javascript/jquery.form.js'; ?>"></script>

<script language="javascript" type="text/javascript">
	$(document).ready(function(){
			$('.tooltip').tipsy({gravity: 'se'});
			$(".d-reg").focus(function(){
					$(this).removeClass('error-border');
			});
			
			$( "#sortable" ).sortable({containment:'#sortable'});       
			$( "#sortable" ).disableSelection();
			/* tooltip start */
			$('.tooltip').tipsy({gravity: 'w'}); 
			/* tooltip end */
	});
</script>
<!-- Javascripts end -->
</head>
<body>
<!--Zip-code section start -->
<div id="zipcode-main-block">
    <div class="zip-code-block"> <span class="zip-info" id="site-message">We need your zip code so that you help others know your area in case they wish to know. You'll be the window to your area for these users and as you keep posting, you posts can be useful to everyone</span>
        <div class="clear"></div>
        <div class="close-alert" id="close-alert"></div>
    </div>
</div>
<!--Zip-code section End -->
<div id="header-main">
	<div class="header-black">
		<div class="header">
			<div class="header-left">
				<div class="inksmash-logo"><?php echo anchor('','<img src="images/wiki.png" alt="" width="171" height="66" />')?></div>
			</div>
			<div class="header-right-top"><?php $this->load->view('includes/header-right-top');?></div>
		</div>
	</div>
	<?php 
		$no_header_link_url_array = array('','user/login','user/forgotPassword','user/sendforgotPasswordEmail','user/verifyUserLink','user/congratulation','user/resetPassword','user/social','user/saveSocialRegistration');
		
		if(!in_array($this->uri->uri_string(),$no_header_link_url_array)){?>
		
	<div class="header-blue">
		<div class="header">
			<div class="header-left">
				<div class="view-demo-video"></div>
			</div>
			<div class="header-right">
				<div class="main-nav">
				
					<ul>
					  <li class="home"> <a href="<?php echo site_url('post/allcategories');?>" class="active">Home<span class="arrow"></span></a></li>					 
					  <!--<li class="all-post"><?php echo anchor('post/showposts/all','All Posts<span class="arrow"></span>');?></li>-->
					</ul>
					
				</div>
			</div>
		</div>
	</div>
	<?php }?>
	<div class="clear"></div>
</div>	