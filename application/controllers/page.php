<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('commonmodel');		
	}

	/**
	 * Index Page for this controller.
	 *
	 * 
	 */
	
		public function index(){
			
		}
		
		
		public function help_center(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/help-center',$data);
			$this->load->view('includes/footer');
		}
		
		public function about_inksmash(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/about-us',$data);
			$this->load->view('includes/footer');
		}
		
		public function creating_post(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/creating-post',$data);
			$this->load->view('includes/footer');
		}
		
		
		public function creating_account(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/creating-account',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		public function my_profile(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/my-profile',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		public function following_user(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/following-user',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		public function user_dashboard(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/user-dashboard',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		public function dos_and_donots(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/dos-and-notdos',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function selecting_post_type(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/selecting-post-type',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function choose_suitable_title(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/choose-suitable-title',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function add_related_tags(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/add-related-tag',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function share_social_networks(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/share-social-networks',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function using_blocks(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/using-blocks',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function earnings_section(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/earnings-section',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		
		public function how_to_make_money(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/how-to-make-money',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		
		public function setting_adsense_account(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/setting-adsense-account',$data);
			$this->load->view('includes/footer');
		}
		
		public function setting_amazon_affiliate_account(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/setting-amazon-affiliate-account',$data);
			$this->load->view('includes/footer');
		}
		
		public function tips_to_make_money(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/tips-to-make-money',$data);
			$this->load->view('includes/footer');
		}
		
		public function faq(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/faq',$data);
			$this->load->view('includes/footer');
		}
		
		
		
		
		public function terms_of_service(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/terms-of-service',$data);
			$this->load->view('includes/footer');
		}
		
		public function take_tour(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/take-tour',$data);
			$this->load->view('includes/footer');
		}
		
		public function what_we_do(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/what-we-do',$data);
			$this->load->view('includes/footer');
		}
		
		public function press_information(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/press-information',$data);
			$this->load->view('includes/footer');
		}
		
		public function official_blog(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/official-blog',$data);
			$this->load->view('includes/footer');
		}
		
		public function contact_us(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/contact-us',$data);
			$this->load->view('includes/footer');
		}
		
		public function contact_us_submit(){
			if(!empty($_POST)){
				$new_contact_data = array(
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'country' => $this->input->post('country'),
					'phone' => $this->input->post('phone'),
					'comment' => $this->input->post('comment'),
					'submitted_date' => date("Y-m-d H:i:s")
				);
				$this->commonmodel->commonAddEdit('contact_data', $new_contact_data);
				echo $this->db->insert_id();
				
				$this->commonmodel->setMailConfig();

				// reply email to form submittor
				$subject = constant('CONTACT_FROM_NOTIFICATION_TO_USER_SUBJECT');
															
				//for mail text
				$mail_text = constant('CONTACT_FROM_NOTIFICATION_TO_USER_MAIL');
				$mail_search = array("{NAME}");
				$mail_replace = array("".$this->input->post('name')."");
				
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('CONTACT_FROM_NOTIFICATION_TO_USER_MAIL_FOOTER');
				
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
				
				// Notification to admin
				$subject = constant('CONTACT_FROM_NOTIFICATION_TO_ADMIN_SUBJECT');
															
				//for mail text
				$mail_text = constant('CONTACT_FROM_NOTIFICATION_TO_ADMIN_MAIL');
				$mail_search = array("{NAME}","{EMAIL}","{COUNTRY}","{PHONE}","{COMMENT}");
				$mail_replace = array("".$this->input->post('name')."","".$this->input->post('email')."","".$this->input->post('country')."","".$this->input->post('phone')."","".$this->input->post('comment')."");
				
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('CONTACT_FROM_NOTIFICATION_TO_ADMIN_MAIL_FOOTER');
				
				// for mail tepmlate
				$template_string = constant('MAIL_TEMPLATE');
				$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
				$template_replace = array("".$mail_body."","".$mail_footer."");
				
					
				$message =	str_replace($template_search, $template_replace, $template_string);
				
				
				$this->email->from(FROM_EMAIL, 'InkSmash');
				$this->email->to('admin@inksmash.com');
				//$this->email->to('pradeep@vinfotech.com');
				$this->email->subject($subject);
				$this->email->message($message);
				$this->commonmodel->sendEmail();
			}
			exit;
		}
		
		public function management(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/management',$data);
			$this->load->view('includes/footer');
		}
		
		
		/*	Function for load how it works view */
		public function how_it_works(){
		
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}
	
			$this->load->view('includes/header');
			$this->load->view('pages/how-it-works',$data);
			$this->load->view('includes/footer');
		}
		


// ***** Master Under Construction function *****
function underConstruction($page="")
	{
		$data['name'] =ucfirst( urldecode($page));
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['post_capsule_list'] = '';
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
		}

		$this->load->view('includes/header');
		$this->load->view('pages/master-under-construction',$data);
		$this->load->view('includes/footer');
	}

	// ***** View Demo Video page *****
	function demoVideo($page="")
		{
			$data['name'] =ucfirst( urldecode($page));
			 $data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			}

			$this->load->view('includes/header');
			$this->load->view('pages/view-demo-video',$data);
			$this->load->view('includes/footer');
		}


    function SubscribeEmail()
	{
		$selectemail = "";
		$email = $this->input->post('emailid');
		$field = array('subscribe_id','emailid','isactive');
		$condition = array('emailid '=>$email);
		
		$result = $this->commonmodel->getRecords('subscribe',$field,$condition);
		$msg = ""; 
		$res = "";
		foreach($result as $row){
			$id = $row['subscribe_id'];
			$selectemail = $row['emailid'] ;
			$isactive = $row['isactive'];
		}					
		
		if($selectemail == $email){
			if($isactive != 1){
				$updata = array('isactive'=>1);
				$this->db->where('subscribe_id', $id);
				$this->db->update('subscribe' ,$updata);
				$msg = "Your subscription has been reactivated";
				$res = "success";
			}else{
				$msg = "This email-id already subscribed";
				$res = "error";
			}
		}else{
			$insert = array('emailid'=>$email , 'isactive'=>1);
			$res= $this->db->insert('subscribe', $insert);
			if($res == true){
			
				$this->commonmodel->setMailConfig();
				$subject = constant('SUBSCRIPTION_SUBJECT');
															
				//for mail text
				$mail_text = constant('SUBSCRIPTION_MAIL');
				$mail_search = array("{MAIL}");		
				$mail_replace = array("".$email."");
				
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('SUBSCRIPTION_FOOTER');
				
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
				$msg = "Subscription has been sent.";
				$res = "success";
			}
			else{
				$msg = "Sorry for incovenience. please try again";
				$res = "error";
			}
		}
		echo "$msg###$res";
		exit;
	 }


		 function myEarningAccount()
			{
				 $data['categories'] = $this->commonmodel->getRecords('category');
				$data['post_capsule_list'] = '';
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				if($this->commonmodel->isLoggedIn())
				{ 
					$this->user_id = $this->session->userdata('user_id');
					
					$data['profile_links'] = $this->load->view('user/profile-links', $data, true);

					
					
					$this->load->view('includes/header');
					$this->load->view('pages/my-earning-account',$data);
					$this->load->view('includes/footer');
				}
				else
				{

					$this->load->view('includes/header');
					$this->load->view('pages/my-earning-account',$data);
					$this->load->view('includes/footer');

				}
			}

		 function mySetting()
			{
				 $data['categories'] = $this->commonmodel->getRecords('category');
				$data['post_capsule_list'] = '';
				$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
				
				if($this->commonmodel->isLoggedIn())
				{ 
					$this->user_id = $this->session->userdata('user_id');
					
					$data['profile_links'] = $this->load->view('user/profile-links', $data, true);

					
					
					$this->load->view('includes/header');
					$this->load->view('pages/my-setting',$data);
					$this->load->view('includes/footer');
				}
				else
				{

					$this->load->view('includes/header');
					$this->load->view('pages/my-setting',$data);
					$this->load->view('includes/footer');

				}
			}

}

/* End of file page.php */
/* Location: ./application/controllers/page.php */