<?php

 class Adminmodel extends CI_Model
{
	
	function __construct()
	{
		parent :: __construct();
		// invoking  constructor of base class
		$this->max_levels = $this->config->item('max_levels', 'adjacency_list');
        $this->dropdown = $this->config->item('dropdown', 'adjacency_list');
	}

	function checkLogin($username, $password)
	{
        $pwd= md5($password);
		
		$condition = array('ur.role_id'=>3,'u.user_name'=>$username,'u.password'=>$pwd);
       	$rs_login = $this->db->select('u.user_id, u.user_name,f.file_path,u.profile_name,f.file_upload_id ')
							 ->from('user as u')
							 ->join('file_upload as f','u.picture = f.file_upload_id','left')
							 ->join('user_role as ur','u.user_id = ur.user_id','left')
							 ->where($condition)
							 ->get();
		$res = $rs_login->row_array();
			  
		if($res)
		{			
			return  $res;
		}
		else
		{
			return null ;
		}
	}
	
	function isLoggedIn()
	{
		if($this->session->userdata('user_name')!='' && $this->session->userdata('user_role') == 'admin')
		{ 
		 return true;
		}
		else
		{
			return false;
		}
	}
	

	function registrationSummary()
	{
		$today_mid_night_time = strtotime(date('d M Y 0:0:0'));
		$yesterday = $today_mid_night_time - (24*60*60);
		$week  = $today_mid_night_time -(7*24*60*60);
		$month3 = $today_mid_night_time -(3*30*24*60*60);
		


		$rs_today = $this->db->select('count(user_id) as countdata')
							 ->from('user')
							 ->where('registered_date >',$today_mid_night_time)
							 ->get();
			$today = $rs_today->row_array();
		$summary['today'] = $today['countdata'];

		$sql1 = "SELECT count(user_id) as countdata from user where registered_date <'$today_mid_night_time' AND registered_date > $yesterday ";
		$sql2 = "SELECT count(user_id) as countdata from user where registered_date <'$today_mid_night_time' AND registered_date > $week ";
		$sql3 = "SELECT count(user_id) as countdata from user where registered_date <'$today_mid_night_time' AND registered_date >'$month3'  ";
		$sql4 = "SELECT count(user_id)  as countdata from user  ";
		
		$query1 = $this->db->query($sql1);
		$row = $query1->row_array();
       	$summary['yesterday'] = $row['countdata'] ;

		$query1 = $this->db->query($sql2);
		$row = $query1->row_array();
  	    $summary['week'] = $row['countdata'] ;

		
		$query1 = $this->db->query($sql3);
		$row = $query1->row_array();
        $summary['month'] = $row['countdata'] ;


		$query1 = $this->db->query($sql4);
		$row = $query1->row_array();
        $summary['all'] = $row['countdata'] ;


		return $summary ;

	}

	function highestGrosser()
	{
		$rs_highest_grosser = $this->db->select('u.user_id, u.user_name, count(p.post_id) as "Number" ')
									   ->from('post as p')
									   ->join('user as u','p.user_id = u.user_id','left')
									   ->group_by('p.user_id')
									   ->order_by('Number','Desc')
									   ->limit(5)
									   ->get();
		
		$highest_grosser = $rs_highest_grosser->result_array();
		return $highest_grosser;
	}

	function  manageUser($limit,$offset,$search_user)
	{
		$rs_manage_user_result = $this->db->select("u.user_id, u.profile_name, u.user_name, u.email, u.registered_date, u.picture , f.file_upload_id, f.file_path, count(p.post_id) as 'content_posted'")
										 ->from('user as u')
										->join('post as p','u.user_id = p.user_id','left')
										->join('file_upload as f','f.file_upload_id=u.picture','left')								 
										->where("u.is_active = 1 and (u.profile_name like '%$search_user%' or u.user_name like '%$search_user%')")
										 ->group_by('u.user_id')
										 ->order_by('u.registered_date','desc')
										 ->limit($limit,$offset)
										 ->get();
				
		return $rs_manage_user_result->result_array();

	}
	function suspendedUserList($limit,$offset,$search='')
	{
		
		if($search=='--'){
		$rs_suspended_user_result = $this->db->select("u.user_id, u.profile_name, u.user_name, u.email, u.registered_date, u.picture, f.file_path, count(p.post_id) as 'content_posted'")
										 ->from('user as u')
										 ->join('post as p','u.user_id = p.user_id','left')
										 ->join('file_upload as f','u.picture = f.file_upload_id','left')
										 ->where("u.is_active != 1")
										 ->group_by('u.user_id')
										 ->order_by('u.registered_date','desc')
										 ->limit($limit,$offset)
										 ->get();
		}else{
		$rs_suspended_user_result = $this->db->select("u.user_id, u.profile_name, u.user_name, u.email, u.registered_date, u.picture, f.file_path, count(p.post_id) as 'content_posted'")
										 ->from('user as u')
										 ->join('post as p','u.user_id = p.user_id','left')
										 ->join('file_upload as f','u.picture = f.file_upload_id','left')
										 ->where("u.is_active <> 1 and (u.profile_name like '%$search%' or u.user_name like '%$search%')")
										 ->group_by('u.user_id')
										 ->order_by('u.registered_date','desc')
										 ->limit($limit,$offset)
										 ->get();

		}		
		return $rs_suspended_user_result->result_array();
	}
	
	function manageUserViewDetails($user_id)
	{
		$sql = " SELECT u.user_id,u.user_name, u.profile_name,u.email,u.picture,f.file_path,u.birth_date,u.is_active
		          from user  as  u 
				  left join file_upload as f on u.picture = f.file_upload_id
				  where  u.user_id = $user_id";
		 $view_result = $this->db->query($sql);
		 return $view_result->row_array();
		
	}
	
	/*
	 * This  function used for updating data of user
	 * Function call from  "Home/updateUserData"  from  Home controller
	 */	
	function updateUserData()
	{
	  	$profile_name = $this->input->post('name',true);
	   	$email = $this->input->post('email',true);
	 	$user_name = $this->input->post('user_name',true);
		$user_id = $this->session->userdata('user_id');
	
		$data = array(
               'profile_name' => $profile_name ,
               'email' => $email,
               'user_name' => $user_name
           );

		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}

	
	/*
	* Category section start here
	*/

	function displayCategoryList($limit,$offset)
	{
		$sql ="SELECT c.category_id, c.name, c.is_active, c.picture, f.file_path,cc.name as parent 
		         from category as c
				 left join file_upload as f on c.picture = f.file_upload_id    
				 left join category as cc on c.parent = cc.category_id
				 order by c.category_id desc limit $offset , $limit ";
		$category_list_result = $this->db->query($sql);
		return $category_list_result->result_array();
		
	}
	
	function displayCategoryChildList($limit='',$offset='')
	{
		$sql =" SELECT c.category_id AS id, c.name, c.is_active,c.parent AS parent_id
			   from category as c
			   order by c.category_id desc"; 
			   if($offset != ''){
			 	$sql .=" limit $offset , $limit ";
			 }
		$category_list_result = $this->db->query($sql);
		$query = $category_list_result->result_array();
		
		$tree = array();

		foreach ($query as $row)
		{
			$tree[$row['id']] = $row;
		}

        unset($query);
        $tree_array = array();

		foreach ($tree as $leaf)
		{
			if (array_key_exists($leaf['parent_id'], $tree))
			{
				$tree[$leaf['parent_id']]['children'][$leaf['id']] = &$tree[$leaf['id']];
			}

			if ( ! isset($tree[$leaf['id']]['children']))
			{
				$tree[$leaf['id']]['children'] = array();
			}

			if ($leaf['parent_id'] == 0)
			{
				$tree_array[$leaf['id']] = &$tree[$leaf['id']];
			}
		}
		return $tree_array;
	}
	
	function displayCategoryChildListSecond($group_id)
	{
		$sql =" SELECT c.category_id AS id, c.name, c.is_active,c.parent AS parent_id
			   from category as c ";
		$category_list_result = $this->db->query($sql);
		$query = $category_list_result->result_array();
		
		$tree = array();

		foreach ($query as $row)
		{
			$tree[$row['id']] = $row;
		}

        unset($query);
        $tree_array = array();

		foreach ($tree as $leaf)
		{
			if (array_key_exists($leaf['parent_id'], $tree))
			{
				$tree[$leaf['parent_id']]['children'][] = &$tree[$leaf['id']];
			}

			if ( ! isset($tree[$leaf['id']]['children']))
			{
				$tree[$leaf['id']]['children'] = array();
			}

			if ($leaf['parent_id'] == 0)
			{
				$tree_array[] = &$tree[$leaf['id']];
			}
		}
		return $tree_array;
	}
	
	
	
	function displayCategoryDropdown($group_id = 1, $exclude = 0, $level = 0, &$tree = NULL)
	{
		$output = array();
        if ($level == 0)
        {
            $tree = $this->displayCategoryChildListSecond($group_id);
            $output[0] = $this->dropdown['parent'];
        }

        if (is_array($tree))
        {
            foreach ($tree as $leaf)
            {
                if ($exclude != $leaf['id'])
                {
                    $output[$leaf['id']] = str_repeat($this->dropdown['space'], $level) . ' ' . $leaf['name'];

                    if ((($this->max_levels != 0) && ($this->max_levels > $level + 1)) || ($this->max_levels == 0) || ($exclude == 0))
                    {
                        if (isset($leaf['children']) && ! empty($leaf['children']))
                        {                                                
                            $output += $this->displayCategoryDropdown($group_id, $exclude, $level + 1, $leaf['children']);        
                        }
                    }
                }
            }
        }
        return $output;
    }
	
	function displayEditCategory($category_id)
	{
		$sql ="SELECT c.category_id, c.name, c.is_active,c.parent, c.picture, f.file_path 
		         from category as c
				 left join file_upload as f on c.picture = f.file_upload_id    
				 where c.category_id = $category_id ";
		$category_list_result = $this->db->query($sql);
		return $category_list_result->row_array();
		
	}
	
	function displayPostTypeList($limit='', $offset=0)
	{
		$sql = "SELECT  sc.sub_category_id, sc.name, group_concat(ct.name SEPARATOR ' , ')as capsule_type_name,sc.is_active
				  from sub_category as sc
				  left join sub_category_capsule as scc on sc.sub_category_id = scc.sub_category_id
				  left join  capsule_type as ct on  scc.capsule_type_id = ct.capsule_type_id
				  where scc.mandatory = 1 
				  group by sc.sub_category_id
				  order by sc.weight asc";

		$post_type_list = $this->db->query($sql);
		return $post_type_list->result_array();

	}
	
	function addNewPostTypeList()
	{
			$check_array = array();
			$name = $this->input->post('sub_category_name',true);
			$name = ucwords(strtolower($name));
			$check_array = $this->input->post('check');
			$is_active = $this->input->post('is_active');
			
			$add_sub_category = array('name'=>$name,
									  'is_active'=>$is_active,
									  
									);
			

			$this->db->insert('sub_category',$add_sub_category);

			$new_insert_id = $this->db->insert_id();

				$this->db->set('sub_category_id', $new_insert_id);
				$this->db->set('capsule_type_id', 5);
				$this->db->insert('sub_category_capsule');

			if(!empty($check_array)){
					foreach($check_array as $key => $capsule_id)
					{
						$this->db->set('sub_category_id', $new_insert_id);
						$this->db->set('capsule_type_id', $key);
						$this->db->insert('sub_category_capsule');
					}
				}
	}


	function displayEditSubCategory($sub_category_id)
	{
		$sql ="SELECT sc.sub_category_id, sc.name, sc.is_active, sc.picture, f.file_path 
		         from sub_category as sc
				 left join file_upload as f on sc.picture = f.file_upload_id    
				 where sc.sub_category_id = $sub_category_id ";
		$category_list_result = $this->db->query($sql);
		return $category_list_result->row_array();
		
	}

	function  capsuleTypeList()
	{
		$this->db->select('name,capsule_type_id');
				$this->db->from('capsule_type');
				$this->db->where('is_active','1');
				$result = $this->db->get();
			return $result->result_array();
	}

	function editSubCategory($sub_category_id)
	{
		$selected_capsule_array = array();
		$sub_category_name = $this->input->post('sub_category_name',true);
	   	$selected_capsule_array = $this->input->post('check');
		$is_active = $this->input->post('is_active');
	   	$picture = $this->input->post('file_upload_id');
		

		$this->db->set('name',$sub_category_name);
		$this->db->set('is_active',$is_active);
		$this->db->set('picture', $picture);
		$this->db->where('sub_category_id',$sub_category_id);
		$this->db->update('sub_category');

		// compulsary capsule ="comment" id =5  edit/update body start

		$this->db->set('sub_category_id',$sub_category_id);
		$this->db->set('capsule_type_id',5);
		$this->db->insert('sub_category_capsule');

		// compulsary capsule ="comment" id =5  edit/update body End
		
		if(!empty($selected_capsule_array)){
			foreach($selected_capsule_array as $capsule_id => $empty)
			{			
				$this->db->set('sub_category_id',$sub_category_id);
				$this->db->set('capsule_type_id',$capsule_id);
				$this->db->insert('sub_category_capsule');
			}
		}
	}

	function viewPostMultimedia($post_id)
	{
		$all_result = array();
		$post = "SELECT p.post_id, p.title,p.description,u.user_name,p.created_date, f.file_upload_id, f.file_path , f.width, f.height
					FROM post as p
					LEFT JOIN file_upload as f on p.post_image = f.file_upload_id
					LEFT JOIN user as u on p.user_id = u.user_id
					WHERE post_id = $post_id";

		$post_result = $this->db->query($post);
		$all_result['post'] = $post_result->row_array();

		$images = "SELECT i.file_upload_id,i.title,i.description,f.file_path,c.capsule_id, c.post_id  
				   FROM capsule as c 
				   RIGHT JOIN image as i ON c.capsule_id = i.capsule_id
				   LEFT JOIN file_upload as f ON i.file_upload_id = f.file_upload_id
				   WHERE post_id = $post_id AND capsule_type_id = 3";
		$image_result = $this->db->query($images);
		$all_result['image'] = $image_result->result_array();

		$video = "SELECT v.file_upload_id,v.title,v.description , f.file_path,c.capsule_id, c.post_id
				  FROM capsule as c
				  RIGHT JOIN video as v ON c.capsule_id = v.capsule_id
				  LEFT JOIN file_upload as f ON v.file_upload_id = f.file_upload_id
				  WHERE post_id = $post_id AND capsule_type_id =4";
		 $video_result = $this->db->query($video);
		 $all_result['video'] = $video_result->result_array();
		 return $all_result ;
		
	}


	function manageContent($start, $limit,$is_block="1")
	{
		if(array_key_exists('search',$_GET) && $_GET['search']!=''){
			$search_word = str_replace('"','',$_GET['search']);
			$search_word = str_replace("'","",$search_word);
		 	$sql = "SELECT p.post_id , p.title,p.user_id, p.created_date,p.changed_date,u.user_name, count(ph.ip_address) as hit , (select count(a.comment_id) from post as po 
			left join capsule as b on po.post_id = b.post_id 
			left join comment as a on a.capsule_id = b.capsule_id 
			where b.capsule_type_id = 5 AND po.post_id = p.post_id
			group by b.post_id ) as comment
		FROM post as p
		left join post_hit as ph  on ph.post_id = p.post_id
		left join user as u  on u.user_id = p.user_id
		where p.is_block = $is_block AND p.title like '%".$search_word."%'
		group by p.post_id
		order by p.created_date desc	";
		}
		else
		{
			$sql ="SELECT p.post_id , p.title,p.user_id, p.created_date,p.changed_date,u.user_name,  count(ph.ip_address) as hit ,( select  count(a.comment_id) from post as po 
			left join capsule as b on po.post_id = b.post_id 
			left join comment as a on a.capsule_id = b.capsule_id 
			where b.capsule_type_id = 5 AND po.post_id = p.post_id
			group by b.post_id	) as comment
		FROM post as p
		left join post_hit as ph  on ph.post_id = p.post_id
		left join user as u  on u.user_id = p.user_id
		where p.is_block = $is_block
		group by p.post_id
		order by p.created_date desc
		limit $start, $limit";
		
		}
		$result = $this->db->query($sql);
		return $result->result_array(); 
	}


	function capsuleDetail($post_id, $capsule_type='')
	{
		
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
		return $capsules->result_array();			
	}

	function reportAbuseList($limit,$offset)
	{
		$result = $this->db->select("report_abuse.post_id,post.title,count(report_abuse.post_id) report_count")
				 ->from('report_abuse')
				 ->join('post', 'report_abuse.post_id = post.post_id', 'left')
				 ->group_by('report_abuse.post_id')
				 ->limit($limit,$offset)
				 ->get();

		return $result->result_array();
	}

	
	/* -------------- Fetch comments by post id-----------*/
	
	function viewComments($start, $limit,$post_id='',$countRecords='')
	{
		$this->db->where('capsule.post_id', $post_id); 
		$this->db->select('comment.capsule_id, comment.comment_id, comment.description,comment.created_date,user.user_name');
		$this->db->from('comment');
		$this->db->join('capsule', 'capsule.capsule_id = comment.capsule_id','left');
		$this->db->join('user', 'user.user_id = comment.user_id','left');
		$this->db->order_by("comment.created_date", "desc"); 
		if($countRecords==false){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		return $query->result_array(); 
	}
	
	/*-------- function for get contact detail list 
	* created date :- 2013-01-18 by AShvin soni	
	------------*/
	function contactDetailList($start, $limit)
	{
		if(array_key_exists('search',$_GET) && $_GET['search']!=''){
			$search_word = str_replace('"','',$_GET['search']);
			$search_word = str_replace("'","",$search_word);
		 	$sql = "SELECT * FROM contact_data as cd WHERE cd.name like '%".$search_word."%' or cd.email like '%".$search_word."%' ";
		}
		else
		{
			$sql ="SELECT * FROM contact_data as cd order by cd.contact_data_id  desc limit $limit, $start";
		}
		
		$result = $this->db->query($sql);
		return $result->result_array();		
	}
				
	/* -------------- Delete comments -----------*/
	function deleteComments($comment_id)
	{
		$this->db->where('comment_id', $comment_id);
		$this->db->delete('comment'); 
					
	}
	
	
	/*-------- function for get subscribed user list
	* created date :- 2013-01-18 by AShvin soni	
	------------*/
	function subscribedUserList($start, $limit)
	{
		if(array_key_exists('search',$_GET) && $_GET['search']!=''){
			$search_word = str_replace('"','',$_GET['search']);
			$search_word = str_replace("'","",$search_word);
		 	$sql = "SELECT * FROM subscribe as su WHERE su.isactive = 1 AND su.emailid like '%".$search_word."%' ";
		}
		else
		{
			$sql ="SELECT * FROM subscribe as su WHERE su.isactive = 1 order by su.subscribe_id  desc limit $limit, $start";
		}
		
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
	
	/*-------- 
	*  function for get contest list
	* created date :- 2013-04-09 by AShvin soni	
	------------*/
	function contestList($start, $limit)
	{
		if(array_key_exists('search',$_GET) && $_GET['search']!=''){
			$search_word = str_replace('"','',$_GET['search']);
			$search_word = str_replace("'","",$search_word);
			$sql = "SELECT * FROM contest as con WHERE con.title like '%".$search_word."%' ";
			
		}
		else
		{
			$sql ="SELECT * FROM contest as con order by con.contest_id  desc limit $limit, $start";
		}
		
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
		
	/* Function is get contest detail using id */
	function manageContestEditDetails($contest_id)
	{		  
		if($contest_id != "")
		{
			 $sql = "SELECT c.* FROM contest as c WHERE c.contest_id = $contest_id";
			 $contest_result = $this->db->query($sql);
			 $contest_array = $contest_result->row_array();
			
			 $sql1 = "SELECT GROUP_CONCAT(ct.tag_id)as tag_ids FROM contest_tag as ct WHERE ct.contest_id = $contest_id";
			 $tag_result = $this->db->query($sql1);
			 $tag_array = $tag_result->row_array(); 
			 
			 
			 $sql2 = "SELECT GROUP_CONCAT(cp.parameter_id SEPARATOR '####' ) AS paramter_id FROM contest_parameters as cp WHERE cp.contest_id = $contest_id";
			 $parameter_result_id = $this->db->query($sql2);
			 $parameter_array_id = $parameter_result_id->row_array();
			 $explode_arr = explode("####", $parameter_array_id['paramter_id']);
			 
			 
			 $sql3 = " SELECT GROUP_CONCAT(cp.parameter SEPARATOR '####') AS parameters FROM contest_parameters as cp WHERE cp.contest_id = $contest_id ";
			 $parameter_result_val = $this->db->query($sql3);
			 $parameter_array_vals = $parameter_result_val->row_array();
			 $explode_arr_val = explode("####", $parameter_array_vals['parameters']);
			 
	
			 /* Combine array and assign on a parameter key */
			 $combine_array = array_combine($explode_arr,$explode_arr_val);
			 $paramter_array['parameters'] = $combine_array;
			 
			 $sql4 = "SELECT GROUP_CONCAT(cw.user_id) AS user_ids,GROUP_CONCAT(cw.post_id) AS post_ids  FROM contest_winners as cw WHERE cw.contest_id = $contest_id";
			 $winner_result_val = $this->db->query($sql4);
			 $winner_result_vals = $winner_result_val->row_array();
			 $winner_user_val = explode(",", $winner_result_vals['user_ids']);
			 $winner_post_val = explode(",", $winner_result_vals['post_ids']);
			 
			 $winner_arr = array();
			 foreach($winner_user_val as $key=>$user){
					
					$sub_arr[$user][] = $winner_post_val[$key];
			 }
			
			 foreach($sub_arr as $key => $subArray){
				foreach($subArray as $val){
					$newArray[][$key] = $val;
				}
			}
		
			/* Combine array and assign on a parameter key */
			$winner_arr['winners'] = $newArray;
			 
			 $merged_array = array_merge($contest_array,$tag_array,$paramter_array, $winner_arr);
			 //echo'<pre>';print_r($merged_array);exit;
			 return $merged_array;
		}
}
	
	/* Function for the get user list for contest */
	function  manageUserContest()
	{
		$rs_manage_user_result = $this->db->select("u.user_id, u.profile_name, u.user_name, u.email, u.registered_date, u.picture , f.file_upload_id, f.file_path, count(p.post_id) as 'content_posted'")
										->from('user as u')
										->join('post as p','u.user_id = p.user_id','left')
										->join('file_upload as f','f.file_upload_id=u.picture','left')								 
										->where("u.is_active = 1")
										->group_by('u.user_id')
										->order_by('u.registered_date','desc')
										->get();
		return $rs_manage_user_result->result_array();

	}
	
	/* Function for the get user list for admin */
	function  getAdminInfo($category_id,$type = 1)
	{
		$sql = 'SELECT ucr.user_id FROM user_category_relation AS ucr WHERE ucr.category_id = '.$category_id.' AND ucr.permission_type = '.$type;
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
	/* Function for the get user list for read/write */
	function  getAdminRwInfo($category_id)
	{
		$sql = 'SELECT ucr.user_id FROM user_category_relation AS ucr WHERE ucr.category_id = '.$category_id.' AND ucr.permission_type = 2';
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
	/* Function for the get user list for read */
	function  getAdminRInfo($category_id)
	{
		$sql = 'SELECT ucr.user_id FROM user_category_relation AS ucr WHERE ucr.category_id = '.$category_id.' AND ucr.permission_type = 3';
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
	/* Function for the get admin categories*/
	function  getAdminCategories($parent_id)
	{
		$sql = 'SELECT GROUP_CONCAT(ucr.user_id) AS user_ids FROM user_category_relation AS ucr WHERE ucr.category_id = '.$parent_id.' AND permission_type = 1';
		$result = $this->db->query($sql);
		return $result->row_array();
	}

}
/* End of file adminmodel.php */
/* Location: ./application/models/adminmodel.php */