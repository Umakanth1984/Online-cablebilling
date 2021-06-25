<?php 
class Preferences_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function save_common()
	{
		extract($_REQUEST);
	 	$data = array(
				"customnumber" => $customnumber,
				"records" => $records, 
				"mobilerecords" => $mobilerecords, 
				"billdate" => $billdate, 
				"sortby" => $sortby, 
				"invoiceformat" => $invoiceformat, 
				"tax1" => $tax1, 
				"tax2" => $tax2,
				"tax3" => $tax3,
				"nextcustomerid" => $nextcustomerid,				
				"template" => $template,
				"admingroup" => $admingroup,
				"amountdisplay" => $amountdisplay,			
				"financialyear" => $financialyear,
				"months" => $months,
				"showbillamount" => $showbillamount,
				"showonetime" => $showonetime,
				"showmonthbill" => $showmonthbill
			);
		//$this->db->insert("common_prefer", $data);
		//$id = $this->db->insert_id();
		//return $id;
		$this->db->where('id', 1);
		$this->db->update('common_prefer', $data);
		return 1;
	}
	public function get_common()
	{
		$query = $this->db->query("select * from common_prefer");
        return $query->result_array();
	}
	 
	public function save_sms($id=NULL)
	{
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
		$this->db->select('admin_id');
		$this->db->where('admin_id', $adminId);
		$query = $this->db->get('sms_prefer');
		if ($query->num_rows() > 0) {
			$data = array(
					"sendsms" => $sendsms,
					"sendinvoicesms" => $sendinvoicesms,
					"sendpaymentsms" => $sendpaymentsms,
					"sendservicesmscustomer" => $sendservicesmscustomer,
					"sendservicesmsdealer" => $sendservicesmsdealer,
					"sendservicesmsemployee" => $sendservicesmsemployee,
					"sendcomplaintsms" => $sendcomplaintsms,
					"sendwelcomesms" => $sendwelcomesms,
					"sendonetimesms" => $sendonetimesms,
					"smsuser" => $smsuser,
					"smspwd" => $smspwd,
					"smstype" => $smstype,
					"smsfrequency" => $smsfrequency,
					"txtSMSAmtLimit" => $txtSMSAmtLimit,
					"sendoutstandingsms" => $sendoutstandingsms,
					"senddailyreportsms" => $senddailyreportsms,
					"SendCustomerDeactivationSms" => $SendCustomerDeactivationSms,
					"PendingSmstoAll" => $PendingSmstoAll,
					"sms_sender_id" => $sms_sender_id,
					"sms_api_url" => $sms_api_url
				);
			//$this->db->set('sendsms', $sendsms);
			//$this->db->insert("sms_prefer", $data);
			$this->db->where('admin_id', $adminId);
			$this->db->update('sms_prefer', $data);
			return 1;
		}
		else
		{
			$data = array(
					"admin_id" => $adminId,
					"sendsms" => $sendsms,
					"sendinvoicesms" => $sendinvoicesms,
					"sendpaymentsms" => $sendpaymentsms,
					"sendservicesmscustomer" => $sendservicesmscustomer,
					"sendservicesmsdealer" => $sendservicesmsdealer,
					"sendservicesmsemployee" => $sendservicesmsemployee,
					"sendcomplaintsms" => $sendcomplaintsms,
					"sendwelcomesms" => $sendwelcomesms,
					"sendonetimesms" => $sendonetimesms,
					"smsuser" => $smsuser,
					"smspwd" => $smspwd,
					"smstype" => $smstype,
					"smsfrequency" => $smsfrequency,
					"txtSMSAmtLimit" => $txtSMSAmtLimit,
					"sendoutstandingsms" => $sendoutstandingsms,
					"senddailyreportsms" => $senddailyreportsms,
					"SendCustomerDeactivationSms" => $SendCustomerDeactivationSms,
					"PendingSmstoAll" => $PendingSmstoAll,
					"sms_sender_id" => $sms_sender_id,
					"sms_api_url" => $sms_api_url
				);
			$this->db->insert("sms_prefer", $data);
			return 1;
		}
	}
	
	public function get($id=NULL)
	{
		$adminId= $this->session->userdata('admin_id');
		$query = $this->db->query("select * from sms_prefer where admin_id='$adminId'");
        return $query->result_array();
	}
	
	public function save_dealerprefer($REQUEST)
	{
		$data = array(
					"onetimechargetype" => $REQUEST['onetimechargetype']
			);
			$this->db->insert("dealer_prefer", $data);
			//$this->db->where('id', 1);
			//$this->db->update('dealer_prefer', $data);
	}
	
	public function update_dealerprefer()
	{
		extract($_REQUEST);
		$data = array(
					"onetimechargetype" => $onetimechargetype
			);
			// $this->db->insert("dealer_prefer", $data);
			$this->db->where('id', $dealer_prefer_id);
			$this->db->update('dealer_prefer', $data);
	}
	
	public function delete_dealerprefer($id = NULL)
	{
		$query = $this->db->query("DELETE from dealer_prefer where id='$id'");
		return true;
	}
	
	public function get_dealer_prefer($id = NULL) {
        $query = $this->db->query("select * from dealer_prefer");
        //echo $query;exit;
        return $query->result_array();
    }
	
	public function get_dealer_prefer_by_id($id) {
        $query = $this->db->query("select * from dealer_prefer where id='$id'");
        //echo $query;exit;
        return $query->result_array();
    }
	
	public function save_paymentgateway()
	{
		extract($_REQUEST);
		$data = array(
					"accID" => $accID,
					"secretkey" => $secretkey
			);
			$this->db->insert("payment_prefer", $data);
			//$this->db->where('id', 1);
			//$this->db->update('payment_prefer', $data);
			return 1;
	}
	
	public function get_payment_prefer($id = NULL) {
        $query = $this->db->query("select * from payment_prefer");
        return $query->result_array();
    }
	
	public function save_complaint()
	{
		extract($_REQUEST);
		$data = array(
					"category" => $category
			);
			$this->db->insert("complaint_prefer", $data);
			return 1;
	}
	
	public function update_complaint()
	{
		extract($_REQUEST);
		$data = array(
			    "category" => $category
			     );
			$this->db->where("id", $id);
			$this->db->update("complaint_prefer", $data);
			return 1;
	}
	
	public function get_complaint_prefer($id = NULL) {
        $query = $this->db->query("select * from complaint_prefer");
        return $query->result_array();
    }
	public function get_node_prefer($id = NULL) {
        $query = $this->db->query("select * from node_prefer");
        return $query->result_array();
    }
     public function delete_node_prefer($id = NULL)
	{
		$query = $this->db->query("DELETE from node_prefer where id='$id'");
		return true;
	}
	public function save_node()
	{ 
		extract($_REQUEST);
		$data = array(
					"category" => $category
			);
			$this->db->insert("node_prefer", $data);
			return 1;
	}
	public function update_node()
	{
		extract($_REQUEST);
		$data=array("category" => $category);
		$this->db->where("id", $id);
			$this->db->update("node_prefer", $data);
			return 1;
	}
        public function edit_node_prefer($id = NULL) {
        $query = $this->db->query("select * from node_prefer where id='$id'");
        return $query->result_array();
        }
	public function save_emp()
	{
		extract($_REQUEST);
		$data = array(
					"employeerole" => $employeerole
			);
			$this->db->insert("emp_prefer", $data);
			return 1;
	}
	
	public function update_emp()
	{
		extract($_REQUEST);
		$data = array(
			      "employeerole" => $employeerole
			     );
			$this->db->where("emp_id", $emp_id);
			$this->db->update("emp_prefer", $data);
			return 1;
	}
	
	public function get_emp_prefer($id = NULL) {
        $query = $this->db->query("select * from emp_prefer");
        return $query->result_array();
    }
	
	public function edit_complaint_prefer($id = NULL) {
        $query = $this->db->query("select * from complaint_prefer where id='$id'");
        return $query->result_array();
    }
	
	public function edit_emp_prefer($id = NULL) {
        $query = $this->db->query("select * from emp_prefer where emp_id='$id'");
        return $query->result_array();
    }
	
	public function delete_complaint_prefer($id) {
        $query = $this->db->query("DELETE from complaint_prefer where id='$id'");
        // return $query->result_array();
    }
	
	public function delete_emp_prefer($id) {
        $query = $this->db->query("DELETE from emp_prefer where emp_id='$id'");
        // return $query->result_array();
    }
	
	public function save_mso()
	{
		extract($_REQUEST);
		$data = array(
			"mso_name" => $mso,
			"dateCreated" => date('Y-m-d H:i:s')
		);
		$this->db->insert("mso", $data);
		return 1;
	}
	
	public function update_mso($mso_id=NULL)
	{
		extract($_REQUEST);
		$data = array(
			"mso_name" => $mso,
			"updatedOn" => date('Y-m-d H:i:s')
		);
		$this->db->where("mso_id", $mso_id);
		$this->db->update("mso", $data);
		return 1;
	}
	
	public function get_mso_prefer($id = NULL) {
	        $query = $this->db->query("select * from mso");
        	return $query->result_array();
	}
	
	public function edit_mso_prefer($id = NULL) {
	        $query = $this->db->query("select * from mso where mso_id='$id'");
        	return $query->result_array();
	}
	
	public function delete_mso_prefer($id = NULL) {
	        $query = $this->db->query("DELETE from mso where mso_id='$id'");
    	}
}