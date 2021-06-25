<?php
/**
* Laabus menus table
*/

class Broadcast_sms_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
 
	public function broadcast_sms()
	{
		extract($_REQUEST); 
		$adminId= $this->session->userdata('admin_id');
		$empId= $this->session->userdata('emp_id');
		$group_ids=implode(",",$grp);
		$group_names=implode(",",$grpName);
		if(isset($unpaidCust) && $unpaidCust=='unpaid')
		{
		    $type="Unpaid Customers";
			$sel_customer=mysql_query("select mobile_no,cust_id from customers where admin_id='$adminId' AND pending_amount > 0 AND mobile_no!='1234567890' AND status=1");
		}
		elseif(isset($allgroups) && $allgroups=='allgroups')
		{
		    $type="All Active Customers";
			$sel_customer=mysql_query("select mobile_no,cust_id from customers where admin_id='$adminId' AND status=1 AND mobile_no!='1234567890'");
		}
		else
		{
		    $type="Selected Groups (".$group_names.") Customers";
			$sel_customer=mysql_query("select mobile_no,cust_id from customers where admin_id='$adminId' AND group_id IN ($group_ids) AND mobile_no!='1234567890' AND status=1");
		}
		$busInfo=mysql_fetch_assoc(mysql_query("SELECT business_name FROM business_information"));		
		$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT sms_api_url FROM sms_prefer"));
		$busiName=$busInfo['business_name'];
		while($cust_res=mysql_fetch_assoc($sel_customer))
		{
			$newMsg=strip_tags($msgFormat);
			// Send SMS
				$mess = urlencode("$newMsg");
				$url = $resSmsPrefer['sms_api_url']."&contacts=".$cust_res['mobile_no']."&msg=".$newMsg; 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
				curl_close ($ch);
			// End of SMS Sending
		    $unique_sms_id="";
			if(!empty($result))
			{
				$unique_sms_id=$result;
				$smsData=array();
				$smsData['mobile'] = $cust_res['mobile_no'];
				$smsData['cust_id'] = $cust_res['cust_id'];
				$smsData['message'] = $newMsg;
				$smsData['unique_sms_id'] = $unique_sms_id;
				$smsData['perform_by'] = $empId;
				$smsData['dateCreated'] = date('Y-m-d H:i:s');
				$this->db->insert("sms_log", $smsData);
			}
		}
			$ipaddress = '';
			if(isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			$data1 = array(
				"emp_id" => $empId,
				"category" => "SMS Broadcast",
				"ipaddress" => $ipaddress,
				"log_text" => "SMS Broadcasted for : ".$type,
				"dateCreated" => date("Y-m-d H:i:s")
			);
			$this->db->insert("change_log", $data1);
		return 1;
	}

	public function broadcast_single_sms()
	{
		extract($_REQUEST);
		$cust_mobile=$inputcustomerno;
		$empId= $this->session->userdata('emp_id');
		if($cust_mobile!='1234567890')
		{
			$mess = urlencode($msgFormat);
			// Send SMS
			$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT sendsms,sendpaymentsms,sms_api_url FROM sms_prefer"));
			if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendpaymentsms']=='Yes'))
			{
				$url = $resSmsPrefer['sms_api_url']."&contacts=".$cust_mobile."&msg=" . $mess;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close ($ch);
				
				$unique_sms_id="";
    			if(!empty($result))
    			{
    				$unique_sms_id=$result;
    				$smsData=array();
    				$smsData['mobile'] = $cust_mobile;
    				$smsData['cust_id'] = 0;
    				$smsData['message'] = $msgFormat;
    				$smsData['unique_sms_id'] = $unique_sms_id;
    				$smsData['perform_by'] = $empId;
    				$smsData['dateCreated'] = date('Y-m-d H:i:s');
    				$this->db->insert("sms_log", $smsData);
    			}
    			
    			$ipaddress = '';
    			if(isset($_SERVER['HTTP_CLIENT_IP']))
    				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    			else if(isset($_SERVER['HTTP_X_FORWARDED']))
    				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    			else if(isset($_SERVER['HTTP_FORWARDED']))
    				$ipaddress = $_SERVER['HTTP_FORWARDED'];
    			else if(isset($_SERVER['REMOTE_ADDR']))
    				$ipaddress = $_SERVER['REMOTE_ADDR'];
    			else
    				$ipaddress = 'UNKNOWN';
    			$data1 = array(
    				"emp_id" => $empId,
    				"category" => "Single SMS Broadcast",
    				"ipaddress" => $ipaddress,
    				"log_text" => "Single SMS Broadcasted for : ".$cust_mobile,
    				"dateCreated" => date("Y-m-d H:i:s")
    			);
    			$this->db->insert("change_log", $data1);
			}
			return 1;
		}
	}
}