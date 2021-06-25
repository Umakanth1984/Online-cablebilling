<?php 
/**
* Laabus menus table
*/

class Dealer_outward_qty_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function save()
	{  
	
		extract($_REQUEST);
			$chkSql=mysql_query("select * from dealer_outward_qty where emp_id=$emp_id AND inv_id=$inv_id");
			$chkCnt=mysql_num_rows($chkSql);
			//echo "select * from dealer_outward_qty where emp_id=$emp_id AND inv_id=$inv_id"; 
			//echo $chkCnt;die;
			if($chkCnt >0 ){
				$chkQty=mysql_fetch_assoc($chkSql);
				 $outQty=$chkQty['outward_qty']+$outward_qty;
				 
					$data = array(
						"emp_id" => $emp_id,
						"inv_id" => $inv_id,
						"outward_qty" => $outQty,
						"dateCreated" => date('Y-m-d H:i:s')
					);
					$this->db->where('dealer_outward_id', $chkQty['dealer_outward_id']);
					$this->db->update('dealer_outward_qty', $data);
			
			}
			else{
				$data = array(
						 "emp_id" => $emp_id,
						"inv_id" => $inv_id,
						"outward_qty" => $outward_qty,
						"dateCreated" => date('Y-m-d H:i:s')
					);
				$this->db->insert("dealer_outward_qty", $data);
			}
		return 1;
	}
	public function edit($id){
		 
			extract($_REQUEST); 
			
				$selOut=mysql_fetch_assoc(mysql_query("select * from dealer_inward_qty where inv_id=".$inv_id));
				//$updQty=$selOut['inward_qty'] + $outward_qty;
			 
				/*if($updQty>0){
					$data = array( 
						"inward_qty" => $updQty,

					);
				$this->db->where('inv_id', $inv_id);
				$this->db->update('dealer_inward_qty', $data);
				}*/
			
			 if($selOut['inward_qty'] >= $outward_qty){
					$chkSql=mysql_fetch_assoc("select * from dealer_outward_qty where emp_id=$emp_id AND inv_id=$inv_id");
					$chkCnt=mysql_num_rows($chkSql);
					if($chkCnt >0 ){
						$chkQty=mysql_query($chkSql);
					 
							
					
					}
					else{
						$data = array(
							"emp_id" => $emp_id,
							"inv_id" => $inv_id,
							"outward_qty" => $outward_qty,
							"dateCreated" => date('Y-m-d H:i:s')
						);
						$this->db->where('dealer_outward_id', $id);
						$this->db->update('dealer_outward_qty', $data);
					}
			}
	}
 	public function get($id = NULL) {
        $query = $this->db->query("select * from dealer_outward_qty ORDER By dealer_outward_id ASC ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function updateQty() { 
			extract($_REQUEST); 
		  $selOut1=mysql_fetch_assoc(mysql_query("select * from dealer_outward_qty where inv_id=".$inv_id));
		// print_r($selOut1); 
		if($selOut1['outward_qty']>$outward_qty){$updQty1=$outward_qty-$selOut1['outward_qty'];}else{$updQty1=$outward_qty-$selOut1['outward_qty'] ;}
		// print_r($updQty1); die;
		/*$data = array( 
						"inward_qty" => $updQty1,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->update('dealer_inward_qty', $data); */
				 
		  //$updQty=$selOut['inward_qty'] + $outward_qty;
		
		$selOut=mysql_fetch_assoc(mysql_query("select * from dealer_inward_qty where inv_id=".$inv_id));
		$updQty=$selOut['inward_qty'] - $updQty1;
		//echo $selOut['inward_qty']." - ".$updQty1; die;
		if($updQty>0){
				$data = array( 
						"inward_qty" => $updQty,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->update('dealer_inward_qty', $data);
			}
				//echo $query;exit;
        //return $query->result_array();
    }  
	public function updateAddQty() { 
			extract($_REQUEST); 
		  $selOut1=mysql_fetch_assoc(mysql_query("select * from dealer_inward_qty where inv_id=".$inv_id));
		//  print_r($selOut1);
		//   print_r($_REQUEST);
		if($selOut1['inward_qty'] > $outward_qty){$updQty1=$selOut1['inward_qty'] - $outward_qty;}else{$updQty1=$selOut1['inward_qty']+ $outward_qty;}
		// print_r($updQty1);  die;
		/*$data = array( 
						"inward_qty" => $updQty1,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->update('dealer_inward_qty', $data); */
				 
		  //$updQty=$selOut['inward_qty'] + $outward_qty;
		
	//	$selOut=mysql_fetch_assoc(mysql_query("select * from dealer_inward_qty where inv_id=".$inv_id));
		//$updQty=$selOut['inward_qty'] - $updQty1;
		//echo $selOut['inward_qty']." - ".$updQty1; die;
		if($updQty1>0){
				$data = array( 
						"inward_qty" => $updQty1,
					 
					);
				$this->db->where('inv_id', $inv_id);
				$this->db->update('dealer_inward_qty', $data);
			}
				//echo $query;exit;
        //return $query->result_array();
    }  
	public function get_by_id($id = NULL) {
		 //echo "select * from dealer_outward_qty where dealer_outward_id = $id "; die;
        $query = $this->db->query("select * from dealer_outward_qty where dealer_outward_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	public function del($id = NULL) {
	     $query = $this->db->query("DELETE FROM dealer_outward_qty WHERE dealer_outward_id = $id ");
         return true;
    }

}