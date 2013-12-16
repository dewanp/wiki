<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

		
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'image','url'));
		$this->load->model(array('commonmodel','usermodel','messagemodel'));
	}

	/**
	 * Index Page for this controller.
	 */
	
	public function index()
	{}
	
	/* 
	 * This function is used for retriving incoming message for current user,default sort by time order by descending.
	 * Fill the left part of inbox.php & also act as message main page
	*/
	public function inbox()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			//$data['name'] =ucfirst(" Inbox ");
			$sort = $this->input->get('sort','mr.time');
			if($sort==""){
				$sort = 'mr.time';
			}
			$order = $this->input->get('order','desc');
			if($order==""){
				$order = 'desc';
			}
			
			
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			$data['inbox'] =  $this->messagemodel->inbox($sort,$order);
			
			
		   	$data['sort'] = $sort;
			$data['order'] = $order;
			$this->user_id = $this->session->userdata('user_id');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$this->load->view('includes/header',$data);
			$this->load->view('message/inbox');
			$this->load->view('includes/footer');
		}
		else
		{
			redirect(site_url());
		}

	}
	/* 
	 * This function is used for showing complete message and populate the right empty part of screen
	 * This is function call by AJAX and work for all three page i.e. Inbox, Sent and Archive.
	 * and load a view according to request.
	*/

	public function messageDescription()
	{
		 $message_id = $this->input->post('message_id');
		 $page_type = $this->input->post('page_type');
		
		$res =$this->messagemodel->messageDescription($message_id);
	
		if($page_type =='inbox')
		    echo $this->load->view('message/inbox-description',$res,true);
		 else if($page_type =='archive')
		    echo $this->load->view('message/archive-description',$res,true);			 
		 else
			echo $this->load->view('message/sent-description',$res,true);			 

		  
	}
	/* 
	 * This function is used for retriving archive message for current user.
	 * Fill the left part of archive.php, default sort by time order by descending .
	*/
	public function archive()
	{
		if($this->commonmodel->isLoggedIn())
		{ 
			$sort = $this->input->get('sort','mr.time');
			if($sort==""){
				$sort = 'mr.time';
			}
			$order = $this->input->get('order','desc');
			if($order==""){
				$order = 'desc';
			}

			$data['name'] =ucfirst(" Archive ");
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			 $data['archive'] =  $this->messagemodel->archive($sort,$order);
		   	$data['sort'] = $sort;
			$data['order'] = $order;
			$this->user_id = $this->session->userdata('user_id');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$this->load->view('includes/header',$data);
			$this->load->view('message/archive');
			$this->load->view('includes/footer');
		}
		else
		{
			redirect();
		}

	}
	/* 
	 * This function is used for  making archive message from inbox and sent messages.
	 * Function call by AJAX request.
	*/

	public function makeArchive()
	{
		$message_id = $this->input->post('message_id');
		$page_type = $this->input->post('page_type');

		/*if($page_type == "inbox")
		{*/
			$data = array('is_archive'=>'1');
			$this->db->where('message_id',$message_id);
			$this->db->where('recepient_id',$this->session->userdata('user_id'));
			$this->db->update('message_receiver',$data);
			redirect('message/inbox');
	/*	}*/
		/*if($page_type =="sent")
		{
			$data = array('is_archive'=>'1');
			$this->db->where('message_id',$message_id);
			$this->db->where('author_id',$this->session->userdata('user_id'));
			$this->db->update('message',$data);
			redirect('message/sent');
		}*/
		
	}
	/* 
	 * This function is used for  resuming archive message to inbox .
	 * Function call by AJAX request.
	*/

	public function removeArchive($message_id)
	{
		$data = array('is_archive'=>'0');
		$this->db->where('message_id',$message_id);
		$this->db->where('recepient_id',$this->session->userdata('user_id'));
		$this->db->update('message_receiver',$data);

		redirect('message/archive');
	}

	/*
	  * This function is used for creating new message and store in database.
	  * Function call by AJAX request.	
	*/
	
	public function compose()
	{
		$to_array = array();
		$to_array = $this->input->post('compose_to');
	
  		$from = $this->session->userdata('user_id');
  		$subject = $this->input->post('compose_subject');
   		$description = $this->input->post('compose_description');
		$message_data = array(
			'author_id'=>$from,
			'subject' => $subject,
			'description'=> $description,
			'time'=> time()
		);
		$this->commonmodel->commonAddEdit('message',$message_data);
		$new_message_id = $this->db->insert_id();
		
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		$sender_name = $this->commonmodel->getRecords('user','user_id,profile_name,user_name,email', array('user_id'=>$this->user_id),'',true);
		
		$sender_name_link = "<a href=".site_url().$sender_name['user_name'].">".$sender_name['profile_name']."</a>";
		$inbox_link = "<a href=".site_url('message/inbox').">Go to the Message Inbox</a>";
		foreach($to_array as $key=>$value){
			$recipent_data = array(
				'message_id'=>$new_message_id,
				'recepient_id'=>str_replace('-a','',$key),
				'time' => time()		
			);
			
		$account_setting_info = $this->commonmodel->getRecords('user_account_setting', 'user_id,receive_an_email', array('user_id'=>str_replace('-a','',$key)),'',true);
		
		/* if checkbox checked from account setting then shoot email otherwise do nothing */
		if($account_setting_info['receive_an_email'] == 1)
		{
			/* get user email, profile_name by id */
			$receiver_name = $this->commonmodel->getRecords('user','profile_name,user_name,email', array('user_id'=>str_replace('-a','',$key)),'',true);
					
			$this->commonmodel->setMailConfig();
			$subject = constant('RECEIVE_EMAIL_WITHIN_INKSMASH');
														
			//for mail text
			$mail_text = constant('RECEIVE_EMAIL_WITHIN_INKSMASH_MAIL');
			$mail_search = array("{RECEIVER_NAME}","{SENDER_NAME}","{MESSAGE_INBOX}");
			$mail_replace = array("".$receiver_name['profile_name']."","".$sender_name_link."","".$inbox_link."");
					
			$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
			
			//for mail footer
			$mail_footer = constant('RECEIVE_EMAIL_WITHIN_INKSMASH_FOOTER');
			
			// for mail tepmlate
			$template_string = constant('MAIL_TEMPLATE');
			$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
			$template_replace = array("".$mail_body."","".$mail_footer."");
				
			$message =	str_replace($template_search, $template_replace, $template_string);
			
			$this->email->from(FROM_EMAIL, 'InkSmash');
			$this->email->to($receiver_name['email']);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->commonmodel->sendEmail();	
		} //end if
		$this->commonmodel->commonAddEdit('message_receiver', $recipent_data);
		}
 		
	}
	/*
	 * This function is used for replying a message. 
	 * Again creating a new message but we cannot change the address of receipient.
	 * 
	*/

	public function postMessageReply()
	{	
		
		$to = "";
		$to = $this->input->post('to',true);
		$to_array = explode(',',$to);
		
		$from = $this->session->userdata('user_id');
		$subject = $this->input->post('reply_subject',true);
		$description = $this->input->post('description',true);
		$message_parent_id = $this->input->post('message_parent_id');

		$reply_data = array('author_id'=>$from,
							'subject'=>$subject,
							'description'=>$description,
							'time'=> time()					
						);

		$this->commonmodel->commonAddEdit('message',$reply_data);
		$new_message_id = $this->db->insert_id();
		
		
		if($this->commonmodel->isLoggedIn())
		{ 
			$this->user_id = $this->session->userdata('user_id');
		}
		$sender_name = $this->commonmodel->getRecords('user','user_id,profile_name,user_name,email', array('user_id'=>$this->user_id),'',true);
		
		$sender_name_link = "<a href=".site_url().$sender_name['user_name'].">".$sender_name['profile_name']."</a>";
		$inbox_link = "<a href=".site_url('message/inbox').">Go to the Message Inbox</a>";
		
			
		foreach($to_array as $value)
				{
				  if($value > 0 ){
					$recipent_data = array('message_id'=>$new_message_id,
										   'recepient_id'=>$value,
										   'time' => time()				
										  );
					
					
					$account_setting_info = $this->commonmodel->getRecords('user_account_setting', 'user_id,receive_an_email', array('user_id'=>$value),'',true);
		
					/* if checkbox checked from account setting then shoot email otherwise do nothing */
					if($account_setting_info['receive_an_email'] == 1)
					{
						/* get user email, profile_name by id */
						$receiver_name = $this->commonmodel->getRecords('user','profile_name,user_name,email', array('user_id'=>$value),'',true);
								
						$this->commonmodel->setMailConfig();
						$subject = constant('RECEIVE_EMAIL_WITHIN_INKSMASH');
																	
						//for mail text
						$mail_text = constant('RECEIVE_EMAIL_WITHIN_INKSMASH_MAIL');
						$mail_search = array("{RECEIVER_NAME}","{SENDER_NAME}","{MESSAGE_INBOX}");
						$mail_replace = array("".$receiver_name['profile_name']."","".$sender_name_link."","".$inbox_link."");
								
						$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
						
						//for mail footer
						$mail_footer = constant('RECEIVE_EMAIL_WITHIN_INKSMASH_FOOTER');
						
						// for mail tepmlate
						$template_string = constant('MAIL_TEMPLATE');
						$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
						$template_replace = array("".$mail_body."","".$mail_footer."");
							
						$message =	str_replace($template_search, $template_replace, $template_string);
						
						$this->email->from(FROM_EMAIL, 'InkSmash');
						$this->email->to($receiver_name['email']);
						$this->email->subject($subject);
						$this->email->message($message);
						$this->commonmodel->sendEmail();	
					} //end if
					$this->commonmodel->commonAddEdit('message_receiver', $recipent_data);
				  }
				}
		
	}

	/*
	 * This function is used for auto suggesting name of user for sending message as receipient.
	 * Function call by AJAX request
	*/
	public function getHint()
	{
	    $tag = $this->input->get('term',true);		
		$tag_array = $this->messagemodel->getTagsAutocomplete($tag);
		echo json_encode($tag_array);
		exit;
	}


	public function sent()
	{
	      if($this->commonmodel->isLoggedIn())
		{ 
			  $sort = $this->input->get('sort','mm.time');
			if($sort==""){
				$sort = 'mm.time';
			}
			$order = $this->input->get('order','desc');
			if($order==""){
				$order = 'desc';
			}
			
			$data['categories'] = $this->commonmodel->getRecords('category');
			$data['post_capsule_list'] = '';
			$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
			$data['res'] =  $this->messagemodel->sent($sort,$order);
						
		   	$data['sort'] = $sort;
			$data['order'] = $order;
			$this->user_id = $this->session->userdata('user_id');
			$data['profile_links'] = $this->load->view('user/profile-links', $data, true);
			$this->load->view('includes/header',$data);
			$this->load->view('message/sent');
			$this->load->view('includes/footer');
		}
		else
		{
			redirect();
		}
	}

	public function delete_message()
	{
		$message_id = $this->input->post('message_id',true);
		$page_type = $this->input->post('page_type',true);

		$data = array('is_del'=>'1');
		$this->db->where('message_id',$message_id);
		if($page_type =='inbox')
		{
			$this->db->where('recepient_id',$this->session->userdata('user_id'));
			$this->db->update('message_receiver',$data);
			redirect('message/inbox');
		}
		else if($page_type =='sent')
		{
			$this->db->where('author_id',$this->session->userdata('user_id'));
			$this->db->update('message',$data);
			redirect('message/sent');
		}
		/*else if($page_type =="archive")
		{
			$archive_area = $this->input->post('archive_area');
			if($archive_area == 'inbox')
			{
			
			$this->db->where('recepient_id',$this->session->userdata('user_id'));
			$this->db->update('message_receiver',$data);
		
			}
			else
			{
			
				$this->db->where('author_id',$this->session->userdata('user_id'));
				$this->db->update('message',$data);
			}
			//redirect('message/archive');
		}*/
	}
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */