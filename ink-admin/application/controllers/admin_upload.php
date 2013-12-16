<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('commonmodel');
	}

	function index()
	{
		
	}

	
	function do_upload()
	{
		
		$file_field_name = $this->input->post('field_name','userfile');
		$file_type = $this->input->post('file_type','image');
		
		
		if (! is_dir(ROOT_PATH."uploads")){
				mkdir(ROOT_PATH."uploads", 0777);
				chmod(ROOT_PATH."uploads", 0777);
		}
		
		if (! is_dir(ROOT_PATH."uploads/temp")){
				mkdir(ROOT_PATH."uploads/temp", 0777);
				chmod(ROOT_PATH."uploads/temp", 0777);
		}
		
		
		$folder_path = ROOT_PATH.'uploads/';
		
		$config['upload_path'] = $folder_path;
		$config['allowed_types'] = '*';
		$config['encrypt_name'] = true;
		$config['max_size']	= '102400';
		$config['max_width']  = '102400';
		$config['max_height']  = '76800';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file_field_name)){
			$msg = array('status' => '0', 'data' => $this->upload->display_errors());
		}else{

			$uploaded_data = $this->upload->data();
			if($uploaded_data['is_image']){
			$thumb_size_array = array(
								 '100'=>array('width'=>100,'height'=>100),
								 '150'=>array('width'=>150,'height'=>150),
								 '700'=>array('width'=>700,'height'=>700));
			
			$this->load->library('phpthumb');
			$phpThumb = new phpThumb();
			$thumb_source_path = file_get_contents($uploaded_data['full_path']);
						
			//If you want to resize
			//Config array for second thumbnail type
			foreach($thumb_size_array as $key => $thumb_size)
			{
				$phpThumb->resetObject();
				$phpThumb->setSourceData($thumb_source_path);
				$phpThumb->setParameter('w', $thumb_size['width']);
				$phpThumb->setParameter('h', $thumb_size['height']);
				$phpThumb->setParameter('zc', true);
				$phpThumb->setParameter('q', 70);
				$modified_filename = $uploaded_data['raw_name'].'_'.$thumb_size['width'].'X'.$thumb_size['height'].$uploaded_data['file_ext'];
				$output_filename = ROOT_PATH.'uploads/temp/'. $modified_filename ;
				  
				   if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
					if ($phpThumb->RenderToFile($output_filename)) {
	
					  	/* Code for upload file on amazon server */	
						$this->load->library('amazons3');
						$this->amazon_s3_client->putBucket(BUCKET_NAME, S3::ACL_PUBLIC_READ);
						$this->amazon_s3_client->putObjectFile($output_filename, BUCKET_NAME, "uploads/".$modified_filename, S3::ACL_PUBLIC_READ);
						unlink($output_filename);
						
					}
				}
			}
			// Main if start is image
			}
			
			$new_file_upload = array('file_name' => $uploaded_data['file_name'],
									'file_path' => $uploaded_data['file_name'],
									'type' => $uploaded_data['file_type'],
									'size' => $uploaded_data['file_size'],
									'width' =>$uploaded_data['image_width'],
									'height' =>$uploaded_data['image_height']
									);
			$this->commonmodel->commonAddEdit('file_upload',$new_file_upload);
			$uploaded_data['file_upload_id'] = $this->db->insert_id();
			$uploaded_data['file_upload_file_path'] = $new_file_upload['file_path'];
			$uploaded_data['file_upload_file_name'] = $new_file_upload['file_name'];
			$uploaded_data['file_upload_file_size'] = $new_file_upload['size'];
			
			
			
			$msg = array('status' => '1', 'data' => $uploaded_data);
			unlink($uploaded_data['full_path']);
		}
		echo json_encode($msg);
		exit;
	
	
	
	
	/*
		
		//relative to uploads dir
		$file_field_name = $this->input->post('field_name','userfile');
		$folder_chain = explode("/",$this->input->post('folder_name'));
		$upload_path = './../uploads';
		$folder_loc = '';
		foreach($folder_chain as $folder_name){
			$folder_loc = $folder_loc ."/".$folder_name;;
			$folder_path = $upload_path . "/" .$folder_loc;
			
			if (! is_dir($folder_path)){
				mkdir($folder_path, 0777);
				chmod($folder_path, 0777);
			}		
		}
		
		
		if($folder_loc){
			$config['upload_path'] = './../uploads'.$folder_loc.'/';	
		}else{
			$config['upload_path'] = './../uploads/';
		}
		
		
		$config['allowed_types'] = '*';
		$config['max_size']	= '102400';
		$config['max_width']  = '102400';
		$config['max_height']  = '76800';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file_field_name)){

			$msg = array('status' => '0', 'data' => $this->upload->display_errors());			
		}else{

			$uploaded_data = $this->upload->data();
			//print_r($uploaded_data);exit;
			$new_file_upload = array(
				'file_name' => $uploaded_data['file_name'],
				'file_path' => $config['upload_path'].$uploaded_data['file_name'],
				'type' => $uploaded_data['file_type'],
				'size' => $uploaded_data['file_size']
			);
			
			$this->commonmodel->commonAddEdit('file_upload',$new_file_upload);
			$uploaded_data['file_upload_id'] = $this->db->insert_id();
			$uploaded_data['file_upload_file_path'] = $new_file_upload['file_path'];
			$uploaded_data['file_upload_file_name'] = $new_file_upload['file_name'];
			$uploaded_data['file_upload_file_size'] = $new_file_upload['size'];
			$msg = array('status' => '1', 'data' => $uploaded_data);		
		}

		echo json_encode($msg);
		exit;
	*/}




	function saveYoutubeVideo()
	{
		
		$youtube_data = $this->input->post('data');
		
		//$url = "http://www.youtube.com/watch?v=C4kxS1ksqtw&feature=relate";
		parse_str( parse_url( $youtube_data, PHP_URL_QUERY ), $my_array_of_vars );
		if(array_key_exists('v',$my_array_of_vars)){
			$new_file_upload = array(
				'file_name' => $my_array_of_vars['v'],
				'file_path' => $youtube_data,
				'type' => 'video/youtube',
				'size' => '0'
			);
				
			$this->commonmodel->commonAddEdit('file_upload',$new_file_upload);
			
			
			$uploaded_data['file_upload_id'] = $this->db->insert_id();
			$uploaded_data['file_upload_file_path'] = $new_file_upload['file_path'];
			$uploaded_data['file_upload_file_name'] = $new_file_upload['file_name'];
			$uploaded_data['file_upload_file_size'] = $new_file_upload['size'];
			$msg = array('status' => '1', 'data' => $uploaded_data);
			
			echo json_encode($msg);
			exit;
		}else{
			$msg = array('status' => '0', 'data' => "Youtube url is not valid");
			echo json_encode($msg);
			exit;
		}
	}


	function delete()
	{
		$file_upload_id = $this->input->post('file_upload_id');
		$file_detail = $this->commonmodel->getRecords('file_upload','file_path',array('file_upload_id'=>$file_upload_id),'',true);
		if(is_file($file_detail['file_path'])) {
			unlink($file_detail['file_path']);
			$this->commonmodel->deleteRecords('file_upload'," file_upload_id = '$file_upload_id'");
			echo "1";
		}else{
			echo "0";
		}
	}

	/* myShowImage function is used to 
	*  show image in admin section.
	*/	
	function myShowImage()
	{
		$file_upload_id = $this->input->post('file_upload_id');
		$thumb_width = $this->input->post('t_width');
		$thumb_height = $this->input->post('t_height');
		$file_detail = $this->commonmodel->getRecords('file_upload','file_name, file_path, type, width, height',array('file_upload_id'=>$file_upload_id),'',true);
		
		$this->load->library('amazons3');
		
		$mapArray = array('0'=>'original','30'=>'50','40'=>'50','50'=>'50','80'=>'100','90'=>'100','100'=>'100','102'=>'100','105'=>'100','110'=>'100','111'=>'100','113'=>'100','123'=>'100','140'=>'150','148'=>'150','150'=>'150','180'=>'200',	'200'=>'200','260'=>'400','350'=>'400','400'=>'400','450'=>'400','700'=>'700');
		
		$thumb_size_array = array('original'=>'_1024X768', '50'=>'_50X50', '100'=>'_100X100', '150'=>'_150X150', '200'=>'_200X200', '700'=>'_700X700');
		$mapVal = $mapArray[$thumb_width];
		$appendStr = $thumb_size_array[$mapVal];
		
		if(!empty($file_detail)){
			
				$fileName = $file_detail['file_name'];
				$ext = '.' . end(explode('.', $fileName));
				$newName = str_replace($ext, $appendStr . $ext, $fileName);
				$fileNameInBucket = "uploads/".$newName;
				$contentts = $this->amazon_s3_client->getObjectInfo(BUCKET_NAME, $fileNameInBucket);
			
				if(!empty($contentts))
				{
						$orignal_thumb_file_path = S3_URL.BUCKET_NAME."/".$fileNameInBucket;
						echo "<img src=\"".$orignal_thumb_file_path."\" alt=\"Wait\"   height=\"$thumb_height\" width=\"$thumb_width\"/>";
				}else{
						echo "<img src=\"images/thumbs/no-image110x110.jpg\" alt=\"\" height=\"$thumb_height\" width=\"$thumb_width\"/>";
				}
	    }else{
		  	echo "<img src=\"images/thumbs/no-image110x110.jpg\" alt=\"\" height=\"$thumb_height\" width=\"$thumb_width\"/>";	
	 	}
		/*$file_upload_id = $this->input->post('file_upload_id');
		$thumb_width = $this->input->post('t_width');
		$thumb_height = $this->input->post('t_height');
		

		$file_detail = $this->commonmodel->getRecords('file_upload','file_upload_id,file_name, file_path, type, width, height', array('file_upload_id'=>$file_upload_id), '', true);

		$upload_path = '.././uploads/thumbs';
		$folder_loc = $thumb_width."-".$thumb_height;		
		$folder_path = $upload_path . "/" .$folder_loc;
		/*$thumb_file_path = $folder_path."/".$file_detail['file_name'];*/

		/*if(array_key_exists('file_name',$file_detail))
		{
			$thumb_file_path = $folder_path."/".$file_detail['file_name'];
			if(is_file($thumb_file_path))
			{
				echo "<img src='".$thumb_file_path."' alt='' />";
				exit;
			}

		}		

		if(array_key_exists('file_path',$file_detail) == true  && $file_upload_id != null){
			 $thumb_file_path = $folder_path."/".$file_detail['file_name'];				
			
			if(is_file("../".$file_detail['file_path'])) {
				
				if (! is_dir($folder_path)){
					mkdir($folder_path, 0777);
					chmod($folder_path, 0777);
				}	
				list($img_width, $img_height, $img_type, $img_attr) = getimagesize("../".$file_detail['file_path']);
				
				if($img_width > $thumb_width){
						$thumb_config = array(
									'source_image' => "../".$file_detail['file_path'], //get original image
									'new_image' => $folder_path, //save as new image //need to create thumbs first
									'maintain_ratio' => false,
									'width' => $thumb_width,
									'height' => $thumb_height
								);
						$this->load->library('image_lib', $thumb_config); //load library
						$this->image_lib->clear();
						$this->image_lib->initialize($thumb_config);
						$this->image_lib->resize(); //do whatever specified in config
						$new_thumb_file_path = $folder_path."/".$file_detail['file_name'];
						echo "<img src='$new_thumb_file_path' alt='' />";
						exit;
				}else{
					echo "<img src='"."../".$file_detail['file_path']."' alt='' />";
					exit;
				}

			}
		else
		{
			echo "<img src='.././uploads/thumbs/no-image110x110.jpg' alt='' height='$thumb_width' width='$thumb_height'/>";
		}

	  }
	  else
		{
			echo "<img src='.././uploads/thumbs/no-image110x110.jpg' alt='' height='$thumb_width' width='$thumb_height'/>";
		}*/
	}


	function showImage(){
		
		$file_upload_id = $this->input->post('file_upload_id');
		$thumb_width = $this->input->post('t_width');
		$thumb_height = $this->input->post('t_height');
		$file_detail = $this->commonmodel->getRecords('file_upload','file_name, file_path, type, width, height',array('file_upload_id'=>$file_upload_id),'',true);
		
		$this->load->library('amazons3');
		
		$mapArray = array('0'=>'original','30'=>'50','40'=>'50','50'=>'50','80'=>'100','90'=>'100','100'=>'100','102'=>'100','105'=>'100','110'=>'100','111'=>'100','113'=>'100','123'=>'100','140'=>'150','148'=>'150','150'=>'150','180'=>'200',	'200'=>'200','260'=>'400','350'=>'400','400'=>'400','450'=>'400','700'=>'700');
		
		$thumb_size_array = array('original'=>'_1024X768', '50'=>'_50X50', '100'=>'_100X100', '150'=>'_150X150', '200'=>'_200X200', '700'=>'_700X700');
		$mapVal = $mapArray[$thumb_width];
		$appendStr = $thumb_size_array[$mapVal];
		
		if(!empty($file_detail)){
			
				$fileName = $file_detail['file_name'];
				$ext = '.' . end(explode('.', $fileName));
				$newName = str_replace($ext, $appendStr . $ext, $fileName);
				$fileNameInBucket = "uploads/".$newName;
				$contentts = $this->amazon_s3_client->getObjectInfo(BUCKET_NAME, $fileNameInBucket);
			
				if(!empty($contentts))
				{
						$orignal_thumb_file_path = S3_URL.BUCKET_NAME."/".$fileNameInBucket;
						echo "<img src=\"".$orignal_thumb_file_path."\" alt=\"Wait\"   height=\"$thumb_height\" width=\"$thumb_width\"/>";
				}else{
						echo "<img src=\"images/thumbs/no-image110x110.jpg\" alt=\"\" height=\"$thumb_height\" width=\"$thumb_width\"/>";
				}
	    }else{
		  	echo "<img src=\"images/thumbs/no-image110x110.jpg\" alt=\"\" height=\"$thumb_height\" width=\"$thumb_width\"/>";	
	 	}
		
		
		/*$file_upload_id = $this->input->post('file_upload_id');
		$thumb_width = $this->input->post('t_width');
		$thumb_height = $this->input->post('t_height');
		$image_file = true;
		$file_detail = $this->commonmodel->getRecords('file_upload','file_name,file_path,type',array('file_upload_id'=>$file_upload_id),'',true);
		
		if(array_key_exists('file_path',$file_detail)){
		echo "<img src=\"./.".$file_detail['file_path']."\" alt=\"\" height=\"$thumb_width\" width=\"$thumb_height\"/>";
		}
		else
		{
			echo "<img src=\"uploads/default_images.jpg\" alt=\"\" height=\"$thumb_width\" width=\"$thumb_height\"/>";
		}
		exit;
			
		if(array_key_exists('file_path',$file_detail)){
		
		if(is_file($file_detail['file_path'])) {
			
			if (! is_dir($folder_path)){
				mkdir($folder_path, 0777);
				chmod($folder_path, 0777);
			}	
			if($image_file){			
			$thumb_config = array(
                        'source_image' => $file_detail['file_path'], //get original image
                        'new_image' => $folder_path, //save as new image //need to create thumbs first
                        'maintain_ratio' => false,
                        'width' => $thumb_width,
                        'height' => $thumb_height
                    );

            $this->load->library('image_lib', $thumb_config); //load library
			$this->image_lib->clear();
			$this->image_lib->initialize($thumb_config);
            $this->image_lib->resize(); //do whatever specified in config
			$new_thumb_file_path = $folder_path."/".$file_detail['file_name'];
			}else{
				$ffmpeg_command = "ffmpeg -itsoffset -4  -i ".$file_detail['file_path']." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 150x150 $folder_path/video-$file_upload_id.jpg";
				echo $debug = shell_exec($ffmpeg_command);
				$new_thumb_file_path = $folder_path."/video-$file_upload_id.jpg";
			}
			echo "<img src=\"$new_thumb_file_path\" alt=\"\" />";
			exit;			
		}else{
			exit;
		}
		}else{
			echo "<img src=\"uploads/thumbs/no-image110x110.jpg\" alt=\"\" height=\"$thumb_width\" width=\"$thumb_height\"/>";
		}*/
	
	}

	function nicEdit()
	{
			
			$this->load->model('niceditmodel');
			
			if (! is_dir(ROOT_PATH."uploads"))
			{
				mkdir(ROOT_PATH."uploads", 0777);
				chmod(ROOT_PATH."uploads", 0777);
			}
			
			define('NICUPLOAD_PATH', './uploads'); // Set the path (relative or absolute) to the directory to save image files
												  
			define('NICUPLOAD_URI', 'uploads');   // Set the URL (relative or absolute) to the directory defined above

			$nicupload_allowed_extensions = array('jpg','jpeg','png','gif','bmp');

			// You should not need to modify below this line
			$rfc1867 = function_exists('apc_fetch') && ini_get('apc.rfc1867');

			if(!function_exists('json_encode')) {
				die('{"error" : "Image upload host does not have the required dependicies (json_encode/decode)"}');
			}

			$id = $_POST['APC_UPLOAD_PROGRESS'];
			if(empty($id)) {
				$id = $_GET['id'];
			}

			if($_SERVER['REQUEST_METHOD']=='POST') { // Upload is complete
				if(empty($id) || !is_numeric($id)) {
					$this->niceditmodel->nicupload_error('Invalid Upload ID');
				}
				if(!is_dir(NICUPLOAD_PATH) || !is_writable(NICUPLOAD_PATH)) {
					nicupload_error('Upload directory '.NICUPLOAD_PATH.' must exist and have write permissions on the server');
				}
				
				$file = $_FILES['nicImage'];
				$image = $file['tmp_name'];
				
				$max_upload_size = $this->niceditmodel->ini_max_upload_size();
				if(!$file) {
					$this->niceditmodel->nicupload_error('Must be less than '.$this->niceditmodel->bytes_to_readable($max_upload_size));
				}
				
				$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
				@$size = getimagesize($image);
				if(!$size || !in_array($ext, $nicupload_allowed_extensions)) {
					$this->niceditmodel->nicupload_error('Invalid image file, must be a valid image less than '.$this->niceditmodel->bytes_to_readable($max_upload_size));
				}
				
				$filename = $id.'.'.$ext;
				$path = NICUPLOAD_PATH.'/'.$filename;
				$amazon_path =  NICUPLOAD_PATH."/";
				if(!move_uploaded_file($image, $path)) {
					$this->niceditmodel->nicupload_error('Server error, failed to move file');
				}
				
				if($rfc1867) {
					$status = apc_fetch('upload_'.$id);
				}
				if(!$status) {
					$status = array();
				}
				$status['done'] = 1;
				$status['width'] = $size[0];
				/* upload file on amazon bucket */
				$this->load->library('amazons3');
				$this->amazon_s3_client->putBucket(BUCKET_NAME, S3::ACL_PUBLIC_READ);
				$this->amazon_s3_client->putObjectFile($path, BUCKET_NAME ,substr($amazon_path, 2).$filename, S3::ACL_PUBLIC_READ);
				$file_check_in_bucket = substr($amazon_path, 2).$filename;
				$file_url = $this->amazon_s3_client->getObjectInfo(BUCKET_NAME, $file_check_in_bucket);
				
				
				//$orignal_thumb_file_path = S3_URL.BUCKET_NAME."/".$file_check_in_bucket;
				$status['url'] = $this->niceditmodel->nicupload_file_uri($filename);
				//$status['url'] = $this->niceditmodel->nicupload_file_uri($filename);
				
				if($rfc1867) {
					apc_store('upload_'.$id, $status);
				}

				$this->niceditmodel->nicupload_output($status, $rfc1867);
				exit;
				
				
			} else if(isset($_GET['check'])) { // Upload progress check
				$check = $_GET['check'];
				if(!is_numeric($check)) {
					$this->niceditmodel->nicupload_error('Invalid upload progress id');
				}
				
				if($rfc1867) {
					$status = apc_fetch('upload_'.$check);
					
					if($status['total'] > 500000 && $status['current']/$status['total'] < 0.9 ) { // Large file and we are < 90% complete
					$status['interval'] = 3000;
				} else if($status['total'] > 200000 && $status['current']/$status['total'] < 0.8 ) { // Is this a largeish file and we are < 80% complete
					$status['interval'] = 2000;
				} else {
					$status['interval'] = 1000;
				}
					
					$this->niceditmodel->nicupload_output($status);
				} else {
					$status = array();
					$status['noprogress'] = true;
					foreach($nicupload_allowed_extensions as $e) {
						if(file_exists(NICUPLOAD_PATH.'/'.$check.'.'.$e)) {
							$ext = $e;

							break;
						}
					}
					if($ext) {
						$status['url'] = $this->niceditmodel->nicupload_file_uri($check.'.'.$ext);
					}
					$this->niceditmodel->nicupload_output($status);
				}
			}
			
			
			
			
			
			
			/*$this->load->model('niceditmodel');
			define('NICUPLOAD_PATH', './uploads/post/paragraph-images'); // Set the path (relative or absolute) to
												  // the directory to save image files
												  
			define('NICUPLOAD_URI', 'uploads/post/paragraph-images');   // Set the URL (relative or absolute) to
												  // the directory defined above

			$nicupload_allowed_extensions = array('jpg','jpeg','png','gif','bmp');

			// You should not need to modify below this line

			$rfc1867 = function_exists('apc_fetch') && ini_get('apc.rfc1867');

			if(!function_exists('json_encode')) {
				die('{"error" : "Image upload host does not have the required dependicies (json_encode/decode)"}');
			}

			$id = $_POST['APC_UPLOAD_PROGRESS'];
			if(empty($id)) {
				$id = $_GET['id'];
			}

			if($_SERVER['REQUEST_METHOD']=='POST') { // Upload is complete
				if(empty($id) || !is_numeric($id)) {
					$this->niceditmodel->nicupload_error('Invalid Upload ID');
				}
				if(!is_dir(NICUPLOAD_PATH) || !is_writable(NICUPLOAD_PATH)) {
					nicupload_error('Upload directory '.NICUPLOAD_PATH.' must exist and have write permissions on the server');
				}
				
				$file = $_FILES['nicImage'];
				$image = $file['tmp_name'];
				
				$max_upload_size = $this->niceditmodel->ini_max_upload_size();
				if(!$file) {
					$this->niceditmodel->nicupload_error('Must be less than '.$this->niceditmodel->bytes_to_readable($max_upload_size));
				}
				
				$ext = strtolower(substr(strrchr($file['name'], '.'), 1));
				@$size = getimagesize($image);
				if(!$size || !in_array($ext, $nicupload_allowed_extensions)) {
					$this->niceditmodel->nicupload_error('Invalid image file, must be a valid image less than '.$this->niceditmodel->bytes_to_readable($max_upload_size));
				}
				
				$filename = $id.'.'.$ext;
				$path = NICUPLOAD_PATH.'/'.$filename;
				
				if(!move_uploaded_file($image, $path)) {
					$this->niceditmodel->nicupload_error('Server error, failed to move file');
				}
				
				if($rfc1867) {
					$status = apc_fetch('upload_'.$id);
				}
				if(!$status) {
					$status = array();
				}
				$status['done'] = 1;
				$status['width'] = $size[0];
				$status['url'] = $this->niceditmodel->nicupload_file_uri($filename);
				
				if($rfc1867) {
					apc_store('upload_'.$id, $status);
				}

				$this->niceditmodel->nicupload_output($status, $rfc1867);
				exit;
			} else if(isset($_GET['check'])) { // Upload progress check
				$check = $_GET['check'];
				if(!is_numeric($check)) {
					$this->niceditmodel->nicupload_error('Invalid upload progress id');
				}
				
				if($rfc1867) {
					$status = apc_fetch('upload_'.$check);
					
					if($status['total'] > 500000 && $status['current']/$status['total'] < 0.9 ) { // Large file and we are < 90% complete
					$status['interval'] = 3000;
				} else if($status['total'] > 200000 && $status['current']/$status['total'] < 0.8 ) { // Is this a largeish file and we are < 80% complete
					$status['interval'] = 2000;
				} else {
					$status['interval'] = 1000;
				}
					
					$this->niceditmodel->nicupload_output($status);
				} else {
					$status = array();
					$status['noprogress'] = true;
					foreach($nicupload_allowed_extensions as $e) {
						if(file_exists(NICUPLOAD_PATH.'/'.$check.'.'.$e)) {
							$ext = $e;
							break;
						}
					}
					if($ext) {
						$status['url'] = $this->niceditmodel->nicupload_file_uri($check.'.'.$ext);
					}
					$this->niceditmodel->nicupload_output($status);
				}
			}*/
	}

	function videoThumb(){
		$video = 'path/to/video.flv';
		$thumbnail = 'path/to/thumbnail.jpg';
		// shell command [highly simplified, please don't run it plain on your script!]
		shell_exec("ffmpeg -i $video -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
	}
}
?>