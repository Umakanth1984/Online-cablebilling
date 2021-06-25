<?php 
/**
* Laabus menus table
*/

class Expenses_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function expenses_id_exists($item_number) {
		$adminId= $this->session->userdata('admin_id');
			$this->db->select('exp_id');
			$this->db->where("(name='$item_number' AND admin_id='$adminId')", NULL, FALSE);
			$query = $this->db->get('expenses_items');
			if ($query->num_rows() > 0) {
				 return $query->result_array();
			} else {
				return 0;
			}
	}
	
	public function expenses_cat_id_exists($item_number) {
		$adminId= $this->session->userdata('admin_id');
			$this->db->select('exp_cat_id');
			$this->db->where("(catName='$item_number' AND admin_id='$adminId')", NULL, FALSE);
			$query = $this->db->get('expenses_cat');
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return 0;
			}
	}
	
	public function save_expenses()
	{ 
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
			$data = array(
				"admin_id" =>$adminId,
				"exp_cat_id" =>$exp_cat_id,
				"name" => $name,
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->insert("expenses_items", $data);
		return 1;
	}
	
	public function edit_expenses($id){
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
 		$data = array(
				"exp_cat_id" =>$exp_cat_id,
				"name" => $name,
			);
		$this->db->where('exp_id', $id);
		$this->db->where('admin_id', $adminId);
		$this->db->update('expenses_items', $data);
	}
	
	public function save_expenses_cat()
	{
		extract($_REQUEST); 
		$adminId= $this->session->userdata('admin_id');
			$data = array(
				"admin_id" => $adminId,
				"catName" => $catName,
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->insert("expenses_cat", $data);
		return 1;
	}
	
	public function edit_expenses_cat($id)
	{ 
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
			$data = array(
				"catName" => $catName,
			);
		$this->db->where('exp_cat_id', $id);
		$this->db->where('admin_id', $adminId);
		$this->db->update('expenses_cat', $data);
		return 1;
	}
	
 	public function get_expenses($id = NULL) {
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
		if((isset($name) && $name!='') || (isset($item_number) && $item_number!=''))
		{
			$query = $this->db->query("select * from expenses_items where name='$name' AND admin_id='$adminId'");
		}
		else
		{
			$query = $this->db->query("select * from expenses_items where admin_id='$adminId' ORDER BY exp_id ASC ");
		}
        return $query->result_array();
    }
	
	public function get_expenses_cat($id = NULL) {
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
		if((isset($name) && $name!='') || (isset($item_number) && $item_number!=''))
		{
			$query = $this->db->query("select * from expenses_cat where catName='$name' AND admin_id='$adminId'");
		}
		else
		{
			$query = $this->db->query("select * from expenses_cat where admin_id='$adminId' ORDER BY exp_cat_id ASC ");
		}
        return $query->result_array();
    }
	
	public function get_expenses_by_id($id = NULL) {
		$adminId= $this->session->userdata('admin_id');
        $query = $this->db->query("select * from expenses_items where exp_id = $id AND admin_id='$adminId'");
        return $query->result_array();
    }
	
	public function del_expenses($id = NULL) {
		$adminId= $this->session->userdata('admin_id');
		$query = $this->db->query("DELETE FROM expenses_items WHERE exp_id = $id AND admin_id='$adminId'");
        return true;
    }
	
	public function get_expenses_cat_by_id($id = NULL) {
		$adminId= $this->session->userdata('admin_id');
        $query = $this->db->query("select * from expenses_cat where exp_cat_id = $id AND admin_id='$adminId'");
        return $query->result_array();
    }
	
	public function del_expenses_cat($id = NULL) {
		$adminId= $this->session->userdata('admin_id');
	    $query = $this->db->query("DELETE FROM expenses_cat WHERE exp_cat_id = $id where admin_id='$adminId'");
        return true;
    }

}