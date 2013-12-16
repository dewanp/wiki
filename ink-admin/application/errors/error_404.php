<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>InkSmash</title>
<link rel="stylesheet" type="text/css" href="/ink-smash/css/inkSmashStyle.css" />
</head>
<body>
<div id="header-main">
  <div class="header">
    <div class="headerin">
      <div class="inksmash-logo">
	  <?php echo anchor('home/dashboard',' <img src="'. base_url().'images/inksmash-logo.png" alt="" />') ?>
	 
	  </div>
      <div class="admin-head">
      Admin Login
      </div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<div id="wrapper-login" style="min-height:575px;">
    <div class="logsignbox">
        <div class="loginmain error404main">
            <h2><?php echo $heading; ?></h2>
            <span class="error404"><?php echo $message; ?></span>
            </div>
    </div>
</div>
<div id="footer-wrapper">
    <div id="footer-main" style="min-height:2px;"></div>
    <div class="copyright-section">
        <div class="footer-copyright-main">
            <div class="copyrith-left">Copyright &copy;inkSmash 2012. All Rights Reserved</div>
            <div class="copyright-right">Powered by- <a href="http://vinfotech.com">Vinfotech</a></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
</body>
</html>