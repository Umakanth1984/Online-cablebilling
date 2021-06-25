<?php
/**
* Laabus menus table
*/

	class Bill_rollback_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
 
	public function rollback_bill()
	{
		//extract($_REQUEST);		
		$sel_customer=mysql_query("select * from customers where status=1");
		while($cust_res=mysql_fetch_assoc($sel_customer)){
				$pkg_id=mysql_fetch_assoc(mysql_query("select package_id,group_name from groups where group_id=".$cust_res['group_id']));
				$qry_price=mysql_query("select package_price,package_validity from packages where package_id=".$cust_res['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);
				$current_pack_price=floor($sel_price['package_price']/$sel_price['package_validity']);
				$current_due = floor($cust_res['current_due']-$current_pack_price);
				$id=$cust_res['cust_id'];
				$data = array( 
					//"amount" => $inputAmount,
					 "pending_amount" => $current_due,
					"current_due" => $current_due,
					//"monthly_bill" => $sel_price['package_price'],
					"monthly_bill" => $current_pack_price,
				);
				$this->db->where('cust_id', $id);
				$this->db->update('customers', $data);
			/*Inserting Data into Billinfo DB	
			$data = array(
				"cust_id" => $cust_res['cust_id'],
				"group_id" => $cust_res['group_id'],
				"previous_due" => $cust_res['pending_amount'],
				"total_outstaning" => $current_due,
				"current_month_name" => date("F"),
				//"current_month_bill" => $sel_price['package_price'],
				"current_month_bill" =>$current_pack_price,
				"dateGenerated" => date('Y-m-d H:i:s')			
			);
			$this->db->insert("billing_info", $data);*/
			$billing_info_qry=mysql_query("select * from billing_info ORDER BY bill_info_id DESC");
			$billing_info_res=mysql_fetch_assoc($billing_info_qry);
			$bill_id=$billing_info_res['bill_info_id'];
			$query=mysql_query("DELETE from billing_info where bill_info_id='$bill_id'");
		}
		return 1;
	}
 
}