<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
		$this->load->model(array('commonmodel','usermodel','postmodel'));
	}

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function index()
	{
		$data = array();
		
		$data['post_capsule_list'] = '';
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		
		$this->load->view('includes/header');
		$this->load->view('search/search',$data);
		$this->load->view('includes/footer');
	}

	/**
	 * This function is used to load more search posts from db 
	 * Created by Neelesh Choukesy on 2012.03.26
	 * 
	 */
	public function loadMoreSearch()
	{
		$post = $this->input->post();
		$offset = $this->input->post('offset');
		
		if($post['keyword'] != '')
		{
			$data['posts'] = $this->postmodel->getPosts($offset, 8, $post);
		}
		
		if(!empty($data['posts']))
		{
			$this->load->view("post/post-list-content",$data);
		}else if(!empty($data['posts']) && count($data['posts']) >= 8)
		{
			echo'<div class="searchdtl">There are no more Posts to show for this. Create another one for this <a href="post/add" class="btnorange" style="float:none;">Create Post</a></div>';
		}
		
		if(isset($data['posts']) && empty($data['posts']))
		{
			 echo'<div class="searchdtl">There are no more Posts to show for this. Create another one for this <a href="post/add" class="btnorange" style="float:none;">Create Post</a></div>';			
		}
		
	}

}
/* End of file message.php */
/* Location: ./application/controllers/message.php */