<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends CI_Controller {

	var $page_title = "";
	var $page_keywords = "";
	var $page_desc = "";
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
		$this->load->model(array('commonmodel','contestmodel'));
	}
	
	public function index()
	{
		/* Index function for controller */
	}
	
	public function contestlist( $type= '')
	{
		$data = array();
		
		$data['type'] = $type;
		$data['posts'] = $this->contestmodel->getShowContest();
		
		$data['most_posted_users'] = true;
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		
		$data['post_capsule_list'] = $this->load->view('post/left-moreblock', $data, true);
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('contest/contest-list',$data);
		$this->load->view('includes/footer');		
	}
	
	public function view($contest_id, $type= '')
	{				
		//$type = 1 for running contest, $type = 0 for close contest
		$data = array();
		if($type == 0)
		{
				$sql ="SELECT con.*,
							(SELECT GROUP_CONCAT(conw.user_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS user_ids,
							(SELECT GROUP_CONCAT(conp.parameter  SEPARATOR '|--|') FROM contest_parameters as conp WHERE conp.contest_id = con.contest_id) AS parameters
						FROM contest AS con  
						WHERE con.unique_contest_token = $contest_id AND con.status = 0";
				$rs_closecontest = $this->db->query($sql);
				$data['posts'] = $rs_closecontest->row_array();	
		}else{
				$sql ="SELECT con.*,(SELECT GROUP_CONCAT(conw.user_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS user_ids,
									(SELECT GROUP_CONCAT(conp.parameter SEPARATOR '|--|') FROM contest_parameters as conp WHERE conp.contest_id = con.contest_id) AS parameters
								FROM contest AS con  
								WHERE con.unique_contest_token = $contest_id AND con.status = 1";
				$rs_runningcontest = $this->db->query($sql);
				$data['posts'] = $rs_runningcontest->row_array();
		}
			
		$data['type'] = $type;
		$data['most_posted_users'] = true;
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['post_capsule_list'] = $this->load->view('post/left-moreblock', $data, true);
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('contest/contest-view',$data);
		$this->load->view('includes/footer');		
	}
	
	
	public function viewwinners($contest_id , $type= '')
	{
		$data = array();
		$sql ="SELECT con.*,(SELECT GROUP_CONCAT(conw.user_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS user_ids,
								 (SELECT GROUP_CONCAT(conp.parameter SEPARATOR '|--|') FROM contest_parameters as conp WHERE conp.contest_id = con.contest_id) AS parameters,
								 (SELECT GROUP_CONCAT(conw.post_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS post_ids
						FROM contest AS con  
						WHERE con.unique_contest_token = $contest_id";
		$rs_runningcontest = $this->db->query($sql);
		$data['posts'] = $rs_runningcontest->row_array();
		
		$data['type'] = $type;
		$data['most_posted_users'] = true;
		
		$data['categories'] = $this->commonmodel->getRecords('category');
		$data['post_capsule_list'] = $this->load->view('post/left-moreblock', $data, true);
		$data['sidebar'] = $this->load->view('includes/sidebar', $data, true);
		
		$this->load->view('includes/header');
		$this->load->view('contest/contest-view-winners',$data);
		$this->load->view('includes/footer');		
	}
	
	
	/* 
	*	This function is used for show contest acoording
	*	running tab and over tab.
	*/
	public function contestPage(){
		
		$limit = 10;
		$page_id = $this->input->post('page_id');
		
		
		if(! $this->input->post('offset')){
			$offset = 0;
		}else{
			$offset = $this->input->post('offset');
		}
		$cur_user_id = $this->session->userdata('user_id'); 
		
		$data = array();
		$data['type'] = "";
		switch($page_id){
			case 'runningcontest':
				
				$sql ="SELECT con.*,(SELECT GROUP_CONCAT(conw.user_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS user_ids
						FROM contest AS con  
						WHERE con.status = 1 AND con.is_deleted = 0 ORDER BY con.contest_id  DESC limit $offset, $limit ";
				$rs_runningcontest = $this->db->query($sql);
	
				$data['posts'] = $rs_runningcontest->result_array();
				echo $this->load->view('contest/runningcontest',$data,true);
				break;
			
			default:
				//for over contest
				$sql ="SELECT con.*,(SELECT GROUP_CONCAT(conw.user_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS user_ids
						FROM contest AS con  
						WHERE con.status = 0 AND con.is_deleted = 0 ORDER BY con.contest_id  DESC limit $offset, $limit ";
				$rs_runningcontest = $this->db->query($sql);
																	
				$data['posts'] = $rs_runningcontest->result_array();
				echo $this->load->view('contest/overcontest',$data,true);
		}
	}
	
	public function loadMoreContest()
	{
		
		$page_type= $this->input->post('page_type');
		$offset = $this->input->post('offset');
		$limit = 10; 
		$data['posts'] = $this->contestmodel->getShowContest($offset,$limit);
		$this->load->view('contest/contest-wrapper',$data);
	}


} //end of class
?>