<?php 
/*
this model is commonly used for all pages..
like index page, sign in etc.
*/

class Commonmodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	// this function returns table data.
	function getRecords($table, $fields="", $condition="", $orderby="", $single_row=false) //$condition is array 
	{
		if($fields != "")
		{
			$this->db->select($fields);
		}
		 
		if($orderby != "")
		{
			$this->db->order_by($orderby); 
		}

		if($condition != "")
		{
			$rs = $this->db->get_where($table,$condition);
		}
		else
		{
			$rs = $this->db->get($table);
		}
		
		if($single_row)
		{  
			return $rs->row_array();
		}
		return $rs->result_array();

	}

	// Created by Neelesh Chouksey
	// this function is to add/edit data into table .
	// this function is to add/edit data in only one table at a time.
	function addEditRecords($table_name, $data_array, $id = "")
	{
		if($table_name && is_array($data_array))
		{
			$columns = $this->getTableFields($table_name);
			foreach($columns as $coloumn_data)
						  $column_name[]=$coloumn_data['Field'];
					  
			foreach($data_array as $key=>$val)
			{
				if(in_array(trim($key),$column_name))
				{
					$data[$key] = $val;
				}
			 }

			if($id == "")
			{	
				$query = $this->db->insert_string($table_name, $data);
			}
			else
			{
				$where = $table_name."_id = '$id'";
				$query = $this->db->update_string($table_name, $data, $where);
			}
			$this->db->query($query);
		}			
	}

	// Function for add or edit record in database by condition.
	function commonAddEdit($table_name, $data_array, $id = "")
	{
		if($table_name && is_array($data_array))
		{
			if($id == "")
			{	
				$query = $this->db->insert_string($table_name, $data_array);
			}
			else
			{
				$where = $table_name."_id = '$id'";
				$query = $this->db->update_string($table_name, $data_array, $where);
			}
			$this->db->query($query);
		}			
	}
	
	// function for deleting records by condition.
	function deleteRecords($table, $where)
	{ 
		$query = "DELETE FROM $table WHERE $where";
		$this->db->query($query);
	}

	// this function is used to get all the fields of a table.
	function getTableFields($table_name)
	{
		$query = "SHOW COLUMNS FROM $table_name";
		$rs = $this->db->query($query);
		return $rs->result_array();
	}

	// This function is used to set up mail configuration..
	function setMailConfig()
	{
		$this->load->library('email');
		$config['smtp_host'] = SMTP_HOST;
		$config['smtp_user'] = SMTP_USER;
		$config['smtp_pass'] = SMTP_PASS;
		$config['smtp_port'] = SMTP_PORT;
		$config['protocol'] = PROTOCOL;
		$config['mailpath'] = MAILPATH;
		$config['mailtype'] = MAILTYPE;
		$config['charset'] = CHARSET;
		$config['wordwrap'] = WORD_WRAP;

		$this->email->initialize($config);
	}

	function sendEmail()
	{
		$this->email->send();
	}

	
	// Created by Neelesh Chouksey
	// This function is to check for logged-in user
	function isLoggedIn(){
	
		if($this->session->userdata('user_id')!='' && $this->session->userdata('email')!='')
		{ 
			/*$this->login_user['user_id'] = $this->session->userdata('user_id');
			$this->login_user['user_name'] = $this->session->userdata('user_name');
			$this->login_user['email'] = $this->session->userdata('email');*/
			return true;
		}
		else
		{
			return false;
		}
	}

	// Created by Neelesh Chouksey
	// This function is to check for zip code of user
	function isZipCode(){
		if($this->isLoggedIn())
		{ 
			$zip_code = $this->getRecords('user','zip_code',array("user_id"=>$this->session->userdata('user_id')),'',true);
			return $zip_code['zip_code'];
		}
		else
		{
			return false;
		}
	}

	function postAccess($post_id, $user_id)
	{
		$rs_post = $this->db->select("p.post_id")->from('post as p')->where(array('p.post_id'=>$post_id,'p.user_id'=>$user_id))->get();	
		
		if($rs_post->num_rows())
		{
			return true;
		}else{
				$rs_user = $this->db->select("ur.user_id")->from('user_role as ur')->where(array('ur.role_id'=>3,'ur.user_id'=>$user_id))->get();	
				if($rs_user->num_rows())
				{
					return true;
				}else{
					return false;			
				}
		}
	}
	
	/* This function is used for restrict user.
	*  User can not login more than 1 browser simenteaously.
	*  This function logout the particular user.
	*  created by : ashvin soni :- 2013-02-01.
	*/
	public function check_browser_login()
	{
	
		if($this->session->userdata('user_id'))
		{
			$xxx_uid =  $this->session->userdata('user_id');
			$xxx_uagent =  $this->session->userdata('users_user_agent');
			$records = $this->commonmodel->getRecords('user_session', 'user_id', array('user_id'=>$xxx_uid,'user_agent'=>$xxx_uagent),'',true);
			if(empty($records))
			{			
				redirect(site_url('user/logout'));
						
			}
		}
	}
	
	/**
	*	Function for check permission to user on particular category or not.
	*	check in admin_ids column using cat_id where condition
	*	Different case for all permissions. 
	*	1 for admin, 2 for r/w, 3 for read, 4 for default.
	*	
	*/
	public function check_permission($cat_id, $user_id)
	{
		if($cat_id != '' && $user_id != '')
		{
			$admin_query = " SELECT ucr.user_id FROM user_category_relation AS ucr WHERE FIND_IN_SET(".$user_id." ,ucr.user_id) AND category_id = ".$cat_id." AND ucr.permission_type = 1 ";
			$admin_result = $this->db->query($admin_query);
			$admin_permission = $admin_result->row_array();
			if(!empty($admin_permission)){
				return 1;
			}
			
			$rw_query = " SELECT ucr.user_id FROM user_category_relation AS ucr WHERE  FIND_IN_SET(".$user_id." ,ucr.user_id) AND category_id = ".$cat_id ." AND ucr.permission_type = 2 ";
			$rw_result = $this->db->query($rw_query);
			$rw_permission = $rw_result->row_array();
			if(!empty($rw_permission)){
				return 2;
			}
		
			$r_query = " SELECT ucr.user_id FROM user_category_relation AS ucr WHERE  FIND_IN_SET(".$user_id.",ucr.user_id) AND category_id = ".$cat_id ." AND ucr.permission_type = 3 ";
			$r_result = $this->db->query($r_query);
			$r_permission = $r_result->row_array();
			if(!empty($r_permission)){
				return 3;
			}
			return false;
		}
	}
	
	
	/**
	*	Function for check user exist in admin and read/write column 
	*	if exist then show createpost button
	*/
	/** function for get category list using user id*/
	public function getUserStatus($user_id)
	{
		$query = " SELECT user_id, ucr.category_id FROM user_category_relation AS ucr WHERE FIND_IN_SET (".$user_id.",ucr.user_id) ";
		
		$status_result = $this->db->query($query);
		$status = $status_result->result_array();
		if(!empty($status)){
			return 'exist';
		}else{
			return 'not exist';
		}			
		
	}
	
	/**
	*	Function for check user exist in admin and read/write column 
	*	if exist then show createpost button
	*/
	/** function for get category list using user id*/
	public function getUserStatusRead($user_id)
	{
		$query = " SELECT user_id, ucr.category_id FROM user_category_relation AS ucr WHERE FIND_IN_SET (".$user_id.",ucr.user_id)";
		
		$status_result = $this->db->query($query);
		$status = $status_result->result_array();
		if(!empty($status)){
			return 'exist';
		}else{
			return 'not exist';
		}			
		
	}
	
	

}