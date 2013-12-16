<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->model('categorymodel');
		// Your own constructor code
	}

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function autocomplete($vid = 1)
	{
					
			echo '[{"key": "hello world", "value": "hello world"}, {"key": "movies", "value": "movies"}, {"key": "ski", "value": "ski"}, {"key": "snowbord", "value": "snowbord"}, {"key": "computer", "value": "computer"}, {"key": "apple", "value": "apple"}, {"key": "pc", "value": "pc"}, {"key": "ipod", "value": "ipod"}, {"key": "ipad", "value": "ipad"}, {"key": "iphone", "value": "iphone"}, {"key": "iphon4", "value": "iphone4"}, {"key": "iphone5", "value": "iphone5"}, {"key": "samsung", "value": "samsung"}, {"key": "blackberry", "value": "blackberry"}]';
			exit;
		
	}
	
	public function posts($vid = 1)
	{
		$data = array();
		$this->load->view('includes/header');
		$this->load->view('category/post-list',$data);
		$this->load->view('includes/footer');
		
	}

	



	
	/**
	 * login Page for this controller.
	 *
	 */
	public function termEdit()
	{
		
			$data = array();
			$this->load->view('taxonomy/term-add',$data);
		
		
	}

	public function termDelete()
	{
		redirect('taxonomy/term');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */