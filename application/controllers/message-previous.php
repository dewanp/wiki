<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'image'));
		$this->load->model(array('commonmodel','usermodel'));
	}

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function index()
	{
		$data = array();
				
		$data['posts'] = $this->commonmodel->getRecords('post','','','created_date desc');
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('message/message',$data);
		$this->load->view('includes/footer');
	}

	

	

	
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */