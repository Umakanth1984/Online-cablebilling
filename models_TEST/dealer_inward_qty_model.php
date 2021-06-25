<?php 
/**
* Laabus menus table
*/

class Dealer_inward_qty_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	public function save()
	{ 
			//print_r($_REQUEST); die;
			extract($_REQUEST);
			//	echo "select * from dealer_inward_qty where inv_id=$inv_id"; die;
			$chkSql=mysql_query("select * from dealer_inward_qty where inv_id=$inv_id");
			$chkCnt=mysql_num_rows($chkSql);
 			if($chkCnt >0 ){
				$chkQty=mysql_fetch_assoc($chkSql);
				//print_r($chkQty);die;
				$inwardQty=$chkQty['inward_qty'] + $inward_qty;
 					$data = array( 
						"inward_qty" => $inwardQty,						 
					);
					$this->db->where('inv_id', $inv_id);
					$this->db->update('dealer_inward_qty', $data);

				}
			else{
				$data = array(
					"inv_id" => $inv_id,
					"inward_qty" => $inward_qty,
					"dateCreated" => date('Y-m-d H:i:s')
				);
				$this->db->insert("dealer_inward_qty", $data);
			}
		return 1;
	}
	public function edit($id,$REQUEST){
			extract($REQUEST);
 		$data = array(
				"inv_id" => $inv_id,
				"inward_qty" => $inward_qty,
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->where('dealer_inv_id', $id);
		$this->db->update('dealer_inward_qty', $data);
	}
 	public function get($id = NULL) {
        $query = $this->db->query("select * from dealer_inward_qty ORDER By dealer_inv_id ASC ");
        //echo $query;exit;
        return $query->result_array();
    }
	 
	public function get_by_id($id = NULL) {
		//echo "select * from dealer_inward_qty where dealer_inv_id = $id "; die;
        $query = $this->db->query("select * from dealer_inward_qty where dealer_inv_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function del($id = NULL) {
	     $query = $this->db->query("DELETE FROM dealer_inward_qty WHERE dealer_inv_id = $id ");
         return true;
    }

}