<?php
/*
This  controller  contain all methods related messaging.

*/
class  MessageModel extends CI_Model
{
	public function __construct()
	{
		parent :: __construct();
	}

	/* 
	 * This function is used to get received message for current login user. 
	 * Display subject, User name of sender and time of sended message with user defined sorted order.
	 */
	public function inbox($orderby="mr.time",$order="desc")
	{
		$inbox =" SELECT mm.subject, mm.message_id,mm.author_id , u.user_name, mr.time, mr.is_read from message as mm 
           right join message_receiver as mr on mm.message_id = mr.message_id
           left join user as u on mm.author_id = u.user_id
           where mr.recepient_id =".$this->session->userdata('user_id')." AND mr.is_archive = 0 AND mr.is_del=0
             order by $orderby  $order";
		$result = $this->db->query($inbox);
		return $result->result_array();
	}
	/* 
	 * This  function is used for displaying full length message for inbox, send and archive messages.
	 * Display subject, user name of sender, user name of all receiver including self, time and description.
	 */
	public function messageDescription($message_id)
	{
		$data = array('is_read'=>'1');
		$this->db->where('message_id',$message_id);
		$this->db->where('recepient_id',$this->session->userdata('user_id'));
		$this->db->update('message_receiver',$data);

	 	$message_description = "select um.user_id, um.user_name,mm.message_id , mm.time, mm.subject ,mm.description, group_concat(u.user_id,'#',u.user_name) as recepient 
					 from message as mm 
					 left join message_receiver as mr on mm.message_id = mr.message_id
					 left join user as u on   mr.recepient_id = u.user_id
					 left join user as um on mm.author_id = um.user_id
					 where mm.message_id  = $message_id
					 group by mr.message_id";
		$result = $this->db->query($message_description);

		/*$reply = "Select u.user_name as reply_user_name, m.author_id as reply_author_id,m.description as reply_description ,m.time as reply_time from message as m 
		left join user as u on m.author_id = u.user_id
		where message_parent_id = ".$message_id;
		$reply_result = $this->db->query($reply);

		$result_desc['result'] = $result->row_array();
		$result_desc['reply_result'] = $reply_result->result_array();

		return $result_desc ;*/
        return $result->row_array();
	}

	/*
	 * This  function is used to display  send messages.
	 * Display subject, user name of receiver and time with user defined sorted order.
	 */
	public function sent($orderby="mm.time",$order="desc")
	{
		 $sent = "Select mm.message_id, mm.subject, mm.time ,GROUP_CONCAT(u.user_name) as user_name from message as mm 
           left join message_receiver as mr on   mm.message_id = mr.message_id  
           left join user as u on mr.recepient_id = u.user_id
           where mm.author_id =".$this->session->userdata('user_id')." AND mm.is_del=0 AND mm.is_archive=0 
		   group by mr.message_id  order by $orderby  $order";

		 $result = $this->db->query($sent);
		 return $result->result_array();
	}

	/* 
	 * This function is used to display archive message.
	 * Here we select messages from both inbox and send archived message.
	 */

	public function archive($orderby="mr.time",$order="desc")
	{
		$inbox_archive =" SELECT mm.subject, mm.message_id  , u.user_name, mr.time, mr.is_read from message as mm 
           right join message_receiver as mr on mm.message_id = mr.message_id
           left join user as u on mm.author_id = u.user_id
           where mr.recepient_id =".$this->session->userdata('user_id')." AND mr.is_archive = 1 AND mr.is_del =0
           order by  $orderby  $order";
		$result_inbox = $this->db->query($inbox_archive);

		if($orderby == "mr.time")
			$orderby ="mm.time";

		/*$sent_archive = "Select mm.subject,mm.message_id, u.user_name,mm.time 
		                 from message as mm
						 left join user as u on mm.author_id = u.user_id
						 where mm.author_id=".$this->session->userdata('user_id')." AND mm.is_archive = 1 AND mm.is_del =0
						 order by  $orderby  $order";
		 $result_sent = $this->db->query($sent_archive);*/
		 
		 $result['inbox'] = $result_inbox->result_array();
		 //$result['sent'] = $result_sent->result_array();
		 return $result;

	}

	/*  
	 * tag listing function for auto complete 
	 * status: used
	 */
	function getTagsAutocomplete($tag)
	{
		$tags = $this->db->select('user_id,user_name')
						->from('user')
						->where('is_active',1)
						->like('user_name', $tag,'after')
						->get();
		
		$tag_array = array();
		foreach($tags->result_array() as $tag_detail){
			//$tag_array[] = array('key' => $tag_detail['user_id'], 'value' =>$tag_detail['user_name']);
			$tag_array[] = array('id' => $tag_detail['user_id'], 'value' =>$tag_detail['user_name'],'label' =>$tag_detail['user_name']);
		}
		return $tag_array;
	}

}
/* 
 * End of file : messagemodel.php .
 *  Location: ./application/models/messagemodel.php
 */