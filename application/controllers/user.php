<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'image','cookie'));
		$this->load->model(array('commonmodel','usermodel'));
		$this->user_id = $this->session->userdata('user_id');
	}

	/**
	 * Index Page for this controller.
	*/
	public function feeds(){
		
		$data =array();

		if($this->commonmodel->isLoggedIn()){
			$rs_user = $this->db->select('*')
								->from('user')
								->where('user_id' ,$this->session->userdata('user_id'))
								->get();
			$user = $rs_user->row_array();

			if(!empty($user)){
			
				$rs_networkfeeds = $this->db->select("u.user_name, u.profile_name, p.post_id, p.title, p.description, p.created_date, p.post_image")
											->from('user_follow as uf')
											->join('user as u','uf.following=u.user_id','left')
											->join('post as p','p.user_id=u.user_id','left')
											->where(array('uf.follower'=>$this->session->userdata('user_id'), 'p.is_active'=>1,'p.is_block'=>0,'u.is_active'=>1))
											->order_by('p.created_date','desc')
											->limit(10)
											->get();
				
				$data['categories'] = $this->commonmodel->getRecords('category');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
				$data['post_capsule_list'] = '';
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				$data['user_id'] = $user['user_id'];
				$data['posts'] = $rs_networkfeeds->result_array();					

				$this->load->view('includes/header');
				$this->load->view('user/feeds',$data);
				$this->load->view('includes/footer');
			}
		}else{
			redirect('user/login');
		}
		
	}
	
	/* Function is used for the user when we write username in url.
	*  It shows username  related posts.
	*  Actual definetion in -- config/routes.php  for routing.
	*/
	public function profile($user_name = null , $my_favorites = ""){
		
		$data['user_name'] = $user_name;
		$user_id = $this->session->userdata('user_id');
		$data['all_post'] ="";
		$data['favorite'] ="";
		$data['static_profile'] = "active";
		$limit = 10;
		
		if($user_name){
			$rs_user = $this->db->select('*')
								->from('user')
								->where('user_name' ,$user_name)
								->get();
						
		}elseif($this->commonmodel->isLoggedIn()){
			$rs_user = $this->db->select('*')
								->from('user')
								->where('user_id' ,$user_id)
								->get();			
		}
		
		$user = $rs_user->row_array();
		if(!empty($user)){
		
			$data['user'] = $user;
			if($my_favorites == "favorites")
			{
				$rs_posts = $this->db->select('p.*,u.user_name,u.profile_name')
									 ->from('post as p')
									 ->join('post_my_favorites as pf','p.post_id = pf.post_id','left')
									 ->join('user as u','p.user_id = u.user_id','left')
									 ->join('category as cat','p.category_id=cat.category_id','left')
									 ->where(array('pf.user_id'=>$user['user_id'],'p.is_active'=>1,'p.is_block'=>0,'cat.is_active'=>1))
									 ->order_by("p.created_date", "desc")
									 ->limit($limit)
								     ->get();
				$data['favorite'] ="active";
			}
			else
			{
				$rs_posts = $this->db->select('p.*,u.user_name,u.profile_name')
									 ->from('post as p')
									 ->join('category as cat','p.category_id=cat.category_id','left')
									  ->join('user as u','p.user_id = u.user_id','left')
									 ->where(array('p.user_id'=>$user['user_id'],'cat.is_active'=>1,'p.is_active'=>1,'p.is_block'=>0))
									 ->order_by("created_date", "desc")
									 ->limit($limit)
									 ->get();
				$data['all_post'] ="active";
			}

			$rs_mostpost = $this->db->select('COUNT(p.post_id) AS post_count,cat.*')
								 ->from('post as p')
								 ->join('category as cat','p.category_id=cat.category_id','left')
								 ->where(array('p.user_id'=>$user['user_id'],'cat.is_active'=>1,'p.is_active'=>1,'p.is_block'=>0))
								 ->group_by("p.category_id")
								 ->order_by("post_count","DESC")		
								 ->limit(4)
								 ->get();

			if($this->commonmodel->isLoggedIn()){
			$rs_user_following = $this->db->select("user_follow_id")->from('user_follow')->where(array('following'=>$user['user_id'] ,'follower'=>$user_id))->get();
			
			if($rs_user_following->num_rows()){
				$followdata = $rs_user_following->row_array();
				$data['followthisuser']= "<div class=\"follow-link\"><a href=\"javascript:void(0);\" title=\"Unfollow this User\" onclick=\"unFollowUserbyAnyLocation(this,'".$followdata['user_follow_id']."','breadcrumb')\"></a></div>";
			
			}else{
				// no link for self profile
				if($user['user_id']!=$user_id){
					$data['followthisuser']= "<div class=\"unfollow-link\"><a href=\"javascript:void(0);\" title=\"Follow this User\"  onclick=\"followUserbyAnyLocation(this,'".$user['user_id']."','".$user_id."','breadcrumb')\"></a></div>";
				}else{
					$data['followthisuser']= "";
				}
			}
			}
			else
			{
						$data['followthisuser']= "";
			}
			
			$posts = $rs_posts->result_array();
			$data['posts'] = $posts;
			$mostpost = $rs_mostpost->result_array();
			$data['mostpost'] = $mostpost;
			
			$this->load->view('includes/header');
			$this->load->view('user/user-profile',$data);
			$this->load->view('includes/footer');

		}else{
			show_404();
		}
	}
	
	
	/* This function is used for the show ajax based all posts and
	*  My favorites posts.
	*  Created by :- ashvin soni -- 2013/02/01.
	*/
	public function userPosts(){
		
		$page_id = $this->input->post('page_id');
		$offset = $this->input->post('offset');
		$user_id = $this->input->post('user_id');
		$limit = 10;
		
		if(!empty($user_id)){
		
		switch($page_id){
			case 'myFavorites':
				$rs_myFavorites = $this->db->select('p.*,u.user_name,u.profile_name')
									 ->from('post as p')
									 ->join('post_my_favorites as pf','p.post_id = pf.post_id','left')
									 ->join('user as u','p.user_id = u.user_id','left')
									 ->join('category as cat','p.category_id=cat.category_id','left')
									 ->where(array('pf.user_id'=>$user_id,'p.is_active'=>1,'p.is_block'=>0,'cat.is_active'=>1))
									 ->order_by("p.created_date", "desc")
									 ->limit($limit)
								     ->get();
				$data['favorite'] ="active";
				$data['user_id'] = $user_id;
				$data['posts'] = $rs_myFavorites->result_array();
				
				echo $this->load->view('user/user-page/myfavourites',$data,true);
				break;
				
			case 'allPosts':
				$rs_allPosts = $this->db->select('p.*,u.user_name,u.profile_name')
									 ->from('post as p')
									 ->join('category as cat','p.category_id=cat.category_id','left')
									  ->join('user as u','p.user_id = u.user_id','left')
									 ->where(array('p.user_id'=>$user_id,'cat.is_active'=>1,'p.is_active'=>1,'p.is_block'=>0))
									 ->order_by("created_date", "desc")
									 ->limit($limit)
									 ->get();
				$data['all_post'] ="active";
				$data['user_id'] = $user_id;
				$data['posts'] = $rs_allPosts->result_array();
				
				echo $this->load->view('user/user-page/allposts',$data,true);
				break;
				
				default:
					echo '<div style="padding: 15px;">
							<div id="zip-info-box" class="info-block">	
								<span class="info-show">
									No Posts available right now for you. You may '.anchor('post/add','Create Post', 'class="btnorange" ').'.
								</span>
							</div>	
						</div>';
					exit;	
					break;
			}
		}	
	}
	
	
	
	/* 
	*	This function is used for show feeds acoording
	*	network tab and local tab.
	*/
	public function userPage(){
		
		$limit = 10;
		$page_id = $this->input->post('page_id');
		$offset = $this->input->post('offset');
		
		$cur_user_id = $this->session->userdata('user_id'); 
		
		$data = array();
		$data['type'] = "";
		switch($page_id){
			case 'networkfeeds':
				$rs_networkfeeds = $this->db->select("u.user_name, u.profile_name, p.post_id, p.title, p.description, p.created_date, p.post_image")
											->from('user_follow as uf')
											->join('user as u','uf.following=u.user_id','left')
											->join('post as p','p.user_id=u.user_id','left')
											->where(array('uf.follower'=>$this->session->userdata('user_id'), 'p.is_active'=>1,'p.is_block'=>0,'u.is_active'=>1))
											->order_by('p.created_date','desc')
											->limit(10)
											->get();
															
				$data['user_id'] = $cur_user_id;
				$data['posts'] = $rs_networkfeeds->result_array();
				
				echo $this->load->view('user/user-page/networkfeeds',$data,true);
				break;
			
			case 'search':
				$rs_users_youfollowing = $this->db->select("following")->from('user_follow')->where('follower',$cur_user_id)->get();
				
				$excluded_user_id[] = $cur_user_id;
				foreach($rs_users_youfollowing->result_array() as $youfollow){
					$excluded_user_id[] = $youfollow['following'];
				}
								
				$rs_users = $this->db->select("*")->from('user')->where_not_in('user_id',$excluded_user_id)->get();
				$data['user_id'] = $cur_user_id;
				$data['users'] = $rs_users->result_array();
				echo $this->load->view('user/user-page/search',$data,true);
				break;
			
			case 'peopleyoufollow':
				$rs_users = $this->db->select("uf.*,u.*,count(p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type")
									->from('user_follow as uf')
									->join('user as u','uf.following=u.user_id','left')
									->join('post as p','p.user_id=u.user_id','left')
									->join('post_tag as pt','pt.post_id=p.post_id','left')
									->join('tag as t','t.tag_id=pt.tag_id','left')
									->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
									->where('uf.follower',$cur_user_id)
									->get();
				$data['user_id'] = $cur_user_id;
				$data['users'] = $rs_users->result_array();
				echo $this->load->view('user/user-page/useryoufollow',$data,true);
				break;
			
			case 'peoplefollowingyou':
				$rs_users = $this->db->select("uf.*,u.*,count(p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type")
									->from('user_follow as uf')
									->join('user as u','uf.follower=u.user_id')
									->join('post as p','p.user_id=u.user_id','left')
									->join('post_tag as pt','pt.post_id=p.post_id','left')
									->join('tag as t','t.tag_id=pt.tag_id','left')
									->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
									->where('uf.following',$cur_user_id)
									->distinct()
									->get();
				$data['user_id'] = $cur_user_id;
				$data['users'] = $rs_users->result_array();
				echo $this->load->view('user/user-page/userfollowingyou',$data,true);
				break;
			default:
				//for localfeeds
				$rs_user = $this->db->select('zip_code')->from('user')->where('user_id',$cur_user_id)->get();
				$follow_rs_user = $this->db->select('follow_location_id,zip_code')->from('follow_location')->where('user_id',$cur_user_id)->get();
				
				$re = $follow_rs_user->result_array();
				
				if(!empty($re))
				{
				
					foreach($re as $zip_codes)
					{
							 $all_zip_codes[] = $zip_codes['zip_code'];
					}
					$comma_sep_zip = implode(',',$all_zip_codes);				
					$user = $rs_user->row_array();
					
					$query = "SELECT u.user_name, u.profile_name, p.post_id,p.title,  p.description, p.created_date,p.post_image, fl.follow_location_id from  follow_location as fl LEFT JOIN post as p ON p.post_zip_code = fl.zip_code LEFT JOIN user as u ON u.user_id = fl.user_id WHERE p.local_post = 1 and p.is_active = 1 and p.is_block = 0 and fl.zip_code IN ($comma_sep_zip) order by p.created_date desc limit 
					0, $limit";
					
					$rs_localfeeds =  $this->db->query($query);				
					$data['user_id'] = $cur_user_id;				
					$data['posts'] = $rs_localfeeds->result_array();
					
					echo $this->load->view('user/user-page/localfeeds',$data,true);
				}else{
					echo '<div style="padding: 15px;">
							<div id="zip-info-box" class="info-block">	
								<span class="info-show">
									No Local Feeds available right now for you. You may '.anchor('post/add','create a local post').' and be the first one to let the world know about your area.
								</span>
							</div>	
						</div>';
				}
		}
	}
	
	
	
	/**
	  @param : No
	  @return:  $userid					- User Id of current login user
	 			$users_total_count		- Total number of users you follow
				$users					- Details of users that follow you (current user)
				$categories				- All categories information
				$profile-links			- Load a view "user/profile-links"
				$post_capsule_list		- null
				$sidebar				- Load a view "includes/sidebar"
	 @detail : This function is used to show block of user's that is follwed by current login user.
	*/
	
	public function youfollow(){
		
		if($this->commonmodel->isLoggedIn()){
			$rs_user = $this->db->select('*')
								->from('user')
								->where('user_id' ,$this->session->userdata('user_id'))
								->get();
			$user = $rs_user->row_array();
			if(!empty($user)){
			
				$rs_users_total = $this->db->select("uf.*, u.user_id, u.user_name, u.profile_name,u.picture,count(DISTINCT p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type")
										->from('user_follow as uf')
										->join('user as u','uf.following=u.user_id','left')
										->join('post as p','p.user_id=u.user_id AND p.is_active=1','left')
										->join('post_tag as pt','pt.post_id=p.post_id','left')
										->join('tag as t','t.tag_id=pt.tag_id','left')
										->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
										->where(array('uf.follower'=>$user['user_id'],'u.is_active'=>1))
										->group_by('uf.following')
										->get();
				
				$users_total_count = $rs_users_total->num_rows();
				$this->load->library('pagination');
				$start=0;
				$limit=8;
				$start = $this->uri->segment(3,$start);
				$config['base_url'] = site_url("user/youfollow");
				$config['total_rows'] =  $users_total_count;
				$config['per_page'] = $limit;
				$config['uri_segment'] = '3' ;
				$config['num_links'] = '2';
				$config['next_link'] = 'Next';
				$config['prev_link'] ='Previous';
				$this->pagination->initialize($config);
				
				$rs_users = $this->db->select("uf.*, u.user_id, u.user_name, u.profile_name,u.picture,count(DISTINCT p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type")
										->from('user_follow as uf')
										->join('user as u','uf.following=u.user_id','left')
										->join('post as p','p.user_id=u.user_id AND p.is_active=1','left')
										->join('post_tag as pt','pt.post_id=p.post_id','left')
										->join('tag as t','t.tag_id=pt.tag_id','left')
										->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
										->where(array('uf.follower'=>$user['user_id'],'u.is_active'=>1))
										->group_by('uf.following')
										->limit($limit, $start)
										->get();
				$data['user_id'] = $user['user_id'];
				$data['users_total_count'] = $users_total_count;
				$data['users'] = $rs_users->result_array();
				
				$data['categories'] = $this->commonmodel->getRecords('category');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
				$data['post_capsule_list'] = '';
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				
				$this->load->view('includes/header');
				$this->load->view('user/useryoufollow',$data);
				$this->load->view('includes/footer');

			}
		}else{
			redirect('user/login');
		}
	
	}

	/**
	  @param : No
	  @return:  $userid					- User Id of current login user
				$users_total_count		- Total number of users you follow
				$users					- Details of users that follow you (current user)
				$categories				- All categories information
				$profile-links			- Load a view "user/profile-links"
				$post_capsule_list		- null
				$sidebar				- Load a view "includes/sidebar"
	  @detail: This function is used to show block of user's who follow current user.
	 */

	public function followingyou(){
		
		if($this->commonmodel->isLoggedIn()){
			$user_id = $this->session->userdata('user_id');
			$rs_user = $this->db->select('*')
								->from('user')
								->where('user_id' ,$user_id)
								->get();
			$user = $rs_user->row_array();
			if(!empty($user)){
			
				
				$data['categories'] = $this->commonmodel->getRecords('category');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
				$data['post_capsule_list'] = '';
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				$rs_users_total = $this->db->select("uf.*, u.user_id, u.user_name, u.profile_name, u.picture, count(DISTINCT p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type, GROUP_CONCAT(DISTINCT uf1.follower) AS thsfollowing, GROUP_CONCAT(DISTINCT uf1.user_follow_id) AS thsfollowingid")
										->from('user_follow as uf')
										->join('user as u','u.user_id=uf.follower','left')
										->join('user_follow as uf1','uf1.following=uf.follower','left')
										->join('post as p','p.user_id=u.user_id AND p.is_active=1','left')
										->join('post_tag as pt','pt.post_id=p.post_id','left')
										->join('tag as t','t.tag_id=pt.tag_id','left')
										->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
										->where(array('uf.following'=>$user_id,'u.is_active'=>1))
										->group_by('uf.follower')
										->get();
				
				
				$users_total_count = $rs_users_total->num_rows();
				$this->load->library('pagination');
				$start=0;
				$limit=8;
				$start = $this->uri->segment(3,$start);
				$config['base_url'] = site_url("user/followingyou");
				$config['total_rows'] =  $users_total_count;
				$config['per_page'] = $limit;
				$config['uri_segment'] = '3' ;
				$config['num_links'] = '2';
				$config['next_link'] = 'Next';
				$config['prev_link'] ='Previous';
				$this->pagination->initialize($config);
				
				
				$rs_users = $this->db->select("uf.*, u.user_id, u.user_name, u.profile_name, u.picture, count(DISTINCT p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type, GROUP_CONCAT(DISTINCT uf1.follower) AS thsfollowing, GROUP_CONCAT(DISTINCT uf1.user_follow_id) AS thsfollowingid")
										->from('user_follow as uf')
										->join('user as u','u.user_id=uf.follower','left')
										->join('user_follow as uf1','uf1.following=uf.follower','left')
										->join('post as p','p.user_id=u.user_id AND p.is_active=1','left')
										->join('post_tag as pt','pt.post_id=p.post_id','left')
										->join('tag as t','t.tag_id=pt.tag_id','left')
										->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
										->where(array('uf.following'=>$user_id,'u.is_active'=>1))
										->group_by('uf.follower')
										->limit($limit, $start)
										->get();
				
				$data['user_id'] = $user['user_id'];
				$data['users_total_count'] = $users_total_count;
				
				$data['users'] = $rs_users->result_array();
				
				$this->load->view('includes/header');
				$this->load->view('user/userfollowingyou',$data);
				$this->load->view('includes/footer');			
			}
		}else{
			redirect('user/login');
		}
	
	}

	/**
	  @param: $_GET {contains keyword for search}.
	  @return:  $user_id				- user id of current login user.
				$users_total_count		- Total count of search result.
				$users					- All information about user comes into search criteria.
				$categories				- All categories information
				$profile-links			- Load a view "user/profile-links"
				$post_capsule_list		- null
				$sidebar				- Load a view "includes/sidebar"
	  @detail: This function is used for searching all users.
	*/
	public function search(){
		
		if($this->commonmodel->isLoggedIn()){
			$user_id = $this->session->userdata('user_id');
			$rs_user = $this->db->select('*')
								->from('user')
								->where('user_id' ,$user_id)
								->get();			
			$user = $rs_user->row_array();
			if(!empty($user)){
			
				if(array_key_exists('filter',$_GET) && $_GET['filter']!=''){
					$filter = $_GET['filter'];
				}else{
					$filter = '';
				}
				
				$data['categories'] = $this->commonmodel->getRecords('category');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
				$data['post_capsule_list'] = '';
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				$where = "(`u`.`user_name`  LIKE '%$filter%' OR  `u`.`profile_name`  LIKE '%$filter%') AND (`u`.`user_id` != '$user_id' AND `u`.`is_active` =  1)";
								
				$rs_users_total = $this->db->select("u.user_id, u.user_name, u.profile_name, u.picture,count(DISTINCT p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type, GROUP_CONCAT(DISTINCT uf.follower) AS thsfollowing, GROUP_CONCAT(DISTINCT uf.user_follow_id) AS thsfollowingid")
										->from('user as u')
										->join('user_follow as uf','uf.following=u.user_id','left')
										->join('post as p','p.user_id=u.user_id AND p.is_active=1','left')
										->join('post_tag as pt','pt.post_id=p.post_id','left')
										->join('tag as t','t.tag_id=pt.tag_id','left')
										->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
										->where($where)
										
										->distinct()
										->group_by('u.user_id')
										->get();
				
				
				$users_total_count = $rs_users_total->num_rows();
				$this->load->library('pagination');
				$start=0;
				$limit=8;
				$start = $this->uri->segment(3,$start);
				$config['base_url'] = site_url("user/search");
				$config['total_rows'] =  $users_total_count;
				$config['per_page'] = $limit;
				$config['uri_segment'] = '3' ;
				$config['num_links'] = '2';
				$config['next_link'] = 'Next';
				$config['prev_link'] ='Previous';
				$this->pagination->initialize($config);
				
				
				$rs_users = $this->db->select("u.user_id, u.user_name, u.profile_name, u.picture,count(DISTINCT p.post_id) as postcount, GROUP_CONCAT(DISTINCT t.name SEPARATOR ' | ') as used_tags , GROUP_CONCAT(DISTINCT sc.name SEPARATOR ' | ') as used_post_type, GROUP_CONCAT(DISTINCT uf.follower) AS thsfollowing, GROUP_CONCAT(DISTINCT uf.user_follow_id) AS thsfollowingid")
										->from('user as u')
										->join('user_follow as uf','uf.following=u.user_id','left')
										->join('post as p','p.user_id=u.user_id AND p.is_active=1','left')
										->join('post_tag as pt','pt.post_id=p.post_id','left')
										->join('tag as t','t.tag_id=pt.tag_id','left')
										->join('sub_category as sc','sc.sub_category_id=p.sub_category_id','left')
										->where($where)
										->distinct()
										->group_by('u.user_id')
										->limit($limit, $start)
										->get();
				
				$data['user_id'] = $user_id;
				$data['users_total_count'] = $users_total_count;
				$data['users'] = $rs_users->result_array();			
				
				$this->load->view('includes/header');
				$this->load->view('user/search',$data);
				$this->load->view('includes/footer');			
			}
		}else{
			redirect('user/login');
		}
	}


	
	
	/**
		@param : $following_data =array(following, follower) having user_id of users to insert into database.
		@return : create link for unfollow this user.
		@details : This function is used to follow any user. Function called by Ajax request.
	*/
	public function followUser(){
		
		$place = $this->input->post('place');
		$follower_data = array(
			'following'=> $this->input->post('following'),
			'follower'=> $this->input->post('follower')
		);
		$this->commonmodel->addEditRecords('user_follow', $follower_data);
		$user_follow_id = $this->db->insert_id();
		
		if($place == "breadcrumb")
		{
			echo "<div class=\"follow-link\"><a href=\"javascript:void(0);\" onclick=\"unFollowUserbyAnyLocation(this,'".$user_follow_id."','breadcrumb')\" title=\"Unfollow This User\"></a></div>";		
		}else{
			echo "<div class=\"follow-link\"><a href=\"javascript:void(0);\" onclick=\"unFollowUserbyAnyLocation(this,'".$user_follow_id."','page')\" title=\"Unfollow This User\">Unfollow This User</a></div>";
		}
		$following_id = $this->input->post('following');
		$follower_id = $this->input->post('follower');
		$account_setting_info = $this->commonmodel->getRecords('user_account_setting', 'user_id,someone_start_following',array('user_id'=>$following_id),'',true);
		
		/* if checkbox checked from account setting then shoot email otherwise do nothing */
		if($account_setting_info['someone_start_following'] == 1)
		{
		
			/* code for send email when someone answer your question */
			$following_email = $this->commonmodel->getRecords('user','profile_name,email', array('user_id'=>$following_id),'',true);
			$follower_email =  $this->commonmodel->getRecords('user','profile_name,user_name,email', array('user_id'=>$follower_data['follower']),'',true);
			
			$follower_name = "<a href=".base_url().$follower_email['user_name'].">".$follower_email['profile_name']."</a>";
			
			$this->commonmodel->setMailConfig();
			$subject = constant('SOMEONE_START_FOLLOWING_YOU');
														
			//for mail text
			$mail_text = constant('SOMEONE_START_FOLLOWING_YOU_MAIL');
			$mail_search = array("{FOLLOWING_NAME}","{FOLLOWER_NAME}");
			$mail_replace = array("".$following_email['profile_name']."","".$follower_name."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('SOMEONE_START_FOLLOWING_YOU_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
			
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($following_email['email']);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();
			exit;
		}
	}

	/**
		@param : $user_follow_id - The unique id of user_follow table to which row user sends a request for deletion.
		@return : create link for follow this user.
		@detail :This function is used to unfollow any user. Function called by Ajax request.
	*/
	public function unfollowUser(){
		
		$place = $this->input->post('place');
		$user_follow_id = $this->input->post('user_follow_id');
		$rs_user_follow = $this->db->select('follower,following')->from('user_follow')->where('user_follow_id',$user_follow_id)->get();
		$user_follow = $rs_user_follow->row_array();
		$this->db->delete('user_follow', array('user_follow_id' =>$user_follow_id));
		if($place == "breadcrumb")
		{
			echo "<div class=\"unfollow-link\"><a href=\"javascript:void(0);\" onclick=\"followUserbyAnyLocation(this,'".$user_follow['following']."','".$user_follow['follower']."','breadcrumb')\" title=\"Follow This User\"></a></div>";
		}else{		
			echo "<div class=\"unfollow-link\"><a href=\"javascript:void(0);\" onclick=\"followUserbyAnyLocation(this,'".$user_follow['following']."','".$user_follow['follower']."','page')\" title=\"Follow This User\">Follow This User</a></div>";
		}
		exit;
		
	}

	public function index()
	{
		$this->login();
	}

	/**
		@param : null
		@return : null
		@detail: destroy all session data created by user at the time of login, delete all cookies made in session time. and then redirect to visitor's login/signup page.
	*/
	public function logout()
	{ 
		$this->session->sess_destroy();
		delete_cookie("ink_user_name");
		delete_cookie("ink_email");
		delete_cookie("ink_user_id");
		redirect();
		
	}

	/**
		@param  : null
		@return : null
		@package: helper ('captcha')
		@detail : login Page for this controller.
		
	 */
	public function login()
	{
		if($this->commonmodel->isLoggedIn())
		{
			redirect('post/showposts/all');
		}
		else
		{ 
			$this->load->helper('captcha');

			$vals = array(
						'word'		 => '',
						'img_path'	 => './captcha/',
						'img_url'	 => base_url().'captcha/',
						'font_path'	 => 'verdana.ttf',
						'img_width'	 => '119',
						'img_height' => 45,
						'expiration' => 7200
					);
			
			$captcha = create_captcha($vals);
			$data['captcha']=$captcha;

			$this->load->view('includes/header');
			$this->load->view('user/login', $data);
			$this->load->view('includes/footer');
		}
	}
	
	
	public function social(){
		if($this->commonmodel->isLoggedIn())
		{
			redirect('user/feeds');
		}
		else
		{ 
			$this->load->helper('captcha');

			$vals = array(
						'word'		 => '',
						'img_path'	 => './captcha/',
						'img_url'	 => base_url().'captcha/',
						'font_path'	 => 'verdana.ttf',
						'img_width'	 => '119',
						'img_height' => 45,
						'expiration' => 7200
					);
			
			$captcha = create_captcha($vals);
			$data['captcha']=$captcha;

			$this->load->view('includes/header');
			$this->load->view('user/social-register', $data);
			$this->load->view('includes/footer');
		}
	}

	/**
		@param : User_name , Password
		@return: null
		@detail: Authentication for signin.
		@package: library( form_validation ) , helper( captcha ) 
	*/
	public function signin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login_user_name', 'user name', 'trim|required|callback_checklogin');
		$this->form_validation->set_rules('login_password', 'password', 'trim|required|md5');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->helper('captcha');

			$vals = array(
						'word'		 => '',
						'img_path'	 => './captcha/',
						'img_url'	 => base_url().'captcha/',
						'font_path'	 => 'verdana.ttf',
						'img_width'	 => '119',
						'img_height' => 45,
						'expiration' => 7200
					);
			
			$captcha = create_captcha($vals);
			$data['captcha']=$captcha;

			$this->load->view('includes/header');
			$this->load->view('user/login',$data);
			$this->load->view('includes/footer');

			return false; 
		}
		else
		{ 
			redirect('user/feeds');
		}
	}

	/**
		@param : user_name , password
		@return : create session of user_name, email, user_id.
		@detail : Checking for Login restrictions.
	*/
	public function checklogin($str)
	{ 
		$user = $this->commonmodel->getRecords('user','user_id,email',array("user_name"=>$str,"password"=>md5($this->input->post('login_password'))),'',true);
		if($user)
		{
			$this->session->set_userdata('user_name',$str);
			$this->session->set_userdata('email',$user['email']);
			$this->session->set_userdata('user_id',$user['user_id']);
			return true;
		}
		else
		{
			$this->form_validation->set_message('checklogin', 'Invalid email or password.');
			return FALSE;
		}
	}

	/**
		@param : user_name, Password
		@return : 1 for success and 0 for failure.
					set session - User_name, email, user_id, picture, profile_name, last_visit, last_visit_ip
					set Cookies - User_name, email, user_id, picture, profile_name, last_visit, last_visit_ip
		@author : Neelesh Chouksey 
		@Created date: 15 feb 2012
		@detail : Checking for Ajax Login restrictions.
	*/
	public function ajaxLogin()
	{
		$this->load->library('user_agent');
		$user_name = $this->input->post('user_name');
		$user = $this->commonmodel->getRecords('user','user_id,email,picture,profile_name,last_visit,last_visit_ip,login_status',array("role"=>2,"user_name"=>$user_name,"password"=>md5($this->input->post('password')),"is_active"=>1),'',true);
		
		
		if($user){
			$this->session->sess_destroy();
			$this->session->set_userdata('user_name',$user_name);
			$this->session->set_userdata('email',$user['email']);
			$this->session->set_userdata('user_id',$user['user_id']);
			$this->session->set_userdata('picture',$user['picture']);
			$this->session->set_userdata('profile_name',$user['profile_name']);
			$this->session->set_userdata('last_visit',$user['last_visit']);
			$this->session->set_userdata('last_visit_ip',$user['last_visit_ip']);
			$this->session->set_userdata('users_user_agent',$this->agent->browser());
			
			$login_data['last_visit'] = time();
			$login_data['last_visit_ip'] = $_SERVER['REMOTE_ADDR'];
			
			$this->commonmodel->addEditRecords('user', $login_data, $user['user_id']);
			
			/* Data insertion for maintaining User login information . Created by: Jay Hardia*/
			$login_info = array( 'user_id' => $user['user_id'],
				                 'last_visit'=> $login_data['last_visit'],
				                 'last_visit_ip'=> $login_data['last_visit_ip']						
							);
			$this->commonmodel->addEditRecords('user_login_history',$login_info);
			/* End*/
			
			$user_session_info = $this->commonmodel->getRecords('user_session','user_id',array("user_id"=>$user['user_id']),'',true);
			if(empty($user_session_info))
			{
				$session_info = array('user_id' => $user['user_id'],'session_id' => $user['user_id'],'user_agent' => $this->session->userdata('users_user_agent'));
				$this->commonmodel->addEditRecords('user_session',$session_info);
			}else{
				$where = "user_id = ".$user['user_id'];
				$this->commonmodel->deleteRecords('user_session', $where);
				$session_info = array('user_id' => $user['user_id'],'session_id' => $user['user_id'],'user_agent' => $this->session->userdata('users_user_agent'));
				$this->commonmodel->addEditRecords('user_session',$session_info);
			}
			if($this->input->post('remember_me') == 1)
			{
				$one_year = 60*60*24*365; //value in seconds
				set_cookie('ink_user_name',base64_encode($user_name),$one_year);
				set_cookie('ink_email',base64_encode($user['email']),$one_year);
				set_cookie('ink_user_id',base64_encode($user['user_id']),$one_year);
				set_cookie('picture',base64_encode($user['picture']),$one_year);
				set_cookie('profile_name',base64_encode($user['profile_name']),$one_year);
				set_cookie('last_visit',base64_encode($user['last_visit']),$one_year);
				set_cookie('last_visit_ip',base64_encode($user['last_visit_ip']),$one_year);
			}
			$redirect =  $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : 1;
			echo $redirect;
		}else
		{
			echo 0;
		}
	}

	/**
		@param: null
		@return: null
		@detail: Checking for Home page after login.
	
	*/
	public function home()
	{ 
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->load->view('includes/header');
			$this->load->view('user/home');
			$this->load->view('includes/footer');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}

	/**
		@param : null
		@return: null
		@detail: This function is used to display user registration form.
		@package : helper( captcha )
	*/
	public function userSignUp()
	{
		$this->load->helper('captcha');

		$vals = array(
					'word'		 => '',
					'img_path'	 => './captcha/',
					'img_url'	 => base_url().'captcha/',
					'font_path'	 => 'verdana.ttf',
					'img_width'	 => '119',
					'img_height' => 45,
					'expiration' => 7200
				);
		
		$captcha = create_captcha($vals);
		$data['captcha']=$captcha;

		$this->load->view('includes/header');
		$this->load->view('user/usersignup', $data);
		$this->load->view('includes/footer');
	}

	/**
		@param: null
		@return: null
		@detail: This function is used to show captcha image
	*/
	public function reloadCaptcha()
	{
		$this->load->helper('captcha');

		$vals = array(
					'word'		 => '',
					'img_path'	 => './captcha/',
					'img_url'	 => base_url().'captcha/',
					'font_path'	 => 'verdana.ttf',
					'img_width'	 => '119',
					'img_height' => 45,
					'expiration' => 7200
				);

		$captcha = create_captcha($vals);
		$data['captcha']=$captcha; 
		echo $captcha['image'].'<input type="hidden" value="'.md5($captcha['word']).'" name="redirect">';
	}

	/**
		@param: user_name		- unique user name for user.
				password		- Password for user account.
				email id		- Email id for confirmation email of user account.
				captcha_code	- verification code of captcha image.
				redirect		- User entered code as captcha image contains.
				terms			- if checked then true else false.
		@return: null
		@detail: saveRegistration Page for the user.
	*/
	public function saveRegistration()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('user_name', 'name', 'trim|required|alpha_numeric|callback_user_check');
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|matches[confirm_password]|md5'); //|matches[confirm_password]
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|min_length[6]|required');
		$this->form_validation->set_rules('email', 'e-mail address', 'trim|required|valid_email|callback_email_check');
		$this->form_validation->set_rules('captcha_code', 'Security code', 'trim|required|md5|matches[redirect]');
		$this->form_validation->set_rules('redirect', 'Verification Code', 'trim');
		$this->form_validation->set_rules('terms', 'Terms and Conditions', 'callback_terms_check');
		
		$this->form_validation->set_custom_message('password', 'required', 'Please choose a password.');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->helper('captcha');

			$vals = array(
						'word'		 => '',
						'img_path'	 => './captcha/',
						'img_url'	 => base_url().'captcha/',
						'font_path'	 => 'verdana.ttf',
						'img_width'	 => '119',
						'img_height' => 45,
						'expiration' => 7200
					);
			
			$captcha = create_captcha($vals);
			$data['captcha']=$captcha;

			$this->load->view('includes/header');
			$this->load->view('user/login', $data);
			$this->load->view('includes/footer');
		}
		else
		{ 
			$post_data = $this->input->post();
			$post_data['profile_name'] = $post_data['user_name'];
			$post_data['registered_date'] = time();
			$post_data['init_mail'] = $post_data['email'];
			$post_data['token'] = $token = uniqid();
			
			$this->commonmodel->addEditRecords('user', $post_data);
			
			
			$user_email_data['user_id'] = $this->db->insert_id();
			$user_email_data['user_email'] = $post_data['email'];
			$user_email_data['is_default'] = 1;
			$this->commonmodel->addEditRecords('user_email', $user_email_data);
			
			$account_setting_data = array(	'user_id'=>$this->db->insert_id(), 
											'someone_make_comment'=> 1,
											'someone_answer_question'=> 1,
											'someone_comment_post'=> 1,
											'someone_answer_question_you_answer'=> 1,
											'someone_start_following'=> 1,
											'receive_an_email'=> 1,
											'someone_answer_publisher_poll'=> 1
										);																						
			$this->commonmodel->addEditRecords('user_account_setting', $account_setting_data);
			
			
			$this->session->set_userdata('msg', "Congrates!! you are successfully registered..");
			$this->session->set_userdata('email', $user_email_data['user_email']);
			
			$this->commonmodel->setMailConfig();

			
			
			$link = site_url("user/verifyuserlink/".$token);
			
			
			$subject = constant('WELCOME_INKSMASH_MAIL_SUBJECT');
														
			//for mail text
			$mail_text = constant('WELCOME_INKSMASH_MAIL');
			$mail_search = array("{FIRST_NAME}","{EMAIL_VERIFIED_LINK}");
			$mail_replace = array("".$post_data['profile_name']."","".$link."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('WELCOME_INKSMASH_MAIL_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
			
				
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($this->input->post('email'));
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();
									
			redirect('user/congratulation');
		}
	}

	/**
		@param: user_name		- unique user name for user.
				email id		- Email id for confirmation email of user account.
				captcha_code	- verification code of captcha image.
				redirect		- User entered code as captcha image contains.
				terms			- if checked then true else false.
		@return: set session	- User_name, email, user_id, picture, profile_name, last_visit, last_visit_ip
		@author: Neelesh Choukesy 
		@created date : 17 Apr 2012
		@detail: Face book saveRegistration Page for the user.
	*/
	public function saveSocialRegistration()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user_name', 'name', 'trim|required|alpha_numeric_space|callback_user_check');
		$this->form_validation->set_rules('profile_name', 'profile name', 'trim|required');
		$this->form_validation->set_rules('email', 'e-mail address', 'trim|required|valid_email|callback_email_check');
		$this->form_validation->set_rules('captcha_code', 'Security code', 'trim|required|md5|matches[redirect]');
		$this->form_validation->set_rules('redirect', 'Verification Code', 'trim');
		$this->form_validation->set_rules('terms', 'Terms and Conditions', 'callback_terms_check');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->helper('captcha');

			$vals = array(
						'word'		 => '',
						'img_path'	 => './captcha/',
						'img_url'	 => base_url().'captcha/',
						'font_path'	 => 'verdana.ttf',
						'img_width'	 => '119',
						'img_height' => 45,
						'expiration' => 7200
					);
			
			$captcha = create_captcha($vals);
			$data['captcha']=$captcha;

			$this->load->view('includes/header');
			$this->load->view('user/social-register', $data);
			$this->load->view('includes/footer');
		}
		else
		{ 
			$post_data = $this->input->post();
			$post_data['profile_name'] = $post_data['profile_name'];
			$post_data['is_fb'] = 1;
			$post_data['is_active'] = 1;
			$post_data['registered_date'] = time();
			$post_data['init_mail'] = $post_data['email'];
			$post_data['token'] = $token = uniqid();
			
			$this->commonmodel->addEditRecords('user', $post_data);
			
			$user_email_data['user_id'] = $this->db->insert_id();
			$user_email_data['user_email'] = $post_data['email'];
			$user_email_data['is_default'] = 1;
			$this->commonmodel->addEditRecords('user_email', $user_email_data);
			
			$account_setting_data = array(	'user_id'=>$this->db->insert_id(), 
											'someone_make_comment'=> 1,
											'someone_answer_question'=> 1,
											'someone_comment_post'=> 1,
											'someone_answer_question_you_answer'=> 1,
											'someone_start_following'=> 1,
											'receive_an_email'=> 1,
											'someone_answer_publisher_poll'=> 1
										);																						
			$this->commonmodel->addEditRecords('user_account_setting', $account_setting_data);
			
			$this->session->set_userdata('msg', "Congrates!! you are successfully registered..");
			$this->session->set_userdata('email', $user_email_data['user_email']);
			
			/*$this->commonmodel->setMailConfig();

			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Welcome to InkSmash!');
			$link = site_url()."user/verifyuserlink/".$token;
			$message = 'Welcome,
			<br />
			<br />
			Please click the following link to verify your account:
			<br />
			<br /><a href="'.$link.'">'.$link.'</a>
			<br />
			<br />
			Thank You.';
			$this->email->message($message);

			$this->commonmodel->sendEmail();
			*/
			
			
			$rs_user = $this->db->select("*")->from('user')->where('user_id',$user_email_data['user_id'])->get();
			$user = $rs_user->row_array();
			
			// valid for login--- make this user as loggedin
			$this->session->set_userdata('user_name',$user['user_name']);
			$this->session->set_userdata('email',$user['email']);
			$this->session->set_userdata('user_id',$user['user_id']);
			$this->session->set_userdata('picture',$user['picture']);
			$this->session->set_userdata('profile_name',$user['profile_name']);
			$this->session->set_userdata('last_visit',$user['last_visit']);
			$this->session->set_userdata('last_visit_ip',$user['last_visit_ip']);
	
			redirect('');
		}
	}

	/**
		@param : $user_name - user name for current user
		@return: true if user_name not found in database else return false.
		@detail: callback function for validating 'user already exist' check in registration form.
	*/
	public function user_check($user_name)
	{ 
		$user_exist = $this->commonmodel->getRecords('user','user_id',array("user_name"=>$user_name),'',true);
		if ($user_exist == false)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('user_check', 'User already exists.');
			return FALSE;
		}
	}

	/**
		@param: $email - Email id for current user.
		@return:true if email_id not found in database else return false.
		@detail: callback function for validating 'user already exist' check in registration form.
	*
	*/
	public function email_check($email)
	{ 
		$email_exist = $this->commonmodel->getRecords('user_email','user_email_id',array("user_email"=>$email),'',true);
		
		if ($email_exist == false)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('email_check', 'This email is already registered with us.');
			return FALSE;
		}
	}

	/**
		@param: $str - checked value of Terms and Condition
		@return: return true if checked else false with error message.
		@detail: Callback function for validating 'terms of services' check in registration form.
	*
	*/
	public function terms_check($str)
	{
		if ($str == '1')
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('terms_check', 'For registration you have to agree to the %s');
			return FALSE;
		}
	}

	/**
		@param : $token			- unique token id
		@return: set session	- User_name, email, user_id, picture, profile_name, last_visit, last_visit_ip
		@detail: This function is for verify user registration.
	*
	*/
	public function verifyUserLink($token="")
	{
		$user_detail = $this->commonmodel->getRecords('user', 'user_id,email,picture,profile_name,last_visit,last_visit_ip,user_name', array("token"=>$token), '', true);
		if(!$user_detail)
		{
			$this->session->set_userdata('msg','No user found for this authentication.');
			$this->load->view('includes/header');
			$this->load->view("user/congratulation");
			$this->load->view('includes/footer');
			return;
		}
				
		$this->commonmodel->addEditRecords('user',array('token'=>uniqid(),'is_active'=>1),$user_detail['user_id']);

		$this->session->set_userdata('user_name',$user_detail['user_name']);
		$this->session->set_userdata('email',$user_detail['email']);
		$this->session->set_userdata('user_id',$user_detail['user_id']);
		$this->session->set_userdata('picture',$user_detail['picture']);
		$this->session->set_userdata('profile_name',$user_detail['profile_name']);
		$this->session->set_userdata('last_visit',$user_detail['last_visit']);
		$this->session->set_userdata('last_visit_ip',$user_detail['last_visit_ip']);

		//$this->session->set_userdata('msg','Welcome to Ink-Smash');
		
		
		$this->commonmodel->setMailConfig();
	
		$subject = constant('VERIFICATION_DONE_MAIL_SUBJECT');
													
		//for mail text
		$mail_text = constant('VERIFICATION_DONE_MAIL');
		$mail_search = array("{FIRST_NAME}");
		$mail_replace = array("".$user_detail['profile_name']."");
		
		$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
		
		//for mail footer
		$mail_footer = constant('VERIFICATION_DONE_MAIL_FOOTER');
		
		// for mail tepmlate
		$template_string = constant('MAIL_TEMPLATE');
		$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
		$template_replace = array("".$mail_body."","".$mail_footer."");
		
			
		$message =	str_replace($template_search, $template_replace, $template_string);
		
		
		$this->email->from(FROM_EMAIL, 'InkSmash');
		$this->email->to($user_detail['email']);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->commonmodel->sendEmail();
		
		redirect('user/myprofile');
		
	}

	/**
		@param: null
		@return: null
		@detail: Congratulation Page for registered user, and unset session of 'msg'
	*/
	public function congratulation()
	{
		$this->load->view('includes/header');
		$this->load->view("user/congratulation");
		$this->load->view('includes/footer');

		$this->session->unset_userdata('msg');
	}

	/**
		@param : session data			- msg ,email, user_id
		@return: msg					- some msg ??????
				 user_detail			- all details about user where email = @param[email]
				 emails					- All  emails of user where user_id = @param[user_id]
				 categories				- All information of Category
				 profile_links			- Load a view  "user/profile-links"
				 post_capsule_list		- null
				 sidebar				- Load a view "includes/sidebar"
		@detail : profile Page for registered user.
	*/
	public function myProfile()
	{	
	
		if($this->commonmodel->isLoggedIn())
		{
			$data['msg'] = $this->session->userdata('msg');
			$user_id = $this->session->userdata('user_id');			 
			$data['user_id'] = $user_id;
			$this->session->unset_userdata('msg');
			
			$data['user_detail'] = $this->commonmodel->getRecords('user', '', array("email"=>$this->session->userdata('email'),"user_id"=>$user_id), '', true);
			
			$data['emails'] = $this->commonmodel->getRecords('user_email', '', array("user_id"=>$user_id));		
			
			$data['account_setting'] = $this->commonmodel->getRecords('user_account_setting','', array('user_id'=>$user_id), '', true);
			
			$rs_amazon_details = $this->db->select('*')->from('user_earnings_account')->where(array('user_id'=>$user_id,'account_type'=>1))->get();
			$data['user_amazon_detail'] = $rs_amazon_details->row_array();
			
			$rs_adsence_details = $this->db->select('*')->from('user_earnings_account')->where(array('user_id'=>$user_id,'account_type'=>2))->get();
			$data['user_adsence_detail'] = $rs_adsence_details->row_array();
			
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);

			$this->load->view('includes/header', $data);
			$this->load->view('user/myprofile');
			$this->load->view('includes/footer');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}

	/**
		@param : session data			- user_id
		@return: user_id				- user_id of current user
				 user_amazon_detail		- All detail about amazon for current user
				 user_adsence_detail	- All detail about google adsense for current user
				 categories				- All information about category
				 profile_links			- Load a view "user/profile-links"
				 post_capsule_list		- null
				 sidebar				- Load a view "includes/sidebar"
		@detail: profile Page for registered user.
	*/
	public function earningacc()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$user_id = $this->session->userdata('user_id');
			$data['user_id'] = $user_id;
			
			$data['user_detail'] = $this->commonmodel->getRecords('user', '', array("email"=>$this->session->userdata('email'),"user_id"=>$user_id), '', true);
			
			
			$data['emails'] = $this->commonmodel->getRecords('user_email', '', array("user_id"=>$user_id));		
			
			$data['account_setting'] = $this->commonmodel->getRecords('user_account_setting','', array('user_id'=>$user_id), '', true);
			
			$rs_amazon_details = $this->db->select('*')->from('user_earnings_account')->where(array('user_id'=>$user_id,'account_type'=>1))->get();
			$data['user_amazon_detail'] = $rs_amazon_details->row_array();
			
			
			$rs_adsence_details = $this->db->select('*')->from('user_earnings_account')->where(array('user_id'=>$user_id,'account_type'=>2))->get();
			$data['user_adsence_detail'] = $rs_adsence_details->row_array();
			

			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);

			$this->load->view('includes/header', $data);
			$this->load->view('user/myprofile');
			$this->load->view('includes/footer');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}

	/**
		@param: $user_id					- User id of current user
				$account_type				- Set 2 for Google Ad Sense
				$google_ad_client			- google client id from google for user
				$is_active					- Status for google ad sense
				$user_earnings_account_id	- if id exist then update the existing value otherwise insert new row
		@return: null
		@detail: Insert new row for google adsense if not exist and update if exist.
		@author: Jay Hardia
		@created date : 5/5/2012
	*/

	public function updateGoogleAdAccount()
	{		
		$user_id = $this->input->post('user_id');
		$account_type = $this->input->post('account_type');
		$user_code = $this->input->post('google_ad_client');
		$is_active = $this->input->post('is_active');
		$user_earnings_account_id = $this->input->post('user_earnings_account_id');		
		$earning_data = array('user_id' => $user_id, 'account_type' => $account_type, 'user_code' => $user_code, 'is_active' => $is_active);
		if($user_earnings_account_id){
			$this->commonmodel->addEditRecords('user_earnings_account', $earning_data, $user_earnings_account_id);
			$earnig_info = $this->commonmodel->getRecords('user_earnings_account','user_code', array('user_earnings_account_id'=>$user_earnings_account_id),'',true);
			echo $earnig_info['user_code'];
		}else{
			$this->commonmodel->addEditRecords('user_earnings_account', $earning_data);
			$inserted_id = $this->db->insert_id();
			$earnig_info = $this->commonmodel->getRecords('user_earnings_account','user_code', array('user_earnings_account_id'=>$inserted_id),'',true);
			echo $earnig_info['user_code'];
		}
	}

	/**
	 * Ajax edit request for inputs.
	 */
	public function editInputs()
	{
		if($this->session->userdata('user_id')!='' && $this->session->userdata('email')!='')
		{
			$post_data = $this->input->post();
			
			$row_id = $post_data['table']== 'user' ? $this->session->userdata('user_id') : $post_data['row_id'];
			
			if (array_key_exists('birth_date', $post_data)) {
				$post_data['birth_date'] = strtotime($post_data['birth_date']);
			}

			if (array_key_exists('profile_name', $post_data)) {
				$this->session->set_userdata('profile_name',$post_data['profile_name']);
			}

			if (array_key_exists('picture', $post_data)) {
				$this->session->set_userdata('picture',$post_data['picture']);
			}

			//$this->session->set_userdata('picture',$user_detail['picture']);
			//$this->session->set_userdata('profile_name',$user_detail['profile_name']);

			$this->commonmodel->addEditRecords($post_data['table'], $post_data, $row_id);
			echo $this->db->insert_id();


		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}

	/**
		@param: session data- user_id and email, $id = email_ids of current user.
		@return: null
		@author: Neelesh Chouksey
		@detail: Ajax function for deleting records.
	*/
	public function ajaxDeleteEmail()
	{ 
		if($this->session->userdata('user_id')!='' && $this->session->userdata('email')!='')
		{ 
			$post_data = $this->input->post();
			$id = $post_data['email_id']; 
			$user_id = $this->session->userdata('user_id');

			// deleting records from database
			$this->commonmodel->deleteRecords('user_email', "user_email_id=$id && user_id=$user_id");
		}
		else
		{
			$this->session->destroy();
		}
	}


	/**
		@param : session data			- msg ,email, user_id
		@return: msg					- some msg ??????
				 user_detail			- all details about user where email = @param[email]
				 emails					- All  emails of user where user_id = @param[user_id]
				 categories				- All information of Category
				 profile_links			- Load a view  "user/profile-links"
				 post_capsule_list		- null
				 sidebar				- Load a view "includes/sidebar"
		@detail : profile Page for registered user.
	*/
	public function showChangePassword()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$data['msg'] = $this->session->userdata('msg');
			$this->session->unset_userdata('msg');
			$data['user_detail'] = $this->commonmodel->getRecords('user', '', array("email"=>$this->session->userdata('email')), '', true);
			$data['emails'] = $this->commonmodel->getRecords('user_email', '', array("user_id"=>$this->session->userdata('user_id')));

			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);

			$this->load->view('includes/header', $data);
			$this->load->view('user/changepassword');
			$this->load->view('includes/footer');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}



	/**
		@param : cur_password -  Current password of user
				 new_password -  New Password of user
				 session data -  user id
		@return: null
		@detail: change password
	
	*/
	public function changePassword()
	{				
		$cur_str = $this->input->post('cur_password');
		
		$user = $this->commonmodel->getRecords('user', 'password', array("password"=>md5($cur_str), "user_id" => $this->session->userdata('user_id')),'',true);
		
		if($user)
		{
			$this->commonmodel->addEditRecords('user',array('password'=>md5($this->input->post('new_password'))),$this->session->userdata('user_id'));
			$this->session->set_userdata('msg','Your password has been changed successfully.');
			
			$this->commonmodel->setMailConfig();

			$user_detail = $this->commonmodel->getRecords('user', 'user_name,email', array("user_id"=>$this->session->userdata('user_id')), '', true);
						
			$subject = constant('USER_CHANGED_PASSWORD_SUBJECT');
														
			//for mail text
			$mail_text = constant('USER_CHANGED_PASSWORD_MAIL');
			$mail_search = array("{FIRST_NAME}");
			$mail_replace = array("".$user_detail['user_name']."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('USER_CHANGED_PASSWORD_MAIL_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
				
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($user_detail['email']);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();
			
			echo'true';
			return true;
		}
		else
		{
			echo'false';
			return FALSE;
		}
	}

	/** 
		@param : $token - unique token id.
				 $new_password - password of user
				 $confirm_password - To match the both password.			 
		@return: null
		@detail: Used to reset password
	*/
	public function saveResetPassword()
	{
		$this->load->library('form_validation');
		
		
		$data['token'] = $token = $this->input->post('token');
		$user_detail = $this->commonmodel->getRecords('user', '', array("token"=>$token), '', true);
		if(!count($user_detail))
			redirect();
		
		$this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[6]|matches[confirm_password]|md5');
		$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|min_length[6]|required');
		$this->form_validation->set_message('matches', 'The new password field does not match the confirm password field.');

		$this->form_validation->set_custom_message('new_password', 'required', 'Please enter new password');
		$this->form_validation->set_custom_message('confirm_password', 'required', 'Please enter confirm password');
		$this->form_validation->set_custom_message('new_password', 'min_length', 'Should be of 6 character');
		$this->form_validation->set_custom_message('confirm_password', 'min_length', 'Should be of 6 character');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('includes/header', $data);
			$this->load->view('user/resetpassword');
			$this->load->view('includes/footer');

			return false; 
		}
		else
		{ 
			
			$this->commonmodel->addEditRecords('user',array('token'=>uniqid(),'password'=>$this->input->post('new_password')),$user_detail['user_id']);
			$this->session->set_userdata('msg','Your password has been changed successfully. <a href="'.site_url('user/login').'">Click here</a> to login');
			redirect('user/resetpassword/'.$_POST['token']);
		}
	}

	/**
		@param: $str - contains new password for checking with old one
		@return: true if valid otherwise false
		@detail:Callback function for validating change password form.
	*/
	public function checkPassword($str)
	{
		$user = $this->commonmodel->getRecords('user', 'password', array("password"=>md5($str)),'',true);
		
		if($user)
		{
			echo'true';
			return true;
		}
		else
		{
			//$this->form_validation->set_message('checkPassword', 'Current password is incorrect.');
			echo'false';
			return FALSE;
		}
	}

	/**
		@param : 
		@return: session data	- msg
				 user_detail	- All details about user matched with email id
				 emails			- All email id of user matched with user id
		@detail: profile Page for Video Gallery.
	*/
	public function videoGallery()
	{
		if($this->session->userdata('user_id')!='' && $this->session->userdata('email')!='')
		{
			$data['msg'] = $this->session->userdata('msg');
			$this->session->unset_userdata('msg');
			$data['user_detail'] = $this->commonmodel->getRecords('user', '', array("email"=>$this->session->userdata('email')), '', true);
			$data['emails'] = $this->commonmodel->getRecords('user_email', '', array("user_id"=>$this->session->userdata('user_id')));
			
			$this->load->view('includes/header');
			$this->load->view('user/videoGallery', $data);
			$this->load->view('includes/footer');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}

	/**
		@param : null
		@return: null
		@detail:  Forgot password Page.
	
	*/
	public function forgotPassword()
	{
		$this->load->view('includes/header');
		$this->load->view('user/forgotpassword');
		$this->load->view('includes/footer');
	}


	/**
		@param : email - default email address of user
		@return: link-sent - A message for user that your new password has been send to your email id.
		@detail: Forgot password Page.
		@package: library ( form_validation )
	
	*/
	public function sendforgotPasswordEmail()
	{
		$data = array();
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'e-mail address', 'trim|required|valid_email|callback_forgotEmailCheck');
		
		if ($this->form_validation->run() == TRUE)
		{
			$email = $this->input->post('email');
			$uniqid = uniqid();
			$link = site_url('user/resetPassword/'.$uniqid);

			$query = $this->db->update_string('user', array('token'=>$uniqid), "email = '$email'");
			
			$this->db->query($query);
			
			$this->commonmodel->setMailConfig();

			$user_detail = $this->commonmodel->getRecords('user', 'user_name', array("email"=>$email), '', true);
						
			$subject = constant('USER_FORGOT_PASSWORD_SUBJECT');
														
			//for mail text
			$mail_text = constant('USER_FORGOT_PASSWORD_MAIL');
			$mail_search = array("{FIRST_NAME}","{CHANGE_PASS_LINK}");
			$mail_replace = array("".$user_detail['user_name']."","".$link."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('USER_FORGOT_PASSWORD_MAIL_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
			
				
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();
			
			$data['link_sent'] = 'Change password link has been sent to your email. Please click on the link and change your password.';
		}

		$this->load->view('includes/header');
		$this->load->view('user/forgotpassword',$data);
		$this->load->view('includes/footer');
	}

	/**
		@param: $email - email address of user
		@return: true if exist otherwise false
		@detail: callback function for validating 'user already exist' check in forgot password form.
	*/
	public function forgotEmailCheck($email)
	{ 
		$email_exist = $this->commonmodel->getRecords('user_email','user_email_id,user_id',array("user_email"=>$email),'',true);
		$email_block = $this->commonmodel->getRecords('user','email,is_active',array("user_id"=>$email_exist['user_id'],'is_active !='=>1),'',true);
		
		if ($email_exist == false)
		{
			$this->form_validation->set_message('forgotEmailCheck', 'User with this email is not exists.');
			return FALSE;
		}else if(!empty($email_block))
		{
			$this->form_validation->set_message('forgotEmailCheck', 'This account is blocked, please make request to admin for resume account.');
			return FALSE;
		}
		else
		{
			return true;
		}
	}

	/**
		@param : $token , session data - msg
		@return: null
		@detail: Forgot password Page.
	*/
	public function resetPassword($token=false)
	{ 
		$data['token'] = $token;
		if($token)
		{
			$data['msg'] = $this->session->userdata('msg');
			$this->load->view('includes/header');
			$this->load->view('user/resetpassword',$data);
			$this->load->view('includes/footer');
			$data['msg'] = $this->session->unset_userdata('msg');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}	
	}
	
	
	/**
		@param : null
		@return: null
		@detail:  Forgot username Page.
	*/
	public function forgotUsername()
	{
		$this->load->view('includes/header');
		$this->load->view('user/forgotusername');
		$this->load->view('includes/footer');
	}


	/**
		@param : email - default email address of user
		@return: link-sent - A message for user that your new username has been send to your email id.
		@detail: Forgot username Page.
		@package: library ( form_validation )
	
	*/
	public function sendforgotUsernameEmail()
	{		
		$data = array();
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'e-mail address', 'trim|required|valid_email|callback_forgotEmailCheck');
		
		if ($this->form_validation->run() == TRUE)
		{
			$email = $this->input->post('email');
			
			$link = site_url('user/login/');
			
			$this->commonmodel->setMailConfig();

			$user_detail = $this->commonmodel->getRecords('user', 'user_name, profile_name', array("email"=>$email), '', true);
			
			$profile_link = site_url().$user_detail['user_name'];
			$subject = constant('USER_FORGOT_USERNAME_SUBJECT');
														
			//for mail text
			$mail_text = constant('USER_FORGOT_USERNAME_MAIL');
			$mail_search = array("{PROFILE_NAME}","{PROFILE_LINK}", "{USER_NAME}","{CHANGE_USERNAME_LINK}");
			$mail_replace = array("".$user_detail['profile_name']."","".$profile_link."","".$user_detail['user_name']."","".$link."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('USER_FORGOT_USERNAME_MAIL_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
			
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();
			
			$data['link_sent'] = 'The username has been sent on your email.Please click on the attached link and login with username';
		}

		$this->load->view('includes/header');
		$this->load->view('user/forgotusername',$data);
		$this->load->view('includes/footer');
	}	

	/**
		@param: $zip_code - Zip code of user area
		@return: if zip code exist return 0 else return 1
		@detail:  save zip code
		@author: Neelesh Chouksey
		@created date : 24 March 2012
	*/
	public function saveZipCode($zip_code)
	{ 
		if(!$this->commonmodel->isLoggedIn())
		{ 
			$this->session->sess_destroy();
			redirect();
		}
		
		$zip_code_exist = $this->commonmodel->getRecords('usa_zip_codes','zip_code',array("zip_code"=>$zip_code),'',true);
		if(count($zip_code_exist) == 0) {echo 0; return;}
		$this->commonmodel->commonAddEdit('user',array('zip_code'=>$zip_code),$this->session->userdata('user_id'));
		echo 1;
	}
	
	/**
		@param : session data - user_id ( User id of current login user)
		@return: count of unread message , follower and following of you
		@detail: This function  is used for counting followers of you,  user you follow and number of unread message of user. Call by Ajax function
		@author: Jay Hardia
	 */
	
	public function countfollowingyou()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$user_id = $this->session->userdata('user_id');
			$count =	$this->db->from('user_follow as uf')
						 ->join('user as u','uf.following = u.user_id','left')
						 ->where('uf.follower',$user_id)
						 ->where('u.is_active','1')
						 ->count_all_results();
						
			$this->db->from('user_follow as uf')
					 ->join('user as u','uf.follower = u.user_id','left')
					 ->where('uf.following',$user_id)
					 ->where('u.is_active','1');
			$count = $count."/". $this->db->count_all_results();
			
			$this->db->from('message_receiver');
			$this->db->where('recepient_id',$user_id);
			$this->db->where('is_read', '0');
			$count = $count."/". $this->db->count_all_results();
			
			echo $count ;
		}
	}
	
	/**
		@param : $user_id						- User id of current login user
				 $account_type					- set 1 for amazon and 2 for google adsense.
				 $user_code						- user's amazon ads id
				 $is_active						- status of Ad account
				 $user_earnings_account_id		- unique row id for user , amazon code
		@return: null
		@detail: This function is used to save earning amount into user's account.
	*/
	public function saveEarningContent(){
		$user_id = $this->input->post('user_id');
		$account_type = $this->input->post('account_type');
		$user_code = $this->input->post('user_code');
		$is_active = $this->input->post('is_active');
		$user_earnings_account_id = $this->input->post('user_earnings_account_id');		
		$earning_data = array('user_id' => $user_id, 'account_type' => $account_type, 'user_code' => $user_code, 'is_active' => $is_active);
		if($user_earnings_account_id){
			$this->commonmodel->addEditRecords('user_earnings_account', $earning_data, $user_earnings_account_id);
			$amzon_info = $this->commonmodel->getRecords('user_earnings_account','user_code', array('user_earnings_account_id'=>$user_earnings_account_id),'',true);
			echo $amzon_info['user_code'];
		}else{
			$this->commonmodel->addEditRecords('user_earnings_account', $earning_data);
			$inserted_id = $this->db->insert_id();
			$amzon_info = $this->commonmodel->getRecords('user_earnings_account','user_code', array('user_earnings_account_id'=>$inserted_id),'',true);
			echo $amzon_info['user_code'];
		}
	}

	/**
		@param :$user_earnings_account_id  - unique row id for user , amazon code
		@return: null
		@detail: This function is used to delete earning amount from user's account
	*/
	public function deleteEarningContent(){
		$user_earnings_account_id = $this->input->post('user_earnings_account_id');
		$this->db->delete('user_earnings_account', array('user_earnings_account_id' =>$user_earnings_account_id));
	}

	/*
		@param: $fbemail - facebook email address of user
		@return: set session - User_name, email, user_id, picture, profile_name, last_visit, last_visit_ip
				return 0 for successfully set session , 1 for email already in database, 2 user email is valid user can use this email
		@detail: This function is used to check user from facebook and valid it's email id.
	*/
	public function checkfbuser(){
			$fbemail = $this->input->post('fbemail');
			
			$rs_user = $this->db->select('u.*')->from('user_email as ue')
											->join('user as u','u.user_id=ue.user_id','left')
											->where('ue.user_email',$fbemail)->get();
			
			if($rs_user->num_rows()){
				$user = $rs_user->row_array();
				if($user['is_fb'] && $user['is_active'] && !$this->commonmodel->isLoggedIn()){
					// valid for login--- make this user as loggedin
					$this->session->set_userdata('user_name',$user['user_name']);
					$this->session->set_userdata('email',$user['email']);
					$this->session->set_userdata('user_id',$user['user_id']);
					$this->session->set_userdata('picture',$user['picture']);
					$this->session->set_userdata('profile_name',$user['profile_name']);
					$this->session->set_userdata('last_visit',$user['last_visit']);
					$this->session->set_userdata('last_visit_ip',$user['last_visit_ip']);
					echo 0;
				}else{
					echo 1; // email is allready in database
				}
			}else{
			 echo '2'; // 2 user email is valid user can use this email
			}
			
	}
	
	/**
		@param: $fbemail -  facebook email address of user
				$user_id - user id of current login user
		@return: null
		@detail: This function is used to attach facebook account to user's account by  updating 1 into is_fb field of user table.
	*/
	public function fbattach(){
		$fbemail = $this->input->post('fbemail');
		$user_id = $this->session->userdata('user_id');		
		
		$rs_user_email = $this->db->select('user_id')->from('user_email')->where('user_email',$fbemail)->get();		
		if($rs_user_email->num_rows()){
			$user_email = $rs_user_email->row_array();
			if($user_id==$user_email['user_id']){
				$this->commonmodel->addEditRecords('user', array('is_fb'=>1), $user_id);
				echo 0;
			}else{
				echo 1;
			}
		} else{
			$this->commonmodel->addEditRecords('user_email', array('user_id'=>$user_id,'user_email'=>$fbemail));
			$this->commonmodel->addEditRecords('user', array('is_fb'=>1), $user_id);
			echo 0;
		}
	}


	public function loadMoreUserFeeds()
	{
		$page_type= $this->input->post('page_type');
		$offset = $this->input->post('offset');
		$data['posts'] = $this->usermodel->loadMoreUserFeeds($offset,$page_type);
		$this->load->view('user/feeds-wrapper',$data);

	}

	public function loadMoreUserProfile()
	{
		$limit = 10;
		$offset = $this->input->post('offset');
		$user_id = $this->input->post('user_id');
		$page_type = $this->input->post('page_type');
		$data['favorite'] = "";

		if($page_type == "active")
			{
				$rs_posts = $this->db->select('p.*,u.user_name,u.profile_name')
									 ->from('post as p')
									 ->join('post_my_favorites as pf','p.post_id = pf.post_id','left')
									 ->join('user as u','p.user_id = u.user_id','left')
									 ->where(array('pf.user_id'=>$user_id,'p.is_active'=>1))
									 ->order_by("p.created_date", "desc")
									 ->limit($limit,$offset)
								     ->get();
				$data['favorite'] = "active";			
			}
			else
			{
				$rs_posts = $this->db->select('p.*,u.user_name,u.profile_name')
									 ->from('post as p')
									  ->join('user as u','p.user_id = u.user_id','left')
									 ->where(array('p.user_id'=>$user_id,'p.is_active'=>1))
									 ->order_by("p.created_date", "desc")
									 ->limit($limit,$offset)
									 ->get();
			}
		 $data['posts'] = $rs_posts->result_array();
		 $this->load->view('user/user-profile-wrapper',$data);


	}

	
	function test($admin_percent=30)
	{ 
		$this->session->set_userdata('email',$user['email']);
		
		echo $admin_percent%20;exit;

		if($admin_percent%5 != 0)
		{
			echo "Please enter a value in multiples of 5 and 10 only.";
			return;
		}

		echo $user_percent = 100-$admin_percent;

		if($admin_percent%10 == 0)
		{ 
			echo $admin_hits = $admin_percent/10;
			echo $user_hits = $user_percent/10;
			
		}
		else
		{
			echo $admin_hits = $admin_percent/5;
			echo $user_hits = $user_percent/5;
		}
	}
	
	
	
	/**
		@ account setting function for the show notification or not. date :- 22/10/2012.
		@param : session data			- user_id
		@return: user_id				- user_id of current user						 
				 sidebar				- Load a view "includes/sidebar"
		@detail: profile Page for registered user.
	*/
	public function myaccsetting()
	{
				
		$account_setting_info = $this->commonmodel->getRecords('user_account_setting', '*','','',true);
		
		if($this->commonmodel->isLoggedIn())
		{ 
						
			$user_id = $this->session->userdata('user_id');
			$data['user_id'] = $user_id;
			
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['account_setting'] = $this->commonmodel->getRecords('user_account_setting','', array('user_id'=>$user_id), '', true);
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);

			$this->load->view('includes/header', $data);
			$this->load->view('user/myaccsetting');
			$this->load->view('includes/footer');
		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}
	
	
	/**
		@ account setting function for the add or edit in 
		@ account setting table. get data from table and change in table.
		@ param : session data			- user_id
		@ return: user_id				- user_id of current user and data come in post	
		@
	*/
	public function addEditAccountSetting()
	{
			$s_m_c = $this->input->post('someone_make_comment');
			$someone_make_comment =  $s_m_c == '' ? 0 : 1 ;		
			
			$s_a_q = $this->input->post('someone_answer_question');
			$someone_answer_question = $s_a_q == '' ? 0 : 1 ;
			
			$s_c_p = $this->input->post('someone_comment_post');			
			$someone_comment_post = $s_c_p == '' ? 0 : 1 ;
			
			$s_a_q_y_a = $this->input->post('someone_answer_question_you_answer');
			$someone_answer_question_you_answer = $s_a_q_y_a == '' ? 0 : 1 ;
			
			$s_s_f = $this->input->post('someone_start_following');			
			$someone_start_following = $s_s_f == '' ? 0 : 1 ;
			
			$r_a_e = $this->input->post('receive_an_email');
			$receive_an_email = $r_a_e == '' ? 0 : 1 ;
			
			$s_a_p_p = $this->input->post('someone_answer_publisher_poll');
			$someone_answer_publisher_poll = $s_a_p_p == '' ? 0 : 1 ;
			
			$user_id = $this->input->post('user_id');
			$user_data = $this->commonmodel->getRecords('user_account_setting', '', array('user_id'=>$user_id), '', true);
						
			$account_setting_data = array(
				'user_id'=> $user_id,
				'someone_make_comment'=> $someone_make_comment,
				'someone_answer_question'=> $someone_answer_question,
				'someone_comment_post'=> $someone_comment_post,
				'someone_answer_question_you_answer'=> $someone_answer_question_you_answer,
				'someone_start_following'=> $someone_start_following,
				'receive_an_email'=> $receive_an_email,
				'someone_answer_publisher_poll'=> $someone_answer_publisher_poll
			);
			
			$where = 'user_id='.$user_id;
			if(!empty($user_data))
			{
				$this->usermodel->addEditAcountSetting('user_account_setting', $account_setting_data,$where );
			}else{
				$this->usermodel->addEditAcountSetting('user_account_setting', $account_setting_data);
			}
			echo 'success';
		}
	


}
/* End of file user.php */
/* Location: ./application/controllers/user.php */
