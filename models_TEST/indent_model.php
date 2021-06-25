<?php 
/**
* Laabus menus table
*/

class Indent_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function save()
	{ 
			extract($_REQUEST);
			$data = array(
				"emp_id" => 1,
				"inv_id" => $inv_id,
				"required_qty" => $required_qty,	
				"required_date" => $required_date,	
				"status" => 0,					
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->insert("inventory_indent", $data);
		return 1;
	}
	public function edit($id,$REQUEST){
 		$data = array( 
				"status" => 1 			
			 );
		$this->db->where('indent_id', $id);
		$this->db->update('inventory_indent', $data);
	}
 	public function get($id = NULL) {
        $query = $this->db->query("select * from inventory_indent where status=0 ORDER By indent_id ASC ");
        //echo $query;exit;
        return $query->result_array();
    }
 
	public function get_by_id($id = NULL) {
		//echo "select * from groups where indent_id = $id "; die;
        $query = $this->db->query("select * from inventory_indent where indent_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function del($id = NULL) {
	     $query = $this->db->query("DELETE FROM inventory_indent WHERE indent_id = $id ");
         return true;
    }

}