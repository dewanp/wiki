<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
		<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><?php echo anchor('user/feeds','Home'); ?></li>
				<li><a href="javascript:void(0);" class="active">All Post</a></li>
			</ul>
		</div>
		<div class="rightinner">   
			
			<h1 class="orangetitle-f20">Featured Posts</h1>
            <div class="switchview"> 
            <a href="javascript:void(0)" class="list active" onclick="$('#list-container').show();$('#table-container').hide();$('#a-table').removeClass('active');$('#a-list').addClass('active')" id="a-list"></a>
             <a href="javascript:void(0)" class="task " id="a-table" onclick="$('#table-container').show();$('#list-container').hide();$('#a-list').removeClass('active');$('#a-table').addClass('active')"></a></div>
			<!--start: slider-->
            <div id="homeSlider">
                <div class="container">
                    <div class="bgleft"></div>
                    <div class="bgright"></div>
                    <div class="slides"> 
                        <!--slide 1-->
                        <div class="slideinner">
                            <h3>Our beloved earth - <span class="txtorange">Journey from eyes of a photographer</span></h3>
                            <span class="by">By: <a href="javascript:void(0);">Joseph C</a></span>
                            <div class="contentbox">
                                <div class="sleft">
                                    <div class="thumbmain">
                                        <div class="thumb"><img src="images/slidethumb.jpg" alt="" /></div>
                                        <span class="or-icons"><img src="images/icon1.png" alt="" /></span></div>
                                </div>
                                <div class="sright">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                        <!--slide 1--> 
                    </div>
                    <div class="slides"> 
                        <!--slide 2-->
                        <div class="slideinner">
                            <h3>Our beloved earth - <span class="txtorange">Journey from eyes of a photographer 2</span></h3>
                            <span class="by">By: <a href="javascript:void(0);">Joseph C</a></span>
                            <div class="contentbox">
                                <div class="sleft">
                                    <div class="thumbmain">
                                        <div class="thumb"><img src="images/slidethumb.jpg" alt="" /></div>
                                        <span class="or-icons"><img src="images/icon1.png" alt="" /></span></div>
                                </div>
                                <div class="sright">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                        <!--slide 2--> 
                    </div>
                    <div class="slides"> 
                        <!--slide 3-->
                        <div class="slideinner">
                            <h3>Our beloved earth - <span class="txtorange">Journey from eyes of a photographer 3</span></h3>
                            <span class="by">By: <a href="javascript:void(0);">Joseph C</a></span>
                            <div class="contentbox">
                                <div class="sleft">
                                    <div class="thumbmain">
                                        <div class="thumb"><img src="images/slidethumb.jpg" alt="" /></div>
                                        <span class="or-icons"><img src="images/icon1.png" alt="" /></span></div>
                                </div>
                                <div class="sright">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                        <!--slide 3--> 
                    </div>
                    <div class="slides"> 
                        <!--slide 4-->
                        <div class="slideinner">
                            <h3>Our beloved earth - <span class="txtorange">Journey from eyes of a photographer 4</span></h3>
                            <span class="by">By: <a href="javascript:void(0);">Joseph C</a></span>
                            <div class="contentbox">
                                <div class="sleft">
                                    <div class="thumbmain">
                                        <div class="thumb"><img src="images/slidethumb.jpg" alt="" /></div>
                                        <span class="or-icons"><img src="images/icon1.png" alt="" /></span> </div>
                                </div>
                                <div class="sright">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                        <!--slide 4--> 
                    </div>
                </div>
            </div>
            <!--end: slider-->
			
			
			<div id="list-container">
			<?php if(!empty($posts)){?>
				<div id="list-reading">
					<?php $this->load->view("reading/list-reading");?>
				</div>
				<div class="txtshow showmore" id="list-reading-showmore">
					<a href="javascript:void(0);" class="txtgrey" onclick="loadMoreReadingPosts('list-reading');"><span class="txtload">Show more</span>
					<img src="images/loader.gif" alt="" id="list-reading-loading" style="display:none;"/></a>
				</div>
			<?php } else echo '<span style="margin:10px;font-size:16px;">No Posts available</span>';?>
			</div>



			<div id="table-container" style="display:none;">
			<?php if(!empty($posts)){?>
				<div id="table-reading">
					<?php $this->load->view("reading/table-reading");?>
				</div>
				<div class="txtshow showmore" id="table-reading-showmore">
					<a href="javascript:void(0);" class="txtgrey"  onclick="loadMoreReadingPosts('table-reading');"><span class="txtload">Show more</span>
					<img src="images/loader.gif" alt="" id="table-reading-loading" style="display:none;"/></a>
				</div>
			<?php } else echo '<span style="margin:10px;font-size:16px;">No Posts available</span>';?>
			</div>



		</div>
	</div>
	<div class="clear"></div>
</div>