<div id="wrapper">
  <div class="left-content-main"> <?php echo $sidebar;?> </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><a href="javascript:void(0);" class="active">Home</a></li>
        <li>Add Post</li>
      </ul>
    </div>
 	    
    <div class="rightinner">
            <div class="createpost" id="content">
                <h1>Create Post</h1>
               
                <div id="addpostblock">        
                    <form action="<?php echo site_url('post/addPost')?>"  class="create-step" id="postAdd" name="postAdd" method="post">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcreate-step">
                     
                        <tr>
                          <td valign="top"><label class="name">Choose a suitable title</label></td>
                          <td><input type="text" class="inputmain tbi" name="title" id="title" value="<?php echo set_value('title',''); ?>"/>
                            <div class="error_class" id="err_title"></div>
							<span class="note">*Keep the title small and concise to make it easily searchable.</span>
                            <span class="error"><?php echo form_error('title'); ?></span>
                            </td>
                        </tr>
                        
                        <tr>
                          <td valign="top"><label class="name">Description about post</label></td>
                          <td><textarea cols="" rows="" class="inputmain tbi" name="description" id="description"><?php echo set_value('description', ''); ?></textarea>
                            <span class="error"><?php echo form_error('description'); ?></span>
                          </td>
                        </tr>
                        <tr>
                        	<td valign="top"><label class="name">Select Category</label></td>
                            <td>
								<?php $i = 1;
									if(isset($category) && empty($category)){
										$category = array();
									}
									
									if(!empty($category_list))
									{
										//echo'<pre>';print_r($category_list);
										foreach($category_list as $key=>$val)
										{
											if($val['category_id'] != '' && $val['name'] != '')
											{
								?>
										<span class="w50per">
                                            <input type="checkbox" id="category" name="category[]" value="<?php echo $val['category_id'];?>" <?php if(isset($category) && in_array($val['category_id'],$category)){?> checked="checked" <?php }?>/>
                                            <?php echo $val['name'];?>
                                        </span>
								<?php $i++; 
											}
										}
									}else{
										echo 'Categories are not available.';
								?>
										<input type="hidden" name="category[]"  id="category" value="no category"/>
								<?php 
									}
								?>
                                <span class="error"><?php echo form_error('category'); ?></span>
                            </td>
                        </tr>
                        
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" class="btnorange" value="Submit"/></td>
                        </tr>
                      </table>
                      <input type="hidden" name="add_post"  id="add_post" value="Add new post"/>
                    </form>
  				</div>
        </div>
        </div>
</div>
<div class="clear"></div>
</div>