<div id="wrapper">
	<div class="left-content-main"> <?php echo $sidebar; ?></div> 
	
    <div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li><?php echo anchor('','Home');?></li>
                <li><a href="javascript:void(0);" class="active">Help Center</a></li>
            </ul>
        </div>
        <div class="rightinner">
            <div class="contentpanel">
                <h1 class="orangetitle-f20">Help Center</h1>
                <div class="expandablediv">
                    <div class="grnhead">
                        <h3>Getting Started</h3>
                        <span class="default open"></span> </div>
                    <div class="opendiv">
                        <ul class="openblock">
                            <li><?php echo anchor('about-inksmash','About InkSmash');?></li>
                            <li><?php echo anchor('creating-account','Creating an Account');?></li>
                            <li><?php echo anchor('creating-post','Creating a Post');?></li>
                            <li><?php echo anchor('my-profile','My Profile');?></li>
                            <li><?php echo anchor('following-user','Following a User');?></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="expandablediv">
                    <div class="grnhead" onClick="window.location.href='<?php echo site_url('user-dashboard');?>'">
                        <h3>User Dashboard</h3>
                    </div>
                    <div class="opendiv">
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="expandablediv">
                    <div class="grnhead">
                        <h3>Helpful Tips for Our Inkers</h3>
                        <span class="default open"></span> </div>
                    <div class="opendiv">
                        <ul class="openblock">
                            <li><?php echo anchor('dos-and-donts',"Do's and Do Not's");?></li>
                            <li><?php echo anchor('selecting-post-type','Selecting a Post Type');?></li>
                            <li>Increase the Visibility of Your Posts</li>
                            <ul>
                                <li><?php echo anchor('choose-suitable-title','Choose a Suitable Title');?></li>
                                <li><?php echo anchor('add-related-tags','Add all related tags');?></li>
                                <li><?php echo anchor('share-social-networks','Share on Your Social Networks');?></li>
                            </ul>
                            <li><?php echo anchor('using-blocks','Using the Blocks');?></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="expandablediv">
                    <div class="grnhead">
                        <h3>Earnings Section</h3>
                        <span class="default open"></span> </div>
                    <div class="opendiv">
                        <ul class="openblock">
                            <li><?php echo anchor('earnings-section','Earnings Section');?></li>
                            <li><?php echo anchor('how-to-make-money','How to Make Money on InkSmash');?></li>
                            <li><?php echo anchor('setting-adsense-account','Setting up an AdSense Account');?></li>
                            <li><?php echo anchor('setting-amazon-affiliate-account','Setting up an Amazon Affiliate Account');?></li>
                            <li><?php echo anchor('tips-to-make-money','Tips on how to Make Money on InkSmash');?></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="expandablediv">
                    <div class="grnhead" onClick="window.location.href='<?php echo site_url('faq');?>'">
                        <h3>Frequently Asked Questions</h3>
                    </div>
                    <div class="opendiv">
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="clear"></div>
</div>