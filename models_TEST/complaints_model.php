<?php 
/**
* Laabus menus table
*/

class Complaints_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function save_complaints()
	{
			extract($_REQUEST);
			// $newCustID=split(",",$inputcustomerno);
			$newCustID=$cust_id;
			$ticketNo=rand(100000,999999);
			$qry1=mysql_query("select * from customers where cust_id='$newCustID'");
			$res1=mysql_fetch_assoc($qry1);
			$cust_mobile=$res1['mobile_no'];
			$data = array(
				"admin_id" =>$res1['admin_id'],
				"customer_id" =>$newCustID,
				"comp_ticketno" => $ticketNo,
				"complaint"  => $inputcomplaint,
				"comp_cat" => $complaint_category,
				"comp_status" => 0,
				"created_by" => $emp_id,
				"created_date" => date('Y-m-d H:i:s'),
				"last_edited_by" =>0,
				"edited_on" => 0,
				"comp_remarks" =>"N/A"
			);
		    $this->db->insert("create_complaint", $data);
	 
		// Send SMS
		$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer"));
		$busi_info=mysql_fetch_assoc(mysql_query("select * from  business_information"));
		$complaint_prefer=mysql_fetch_assoc(mysql_query("select * from complaint_prefer where id=".$complaint_category));
		extract($res1);
		extract($busi_info);
		$busiMobile=$busi_info['mobile'];
		extract($complaint_prefer);
		if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendcomplaintsms']=='Yes')){
		
			$mess = urlencode("Dear ".trim($first_name).", The Complaint is Registered, Please find the complaint number for your referral ".$ticketNo." Thank You...".trim($business_name));
			$url = $resSmsPrefer['sms_api_url']."&contacts=".$res1['mobile_no']."&msg=" . $mess;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
			curl_close ($ch);
	 
		 	// Admin SMS 
			$tech=implode(",",$_REQUEST['chkbox']);
			$mess1 = urlencode("New Complaint Registred from ".trim($first_name)."- (".$custom_customer_no.") Complaint No.".$ticketNo." for issue ".$category);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
			curl_close ($ch);
 		}
		// End of SMS
		return 1;
	}
	
	public function edit_complaints($id=NULL,$emp_id=NULL)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM create_complaint WHERE complaint_id=$id"));
		if($resCust['admin_id']==$chkEmpType['admin_id'])
		{
			extract($_REQUEST);
			$data = array(
				"complaint"  => $inputcomplaint,
				"comp_status" => $inputcomplaintstatus, 
				"last_edited_by"=>$emp_id, 				
				"edited_on" => date('Y-m-d H:i:s'),
				"comp_remarks" =>$inputRemarks
			);
			$this->db->where('complaint_id', $id);
			$this->db->update('create_complaint', $data);
			// Send SMS
			$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer"));
			$busi_info=mysql_fetch_assoc(mysql_query("select * from  business_information"));
			$cust_name=mysql_fetch_assoc(mysql_query("select * from customers where cust_id=".$cust_id));
			$getCompDetails=mysql_fetch_assoc(mysql_query("select * from  create_complaint where complaint_id=".$id));
			$complaint_prefer=mysql_fetch_assoc(mysql_query("select * from complaint_prefer where id=".$getCompDetails['comp_cat']));
			extract($cust_name);
			extract($busi_info);
			extract($complaint_prefer);
			$busiMobile=$busi_info['mobile'];
			$ticketNo=$getCompDetails['comp_ticketno'];
			if($inputcomplaintstatus==0){$status='Pending';}
			elseif($inputcomplaintstatus==1){$status='Processing';}
			elseif($inputcomplaintstatus==2){$status='Closed';}
			if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendcomplaintsms']=='Yes'))
			{
				$mess1 = "Dear ".trim($first_name).", Your Complaint (".$ticketNo.") Status is Updated to ".strtoupper($status)."-".trim($business_name);
				$mess = urlencode($mess1);
				$url = $resSmsPrefer['sms_api_url']."&contacts=".$mobile_no."&msg=" . $mess;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
				curl_close ($ch);
				
				$unique_sms_id="";
    			if(!empty($result))
    			{
    				$unique_sms_id=$result;
    				$smsData=array();
    				$smsData['mobile'] = $mobile_no;
    				$smsData['cust_id'] = $cust_id;
    				$smsData['message'] = $mess1;
    				$smsData['unique_sms_id'] = $unique_sms_id;
    				$smsData['perform_by'] = $emp_id;
    				$smsData['dateCreated'] = date('Y-m-d H:i:s');
    				$this->db->insert("sms_log", $smsData);
    			}
			}
		}
	}
	
	
	public function get_complaints($id = NULL)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			if((isset($customer_id) && $customer_id!='') || (isset($customer_name) && $customer_name!='') || (isset($comp_status) && $comp_status!=''))
			{
				$cust_name=$customer_name;
				$cust_qry=mysql_query("select cust_id from customers where first_name='$cust_name'");
				$cust_res=mysql_fetch_assoc($cust_qry);
				$customer_id2=$cust_res['cust_id'];
				$cust_qry1=mysql_query("select cust_id from customers where custom_customer_no='$customer_id'");
				$cust_res1=mysql_fetch_assoc($cust_qry1);
				$customer_id1=$cust_res1['cust_id'];
				$query = $this->db->query("select * from create_complaint where customer_id='$customer_id1' OR customer_id='$customer_id2' OR comp_status='$comp_status' ORDER BY complaint_id DESC");
			}
			else
			{
				$query = $this->db->query("select * from create_complaint WHERE comp_status!=2 ORDER BY complaint_id DESC");
			}
			return $query->result_array();
		}
		else
		{
			if((isset($customer_id) && $customer_id!='') || (isset($customer_name) && $customer_name!='') || (isset($comp_status) && $comp_status!=''))
			{
				$cust_name=$customer_name;
				$cust_qry=mysql_query("select cust_id from customers where first_name='$cust_name'");
				$cust_res=mysql_fetch_assoc($cust_qry);
				$customer_id2=$cust_res['cust_id'];
				$cust_qry1=mysql_query("select cust_id from customers where custom_customer_no='$customer_id'");
				$cust_res1=mysql_fetch_assoc($cust_qry1);
				$customer_id1=$cust_res1['cust_id'];
				$query = $this->db->query("select * from create_complaint where admin_id='$admin_id' AND (customer_id='$customer_id1' OR customer_id='$customer_id2' OR comp_status='$comp_status') ORDER BY complaint_id DESC");
			}
			else
			{
				$query = $this->db->query("select * from create_complaint WHERE admin_id='$admin_id' AND comp_status!=2 ORDER BY complaint_id DESC");
			}
			return $query->result_array();
		}
    }
	
	public function get_complaints_by_id($id = NULL,$emp_id=NULL) {
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM create_complaint WHERE complaint_id=$id"));
		if($resCust['admin_id']==$admin_id)
		{
			$query = $this->db->query("select * from create_complaint where complaint_id = $id ");
			return $query->result_array();
		}
    }

	public function get_customers_id($id=NULL) {
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			$query = $this->db->query("select cust_id,custom_customer_no,first_name from customers");
			return $query->result_array();
		}
		else
		{
			$query = $this->db->query("select cust_id,custom_customer_no,first_name from customers where admin_id='$admin_id'");
			return $query->result_array();
		}
    }
	
	public function closed_complaints($id=NULL) {
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			if((isset($customer_id) && $customer_id!='') || (isset($customer_name) && $customer_name!=''))
			{
				$cust_name=$customer_name;
				$cust_qry=mysql_query("select cust_id from customers where first_name='$cust_name'");
				$cust_res=mysql_fetch_assoc($cust_qry);
				$customer_id2=$cust_res['cust_id'];
				$cust_qry1=mysql_query("select cust_id from customers where custom_customer_no='$customer_id'");
				$cust_res1=mysql_fetch_assoc($cust_qry1);
				$customer_id1=$cust_res1['cust_id'];
				$query = $this->db->query("select * from create_complaint where customer_id='$customer_id1' OR customer_id='$customer_id2' OR comp_status='$comp_status' ORDER BY complaint_id DESC");
			}
			else
			{
				$query = $this->db->query("select * from create_complaint WHERE comp_status=2 ORDER BY complaint_id DESC");
			}
			return $query->result_array();
		}
		else
		{
			if((isset($customer_id) && $customer_id!='') || (isset($customer_name) && $customer_name!=''))
			{
				$cust_name=$customer_name;
				$cust_qry=mysql_query("select cust_id from customers where first_name='$cust_name'");
				$cust_res=mysql_fetch_assoc($cust_qry);
				$customer_id2=$cust_res['cust_id'];
				$cust_qry1=mysql_query("select cust_id from customers where custom_customer_no='$customer_id'");
				$cust_res1=mysql_fetch_assoc($cust_qry1);
				$customer_id1=$cust_res1['cust_id'];
				$query = $this->db->query("select * from create_complaint where admin_id='$admin_id' AND (customer_id='$customer_id1' OR customer_id='$customer_id2' OR comp_status='$comp_status') ORDER BY complaint_id DESC");
			}
			else
			{
				$query = $this->db->query("select * from create_complaint WHERE admin_id='$admin_id' AND comp_status=2 ORDER BY complaint_id DESC");
			}
			return $query->result_array();
		}
    }
}