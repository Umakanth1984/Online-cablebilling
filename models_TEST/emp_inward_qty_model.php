<?php 
/**
* Laabus menus table
*/

class Emp_inward_qty_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function cust_inv_exists($cust,$inv) {
		$this->db->select('emp_inward_id');
			//$this->db->where('emp_email', $email);
			$this->db->where("(customer_id='$cust' AND inv_id='$inv')", NULL, FALSE);
			$query = $this->db->get('emp_inward_qty');
			if ($query->num_rows() > 0) {
				 return $query->result_array();
			} else {
				return 0;
			}
	}
	public function save($emp_id)
	{ 	
		 /*$selOut234=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where emp_id=1 AND inv_id=".$REQUEST['inv_id']));
 		 $updQty234=($selOut234['outward_qty'] - $REQUEST['inward_qty']);
 		// echo "UPDATE dealer_outward_qty SET  outward_qty ='$updQty234' WHERE  inv_id = ".$REQUEST['inv_id'];
		 $updInv=mysql_query("UPDATE dealer_outward_qty SET outward_qty='$updQty234' WHERE inv_id =".$REQUEST['inv_id']); */
		//print_r($_REQUEST); die;
		 extract($_REQUEST);
			$data = array(
				"customer_id" => $customer_id,
				"emp_id" => $emp_id,
				"inv_id" => $inv_id,
				"inward_qty" => $inward_qty,
				"remarks" => $inward_remarks,
				"dateCreated" => date('Y-m-d H:i:s')
			);
			$this->db->insert("emp_inward_qty", $data);

			$selOut23=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where emp_id=1 AND inv_id=".$inv_id));
			$updQty23=$selOut23['outward_qty'] - $inward_qty;
			// print_r($updQty23); die;
			if($updQty23>0){
				$data = array( 
						"outward_qty" => $updQty23,
					 );
				$this->db->where('inv_id', $inv_id);
				$this->db->where('emp_id', 1);
				$this->db->update('dealer_outward_qty', $data);
			}
 	 		//return 1;
	}
	public function edit($id,$emp_id){
		 extract($_REQUEST);
		$selOut1=mysql_fetch_assoc(mysql_query("select * from emp_inward_qty where emp_inward_id=".$id));
		// print_r($REQUEST);  
		 $updQty1=$selOut1['inward_qty'] + $inward_qty;
 		$data = array(
				"customer_id" => $customer_id,
				"emp_id" => $emp_id,
				"inv_id" => $inv_id,
				"inward_qty" => $updQty1,
				"remarks" => $inward_remarks,
 			);
		$this->db->where('emp_inward_id', $id);
		$this->db->update('emp_inward_qty', $data);
		$selOut23=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where emp_id=1 AND inv_id=".$inv_id));
	
		 $updQty23=$selOut23['outward_qty'] - $inward_qty;
		 // print_r($updQty23); die;
		 if($updQty23>0){
				$data = array( 
						"outward_qty" => $updQty23,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->where('emp_id', $emp_id);
				$this->db->update('dealer_outward_qty', $data);
			}
	}
	public function return_inventry($id,$emp_id){
		 
		extract($_REQUEST);
		$selOut1=mysql_fetch_assoc(mysql_query("select * from emp_inward_qty where emp_inward_id=".$id));
		// print_r($selOut); die;
		 $updQty1=$selOut1['inward_qty'] - $outward_qty;
 		$data = array(
				"customer_id" => $customer_id,
				"emp_id" => $emp_id,
				"inv_id" => $inv_id,
				"inward_qty" => $updQty1,
				"remarks" => $outward_remarks,
 			);
		$this->db->where('emp_inward_id', $id);
		$this->db->update('emp_inward_qty', $data);
		
		$selOut22=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where emp_id=$emp_id AND inv_id=$inv_id"));
		//print_r($selOut22); die;
		 $updQty22=$selOut22['outward_qty'] + $outward_qty;
		 //print_r($updQty23); die;
		 if($updQty22>0){
				$data = array( 
						"outward_qty" => $updQty22,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->where('emp_id', $emp_id);
				$this->db->update('dealer_outward_qty', $data);
			}
	}
 	public function get($emp_id) {
		
		 $chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
		 if($chkEmpType['user_type']==1){
			 $query = $this->db->query("select * from emp_inward_qty WHERE inward_qty > 0 ORDER By emp_inward_id ASC ");
		 }else{
			$query = $this->db->query("select * from emp_inward_qty WHERE inward_qty > 0 AND emp_id=$emp_id ORDER By emp_inward_id ASC ");
		 }
						 
						 
        
        //echo $query;exit;
        return $query->result_array();
    }
	 public function updateQty($emp_id) { 
		 extract($_REQUEST);
		// print_r($_REQUEST);
		// echo "select * from dealer_outward_qty where emp_id=$emp_id AND inv_id=$inv_id";
		$selOut=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where emp_id=$emp_id AND inv_id=$inv_id"));
		 //print_r($selOut); die;
		 if($selOut['outward_qty']>$inward_qty){
			$updQty=$selOut['outward_qty'] - $inward_qty;
			if($updQty>0){
				$data = array( 
						"outward_qty" => $updQty,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->where('emp_id', $emp_id);
				$this->db->update('dealer_outward_qty', $data);
			}
		 }
		
				//echo $query;exit;
        //return $query->result_array(); 
    }   
	public function get_by_id($id = NULL) {
		//echo "select * from emp_inward_qty where emp_inward_id = $id "; die;
        $query = $this->db->query("select * from emp_inward_qty where emp_inward_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function del($id = NULL) {
	     $query = $this->db->query("DELETE FROM emp_inward_qty WHERE emp_inward_id = $id ");
         return true;
    }

}