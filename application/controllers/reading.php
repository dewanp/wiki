<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reading extends CI_Controller {

	
	var $page_title = "Post";
	var $user = array();
	var $user_id =0;
	
	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->model(array('commonmodel','capsulemodel','postmodel','usermodel'));
		// Your own constructor code
		$this->user_id = $this->session->userdata('user_id');
		
		
	}

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function index()
	{
		$data = array();
		$data['posts'] = $this->postmodel->getPosts();
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar-reading', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('reading/reading',$data);
		$this->load->view('includes/footer');
		
	}

	/**
	 * This function is used to load more posts from db 
	 * Created by Neelesh Choukesy on 2012.02.22
	 * 
	 */
	public function loadMoreReadingPosts()
	{
		$offset = $this->input->post('offset');
		$view = $this->input->post('view');
		$data['posts'] = $this->postmodel->getPosts($offset);
		$this->load->view("reading/".$view,$data);
	}


	public function myreading()
	{
		
		if($this->session->userdata('user_id')!='' && $this->session->userdata('email')!='')
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		else
		{
			redirect('user/login');
		}
		
		$data = array();
				
			
		$data['posts'] = $this->commonmodel->getRecords('post','',array('user_id' => $this->user_id),'created_date desc');
		$data['isZipCode'] = $this->commonmodel->isZipCode();
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('reading/my-reading',$data);
		$this->load->view('includes/footer');
		
	}

	public function loadreading()
	{
		
		$data['posts'] = $this->commonmodel->getRecords('post','','','created_date desc');
		$this->load->view('reading/my-reading',$data);
	}

}

/* End of file post.php */
/* Location: ./application/controllers/post.php */