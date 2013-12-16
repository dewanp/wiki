<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contestmodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getShowContest($offset = 0, $limit = 10) 
	{
		$sql ="SELECT con.*,(SELECT GROUP_CONCAT(conw.user_id) FROM contest_winners as conw WHERE conw.contest_id = con.contest_id) AS user_ids
					FROM contest AS con  
					WHERE con.status = 1 AND con.is_deleted = 0 ORDER BY con.contest_id  DESC limit $offset, $limit ";
			
		$result = $this->db->query($sql);
		return $userstring = $result->result_array();
	}


} //end of class
?>