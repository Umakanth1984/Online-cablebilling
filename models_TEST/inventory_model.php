<?php 
/**
* Laabus menus table
*/

class Inventory_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function inventory_id_exists($item_number) {
	 
			$this->db->select('inv_id');
			 //$this->db->where('item_number', $item_number);
			$this->db->where("(item_number='$item_number')", NULL, FALSE);
			$query = $this->db->get('inventory_items');
			if ($query->num_rows() > 0) {
				 return $query->result_array();
			} else {
				return 0;
			}
	}
	public function save_inventory()
	{ 
		 extract($_REQUEST); 
			$data = array(
				"name" => $name,
				"item_number" => $item_number,
				"item_price" => $item_price,	
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->insert("inventory_items", $data);
		return 1;
	}
	public function edit_inventory($id){
		extract($_REQUEST);
 		$data = array(
				"name" => $name,
				"item_number" => $item_number,
				"item_price" => $item_price,	
			
			);
		$this->db->where('inv_id', $id);
		$this->db->update('inventory_items', $data);
	}
 	public function get_inventory($id = NULL) {
		extract($_REQUEST);
		if((isset($name) && $name!='') || (isset($item_number) && $item_number!=''))
		{
			$query = $this->db->query("select * from inventory_items where name='$name' OR item_number='$item_number'");
		}
		else
		{
			$query = $this->db->query("select * from inventory_items ORDER By inv_id ASC ");
		}
        //echo $query;exit;
        return $query->result_array();
    }
	 
	public function get_inventory_by_id($id = NULL) {
		//echo "select * from inventory_items where inv_id = $id "; die;
        $query = $this->db->query("select * from inventory_items where inv_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function del_inventory($id = NULL) {
	     $query = $this->db->query("DELETE FROM inventory_items WHERE inv_id = $id ");
         return true;
    }

}