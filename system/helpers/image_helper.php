<?php

function image_thumb($image_path, $height, $width,$user_id,$image_name, $img_css_class="")
{
	// Get the CodeIgniter super object
	$CI =& get_instance();
	
	// Path to image thumbnail
	$image_thumb = dirname($image_path) . '/' . $height . '_' . $width . '_'.$user_id.'_'.$image_name;
	
	
		// LOAD LIBRARY
		$CI->load->library('image_lib');
		
		// CONFIGURE IMAGE LIBRARY
		$config['image_library']	= 'gd2';
		$config['source_image']		= $image_path;
		$config['new_image']		= $image_thumb;
		$config['maintain_ratio']	= false;
		$config['dynamic_output']	= false;
		$config['height']			= $height;
		$config['width']			= $width;
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();

	return '<img src="' . $image_thumb . '" class="pic1 '.$img_css_class.'" />';
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */