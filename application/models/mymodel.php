<?php

 class Mymodel extends CI_Model
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
	
	function manageUserViewDetails($user_id)
	{
		$sql = " SELECT u.user_id,u.user_name, u.profile_name,u.email,u.picture,f.file_path,u.birth_date,u.is_active
		          from user  as  u 
				  left join file_upload as f on u.picture = f.file_upload_id
				  where  u.user_id = $user_id";
		 $view_result = $this->db->query($sql);
		 return $view_result->row_array();
		
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
	
	
	/* Function for the get user list for admin */
	function  getAdminInfo($category_id,$type = 1)
	{ if($category_id != ''){
		$sql = 'SELECT ucr.user_id,ucr.is_inherited FROM user_category_relation AS ucr WHERE ucr.permission_type = '.$type;
		
			$sql .= ' AND ucr.category_id = '.$category_id;
            $result = $this->db->query($sql);
		return $result->result_array();
		}
        
		
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