<div id="wrapper">
	<div class="left-content-main"><?php echo $sidebar;?></div>
	<div class="rightmain">
        <div class="breadcrumb"> <span class="arrowleft"></span>
            <ul>
                <li><a href="javascript:void(0);" class="active">Home</a></li>
                <li><a href="javascript:void(0);" class="active">All Categories</a></li>
            </ul>
        </div>
        <div class="rightinner">
            <div class="sub-title">
                <h2>Categories</h2>
                 <ul id="sample">
                     <li class="cadmin">Admin</li>
                     <li class="crw">RW</li>
                     <li class="cr">R</li>
                 </ul>
            </div>
            <div class="catbox">
            <?php if(!empty($categories)){?>
                <div class="catypef">
                 
                 <ul id="category_display">
                     
                    <?php foreach ($categories as $row){  
                        $class='';
                        if($row['permission_type']==1)
                            $class='cadmin';
                        elseif($row['permission_type']==2)
                            $class='crw';
                        elseif($row['permission_type']==3)
                            $class='cr';
                        ?>
                     <li class="<?php echo $class;?>"> <?php echo $row['name'];?></li>
                     <?php
                    }  ?>
                     </ul>
                </div>
                <div class="catnav"> <?php  echo $this->pagination->create_links(); ?></div>
                <?php }else{?>
                	<?php echo "<span style=\"color:red;\">No Categories Available. </span>";?>
                <?php }?>
            </div>
           
        </div>
    </div>
	<div class="clear"></div>
</div>