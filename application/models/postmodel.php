<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postmodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->max_levels = $this->config->item('max_levels', 'adjacency_list');
        $this->dropdown = $this->config->item('dropdown', 'adjacency_list');
    }

	
	/*
		tag listing function for auto complete 
		status: used
	*/
	
	function getTagsAutocomplete($tag){
		$tags = $this->db->select('*')
						->from('tag')
						->like('name', $tag)
						->limit(10)
						->get();
		
		$tag_array = array();
		foreach($tags->result_array() as $tag_detail){
			$tag_array[] = array('id' => $tag_detail['tag_id'], 'value' =>$tag_detail['name'],'label' =>$tag_detail['name']);
		}
		return $tag_array;
	}

	/* status: used	*/
	function tagDetailByPostId($post_id){
		$tags =	$this->db->select('*')
							->from('post_tag')
							->join('tag', 'post_tag.tag_id = tag.tag_id', 'left')
							->where(array('post_tag.post_id' => $post_id))						
							->get();
		return $tags->result_array();
	}

	/**
	 * This function is used to get posts from db 
	 * Created by Neelesh Choukesy on 2012.02.22
	 * 
	 */
	public function getPosts($offset = 0, $limit = 8, $post)
	{ 		
		$keyword = trim(strip_tags($this->input->post('keyword')));
		$condition = ""; 
		
		if($keyword == "")
		{
			$all_result = '';
			return $all_result;
		}
		
		if($this->input->post('searchtype') == 'advance')
		{
			$user_name = $this->input->post('user_name');
			$from_date = strtotime($this->input->post('from_date'));
			$from_date = $from_date ? "AND p.created_date >= '$from_date'" : "";
			$to_date = $this->input->post('to_date') ? strtotime('+1 day', strtotime($this->input->post('to_date'))) : "";
			$to_date = $to_date ? "AND p.created_date <= '$to_date'" : "";
			
			$condition = " AND u.user_name like '%$user_name%' $from_date $to_date ";
			
			$query = "SELECT p.*, u.user_name, u.profile_name,t.tag_id,t.name FROM post p, user u, tag t where p.`user_id` = u.`user_id` AND p.is_active = 1 AND p.is_block=0 $condition GROUP BY p.post_id ORDER BY p.created_date DESC LIMIT $offset, $limit";
			$rs = $this->db->query($query);
			return $rs->result_array();
		}
		
			
		/* get post_id using title */
		$query_title = "select p.post_id from post p where p.title like '%$keyword%' ";
		$rs_title = $this->db->query($query_title);
		$data_title = $rs_title->result_array();
		//echo $this->db->last_query();
		
		/* get post_id using tag */
		$query_tag = "select p.post_id from post p,tag t,post_tag pt where t.tag_id = pt.tag_id and p.post_id = pt.post_id and t.name like '%$keyword%' ";
		$rs_tag = $this->db->query($query_tag);
		$data_tag = $rs_tag->result_array();
		
		
		/*get post_id using decription */
		$query_description = "select p.post_id from post p where p.description like '%$keyword%' ";
		$rs_description = $this->db->query($query_description);
		$data_description = $rs_description->result_array();
		
		
		/* get post_id from capsule paragraph */
		$query_capsule = "select p.post_id from post p, capsule c, paragraph pa where p.post_id = c.post_id and c.capsule_id = pa.capsule_id  and pa.value like '%$keyword%' ";
		$rs_capsule = $this->db->query($query_capsule);
		$data_capsule = $rs_capsule->result_array();
		
		
		$merged_array = array_merge($data_title,$data_tag,$data_description,$data_capsule);
		$union_array = array();
		foreach($merged_array as $mer_arr){
			$union_array[$mer_arr['post_id']] = $mer_arr['post_id'];
		}
		
		$single_result = array();
		if($keyword != ""){
		$query_all_data = "SELECT p.*, u.user_name, u.profile_name,t.tag_id,t.name FROM post p, user u, tag t where p.post_id in(".implode(",",$union_array).") AND  p.user_id = u.user_id AND p.is_active = 1 AND p.is_block=0 GROUP BY p.post_id ORDER BY p.created_date DESC LIMIT $offset, $limit";
		}else{
		$query_all_data = "SELECT p.*, u.user_name, u.profile_name,t.tag_id,t.name FROM post p, user u, tag t where p.user_id = u.user_id AND p.is_active = 1 AND p.is_block=0 GROUP BY p.post_id ORDER BY p.created_date DESC LIMIT $offset, $limit";
		}
		$rs_all_data = $this->db->query($query_all_data);
		$all_result = $rs_all_data->result_array();
		return $all_result;
	}

	/**
	 * This function is used to get local posts from db 
	 * Created by Neelesh Choukesy on 2012.03.19
	*/
	public function getLocalPosts($zip_code, $offset = 0, $limit = 8)
	{
		if(is_numeric($zip_code)){
			$query = "SELECT p.*, u.user_name, u.profile_name,p.post_zip_code FROM post p, user u where p.`user_id` = u.`user_id` AND p.`local_post` = 1 AND p.`post_zip_code` = $zip_code AND p.is_active = 1 AND p.is_block=0 ORDER BY p.created_date DESC LIMIT $offset, $limit";
		}else{
			$query = "SELECT p.*, u.user_name, u.profile_name,p.post_zip_code FROM post p, user u where p.`user_id` = u.`user_id` AND p.`local_post` = 1 AND p.`post_zip_code` in (select zip_code from usa_zip_codes where city='$zip_code') AND p.is_active = 1 AND p.is_block=0 ORDER BY p.created_date DESC LIMIT $offset, $limit";
		}
		$rs = $this->db->query($query);
		return $rs->result_array();
	}
	
	/**
	 * This function is used to get city name from db 
	 * Created by Ashwin soni on 2012.12.17
	*/
	public function getCityName($zip_code)
	{
		if(is_numeric($zip_code)){
			$query = "SELECT uzc.city as state from usa_zip_codes as uzc where uzc.zip_code='".$zip_code."'";
		}else{
			//$query = "SELECT s.state from state as s where s.abbreviation='".$zip_code."'";
			$query = "SELECT uzc.city as state,uzc.zip_code from usa_zip_codes as uzc where uzc.city=  '$zip_code' ";
		}
		$rs = $this->db->query($query);
		return $rs->row_array();
	}
	
		
	/**
	 * This function is used to get tag relates posts from db 
	 * Created by Ashvin soni on 2012.11.28
	 * 
	 */
	public function getTagRelatedPost($tag_name, $offset = 0, $limit = 8)
	{
		$query = "SELECT p.*, u.user_name, u.profile_name,t.tag_id,t.name,pt.post_id FROM post p, user u,tag t,post_tag pt where t.tag_id = pt.tag_id AND p.post_id = pt.post_id AND p.user_id = u.user_id AND t.name like '%$tag_name%' AND p.is_active = 1 AND p.is_block=0  GROUP BY p.post_id ORDER BY p.created_date DESC LIMIT $offset, $limit";
		$rs = $this->db->query($query);
		return $rs->result_array();
	}
	

	/**
	 * This function is used to get all users who have most posts for all posts 
	 * Created by Neelesh Choukesy on 2012.02.29
	 * 
	 */
	public function getAllMostPostedUsers($offset = 0, $limit = 9)
	{
		//$query = "SELECT count(p.`user_id`), u.user_name, u.profile_name, u.picture FROM post p, user u where p.`user_id` = u.`user_id` GROUP BY p.`user_id` ORDER BY count(p.`user_id`) desc LIMIT $offset, $limit";
		$query = "SELECT count(p.`post_id`) as post_count,p.user_id, u.user_name, u.profile_name, u.picture FROM post p, user u where p.`user_id` = u.`user_id`  AND p.is_block = 0 AND p.is_active = 1 AND u.is_active = 1 GROUP BY p.`user_id` HAVING  post_count >0 ORDER BY post_count desc  LIMIT $offset, $limit ";
		
		$rs = $this->db->query($query);
		return $rs->result_array();

	}

	/**
	 * This function is used to get show posts from db 
	 * Created by Neelesh Choukesy on 2012.02.29
	*/
	public function getShowPosts($type, $offset = 0, $limit = 8, $condition = "")
	{ 
		if($type == 'all')
		{
			return $this->getPosts($offset, $limit, $condition);
		}

		
		$query = "SELECT c.`post_id`, count(c.`post_id`), p.*, u.user_name, u.profile_name FROM capsule c, post p, user u WHERE p.`user_id` = u.`user_id` AND c.`post_id` = p.`post_id` AND c.`capsule_type_id` = (SELECT ct.capsule_type_id FROM capsule_type ct WHERE name = '$type') AND p.is_active = 1 AND p.is_block=0 AND `p`.`sub_category_id` != '17' $condition GROUP BY c.`post_id` HAVING count(c.`post_id`) >0 ORDER BY p.created_date DESC LIMIT $offset, $limit";
		$rs = $this->db->query($query);
		return $rs->result_array();

		//$resultQuery = $this->db->get('post', $limit, $offset);
		//return $resultQuery->result_array();
	}

	/**
	 * This function is used to get show images posts from db 
	 * Created by Neelesh Choukesy on 2012.04.17
	 */
	public function getShowImage($offset = 0, $limit = 12, $id = "")
	{ 
		if($id != "")
		{
			$query = "SELECT i.image_id, i.title, i.description, f.file_upload_id, f.file_path, p.post_id, u.user_id, u.user_name, u.profile_name  FROM image i, file_upload f, capsule c, post p, user u WHERE i.file_upload_id = f.file_upload_id AND i.capsule_id = c.capsule_id AND c.post_id = p.post_id AND p.user_id = u.user_id AND p.is_active = 1 AND p.is_block=0 AND i.image_id = $id";


			$rs = $this->db->query($query);
			return $rs->row_array();
		}
		else
		{
			$query = "SELECT i.image_id, i.title, f.file_upload_id, f.file_path, p.post_id, u.user_id, u.user_name, u.profile_name  FROM image i, file_upload f, capsule c, post p, user u WHERE i.file_upload_id = f.file_upload_id AND i.capsule_id = c.capsule_id AND c.post_id = p.post_id AND p.user_id = u.user_id AND p.is_active = 1 AND p.is_block=0 ORDER BY p.created_date desc LIMIT $offset, $limit";

			$rs = $this->db->query($query);
			return $rs->result_array();
		}

		//$resultQuery = $this->db->get('post', $limit, $offset);
		//return $resultQuery->result_array();
	}

	/**
	 * This function is used to get show images posts from db 
	 * Created by Neelesh Choukesy on 2012.04.17
	 */
	public function getShowVideo($offset = 0, $limit = 12, $id = "")
	{ 
		if($id != "")
		{ 
			$query = "SELECT v.video_id, v.title, v.description, f.file_upload_id, f.file_path, f.type, p.post_id, u.user_id, u.user_name, u.profile_name FROM video v, file_upload f, capsule c, post p, user u WHERE v.file_upload_id = f.file_upload_id AND v.capsule_id = c.capsule_id AND c.post_id = p.post_id AND p.user_id = u.user_id AND p.is_active = 1 AND p.is_block=0 AND v.video_id = $id";

			$rs = $this->db->query($query);
			return $rs->row_array();
		}
		else
		{
			$query = "SELECT v.video_id, v.title, v.file_upload_id, f.file_path, f.type, f.file_name, p.post_id, u.user_id, u.user_name, u.profile_name FROM video v, file_upload f, capsule c, post p, user u WHERE v.file_upload_id = f.file_upload_id AND v.capsule_id = c.capsule_id AND c.post_id = p.post_id AND p.user_id = u.user_id AND p.is_active = 1 AND p.is_block=0 ORDER BY p.created_date desc LIMIT $offset, $limit";

			$rs = $this->db->query($query);
			return $rs->result_array();
		}
	}

	public function getShowPoll($offset = 0, $limit = 12, $id = "")
	{
		if($id != "")
		{
			$rs_poll_info =$this->db->select('c.post_id, p.polls_id, p.title as poll_title, p.description, p.capsule_id')
									->from('polls as p')
									->join('capsule as c','p.capsule_id = c.capsule_id','left')
									->where('p.capsule_id',$id)
									->get();
												
									
			$poll_info = $rs_poll_info->row_array();
			/*$rs_votes = $this->db->select('option.option_id, option.title, count(votes_id) as votecount')
								->from('option')
								->join('votes', 'votes.option_id = option.option_id', 'left')
								->where(array('source_id' =>$poll_info['polls_id'], 'type' =>0))
								->group_by('option.option_id')
								->get();
			$votes = $rs_votes->result_array();
			$polls['info'] = $poll_info;
			$polls['votes']= $votes;*/
			
			return $poll_info;

		}
		else
		{
			$condition = array('c.capsule_type_id'=>6, 'p.is_active'=>1, 'p.is_block'=>0);
			$rs_polls_content = $this->db->select('c.capsule_id,p.title as post_title,p.user_id,p.post_image,u.user_name, u.profile_name,p.post_id,po.*')
									 ->from('capsule as c')
									 ->join('polls as po','c.capsule_id = po.capsule_id','left')
									 ->join('post as p','c.post_id = p.post_id','left')
									 ->join('user as u','p.user_id = u.user_id','left')
									 ->order_by('p.created_date','desc')
									 ->where($condition)
									 ->limit($limit,$offset)
									 ->get();

	   		return  $rs_polls_content->result_array();
		}
	}


	public function getshowQna($offset = 0, $limit = 8, $id = "")
	{
			$condition = array('p.sub_category_id'=>QNA_SUB_CATEGORY_ID ,'p.is_active'=>1,'p.is_block'=>0);
			$rs_qna_content = $this->db->select('p.user_id, p.post_id, p.title, p.description, p.created_date, p.post_image, count(a.answer_id) as answer, u.user_name, u.profile_name')
									    ->from('post as p')
										->join('answer as a ','p.post_id = a.post_id','left')
										->join('user as u','p.user_id = u.user_id','left')
										->where($condition)
										->order_by('p.created_date','desc')
										->group_by('p.post_id')
										->limit($limit,$offset)
										->get();
			
			return $rs_qna_content->result_array();
	}


	/**
	 * This function is used to get users who have most posts for specific type posts
	 * Created by Neelesh Choukesy on 2012.02.29
	 * 
	 */
	public function getMostPostedUsers($type, $offset = 0, $limit = 9)
	{
		if($type == 'all')
		{
			return $this->getAllMostPostedUsers($offset, $limit);
		}
		
		//$query = "SELECT count(p.`user_id`), u.user_name, u.profile_name, u.picture FROM capsule c, post p, user u WHERE p.`user_id` = u.`user_id` AND c.`post_id` = p.`post_id` AND c.`capsule_type_id` = (SELECT ct.capsule_type_id FROM capsule_type ct WHERE name = '$type') GROUP BY p.`user_id` HAVING count(c.`post_id`) >1 ORDER BY count(p.`user_id`) desc LIMIT $offset, $limit";

		$query = "SELECT count(p.`post_id`) as post_count,p.user_id, u.user_name, u.profile_name, u.picture FROM post p, user u where p.`user_id` = u.`user_id`  AND p.is_block = 0 AND p.is_active = 1 AND u.is_active = 1 GROUP BY p.`user_id` HAVING  post_count >0 ORDER BY post_count desc  LIMIT $offset, $limit ";
		
		/*$query = "SELECT dt.*, count(dt.user_name) from (SELECT count(p.`post_id`), p.`user_id`, u.user_name, u.profile_name, u.picture FROM capsule c, post p, user u WHERE p.`user_id` = u.`user_id` AND c.`post_id` = p.`post_id` AND c.`capsule_type_id` = (SELECT ct.capsule_type_id FROM capsule_type ct WHERE name = '$type') GROUP BY p.`post_id` HAVING count(c.`post_id`) >1 ) dt GROUP BY dt.`user_id` ORDER BY count(dt.user_name) DESC LIMIT $offset, $limit";*/
		
		$rs = $this->db->query($query);
		return $rs->result_array();
	}
	

	/**
	 * This function is used to get all the local cities shown in map according to local posts
	 * Created by Neelesh Choukesy on 2012.03.19
	 * 
	 */
	public function getMapCities()
	{
		/*$query = 'select count(p.post_id) as post_count ,p.post_zip_code, uzc.zip_code,uzc.city, uzc.state,s.state as state_name,s.state_id from post as p,usa_zip_codes as uzc,state as s WHERE uzc.state=s.abbreviation and p.post_zip_code=uzc.zip_code and p.is_block=0 and p.is_active=1 and p.local_post=1 group by uzc.state';*/
		
		$postQuery = "SELECT count(p.post_id) as post_count, p.post_zip_code,uzc.city,uzc.state FROM post as p,usa_zip_codes as uzc WHERE uzc.zip_code = p.post_zip_code and p.local_post=1 and p.post_zip_code!='' and p.is_active=1 and p.is_block=0 group by p.post_zip_code having post_count > 0";
		$postQueryRs = $this->db->query($postQuery);
		$zipc = array();
		foreach($postQueryRs->result_array() as $zip)
		{
				$zipc[]=$zip['post_zip_code'];
		}
		$zipcs = implode(",",$zipc);
		
		$query = 'select count(p.post_id) as post_count , uzc.zip_code,uzc.city, uzc.state,s.state_id,s.state as state_name from post as p,usa_zip_codes as uzc,state as s WHERE uzc.state=s.abbreviation and p.post_zip_code=uzc.zip_code  and  p.is_active=1  and p.local_post=1 and  p.is_block=0 and uzc.zip_code in ('.$zipcs.') group by uzc.city';	
		$rs = $this->db->query($query);
		return $rs->result_array();
	}


	/**
	 * This function is used to get all the local cities shown in map according to local posts
	 * Created by Neelesh Choukesy on 2012.03.19
	 */
	public function getPostCountStates()
	{
		$query = "SELECT state, GROUP_CONCAT(zip_code) as zip_codes FROM `usa_zip_codes` group by state";
		$rs = $this->db->query($query);
		$zipcodesByState = $rs->result_array();
		$outArray = array();
		foreach($zipcodesByState as $zipCodeData){
			$expZip = explode(",",$zipCodeData['zip_codes']);
			$query = "SELECT post_id, post_zip_code FROM post WHERE is_block=0 and is_active=1";
			$rs = $this->db->query($query);
			$ds = $rs->result_array();
			
			foreach($ds as $d){
				if(in_array($d['post_zip_code'],$expZip))
				{
					$query = "SELECT count(post_id) as post_count FROM post WHERE post_zip_code='".$d['post_zip_code']."' and is_block=0 and is_active=1";
					$rs = $this->db->query($query);
					$count_res = $rs->row_array();
					print_r($count_res); 
				}
			}
			$outArray[$zipCodeData['state']]= $d['post_count'];
		}
		print_r($outArray);
		return $outArray;
	}

	/**
	 * This function is used to get average rating for a particular capsule
	 * Created by Neelesh Choukesy on 2012.03.20
	 */
	public function getAvgRating($capsule_id)
	{
		$query = "SELECT avg(rate) rate FROM rate WHERE capsule_id = $capsule_id";

		$rs = $this->db->query($query);
		return $rs->row_array();
	}
	
	/**
	 * This function is used to get average rating for a particular post
	 * Created by Ashvin soni on 2012.12.24
	 */
	public function getAvgRatingPost($post_id)
	{
		$query = "SELECT avg(rate) rate FROM rate_post WHERE post_id = $post_id";

		$rs = $this->db->query($query);
		return $rs->row_array();
	}
	
	

	/**
	 * This function is used to get posts by categroy from db 
	 * Created by Neelesh Choukesy on 2012.03.26
	 */
	public function getCategoryPosts($category_id, $offset = 0, $limit = 8)
	{
		$query = "SELECT p.*, u.user_name, u.profile_name FROM post p, user u where p.`category_id` = $category_id AND p.`user_id` = u.`user_id` AND p.is_active = 1 AND p.is_block =0 ORDER BY p.created_date DESC LIMIT $offset, $limit";
		$rs = $this->db->query($query);
		return $rs->result_array();
	}
	
	/*	
	*	This function is used for the insert receord in follow_location table 
	*	parameter : $user_id and $zip_code
	*/
	public function followLocation($zip_code,$user_id)
	{
		if(is_numeric($zip_code))
		{
			$follow_location_data =array('follow_location_id'=>'', 'user_id'=>$user_id, 'zip_code'=>$zip_code);
			$this->db->insert('follow_location', $follow_location_data);
		}else{
			$query = "SELECT  distinct uzc.zip_code,uzc.state FROM usa_zip_codes uzc ,post p WHERE uzc.state = '$zip_code' AND uzc.zip_code = p.post_zip_code ";
			$rs = $this->db->query($query);
			foreach($rs->result_array() as $one_zip_code)
			{
				$follow_location_data =array('follow_location_id'=>'', 'user_id'=>$user_id, 'zip_code'=>$one_zip_code['zip_code'],'state'=>$one_zip_code['state']);
				$this->db->insert('follow_location', $follow_location_data);
			}
		}
	}

    /*	
	*	This function is used for the delete receord in follow_location table
	*	parameter : $user_id and $zip_code
	*/
    public function unFollowLocation($zip_code,$user_id)
    {
        if(is_numeric($zip_code))
		{
            $delete_location = array('user_id'=>$user_id,'zip_code'=>$zip_code);
            $this->db->delete('follow_location', $delete_location);

        }else{
            $query = "SELECT  distinct(uzc.zip_code) FROM usa_zip_codes uzc ,post p WHERE uzc.state = '$zip_code' AND uzc.zip_code = p.post_zip_code ";
            $rs = $this->db->query($query);
            foreach($rs->result_array() as $one_zip_code)
			{
                $delete_location = array('user_id'=>$user_id,'zip_code'=>$one_zip_code['zip_code']);
                $this->db->delete('follow_location', $delete_location);
            }
        }
    }
	
	/** function for get category list using user id*/
	public function getCategoryIds($user_id = "")
	{
		$query = " SELECT cat.category_id, cat.name FROM 
				   user_category_relation AS ucr LEFT JOIN category AS cat ON cat.category_id = ucr.category_id
				   WHERE FIND_IN_SET(".$user_id." ,ucr.admin_ids)
				   OR FIND_IN_SET(".$user_id." ,ucr.read_write_user_ids)
				   OR FIND_IN_SET(".$user_id." ,'all')
				   AND cat.is_active = 1 ";
		$rs = $this->db->query($query);
		return $rs->result_array();
	}
	
	/** function for get category list using user id*/
	public function getCategoriesPosts($user_id = "", $type="", $offset = 0, $limit = 10)
	{
		$posts = array();
 		$where = '';
		if(is_numeric($type))
		{
			$where = ' WHERE p.category_id = '.$type;
		}
		
		if(!is_numeric($type))
		{
			$get_query = " SELECT GROUP_CONCAT(category_id) AS categories FROM user_category_relation WHERE user_id = ".$user_id;
			$cat_result = $this->db->query($get_query);
			$cats = $cat_result->row_array();
			if(!empty($cats))
			{
				$where = ' WHERE p.category_id IN ('.$cats['categories'].') ';
			}
		}
		
		/*$query = "SELECT   p.*,u.user_name, u.profile_name,
				  (SELECT c.name FROM category AS c WHERE c.category_id = p.category_id)AS category_name
				  FROM post p LEFT JOIN user u ON u.user_id = p.user_id 
				  WHERE
				  p.category_id IN(SELECT ucr.category_id FROM user_category_relation AS ucr WHERE FIND_IN_SET(".$user_id.",ucr.user_id))
				  ".$where." AND p.is_active = 1 
				  ORDER BY p.created_date DESC LIMIT $offset, $limit";*/
		$query = "SELECT   p.*,u.user_name, u.profile_name,
				  (SELECT c.name FROM category AS c WHERE c.category_id = p.category_id)AS category_name
				  FROM post p LEFT JOIN user u ON u.user_id = p.user_id ".$where."
				  AND p.is_active = 1 ORDER BY p.created_date DESC LIMIT $offset, $limit";
		
		$post_result = $this->db->query($query);
		$posts = $post_result->result_array();	
		return $posts;
	}
	
	/**
	*	Function for get all categories related to logged in user id
	*/
	public function getAdminCategories($user_id)
	{
		if($user_id != '')
		{
		  $sql =" SELECT c.category_id AS id, c.name, c.is_active,c.parent AS parent_id
			   FROM category AS c LEFT JOIN user_category_relation AS ucr ON c.category_id = ucr.category_id WHERE ucr.user_id=".$user_id." AND c.is_active = 1 ";
			
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
			
			if ($leaf['parent_id'] != 0  && !array_key_exists($leaf['parent_id'], $tree) )
			{
				$tree_array[] = &$tree[$leaf['id']];
			}
		}
		return $tree_array;	
	  }
	}
	
	function displayCategoryChildListSecond($group_id)
	{
		$sql =" SELECT c.category_id AS id, c.name, c.is_active,c.parent AS parent_id
			   from category as c LEFT JOIN user_category_relation AS ucr ON c.category_id = ucr.category_id WHERE FIND_IN_SET(".$this->user_id.", ucr.user_id) AND c.is_active = 1 ";
			   
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
			
			if ($leaf['parent_id'] != 0 && !array_key_exists($leaf['parent_id'], $tree))
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
	
	/* Function for the get user list for contest */
	function  getAdminInfo($category_id)
	{
		$sql = 'SELECT ucr.user_id FROM user_category_relation AS ucr WHERE ucr.category_id = '.$category_id." AND permission_type = 1";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
	/* Function for the get admin categories*/
	function  getOldAdminCategories($parent_id)
	{
		$sql = 'SELECT GROUP_CONCAT(ucr.user_id) AS user_ids FROM user_category_relation AS ucr WHERE ucr.category_id = '.$parent_id.' AND permission_type = 1';
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	
	/*FUnction for get category info for edit*/
	public function editcategoryInfo($category_id)
	{
		if($category_id != '')
		{
			$sql = ' SELECT c.category_id,c.name, c.parent,
					(SELECT GROUP_CONCAT(user_id) FROM user_category_relation WHERE category_id = '.$category_id.' AND permission_type = 1)AS admin_id,
					(SELECT GROUP_CONCAT(user_id) FROM user_category_relation WHERE category_id = '.$category_id.' AND permission_type = 2)AS rw_id ,
					(SELECT GROUP_CONCAT(user_id) FROM user_category_relation WHERE category_id = '.$category_id.' AND permission_type = 3)AS r_id 
			FROM category AS c WHERE c.category_id = '.$category_id;
		$result = $this->db->query($sql);
		return $result->row_array();
		}
	}

    public function get_user_all_category($user_id){
     
		if($user_id != '')
		{
		  $sql =" SELECT c.category_id AS id, c.name, c.is_active,c.parent AS parent_id, ucr.permission_type
			   FROM category AS c LEFT JOIN user_category_relation AS ucr ON c.category_id = ucr.category_id WHERE ucr.user_id='".$user_id."' AND c.is_active = 1";
			
		$category_list_result = $this->db->query($sql);
		 return $category_list_result->result_array();
		 
		  	
	  }
	 
    }
	
    
}
/* End of file postmodel.php */
/* Location: ./application/models/usermodel.php */