<?php print $this->load->view('includes/header');?>
<?php 
	$formAttributes = array('class' => 'post-add', 'id' => 'postAdd', 'name' => 'postAdd');
	print form_open_multipart('post/save', $formAttributes);
?>
<table width="100%" border="1">
  <tr><td><?php print form_label('Title', 'postTitle');?><br /><?php print form_input('postTitle', '');?></td></tr>
  <tr><td><?php print form_label('Choose a Topic. Which Category Describes What Your Hub Is About?', 'postCategory');?><br />
	<?php $postCategoryOptions = array(
                  'small'  => 'Small Shirt',
                  'med'    => 'Medium Shirt',
                  'large'   => 'Large Shirt',
                  'xlarge' => 'Extra Large Shirt',
                );
              print form_dropdown('postCategory', $postCategoryOptions, 'large');?>
		</td></tr>
  <tr><td><?php print form_submit('addPost', 'Continue!');?><?php print form_reset();?></td></tr>
</table>
<?php print form_close();?>
<?php print $this->load->view('includes/footer');?>
