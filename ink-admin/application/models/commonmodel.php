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
	
	
	function commonAddEditParameter($table_name, $data_array, $where = "")
	{
		if($table_name && is_array($data_array))
		{
			if($where == "")
			{	
				$query = $this->db->insert_string($table_name, $data_array);
			}
			else
			{
				//$wheree = "contest_id = '$id'";
				$wheree = $where;
				$query = $this->db->update_string($table_name, $data_array, $wheree);
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
	
	// function for close contest by condition.
	function closecontest($table, $where, $status)
	{ 
		$query = "UPDATE $table SET status = $status WHERE $where ";
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

	

}

	