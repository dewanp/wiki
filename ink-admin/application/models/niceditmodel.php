<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Niceditmodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function nicupload_error($msg) {
		echo $this->nicupload_output(array('error' => $msg)); 
	}

	function nicupload_output($status, $showLoadingMsg = false) {
    $script = '
        try {
            '.(($_SERVER['REQUEST_METHOD']=='POST') ? 'top.' : '').'nicUploadButton.statusCb('.json_encode($status).');
        } catch(e) { alert(e.message); }
    ';
    
    if($_SERVER['REQUEST_METHOD']=='POST') {
        echo '<script>'.$script.'</script>';
    } else {
        echo $script;
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST' && $showLoadingMsg) {      

echo <<<END
    <html><body>
        <div id="uploadingMessage" style="text-align: center; font-size: 14px;">
            <img src="http://js.nicedit.com/ajax-loader.gif" style="float: right; margin-right: 40px;" />
            <strong>Uploading...</strong><br />
            Please wait
        </div>
    </body></html>
END;

    }
    
    exit;
}

	/*function nicupload_file_uri($filename) {
		return NICUPLOAD_URI.'/'.$filename;
	}*/
	
	function nicupload_file_uri($filename) {
		//https://s3-us-west-1.amazonaws.com/inksmash-live/uploads/post/paragraph-images/721254610850115.jpg
		//return NICUPLOAD_URI.'/'.$filename;
		return S3_URL.BUCKET_NAME.'/'.NICUPLOAD_URI.'/'.$filename;
	}

	function ini_max_upload_size() {
		$post_size = ini_get('post_max_size');
		$upload_size = ini_get('upload_max_filesize');
		if(!$post_size) $post_size = '8M';
		if(!$upload_size) $upload_size = '2M';
		
		return min( $this->ini_bytes_from_string($post_size), $this->ini_bytes_from_string($upload_size) );
	}

	function ini_bytes_from_string($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}

	function bytes_to_readable( $bytes ) {
		if ($bytes<=0)
			return '0 Byte';
	   
		$convention=1000; //[1000->10^x|1024->2^x]
		$s=array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
		$e=floor(log($bytes,$convention));
		return round($bytes/pow($convention,$e),2).' '.$s[$e];
	}
	
  
}
/* End of file Niceditmodel.php */
/* Location: ./application/models/Niceditmodel.php */