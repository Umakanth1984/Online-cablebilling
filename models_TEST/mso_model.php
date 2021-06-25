<?php 

class mso_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	//Insertion
	public function save_create_mso($REQUEST)

	{
			$data = array(
				"mso_name" =>$REQUEST['inputmsoname'],	 				
				"mso_remarks" => $REQUEST['inputmsoRemarks'],					
			);
		$this->db->insert("create_mso", $data);
		return 1;

	}
	
	//Edit 
	public function edit_mso($id,$REQUEST){
 		$data = array(
				"mso_name" =>$REQUEST['inputmsoname'],	 				
				"mso_remarks" => $REQUEST['inputmsoRemarks'],					
			);
		$this->db->where('mso_id', $id);
		$this->db->update('create_mso', $data);
	}
	
	//List
	public function get_create_mso($id = NULL) {
        $query = $this->db->query("select * from create_mso");
        //echo $query;exit;
        return $query->result_array();
    }
	
	//View
	public function get_mso_by_id($id = NULL) {
        $query = $this->db->query("select * from create_mso where mso_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }

}