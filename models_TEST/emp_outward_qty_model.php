<?php 
/**
* Laabus menus table
*/

class Emp_outward_qty_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function save($REQUEST)
	{ 
		$data = array(
			"customer_id" => $REQUEST['customer_id'],
			"emp_id" => 1,
			"inv_id" => $REQUEST['inv_id'],
			"outward_qty" => $REQUEST['outward_qty'],
			"remarks" => $REQUEST['outward_remarks'],
			"dateCreated" => date('Y-m-d H:i:s')
		);
		$this->db->insert("emp_outward_qty", $data);
		//$outQty=$REQUEST['inv_id'];
		
		return 1;
	}
	public function edit($id,$REQUEST){
 		$data = array(
				"customer_id" => $REQUEST['customer_id'],
				"emp_id" => 1,
				"inv_id" => $REQUEST['inv_id'],
				"outward_qty" => $REQUEST['outward_qty'],
				"remarks" => $REQUEST['outward_remarks'],
 			);
		$this->db->where('emp_outward_id', $id);
		$this->db->update('emp_outward_qty', $data);
	}
 	public function get($id = NULL) {
        $query = $this->db->query("select * from emp_outward_qty ORDER By emp_outward_id ASC ");
        //echo $query;exit;
        return $query->result_array();
    }
	 public function updateQty($REQUEST) { 
		 
		$selOut=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where emp_id=1 AND inv_id=".$REQUEST['inv_id']));
		//print_r($selOut); die;
		 $updQty=$selOut['outward_qty'] - $REQUEST['outward_qty'];
		if($updQty>0){
				$data = array( 
						"outward_qty" => $updQty,
					 
					);
				$this->db->where('inv_id', $REQUEST['inv_id']);
				$this->db->where('emp_id', 1);
				$this->db->update('dealer_outward_qty', $data);
			}
				//echo $query;exit;
        //return $query->result_array(); 
    }   
	public function get_by_id($id = NULL) {
		//echo "select * from emp_outward_qty where emp_outward_id = $id "; die;
        $query = $this->db->query("select * from emp_outward_qty where emp_outward_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function del($id = NULL) {
	     $query = $this->db->query("DELETE FROM emp_outward_qty WHERE emp_outward_id = $id ");
         return true;
    }

}