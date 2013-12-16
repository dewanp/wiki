<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorymodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function saveNewTerm($form_value)
	{
		
		$query = $this->db->insert_string('category_term', $form_value);
		$this->db->query($query);
		
		$category_term_id = $this->db->insert_id(); 
		
		$query = $this->db->insert_string('category_term_hierarchy', array('category_term_id' => $category_term_id, 'category_term_parent'=>0));
		$this->db->query($query);		
		
		return $category_term_id;
	}
	
	function categoryTermLoad($category_term_id)
	{
		$termResultSet = $this->db->query('SELECT * FROM category_term t  WHERE t.category_term_id = "'.$category_term_id.'"');
		return $termResultSet->row_array();
	}


	function categoryTermTree($vid = 1)
	{
		$termsResultSet = $this->db->query('SELECT t.*, h.category_term_parent FROM category_term t INNER JOIN category_term_hierarchy h ON t.category_term_id = h.category_term_id WHERE t.category_id = '.$vid.' ORDER BY weight, name');
		return $termsResultSet->result_array();
	}

	
	function loadCategoryTerm($post_id, $vid = 1)
	{
		$category_term_sql = "SELECT * FROM category_term as ct LEFT JOIN category_term_post as ctp ON ct.category_term_id = ctp.category_term_id WHERE ctp.post_id = '$post_id' AND ct.category_id = '$vid'";
		$category_term = $this->db->query($category_term_sql);
		if($category_term->num_rows()>1){
			return $category_term->result_array();	
		}else{
			return $category_term->row_array();	
		}
	}

	function categoryDropdownOptions($vid = 1 , $parent = 0)
	{
		$dropdownOptions = array("" => "-- Select category--");
		
		$termsResultSet = $this->db->query('SELECT t.*, h.category_term_parent FROM category_term t INNER JOIN category_term_hierarchy h ON t.category_term_id = h.category_term_id WHERE t.category_id = '.$vid.' AND h.category_term_parent = '.$parent.' ORDER BY weight, name');
		
		foreach($termsResultSet->result_array() as $categoryData)
		{
			$dropdownOptions[$categoryData['category_term_id']] = $categoryData['name'];
		}
		return $dropdownOptions;
	}

    
}
/* End of file usermodel.php */
/* Location: ./application/models/usermodel.php */