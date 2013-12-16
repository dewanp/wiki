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
class check_session {
		
	public function __construct()
	{
		$CI =& get_instance();
		$this->check_session_in_db();
	}
	
	public function check_session_in_db()
	{
		$CI =& get_instance();
		$CI->load->model('commonmodel');				
		$CI->load->helper(array('cookie'));
		
	}
	
	
}