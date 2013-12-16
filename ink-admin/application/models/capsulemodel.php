<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capsulemodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function saveNewCapsule($form_value){
		$query = $this->db->insert_string('capsule', $form_value);
		$this->db->query($query);
		return $this->db->insert_id();
	}

	function deleteCapsule($capsuleId = 0){
		
	}

	function capsuleDetail($post_id, $capsule_type=''){
		
		if($capsule_type){
			$capsules =	   $this->db->select('capsule.*, capsule_type.name as capsule_name')
								->from('capsule')
								->join('capsule_type', 'capsule.capsule_type_id = capsule_type.capsule_type_id', 'left')
								->where(array('post_id'=>$post_id, 'capsule_type.name'=>$capsule_type))
								->order_by("weight", "asc")
								->get();
		}else{
			$capsules =	   $this->db->select('capsule.*, capsule_type.name as capsule_name')
								->from('capsule')
								->join('capsule_type', 'capsule.capsule_type_id = capsule_type.capsule_type_id', 'left')
								->where('post_id', $post_id)
								->order_by("weight", "asc")
								->get();
			
		}
		
		//echo'<pre>';print_r($capsules->result_array());exit;
		
		return $capsules->result_array();			
	}



	/*function capsuleValue()*/

	function capsuleDetailValue($post_id){
		
		$capsules =	 $this->db->select('capsule.*, capsule_type.name as capsule_name')
								->from('capsule')
								->join('capsule_type', 'capsule.capsule_type_id = capsule_type.capsule_type_id', 'left')
								->where('post_id', $post_id)->order_by("weight", "asc")
								->get();
		
		$capsule_details = $capsules->result_array();
		foreach($capsules->result_array() as $capsule){
			$capsule_value_result = $this->db->select('*')
								->from($capsule['capsule_name'])
								->where('capsule_id', $capsule['capsule_id'])
								->get();
			$capsule_value[$capsule['capsule_id']]['detail'] = $capsule;
			if($capsule['capsule_type_id']==1){
				$capsule_value[$capsule['capsule_id']]['value'] = $capsule_value_result->row_array();
			}else{
				$capsule_value[$capsule['capsule_id']]['value'] = $capsule_value_result->result_array();
			}
		}
		return $capsule_value;			
	}


	function imageDetails($capsule_id){
		$capsules =	 $this->db->select('image.*, file_upload.*')
								->from('image')
								->join('file_upload', 'image.file_upload_id = file_upload.file_upload_id', 'left')
								->where('capsule_id', $capsule_id)
								->order_by("weight")
								->get();
		return $capsules->result_array();
	}

	function videoDetails($capsule_id){
		$capsules =	 $this->db->select('video.*, file_upload.*')
								->from('video')
								->join('file_upload', 'video.file_upload_id = file_upload.file_upload_id', 'left')
								->where('capsule_id', $capsule_id)
								->order_by("weight")
								->get();
		return $capsules->result_array();
	}

	function pollsDetails($capsule_id){
		$capsules =	 $this->db->select('polls.*, option.*')
								->from('polls')
								->join('option', 'polls.polls_id = option.source_id', 'left')
								->where('capsule_id', $capsule_id)
								->order_by("weight")
								->get();
		return $capsules->result_array();
	}

	function pollsResult($polls_id){
	
		$query =	$this->db->select('COUNT(*) as totalvotes')
								->from('votes')
								->join('option', 'votes.option_id = option.option_id', 'left')
								->where('option.source_id', $polls_id)
								->get();
			
		foreach ($query->result_array() as $row)
		{
		   $total=$row['totalvotes'];
		}
		
		
		$query = $this->db->select('option.option_id, option.title ,COUNT(*) as votes')
								->from('votes')
								->join('option', 'votes.option_id = option.option_id', 'left')
								->where('option.source_id', $polls_id)
								->get();
		
		if($total){
		foreach ($query->result_array() as $row)
		{
			$percent=round(($row['votes']*100)/$total);
			echo '<div class="option" ><p>'.$row['title'].' (<em>'.$percent.'%, '.$row['votes'].' votes</em>)</p>';
			echo '<div class="bar ';
			echo '" style="width: '.$percent.'%; " ></div></div>';
		}}
		echo '<p>Total Votes: '.$total.'</p>';
}

	
	
    
    
}
/* End of file usermodel.php */
/* Location: ./application/models/usermodel.php */