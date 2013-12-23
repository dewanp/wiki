<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {
	
	var $page_title = "";
	var $page_keywords = "";
	var $page_desc = "";
	var $user = array();
	var $user_id =0;
	
	public $childcategory = array();
    public $parentcategory = array();
	
	/**
	 * Index Page for this controller.
	 */
	
	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form','image_helper','cookie'));
		$this->load->model(array('commonmodel','capsulemodel','postmodel','usermodel','mymodel'));
		// Your own constructor code
		$this->user_id = $this->session->userdata('user_id');
		if($this->user_id == '')
		{
			redirect('user/login');
		}
	}

	/**
	 * Index Page for this controller.
	 */
	
	public function index()
	{
		$data = array();
				
		$data['posts'] = $this->commonmodel->getRecords('post','','','created_date desc');
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('post/post-list',$data);
		$this->load->view('includes/footer');
		
	}

	/*
	 * This function is used to display all post posted by current user.
	*/
	public function mypost()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		else
		{
			redirect();
		}
		
		$data = array();
		
		if(array_key_exists('search',$_GET) && $_GET['search']!=''){
				if(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_GET['search']))
				{
					$rs_posts = $this->db->select('p.*,count(ph.ip_address) as hit')->from('post as p')->join('post_hit as ph','ph.post_id = p.post_id','left')->like('title', $_GET['search'])->where(array('p.user_id' =>$this->user_id,'p.is_block'=>0))->group_by('p.post_id')->order_by("p.created_date", "desc")->get();
					$data['indication'] = 'Usingsearch';
					
				}else{
					$rs_posts = $this->db->select('p.*,count(ph.ip_address) as hit')->from('post as p')->join('post_hit as ph','ph.post_id = p.post_id','left')->like('title', $_GET['search'])->where(array('p.user_id' =>$this->user_id,'p.is_block'=>0))->group_by('p.post_id')->order_by("p.created_date", "desc")->get();
					$data['indication'] = 'Usingsearch';
				}
		}else{
			$data['indication'] = 'mypost';
			$rs_posts = $this->db->select('p.*,count(ph.ip_address) as hit')->from('post as p')->join('post_hit as ph','ph.post_id = p.post_id','left')->where(array('p.user_id'=>$this->user_id,'p.is_block'=>0)) ->group_by('p.post_id')->order_by("p.created_date", "desc")->get();
			
		}
			

		$data['posts'] = $rs_posts->result_array();
		$data['isZipCode'] = $this->commonmodel->isZipCode();
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('post/my-post-list',$data);
		$this->load->view('includes/footer');
	}

	/**
	 * this function is for adding any post to the database.
	 *
	 */
	public function publish($post_id){
		if($this->commonmodel->isLoggedIn())
		{ 
			$user_id = $this->session->userdata('user_id');
			$this->db->update('post', array('is_active' => 1), array('post_id' => $post_id, 'user_id' => $user_id));
			redirect(getPostUrl($post_id));
		}
		else
		{
			redirect('user/login');
		}
		
	}
	
	public function add($category_id='')
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		else
		{
			redirect('user/login');
		}
		$data = array();
		
		$permission = $this->commonmodel->check_permission($category_id,$this->user_id);
		if(!$permission){
			$this->session->set_flashdata('Insufficient_rights', 'Insufficient rights for create/edit post.');
			redirect('post/allcategories');
			exit;
		}
		
		$data['category'] = $category_id;
		$data['capsules'] = $this->commonmodel->getRecords('capsule_type', '', array('is_active' => 1));
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('post/post-add',$data);
		$this->load->view('includes/footer');
	}
	
	
	
	/*
	* This function is first step of creating post i.e. Make Post or Create new post
	* Function is used for save post by ajax.
	* Modified by Ashvin Soni.
	*/
	public function addPost()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		else
		{
			redirect('user/login');
		}
		$category_id = $this->input->post('category');
		if ($this->input->post('add_post') == 'Add new post')
		{
			$user_id = $this->user_id;
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('category', 'Category', 'required');
									
			$this->form_validation->set_error_delimiters('', '');
			if ($this->form_validation->run() == FALSE)
			{
				$data = array();
				$data['title'] = $this->input->post('title');
				$data['category'] = $this->input->post('category');
				$data['description'] = $this->input->post('description');
				
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				$this->load->view('includes/header');
				$this->load->view('post/post-add',$data);
				$this->load->view('includes/footer');
			}
			else
			{
				$new_post = array(
					'title' => $this->input->post('title'),
					'category_id' => $category_id,
					'sub_category_id' => $category_id,
					'description' => $this->input->post('description'),
					'user_id' => $this->user_id,
					'created_date' => time(),
					'changed_date' => time(),
					'is_active' => 1,
					'is_block' => 1
				);
			
				$this->commonmodel->commonAddEdit('post', $new_post);
				$new_post_id = $this->db->insert_id();
				if($new_post_id != '')
				{
					redirect('post/showposts/'.$category_id);
				}
			}
	 	}else{
			redirect('post/showposts/'.$category_id);
		}
	}
	
	/**
	 * post edit function
	 *
	 */
	public function edit($post_id, $category_id)
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		else
		{
			redirect('user/login');
		}
		
		$data = array();
		//load current post
		$post = $this->commonmodel->getRecords('post', '', array('post_id' => $post_id), '', true);
		
		if(empty($post)){
			show_404();
		}
		$data['post'] = $post;
		$data['category'] = $category_id;
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('post/post-edit',$data);
		$this->load->view('includes/footer');
	}
	
	/*
	* This function is first step of creating post i.e. Make Post or edit existing post
	* Function is used for edit post.
	* Created by Ashvin Soni.
	*/
	public function editPost()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		else
		{
			redirect('user/login');
		}
		$category_id = $this->input->post('category');
		if ($this->input->post('edit_post') == 'Edit post')
		{
			$user_id = $this->user_id;
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('category', 'Category', 'required');
									
			$this->form_validation->set_error_delimiters('', '');
			$post_id = $this->input->post('post_id');
			if ($this->form_validation->run() == FALSE)
			{
				$data = array();
				$data['title'] = $this->input->post('title');
				$data['category'] = $this->input->post('category');
				$data['description'] = $this->input->post('description');
				
				
				$post = $this->commonmodel->getRecords('post', '', array('post_id' => $post_id), '', true);
				$data['post'] = $post;
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				$this->load->view('includes/header');
				$this->load->view('post/post-edit',$data);
				$this->load->view('includes/footer');
			}
			else
			{
				$new_post = array(
					'title' => $this->input->post('title'),
					'category_id' => $category_id,
					'sub_category_id' => $category_id,
					'description' => $this->input->post('description'),
					'user_id' => $user_id,
					'created_date' => time(),
					'changed_date' => time(),
					'is_active' => 1,
					'is_block' => 1
				);
			
				$this->commonmodel->commonAddEdit('post', $new_post,$post_id);
				redirect('post/showposts/'.$category_id);
			}
	 	}else{
			redirect('post/showposts/'.$category_id);
		}
	}

	
	/**
	 * view function for any post this controller.
	 *
	 */
	public function view($post_id, $capsule_type="")
	{ 
		
		$post = $this->commonmodel->getRecords('post', '', array('post_id' => $post_id), '', true);
		
		if(!empty($post)){
			$post_id = $post['post_id'];
		}else{
			$post_id = "0";
		}
		
		$rs_post_hit = $this->db->select("*")->from('post_hit')->where(array('post_id'=>$post_id ,'ip_address'=> $this->input->ip_address()))->get();
		if(!$rs_post_hit->num_rows()){
			$this->db->insert('post_hit',array('post_id'=>$post_id ,'ip_address'=> $this->input->ip_address()));
		}
		
		
		$user_id = $this->session->userdata('user_id');
		$data = array();
		$data['user_id'] = $user_id;
		$data['post_id'] = $post_id;
		$data['capsule_type'] = $capsule_type;
		$post_author_id = $this->commonmodel->getRecords('post', 'user_id', array('post_id' => $post_id), '', true);
       
		$data['post_author_id'] = $post_author_id['user_id'];

		if(empty($post)){
			show_404();
		}
		
		$data['post'] = $post;
		
		// post My Favorites
		if($this->commonmodel->isLoggedIn()) {
			$check_favorites = $this->commonmodel->getRecords('post_my_favorites','',array('user_id'=>$user_id,'post_id'=>$post_id),'',true);
					
			if(array_key_exists('post_my_favorites_id',$check_favorites))
			{
				$data['my_favorites'] = '<div class="removefavorites"><a href="javascript:void(0);" onclick ="removeFavorites ('.$user_id.','.$post_id.')" title="Remove from My Favorite"></a></div>';
			}
			else
			{
				$data['my_favorites'] = '<div class="addfavorite"> <a href="javascript:void(0);" onclick ="myFavorites('.$user_id.','.$post_id.')" title="Add to My Favorite"></a></div>';
			}
		}
		else
		{
				$data['my_favorites'] = "";
		}

		//post subscribe-unsubscribe
		if($this->commonmodel->isLoggedIn()) {
			$check_subscribe = $this->commonmodel->getRecords('post_subscribe_unsubscribe','',array('user_id'=>$user_id,'post_id'=>$post_id),'',true);

			if(array_key_exists('post_subscribe_unsubscribe_id',$check_subscribe))
			{
				$data['subscribe_unsubscribe'] = '<div class="unSubPost"><a href="javascript:void(0);" onclick ="subscribePost ('.$user_id.','.$post_id.')" title="Subscribe Post"></a></div>';
			}
			else
			{
				$data['subscribe_unsubscribe'] = '<div class="subPost"> <a href="javascript:void(0);" onclick ="unsubscribePost('.$user_id.','.$post_id.')" title="Unsubscribe Post"></a></div>';
			}
		}
		else
		{
				$data['subscribe_unsubscribe'] = "";
		}
		
		// post image
		$data['post_image'] = $this->commonmodel->getRecords('file_upload', '', array('file_upload_id' => $post['post_image']) , '', true);
		// post category
		$data['post_category'] = $this->commonmodel->getRecords('category', '', array('category_id' => $post['category_id']) , '', true);
		// post sub category
		$data['post_sub_category'] = $this->commonmodel->getRecords('sub_category', '', array('sub_category_id' => $post['sub_category_id']) , '', true);
		// post tags
		$data['tags'] = $this->postmodel->tagDetailByPostId($post_id);
		
		
		//post capsules		
		$this->page_title = $post['title'];
		$this->page_desc = $post['description'];
		
		$this->page_keywords = $data['tags'];

		// all categories links left
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);


		$this->load->view('includes/header',$data);
		$this->load->view('post/post-view');
		$this->load->view('includes/footer');
		$this->session->set_userdata('redirect_url',current_url());
	}

	/*
	 * This function is used to show tags to user while tagging to post.
	*/
	public function tagAutocomplete()
	{
		 $tag = trim($this->input->get('term'));	
		 
		$tag_array = $this->postmodel->getTagsAutocomplete($tag);
		echo json_encode($tag_array);
		exit;
	}
	
	/*
	* This function is used to delete post completely from database i.e  from post, capsule,file_upload,post_tag
	   all capsules table(like list,paragraph,images etc), capsule.
	*/
	public function delete()
	{
		$post_id = $this->input->post('post_id');
		
		$rs_post = $this->db->select('*')->from('post')->where('post_id',$post_id)->get();

		// load current post
		$post = $rs_post->row_array();
		
		// post image
		$this->db->update('file_upload', array('is_active' => 0), array('file_upload_id' => $post['post_image']));
		
		// post tags
		$this->db->delete('post_tag', array('post_id' => $post_id));
		

		$rs_post_capsules = $this->db->select('*')->from('capsule')->where('post_id' ,$post_id)->get();
		
		foreach($rs_post_capsules->result_array() as $key => $capsule){

			// delete first if value for capsule is added
			if($capsule['capsule_type_id'] == 1){				
				$this->db->delete('paragraph', array('capsule_id' => $capsule['capsule_id']));				
			}elseif($capsule['capsule_type_id'] == 2){				
				$this->db->delete('list', array('capsule_id' => $capsule['capsule_id']));				
			}elseif($capsule['capsule_type_id'] == 3){				
				$this->db->delete('image', array('capsule_id' => $capsule['capsule_id']));				
			}elseif($capsule['capsule_type_id'] == 4){				
				$this->db->delete('video', array('capsule_id' => $capsule['capsule_id']));				
			}elseif($capsule['capsule_type_id'] == 5){				
				$this->db->delete('comment', array('capsule_id' => $capsule['capsule_id']));				
			}elseif($capsule['capsule_type_id'] == 6){				
				$rs_post_capsules_polls = $this->db->select('*')->from('polls')->where('capsule_id' ,$capsule['capsule_id'])->get();
				foreach($rs_post_capsules_polls->result_array() as $polls){
					
					// to do votes table delete
					$this->db->delete('option', array('source_id' => $polls['polls_id'], 'type' => 0));
				}
				$this->db->delete('polls', array('capsule_id' => $capsule['capsule_id']));				
			}elseif($capsule['capsule_type_id'] == 7){				
				$rs_post_capsules_opinion = $this->db->select('*')->from('opinion')->where('capsule_id' ,$capsule['capsule_id'])->get();
				foreach($rs_post_capsules_opinion->result_array() as $opinion){
					
					// to do votes table delete
					$this->db->delete('option', array('source_id' => $opinion['opinion_id'], 'type !=' => 0));
				}
				$this->db->delete('opinion', array('capsule_id' => $capsule['capsule_id']));				
			}			
		}
		
		$this->db->delete('capsule', array('post_id' => $post_id));
		
		$this->db->delete('post', array('post_id' => $post_id)); 
	}

	/*
	* This function is used to display post lists of selected category.
	*/

	public function category($category_id)
	{
		$data = array();
		
		$category = $this->commonmodel->getRecords('category','category_id',array('category_id' => $category_id),'', true);
		
		if(!empty($category)){
			$data['posts'] = $this->commonmodel->getRecords('post','',array('category_id' => $category_id),'created_date desc');
		}else{
			$data['posts'] = $this->commonmodel->getRecords('post','','','created_date desc');
		}
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		
		$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('post/post-list',$data);
		$this->load->view('includes/footer');
	}


	/**
	 * Created by Neelesh Chouksey on 2012.02.29
	 * This function is used to show image posts.
	 * 
	 */
	
	public function showPosts($type = '')
	{
		$data = array();
		if($this->user_id != '')
		{
			$data['type'] = $type;
			 
                $permission = $this->commonmodel->check_permission($type,$this->user_id);
			
			if(!$permission){
				redirect('post/allcategories');
				exit;
			}
			 
			$this->display_children($type,0);
            $this->display_parent($type,0);
            ksort($this->childcategory);
			ksort($this->parentcategory);
            $data['breadcrumb'] = $this->parentcategory;
			$data['child_category'] = $this->childcategory;
			//echo'<pre>';print_r($data['child_category']);
             
			$data['permission'] = $permission;
			$data['posts'] = $this->postmodel->getCategoriesPosts($this->user_id,$type);
			
			$data['most_posted_users'] = true;
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['login_user_id'] = $this->user_id;
			
			$data['status'] = 'not exist';
			$data['post_capsule_list'] = $this->load->view('post/left-moreblock', $data, true);
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			$this->load->view('includes/header');
			$this->load->view('post/post-list',$data);
			$this->load->view('includes/footer');
		}else{
			redirect('user/login');
		}
		
	}


	/**
	 * This function is used to load more posts from db 
	 * Created by Neelesh Choukesy on 2012.02.22
	 * 
	 */
	public function loadMoreShowPosts()
	{
		$type = $this->input->post('type');
		$offset = $this->input->post('offset');
		$data['posts'] = $this->postmodel->getShowPosts($type, $offset);
		$this->load->view("post/post-list-content",$data);
	}

	/**
	 * Created by Neelesh Chouksey on 2012.03.02
	 * This function is used to fetch city autosuggest values. // JSON
	 * 
	 */
	public function cityAutocomplete()
	{ 
		$term = $this->input->get('term');
		$rs_citys = $this->db->select('*')->from('usa_zip_codes')->like('city', $term)->or_like('zip_code', $term)->get();

		$cities =  $rs_citys->result_array();
		foreach($cities as $city_row)
		{
			$autosuggest_cities[] = '{"label":"'.$city_row['zip_code'].'-'.$city_row['city'].' ('.$city_row['state'].')'.'"}';
		}
		echo '['.implode(',',$autosuggest_cities).']';;
		exit;
				
	}
	
	/**
	 * This function is used to load rating functionality 
	 * Created by Neelesh Choukesy on 2012.03.20
	 * 
	 */
	public function loadRating()
	{
		$capsule_id = $this->input->post('capsule_id');
		$edit = $this->input->post('edit');
		$data = $this->postmodel->getAvgRating($capsule_id);
		$data['capsule_id'] = $capsule_id;
		$data['edit'] = $edit;
		
		$this->load->view('rating',$data);
	}

	/**
	 * This function is used to apply rating functionality 
	 * Created by Neelesh Choukesy on 2012.03.20
	 * 
	 */
	public function applyRating()
	{
		$capsule_id = $this->input->post('capsule_id');
		$rate = $this->input->post('rate');

		$is_exist = $this->commonmodel->getRecords('rate','capsule_id',array('capsule_id' =>$capsule_id),'',true);
		if($is_exist)
		{ 
			$where = "capsule_id = '$capsule_id'";
			$query = $this->db->update_string('rate', array('rate'=>$rate), $where);
		}
		else
		{
			$query = $this->db->insert_string('rate', array('capsule_id'=>$capsule_id, 'rate'=>$rate));
		}
		$this->db->query($query);
	}
	
	/**
	 * Created by Neelesh Chouksey on 2012.03.26
	 * This function is used to show all categories on the page.
	 * 
	 */
	
	public function allCategories($start=0)
	{
		$this->load->library('pagination');
		$data = array();
		
		$data['type'] = $type = 'all';
		$data['most_posted_users'] = true;
		$data['child_category'] = $this->postmodel->get_user_all_category($this->user_id); 
		
		$limit=200;
		$start = $this->uri->segment(3,$start);	
		$all = count($data['categories']);
		
		$config['base_url'] = site_url("post/allCategories");
		$config['total_rows'] =  $all ;
		$config['per_page'] = $limit;
		$config['uri_segment'] = '3' ;
		$config['num_links'] = '2';
		$config['next_link'] = 'Next';
		$config['prev_link'] ='Previous';
		$this->pagination->initialize($config);
		
		$data['post_capsule_list'] = '';
		$data['status'] = 'exist';
		$data['user_id'] = $this->user_id;
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		if($this->session->flashdata('Insufficient_rights')!= ''){
			$data['flash_msg'] = $this->session->flashdata('Insufficient_rights');
		}
		
		$this->load->view('includes/header');
		$this->load->view('post/all-categories',$data);
		$this->load->view('includes/footer');
	}
	
	/*
	 * This function is used to load view for Edit category .
	*/
	public function displayEditCategory($parent_category_id=0,$category_id=0)
	{
		 
		if($category_id)	{		
			$permission = $this->commonmodel->check_permission($category_id,$this->user_id);
             
			$data['permission'] = $permission;
			if($permission != 1){
				redirect('post/allcategories');
				exit;
			}
			
			$inherited = $this->commonmodel->check_inherited($category_id,$this->user_id);
			$data['inheritance'] = $inherited;
			
			$category_detail = $this->mymodel->displayEditCategory($category_id);
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="category";
			$data['category_detail'] = $category_detail;            
			$data['parent_category'] = $category_detail['parent'];
			
            $category_result = $this->display_children($category_id,0);
            
            if(empty($this->childcategory)) 
                $data['have_child_cat']= 0;
                else
            $data['have_child_cat']= 1;
                
                
                $this->display_children($category_id,0);
            $this->display_parent($category_id,0);
            ksort($this->childcategory);
			ksort($this->parentcategory);
            $data['type'] = $category_id;
            $data['permission'] = $permission;
        }if($parent_category_id){ 
            $permission = $this->commonmodel->check_permission($parent_category_id,$this->user_id);
             
			$data['permission'] = $permission;
			if($permission != 1){
				redirect('post/allcategories');
				exit;
			}
            $this->display_children($parent_category_id,0);
            $this->display_parent($parent_category_id,0);
            ksort($this->childcategory);
			ksort($this->parentcategory);
            $data['parent_category'] = $parent_category_id;
            $data['type'] = $parent_category_id;
            $data['permission'] = $permission;
        }
        
        
        	
            $data['breadcrumb'] = $this->parentcategory;
			$data['child_category'] = $this->childcategory;
			$data['section'] = 'front-end';
			
			$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->order_by('profile_name','asc')->get();
			$data['user_result'] = $user_result->result_array();
			
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
            
			$this->load->view('includes/header');
            $this->load->view('post/add-edit-category',$data);
			$this->load->view('includes/footer');
		 
	}
	
	/*
	 * This function is used for getting suggestion from user about new category in this site
	 * Called by Ajax function.
	 * Created by : ashvin
	*/

	public function suggestCategory()
	{
		$category_id = $this->input->post('category_id');
		$sub_category_name = $this->input->post('sub_cat_name');
		$main_category = $this->input->post('main_category');		
		$admin = $this->input->post('admin');
		$read_write = $this->input->post('read_write');
		$read = $this->input->post('read');
		$user_id = $this->input->post('user_id');
		
		$category_name = ucwords(strtolower($sub_category_name));
		
		$data = array();
		$data =array('name'=>$category_name,'description'=>$category_name,'is_active'=>1, 'parent'=>$main_category);		
		$this->commonmodel->commonAddEdit('category',$data);
		$category_id = $this->db->insert_id();
		
		//code for make root category
		$admindata = array();
		
		$admins = explode(',',$admin);
		//first check if parent_category exist then get all admins related to parent and then inherited =1
		if( !empty($admin) && !empty($main_category) )
		{
			//now get admin for parent_category
			$parent_admin = $this->postmodel->getOldAdminCategories($main_category);
			if(!empty($parent_admin))
			{	
				$parent_admin_cat = explode(',',$parent_admin['user_ids']);
				
				foreach($admins as $key=>$val)
				{
					if( in_array($val,$parent_admin_cat)){
						$admindata[] = array('user_id' => $val,
										 'category_id' => $category_id,
										 'permission_type' =>1,
										 'is_inherited' => 1,
										 'created_by' => $user_id
										 );
					}else{
						$admindata[] = array('user_id' => $val,
										 'category_id' => $category_id,
										 'permission_type' =>1,
										 'is_inherited' => 0,
										 'created_by' => $user_id
										 );
					}
				}
			}
		}
		
		if( !empty($admin) && empty($main_category) )
		{	
			foreach($admins as $key=>$val)
			{
				$admindata[] = array('user_id' => $val,
									 'category_id' => $category_id,
									 'permission_type' =>1,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
			}
		}
		
		if(!empty($read_write))
		{	
			$read_writes = explode(',',$read_write);
			foreach($read_writes as $rwkey=>$rwval)
			{
				$admindata[] = array('user_id' => $rwval,
									 'category_id' => $category_id,
									 'permission_type' =>2,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
			}
		}
		
		if(!empty($read))
		{	
			$reads = explode(',',$read);
			foreach($reads as $rkey=>$rval)
			{
				$admindata[] = array('user_id' => $rval,
									 'category_id' => $category_id,
									 'permission_type' =>3,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
			}
		}
		$this->db->insert_batch('user_category_relation', $admindata);
		
		//Code for make sub category if parent is selected
		/*if($main_category != '' && $main_category != 0)
		{	
			//first get all admin ids realted to parent_id
			$parent_ids = $this->postmodel->getOldAdminCategories($parent);
			
			//now deleted which admin match both array admin and parent_ids
			if(!empty($parent_ids))
			{
				if(!empty($admin))
				{
					$admins = explode(',',$admin);
					foreach($admins as $key=>$val)
					{
						$parent_array = explode(',',$parent_ids['user_ids']);
						if(in_array($val,$parent_array))
						{
							$this->db->delete('user_category_relation', array('user_id' => $val,'category_id'=>$category_id,'permission_type'=>1,'is_inherited'=>0));				 
							// Now make inherited data for sub-cateory
							$parent_data = array('user_id' => $val,'category_id'=>$category_id,'permission_type'=>1,'is_inherited'=>1,'created_by'=>$user_id);
							$this->db->insert('user_category_relation', $parent_data); 
						}
					}
				}
			}
		}*/
		echo "0";
		exit;
	}
	
	/*
	*	Function for edit category
	*/
	public function editCategory()
	{
		$category_id = $this->input->post('category_id');
		
		//first get all related name, title,parent,for selected category
		$category_info = $this->postmodel->editcategoryInfo($category_id);
		
		if(!empty($category_info))
		{
			$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->get();
			$data['user_result'] = $unset_array =  $user_result->result_array();
			
			//get admin user for this category
			$admin_user = $this->db->select('user_id')
						  ->from('user_category_relation')
						  ->where('category_id',$category_id)
						  ->where('permission_type',1)					  
						  ->get();
			$admin_user_ids = array();
			foreach($admin_user->result_array() as $admindval)
			{
				$admin_user_ids[] = $admindval['user_id'];
			}
			
			//now get all inherited user for category
			$inherited_user = $this->db->select('user_id')
						  ->from('user_category_relation')
						  ->where('category_id',$category_id)
						  ->where('permission_type',1)
						  ->where('is_inherited',1)
						  ->get();
						  
			$inherited_user_ids = array();
			foreach($inherited_user->result_array() as $inheriteddval)
			{
				$inherited_user_ids[] = $inheriteddval['user_id'];
			}
			
			//now combine both arrays and get unique value
			$merge_array = array();
			if( !empty($admin_user_ids) && !empty($inherited_user_ids) ){
				$merge_array = array_unique(array_merge($admin_user_ids,$inherited_user_ids));
			}elseif( !empty($admin_user_ids) &&  empty($inherited_user_ids)){
				$merge_array = $admin_user_ids;
			}elseif( empty($admin_user_ids) &&  !empty($inherited_user_ids)){
				$merge_array = $inherited_user_ids;
			}
			
			//get name for ids to show on view
			$admin_names = $admin_ids = '';
			foreach($user_result->result_array() as $adminkey=>$adminval)
			{
				if( in_array($adminval['user_id'],$merge_array) )
				{
					$admin_names .= ' <label>'.$adminval['profile_name'].' ,</label> ';
					$admin_ids .=  $adminval['user_id'].',';
				}
				
			}
			
			//now make admin d.d. for w/o selcted admin/inherited users
			$adminsel = '';
			$user_array = array(); 
			foreach($unset_array as $firstkey=>$firstval)
			{
				//now make array index is id
				$user_array[$firstval['user_id']] = $firstval;
			}
			foreach($user_array as $userkey=>$userval)
			{	
				if( isset($merge_array) && in_array($userkey,$merge_array) ){
					unset($user_array[$userkey]);
				}			
			}
			foreach($user_array as $newkey=>$newval)
			{
				$adminsel .= '<option value="'.$newval['user_id'].'">'.$newval['profile_name'].'</option>';
			}
		
			//now make read/write select
			$rwids = explode(',',$category_info['rw_id']);
			$rwsel = '';
			foreach($user_result->result_array() as $rwkey=>$rwval)
			{
				if( in_array($rwval['user_id'],$rwids) )
				{
					$rwsel .= '<option value="'.$rwval['user_id'].'" selected="selected">'.$rwval['profile_name'].'</option>';
				}else{
					$rwsel .= '<option value="'.$rwval['user_id'].'">'.$rwval['profile_name'].'</option>';
				}
				
			}
			
			//now make read select
			$rids = explode(',',$category_info['r_id']);
			$rsel = '';
			foreach($user_result->result_array() as $rkey=>$rval)
			{
				if( in_array($rval['user_id'],$rids) )
				{
					$rsel .= '<option value="'.$rval['user_id'].'" selected="selected">'.$rval['profile_name'].'</option>';
				}else{
					$rsel .= '<option value="'.$rval['user_id'].'">'.$rval['profile_name'].'</option>';
				}
				
			}
			
			$output = array(
							'category_id'=>$category_info['category_id'],
							'name'=>$category_info['name'],
							'parent'=>$category_info['parent'],
							'admin_names'=>$admin_names,
							'admin_ids'=>$admin_ids,
							'admin'=>$adminsel,
							'rw'=>$rwsel,
							'r'=>$rsel,
							'status'=>'success',
							);
			echo json_encode($output);
		
		}else{
			$output = array('status'=>'fail');
			echo json_encode($output);
		}
		exit;
	}
	
	public function ajaxedit_category()
	{
		$category_id = $this->input->post('sub_category_id');
		$sub_category_name = $this->input->post('sub_cat_name');
		$parent = $this->input->post('main_category');		
		
		$category_name = ucwords(strtolower($sub_category_name));
		
		$category_data = array('name' =>$sub_category_name,
							   'description'=>$sub_category_name,
							   'parent'	=> $parent
							);

		$this->db->where('category_id',$category_id);
		$this->db->update('category',$category_data);
		
		//parameters for add user_category_relation
		$user_id = $this->input->post('user_id');
		$admin = $this->input->post('admin');
		$read_writ = $this->input->post('read_write');
		$readd = $this->input->post('read');
		$prev_ids = $this->input->post('prev_ids');
		
		$this->db->delete('user_category_relation',array('category_id'=>$category_id));
		
		//insert data
		$admindata = array();
		
		if( !empty($prev_ids) )
		{	
			$prev_id = explode(',',$prev_ids);
			foreach($prev_id as $prevkey=>$prevval)
			{
				if($prevval != ''){
					$admindata[] = array('user_id' => $prevval,
										 'category_id' => $category_id,
										 'permission_type' =>1,
										 'is_inherited' => 1,
										 'created_by' => $user_id
										 );	
				}
			}
		}
		
		
		if( !empty($parent) )
		{
			//now get admin for parent_category
			$parent_admin = $this->postmodel->getOldAdminCategories($parent);
			if(!empty($parent_admin))
			{
				$parent_admin_cat = explode(',',$parent_admin['user_ids']);
				foreach($parent_admin_cat as $key=>$val)
				{
					$admindata[] = array('user_id' => $val,
									 'category_id' => $category_id,
									 'permission_type' =>1,
									 'is_inherited' => 1,
									 'created_by' => $user_id
									 );
				}
			}
		}
		
		if( !empty($admin) )
		{	
			$admins = explode(',',$admin);
			foreach($admins as $key=>$val)
			{
				$admindata[] = array('user_id' => $val,
									 'category_id' => $category_id,
									 'permission_type' =>1,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
			}
		}
		
		if(!empty($read_writ))
		{	
			$read_write = explode(',',$read_writ);
			foreach($read_write as $rwkey=>$rwval)
			{
				$admindata[] = array('user_id' => $rwval,
									 'category_id' => $category_id,
									 'permission_type' =>2,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
			}
		}
		
		if(!empty($readd))
		{	
			$read = explode(',',$readd);
			foreach($read as $rkey=>$rval)
			{
				$admindata[] = array('user_id' => $rval,
									 'category_id' => $category_id,
									 'permission_type' =>3,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
			}
		}
		$this->db->insert_batch('user_category_relation', $admindata);
		
		//after this get all child categories and delete all user record for permission type 1 and inherited == 1
		//Imp code for get all subcategories related to category in one array
		$category_result = $this->display_children($category_id,0);
		
		if( !empty($this->childcategory) )
		{
			foreach($this->childcategory as $childcat)
			{
			$this->db->delete('user_category_relation',array('category_id'=>$childcat, 'permission_type' => 1 ,'is_inherited = '=> 1));
			
				$categorydata = array();
				if(!empty($admin))
				{	
					$admins = explode(',',$admin);
					foreach($admins as $key=>$val)
					{
						$categorydata[] = array('user_id' => $val,
											 'category_id' => $childcat,
											 'permission_type' =>1,
											 'is_inherited' => 1,
											 'created_by' => $user_id
											 );	
					}
					$this->db->insert_batch('user_category_relation', $categorydata);
				}
			}
		}
		echo "0";
		exit;
	}
	
	
	/* Function for get sub-catetgories related to root category*/
	function display_children($parent, $level)
	{ 
 		$query = 'SELECT c.category_id,c.name,cr.permission_type FROM category c left join user_category_relation cr on c.category_id=cr.category_id and cr.user_id="'.$this->user_id.'" WHERE c.parent="'.$parent.'" AND c.is_active = 1';
		$resultt = $this->db->query($query);
	
		foreach($resultt->result_array() as $row)
		{ 
		 
			if($row['permission_type'] > 0)
			{
				$thisref = &$this->childcategory;					 
				$thisref[$row['category_id']]['id'] =   $row['category_id'];
				$thisref[$row['category_id']]['name'] =   $row['name'];
				$thisref[$row['category_id']]['permission_type'] =   $row['permission_type'];			
				$this->childcategory =  &$thisref; 
			}
			 
			$this->display_children($row['category_id'], $level+1);
		} 
	}
	
	/* Function for get sub-catetgories related to root category*/
	function display_parent($child, $level)
	{ 
		$query = 'SELECT c.category_id,c.is_active,c.parent,c.name,cr.permission_type FROM category c left join user_category_relation cr on c.category_id=cr.category_id and cr.user_id="'.$this->user_id.'" WHERE c.category_id="'.$child.'" ';
		$resultt = $this->db->query($query);
	
		foreach($resultt->result_array() as $row)
		{ 
            if($row['is_active']==1){
                $thisref = &$this->parentcategory;
                $thisref[$row['parent']]['id'] =   $row['category_id'];
                $thisref[$row['parent']]['parent'] =   $row['parent'];
                $thisref[$row['parent']]['name'] =   $row['name'];
                $thisref[$row['parent']]['permission_type'] =   $row['permission_type'];
                $this->parentcategory =  &$thisref ; 		
                //echo '<pre>';print_r($thisref);
            }
			$this->display_parent($row['parent'], $level+1);
		} 
	}
	
	
	/*
	 * This function is used to show post to user.
	 * Called by Ajax function.
	*/
	public function postBasicInfo()
	{
		$post_id = $this->input->post('post_id');
		$view_type = $this->input->post('view_type','view');
		$data['post_id'] = $post_id;
		// load current post
		$post = $this->commonmodel->getRecords('post', '', array('post_id' => $post_id), '', true);	
		$data['post'] = $post;
		

		//User information of this post
		$user_info = $this->commonmodel->getRecords('user','user_name,profile_name', array('user_id'=>$post['user_id']), '',true);
		$data['user_info'] = $user_info ;
		
		// Zip code of current user
		$data['isZipCode'] = $this->commonmodel->isZipCode();
		
		// post category
		$data['post_category'] = $this->commonmodel->getRecords('category', '', array('category_id' => $post['category_id']) , '', true);
		// post sub category
		$data['post_sub_category'] = $this->commonmodel->getRecords('sub_category', '', array('sub_category_id' => $post['sub_category_id']) , '', true);
		$data['category_list'] = $this->commonmodel->getRecords('category');
		$data['sub_category_list'] = $this->commonmodel->getRecords('sub_category');
		// post tags
		$data['tags'] = $this->postmodel->tagDetailByPostId($post_id);

		$result =$this->db->select('z.city, s.state')
							->from('post as p')
							->join('usa_zip_codes as z','p.post_zip_code = z.zip_code','left')
							->join('state as s','z.state = s.abbreviation','left')
							->where('p.post_id',$post_id)
							->get();
		$result = $result->row_array();
		$data['post']['city'] = $result['city'];
		$data['post']['state'] = $result['state'];
		$data['ip_address'] = $this->input->ip_address();
		
		echo $this->load->view('post/basic-info/'.$view_type, $data, true);
		exit;
	}
	
	
	
	public function myFavorites()
	{
		$user_id = $this->input->post("user_id");
		$post_id = $this->input->post("post_id");
		$this->commonmodel->addEditRecords('post_my_favorites',array('user_id'=>$user_id,'post_id'=>$post_id));
	}
	public function removeFavorites()
	{
		 $user_id = $this->input->post("user_id");
		 $post_id = $this->input->post("post_id");
		
		 $condition ='user_id = '.$user_id.' AND post_id ='.$post_id ;
		 $this->commonmodel->deleteRecords('post_my_favorites',$condition);
	}
	
	/* function for unsubscribe post for user */
	public function unsubscribePost()
	{
		  $user_id = $this->input->post("user_id");
		  $post_id = $this->input->post("post_id");
		
		  $this->commonmodel->addEditRecords('post_subscribe_unsubscribe',array('user_id'=>$user_id,'post_id'=>$post_id));
	}
	
	/* function for unsubscribe post for user */
	public function subscribePost()
	{
		 $user_id = $this->input->post("user_id");
		 $post_id = $this->input->post("post_id");
		
		 $condition ='user_id = '.$user_id.' AND post_id ='.$post_id ;
		 $this->commonmodel->deleteRecords('post_subscribe_unsubscribe',$condition);
	}

	public function postAnswer()
	{
		 $post_id = $this->input->post('post_id');
		 $description = $this->input->post('description');
		 if($this->session->userdata('user_id'))
		{
			 $user_id = $this->session->userdata('user_id');
  			 $rs_user_name =   $this->db->select('user_name, profile_name, picture')
										->from('user')
										->where('user_id',$user_id)
										->get();
			 $data['user'] = $rs_user_name->row_array();			
		}
		else
		{
			$user_id = 0;
			$user = array('user_name'=> "", 'profile_name'=>'Anonymous','picture' =>0);
			$data['user'] = $user;
		}
		$post_author_id = $this->commonmodel->getRecords('post', 'user_id', array('post_id' => $post_id), '', true);
		$data['post_author_id'] = $post_author_id['user_id'];
		
		$insert_data = array('user_id'=>$user_id, 'post_id'=>$post_id, 'description'=>$description, 'created_date'=> time());
		$account_setting_info = $this->commonmodel->getRecords('user_account_setting', 'user_id,someone_answer_question,someone_answer_question_you_answer','','',true);
		
		/* if checkbox checked from account setting then shoot email otherwise do nothing */
		if($account_setting_info['someone_answer_question'] == 1)
		{
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$profile_name = $this->commonmodel->getRecords('user','profile_name,user_name',array('user_id'=>$this->user_id),'',true);
				$commenter_name = "<a href=".base_url().$profile_name['user_name'].">".$profile_name['profile_name']."</a>";
			}
			$post_link =  "<a href=".getPostUrl($post_id).">".getPostUrl($post_id)."</a>";
			$italic_text = "<i>".$description."</i>";
			
			/* code for send email when someone answer your question */
			$user_id_using_post = $this->commonmodel->getRecords('post','user_id', array('post_id'=>$post_id),'',true);
			$email_using_user_id = $this->commonmodel->getRecords('user','profile_name,email', array('user_id'=>$user_id_using_post['user_id']),'',true);
			
			
			$single_subscribe_unsubscribe_info =  $this->commonmodel->getRecords('post_subscribe_unsubscribe','post_subscribe_unsubscribe_id,user_id', array('user_id'=>$user_id_using_post['user_id'],'post_id'=>$post_id),'',true);
			
			if(empty($single_subscribe_unsubscribe_info))
			{
			
				$this->commonmodel->setMailConfig();
				$subject = constant('SOMEONE_ANSWER_YOUR_QUESTION');
															
				//for mail text
				$mail_text = constant('SOMEONE_ANSWER_YOUR_QUESTION_MAIL');
				$mail_search = array("{FIRST_NAME}","{POST_TITLE}","{COMMENTER_NAME}","{COMMENT}");
				$mail_replace = array("".$email_using_user_id['profile_name']."","".$post_link."","".$commenter_name."","".$italic_text."");
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('SOMEONE_ANSWER_YOUR_QUESTION_FOOTER');
				
				// for mail tepmlate
				$template_string = constant('MAIL_TEMPLATE');
				$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
				$template_replace = array("".$mail_body."","".$mail_footer."");
					
				$message =	str_replace($template_search, $template_replace, $template_string);
				
				$this->email->from(FROM_EMAIL, 'InkSmash');
				$this->email->to($email_using_user_id['email']);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->commonmodel->sendEmail();
			}	
	} //first end if
	
	// second condition
	if($account_setting_info['someone_answer_question_you_answer'] == 1)
	{
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$profile_name = $this->commonmodel->getRecords('user','user_name,profile_name',array('user_id'=>$this->user_id),'',true);
				$commenter_name = "<a href=".base_url().$profile_name['user_name'].">".$profile_name['profile_name']."</a>";
			}
			$post_link =  "<a href=".getPostUrl($post_id).">".getPostUrl($post_id)."</a>";
			$italic_text = "<i>".$description."</i>";
			
			$answer_count = $this->commonmodel->getRecords('answer','user_id,post_id', array('post_id'=>$post_id),'',false);
			foreach($answer_count as $answer_id){
				
				$subscribe_unsubscribe_info =  $this->commonmodel->getRecords('post_subscribe_unsubscribe','post_subscribe_unsubscribe_id,user_id', array('user_id'=>$answer_id['user_id'],'post_id'=>$post_id),'',true);
				
			if(empty($subscribe_unsubscribe_info))
			{
					$email_using_user_id = $this->commonmodel->getRecords('user','profile_name,email', array('user_id'=>$answer_id['user_id']),'',true);
					
					$this->commonmodel->setMailConfig();
					$subject = constant('SOMEONE_ANSWERED_QUESTION_YOU_ANSWERED');
																
					//for mail text
					$mail_text = constant('SOMEONE_ANSWERED_QUESTION_YOU_ANSWERED_MAIL');
					$mail_search = array("{FIRST_NAME}","{POST_TITLE}","{COMMENTER_NAME}","{COMMENT}");		
					$mail_replace = array("".$email_using_user_id['profile_name']."","".$post_link."","".$commenter_name."","".$italic_text."");	
					$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
					
					//for mail footer
					$mail_footer = constant('SOMEONE_ANSWERED_QUESTION_YOU_ANSWERED_FOOTER');
					
					// for mail tepmlate
					$template_string = constant('MAIL_TEMPLATE');
					$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
					$template_replace = array("".$mail_body."","".$mail_footer."");
						
					$message =	str_replace($template_search, $template_replace, $template_string);
					
					$this->email->from(FROM_EMAIL, 'InkSmash');
					$this->email->to($email_using_user_id['email']);
					$this->email->subject($subject);
					$this->email->message($message);
					$this->commonmodel->sendEmail();
				}
			}//foreach end
		}// second if end.

		 $this->commonmodel->addEditRecords('answer', $insert_data);
		 $data['new_answer_id'] = $this->db->insert_id();
		 $data['description'] = $description;
		 $data['created_date'] = time();
		 echo $this->load->view('post/qna-wrapper',$data);
	}

	public function deleteAnswer()
	{
		$answer_id = $this->input->post('answer_id');
		$this->db->delete('answer', array('answer_id' => $answer_id));

	}

	/**
	 * This function is used to apply report abuse functionality 
	 * Created by Neelesh Choukesy on 2012.05.29
	 * 
	 */
	public function reportAbuse()
	{
		$data = $this->input->post();
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['time'] = time();
		$this->commonmodel->commonAddEdit('report_abuse', $data);

		$this->session->set_userdata('reported_abuse_'.$data['post_id'],'1');
	}
	
	/**
	 * This function is used to category child functionality 
	 * Created by Pradeep Mishra on 2012.07.12
	 * 
	 */
	public function categoryChild()
	{
		$category_id = $this->input->get('category_id');
		$categoryChilds = $this->commonmodel->getRecords('category','*',array('parent'=>$category_id ,'is_active'=>1));
		
		$selectOption = count($categoryChilds).'##';
		
		foreach($categoryChilds as $categoryChild){
		$selectOption .= "<li value=\"".$categoryChild['category_id']."\" text=\"".$categoryChild['name']."\">																
							<img  src=\"images/how-to-items.png\"/>
							<span>".$categoryChild['name']."</span>
						  </li>";
		} 						  
		$selectOption .='';
		echo $selectOption;
	}
	
	/*	Function for make best any answer
	*	created by ashvin soni.
	*/
	public function make_best()
	{
		$answer_id = $this->input->post('answerId');
		$checked_value = $this->input->post('checked_value');
		
		$answer_data = array('is_best' => $checked_value);
		$this->commonmodel->commonAddEdit('answer', $answer_data, $answer_id);
		
		if($checked_value == 1)
		{
			$user_id = $this->commonmodel->getRecords('answer','user_id,post_id,description', array('answer_id'=>$answer_id),'',true);
			$email_by_user_id = $this->commonmodel->getRecords('user','profile_name,user_name,email', array('user_id'=>$user_id['user_id']),'',true);
			
			$post_author = $this->commonmodel->getRecords('post','user_id,post_id', array('post_id'=>$user_id['post_id']),'',true);
			$post_author_name = $this->commonmodel->getRecords('user','user_name,profile_name', array('user_id'=>$post_author['user_id']),'',true);
			
			$post_owner = "<a href=".base_url().$post_author_name['user_name'].">".$post_author_name['profile_name']."</a>";
			$post_link =  "<a href=".getPostUrl($user_id['post_id']).">".getPostUrl($user_id['post_id'])."</a>";
			
			$this->commonmodel->setMailConfig();
			$subject = constant('MAKE_BEST_ANSWER');
														
			//for mail text
			$mail_text = constant('MAKE_BEST_ANSWER_MAIL');
			$mail_search = array("{FIRST_NAME}","{POST_TITLE}","{POST_OWNER}");		
			$mail_replace = array("".$email_by_user_id['profile_name']."","".$post_link."","".$post_owner."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('MAKE_BEST_ANSWER_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
				
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($email_by_user_id['email']);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();
		}
		echo'success';
	}

	/*	
	*	Function for show tag related post.
	*	Created date 28-11-2012 by Ashvin soni.
	*/	
	
	function tag()
	{
		$data = array();
		//$tag_name = str_replace("-"," ",$this->uri->segment(3));
		$tag_name = $this->uri->segment(3);
		
		$data['tag_name'] = $tag_name;
		$data['posts'] = $this->postmodel->getTagRelatedPost($tag_name);
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('post/tagpost-list',$data);
		$this->load->view('includes/footer');
	}
	
	
	
	
	/**
	 * function is used for publish post 
	 * Created date 7 jan 2013 by Ashvin soni.
	 * 
	 */
	public function publishPost()
	{
		$post_id = $this->input->post('post_id');
		$this->commonmodel->commonAddEdit('post', array('is_active'=>1), $post_id);
		
        $status = 'success';
		$unpublishPost = "<div class=\"unpublish-post\"><a href=\"javascript:void(0);\" onclick=\"unpublishPost('".$post_id."')\" title=\"Unpublish Post\"></a><div>";
		
		echo json_encode(array('data'=>$unpublishPost,'status'=>$status));
		exit;
	}

    /**
     * function is used for unfollow location
     * Created date 28-11-2012 by Ashvin soni.
     *
     */
    public function unpublishPost()
    {
        $post_id = $this->input->post('post_id');
		$this->commonmodel->commonAddEdit('post', array('is_active'=>0), $post_id);
        
		$status = 'success';
		$publishPost = "<div class=\"publish-post\"><a href=\"javascript:void(0);\" onclick=\"publishPost('".$post_id."')\" title=\"Publish Post\"></a></div>";
		
        echo json_encode(array('data'=>$publishPost,'status'=>$status));
        exit;
    }
	
	/**
	 * This function is used to apply rating functionality on post
	 * Created by Ashvin soni on 2012.12.24
	 * 
	 */
	public function applyRatingPost()
	{
		$post_id = $this->input->post('post_id');
		$rate = $this->input->post('rate');
		$ip_address = $this->input->post('ip_address');
		
		$is_exist = $this->commonmodel->getRecords('rate_post','post_id',array('ip_address' =>$ip_address,'post_id'=>$post_id),'',true);
		if($is_exist)
		{ 
			$where = "ip_address = '$ip_address'";
			$where .= " AND post_id = '$post_id'";
			$query = $this->db->update_string('rate_post', array('rate'=>$rate), $where);
		}
		else
		{
			$query = $this->db->insert_string('rate_post', array('post_id'=>$post_id, 'rate'=>$rate,'ip_address'=>$ip_address));
		}
		$this->db->query($query);
	}

	/*	
	*	Function for the update unique_post_token
	*/
	public function uniquePostToken()
	{
		$post_rs = $this->commonmodel->getRecords('post','post_id','','',false);
		foreach($post_rs as $post_ids){
			$where = "post_id = ".$post_ids['post_id'];
			$query = $this->db->update_string('post', array('unique_post_token'=>time().rand(0,9999999)), $where);		
			$this->db->query($query);
		}
	}
	
	/**
	*	function for get users list
	*/
	/** Function for get users list and show selected in dropa down */
	public function getUsersList()
	{
		$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->get();
		$data['user_result'] = $user_result->result_array();
		
		$output = '';
 		
		foreach($user_result->result_array() as $key=> $val)
		{
			$output .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
		}
		
		$users = array('users'=>$output);
		echo json_encode($users);
		exit;
	}
	
	/*Function for get category users */
	public function getCategryUsers()
	{
		$category_id = $this->input->post('category_id');
		$category_result = $this->db->select('read_write_user_ids')->from('user_category_relation')->where('category_id',$category_id)->get();
		$category = $category_result->row_array();
		
		$output = '';
		if( $category['read_write_user_ids'] != ''){
			$result = explode(',',$category['read_write_user_ids']);
			$output .= $category['read_write_user_ids'];
		}
		$parentusers = array('parentusers'=>$output);
		echo json_encode($parentusers);
		exit;
	}
	
	/*Function for get category users */
	public function getCategryReadUsers()
	{
		$category_id = $this->input->post('category_id');
		$category_result = $this->db->select('read_user_ids')->from('user_category_relation')->where('category_id',$category_id)->get();
		$category = $category_result->row_array();
		
		$output = '';
		if( $category['read_user_ids'] != ''){
			$result = explode(',',$category['read_user_ids']);
			$output .= $category['read_user_ids'];
		}
		$parentusers = array('parentusers'=>$output);
		echo json_encode($parentusers);
		exit;
	}
	
}
/* End of file post.php */
/* Location: ./application/controllers/post.php */