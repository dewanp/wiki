<div class="breadcrumb"> <span class="arrowleft"></span>
			<ul>
				<li><a href="<?php echo site_url('post/allcategories'); ?>" class="">Home</a></li>
				<?php foreach($breadcrumb as $row){ 
                    $active_class = 'class="nolink"';
					$category_url ='javascript:void(0)';
                    
                    if($row['id']==$type)
					{
						$active_class = 'class="active"';
					}
					else
					if(isset($row['permission_type']) && $row['permission_type']>0 )
					{   $active_class = '';
						$category_url = site_url('post/showposts/'.$row['id']);
					}			
					
			?>
                <li><a href="<?php echo $category_url;?>" <?php echo $active_class;?>><?php echo $row['name'];?> </a></li>
          <?php  }
            ?>
    
			</ul>
            
            
            <?php
			if(is_numeric($type)){
		   			 if($permission){
		   ?>
            <span class="" style="float:right;margin-top:12px;">
                <div class="makepostdd">
                    <a href="javascript:void(0);" class="arrowpost"></a>
                    <div class="mpddinner">
                        <div class="mptop"></div>
                        <div class="mpmid">
                          <ul>
                            <?php if($permission == 1){?>
                            
                                <li><?php echo anchor('post/displayEditCategory/0/'.$type,'Manage Category')?></li>
                                <li><a href="javascript:void(0);" onclick="deleteCategory(<?php echo $type;?>)">Delete Category</a></li>
                                <li><?php echo anchor('post/add/'.$type,'Add Post')?></li>
                                <li><?php echo anchor('post/displayEditCategory/'.$type,'Add Category')?></li>
                               
							<?php }elseif($permission == 2){?>
                          		 <li><?php echo anchor('post/add/'.$type,'Add Post')?></li>
                           	
							<?php }elseif($permission == 3){?>
                            	<li><?php $p_url =  getPostUrl($post['post_id']); echo anchor($p_url,'View' ,'class="publish"')?></li>
                            <?php }?>
                          </ul>
                        </div>
                        <div class="mpbot"></div>
                    </div>
                </div>
            </span>
             <?php }?>
              <?php }?>
            
		</div>