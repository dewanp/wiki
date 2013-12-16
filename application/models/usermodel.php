<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	// This function is used to sign in process
	function signIn($email , $password)
	{
		$password = md5($password);
		$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'  AND acc_status = 1"; 
		$rs = $this->db->query($query);
		if($rs->num_rows()>0)
		{
			return $rs->row_array();
		}
		return false;
	}

	// this function checks for user extists or not.
	// if exists returns true otherwise false
	function checkUser($email)
	{
		$query = "SELECT email FROM user WHERE email = '$email'"; 
		$rs = $this->db->query($query);
		if($rs->num_rows()>0)
		{
			return true;
		}
		return false;
	}

	// This function is used to verify activation link.
	function verifyUserLink($varification_code)
	{
		$data = array('acc_status' => 1);
		$where = "varification_code = '$varification_code'";
		$query = $this->db->update_string('user', $data, $where); 
		$this->db->query($query);

		$query = "SELECT user_type FROM user WHERE varification_code = '$varification_code'"; 
		$rs = $this->db->query($query);
		return $rs->row_array();
	}

	
	// This function is used to update new password.
	function updateNewPassword($email,$new_password)
	{
		$data = array('password' => md5($new_password));
		$where = "email = '$email'";
		$query = $this->db->update_string('user', $data, $where); 
		$this->db->query($query);

		$query = "SELECT first_name FROM user WHERE email = '$email'"; 
		$rs = $this->db->query($query);
		return $rs->row_array();
	}

	function loadMoreUserFeeds($offset =0,$page_type="networkfeeds",$limit = 10)
	{
		$cur_user_id = $this->session->userdata('user_id');
		if($page_type == "networkfeeds")
		{
			$rs_networkfeeds = $this->db->select("u.user_name, u.profile_name, p.post_id, p.title, p.description, p.created_date, p.post_image")
											->from('user_follow as uf')
											->join('user as u','uf.following=u.user_id','left')
											->join('post as p','p.user_id=u.user_id','left')
											->where(array('uf.follower'=>$cur_user_id, 'p.is_active'=>1,'p.is_block'=>0,'u.is_active'=>1))
											->order_by('p.created_date','desc')
											->limit($limit,$offset)
											->get();
			$feeds = $rs_networkfeeds->result_array();
		}
		else
		{
			$rs_user = $this->db->select('zip_code')->from('user')->where('user_id',$cur_user_id)->get();
			$follow_rs_user = $this->db->select('follow_location_id,zip_code')->from('follow_location')->where('user_id',$cur_user_id)->get();
			$re = $follow_rs_user->result_array();
				
			if(!empty($re))
			{
				foreach($re as $zip_codes)
				{
					$all_zip_codes[] = $zip_codes['zip_code'];
				}
					$comma_sep_zip = implode(',',$all_zip_codes);
			}
			$user = $rs_user->row_array();
			
			$query = "SELECT u.user_name, u.profile_name, p.post_id,p.title,  p.description, p.created_date,p.post_image, fl.follow_location_id from  follow_location as fl LEFT JOIN post as p ON p.post_zip_code = fl.zip_code LEFT JOIN user as u ON u.user_id = fl.user_id WHERE p.local_post = 1 and p.is_active = 1 and p.is_block = 0 and fl.zip_code IN ($comma_sep_zip) order by p.created_date desc limit $offset , $limit ";
			$rs_localfeeds =  $this->db->query($query);	

			/*$rs_localfeeds = $this->db->select("u.user_name, u.profile_name, p.post_id, p.title, p.description, p.created_date, p.post_image,p.post_id")
											->from('post as p')
											->join('user as u', 'u.user_id = p.user_id','left')
											->where(array('p.local_post'=>1, 'p.is_active'=>1, 'p.is_block'=>0, 'p.post_zip_code'=>$user['zip_code']))
											->order_by('p.created_date','desc')
											->limit($limit,$offset)
											->get();*/
				
				$feeds = $rs_localfeeds->result_array();
			}
		return $feeds;
	}
	
	/* Function for add or edit using where condition. */
	function addEditAcountSetting($table_name, $data_array, $where = "")
	{
		
		if($table_name && is_array($data_array))
		{
			if($where == "")
			{	
				$query = $this->db->insert_string($table_name, $data_array);
			}else
			{				
				$query = $this->db->update_string($table_name, $data_array, $where);
			}
			$this->db->query($query);
		}	
	}
	
	
	
    
    
}
/* End of file usermodel.php */
/* Location: ./application/models/usermodel.php */