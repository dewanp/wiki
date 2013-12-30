<?php

class Admin extends CI_Controller
{

	public $childcategory = array();
	
	function __construct()
	{
		parent :: __construct();
		$this->load->helper( array('url','form','email','string','captcha'));
		$this->load->library(array('form_validation','session','pagination'));
        $this->load->model(array('commonmodel','mymodel','adminmodel'));

		$this->load->database();
	}
	
	/*
	 * This is login  page of admin section
	*/

	public function index()
	{	
		$data['title'] = "Vinfotech-wiki Admin Section";
		$this->load->view('admin/include/header-login', $data);
		$this->load->view('admin/login');
		$this->load->view('admin/include/footer');
	}

	/*
		* This function is used for checking login of admin user
	*/
	public function login()
	{ 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('adminname', 'User name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('adminpassword', 'Password', 'trim|required|xss_clean |callback_checkLogin');
		

         if( $this->form_validation->run() == FALSE )
		{
			$data['title'] = "Vinfotech-wiki Admin Section";
			$this->load->view('admin/include/header-login', $data);
			$this->load->view('admin/login');
			$this->load->view('admin/include/footer');
		}
		else
		{
			$username =	$this->input->post("adminname");
			$password=    $this->input->post("adminpassword");
			$res = $this->mymodel->checkLogin($username, $password) ;
		 
			if($res)
			{
				$this->session->set_userdata('user_id',$res['user_id']);
				$this->session->set_userdata('user_name',$res['user_name']);
				$this->session->set_userdata('profile_name',$res['profile_name']);
				$this->session->set_userdata('file_path',$res['file_path']);
				$this->session->set_userdata('file_upload_id',$res['file_upload_id']);
				$this->session->set_userdata('user_role','admin');

		        redirect('admin/dashboard');
			}
			else
			{
               redirect();
			}
		}
	}
	
	public function checkLogin($password )
	{
		$username =	$this->input->post("adminname");
		$password = md5($password);
		$condition = array('ur.role_id'=>3,'u.user_name'=>$username,'u.password'=>$password);
		
		$rs_login = $this->db->select('u.user_id')
							 ->from('user as u')
							 ->join('user_role as ur','u.user_id = ur.user_id','left')
							 ->where($condition)
							 ->get();
		$login = $rs_login->row_array();
		
		if(array_key_exists('user_id',$login))
		{
			return true;
		}
		else {
			$this->form_validation->set_message('checkLogin', 'Invalid User Name or Password');
			return false;
		}

	}

	/* 
		 * This function is used for display change password form.	 
	*/
	function viewChangePassword()
	{
		if($this->mymodel->isLoggedIn()){
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="admin";
			$data['success_message'] = "";
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/change-password');
			$this->load->view('admin/include/header');
		}
		else
		{
			redirect();
		}
	}
	/* 
	 * This  function is used for changing password of Administrator 
	*/
	function changePassword()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('old_password', 'Current Password', 'required|trim|xss_clean|callback_checkOldPassword');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|matches[confirm_password]|trim|xss_clean|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|trim|xss_clean');

		$this->form_validation->set_custom_message('old_password','required','Please enter current password');
		$this->form_validation->set_custom_message('new_password','required','Please enter new password');
		$this->form_validation->set_custom_message('new_password', 'min_length', 'Password should be of minimum 6 characters');
		$this->form_validation->set_message('matches', 'The new password does not match the confirm password.');
		$this->form_validation->set_custom_message('confirm_password','required','Please enter confirm password');

		 if( $this->form_validation->run() == FALSE )
		{
			
			$data['success_message'] = "";
		}
		else
		{
			 $password = md5($this->input->post('new_password'));
			 $data = array('password'=> $password);
		 
			 $this->commonmodel->commonAddEdit('user',$data,$this->session->userdata('user_id'));
			 $data['success_message'] = "Congratulation ! Your password has been changed successfully.";
			 //redirect('admin/dashboard');
		}
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="admin";
		    $this->load->view('admin/include/header', $data);
			$this->load->view('admin/change-password');
			$this->load->view('admin/include/header');
	}

	public function checkOldPassword($password)
	{
		$password = md5($password);
		$condition = array('ur.role_id'=>3,'u.user_name'=>$this->session->userdata('user_name'), 'u.password'=>$password);
		
		$rs_login = $this->db->select('u.user_id')
							 ->from('user as u')
							 ->join('user_role as ur','u.user_id = ur.user_id','left')
							 ->where($condition)
							 ->get();
		$login = $rs_login->row_array();
		if(array_key_exists('user_id',$login))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('checkOldPassword', 'Please enter valid password');
			return false;
		}

	}



	/** This function is used for log out from account.*/
	function logout()
		{
			$this->session->sess_destroy();
			redirect();
		}

	
	/*This function is used for displaying data on dashboard of admin section*/
	public function dashboard()
	{		
		if($this->mymodel->isLoggedIn()){
			$data['summary'] = $this->mymodel->RegistrationSummary();
			$data["result"] = $this->mymodel->HighestGrosser();
           	$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="admin";
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/dashboard');
			$this->load->view('admin/include/footer');
		 }
		 else
		 {
			 redirect();
		 }
	}
	
	/*This function is used for displaying list of  active user */
	public function manageUsers()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$uri_segment = 3;
			
			$data['search_user'] = $search_user = $this->uri->segment($uri_segment,$start);	
			if(is_numeric($search_user))
			{
				$start = $search_user;
				$search_user = "";
			}
			else
			{
				$uri_segment = 4;
				$start = $this->uri->segment($uri_segment,$start);	
			}

			$this->db->from ('user');
			$this->db->where("is_active = 1 and (profile_name like '%$search_user%' or user_name like '%$search_user%')");
			

			$all =$this->db->count_all_results();
			$config['base_url'] = site_url("admin/manageusers/$search_user");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = $uri_segment ;
			$config['num_links'] = 2;
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
			$this->pagination->initialize($config);
			
			$data['manage_user'] = $this->mymodel->ManageUser($limit ,$start,$search_user);
			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";
			$data['count_user'] = $all ;
			$data['start'] = $start;
			$data['limit'] = $limit ;
			$data['success_message'] = $this->session->userdata('success_message');
			
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-users');
			$this->load->view('admin/include/footer');

			$this->session->unset_userdata('success_message');
		}
		else
		{
			redirect();
		}
	}
	
	
	/*This function is used for displaying list of suspeded users.*/
	public function suspendedUserList()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$search='--';
			$start = $this->uri->segment(4,$start);
			$search = trim($this->uri->segment(3,$search));	
		
			$this->db->from ('user');
			$this->db->where('is_active != ', '1');
			if($search!='--'){
				$this->db->like('profile_name', $search);
				$this->db->or_like('user_name', $search);
			}
			$all =$this->db->count_all_results();
	 	
			$config['base_url'] = site_url("admin/suspendeduserlist/$search");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '4' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
			$this->pagination->initialize($config);
				
			$data['suspended_user'] = $this->mymodel->suspendedUserList($limit,$start,$search);
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";
			$data['count_user'] = $all;
			$data['start'] = $start;
			$data['limit'] = $limit ;
			$data['success_message'] = $this->session->userdata('success_message');
			$data['search_user'] = $search;
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/suspended-user-list');
			$this->load->view('admin/include/header');
			$this->session->unset_userdata('success_message');
		}
		else
		{
			redirect();
		}
	}
	
	
	/*This function is used to load view for edit user details*/
	public function manageUsersEditDetails($user_id)
	{
		if($this->mymodel->isLoggedIn()){
			$user_detail = $this->mymodel->manageUserViewDetails($user_id);
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";
			$data['user_detail'] = $user_detail;
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-users-edit-details');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	
	/*This function is  used to load view of login history of a user*/
	public function manageUsersLoginHistory($user_id)
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
					
			
			$all =$this->db->from ('user_login_history')
						   ->where('user_id', $user_id)
				           ->count_all_results();
			
			$start = $this->uri->segment(4,$start);
			$config['base_url'] = site_url("admin/manageusersloginhistory/".$user_id);
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '4' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
            $this->pagination->initialize($config);
			 $login_history = $this->db->select('last_visit,last_visit_ip')
									  ->from('user_login_history ')
				                      ->where('user_id',$user_id)
									  ->order_by('last_visit','desc')
									  ->limit($limit,$start)
									  ->get();
			$data['login_history'] = $login_history->result_array();
			
			$result =$this->db->select('user_name')->from('user')->where('user_id',$user_id)->get();
			$user_name = $result->row_array();
			
			$data['user_name'] = $user_name['user_name'];
			$data['count_user'] = $all ;
			$data['start'] = $start;
			$data['limit'] = $limit ;
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";	

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-users-login-history');
			$this->load->view('admin/include/header');
		}
		else
		{
			redirect();
		}

	}
	
	/*This function is used to display history of content of particular user*/
	public function manageUsersContentHistory($user_id)
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
					
			
			
			$this->db->from ('post');
			$this->db->where('user_id', $user_id);

			
			$start = $this->uri->segment(4,$start);
			$all =$this->db->count_all_results();
			$config['base_url'] = site_url("admin/manageuserscontenthistory/".$user_id);
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '4' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
						
			if(array_key_exists('search',$_GET) && $_GET['search']!=''){
				$rs_posts = $this->db->select('p.*,count(ph.ip_address) as hit , (select count(a.comment_id) from post as po 
				left join capsule as b on po.post_id = b.post_id 
				left join comment as a on a.capsule_id = b.capsule_id 
				where b.capsule_type_id = 5 AND po.post_id = p.post_id
				group by b.post_id ) as comment')
									 ->from('post as p')
									 ->join('post_hit as ph','ph.post_id = p.post_id','left')
									 ->like('title', $_GET['search'])
									 ->where('p.user_id' ,$user_id)
									 ->group_by('p.post_id')
									 ->order_by("p.created_date", "desc")
									 ->get();
			}else{
				$rs_posts = $this->db->select('p.*,count(ph.ip_address) as hit , (select count(a.comment_id) from post as po 
				left join capsule as b on po.post_id = b.post_id 
				left join comment as a on a.capsule_id = b.capsule_id 
				where b.capsule_type_id = 5 AND po.post_id = p.post_id
				group by b.post_id ) as comment')
									 ->from('post as p')
									 ->join('post_hit as ph', 'ph.post_id = p.post_id', 'left')
									 ->where(array('p.user_id'=>$user_id))
									 ->group_by('p.post_id')
									 ->order_by("p.created_date", "desc")
									 ->limit($limit,$start)
									 ->get();
				$this->pagination->initialize($config);
			}
		
		    $data['posts'] = $rs_posts->result_array(); 
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";		
	
			$user_detail = $this->mymodel->manageUserViewDetails($user_id);
			$data['user_detail'] = $user_detail;
  		
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-users-content-history');
			$this->load->view('admin/include/header');
		}
		else
		{
			redirect();
		}
	}
	
	
	/*This function is used for suspending users*/
     function suspendUsers($user_id="",$RedirectPage='0')
	 {

		 if($this->input->post('check'))
		 {
			 $checked_user = $this->input->post('check');
		 }
		 else
		 {
			 $checked_user = $user_id ? array($user_id) : array();
		 }
		 
		
		
		 if(count($checked_user))
		 { 
			 $this->commonmodel->setMailConfig();
			 foreach($checked_user as $user_id)
			 {
				 $data = array('is_active'=>'0');
				 $this->db->where('user_id',$user_id);
				 $this->db->update('user',$data);

				 $user = $this->commonmodel->getRecords('user','user_name,email',array('user_id'=> $user_id),'',true);

				/*Start : Send email to user. */
				
				
				/*****************************************/	
				$subject = constant('SUSPEND_ACCOUNT_MAIL_SUBJECT');
															
				//for mail text
				$mail_text = constant('SUSPEND_ACCOUNT_MAIL');
				$mail_search = array("{USER_NAME}");
				$mail_replace = array("".$user['user_name']."");
				
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('SUSPEND_ACCOUNT_MAIL_FOOTER');
				
				// for mail tepmlate
				$template_string = constant('MAIL_TEMPLATE');
				$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
				$template_replace = array("".$mail_body."","".$mail_footer."");
						
				$message =	str_replace($template_search, $template_replace, $template_string);
				/*****************************************/	
				
				
				
				$this->email->from(FROM_EMAIL, 'InkSmash');
				$this->email->to($user['email']);
				$this->email->subject($subject);
				$this->email->message($message);

				//$this->commonmodel->sendEmail();

				/*End : Send email to user. */
			 }
			 $this->session->set_userdata('success_message','Users suspended successfully.');
		 }
		
		 if($RedirectPage!=1)
		 {
			  redirect('admin/manageusers');
		 }
		 else
		 {
			//load user status section using ajax from user detail page in admin ($RedirectPage wou1d be 1 for this case)
			$this->viewAccountInformation($user_id,'User has been suspended successfully!');
			
			
		 }
	 }
	 
	 /*This function is used for activating suspended user.*/
	 function resumeSuspendedUsers($user_id="",$RedirectPage='0',$activateManually='0')
	 {
		  if($this->input->post('check'))
		 {
			 $checked_user = $this->input->post('check');
		 }
		 else
		 {
			 $checked_user = $user_id ? array($user_id) : array();
		 }
		 
		 if(count($checked_user))
		 {
			 $this->commonmodel->setMailConfig();
			 foreach($checked_user as $user_id)
			 {
				 $data = array('is_active'=>'1');
				 $this->db->where('user_id',$user_id);
				 $this->db->update('user',$data);

				 $user = $this->commonmodel->getRecords('user','user_name,email',array('user_id'=> $user_id),'',true);

				/*Start : Send email to user. */
				
				if($activateManually!=1)
				{
					/*****************************************/	
					$subject = constant('RESUME_ACCOUNT_MAIL_SUBJECT');
																
					//for mail text
					$mail_text = constant('RESUME_ACCOUNT_MAIL');
					$mail_search = array("{USER_NAME}");
					$mail_replace = array("".$user['user_name']."");
					
					$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
					
					//for mail footer
					$mail_footer = constant('RESUME_ACCOUNT_MAIL_FOOTER');
					
					// for mail tepmlate
					$template_string = constant('MAIL_TEMPLATE');
					$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
					$template_replace = array("".$mail_body."","".$mail_footer."");
							
					$message =	str_replace($template_search, $template_replace, $template_string);
					/*****************************************/	
										
					$this->email->from(FROM_EMAIL, 'InkSmash');
					$this->email->to($user['email']);
					$this->email->subject($subject);
					$this->email->message($message);
				
				}
				else{
									
					/*****************************************/	
					$subject = constant('ADMIN_VERIFY_ACCOUNT_MAIL_SUBJECT');
																
					//for mail text
					$mail_text = constant('ADMIN_VERIFY_ACCOUNT_MAIL');
					$mail_search = array("{USER_NAME}");
					$mail_replace = array("".$user['user_name']."");
					
					$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
					
					//for mail footer
					$mail_footer = constant('ADMIN_VERIFY_ACCOUNT_MAIL_FOOTER');
					
					// for mail tepmlate
					$template_string = constant('MAIL_TEMPLATE');
					$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
					$template_replace = array("".$mail_body."","".$mail_footer."");
							
					$message =	str_replace($template_search, $template_replace, $template_string);
					/*****************************************/	
								
					
					$this->email->from(FROM_EMAIL, 'InkSmash');
					$this->email->to($user['email']);
					$this->email->subject($subject);
					$this->email->message($message);
				
				}
				
				//$this->commonmodel->sendEmail();
				/*End : Send email to user. */
			 }
			  $this->session->set_userdata('success_message','Users resumed successfully.');
		 }
		
		 if($RedirectPage != 1)
		 {
			 redirect('admin/suspendeduserlist');
		 }
		 else
		 {
			//load user status section using ajax from user detail page in admin ($RedirectPage wou1d be 1 for this case)
			$this->viewAccountInformation($user_id,'User has been activated successfully!');
		 }
		 
	 }
	
	/* This function is used to load Add user view.*/
	public function displayAddUserView()
	{
		if($this->mymodel->isLoggedIn()){
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";
			$data['user_added'] = "";
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/add-user');
			$this->load->view('admin/include/header');
		}
		else
		{
			redirect();
		}
	}
	
	/*This is function perform Add new User*/
	function addUser()
	{ 
		if($this->input->post('add_user')== "Add New User")
			 {
				$this->form_validation->set_rules('name', 'Profile name', 'trim|required|alpha_numeric_space|xss_clean');
				$this->form_validation->set_rules('email', 'Email-id', 'valid_email|trim|required|xss_clean|callback_check_email');
				$this->form_validation->set_rules('user_name', 'User name', 'trim|required|alpha_numeric|xss_clean|callback_check_username');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('birth_date', 'Birthday', 'trim|xss_clean');
				
				$this->form_validation->set_custom_message('name','required','Please enter profile name');
				$this->form_validation->set_custom_message('name','min_length','Profile name should be minimum 6 character');
				$this->form_validation->set_custom_message('name','alpha_numeric_space','Profile name may contains only alphabetical character');
				$this->form_validation->set_custom_message('email','valid_email','Please enter valid email');
				$this->form_validation->set_custom_message('user_name','min_length','User name should be minimum 6 character');
				$this->form_validation->set_custom_message('user_name','alpha_numeric','User name may contains only alphabetical or numerical character');



				if($this->form_validation->run() == FALSE)
				{
					$data['user_added'] = "";
					
				}
				else
				{ 
					$profile_name = $this->input->post('name',true);
					$password = md5($this->input->post('password',true));
					$email = $this->input->post('email',true);	
					$user_name = $this->input->post('user_name',true);
					$birth_date = $this->input->post('birth_date',true);
					$birth_date = strtotime($birth_date);
					$is_active = $this->input->post('is_active',true);
					$token = uniqid();
					$data_array = array('profile_name'=>$profile_name,
										'user_name'=>$user_name,
										'password'=> $password,
										'email' =>$email,
										'birth_date' =>$birth_date,
										'registered_date'=>time(),
										'is_active' =>$is_active,
										'token' =>$token,
										'init_mail'=>$email
									 );
					
					$this->commonmodel->addEditRecords('user',$data_array);	

					$user_email_data['user_id'] = $this->db->insert_id();
					$user_email_data['user_email'] = $email;
					$user_email_data['is_default'] = 1;
					$this->commonmodel->addEditRecords('user_email', $user_email_data);
					
					
					/*Start : Send email to user. */
					$this->commonmodel->setMailConfig();
					$this->email->from(FROM_EMAIL, 'InkSmash');
					$this->email->to($email);
					$this->email->subject('Welcome to InkSmash!');
					$link = str_replace('ink-admin/','',site_url()."user/verifyuserlink/".$token);
					$message = 'Welcome,
					<br />
					Note : currently your user name and password will be same.
					<br />
					<br />
					Username : '.$user_name.' 
					<br />
					Password : '.$user_name.' 
					<br />
					Please click the following link to verify your account:
					<br />
					<br /><a href="'.$link.'">'.$link.'</a>
					<br />
					<br />
					<br />Thank you!<br />
			InkSmash Support Team<br />
			<a href="http://www.inksmash.com" target="_blank">www.inksmash.com</a><br /><br />
			You are receiving this email because a Inksmash user created an account with this email address. If you are the owner of this email address and did not create the Inksmash account, just ignore this message and the account will remain inactive.';
					//$this->email->message($message);

					//$this->commonmodel->sendEmail();
					/*End : Send email to user. */

					$data['user_added'] = "done";

					/*redirect('admin/manageusers');*/
				}
					
					$data['title'] = "Vinfotech-wiki Admin Section";
					$data['active'] ="manage_user";
			
					$this->load->view('admin/include/header', $data);
					$this->load->view('admin/add-user');
					$this->load->view('admin/include/header');
			 }
			 else
		{
				 redirect('admin/manageusers');

		}
		
	}
	
	/*Callback function : used to check whether user_name already exist or not*/
	
	function check_username($username)
	{
		$result = $this->commonmodel->getRecords('user','user_name',array('user_name'=> $username),'',true);
		if (array_key_exists('user_name', $result))
		{
			$this->form_validation->set_message('check_username', 'This user name already exist');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/*Callback function : used to check whether email id already exist or not.*/
	function check_email($email)
	{
		$result = $this->commonmodel->getRecords('user','email',array('email'=>$email),'',true);
	  if (array_key_exists('email', $result))
		{
			$this->form_validation->set_message('check_email', 'This email id already exist');
			return false;
		}
		else
		{
			return true ;
		}
	}
	
	/*This function is used to displaying details about specific user.*/
	function manageUserViewDetails($user_id)
	{	 
		if($this->mymodel->isLoggedIn()){
			$user_detail = $this->mymodel->manageUserViewDetails($user_id);
			$this->session->set_userdata('user_id',$user_id);
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_user";
			$data['user_detail'] = $user_detail;
			
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-users-view-details');
			$this->load->view('admin/include/footer');
			}
		else
			{
				redirect();
			}
	}
	
	/*This  function used for updating data of user*/
	function updateUserData()
	{
		if($this->input->post('save')!= null){			 			 
				$this->load->library('form_validation');
				$this->form_validation->set_rules('name', 'User Profile name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email', 'Email-id', 'trim|required|xss_clean');
				$this->form_validation->set_rules('user_name', 'User name', 'trim|required|xss_clean');
		
				 if( $this->form_validation->run() == FALSE )
				{
					$user_detail = $this->mymodel->manageUserViewDetails($this->session->userdata('user_id'));
					$data['title'] = "Vinfotech-wiki Admin Section";
					$data['active'] ="manage_user";
					$data['user_detail'] = $user_detail;
			
					$this->load->view('admin/include/header', $data);
					$this->load->view('admin/manage-users-edit-details');
					$this->load->view('admin/include/header');
				}
				else
				{
					$this->adminmodel->updateUserData();
					redirect('admin/manageuserseditdetails/'.$this->session->userdata('user_id'));
				}

		 }
		 else
		 {
				 if($this->input->post('is_active')=='1')			 
					 redirect('admin/manageusers');
				 else
					 redirect('admin/suspendeduserlist');
		 }
	}

	public function  viewPostMultimedia($post_id)
	{
		if($this->mymodel->isLoggedIn()){
			
			$data =array();
			$data['all_result'] = $this->mymodel->viewPostMultimedia($post_id);
			$data['image'] = $data['all_result']['image'];
			$data['video'] = $data['all_result']['video'];
			$data['post'] = $data['all_result']['post'];
			$data['all_result'] = "";
			$data['active'] ="manage_content";
			$data['title'] = "Vinfotech-wiki Admin Section";

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/view-post-multimedia');
			$this->load->view('admin/include/header');
		}
		else
		{
			redirect();
		}
	}
	

	public function editPost($post_id)
	{
		
		if($this->mymodel->isLoggedIn()){
		$data =array();
			// load current post
		$post = $this->commonmodel->getRecords('post', '', array('post_id' => $post_id), '', true);
		
		
		$data['post_id'] = $post_id ;
		if(empty($post)){
			show_404();
		}

		$data['post'] = $post;
	
		
		// post image
		$data['post_image'] = $this->commonmodel->getRecords('file_upload', '', array('file_upload_id' => $post['post_image']) , '', true);
		// post category
		$data['post_category'] = $this->commonmodel->getRecords('category', '', array('category_id' => $post['category_id'],'is_active'=>1) , '', true);
		// post sub category
		$data['post_sub_category'] = $this->commonmodel->getRecords('sub_category', '', array('sub_category_id' => $post['sub_category_id']) , '', true);
		
		// post tags
		$tags =	$this->db->select('*')
							->from('post_tag')
							->join('tag', 'post_tag.tag_id = tag.tag_id', 'left')
							->where(array('post_tag.post_id' => $post_id))						
							->get();
		$data['tags'] = $tags->result_array();
		

		// post capsules		
		$data['post_capsules'] =  $this->mymodel->capsuleDetail($post_id);
		
		$data['abused'] = $this->db->from('report_abuse')->where('post_id',$post_id)->count_all_results();
		
		/*echo "<pre>";
		print_r($data);
		exit;*/

			$data['active'] ="manage_content";
			$data['title'] = "Vinfotech-wiki Admin Section";

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-content-view-post');
			$this->load->view('admin/include/header');

		}
		else
		{
			redirect();
		}

	}
	 

	/* This function is used to show post to user.*/
	public function postBasicInfo(){
		$post_id = $this->input->post('post_id');
		$view_type = $this->input->post('view_type','view');
		$data['post_id'] = $post_id;
		// load current post
		$post = $this->commonmodel->getRecords('post', '', array('post_id' => $post_id), '', true);	
		$data['post'] = $post;
		// post category
		$data['post_category'] = $this->commonmodel->getRecords('category', '', array('category_id' => $post['category_id']) , '', true);
		// post sub category
		$data['post_sub_category'] = $this->commonmodel->getRecords('sub_category', '', array('sub_category_id' => $post['sub_category_id']) , '', true);
		$data['category_list'] = $this->commonmodel->getRecords('category');
		$data['sub_category_list'] = $this->commonmodel->getRecords('sub_category');
		// post tags
		$tags =	$this->db->select('*')
							->from('post_tag')
							->join('tag', 'post_tag.tag_id = tag.tag_id', 'left')
							->where(array('post_tag.post_id' => $post_id))						
							->get();
		$data['tags'] = $tags->result_array();
			
		echo $this->load->view('post/basic-info/'.$view_type, $data, true);
		exit;
	}

	public function capsuleContent(){
		$output = array();
		$data = array();
		
		$post_id = $this->input->post('post_id');
		$capsule_id = $this->input->post('capsule_id');
		$content_type = $this->input->post('content_type','view');
		
		$capsule = $this->commonmodel->getRecords('capsule', '*', array('capsule_id' => $capsule_id), '', true);
		$capsule_type = $this->commonmodel->getRecords('capsule_type', '*', array('capsule_type_id' => $capsule['capsule_type_id']), '', true);
		
		$capsule_table =  $capsule_type['name'];
		
		if($capsule_table =='image'){
			$capsules =	 $this->db->select('image.*, file_upload.*')
								->from('image')
								->join('file_upload', 'image.file_upload_id = file_upload.file_upload_id', 'left')
								->where('capsule_id', $capsule_id)
								->order_by("weight")
								->get();
			$capsule_content = $capsules->result_array();

		}elseif($capsule_table =='video'){
			$capsules =	 $this->db->select('video.*, file_upload.*')
								->from('video')
								->join('file_upload', 'video.file_upload_id = file_upload.file_upload_id', 'left')
								->where('capsule_id', $capsule_id)
								->order_by("weight")
								->get();
			$capsule_content = $capsules->result_array();
	
		}elseif($capsule_table =='comment'){
			$rs_capsule_comments = $this->db->select('comment.*, user.user_id, user.profile_name, user.picture, user.user_name')->from('comment')->join('user','comment.user_id=user.user_id','left')->where('comment.capsule_id' ,$capsule_id)->order_by("comment.created_date", "desc")->get();
			$capsule_content = $rs_capsule_comments->result_array();

		}elseif($capsule_table =='polls'){
			$capsule_content = $this->commonmodel->getRecords($capsule_table, '*', array('capsule_id' => $capsule_id),'weight');
			if(!empty($capsule_content)){
				$capsule_content['options'] = $this->commonmodel->getRecords('option', '*', array('source_id' => $capsule_content[0]['polls_id'], 'type' => 0)); // type= 0 for polls
			}
		}elseif($capsule_table =='opinion'){
			$capsule_content = $this->commonmodel->getRecords($capsule_table, '*', array('capsule_id' => $capsule_id),'weight');
			if(!empty($capsule_content)){
				$capsule_content['options']['positive'] = $this->commonmodel->getRecords('option', '*', array('source_id' => $capsule_content[0]['opinion_id'], 'type' => 1)); // type = 1 for positive opinion
				$capsule_content['options']['negative'] = $this->commonmodel->getRecords('option', '*', array('source_id' => $capsule_content[0]['opinion_id'], 'type' => 2)); // type = 2 for positive opinion
			}
		}else{
			$capsule_content = $this->commonmodel->getRecords($capsule_table, '*', array('capsule_id' => $capsule_id),'weight');
		}
		
		$data['post_id'] = $post_id;
		$data['capsule_id'] = $capsule_id;
		$data['capsule_data'] = $capsule;
		$data['capsule_content'] = $capsule_content;

		$output['html'] = $this->load->view('capsule/'.$capsule_table.'/capsule-'.$capsule_table.'-'.$content_type, $data, true);
		//$output['html'] = $capsule_table;
		$output['status'] = 'success';
		echo json_encode($output);
		exit;
	}
	
	public function savePostBasicInfo(){
		//print_r($this->input->post()); exit;
		$post_id = $this->input->post('post_id');
		
		$update_post = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'changed_date' => time(),
				'post_image' => $this->input->post('file_upload_id')			
			);
			
		$this->commonmodel->commonAddEdit('post', $update_post, $post_id);
		
		// search for attach tags
		$tag_array = $this->input->post('tag');
		$tag_term_id = array();
		
		// All tag id new and old one
		
		foreach($tag_array as $tag){
			$trimed_tag = trim($tag);
			$avail_tag = $this->commonmodel->getRecords('tag','tag_id',array('name' =>$trimed_tag),'',true);	
			// tag will be numeric if it was selected old one otherwise

			if(!empty($avail_tag)){
				$tag_term_id[$avail_tag['tag_id']] = $avail_tag['tag_id'];
			}else{					
				// adding new tag to database if user creates any new tag
				$new_tag = array('name' => $trimed_tag);
				$this->commonmodel->commonAddEdit('tag', $new_tag);						
				$new_tag_id = $this->db->insert_id();
				$tag_term_id[$new_tag_id] = $new_tag_id;
			}				
		}
		
		$this->db->delete('post_tag', array('post_id' => $post_id));
		// adding records to category term post table for making relation with term and post
		foreach($tag_term_id as $tag_id){
			$this->commonmodel->commonAddEdit('post_tag', array('post_id' => $post_id, 'tag_id'=> $tag_id));
		}
	}

	public function manageContent()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
			
			$all = $this->db->from('post')->where('is_block',0)->count_all_results();
	
			$start = $this->uri->segment(3,$start);
			$config['base_url'] = site_url("admin/managecontent");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
												
		    $data['all_posts'] = $this->mymodel->manageContent($start,$limit,0);
			
			if(array_key_exists('search',$_GET) && $_GET['search']!=''){}
			else{			$this->pagination->initialize($config); }
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_content";	
			
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-content');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	
	public function blockPosts($post_id)
	{
		if($this->mymodel->isLoggedIn()){
			$data = array('is_block'=>'1');
			$this->db->where('post_id',$post_id);
			$this->db->update('post',$data);

			$this->commonmodel->deleteRecords('report_abuse','post_id = '.$post_id);
		}
		else
		{
			redirect();
		}
	}

	public function resumeBlockedPosts($post_id)
	{
		if($this->mymodel->isLoggedIn()){
			$data = array('is_block'=>'0');
			$this->db->where('post_id',$post_id);
			$this->db->update('post',$data);

			$this->commonmodel->deleteRecords('report_abuse','post_id = '.$post_id);
		}
		else
		{
			redirect();
		}
	}

	public function allBlockedPosts()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
			
			$all = $this->db->from ('post')->where('is_block',1)->count_all_results();
	
			$start = $this->uri->segment(3,$start);
			$config['base_url'] = site_url("admin/allblockedposts");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
						
					
		    $data['all_blocked_posts'] = $this->mymodel->manageContent($start,$limit,1);

			if(array_key_exists('search',$_GET) && $_GET['search']!=''){}
			else{			$this->pagination->initialize($config); }
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_content";	
			
			
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/manage-content-blocked-posts');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
		
	}

	
    /* This function is used to load view of Post Type List. */
	function displayPostTypeList()
	{
	    if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
		
			$this->db->from ('sub_category');
			$all =$this->db->count_all_results();
	 	
			$data['post_type_list'] = $this->mymodel->displayPostTypeList($limit,$start);
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="post_type";
			$data['count_user'] = $all;
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/post-type-list');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	 }

	 
	
	/*Check whether sub category name already exist or not*/
	function checkSubCategoryName($name, $sub_category_id)
	{
	    $condition = array('name'=>$name);
		$result_array =$this->commonmodel->getRecords('sub_category','sub_category_id',$condition);
				
		foreach($result_array as $row)
		{

			if( $row['sub_category_id'] != $sub_category_id)
			{
				$this->form_validation->set_message('checkSubCategoryName', 'The %s  already exist');
			   return false;
			}
		}
	
	}

	
	public function orderPostType()
	{
		
		if($this->mymodel->isLoggedIn())
		{
			$sub_category = $this->input->post('sub_category_id');
			foreach($sub_category as $key => $sub_category_id){
				$this->commonmodel->commonAddEdit('sub_category', array('weight' => $key), $sub_category_id);
			}
			exit;
		}
		else
		{
			redirect();
		}

	}

	/**Ajax edit request for inputs.*/
	public function editInputs()
	{
		if($this->mymodel->isLoggedIn())
		{
			$post_data = $this->input->post();
			
			$this->commonmodel->addEditRecords($post_data['table'], $post_data, $post_data['row_id']);
			echo $this->db->insert_id();


		}
		else
		{
			$this->session->sess_destroy();
			redirect();
		}
	}

	/*This function is used for displaying list of abused posts.*/
	public function reportAbuseList()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$start = $this->uri->segment(3,$start);			
		
			$this->db->from ('report_abuse');
			//$this->db->where('is_active', '1');
			$all =$this->db->count_all_results();
	 	
			$config['base_url'] = site_url("admin/reportabuselist");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
			$this->pagination->initialize($config);
				
			$data['abuse_list'] = $this->mymodel->reportAbuseList($limit,$start );
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="report_abuse";

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/report-abuse');
			$this->load->view('admin/include/footer');

			$this->session->set_userdata('redirect_url',current_url());
		}
		else
		{
			redirect();
		}
	}

	/* This function is used for displaying detail of abused post.*/
	public function reportAbusedPost($post_id)
	{
		if($this->mymodel->isLoggedIn()){
						
			$result = $this->db->select("report_abuse.*,post.title")
				 ->from('report_abuse')
				 ->join('post', 'report_abuse.post_id = post.post_id', 'left')
				 ->where('report_abuse.post_id', $post_id)
				 ->get();

			$data['abuse_list'] = $result->result_array();
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="report_abuse";
			$data['post_id'] =$post_id;

			$data['redirect_url'] =  $this->session->userdata('redirect_url') ? $this->session->userdata('redirect_url') : site_url('admin/reportabuselist');

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/report-abuse-detail');
			$this->load->view('admin/include/footer');

			$this->session->unset_userdata('redirect_url');
		}
		else
		{
			redirect();
		}
	}


	public function viewComments()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
			
			$post_id = $this->uri->segment(3);
			$start = $this->uri->segment(4,$start);
	
			$all =  count($this->mymodel->viewComments($start,$limit,$post_id,true));
				
			$config['base_url'] = site_url("admin/viewComments");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '4' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
												
		    $data['all_posts'] = $this->mymodel->viewComments($start,$limit,$post_id);
				
			if(array_key_exists('search',$_GET) && $_GET['search']!=''){}
			else{	$this->pagination->initialize($config); }
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="manage_content";
			$data['post_id'] =$post_id	;
			
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/view-comments',$data);
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}

	public function deleteComments($comment_id='',$post_id='')
	{
		if($this->mymodel->isLoggedIn()){
			if(is_numeric($comment_id)){
				$this->mymodel->deleteComments($comment_id);
				  //$all_posts = count($this->mymodel->viewComments('','',$post_id,true));line to delete
				redirect("/admin/viewComments/$post_id");	
			}
		}
		else
		{
			redirect();
		}
	}

	function sendVerificationEmail($user_id='')
	{
			
			$result =$this->db->select('*')->from('user')->where('user_id',$user_id)->get();
			$user_rec = $result->row_array();
			
			$this->commonmodel->setMailConfig();

			$newlink = str_replace('/ink-admin','',site_url());
			
			$link = $newlink."user/verifyuserlink/".$user_rec['token'];
			
			
			
			/*****************************************/	
			$subject = constant('VERIFICATION_MAIL_SUBJECT');
														
			//for mail text
			$mail_text = constant('VERIFICATION_MAIL');
			$mail_search = array("{USER_NAME}","{VERIFICATION_LINK}");
			$mail_replace = array("".$user_rec['user_name']."","".$link."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('VERIFICATION_MAIL_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
					
			$message =	str_replace($template_search, $template_replace, $template_string);
			/*****************************************/	
			
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($user_rec['email']);
			$this->email->subject('Welcome to InkSmash!');	
			$this->email->message($message);

			$this->commonmodel->sendEmail();

			$this->viewAccountInformation($user_id,'A email verification link has been sent to users email!');
	}
	
	function resetPassword($user_id='')
	{
			$result =$this->db->select('email,user_name')->from('user')->where('user_id',$user_id)->get();
			$user_rec = $result->row_array();
			$email = $user_rec['email'];
			$uniqid = uniqid();
			$newlink = str_replace('/ink-admin','',base_url());
			$link = $newlink.'user/resetPassword/'.$uniqid;
			$query = $this->db->update_string('user', array('token'=>$uniqid), "email = '$email'");
			$this->db->query($query);

		

			/*****************************************/	
			$subject = constant('USER_FORGOT_PASSWORD_SUBJECT');
														
			//for mail text
			$mail_text = constant('USER_FORGOT_PASSWORD_MAIL');
			$mail_search = array("{USER_NAME}","{CHANGE_PASS_LINK}");
			$mail_replace = array("".$user_rec['user_name']."","".$link."");
			
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('USER_FORGOT_PASSWORD_MAIL_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
					
			$message =	str_replace($template_search, $template_replace, $template_string);
			/*****************************************/	

			$this->commonmodel->setMailConfig();
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($email);
			$this->email->subject('Reset Password Link!!');
			$this->email->message($message);
			$this->commonmodel->sendEmail();

			
			$this->viewAccountInformation($user_id,'A reset password link has been sent to users email!');
	}

	
	function viewAccountInformation($user_id,$message='')
	{
		$user_detail = $this->mymodel->manageUserViewDetails($user_id);
		$data['user_detail'] = $user_detail;
		$data['message'] = $message;
		$this->load->view('admin/account-information',$data);
	}
	
	
	
	/* This function is used for load view of categor list.	*/
	 function displayCategoryList()
	 {
		 if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=30;
			$start = $this->uri->segment(3,$start);			
		
			$this->db->from ('category');
			$all =$this->db->count_all_results();
	 	
			$config['base_url'] = site_url("admin/displaycategorylist");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
			$this->pagination->initialize($config);
				
			$data['category_list'] = $this->mymodel->displayCategoryChildList($limit,$start);
			//echo build_admin_tree($data['category_list']);

			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="category";
			$data['count_user'] = $all;
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/category-list');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	 }

	
	/* This function is used to load view of Add new Category.*/
	function displayAddCategory()
	{
        $this->displayEditCategory();
	}
	
	/*This function is used to load view for Edit category .*/
	public function displayEditCategory($category_id)
	{
		if($this->mymodel->isLoggedIn()){
		if($category_id)
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
			$data['category_result'] = $this->mymodel->displayCategoryDropdown();
			
	 		$data['section'] = 'back-end';
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/edit-category');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
 

	/*This function perform action of edit any category .*/
	public function editCategory()
	{
	   
		if($this->input->post())
		{
		$edit_category_id =  $this->input->post('edit_category_id');
		$category_name= $this->input->post('category_name');
		$parent		 =  $this->input->post('parent_category');
		$is_active =    $this->input->post('is_active');
		
		$category_name = ucwords(strtolower($category_name));

		$this->form_validation->set_rules('category_name', 'Category Name', 'required|trim|xss_clean');

		if( $this->form_validation->run() == FALSE )
		{
						
			if($edit_category_id != ''){
				$category_detail = $this->mymodel->displayEditCategory($edit_category_id);
			}else{
				$data['category_detail']['category_id']	= $this->input->post('category_id');	
				$data['category_detail']['name']	= $this->input->post('category_name');	
				$data['category_detail']['is_active']	= $this->input->post('is_active');
			}
			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="category";
			
			$data['category_result'] = $this->mymodel->displayCategoryDropdown();
			
			$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->order_by('profile_name','asc')->get();
			$data['user_result'] = $user_result->result_array();
			
			if($this->input->post('parent_category')!= ''){
				$data['parent_category'] = $this->input->post('parent_category');
			}
			if($this->input->post('admin')!= ''){
				$data['admin'] = $this->input->post('admin');
			}
			if($this->input->post('read_write')!= ''){
				$data['read_write'] = $this->input->post('read_write');
			}
			if($this->input->post('read')!= ''){
				$data['read'] = $this->input->post('read');
			}
			
			if($this->input->post('admin_all') == 1){
				$data['admin_all'] = 1;
			}
			
			if($this->input->post('read_write_all') == 1){
				$data['read_write_all'] =1;
			}
			
			if($this->input->post('read_all') == 1){
				$data['read_all'] = 1;
			}
			
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/edit-category');
			$this->load->view('admin/include/footer');

		}else{
				   
			
			$category_data = array('name'=>$category_name,
									   'description'=>$category_name,
									   'is_active'  =>$is_active,									 
									   'parent'=> $parent
											);

			if($edit_category_id!=''){
				
				$category_id = $edit_category_id;
				$this->db->where('category_id',$edit_category_id);
				$this->db->update('category',$category_data);
			}else{
				
				$this->commonmodel->commonAddEdit('category',$category_data);
				$edit_category_id=$category_id = $this->db->insert_id();
		  	}
				
				//parameters for add user_category_relation
				$user_id = $this->session->userdata('user_id');
				$admins = $this->input->post('admin');
				$same_level_admin = explode(',',$this->input->post('same_level_admin'));
				$read_write = $this->input->post('read_write');
				$read = $this->input->post('read');
			
				//Now first delete all record related to category except in_herited = 1 and isert data
				//after this get all child categories related to category if find then remove all users with permission type 1 and is_inherited 1
				//and insert into db
				$this->db->delete('user_category_relation',array('category_id'=>$edit_category_id));
			 
				$admindata = array(); $uniqe_user=array();
			
			if( !empty($parent) )
			{
				//now get admin for parent_category
				$parent_admin = $this->mymodel->getAdminCategories($parent);
				if(!empty($parent_admin))
				{
					$parent_admin_cat = explode(',',$parent_admin['user_ids']);
					/*if(!empty($parent_admin_cat) && $parent_admin_cat[0] != '')
					{
						foreach($parent_admin_cat as $key=>$val)
						{
							$uniqe_user[]=$val;
							$admindata[] = array('user_id' => $val,
											 'category_id' => $edit_category_id,
											 'permission_type' =>1,
											 'is_inherited' => 1,
											 'created_by' => $user_id
											 );
						}
					}*/
				}
					
				//now get r/w for parent category
				$parent_rw =  $this->mymodel->getAdminInfo($parent,2);
				if(!empty($parent_rw))
				{
				   foreach($parent_rw as $prevrwkey=>$prevrwval)
				   {
				   		if(!in_array($prevrwval['user_id'], $uniqe_user)){
							$uniqe_user[]=$prevrwval['user_id'];
							$admindata[] = array('user_id' => $prevrwval['user_id'],
												'category_id' => $edit_category_id,
												'permission_type' =>2,
												'is_inherited' => 1,
												'created_by' => $user_id
												);
						}					
				   } 
				}
				
				//now get r/w and read for parent category
				$parent_read =  $this->mymodel->getAdminInfo($parent,3);
				if(!empty($parent_read))
				{
				   foreach($parent_rw as $prevrwkey=>$prevrval)
				   {
						if(!in_array($prevrval['user_id'], $uniqe_user)){
						$uniqe_user[]=$prevrwval['user_id'];
						$admindata[] = array('user_id' => $prevrwval['user_id'],
											'category_id' => $edit_category_id,
											'permission_type' =>3,
											'is_inherited' => 1,
											'created_by' => $user_id
											);
						}					
				   } 
				}
				
			}
			
			if( !empty($admins) )
			{	
				foreach($admins as $key=>$val)
				{
					
					if(!empty($parent_admin_cat) && $parent_admin_cat[0] != '')
					{
						if( in_array($val, $parent_admin_cat) ){
							$uniqe_user[]=$val;
							$admindata[] = array('user_id' => $val,
												'category_id' => $edit_category_id,
												'permission_type' =>1,
												'is_inherited' => 1,
												'created_by' => $user_id
												);	
						}
					}
					
					if(!in_array($val, $uniqe_user)){
						$uniqe_user[]=$val;
						$admindata[] = array('user_id' => $val,
											'category_id' => $edit_category_id,
											'permission_type' =>1,
											'is_inherited' => 0,
											'created_by' => $user_id
											);	
					}
				}
			}
			
			if( !empty($same_level_admin) && $same_level_admin[0] != '' )
			{	
				foreach($same_level_admin as $key=>$val)
				{
					if(!in_array($val, $uniqe_user)){
						$uniqe_user[]=$val;
						$admindata[] = array('user_id' => $val,
									 'category_id' => $edit_category_id,
									 'permission_type' =>1,
									 'is_inherited' => 0,
									 'created_by' => $user_id
									 );	
					}
				}
			}
			
			if(!empty($read_write))
			{	
				foreach($read_write as $rwkey=>$rwval)
				{
					if(!in_array($rwval, $uniqe_user))
					{
						$uniqe_user[]=$rwval;
						$admindata[] = array('user_id' => $rwval,
											 'category_id' => $edit_category_id,
											 'permission_type' =>2,
											 'is_inherited' => 0,
											 'created_by' => $user_id
											 );	
					}
				}
			}
			
			if(!empty($read))
			{	
				foreach($read as $rkey=>$rval)
				{
					 if(!in_array($rval, $uniqe_user))
					 {
						 $uniqe_user[]=$rval;
						$admindata[] = array('user_id' => $rval,
											 'category_id' => $edit_category_id,
											 'permission_type' =>3,
											 'is_inherited' => 0,
											 'created_by' => $user_id
											 );	
					}
				}
			}
			
			$this->db->insert_batch('user_category_relation', $admindata);
			
			
			//after this get all child categories and delete all user record for permission type 1 and inherited == 1
			//Imp code for get all subcategories related to category in one array
			$category_result = $this->display_children($edit_category_id,0);
			
			if( !empty($this->childcategory) )
			{
				foreach($this->childcategory as $childcat)
				{
				
					$inherited_admin = array();
					$unique_user = array();
					
					
					$this->db->delete('user_category_relation',array('category_id'=>$childcat,'permission_type'=>2,'is_inherited'=>1));
					$this->db->delete('user_category_relation',array('category_id'=>$childcat,'permission_type'=>3,'is_inherited'=>1));
					
						foreach($admindata as $key=>$val)
						{
							$prev_admin = array();
							if($val['permission_type']==1) {
							 	$this->db->delete('user_category_relation',array('category_id'=>$childcat,'permission_type'=>1,'is_inherited'=>1));
								
								
								$result_admin =  $this->mymodel->getAdminInfo($parent,1);
								
								if(!empty($result_admin)){
									foreach($result_admin as $val1){
										$prev_admin[]=$val1;
									}
								}
									
								//if(in_array($val['user_id'],$prev_admin)){
								$is_inherited=1;
								$unique_user[]  = $val['user_id'];
								$inherited_admin[] = array('user_id' => $val['user_id'],
													 'category_id' => $childcat,
													 'permission_type' =>$val['permission_type'],
													 'is_inherited' => $is_inherited,
													 'created_by' => $user_id
													 );	
							 //}
							 
							}elseif($val['permission_type']==2) {
							 	
								$prev_admin = array();
								$result_admin =  $this->mymodel->getAdminInfo($parent,2);
								if(!empty($result_admin)){
									foreach($result_admin as $key=>$val1){
										$prev_admin[]=$val1;
									}
								}
								
								$is_inherited=1;	
								if(!in_array($val['user_id'],$prev_admin) && !in_array($val['user_id'],$unique_user))
								{
									$unique_user[]  = $val['user_id'];
									$inherited_admin[] = array('user_id' => $val['user_id'],
														 'category_id' => $childcat,
														 'permission_type' =>2,
														 'is_inherited' => $is_inherited,
														 'created_by' => $user_id
															 );	
								}else{
									$inherited_admin[] = array('user_id' => $val['user_id'],
													 'category_id' => $childcat,
													 'permission_type' =>2,
													 'is_inherited' => $is_inherited,
													 'created_by' => $user_id
														 );	
								}
								//echo'<pre>';print_r($admindata);
								//echo'<pre>';print_r($inherited_admin);exit;
							 }elseif($val['permission_type']==3) {
							 	$this->db->delete('user_category_relation',array('category_id'=>$childcat,'permission_type'=>3,'is_inherited'=>1));
								
								$prev_admin = array();
								$result_admin =  $this->mymodel->getAdminInfo($parent,3);
								if(!empty($result_admin)){
									foreach($result_admin as $key=>$val1){
										$prev_admin[]=$val1;
									}
								}
								
									
								if(!in_array($val['user_id'],$prev_admin) && !in_array($val['user_id'],$unique_user)){
								$is_inherited=1;$unique_user[]  = $val['user_id'];
								$inherited_admin[] = array('user_id' => $val['user_id'],
													 'category_id' => $childcat,
													 'permission_type' =>$val['permission_type'],
													 'is_inherited' => $is_inherited,
													 'created_by' => $user_id
													 );	
							 	}
						
							 
						}
					 
				} 
						if(!empty($inherited_admin))
							$this->db->insert_batch('user_category_relation', $inherited_admin);
				}
			}
			if($this->input->post('section')=='back-end')
				redirect(base_url().'admin/displayEditCategory/'.$edit_category_id);
			else if($this->input->post('section')=='front-end')
				redirect(base_url().'post/displayEditCategory/0/'.$edit_category_id);
		}
	
		}else{
			redirect('admin/displaycategorylist');
		}
	}
	
	
	
	
	/* Function for delete category and sub category */
	public function deleteCategory()
	{
		$category_id = $this->input->post('category_id');
		
		//first get categoyr_id is parent or not if category_id is parent then delete all related child
		//and if cet_id is not parent then delete only category.
		$parent_or_not = $this->mymodel->parent_or_not($category_id);
		
		if($parent_or_not == 1)
		{
		   $category_result = $this->display_children($category_id,0);
           if( !empty($this->childcategory) )
		   {
		   		foreach( $this->childcategory as $key=>$val)
				{
					$this->db->where('category_id', $val);
					$this->db->or_where('parent', $val);
					$this->db->delete('category');
					
					$this->db->where('category_id', $val);
					$this->db->delete('user_category_relation');
				}
		   }
           
		}
		
		$this->db->where('category_id', $category_id);
		$this->db->or_where('parent', $category_id);
		$this->db->delete('category');
		
		$this->db->where('category_id', $category_id);
		$this->db->delete('user_category_relation');
		
		$this->db->from ('category');
		$all =$this->db->count_all_results();
		
		$output = array();
		$output = array('category_count'=>$all, 'status' =>'success');
		echo json_encode($output);
		exit;
	}
	
	/*Function for get admin Info using category Id and in admin_ids Column*/
	public function getAdminInfo()
	{
		$parent_category_id = $this->input->post('parent_category_id');
        $edit_category_id = $this->input->post('edit_category_id');
		$section = $this->input->post('section');
		$is_inherited_admin = $this->input->post('is_inherited_admin');
        
        if($edit_category_id)
		{
            $current_adm = $this->mymodel->getAdminInfo($edit_category_id,1);
			$current_inherited_adm = $this->mymodel->getAdminInfo($edit_category_id,1,1);
            $rec_rw = $this->mymodel->getAdminInfo($edit_category_id,2);
			$rec_inherited_rw = $this->mymodel->getAdminInfo($edit_category_id,2,1);
            $rec_r = $this->mymodel->getAdminInfo($edit_category_id,3);
        }
		
        if($parent_category_id !='' && $parent_category_id!=0)
		{
            $previous_adm = $this->mymodel->getAdminInfo($parent_category_id,1); 
            if($edit_category_id=='')
			{
               $rec_rw = $this->mymodel->getAdminInfo($parent_category_id,2);
               $rec_r = $this->mymodel->getAdminInfo($parent_category_id,3);
            }
        }
		
		//Get previous read users for current category
		if($edit_category_id)
		{
            $prev_read_user = $this->mymodel->getPrevReadUser($edit_category_id,3,1);
        }
		
		$admusers = $rwusers = $rusers = '';
		$admin_ids = $rw_ids = $r_ids = $prev_admin = $prev_read_arr = $prev_user_arr = $inherited_admin = array();
		
		//get user list
		$user_result = $this->db->select('user_id,profile_name')->from('user')->where('role',2)->where('is_active',1)->get();
			
		//get admin users
		foreach($previous_adm as $adminval){
			$previous_admin_ids[] = $adminval['user_id'];
			$inherited_admin[$adminval['user_id']] = $adminval['is_inherited'];
		}
            
		//get previous read user
		if(!empty($prev_read_user))
		{
			foreach($prev_read_user as $readval){
				$prev_read_arr[] = $readval['user_id'];
			}
		}
		
		//get admin users
		foreach($current_adm as $adminval){
			$current_admin_ids[] = $adminval['user_id'];                     
		}
		foreach($current_inherited_adm as $inhritadminval){
			$current_inherited_admin_ids[] = $inhritadminval['user_id'];                     
		}
		
		foreach($user_result->result_array() as $val)
		{
			/*if( in_array($val['user_id'],$previous_admin_ids) )
			{
				$prev_admin[] = '<li class="search-choice"><span>'.$val['profile_name'].'</span></li>';
			}*/
			
			$sel ='';
			if( in_array($val['user_id'],$current_admin_ids) || in_array($val['user_id'],$current_inherited_admin_ids))
			{
				$sel = 'selected="selected"';
				if( $section == 'front-end' && $is_inherited_admin == 0)
				{
					$same_level_admin[] = $val['user_id'];
					$sel .= 'disabled';
				}
			}
			
			$admusers .= '<option value="'.$val['user_id'].'" '.$sel.'>'.$val['profile_name'].'</option>';
			/*if( !in_array($val['user_id'],$previous_admin_ids))
			{
			  $admusers .= '<option value="'.$val['user_id'].'" '.$sel.'>'.$val['profile_name'].'</option>';
			}*/
							 
		}
		
		//get read/write users
		foreach($rec_rw as $rwval){
				$rw_ids[] = $rwval['user_id'];
		}
		foreach($rec_inherited_rw as $inherited_rwval){
				$rw_inherited_ids[] = $inherited_rwval['user_id'];
		}
		
		foreach( $user_result->result_array() as $val )
		{
			/*if( !in_array($val['user_id'],$previous_admin_ids)){
				if( in_array($val['user_id'],$rw_ids)){
						$rwusers .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
				}else{
						$rwusers .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
				}
			}*/
			
			$sel ='';
			if( in_array($val['user_id'],$rw_ids) || in_array($val['user_id'],$rw_inherited_ids) )
			{
				$sel = 'selected="selected"';
			}
			
			$rwusers .= '<option value="'.$val['user_id'].'" '.$sel.'>'.$val['profile_name'].'</option>';
		}
		
		//get read users
		foreach($rec_r as $rval){
				$r_ids[] = $rval['user_id'];
		}
		foreach( $user_result->result_array() as $val)
		{
			/*if( in_array($val['user_id'],$prev_read_arr)){
					if( in_array($val['user_id'],$r_ids)){
							$rusers .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
					}else{
							$rusers .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
					}
			}
			
			if( (in_array($val['user_id'],$prev_read_arr)) ){
					$prev_user_arr[] = '<li class="search-choice"><span>'.$val['profile_name'].'</span></li>';
					//$read .= 'selected="selected disabled "';
			}

			$rusers .= '<option value="'.$val['user_id'].'" '.$read.'>'.$val['profile_name'].'</option>';
			*/
					
			if(in_array($val['user_id'],$prev_read_arr) || in_array($val['user_id'],$r_ids) ){
				$rusers .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
			}else{
				$rusers .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
			}
		}
			
		$outputt = array(
					'status'=>'admin_exist',
					'users' => $admusers,
					'rwusers' => $rwusers,
					'rusers' => $rusers,
					'same_level_admin'=> implode(',',$same_level_admin));
		echo json_encode($outputt);
		exit;
		 
	}
	
	
	/** Function for get users list and show selected in dropa down */
	public function getUsersList()
	{
        $previous_adm = array();
         $parent_category_id = $this->input->post('parent_category_id');
         $selected_user = explode(',', $this->input->post('selected_user'));
          
         if($parent_category_id!='' && $parent_category_id!='0'){
        $previous_adm = $this->mymodel->getAdminInfo($parent_category_id,1); 
        foreach($previous_adm as $adminval){
					$previous_admin_ids[] = $adminval['user_id'];
                    
			}
         }
		$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->where('role',2)->get();
		$data['user_result'] = $user_result->result_array();
		
		$output = '';
 		
		foreach($user_result->result_array() as $key=> $val)
		{
            if(!in_array($val['user_id'], $previous_admin_ids) && !in_array($val['user_id'], $selected_user))
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
		$category_result = $this->db->select('user_id')->from('user_category_relation')->where('category_id',$category_id)->where('permission_type',2)->get();
		$category = $category_result->result_array();
		
		if(!empty($category)){
		
			foreach($category as $userval){
					$user_ids[] = $userval['user_id'];
			}
			$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->get();
			$output = '';
			foreach( $user_result->result_array() as $val)
			{
				
				if( in_array($val['user_id'],$user_ids)){
					$output .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
				}else{
					$output .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
				}
			}
			
			$outputt = array('status'=>'success','users' => $output);
			echo json_encode($outputt);
			exit;
		}else{
			$outputt = array('status'=>'fail');
			echo json_encode($outputt);
			exit;
		}
	}
	
	/*Function for get category users */
	public function getCategryReadUsers()
	{
		$category_id = $this->input->post('category_id');
		$category_result = $this->db->select('user_id')->from('user_category_relation')->where('category_id',$category_id)->where('permission_type',3)->get();
		$category = $category_result->result_array();
		
		if(!empty($category)){
		
			foreach($category as $userval){
					$user_ids[] = $userval['user_id'];
			}
			$user_result = $this->db->select('user_id ,profile_name')->from('user')->where('is_active',1)->get();
			$output = '';
			foreach( $user_result->result_array() as $val)
			{
				
				if( in_array($val['user_id'],$user_ids)){
					$output .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
				}else{
					$output .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
				}
			}
			
			$outputt = array('status'=>'success','users' => $output);
			echo json_encode($outputt);
			exit;
		}else{
			$outputt = array('status'=>'fail');
			echo json_encode($outputt);
			exit;
		}
	}
	
	/* Function for get sub-catetgories related to root category*/
	function display_children($parent, $level)
	{ 
		$query = 'SELECT category_id,name FROM category '.'WHERE parent="'.$parent.'"';
		$resultt = $this->db->query($query);
	
		foreach($resultt->result_array() as $row)
		{ 
			$thisref = &$this->childcategory;		
			$thisref[] =   $row['category_id'];
			$this->childcategory =  &$thisref ; 		 
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
            }
			$this->display_parent($row['parent'], $level+1);
		} 
	}
	

}
// End of  admin.php  controller file 
/* Location: ./application/controllers/admin.php */