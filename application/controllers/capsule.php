<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capsule extends CI_Controller {

	/**
	 * Index Page for this controller.
	*/
	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form','image_helper'));
		$this->load->model(array('commonmodel','capsulemodel'));		
	}

	/**
	 * Index Page for this controller.
	*/
	public function index()
	{
		$this->load->view('welcome_message');
	}

	
	public function add(){ 
		$post_new_capsules = $this->input->post('post_new_capsules');
		foreach($post_new_capsules as $key=>$new_capsule)
		{
			list($capsule_type,$capsule_type_id,$post_id) = explode("-",$new_capsule);
			$newCapsule = array('capsule_type_id' => $capsule_type_id, 'post_id' => $post_id);
			$this->commonmodel->commonAddEdit('capsule', $newCapsule);			
		}
		exit;
	}

	
	public function delete(){
		
		$capsule_id = $this->input->post('capsule_id');
		$capsule_type_id = $this->input->post('capsule_type_id');
		
		// delete first if value for capsule is added
		if($capsule_type_id == 1){
			$this->commonmodel->deleteRecords('paragraph', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 2){
			$this->commonmodel->deleteRecords('list', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 3){
			$this->commonmodel->deleteRecords('image', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 4){
			$this->commonmodel->deleteRecords('video', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 5){
			$this->commonmodel->deleteRecords('comment', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 6){
			$this->commonmodel->deleteRecords('polls', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 7){
			$this->commonmodel->deleteRecords('opinion', "capsule_id = '$capsule_id'");
		}elseif($capsule_type_id == 8){
			$this->commonmodel->deleteRecords('amazon', "capsule_id = '$capsule_id'");
		}
		
		$this->commonmodel->deleteRecords('capsule', "capsule_id = '$capsule_id'");
		exit;
	}

	/* 
		Name: order
		Parameter: key value weight from POST
		Output: none;
		Description: function for sorting the capsules this function is called from post-edit page
	*/
	public function order(){
		$capsule_ids = $this->input->post('capsule_id');
		foreach($capsule_ids as $key => $capsule_id){
			$this->commonmodel->commonAddEdit('capsule', array('weight' => $key), $capsule_id);
		}
		exit;
	}

	/* 
		Name: saveParagraph
		Parameter: key value weight from POST
		Output: none;
		Description: function for storing capsule value in the database
	*/
	public function saveParagraph(){
		
		$capsule_id = $this->input->post('capsule_id');
		$paragraph_id = $this->input->post('paragraph_id');
		$paragraph_title = $this->input->post('paragraph_title');
		$paragraph_value = strip_tags($this->input->post('paragraph_value'),"<p><a><h2><h3><img><ul><li><b><i><sup><sub><em><strong><u><br>");
		//$paragraph_value = $this->input->post('paragraph_value');
		
		if($paragraph_id > 0){
			// updating the paragraph content
			$paragraph_data = array('capsule_id' =>	$capsule_id, 'title' => $paragraph_title ,'value' => $paragraph_value);
			$this->commonmodel->commonAddEdit('paragraph', $paragraph_data,$paragraph_id);
		}else{
			// updating the paragraph content
			$paragraph_data = array('capsule_id' =>	$capsule_id, 'title' => $paragraph_title ,'value' => $paragraph_value);
			$this->commonmodel->commonAddEdit('paragraph', $paragraph_data);
		}
		exit;
	}
	
	
	/* 
		Name: saveAmazon
		Parameter: key value weight from POST
		Output: none;
		Description: function for storing amazon value in the database
	*/
	public function saveAmazon(){
		
		$capsule_id = $this->input->post('capsule_id');
		
		$amazon_urls = $this->input->post('amazon_url');
		$amazon_discriptions = $this->input->post('amazon_description');
		
		$search_amazon_id = $this->input->post('search_amazon_id');
		$result_type = $this->input->post('amazon_search_type');		
		$numberOfSearchResult = $this->input->post('amazon_num_of_search_result');
		
		$this->commonmodel->deleteRecords('amazon', "capsule_id = '$capsule_id'");
		
		if($result_type=='url'){
			foreach($amazon_urls as $key => $amazon_url){			
				$amazon_data = array(
					'capsule_id' =>$capsule_id, 
					'title' => $amazon_url,
					'description' => '', 
					'weight'=> '0', 
					'result_type' => $result_type, 
					'total_result' => 0
				);
				$this->commonmodel->commonAddEdit('amazon', $amazon_data);			
			}
		}else{
			$amazon_data = array(
				'capsule_id' =>$capsule_id, 
				'title' => $this->input->post('search_keyword'),
				'description' => $this->input->post('search_description'), 
				'weight'=> '0', 
				'result_type' => $result_type, 
				'total_result' => $numberOfSearchResult
			);
			$this->commonmodel->commonAddEdit('amazon', $amazon_data);
		}		
		exit;
	}

	/* 
		Name: savePolls
		Parameter: key value weight from POST
		Output: none;
		Description: function for storing capsule value in the database
	*/
	public function savePolls(){
		
		$capsule_id = $this->input->post('capsule_id');
		$polls_id = $this->input->post('polls_id');
		$polls_title = $this->input->post('title');
		$polls_description = $this->input->post('description');
		$polls_options = array();
		
		$is_options = $this->input->post('is_options');

		$polls_data = array(
						'capsule_id' =>	$capsule_id, 
						'title' => $polls_title ,
						'description' => $polls_description,
						'is_options' => $is_options
					  );
		$source_id = 0;
		if($polls_id > 0){
			// updating the Polls content
			$this->commonmodel->commonAddEdit('polls', $polls_data,$polls_id);
			$source_id = $polls_id;
		}else{
			// inserting in the Polls content
			$this->commonmodel->commonAddEdit('polls', $polls_data);
			$source_id = $this->db->insert_id();
		}
		
		
		$option_ids = $this->input->post('option_id');
		$option_titles = $this->input->post('option_title');
		// save update option 
		foreach($option_ids as $key => $option_id){
			
			$option_data = array(
					'source_id' =>$source_id, 
					'title' => $option_titles[$key],	
					'type' => 0
				);
			if($option_id > 0){
				// updating the list content
				$this->commonmodel->commonAddEdit('option', $option_data, $option_id);
			}else{
				// insert the list content
				$this->commonmodel->commonAddEdit('option', $option_data);
			}			
		}
		exit;
	}


	/* 
		Name: saveOpinion
		Parameter: key value weight from POST
		Output: none;
		Description: function for storing capsule value in the database
	*/
	public function saveOpinion(){
		
		$capsule_id = $this->input->post('capsule_id');
		$opinion_id = $this->input->post('opinion_id');
		$opinion_title = $this->input->post('title');
		$opinion_description = $this->input->post('description');
		$opinion_is_rating = $this->input->post('is_rating');
		$opinion_options = array();
		
		
		$opinion_data = array(
						'capsule_id' =>	$capsule_id, 
						'title' => $opinion_title ,
						'description' => $opinion_description,
						'is_rating' => $opinion_is_rating
						);
		$source_id = 0;
		if($opinion_id > 0){
			// updating the opinion content
			$this->commonmodel->commonAddEdit('opinion', $opinion_data,$opinion_id);
			$source_id = $opinion_id;
		}else{
			// inserting the opinion content
			$this->commonmodel->commonAddEdit('opinion', $opinion_data);
			$source_id = $this->db->insert_id();
		}
		
		
		$option_ids = $this->input->post('option_id');
		$option_titles = $this->input->post('option_title');
		$option_types = $this->input->post('option_type');
		// save update option 
		foreach($option_ids as $key => $option_id){
			
			$option_data = array(
					'source_id' =>$source_id, 
					'title' => $option_titles[$key],	
					'type' => $option_types[$key]
				);
			if($option_id > 0){
				// updating the list content
				$this->commonmodel->commonAddEdit('option', $option_data, $option_id);
			}else{
				// insert the list content
				$this->commonmodel->commonAddEdit('option', $option_data);
			}			
		}
		exit;
	}
	
	/*
	*	Function for delete opinion.
	*	data: - opinionId 
	*/
	public function deleteOption(){
		$option_id = $this->input->post('option_id');
		$this->db->delete('option', array('option_id' => $option_id)); 
	}
	
	/*
	*	Function for delete list item.
	*	data: - List Id 
	*/
	public function deleteListItem(){
		$list_id = $this->input->post('list_id');
		$this->db->delete('list', array('list_id' => $list_id));
	}
	
	/*
	*	Function for saveImage.
	*	data: - opinionId 
	*/
	public function saveImage(){
		$capsule_id = $this->input->post('capsule_id');
		$is_gallery = $this->input->post('is_gallery');
		
		$file_upload_ids = $this->input->post('file_upload_id');
		$image_ids = $this->input->post('image_id');
		$capsule_image_titles = $this->input->post('capsule_image_title');
		//$capsule_image_descriptions = $this->input->post('capsule_image_description');
		
		$this->commonmodel->commonAddEdit('capsule', array('is_gallery'=> $is_gallery), $capsule_id);

		foreach($image_ids as $key => $image_id){
			
			if($image_id > 0){
				// updating the image content
				$image_data = array(
					'capsule_id' =>	$capsule_id, 
					'file_upload_id' => $file_upload_ids[$key],
					'title' => $capsule_image_titles[$key],
					'description' => ' '
				);
				$this->commonmodel->commonAddEdit('image', $image_data, $image_id);
			}else{
				// insert the image content
				$image_data = array(
					'capsule_id' =>	$capsule_id, 
					'file_upload_id' => $file_upload_ids[$key],
					'title' => $capsule_image_titles[$key],
					'description' => ' '
				);
				$this->commonmodel->commonAddEdit('image', $image_data);
			}
			
			// make file active because now the image is used in this capsule
			$this->commonmodel->commonAddEdit('file_upload', array('is_active' => 1), $file_upload_ids[$key]);
		}
		exit;
	}
	
	/*
	*	Function for deleteCapsuleImage.
	*	data: - CapsuleImage ID 
	*/
	public function deleteCapsuleImage(){
		$image_id = $this->input->post('image_id');
		$this->db->delete('image', array('image_id' => $image_id));
		exit;
	}
	
	/*
	*	Function for saveVideo.
	*	data: - CapsuleImage ID 
	*/
	public function saveVideo(){
		$capsule_id = $this->input->post('capsule_id');
		
		$file_upload_ids = $this->input->post('file_upload_id');
		$video_ids = $this->input->post('video_id');
		$video_titles = $this->input->post('video_title');
		$video_descriptions = $this->input->post('video_description');


		foreach($video_ids as $key => $video_id){
			
			if($video_id > 0){
				// updating the image content
				$video_data = array(
					'capsule_id' =>	$capsule_id, 
					'file_upload_id' => $file_upload_ids[$key],
					'title' => $video_titles[$key],
					'description' => ' ',
					'weight' => $key
				);
				$this->commonmodel->commonAddEdit('video', $video_data, $video_id);
			}else{
				// insert the image content
				$video_data = array(
					'capsule_id' =>	$capsule_id, 
					'file_upload_id' => $file_upload_ids[$key],
					'title' => $video_titles[$key],
					'description' => ' ',
					'weight' => $key
				);
				$this->commonmodel->commonAddEdit('video', $video_data);
			}
			
			// make file active because now the image is used in this capsule
			$this->commonmodel->commonAddEdit('file_upload', array('is_active' => 1), $file_upload_ids[$key]);
			
		}
		exit;
		
	}
	
	/*
	*	Function for deleteCapsuleVideo.
	*	data: - CapsuleVideo ID 
	*/
	public function deleteCapsuleVideo(){
		$video_id = $this->input->post('video_id');
		$this->db->delete('video', array('video_id' => $video_id));
		exit;
	}

	/**
	 * saveList()
	 * @param Ajax post
	 * used for adding and editing any list item from any post
	 * 
	 */
	public function saveList(){
		$capsule_id = $this->input->post('capsule_id');
			
		$list_titles = $this->input->post('list_title');
		$list_ids = $this->input->post('list_id');
		$list_descriptions = $this->input->post('list_description');
		
		for($k=1;$k < count($list_ids);$k++){
			$list_titles[$k] = '';
		}

		foreach($list_ids as $key => $list_id){
			
			if($list_id > 0){
				// updating the list content
				$list_data = array(
					'capsule_id' =>	$capsule_id, 
					'title' => $list_titles[$key],	
					'description' => $list_descriptions[$key],
					'weight' => $key
				);
				$this->commonmodel->commonAddEdit('list', $list_data, $list_id);
			}else{
				// insert the list content
				$list_data = array(
					'title' => $list_titles[$key],
					'capsule_id' =>	$capsule_id, 
					'description' => $list_descriptions[$key],
					'weight' => $key
				);
				$this->commonmodel->commonAddEdit('list', $list_data);
			}			
		}
		exit;
	}

	/*
	*	Function  for save comment and shoot email
	*	when anonymous or any user comment on your post.
	*	When anyone post comment.
	*/
	public function saveComment(){		
		$capsule_id = $this->input->post('capsule_id');
		$comment_description = $this->input->post('comment_description');
		$comment_user = $this->input->post('user_id');
		$post_id = $this->input->post('post_id');
		$comment_data = array(
			'capsule_id' =>	$capsule_id, 
			'user_id' => $comment_user,	
			'description' => $comment_description,
			'created_date' => time(),
			'is_active' => 1,
			'weight' => 0
		);
		
		/* when anyone comment on your post condition */
		$user_id_using_post = $this->commonmodel->getRecords('post','title,user_id', array('post_id'=>$post_id),'',true);
		
		$account_setting_info = $this->commonmodel->getRecords('user_account_setting', 'user_id,someone_make_comment,someone_comment_post',array('user_id'=>$user_id_using_post['user_id']),'',true);
		
		/* if checkbox checked from account setting then shoot email otherwise do nothing */
		if($account_setting_info['someone_make_comment'] == 1){
			
			//get commenter name
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$profile_name = $this->commonmodel->getRecords('user','profile_name,user_name',array('user_id'=>$this->user_id),'',true);
				$commenter_name = "<a href=".base_url().$profile_name['user_name'].">".$profile_name['profile_name']."</a>";
			}else
			{
				$commenter_name = 'Anonymous';
			}
			$post_link =  "<a href=".getPostUrl($post_id).">".getPostUrl($post_id)."</a>";
			$italic_text = "<i>".$comment_description."</i>";
			
			/* code for send email when any comment posted on your post */			
			$email_using_user_id = $this->commonmodel->getRecords('user','profile_name,user_name,email', array('user_id'=>$user_id_using_post['user_id']),'',true);
			
			$single_subscribe_unsubscribe_info =  $this->commonmodel->getRecords('post_subscribe_unsubscribe','post_subscribe_unsubscribe_id,user_id', array('user_id'=>$user_id_using_post['user_id'],'post_id'=>$post_id),'',true);
			
			
			if(empty($single_subscribe_unsubscribe_info) && $user_id_using_post['user_id'] != $this->user_id)
			{
			
				$this->commonmodel->setMailConfig();
				$subject = constant('SOMEONE_MAKE_COMMENT_ON_YOUR_POST');
															
				//for mail text
				$mail_text = constant('SOMEONE_MAKE_COMMENT_ON_YOUR_POST_MAIL');
				$mail_search = array("{FIRST_NAME}","{POST_TITLE}","{COMMENTER_NAME}","{COMMENT}");		
				$mail_replace = array("".$email_using_user_id['profile_name']."","".$post_link."","".$commenter_name."","".$italic_text."");
				
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('SOMEONE_MAKE_COMMENT_ON_YOUR_POST_MAIL_FOOTER');
				
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
		} // first if end
		
		// second condition
		if($account_setting_info['someone_comment_post'] == 1)
		{
			//get commenter name
			if($this->commonmodel->isLoggedIn())
			{ 
				$this->user_id = $this->session->userdata('user_id');
				$profile_name = $this->commonmodel->getRecords('user','profile_name,user_name',array('user_id'=>$this->user_id),'',true);
				$commenter_name = "<a href=".base_url().$profile_name['user_name'].">".$profile_name['profile_name']."</a>";
			}
			else
			{
				$commenter_name = 'Anonymous';
			}
			$post_link =  "<a href=".getPostUrl($post_id).">".getPostUrl($post_id)."</a>";
			$italic_text = "<i>".$comment_description."</i>";
			
			$comment_count = $this->commonmodel->getRecords('comment','comment_id,user_id', array('capsule_id'=>$capsule_id),'',false);
			/* code for send email when any comment on post on which you also commented */
			foreach ($comment_count as $comment_user_id){
				
				$subscribe_unsubscribe_info =  $this->commonmodel->getRecords('post_subscribe_unsubscribe','post_subscribe_unsubscribe_id,user_id', array('user_id'=>$comment_user_id['user_id'],'post_id'=>$post_id),'',true);
				
				if(empty($subscribe_unsubscribe_info))
				{
					$email_using_user_id = $this->commonmodel->getRecords('user','profile_name,email', array('user_id'=>$comment_user_id['user_id']),'',true);
					
				
					$this->commonmodel->setMailConfig();
					$subject = constant('SOMEONE_COMMENTS_ON_YOU_COMMENTED');
																
					//for mail text
					$mail_text = constant('SOMEONE_COMMENTS_ON_YOU_COMMENTED_MAIL');
					
					$mail_search = array("{FIRST_NAME}","{POST_TITLE}","{COMMENTER_NAME}","{COMMENT}");		
					$mail_replace = array("".$email_using_user_id['profile_name']."","".$post_link."","".$commenter_name."","".$italic_text."");
					$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
					
					//for mail footer
					$mail_footer = constant('SOMEONE_COMMENTS_ON_YOU_COMMENTED_FOOTER');
					
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
		
		$this->commonmodel->commonAddEdit('comment', $comment_data);
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
			$capsule_content = $this->capsulemodel->imageDetails($capsule_id);
		}elseif($capsule_table =='video'){
			$capsule_content = $this->capsulemodel->videoDetails($capsule_id);
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

	/**
	 * Created by Neelesh Chouksey on 2012.03.02
	 * This function is used to show local posts.
	 * 
	 */
	public function isImageGallery()
	{
		$post_data = $this->input->post();
		
		if($post_data['is_gallery'])
		{
			$this->commonmodel->commonAddEdit('capsule_image_gallery', $post_data);
		}
		else
		{
			$this->commonmodel->deleteRecords('capsule_image_gallery', 'capsule_id = '.$post_data['capsule_id']);
		}
		exit;		
	}

	public function showHideComment(){
		$capsule_id = $this->input->post('capsule_id');
		$is_comment = $this->input->post('is_comment');
		$this->db->where('capsule_id', $capsule_id); 
		$this->db->update('capsule', array('is_comment'=> $is_comment));
	}

	public function pollsContent()
	{
		$polls_id = $this->input->post('polls_id');
		$capsule_id = $this->input->post('capsule_id');
		
		$rs_total_votes = $this->db->select('COUNT(*) as totalvote')
								->from('option')
								->join('votes', 'votes.option_id = option.option_id', 'right')
								->where(array('source_id' =>$polls_id, 'type' =>0))
								->get();
		$data['total_votes'] = $rs_total_votes->row_array();

		$rs_votes = $this->db->select('option.option_id, option.title, count(votes_id) as votecount')
								->from('option')
								->join('votes', 'votes.option_id = option.option_id', 'left')
								->where(array('source_id' =>$polls_id, 'type' =>0))
								->group_by('option.option_id')
								->get();
			
		$data['polls_id'] = $polls_id;
		$data['capsule_id'] = $capsule_id;
		$data['options'] = $rs_votes->result_array();

		if(array_key_exists("voted-".$polls_id,$_COOKIE) && $_COOKIE["voted-".$polls_id]=="yes"){		

			$data['votedvalue'] = $_COOKIE["voted-value-".$polls_id];
			echo $this->load->view('capsule/polls/polls-result', $data, true);

		}else{
			echo $this->load->view('capsule/polls/polls-form', $data, true);	
		}
		exit;
	}
	public function pollsSave()
	{
		$polls_id = $this->input->post('polls_id');
		$capsule_id = $this->input->post('capsule_id');
		$option_id = $this->input->post('option_id');
		$this->commonmodel->commonAddEdit('votes', array('option_id' =>$option_id,'ip'=>$this->input->ip_address()));
		setcookie("voted-".$polls_id, 'yes', time()+3600);
		setcookie("voted-value-".$polls_id, $option_id, time()+3600);
		
		$post_id_by_cap = $this->commonmodel->getRecords('capsule','post_id',array('capsule_id'=>$capsule_id),'',true);
		
		$user_id_post = $this->commonmodel->getRecords('post','user_id',array('post_id'=>$post_id_by_cap['post_id']),'',true);
		
		$user_email_id = $this->commonmodel->getRecords('user','user_id,profile_name,user_name,email',array('user_id'=>$user_id_post['user_id']),'',true);
		
		$account_setting_info = $this->commonmodel->getRecords('user_account_setting', 'user_id,someone_answer_publisher_poll',array('user_id'=>$user_email_id['user_id']),'',true);
		
		$subscribe_info =  $this->commonmodel->getRecords('post_subscribe_unsubscribe', 'user_id,post_id',array('user_id'=>$user_email_id['user_id'],'post_id'=>$post_id_by_cap['post_id']),'',true);
		
		/* if checkbox checked from account setting then shoot email otherwise do nothing */
		if($account_setting_info['someone_answer_publisher_poll'] == 1)
		{
			if(empty($subscribe_info))
			{
				$poll_link = "<a href=".getPostUrl($post_id_by_cap['post_id']).">Go to the poll now</a>";
		
				if($this->commonmodel->isLoggedIn())
				{ 
					$this->user_id = $this->session->userdata('user_id');
					$profile_name = $this->commonmodel->getRecords('user','profile_name,user_name',array('user_id'=>$this->user_id),'',true);
					$login_name = "<a href=".base_url().$profile_name['user_name'].">".$profile_name['profile_name']."</a>";
				}
				else
				{
					$login_name = 'Anonymous';
				}
			
				$this->commonmodel->setMailConfig();
				$subject = constant('SOMEONE_ANSWER_PUBLISHERS_POLL');
															
				//for mail text
				$mail_text = constant('SOMEONE_ANSWER_PUBLISHERS_POLL_MAIL');
				$mail_search = array("{PUBLISHER_NAME}","{ANSWER_NAME}","{POLL_URL}");
				$mail_replace = array("".$user_email_id['profile_name']."","".$login_name."","".$poll_link."");
				
				$mail_body = str_replace($mail_search, $mail_replace, $mail_text);
				
				//for mail footer
				$mail_footer = constant('SOMEONE_ANSWER_PUBLISHERS_POLL_FOOTER');
				
				// for mail tepmlate
				$template_string = constant('MAIL_TEMPLATE');
				$template_search = array("{MAIL_BODY}","{MAIL_FOOTER}");
				$template_replace = array("".$mail_body."","".$mail_footer."");
				
				$message =	str_replace($template_search, $template_replace, $template_string);
				
				$this->email->from(FROM_EMAIL, 'InkSmash');
				$this->email->to($user_email_id['email']);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->commonmodel->sendEmail();
		 	}
		}
		echo 'success';
	}
	
	function amazonShowResult(){
		$this->load->library('amazon');
		

		//if(!$this->session->userdata('user_id'))
		//{
			$capsule_id = $this->input->post('capsule_id');
			$rs_post_author_usercode =	$this->db->select('uea.user_code')
												 ->from('user_earnings_account as uea')
												 ->join('post as p', 'uea.user_id = p.user_id', 'left')
												 ->join('capsule as c', 'p.post_id = c.post_id', 'left')
												 ->where(array('c.capsule_id'=>$capsule_id, 'uea.account_type'=>1, 'uea.is_active'=>1))
												->get();
			$post_author_usercode = $rs_post_author_usercode->row_array();
			
			if(array_key_exists('user_code',$post_author_usercode))
			{
				$this->amazon_client->associateTag($post_author_usercode['user_code']);
			}
			else
			{
				$this->amazon_client->associateTag(DEFAULT_AMAZON_USER_CODE);
			}

	/*	}else{

				$rs_amazon_code = $this->db->select('user_code')
										->from('user_earnings_account')
										->where('user_id',$this->session->userdata('user_id'))
										->where('account_type',1)
										->get();
				$amazon_code = $rs_amazon_code->row_array();

				
				if(array_key_exists('user_code',$amazon_code))
				{
					$this->amazon_client->associateTag($amazon_code['user_code']);
				}
				else
				{
					$this->amazon_client->associateTag(DEFAULT_AMAZON_USER_CODE);
				}
		}*/
		//print_r($_POST);exit;
		$result_type = $this->input->post('amazon_search_type');		
		$numberOfSearchResult = $this->input->post('amazon_num_of_search_result');
		
		$data['result_type'] = $result_type;
		$data['numberOfSearchResult'] = $numberOfSearchResult;
		
		if($result_type=='url'){
			$amazon_urls = $this->input->post('amazon_url');
			//print_r($amazon_urls);
			foreach($amazon_urls as $key => $wwwurl){
				$wwwpos = strpos($wwwurl, 'amazon');
				if($wwwpos === false){
					continue;
				}else{
					$parserUrl = parse_url($wwwurl);
					
					if(array_key_exists('path',$parserUrl)){
						$path_info = explode("/",$parserUrl['path']);
						$gpurl = array_search("gp",$path_info);
						$dpurl = array_search("dp",$path_info);
						if($gpurl){
							$amazon_urls[$key] = $path_info[$gpurl+2];
						}elseif($dpurl){
							$amazon_urls[$key] = $path_info[$dpurl+1];
						}
					}					
				}
			}
			//print_r($amazon_urls);
			$response = $this->amazon_client->responseGroup('Medium')->optionalParameters(array('Condition' => 'New'))->lookup($amazon_urls);
			
			
		}else{
			$search_keyword = $this->input->post('search_keyword');
			
			$response = $this->amazon_client->responseGroup('Medium')->category('All')->search($search_keyword);
			
		}
		
		$data['items'] = $response->Items;
		//print_r($response);
		echo $this->load->view('capsule/amazon/item-list', $data, true);		
	}
	
	function test()
	{
			$capsule_content = $this->commonmodel->getRecords($capsule_table, '*', array('capsule_id' => $capsule_id),'weight');
			if(!empty($capsule_content)){
					$this->load->library('amazon');			
					//$this->amazon_client->associateTag('rtco01-20');
					//print_r($_POST);exit;
					$result_type = $capsule_content[0]['result_type'];		
					$numberOfSearchResult = $capsule_content[0]['total_result'];
					
					$ama['result_type'] = $result_type;
					$ama['numberOfSearchResult'] = $numberOfSearchResult;
					
					if($result_type=='url'){
						$response = $this->amazon_client->responseGroup('Medium')->optionalParameters(array('Condition' => 'New'))->lookup(array('B0053NBLFW','B002BBJMO6','B006P4DI5E'));
					}else{
						$search_keyword = $capsule_content[0]['title'];						
						$response = $this->amazon_client->responseGroup('Medium')->category('All')->search($search_keyword);
					}					
					$ama['items'] = $response->Items;
					$data['amazon_result'] = $this->load->view('capsule/amazon/item-list', $ama, true);
			}
		}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */