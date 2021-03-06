<div id="wrapper">
  <div class="left-content-main"> <?php echo $sidebar;?> </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>
      <ul>
        <li><a href="javascript:void(0);" class="active">Home</a></li>
        <li>Edit Post</li>
      </ul>
    </div>
 	    
    <div class="rightinner">
            <div class="createpost" id="content">
                <h1>Edit Post</h1>
               
                <div id="addpostblock">        
                    <form action="<?php echo site_url('post/editPost')?>"  class="create-step" id="postAdd" name="postAdd" method="post">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcreate-step">
                     
                        <tr>
                          <td valign="top"><label class="name">Choose a suitable title</label></td>
                          <td><input type="text" class="inputmain tbi" name="title" id="title" value="<?php echo set_value('title',$post['title']); ?>"/>
                            <div class="error_class" id="err_title"></div>
							<span class="note">*Keep the title small and concise to make it easily searchable.</span>
                            <span class="error"><?php echo form_error('title'); ?></span>
                            </td>
                        </tr>
                        
                        <tr>
                          <td valign="top"><label class="name">Description about post</label></td>
                          <td><textarea cols="" rows="" class="inputmain tbi" name="description" id="description"><?php echo set_value('description', $post['description']); ?></textarea>
                            <span class="error"><?php echo form_error('description'); ?></span>
                          </td>
                        </tr>
                       
                        <tr>
                          <td>&nbsp;</td>
                          <td>
                          	<input type="submit" class="btnorange" value="Submit" style="margin-right:10px;"/>
                            <a href="post/allcategories" >
                            <input type="button" name="cancel" value="Cancel" class="btngrey"/>
                            </a>
                          </td>
                        </tr>
                      </table>
                      <input type="hidden" name="edit_post"  id="edit_post" value="Edit post"/>
                      <input type="hidden" name="post_id"  id="post_id" value="<?php echo $post['post_id']?>"/>
                      <input type="hidden" name="category"  id="category" value="<?php echo $category;?>"/>
                    </form>
  				</div>
        </div>
        </div>
</div>
<div class="clear"></div>
</div>