<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  Amazon S3 - Config
* 
* Author: Pradeep Mishra
* 	 	  pradeep@vinfotec.com
*        
*          
*          
* Created:  4/3/2012 
* 
* Description:  This is amazon s3 library for upload images / files on amazon server.
* 
*
* Requirements: PHP 5.1 or above
* 
*/
class amazons3 {
		
	public function __construct() {
		require_once APPPATH.'third_party/S3.class.php';		
		$amazon_s3_client_obj = new S3(AWS_S3_API_KEY, AWS_S3_SECRET_KEY);		
		$CI =& get_instance();
		$CI->amazon_s3_client = $amazon_s3_client_obj;			
	}
	
}