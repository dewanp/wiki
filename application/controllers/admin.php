<?php

class Admin extends CI_Controller
{

	public $childcategory = array();
	
	function __construct()
	{
		parent :: __construct();
		$this->load->helper( array('url','form','email','string'));
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



/* 
 * This function is used for log out from account.
*/
	function logout()
		{
			$this->session->sess_destroy();
			redirect();
		}

	
	/* 
	 * This function is used for displaying data on dashboard of admin section
	*/
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
	/* -------------MANAGE USER SECTION START HERE ---------
	 *  This function is used for displaying list of  active user 
	*/
	
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
			
			//echo'<pre>'; print_r($data['manage_user']);exit;
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
	
	
	/* 
	 * This function is used for displaying list of suspeded users.
	*/
	
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
	
	
	 
	
	
	
	
	
	/* 
	 * This function is used to load view for edit user details
	*/
	
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
	/* 
	 * This function is  used to load view of login history of a user
	*/
	
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
	
	/*
	 * This function is used to display history of content of particular user
	*/
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
	
	
	/* 
	 * This function is used for suspending users
	 * created on 11/apr/2012
	*/
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
	 
	 /* 
	  * This function is used for activating suspended user.
	 */
	 
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
	
	/* 
	 * This function is used to load Add user view .
	*/
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
	/* 
	 * This is function perform Add new User
	*/
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
	/*
	 * Callback function : used to check whether user_name already exist or not
	*/
	
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
	/*
	 * Callback function : used to check whether email id already exist or not.
	*/
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
	/* 
	 * This function is used to displaying details about specific user.
	*/
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
	/*
	 * This  function used for updating data of user
	 * Function call from  "manage-users-edit-details" on form submition	
	 */
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

			
			/* echo "<pre>";
			print_r($data);
			exit;
			 */

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
	 /*
  * This function is used to update capsule wrapper. 
   * Called by  Ajax function
 */
	public function updateCapsuleWrapper(){
		$post_id = $this->input->post('post_id');
		$view_type = $this->input->post('view_type','view');
		$capsule_type = $this->input->post('capsule_type');
		$data['post_id'] = $post_id;
		$data['post_capsules'] =  $this->mymodel->capsuleDetail($post_id, $capsule_type);
		
		echo $this->load->view('post/capsule-wrapper/'.$view_type, $data, true);
		exit;
	}

/*
 * This function is used to show post to user.
 * Called by Ajax function.
*/
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

	
	
	/* --------------MANAGE USER SECTION END HERE---------------*/
	
	/* --------------MANAGE CONTENT SECTION START HERE -----------*/
	
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

	

	/*
 * This function is used to show tags to user while tagging to post.
*/
	public function tagAutocomplete(){
		$tag = $this->input->get('term');	
		
		$tags = $this->db->select('*')
						->from('tag')
						->like('name', $tag)
						->get();
		
		$tag_array = array();
		foreach($tags->result_array() as $tag_detail){
			$tag_array[] = array('id' => $tag_detail['tag_id'], 'value' =>$tag_detail['name'],'label' =>$tag_detail['name']);
		}
		$tags_array = $tag_array;
		
		echo json_encode($tags_array);
		exit;
	}
	
	/*----------------MANAGE CONTENT SECTION END HERE -------------*/

	/* -------------CATEGORY SECTION START HERE--------------*/
	
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

	 /* 
	  * This function is used for toggel the status of category i.e Active or de-active.
	 */
	 
	 function Category_status_change($category_id="" , $status="")
	 {
		  $is_active_array = $this->input->post('is_active');
			if($this->input->post('active')== "Activate Selected")
			 {
				 $checked_user = $this->input->post('check');
				
				if(!empty($checked_user))
				{
					foreach($checked_user as $key =>$value)
					 {
						$data = array('is_active'=>'1');
						$this->db->where('category_id',$value);
						$this->db->update('category',$data);
					 }
				}
			 }
			 else if($this->input->post('deactive')== "Deactivate Selected")
				 {
					$checked_user = $this->input->post('check');
					if(!empty($checked_user))
						{
							foreach($checked_user as $key =>$value)
								{
									$data = array('is_active'=>'0');
									$this->db->where('category_id',$value);
									$this->db->update('category',$data);
								}
						}
				 }
			 else
			 {
					 if($status == 1)
						$data = array('is_active'=>'0');
					 else
						$data = array('is_active'=>'1');
						
					 $this->db->where('category_id',$category_id);
					 $this->db->update('category',$data);
			 }
			 redirect('admin/displaycategorylist');
 	 }
	
/* 
 * This function is used to load view of Add new Category.
*/

	function displayAddCategory()
	{
        $this->displayEditCategory();
	}

 

	/*
	 * This function perform action of edit any category .
	*/
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

			}
			else
			{
				$category_data = array('name'		=>$category_name,
					                   'description'=>$category_name,
									   'is_active'  =>$is_active,									 
					                   'parent'		=> $parent
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
				$read_write = $this->input->post('read_write');
				$read = $this->input->post('read');
				
				//Now first delete all record related to category except in_herited = 1 and isert data
				//after this get all child categories related to category if find then remove all users with permission type 1 and is_inherited 1
				//and insert into db
				$this->db->delete('user_category_relation',array('category_id'=>$edit_category_id));
				 
				//insert data
				$admindata = array(); $uniqe_user=array();
				
				if( !empty($parent) )
				{
					//now get admin for parent_category
					$parent_admin = $this->mymodel->getAdminCategories($parent);
					if(!empty($parent_admin))
					{
						$parent_admin_cat = explode(',',$parent_admin['user_ids']);
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
					}
				}
				
				if( !empty($admins) )
				{	
					foreach($admins as $key=>$val)
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
                        if(!in_array($rwval, $uniqe_user)){
                            $uniqe_user[]=$rwval;
						$admindata[] = array('user_id' => $rwval,
											 'category_id' => $edit_category_id,
											 'permission_type' =>2,
											 'is_inherited' => 0,
											 'created_by' => $user_id
											 );	
                    }}
				}
				
				if(!empty($read))
				{	
					foreach($read as $rkey=>$rval)
					{
                         if(!in_array($rval, $uniqe_user)){
                             $uniqe_user[]=$rval;
						$admindata[] = array('user_id' => $rval,
											 'category_id' => $edit_category_id,
											 'permission_type' =>3,
											 'is_inherited' => 0,
											 'created_by' => $user_id
											 );	
                    }}
				}
                
                
                
				$this->db->insert_batch('user_category_relation', $admindata);
				
				
					//after this get all child categories and delete all user record for permission type 1 and inherited == 1
					//Imp code for get all subcategories related to category in one array
					$category_result = $this->display_children($edit_category_id,0);
					
					if( !empty($this->childcategory) )
					{
						foreach($this->childcategory as $childcat)
						{
                      if( $this->input->post('overwirte_child') == 1 )
                            {       
                            
                            $this->db->delete('user_category_relation',array('category_id'=>$childcat));
                            $inherited_admin = array();
                                foreach($admindata as $key=>$val)
								{
                                    if($val['permission_type']==1) 
                                        $is_inherited=1;
                                    else $is_inherited=$val['is_inherited'];
                                    
                                        $inherited_admin[] = array('user_id' => $val['user_id'],
                                                             'category_id' => $childcat,
                                                             'permission_type' =>$val['permission_type'],
                                                             'is_inherited' => $is_inherited,
                                                             'created_by' => $user_id
                                                             );	
                                     
								}
                              
                                if(!empty($inherited_admin))
                                    $this->db->insert_batch('user_category_relation', $inherited_admin);
							
                            }else{
                                $this->db->delete('user_category_relation',array('category_id'=>$childcat,'permission_type'=>1,'is_inherited'=>1));
                                $inherited_admin = array();
                                foreach($admindata as $key=>$val)
								{
                                    if($val['permission_type']!=1) 
                                        continue;
									$inherited_admin[] = array('user_id' => $val['user_id'],
														 'category_id' => $childcat,
														 'permission_type' =>1,
														 'is_inherited' => 1,
														 'created_by' => $user_id
														 );	
								}
                                
                               
                                if(!empty($inherited_admin))
                                    $this->db->insert_batch('user_category_relation', $inherited_admin);
                                //without overwrite admin will get overwrite
                            }
							 
						}
					}
				
				redirect(base_url().'admin/displayEditCategory/'.$edit_category_id);
			}
		}
		else
		{
			redirect('admin/displaycategorylist');
		}
	}
/*
	 * This function is used to load view for Edit category .
	*/
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

	/* 
	 * This function check duplicate category. 
	*/
	function checkDuplicateCategory($value,$category_id ='')
	{
		$this->db->where(strtolower('name'),strtolower($value));
		if($category_id!=''){
			$this->db->where('category_id !=',$category_id);
		}
		$query = $this->db->get('category');
		if ($query->num_rows() > 0){
			$this->form_validation->set_message('checkDuplicateCategory', 'That category already exist.');
			return false;
		}
		else{
			return true;
		}

	}
	/* --------CATEGORY SECTION END HERE ------------------ */

	/* -----------SUB CATEGORY(POST TYPE) SECTION START HERE ---------*/

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

	 /*
	 * This function is used to load view of  " Adding new Sub category ".
	 */

   function  displayAddSubCategory()
	{
	   if($this->mymodel->isLoggedIn()){
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="post_type";
			$data['capsule_list'] = $this->mymodel->capsuleTypeList();
			
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/add-sub-category');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	/*
	 * This function perform action for adding new category in category table.
	*/
    function addSubCategory()
	{
	  if($this->input->post('add_user') == 'Add New Sub Category')
		{
			$this->form_validation->set_rules('sub_category_name','Sub Category Name', 'required|trim|xss_clean|callback_sub_category_check');
			if( $this->form_validation->run() == FALSE )
			{
				$data['title'] = "Vinfotech-wiki Admin Section";
				$data['active'] ="post_type";
				
				$data['capsule_list'] = $this->mymodel->capsuleTypeList();
				
				$this->load->view('admin/include/header', $data);
				$this->load->view('admin/add-sub-category');
				$this->load->view('admin/include/footer');
			}
			else
			{
				$this->mymodel->addNewPostTypeList();
				redirect('admin/displayposttypelist');
			}
		}
		else
		{
			redirect('admin/displayposttypelist');
		}
	  
	}

	/* 
	* This is callback function used to identify  whether this sub category already exist or not.
	 * if exist return false with error message "Sub category already exist"
	 * else return true.
	*/

	function sub_category_check($name)
	{
		$name = ucwords(strtolower($name));
		$this->db->select('name')
				 -> from('sub_category')
				 -> where('name',$name);
	    $query = $this->db->get();
		if($query->num_rows() >0)
		{
			$this->form_validation->set_message('sub_category_check', 'The %s  already exist');
			return FALSE;
		}
		else
		{
			return true;
		}
	}

	/*
	  * This function is used for toggle the is_active column of sub_category table
	  * Here we can  activate or deactivate sub categories.
	*/
	function sub_Category_status_change($category_id="" , $status="")
	 {
		  $is_active_array = $this->input->post('is_active');
		  if($this->input->post('active')== "Activate Selected")
			  {
			   $checked_user = $this->input->post('check');
				if(!empty($checked_user))
				  {
					foreach($checked_user as $key =>$value) 
					 {
						$data = array('is_active'=>'1');
						$this->db->where('sub_category_id',$value);
						$this->db->update('sub_category',$data);
					 }
				  }
			 }
			 else if($this->input->post('deactive')== "Deactivate Selected")
				 {
					$checked_user = $this->input->post('check');
					if(!empty($checked_user))
						{
							foreach($checked_user as $key =>$value)
								{
									$data = array('is_active'=>'0');
									$this->db->where('sub_category_id',$value);
									$this->db->update('sub_category',$data);
								}
						}
				 }
		 else
		 {
			 if($status == 1)
				$data = array('is_active'=>'0');
			 else
				$data = array('is_active'=>'1');
				
			 $this->db->where('sub_category_id',$category_id);
			 $this->db->update('sub_category',$data);
			 
		 }
		 redirect('admin/displayposttypelist');
 	 }

/*
* This function is used to load view for Editing/updating existing sub categories
*/
	 public function displayEditSubCategory($sub_category_id)
	{
		if($this->mymodel->isLoggedIn()){
			$sub_category_detail = $this->mymodel->displayEditSubCategory($sub_category_id);
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="post_type";
			$data['sub_category_detail'] = $sub_category_detail;

			$data['capsule_list'] = $this->mymodel->capsuleTypeList();
						
			$this->db->select('capsule_type_id');            // query for retriving capsule_type id
			$this->db->from('sub_category_capsule');         // corresponding to given sub_category_id
			$this->db->where('sub_category_id', $sub_category_id);
			$this->db->where('mandatory',1);
			$result = $this->db->get();

			$data['selected_capsule'] = $result->result_array(); 	
			
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/edit-sub-category');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
/*
 * This function perform action for Editing/Updating  existing sub category
*/
	public function editSubCategory()
	{
		if($this->input->post('save') == 'Save')
		{
			$sub_category_id = $this->input->post('sub_category_id');
			
			$this->form_validation->set_rules('sub_category_name','Sub Category Name', 'required|trim|xss_clean|callback_checkSubCategoryName['.$sub_category_id.']');
			
			if( $this->form_validation->run() == FALSE )
			{
				// Reload Same Edit Sub Category Page
				$sub_category_detail = $this->mymodel->displayEditSubCategory($sub_category_id);
				$data['title'] = "Vinfotech-wiki Admin Section";
				$data['active'] ="post_type";
				$data['sub_category_detail'] = $sub_category_detail;

				$data['capsule_list'] = $this->mymodel->capsuleTypeList();
							
				$this->db->select('capsule_type_id');            // query for retriving capsule_type id
				$this->db->from('sub_category_capsule');         // corresponding to given sub_category_id
				$this->db->where('sub_category_id', $sub_category_id);
				$this->db->where('mandatory',1);
				$result = $this->db->get();

				$data['selected_capsule'] = $result->result_array(); 	
				
				$this->load->view('admin/include/header', $data);
				$this->load->view('admin/edit-sub-category');
				$this->load->view('admin/include/footer');
			}
			else
			{								
				$this->db->delete('sub_category_capsule',array('sub_category_id'=>$sub_category_id));

				$this->mymodel->editSubCategory($sub_category_id);
				redirect('admin/displayposttypelist');
			}
		}
		else
		{
			redirect('admin/displayposttypelist');
		}
		
	}
		/*
	 * Call back function for edit category page
	 * Check whether sub category name already exist or not
	*/
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
/* -----------SUB CATEGORY(POST TYPE) SECTION END HERE ---------*/

	
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

/* Google Ad Sense  */

   public function updateGoogleAdClientId()
	{
		if($this->mymodel->isLoggedIn())
			{
				$data['title'] = "Vinfotech-wiki Admin Section";
				$data['active'] ="google_ads";
				$result =  $this->db->select('user_code,user_earnings_account_id')
									->from('user_earnings_account')
									->where('user_id',$this->session->userdata['user_id'])
									->where('account_type','2')
									->get();
				$data['google_ad'] = $result->row_array();
				$rs_percent = $this->db->select('google_ad_id,admin_percent')
									   ->from('google_ad')
									   ->get();
				$data['admin_percent'] = $rs_percent->row_array();

				
								
				$this->load->view('admin/include/header', $data);
				$this->load->view('admin/update-google-ads');
				$this->load->view('admin/include/footer');
				
			}
			else
		{
				redirect();
		}
	}

	function check_percent($percent)
	{
		if($percent%5 !=0)
		{
			$this->form_validation->set_message('check_percent', 'The %s  should be multiple of 5');
			return false;
		}
		else
		{
			return true ;
			
		}
	}

	/**
	 * Ajax edit request for inputs.
	 *
	 */
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

	/* 
	 * This function is used for displaying list of abused posts.
	 * Created by Neelesh Choukesy on 2012.05.29
	*/
	
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

	/* 
	 * This function is used for displaying detail of abused post.
	 * Created by Neelesh Choukesy on 2012.05.29
	*/
	
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



	/* -------------- View All Comments of Post -----------*/
	
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


    /* -------------- Delete comments -----------*/
	
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

	/* -------------- This function is used to send Verification Email to user by admin from User detail page --------------*/
	
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

	
	/* -------------- This function is used to send reset password link to user by admin from User detail page  --------------*/
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

	
	/* ---- load user status section using ajax from user detail page in admin ($RedirectPage wou1d be 1 for this case) -----*/
	function viewAccountInformation($user_id,$message='')
	{
		$user_detail = $this->mymodel->manageUserViewDetails($user_id);
		$data['user_detail'] = $user_detail;
		$data['message'] = $message;
		$this->load->view('admin/account-information',$data);
	}
	
	
	/* 
	 * This function is used for displaying list of contact detail.
	 * Created by Ashvin soni on 2013.01.18
	*/
	
	public function contactdetail()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
			
			$all = $this->db->from ('contact_data')->count_all_results();
	 	
			$start = $this->uri->segment(3,$start);			
			$config['base_url'] = site_url("admin/contactdetail");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
				
			$data['contact_list'] = $this->mymodel->contactDetailList($limit,$start);
			
			if(array_key_exists('search',$_GET) && $_GET['search']!=''){}
			else{			$this->pagination->initialize($config); }
			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="contact_detail";

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/contact-detail');
			$this->load->view('admin/include/footer');

			$this->session->set_userdata('redirect_url',current_url());
		}
		else
		{
			redirect();
		}
	}
	
	/*	Function for delete contact detail.
	*	Created date :- 2013-01-18 by Ashvin soni
	*	get contact_detail_id.
	*/
	function contactDetailDelete($contact_data_id)
	{
		if($this->mymodel->isLoggedIn()){
			
			$this->db->delete('contact_data', array('contact_data_id' => $contact_data_id));
		}
		else
		{
			redirect();
		}
	}
	
	
	/* 
	 * This function is used for displaying list of subscribed users.
	 * Created by Ashvin soni on 2013.01.18
	*/
	
	public function subscribeduser()
	{
		if($this->mymodel->isLoggedIn()){
			$start=0;
			$limit=20;
			$data = array();
			
			$all = $this->db->from ('subscribe')->count_all_results();
	 	
			$start = $this->uri->segment(3,$start);
			$config['base_url'] = site_url("admin/subscribeduser");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
				
			$data['subscribed_user'] = $this->mymodel->subscribedUserList($limit,$start);
			
			if(array_key_exists('search',$_GET) && $_GET['search']!=''){}
			else{ $this->pagination->initialize($config); }
			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="subscribed_user";

			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/subscribed-user');
			$this->load->view('admin/include/footer');

			$this->session->set_userdata('redirect_url',current_url());
		}
		else
		{
			redirect();
		}
	}
	
	/*	Function for delete subscribed user.
	*	Created date :- 2013-01-18 by Ashvin soni
	*	get contact_detail_id.
	*/
	function subscribedUserDelete($subscribe_id)
	{
		if($this->mymodel->isLoggedIn()){
			
			$this->db->delete('subscribe', array('subscribe_id' => $subscribe_id));
		}
		else
		{
			redirect();
		}
	}
	
	
	/*	Function for used to subscribed user list as 
	*	Excel format.
	*	Created date :- 2013-01-18 by Ashvin soni 
	*/
	 public function subscribedUserExcel()
	 {
		
		if($this->mymodel->isLoggedIn()){
			
			$filename = 'subscribed-user.csv';
			
			$query = "SELECT su.emailid FROM subscribe AS su WHERE su.isactive = 1";
			$data = $this->db->query($query);
			$emails_list = $data->result_array();
			
			$csv_output = "SUBSCRIBED USERS EMAIL";
			$csv_output .= "\n";
			
			foreach( $emails_list as $email )
			{
				$csv_output .= $email['emailid'];
				$csv_output .= "\n";
			}
			header("Content-type: application/x-msexcel"); 
			header("Content-disposition: attachment; filename=".$filename); 
			header("Pragma: no-cache"); 
			header("Expires: 0");
			
			print $csv_output; 
			exit;
		
		}else{
			redirect();		
		}
	 } //end of function
	
	
	/*
	* Function is used for the show listings of contest.
	*/
	public function showcontestlisting()
	{
		if($this->mymodel->isLoggedIn())
		{
			$start=0;
			$limit=20;
			$data = array();
			
			$all = $this->db->from('contest')->count_all_results();
			
			$start = $this->uri->segment(3,$start);
			$config['base_url'] = site_url("admin/showcontestlisting");
			$config['total_rows'] =  $all ;
			$config['per_page'] = $limit;
			$config['uri_segment'] = '3' ;
			$config['num_links'] = '2';
			$config['next_link'] = 'Next';
			$config['prev_link'] ='Previous';
				
			$data['contest_list'] = $this->mymodel->contestList($limit,$start);
			
			if(array_key_exists('search',$_GET) && $_GET['search']!=''){}
			else{ $this->pagination->initialize($config); }
			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="contests";
			$data['contest_added'] = "";
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/contest/list-contest');
			$this->load->view('admin/include/footer');
	
			$this->session->set_userdata('redirect_url',current_url());
		}
		else
		{
			redirect();
		}
	}
	
	
	/*
	* This function is used for the display contest.
	*/
	public function displayaddcontest()
	{
		if($this->mymodel->isLoggedIn())
		{			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="contests";
			$data['contest_added'] = "";
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/contest/add-contest');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	
	
	/*
	* Function is used for the add contest
	*/
	public function addcontest()
	{
		//echo'<pre>'; print_r($this->input->post());exit;
		if($this->input->post('add_contest')== "Add New Contest")
		{
				$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[6]');
				$this->form_validation->set_rules('tag', 'Tag', 'required|callback_tagcheck');				
				$this->form_validation->set_rules('editorData', 'Description', 'required');
				$this->form_validation->set_rules('contest_runs_from', 'Contest runs from', 'trim|required');
				$this->form_validation->set_rules('contest_runs_to', 'Contest runs to', 'trim|required');
				$this->form_validation->set_rules('prize_amount', 'Prize amount', 'trim|required|integer');
				$this->form_validation->set_rules('list_description[]', 'Parameter Contests', 'required');
				
			if($this->form_validation->run() == FALSE)
			{
					$data['contest_added'] = "";
			}
			else
			{ 
					$unique_contest_token = time().rand(0,9999999);
					$title = $this->input->post('title',true);
					$description = $this->input->post('editorData',true);
					$contest_runs_from = $this->input->post('contest_runs_from',true);
					$contest_runs_to = $this->input->post('contest_runs_to',true);
					$prize_amount = $this->input->post('prize_amount');
					$file_upload_id = $this->input->post('file_upload_id');
					$parameter_contest = $this->input->post('list_description');
					$status = 1;
				
					$data_array = array('unique_contest_token'=>$unique_contest_token,
										'title'=>$title,
										'description'=> $description,
										'runs_from' => strtotime($contest_runs_from),
										'runs_to' => strtotime($contest_runs_to),
										'prize'=> $prize_amount,
										'contest_image' => $file_upload_id,
										'status' => $status
									 );
					
					$this->commonmodel->addEditRecords('contest',$data_array);
					$new_contest_id = $this->db->insert_id();
					
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
							//adding new tag to database if user creates any new tag
							$replace_array = array('+', '=', '_', '!', '/', '\\' ,'?', '@', '#', '<', '>', '$', '%', '^', '&', '*', '(', ')', ':', ';');
							$trimed_tagg = str_replace($replace_array, '-', $trimed_tag);
							$new_tag = array('name' => $trimed_tagg);
							$this->commonmodel->commonAddEdit('tag', $new_tag);		
							$new_tag_id = $this->db->insert_id();
							$tag_term_id[$new_tag_id] = $new_tag_id;
						}
					}
				
					// adding records to category term post table for making relation with term and contest
					foreach($tag_term_id as $tag_id){
						$this->commonmodel->commonAddEdit('contest_tag', array('contest_id' => $new_contest_id, 'tag_id'=> $tag_id));
					}
					
					foreach($parameter_contest as $parameter_val){
						$this->commonmodel->commonAddEdit('contest_parameters', array('parameter'=> $parameter_val, 'contest_id' => $new_contest_id));
					}
					
					$data['contest_added'] = "done";
					redirect('admin/showcontestlisting');
				}
					$data['title'] = "Vinfotech-wiki Admin Section";
					$data['active'] ="contests";
			
					$this->load->view('admin/include/header', $data);
					$this->load->view('admin/contest/add-contest');
					$this->load->view('admin/include/footer');
			 }
			 else
			{
				redirect('admin/showcontestlisting');
			}
	}
	
	
	/*
	* This function is used for checking existing tags for a contest.
	*/
	function tagcheck($str)
	{
		if(count($str)>1){
			$nearr = array();
			foreach($str as $v){
				$nearr[strtolower($v)]=strtolower($v);
			}
			if(count($nearr)==count($str)){
				return true;
			}else{
				$this->form_validation->set_message('tagcheck', 'All tags should be different.');
				return false;
			}			
		}else{
			$this->form_validation->set_message('tagcheck', 'Please add At least Two tags.');
			return false;
		}
	}
	
	
	/*	Function for delete contest data.
	*	Created date :- 2013-04-10 by Ashvin soni
	*	get contest_id and delete from contest, contest_parameter table.
	*/
	public function contestdelete($contest_id)
	{
		if($this->mymodel->isLoggedIn())
		{
			$this->commonmodel->commonAddEdit('contest', array('is_deleted' => 1),$contest_id);
		}
		else
		{
			redirect('admin/showcontestlisting');
		}
	}
	
	
	/*	Function for restore contest data.
	*	Created date :- 2013-05-17 by Ashvin soni
	*	get contest_id and restore from contest, contest_parameter table.
	*/
	public function contestrestore($contest_id)
	{
		if($this->mymodel->isLoggedIn())
		{
			$this->commonmodel->commonAddEdit('contest', array('is_deleted' => 0),$contest_id);
		}
		else
		{
			redirect('admin/showcontestlisting');
		}
	}
	
	
	/*	Function for delete contest data permanently.
	*	Created date :- 2013-04-10 by Ashvin soni
	*	get contest_id and delete from contest, contest_parameter table.
	*/
	public function deletepermanent($contest_id)
	{
		if($this->mymodel->isLoggedIn())
		{
			$where = "contest_id = ".$contest_id;
			$this->commonmodel->deleteRecords('contest',$where);
			$this->commonmodel->deleteRecords('contest_tag',$where);
			$this->commonmodel->deleteRecords('contest_parameters',$where);
			$this->commonmodel->deleteRecords('contest_winners',$where);
		}
		else
		{
			redirect('admin/showcontestlisting');
		}
	}
	
	
		
	
	/*	Function for close any contest.
	*	Created date :- 2013-04-24 by Ashvin soni
	*	get contest_id and close from contest, contest_parameter table.
	*/
	public function contestclose($contest_id, $status)
	{
		if($this->mymodel->isLoggedIn())
		{
			$where = "contest_id = ".$contest_id;
			$this->commonmodel->closecontest('contest',$where, $status);
		}
		else
		{
			redirect();
		}
	}			
	
	
	/*
	* Function is used for the edit a contest using it's id
	*/
	public function contestedit($contest_id)
	{
		if($this->mymodel->isLoggedIn()){
			$contest_detail = $this->mymodel->manageContestEditDetails($contest_id);
			
			$tag_array = $contest_detail['tag_ids'];	
			$expode_tag_array = explode(",", $tag_array);		
			$tag_term_id = array();
			
			foreach($expode_tag_array as $tag){
				$trimed_tag = trim($tag);
				$avail_tag = $this->commonmodel->getRecords('tag','tag_id,name',array('tag_id' =>$trimed_tag),'',true);
								
				// tag will be numeric if it was selected old one otherwise
				if(!empty($avail_tag)){
					$tag_term_id[$avail_tag['tag_id']] = $avail_tag['name'];
				}			
			}			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="contests";
			$data['contest_detail'] = $contest_detail;
			$data['tag_term_id'] = $tag_term_id;
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/contest/edit-contest');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	
	
	function arraycheck($arr)
	{
		//echo'<pre>';print_r($arr);exit;
		/*foreach($arr as $key=>$val)
		{*/
			if(count(trim($arr)) > 1)
			{
				return true;
			}else{
				$this->form_validation->set_message('arraycheck', 'Parameter contest field is required.');
				return false;
			}
		//}
	}
	
	
	/* Function is used for the save data on edit contest */
	public function editcontest()
	{				
		if($this->input->post('edit_contest') == "Edit Contest")
		{				
				$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[6]');
				$this->form_validation->set_rules('tag', 'Tag', 'required|callback_tagcheck');
				$this->form_validation->set_rules('editorData', 'Description', 'required');
				$this->form_validation->set_rules('contest_runs_from', 'Contest runs from', 'trim|required');
				$this->form_validation->set_rules('contest_runs_to', 'Contest runs to', 'trim|required');
				$this->form_validation->set_rules('prize_amount', 'Prize amount', 'trim|required|integer');
				$this->form_validation->set_rules('list_description[]', 'Parameter Contest', 'required');
				
				
				if($this->form_validation->run() == FALSE)
				{
					$data['contest_added'] = "";
				}
				else
				{
					$contest_id = $this->input->post('contest_id');
					$unique_contest_token = $this->input->post('contest_token');
					$title = $this->input->post('title',true);
					$description = $this->input->post('editorData',true);	
					$contest_runs_from = $this->input->post('contest_runs_from',true);
					$contest_runs_to = $this->input->post('contest_runs_to',true);
					$prize_amount = $this->input->post('prize_amount');
					$file_upload_id = $this->input->post('file_upload_id');
					$parameter_contest = $this->input->post('list_description');
					$status = 1;
				
					$data_array = array('unique_contest_token'=>$unique_contest_token,
										'title'=>$title,
										'description'=> $description,
										'runs_from' => strtotime($contest_runs_from),
										'runs_to' => strtotime($contest_runs_to),
										'prize'=> $prize_amount,
										'contest_image' => $file_upload_id,
										'status' => $status
									 );
					
					$this->commonmodel->addEditRecords('contest',$data_array,$contest_id);
					$new_contest_id = $contest_id;
					
					// search for attach tags
					$tag_array = $this->input->post('tag');
					
					// All tag id new and old one
					foreach($tag_array as $tag)
					{
						$trimed_tag = trim($tag);
						$avail_tag = $this->commonmodel->getRecords('tag','tag_id',array('name' =>$trimed_tag),'',true);	
						// tag will be numeric if it was selected old one otherwise
						
						if(!empty($avail_tag)){
							$tag_term_id[$avail_tag['tag_id']] = $avail_tag['tag_id'];
						}else{					
							//adding new tag to database if user creates any new tag
							$replace_array = array('+', '=', '_', '!', '/', '\\' ,'?', '@', '#', '<', '>', '$', '%', '^', '&', '*', '(', ')', ':', ';');
							$trimed_tagg = str_replace($replace_array, '-', $trimed_tag);
							$new_tag = array('name' => $trimed_tagg);
							$this->commonmodel->commonAddEdit('tag', $new_tag);		
							$new_tag_id = $this->db->insert_id();
							$tag_term_id[$new_tag_id] = $new_tag_id;
						}
										
					}
					// adding records to category term post table for making relation with term and contest
					foreach($tag_term_id as $tag_id)
					{
						$avail_tag = $this->commonmodel->getRecords('contest_tag','contest_id,tag_id',array('contest_id' =>$new_contest_id, 'tag_id'=>$tag_id),'',true);
						
						if(!empty($avail_tag)){
							$this->db->delete('contest_tag', array('contest_id' => $new_contest_id));
							$this->commonmodel->commonAddEdit('contest_tag', array('contest_id' => $new_contest_id, 'tag_id'=> $tag_id));
						
						}else{
							$this->commonmodel->commonAddEdit('contest_tag', array('contest_id' => $new_contest_id, 'tag_id'=> $tag_id));
							$new_tag_id = $this->db->insert_id();
							$tag_term_id[$new_tag_id] = $new_tag_id;
						}
					}
					// adding records to category term post table for making relation with term and post*/
					foreach($parameter_contest as $key=>$parameter_val)
					{
						$avail_para = $this->commonmodel->getRecords('contest_parameters','*',array('contest_id' =>$new_contest_id,'parameter_id' => $key),'',true);						
						if(!empty($avail_para))
						{
							$where = "contest_id = '$new_contest_id' and parameter_id = '$key' ";
							$this->commonmodel->commonAddEditParameter('contest_parameters', array('parameter'=> $parameter_val, 'contest_id' => $new_contest_id),$where);
						
						}else{
							
							if(strlen($parameter_val)>1){
							
								$this->commonmodel->commonAddEdit('contest_parameters', array('parameter'=> $parameter_val, 'contest_id' => $new_contest_id));
							}
						}
					}
					
					$data['contest_added'] = "done";
					redirect('admin/showcontestlisting');
				}
					$data['title'] = "Vinfotech-wiki Admin Section";
					$data['active'] ="contests";
					
					$this->load->view('admin/include/header', $data);
					$this->load->view('admin/contest/edit-contest');
					$this->load->view('admin/include/footer');
			 }
		else
		{
			redirect('admin/showcontestlisting');

		}
	}
	
	
	/*	Function for delete contest data.
	*	Created date :- 2013-04-10 by Ashvin soni
	*	get contest_id and delete from contest, contest_parameter table.
	*/
	public function deleteParameter()
	{
		$parameter_id = $this->input->post('parameter_id');
		if($this->mymodel->isLoggedIn())
		{
			$where = "parameter_id = ".$parameter_id;
			$this->commonmodel->deleteRecords('contest_parameters',$where);
		}
		else
		{
			redirect();
		}
	}
	
	
	/*
	* Function is used for the small view of a contest using it's id
	*/
	public function contestview($contest_id)
	{
		if($this->mymodel->isLoggedIn())
		{
			$contest_detail = $this->mymodel->manageContestEditDetails($contest_id);
			
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="contests";
			$data['contest_detail'] = $contest_detail;
	
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/contest/view-contest');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	
	/*
	* Function is used for the detail view of a contest using it's id
	* And we can edit from this function.
	*/
	public function contestviewdetail($contest_id)
	{
		if($this->mymodel->isLoggedIn())
		{
			$contest_detail = $this->mymodel->manageContestEditDetails($contest_id);
			//echo'<pre>'; print_r($contest_detail);exit;
			$data['manage_user'] = $this->mymodel->ManageUserContest();
						
			$data['title'] = "Vinfotech-wiki Admin Section";
			$data['active'] ="contests";
			$data['contest_detail'] = $contest_detail;
			
			$this->load->view('admin/include/header', $data);
			$this->load->view('admin/contest/view-contest-detail');
			$this->load->view('admin/include/footer');
		}
		else
		{
			redirect();
		}
	}
	
	/* Function for get user's related post for select box */
	public function usersPost()
	{
		$user_id = $this->input->post('user_id');
		$rs_posts = $this->db->select('p.*')
									 ->from('post as p')									 									 
									 ->where('p.user_id' ,$user_id)
									 ->where('p.is_active' ,1)
									 ->where('p.is_block' ,0)
									 ->group_by('p.post_id')
									 ->order_by("p.created_date", "desc")
									 ->get();
		
		$result = $rs_posts->result_array();
		$output['status'] = 'success';
		
		$output ='<option value="0">Select the title of the post form the user which won</option>'; 
		foreach( $result as $key => $value)
		{
        	$output .=  '<option value="'.$value['post_id'].'">'.$value['title'].'</option>'; 
		}
		echo json_encode($output);
		exit;
	}
	
	
	/* Function  for save winneres list in database */
	public function savewinners()
	{		
		$contest_id = $this->input->post('contest_id');
		$userslist = $this->input->post('userSelectlist');
		
		//echo'<pre>'; print_r($userslist);
		
		$postslist = $this->input->post('userPostlist');
		
		//echo'<pre>'; print_r($postslist);
		
		//$combine_arr = array_combine($userslist,$postslist);
		
		
		$sub_arr = array();
		foreach($userslist as $key=>$user){
				
				$sub_arr[$user][] = $postslist[$key];
				
				
		 }
		 
	  foreach($sub_arr as $key => $subArray){
			foreach($subArray as $val){
				$newArray[][$key] = $val;
			}
		}
		
		foreach($newArray as $key => $val)
		{
			foreach($val as $userid=>$postid)
			{
				$avail_winner = $this->commonmodel->getRecords('contest_winners','*',array('contest_id' =>$contest_id,'user_id' => $userid, 'post_id'=>$postid),'',true);						
				if(!empty($avail_winner))
				{
					//return false;
					//$where = "contest_id = '$contest_id' and user_id = '$userid' ";
					//$this->commonmodel->commonAddEditParameter('contest_parameters', array('parameter'=> $parameter_val, 'contest_id' => $new_contest_id),$where);
				
				}else{
						$this->commonmodel->commonAddEdit('contest_winners', array('user_id'=> $userid, 'post_id'=> $postid, 'contest_id' => $contest_id));
				}
			}
		}
		redirect('admin/showcontestlisting');
	}
	
	/* Function for delete winner options using user_id and post_id */
	public function deletewinneroption()
	{
		$user_id = $this->input->post('user_id');
		$post_id = $this->input->post('post_id');
		$this->db->delete('contest_winners', array('user_id' => $user_id, 'post_id'=>$post_id));
		
		$output['status'] = 'success';
		echo json_encode($output);
		exit;
	}
	
	/* Function for delete category and sub category */
	public function deleteCategory()
	{
		$category_id = $this->input->post('category_id');
		
		$this->db->where('category_id', $category_id);
		$this->db->or_where('parent', $category_id);
		$this->db->delete('category');
		
		$this->db->where('category_id', $category_id);
		$this->db->delete('user_category_relation');
		
		$output['status'] = 'success';
		echo json_encode($output);
		exit;
	}
	
	/*Function for get admin Info using category Id and in admin_ids Column*/
	public function getAdminInfo()
	{
		$parent_category_id = $this->input->post('parent_category_id');
        $edit_category_id = $this->input->post('edit_category_id');
		
        
        if($edit_category_id){
            $current_adm = $this->mymodel->getAdminInfo($edit_category_id,1,1);
            $rec_rw = $this->mymodel->getAdminInfo($edit_category_id,2);
            $rec_r = $this->mymodel->getAdminInfo($edit_category_id,3);
        }
        if($parent_category_id!='' && $parent_category_id!=0){
            $previous_adm = $this->mymodel->getAdminInfo($parent_category_id,1); 
            if($edit_category_id==''){
                $rec_rw = $this->mymodel->getAdminInfo($parent_category_id,2);
               $rec_r = $this->mymodel->getAdminInfo($parent_category_id,3);
            }
        }
		$admusers = $rwusers = $rusers = '';
		$admin_ids = $rw_ids = $r_ids = $prev_admin = $inherited_admin = array();
		
		
			 
			//get user list
			$user_result = $this->db->select('user_id,profile_name')->from('user')->where('role',2)->where('is_active',1)->get();
			
			//get admin users
			foreach($previous_adm as $adminval){
					$previous_admin_ids[] = $adminval['user_id'];
                    $inherited_admin[$adminval['user_id']] = $adminval['is_inherited'];
			}
            
            foreach($current_adm as $adminval){
					$current_admin_ids[] = $adminval['user_id'];                     
			}
             
			foreach($user_result->result_array() as $val)
			{
				if( (in_array($val['user_id'],$previous_admin_ids)) ){
					$prev_admin[] = '<label>'.$val['profile_name'].'</label>';
				} 
                $sel ='';
                if( in_array($val['user_id'],$current_admin_ids)){
                    $sel = 'selected="selected"';
                }
                if( !in_array($val['user_id'],$previous_admin_ids)){
                  $admusers .= '<option value="'.$val['user_id'].'" '.$sel.'>'.$val['profile_name'].'</option>';
                }
                				 
			}
			//get read/write users
			foreach($rec_rw as $rwval){
					$rw_ids[] = $rwval['user_id'];
			}
			foreach( $user_result->result_array() as $val)
			{
                if( !in_array($val['user_id'],$previous_admin_ids)){
				if( in_array($val['user_id'],$rw_ids)){
					$rwusers .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
				}else{
					$rwusers .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
				}
                }
			}
			//get read users
			foreach($rec_r as $rval){
					$r_ids[] = $rval['user_id'];
			}
			
			foreach( $user_result->result_array() as $val)
			{
                if( !in_array($val['user_id'],$previous_admin_ids)){
				if( in_array($val['user_id'],$r_ids)){
					$rusers .= '<option value="'.$val['user_id'].'" selected="selected">'.$val['profile_name'].'</option>';
				}else{
					$rusers .= '<option value="'.$val['user_id'].'">'.$val['profile_name'].'</option>';
				}
                }
			}
			
			$outputt = array(
						'status'=>'admin_exist',						
						'prevadmin' => implode(', ',$prev_admin),
						'users' => $admusers,
						'rwusers' => $rwusers,
						'rusers' => $rusers);
			echo json_encode($outputt);
			exit;
		 
	}
	
	/** Function for get users list and show selected in dropa down */
	public function getUsersList()
	{
        $previous_adm = array();
         $parent_category_id = $this->input->post('parent_category_id');
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
            if(!in_array($val['user_id'], $previous_admin_ids))
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
		/*$output = '';
		if( $category['user_id'] != ''){
			$result = explode(',',$category['user_id']);
			$output .= $category['user_id'];
		}
		$parentusers = array('parentusers'=>$output);
		echo json_encode($parentusers);
		exit;*/
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

}
// End of  admin.php  controller file 
/* Location: ./application/controllers/admin.php */