<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  Amazon ECS - Config
* 
* Author: Pradeep Mishra
* 	 	  pradeep@vinfotec.com
*        
*          
*          
* Created:  4/3/2012 
* 
* Description:  This is a Codeigniter library which allows you to Search Amazon Products, 
* and also lets you put in the you affiliate id so your results will return your associated affiliate link
*
* Requirements: PHP 5.1 or above
* 
*/
class Amazon {
		
	public function __construct() {
		require_once APPPATH.'third_party/AmazonECS.class.php';		
		$amazon_client_obj = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, AWS_LANG, AWS_ASSOCIATE_TAG);		
		$CI =& get_instance();
		$CI->amazon_client = $amazon_client_obj;			
	}
	
}