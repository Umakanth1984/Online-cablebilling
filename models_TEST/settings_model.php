<?php 
class Settings_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function password_change(){
		extract($_REQUEST);
		$data = array(
					"user_name" => $user_name,
					"new_password" => $new_password
				);
			$this->db->insert("business_information", $data);
			$id = $this->db->insert_id();
			//$this->db->where('id', 1);
			//$this->db->update('business_information', $data);
			return 1;
	}
	public function customer_password_change(){
		 
		extract($_REQUEST); 
		$chkPass=mysql_query("select * from customers where cust_id=$cust_id AND pwd='$old_password' ");
		$cntPass=mysql_num_rows($chkPass);  
		if($cntPass <= 0){
			return 0;
		}else{ 
			$data = array(
				"pwd" => $new_password,
				);
			$this->db->where('cust_id', $cust_id);
			$this->db->update('customers', $data);
			return 1; 
			 
	}
	}
	public function username_change(){
		extract($_REQUEST);
		$data = array(
					"new_user_name" => $new_user_name
				);
			$this->db->insert("business_information", $data);
			$id = $this->db->insert_id();
			//$this->db->where('id', 1);
			//$this->db->update('business_information', $data);
			return 1;
	}	
	
	public function get_users($id = NULL) {
        $query = $this->db->query("select * from employes_reg");
        //echo $query;exit;
        return $query->result_array();
    }
	
	public function get_import_values($id=NULL) {
		$adminId= $this->session->userdata('admin_id');
        $query = $this->db->query("select * from import_customers where admin_id='$adminId'");
        return $query->result_array();
    }
	
	public function update_import_values() {
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
		$this->db->select('admin_id');
		$this->db->where('admin_id', $adminId);
		$query = $this->db->get('import_customers');
		if ($query->num_rows() > 0) {
			$data = array(
					"first_name" =>strtoupper($first_name),
					"last_name" => strtoupper($last_name),
					"addr1" => strtoupper($addr1),
					"addr2" => strtoupper($addr2),
					"city" => strtoupper($city),
					"pin_code" => strtoupper($pin_code),
					"state" => strtoupper($state),
					"phone_no" => strtoupper($phone_no),
					"mobile_no" => strtoupper($mobile_no),
					"connection_date" => strtoupper($connection_date),
					"pending_amount" => strtoupper($pending_amount),
					"group_id" => strtoupper($group_id),
					"package_id" => strtoupper($package_id),
					"custom_customer_no" => strtoupper($custom_customer_no),
					"mac_id" => strtoupper($mac_id),
					"stb_no" => strtoupper($stb_no),
					"card_no" => strtoupper($card_no),
					"start_date" => strtoupper($start_date),
					"end_date" => strtoupper($end_date),
					"status" => strtoupper($status),
					"caf_status" => strtoupper($cafStatus),
					"service_poid" => strtoupper($servicePoid),
					"cust_admin_id" => strtoupper($cust_admin_id)
				);
			$this->db->where('admin_id',$adminId);
			$this->db->update('import_customers', $data);
			return 1;
		}
		else
		{
			$data = array(
					"admin_id" =>$adminId,
					"first_name" =>strtoupper($first_name),
					"last_name" => strtoupper($last_name),
					"addr1" => strtoupper($addr1),
					"addr2" => strtoupper($addr2),
					"city" => strtoupper($city),
					"pin_code" => strtoupper($pin_code),
					"state" => strtoupper($state),
					"phone_no" => strtoupper($phone_no),
					"mobile_no" => strtoupper($mobile_no),
					"connection_date" => strtoupper($connection_date),
					"pending_amount" => strtoupper($pending_amount),
					"group_id" => strtoupper($group_id),
					"package_id" => strtoupper($package_id),
					"custom_customer_no" => strtoupper($custom_customer_no),
					"mac_id" => strtoupper($mac_id),
					"stb_no" => strtoupper($stb_no),
					"card_no" => strtoupper($card_no),
					"start_date" => strtoupper($start_date),
					"end_date" => strtoupper($end_date),
					"status" => strtoupper($status),
					"caf_status" => strtoupper($cafStatus),
					"service_poid" => strtoupper($servicePoid),
					"cust_admin_id" => strtoupper($cust_admin_id)
				);
			$this->db->insert('import_customers', $data);
			return 1;
		}
    }
    
    public function update_batch_import_values() {
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
		$this->db->select('admin_id');
		$this->db->where('admin_id', $adminId);
		$query = $this->db->get('import_customers');
		if ($query->num_rows() > 0) {
			$data = array(
				"custom_customer_no" => strtoupper($custom_customer_no),
				"mac_id" => strtoupper($mac_id),
				"deal_name" => strtoupper($deal_name),
				"final_status" => strtoupper($final_status),
			);
			$this->db->where('admin_id',$adminId);
			$this->db->update('import_customers', $data);
			return 1;
		}
		else
		{
			$data = array(
				"admin_id" =>$adminId,
    			"custom_customer_no" => strtoupper($custom_customer_no),
    			"mac_id" => strtoupper($mac_id),
    			"deal_name" => strtoupper($deal_name),
    			"final_status" => strtoupper($final_status)
			);
			$this->db->insert('import_customers', $data);
			return 1;
		}
    }
}