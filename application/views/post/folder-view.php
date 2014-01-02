 <?php if(!empty($child_category)){?>
  <div class="catbox">
    <div class="catypef">
     <ul id="category_display">
        <?php
		 	foreach ($child_category as $row){			
				$class='';
				if($row['permission_type']==1)
					$class='cadmin';
				elseif($row['permission_type']==2)
					$class='crw';
				elseif($row['permission_type']==3)
					$class='cr'
		?>
        	<a href="<?php echo 'post/showposts/'.$row['id'];?>">
                 <li class="<?php echo $class;?>">
                    <?php echo $row['name'];?>
                 </li>
             </a>
	<?php }?>
    </ul>
   </div>
 </div>
 <?php } ?>
				