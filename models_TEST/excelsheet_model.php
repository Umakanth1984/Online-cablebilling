<?php 
class Excelsheet_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function get_customers(){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9)
		{
			$qry="select * from customers where 1=1 ";
		}
		else
		{
			$qry="select * from customers where group_id IN ($grp_ids) AND admin_id='$admin_id'";
		}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND group_id='$inputGroup'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND mobile_no='$mobile'";
			}
			if(isset($report_type) && $report_type=='0')
			{
				$qry.=" AND pending_amount=0 ORDER BY cust_id ASC";
			}
			if(isset($report_type) && $report_type=='1')
			{
				$qry.=" AND pending_amount > 0 ORDER BY cust_id ASC";
			}
			if(isset($report_type) && $report_type=='2')
			{
				$qry.=" AND pending_amount < 0 ORDER BY cust_id ASC";
			}
			if(isset($report_type) && $report_type=='3')
			{
				$qry.="  AND status = 1 ORDER BY cust_id ASC";
			}
			if(isset($report_type) && $report_type=='4')
			{
				$qry.="  AND status != 1  ORDER BY cust_id ASC";
			}
			if(isset($report_type) && $report_type=='none')
			{
				$qry.=" ORDER BY custom_customer_no ASC";
			}
				//$qry.= " limit ". $start . ", " . $limit;
			$query = $this->db->query($qry);
		return $query->result_array();
    }	

	public function get_paid_customers(){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9){
			$qry="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2,customers.status,customers.first_name,customers.last_name,customers.monthly_bill,groups.package_id,groups.group_name,packages.package_price,customers.card_no,customers.mac_id,customers.stb_no,SUM(payments.amount_paid) as amount_paid,employes_reg.emp_first_name,billing_info.previous_due as tot_pre_due,billing_info.current_month_bill,billing_info.total_outstaning from customers RIGHT JOIN groups ON groups.group_id=customers.group_id RIGHT JOIN packages ON packages.package_id=customers.package_id RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN billing_info ON billing_info.cust_id=customers.cust_id where 1=1 ";
		}
		elseif($user_type==1){
			$qry="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2, customers.status, customers.first_name,customers.last_name,customers.monthly_bill,groups.package_id,groups.group_name,packages.package_price,customers.card_no,customers.mac_id,customers.stb_no,SUM(payments.amount_paid) as amount_paid,employes_reg.emp_first_name,billing_info.previous_due as tot_pre_due,billing_info.current_month_bill,billing_info.total_outstaning from customers RIGHT JOIN groups ON groups.group_id=customers.group_id RIGHT JOIN packages ON packages.package_id=customers.package_id RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN billing_info ON billing_info.cust_id=customers.cust_id where 1=1 AND customers.admin_id='$admin_id'";
		}
		else{
			$qry="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2, customers.status, customers.first_name,customers.last_name,customers.monthly_bill,groups.package_id,groups.group_name,packages.package_price,customers.card_no,customers.mac_id,customers.stb_no,SUM(payments.amount_paid) as amount_paid,employes_reg.emp_first_name,billing_info.previous_due as tot_pre_due,billing_info.current_month_bill,billing_info.total_outstaning from customers RIGHT JOIN groups ON groups.group_id=customers.group_id RIGHT JOIN packages ON packages.package_id=customers.package_id RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN billing_info ON billing_info.cust_id=customers.cust_id where customers.group_id IN ($grp_ids) AND customers.admin_id='$admin_id'";
		}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND groups.group_id IN ($newGrpIds)";
			}
			if(isset($inputEmp) && $inputEmp!=''){
				$getEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$inputEmp"));
				$empGrp=$getEmpGrps['group_ids'];
				$qry.=" AND groups.group_id IN ($empGrp)";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}
			if(isset($inputStatus) && $inputStatus!='')
			{
				$qry.=" AND customers.status='$inputStatus'";
			}
			if((isset($amount) && $amount!='') && (isset($condition) && $condition!=''))
			{
				$qry.=" AND payments.amount_paid $condition $amount";
			}
			if(isset($total_paid) && $total_paid!='')
			{
				$qry.=" AND customers.pending_amount=0";
			}
			if(isset($monthDate) && $monthDate!='')
			{
				$newMonth=$monthDate."-00 00:00:00";
				$qry.="  AND payments.dateCreated >= '$newMonth' ";
			}
				$qry.=" AND customers.cust_id!='' GROUP BY payments.customer_id ASC";
				// echo $qry;
			$query = $this->db->query($qry);
	    return $query->result_array();
    }
	
	public function get_users(){
		extract($_REQUEST);
		if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($inputGroup) && $inputGroup!=''))
		{
			$query = $this->db->query("select * from customers RIGHT JOIN groups ON customers.group_id=groups.group_id where custom_customer_no='$inputCCN' or first_name='$inputFname' or group_id='$inputGroup' and pending_amount=0");
		}
		else
		{
			$query = $this->db->query("select cust_id,first_name,addr1,state,city,pin_code,mobile_no,group_name,custom_customer_no,monthly_bill,current_due from customers RIGHT JOIN groups ON customers.group_id=groups.group_id where pending_amount=0");
		}
	    return $query->result_array();
    }
	
	public function get_unpaid_customers(){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9)
		{
			$qry="select * from customers where 1=1 ";
		}
		else
		{
			$qry="select * from customers where group_id IN ($grp_ids) AND admin_id='$admin_id'";
		}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND first_name LIKE '%$inputFname%'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND group_id IN ($newGrpIds)";
			}
			if(isset($inputEmp) && $inputEmp!=''){
				$getEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$inputEmp"));
				$empGrp=$getEmpGrps['group_ids'];
				$qry.=" AND group_id IN ($empGrp)";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND mobile_no='$mobile'";
			}
			if(isset($inputStatus) && $inputStatus!='')
			{
				$qry.=" AND status='$inputStatus'";
			}
			if((isset($amount) && $amount!='') && (isset($condition) && $condition!=''))
			{
				$qry.=" AND amount_paid $condition $amount";
			}
				$qry.=" AND pending_amount>0 ORDER BY custom_customer_no ASC";
			$query = $this->db->query($qry);
	    return $query->result_array();
    }
		
	public function get_adv_paid_customers(){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9)
		{
			$qry="select * from customers where 1=1 ";
		}
		else
		{
			$qry="select * from customers where group_id IN ($grp_ids) AND admin_id='$admin_id'";
		}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND first_name LIKE '%$inputFname%'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND group_id IN ($newGrpIds)";
			}
			if(isset($inputEmp) && $inputEmp!=''){
				$getEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$inputEmp"));
				$empGrp=$getEmpGrps['group_ids'];
				$qry.=" AND groups.group_id IN ($empGrp)";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND mobile_no='$mobile'";
			}
				$qry.=" AND pending_amount<0 ORDER BY custom_customer_no ASC";
			$query = $this->db->query($qry);
	    return $query->result_array();
    }
	
	public function get_active_customers(){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9)
		{
			$qry="select * from customers where 1=1 ";
		}
		else
		{
			$qry="select * from customers where group_id IN ($grp_ids) AND admin_id='$admin_id'";
		}
			if((isset($inputLco) && $inputLco!=''))
			{
				$qry.=" AND admin_id='$inputLco'";
			}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND first_name LIKE '%$inputFname%'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND group_id IN ($newGrpIds)";
			}
			if(isset($inputEmp) && $inputEmp!=''){
				$getEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$inputEmp"));
				$empGrp=$getEmpGrps['group_ids'];
				$qry.=" AND group_id IN ($empGrp)";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND mobile_no='$mobile'";
			}
			// if(isset($inputStatus) && $inputStatus!='')
			// {
				// $qry.=" AND status='$inputStatus'";
			// }
			if((isset($amount) && $amount!='') && (isset($condition) && $condition!=''))
			{
				$qry.=" AND pending_amount $condition $amount";
			}
				$qry.=" AND status=1 ORDER BY custom_customer_no ASC";
			$query = $this->db->query($qry);
	    return $query->result_array();
    }
	
	public function get_inactive_customers(){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9){
		  $qry ="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2, customers.status, customers.first_name,customers.stb_no,customers.mac_id,customers.remarks, groups.group_name from customers RIGHT JOIN groups ON groups.group_id=customers.group_id  where  customers.status='0' ";
		//	$qry="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2, customers.status, customers.first_name,customers.card_no,customers.remarks, groups.package_id,groups.group_name,packages.package_price,(select inactive_date from customers_inactive where cust_id=customers.cust_id) as inactive_date from customers RIGHT JOIN groups ON groups.group_id=customers.group_id RIGHT JOIN packages ON packages.package_id=customers.package_id where 1=1 AND customers.status='0' ";
		}
		elseif($user_type==1){
		    $qry="select * from customers where status=0";
		//	$qry="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2, customers.status, customers.first_name,customers.card_no,customers.remarks, groups.package_id,groups.group_name,packages.package_price,(select inactive_date from customers_inactive where cust_id=customers.cust_id) as inactive_date from customers RIGHT JOIN groups ON groups.group_id=customers.group_id RIGHT JOIN packages ON packages.package_id=customers.package_id where 1=1 AND customers.status='0' AND customers.admin_id='$admin_id'";
		}
		else{
		    $qry="select * from customers where status=0";
			//$qry="select customers.custom_customer_no,customers.cust_id, customers.mobile_no, customers.pending_amount, customers.addr1,customers.addr2,customers.card_no, customers.status, customers.first_name,customers.remarks, groups.package_id,groups.group_name,packages.package_price,(select inactive_date from customers_inactive where cust_id=customers.cust_id) as inactive_date from customers RIGHT JOIN groups ON groups.group_id=customers.group_id RIGHT JOIN packages ON packages.package_id=customers.package_id where customers.group_id IN ($grp_ids) AND customers.status='0' AND customers.admin_id='$admin_id'";
		}
			if((isset($inputLco) && $inputLco!=''))
			{
				$qry.=" AND customers.admin_id='$inputLco'";
			}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND groups.group_id IN ($newGrpIds)";
			}
			if(isset($inputEmp) && $inputEmp!=''){
				$getEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$inputEmp"));
				$empGrp=$getEmpGrps['group_ids'];
				$qry.=" AND groups.group_id IN ($empGrp)";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}
			if((isset($amount) && $amount!='') && (isset($condition) && $condition!=''))
			{
				$qry.=" AND customers.pending_amount $condition $amount";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d 00:00:00",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND (customers.dateCreated BETWEEN '$from_date' AND '$to_date') ";
			}
			// if(isset($inputStatus) && $inputStatus!='')
			// {
				// $qry.=" AND customers.status='$inputStatus'";
			// }
				$qry.=" ORDER BY customers.custom_customer_no ASC";
			$query = $this->db->query($qry);
	    return $query->result_array();
    }
	
	public function get_new_connection(){
		$grp_qry=mysql_query("select * from groups WHERE is_parent=0");
		//while($grp_res=mysql_fetch_assoc($grp_qry))
		$grp_res=mysql_fetch_assoc($grp_qry);
		//{
		//$grp_ID=$grp_res['group_id'];
		$today=date("Y-m-d");
		$query = $this->db->query("select * from customers where status=1 and connection_date >= '$today'");
		//$query = $this->db->query("select * from groups WHERE is_parent=0");
	    return $query->result_array();
		//}
    }
	
	public function get_collection($emp_id){
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
			if($user_type==9)
			{
				$month=date("Y-m-00 00:00:00");
				$qry =  "SELECT customers.custom_customer_no,customers.mac_id,customers.stb_no,customers.first_name,customers.last_name,customers.mobile_no,customers.addr1,payments.amount_paid,customers.pending_amount,payments.customer_id,payments.grp_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_id,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where payments.dateCreated >= '$month'";
			}
			elseif($user_type==1)
			{
				$month=date("Y-m-00 00:00:00");
				$qry =  "SELECT customers.custom_customer_no,customers.mac_id,customers.stb_no,customers.first_name,customers.last_name,customers.mobile_no,customers.addr1,payments.amount_paid,customers.pending_amount,payments.customer_id,payments.grp_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_id,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where payments.dateCreated >= '$month' AND customers.admin_id='$admin_id'";
			}
			else
			{
				$month=date("Y-m-00 00:00:00");
				$qry = "SELECT customers.custom_customer_no,customers.mac_id,customers.stb_no,customers.first_name,customers.last_name,customers.mobile_no,customers.addr1,payments.amount_paid,customers.pending_amount,payments.customer_id,payments.grp_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_id,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where payments.dateCreated >= '$month' AND groups.group_id IN ($grp_ids) AND customers.admin_id='$admin_id'";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			/*if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND groups.group_id = '$inputGroup'";
			}*/
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND groups.group_id IN ($newGrpIds)";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND payments.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
				// $qry.= " limit ". $start . ", " . $limit;
			$query = $this->db->query($qry);			
	    return $query->result_array();
    }
	
	public function get_allcollections(){
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
			if($user_type==9)
			{
				$qry =  "SELECT customers.custom_customer_no,customers.mac_id,customers.stb_no,customers.first_name,customers.last_name,customers.addr1,customers.mobile_no,customers.status,payments.amount_paid,customers.pending_amount,payments.customer_id,payments.grp_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_id,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where 1=1 AND customers.cust_id!=''";
			}
			elseif($user_type==1)
			{
				$qry =  "SELECT customers.custom_customer_no,customers.mac_id,customers.stb_no,customers.first_name,customers.last_name,customers.addr1,customers.mobile_no,customers.status,payments.amount_paid,customers.pending_amount,payments.customer_id,payments.grp_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_id,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where 1=1 AND customers.admin_id='$admin_id' AND customers.cust_id!=''";
			}
			else
			{
				$qry = "SELECT customers.custom_customer_no,customers.mac_id,customers.stb_no,customers.first_name,customers.last_name,customers.addr1,customers.mobile_no,customers.status,payments.amount_paid,customers.pending_amount,payments.customer_id,payments.grp_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_id,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where groups.group_id IN ($grp_ids) AND customers.admin_id='$admin_id' AND customers.cust_id!=''";
			}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND groups.group_id = '$inputGroup'";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND payments.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			if((isset($amount) && $amount!='') && (isset($condition) && $condition!=''))
			{
				$qry.=" AND payments.amount_paid $condition $amount";
			}
			$query = $this->db->query($qry);			
	    return $query->result_array();			
    }
	
	public function get_monthdemand(){
		$emp_id= $this->session->userdata('emp_id');
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			$query = mysql_query("select * from customers");
		}
		else
		{
			$query = mysql_query("select * from customers AND admin_id='$admin_id'");
		}
	    return $query;
    }
	
	public function get_open_complaints(){
		extract($_REQUEST);
		$emp_id= $this->session->userdata('emp_id');
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($mobile) && $mobile!=''))
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where (customers.custom_customer_no='$inputCCN' OR customers.first_name='$inputFname') AND comp_status != 2");
			}
			else
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,customers.mobile_no,customers.city,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where comp_status != 2");
			}
			
		}
		else
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($mobile) && $mobile!=''))
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where customers.admin_id='$admin_id' AND (customers.custom_customer_no='$inputCCN' OR customers.first_name='$inputFname') AND comp_status != 2");
			}
			else
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,customers.mobile_no,customers.city,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where customers.admin_id='$admin_id' AND comp_status != 2");
			}
		}
	    return $query;
    }
	
	public function get_closed_complaints(){
		extract($_REQUEST);
		$emp_id= $this->session->userdata('emp_id');
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($mobile) && $mobile!=''))
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.edited_on,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where (customers.custom_customer_no='$inputCCN' OR customers.first_name='$inputFname') AND comp_status = 2");
			}
			else
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,customers.mobile_no,customers.city,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where comp_status = 2");
			}
			
		}
		else
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($mobile) && $mobile!=''))
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.edited_on,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where customers.admin_id='$admin_id' AND (customers.custom_customer_no='$inputCCN' OR customers.first_name='$inputFname') AND comp_status = 2");
			}
			else
			{
				$query = mysql_query("select customers.custom_customer_no,customers.first_name,customers.addr1,customers.mobile_no,customers.city,create_complaint.comp_ticketno,create_complaint.complaint,complaint_prefer.category,create_complaint.created_date,create_complaint.comp_status,create_complaint.comp_remarks from create_complaint RIGHT JOIN customers ON create_complaint.customer_id=customers.cust_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where customers.admin_id='$admin_id' AND comp_status = 2");
			}
		}
	    return $query;
    }
	
	public function get_active_cust_number()
	{
		$query = $this->db->query("select * from customers where status = 1");
	    return $query->num_rows();
	}
	
	public function get_inactive_cust_number()
	{
		$query = $this->db->query("select * from customers where status != 1");
	    return $query->num_rows();
	}
	
	public function get_open_comp_number()
	{
		$query = $this->db->query("select * from create_complaint where comp_status = 'Active Complaints'");
	    return $query->num_rows();
	}
	
	public function get_closed_comp_number()
	{
		$query = $this->db->query("select * from create_complaint where comp_status = 'Closed Complaints'");
	    return $query->num_rows();
	}
	
	public function get_complaints($emp_id){
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9){
			$qry="select create_complaint.customer_id,create_complaint.comp_ticketno,create_complaint.comp_cat,create_complaint.complaint,create_complaint.comp_status,create_complaint.created_date,create_complaint.comp_remarks,customers.custom_customer_no,customers.first_name,customers.addr1,customers.addr2,customers.mobile_no,complaint_prefer.category from customers RIGHT JOIN create_complaint ON customers.cust_id=create_complaint.customer_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where 1=1 ";
		}
		elseif($user_type==1){
			$qry="select create_complaint.customer_id,create_complaint.comp_ticketno,create_complaint.comp_cat,create_complaint.complaint,create_complaint.comp_status,create_complaint.created_date,create_complaint.comp_remarks,customers.custom_customer_no,customers.first_name,customers.addr1,customers.addr2,customers.mobile_no,complaint_prefer.category from customers RIGHT JOIN create_complaint ON customers.cust_id=create_complaint.customer_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where 1=1 AND customers.admin_id='$admin_id'";
		}
		else{
			$qry="select create_complaint.customer_id,create_complaint.comp_ticketno,create_complaint.comp_cat,create_complaint.complaint,create_complaint.comp_status,create_complaint.created_date,create_complaint.comp_remarks,customers.custom_customer_no,customers.first_name,customers.addr1,customers.addr2,customers.mobile_no,complaint_prefer.category from customers RIGHT JOIN create_complaint ON customers.cust_id=create_complaint.customer_id RIGHT JOIN complaint_prefer ON create_complaint.comp_cat=complaint_prefer.id where customers.group_id IN ($grp_ids) AND customers.admin_id='$admin_id'";
		}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($inputStatus) && $inputStatus!='')
			{
				$qry.=" AND create_complaint.comp_status = '$inputStatus'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}
			$query = $this->db->query($qry);
		return $query->result_array();
    }
	
	public function get_current_month_demand(){
		// $query = mysql_query("select * from customers");
		$month=date("Y-m-00 00:00:00");
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			$qry = "SELECT DISTINCT(`cust_id`) FROM `customers` RIGHT JOIN payments ON payments.customer_id=customers.cust_id WHERE payments.amount_paid!='0' AND payments.dateCreated>='$month'";
		}
		else
		{
			$qry = "SELECT DISTINCT(`cust_id`) FROM `customers` RIGHT JOIN payments ON payments.customer_id=customers.cust_id WHERE payments.amount_paid!='0' AND payments.dateCreated>='$month' AND customers.admin_id='$admin_id'";
		}
			$qry.= " ORDER BY cust_id ASC ";
			$query=mysql_query($qry);
	    return $query;
    }	
	
	public function get_next_payment_date_list()
	{
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$emp_id= $this->session->userdata('emp_id');
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
			if($user_type==9)
			{
				$today=date("Y-m-d");
				$qry =  "select next_payment_date.emp_id,next_payment_date.next_pay_date,next_payment_date.dateCreated,customers.custom_customer_no,customers.first_name,customers.mobile_no,customers.addr1,groups.group_name from next_payment_date RIGHT JOIN customers ON customers.cust_id=next_payment_date.cust_id RIGHT JOIN groups ON groups.group_id=customers.group_id where 1=1";
			}
			else
			{
				$today=date("Y-m-d");
				$qry = "select next_payment_date.emp_id,next_payment_date.next_pay_date,next_payment_date.dateCreated,customers.custom_customer_no,customers.first_name,customers.mobile_no,customers.addr1,groups.group_name from next_payment_date RIGHT JOIN customers ON customers.cust_id=next_payment_date.cust_id RIGHT JOIN groups ON groups.group_id=customers.group_id where 1=1 AND customers.admin_id='$admin_id'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds) && $newGrpIds!='')
			{
				$qry.=" AND groups.group_id IN ($newGrpIds)";
			}			
			if((isset($from_date) && $from_date!='') && (isset($to_date) && $to_date!=''))
			{
				$org_fromdate=strtotime($from_date);
				$fromdate=date("Y-m-d",$org_fromdate);
				$org_todate=strtotime('+23 hours +00 minutes +00 seconds', strtotime($to_date));
				$todate=date("Y-m-d",$org_todate);	
				$qry.=" AND next_payment_date.next_pay_date BETWEEN '$fromdate' AND '$todate'";
			}
			else
			{
				$qry.=" AND next_payment_date.next_pay_date = '$today'";
			}
				// echo $qry;
			$query = $this->db->query($qry);			
	    return $query->result_array();
	}
	
	public function get_customer_requets_pending() {
	    extract($_REQUEST);
	    $adminId=$this->session->userdata('admin_id');
	    $emp_id=$this->session->userdata('emp_id');
	    if(isset($fromdate) && $fromdate!='' && isset($todate) && $todate!='')
        {
        	$date1=date("Y-m-d 00:00:00",strtotime($fromdate));
        	$date2=date("Y-m-d 23:59:59",strtotime($todate));
        }
        else
        {
        	$date1=date("Y-m-01 00:00:00");
        	$date2=date("Y-m-31 23:59:59");
        }
	    $temp1 = $this->db->query("select user_type from employes_reg where emp_id='$emp_id' AND status=1")->result_array();
	    $date=date("Y-m-01");
	    $where1="";
        if(isset($inputLco) && $inputLco!='')
        {
            $where1.=" AND c.admin_id='$inputLco'";
        }
        if(isset($temp_appr) && $temp_appr!='')
        {
            $where1.=" AND ar.status = 1";
        }
        else
        {
            $where1.=" AND ar.status IS NULL";
        }
        if(isset($bouquet) && $bouquet!='')
        {
            $where1.=" AND ar.pack_id='$bouquet'";
        }
        if(isset($inputCCN) && $inputCCN!='')
        {
            $where1.=" AND (c.custom_customer_no LIKE '$inputCCN' or s.stb_no LIKE '%$inputCCN%' or s.mac_id LIKE '%$inputCCN%')";
        }
	    if($temp1[0]['user_type']==9)
	    {
	       // echo "select ar.alacarte_req_id,c.cust_id,c.admin_id,c.custom_customer_no,s.stb_id,s.stb_no,s.mac_id,ar.dateCreated,(select group_name from groups where group_id=c.group_id) as gDescr from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 $where1 AND ar.dateCreated BETWEEN '$date1' AND '$date2' AND ar.sms_status=0";exit;
	        $query = $this->db->query("select ar.alacarte_req_id,c.cust_id,c.admin_id,c.custom_customer_no,s.stb_id,s.stb_no,s.mac_id,ar.dateCreated,(select group_name from groups where group_id=c.group_id) as gDescr from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 $where1 AND ar.dateCreated BETWEEN '$date1' AND '$date2' AND ar.sms_status=0")->result_array();
	    }
	    else
	    {
		    $query = $this->db->query("select ar.alacarte_req_id,c.cust_id,c.admin_id,c.custom_customer_no,s.stb_id,s.stb_no,s.mac_id,ar.dateCreated,(select group_name from groups where group_id=c.group_id) as gDescr from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 $where1 AND ar.dateCreated BETWEEN '$date1' AND '$date2' AND ar.sms_status=0")->result_array();
	    }
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_alacarte_req_pending($cust_id=NULL,$stb_id=NULL,$req_id=NULL) {
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_descr from alacarte_request ar left join alacarte_channels ac ON ar.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.ala_ch_id!='' AND ar.alacarte_req_id='$req_id' order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet_req_pending($cust_id=NULL,$stb_id=NULL,$req_id=NULL) {
		$query = $this->db->query("select ar.pack_id,p.package_name,p.package_description from alacarte_request ar left join packages p ON ar.pack_id=p.package_id where p.isbase != 'Yes' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.pack_id!='' AND ar.alacarte_req_id='$req_id' order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_ala_approved_log() {
	    extract($_REQUEST);
	    $adminId=$this->session->userdata('admin_id');
	    $emp_id=$this->session->userdata('emp_id');
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
	    $date=date("Y-m-01");
	    $where1="";
	    if(isset($inputLco) && $inputLco!='')
	    {
	        $where1.= " AND c.admin_id = '$inputLco'";
	    }
		if($user_type==9)
		{
			$qry =  "select ar.alacarte_req_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empFname from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 AND ar.sms_status=1 AND c.cust_id!='' $where1";
		}
		elseif($user_type==1)
		{
			$qry =  "select ar.alacarte_req_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empFname from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 AND c.admin_id='$admin_id' AND ar.sms_status=1 AND c.cust_id!=''";
		}
		else
		{
			$qry =  "select ar.alacarte_req_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empFname from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 AND c.admin_id='$admin_id' AND ar.sms_status=1 AND c.cust_id!=''";
		}
		if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
		{
			$org_fromdate=strtotime($fromdate);
			$from_date=date("Y-m-d H:i:s",$org_fromdate);
			$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
			$to_date=date("Y-m-d H:i:s",$org_todate);	
			$qry.=" AND ar.dateCreated BETWEEN '$from_date' AND '$to_date'";
		}
		else
		{
		    $from_date=date("Y-m-01 00:00:00");
		    $to_date=date("Y-m-31 23:59:00");
		    $qry.=" AND ar.dateCreated BETWEEN '$from_date' AND '$to_date'";
		}
		$query = $this->db->query($qry);
	    return $query->result_array();
	}
	
	public function get_ala_reject_log(){
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		    $date=date("Y-m-01");
		    $where1="";
		    if(isset($inputLco) && $inputLco!='')
		    {
		        $where1.= " AND c.admin_id = '$inputLco'";
		    }
			if($user_type==9)
			{
				$qry =  "select ar.alacarte_rej_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no from alacarte_reject ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 $where1";
			}
			elseif($user_type==1)
			{
				$qry =  "select ar.alacarte_rej_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no from alacarte_reject ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 AND c.admin_id='$admin_id'";
			}
			else
			{
				$qry =  "select ar.alacarte_rej_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no from alacarte_reject ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 AND c.admin_id='$admin_id'";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND ar.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			else
			{
			    $from_date=date("Y-m-01 00:00:00");
			    $to_date=date("Y-m-31 23:59:00");
			    $qry.=" AND ar.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			$query = $this->db->query($qry);			
		    return $query->result_array();
    }
    
    public function get_franchise_log(){
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
// 		if(isset($inputLco) && $inputLco!='')
// 		{
			if($user_type==9)
			{
			    $where1="";
			    if(isset($inputLco) && $inputLco!='')
        		{
			        $where1=" AND f.admin_id='$inputLco'";
        		}
				$qry =  "SELECT f.*,(select first_name from customers where cust_id=f.cust_id) as cFname,(select mac_id from set_top_boxes where cust_id=f.cust_id) as cMacId,(select stb_no from set_top_boxes where cust_id=f.cust_id) as cStbNo,(select custom_customer_no from customers where cust_id=f.cust_id) as custNo FROM f_accounting f where 1=1 $where1";
			}
			elseif($user_type==1)
			{
				$qry =  "SELECT f.*,(select first_name from customers where cust_id=f.cust_id) as cFname,(select mac_id from set_top_boxes where cust_id=f.cust_id) as cMacId,(select stb_no from set_top_boxes where cust_id=f.cust_id) as cStbNo,(select custom_customer_no from customers where cust_id=f.cust_id) as custNo FROM f_accounting f where 1=1 AND f.admin_id='$inputLco'";
			}
			else
			{
				$qry =  "SELECT f.*,(select first_name from customers where cust_id=f.cust_id) as cFname,(select mac_id from set_top_boxes where cust_id=f.cust_id) as cMacId,(select stb_no from set_top_boxes where cust_id=f.cust_id) as cStbNo,(select custom_customer_no from customers where cust_id=f.cust_id) as custNo FROM f_accounting f where 1=1 AND f.admin_id='$inputLco'";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND f.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			else
			{
			    $from_date=date("Y-m-01 00:00:00");
			    $to_date=date("Y-m-31 23:59:00");
			    $qry.=" AND f.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			if(isset($type) && $type!='')
			{
			    $qry.=" AND f.type='$type'";
			}
			$query = $this->db->query($qry);			
		    return $query->result_array();
// 		}
// 		else
// 		{
// 		    return 0;
// 		}
    }
    
    public function get_customer_renewals(){
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
			if($user_type==9)
			{
			    $where1="";
			    if(isset($inputLco) && $inputLco!='')
        		{
			        $where1=" AND cr.admin_id='$inputLco'";
        		}
				$qry =  "SELECT cr.*,(select first_name from customers where cust_id=cr.cust_id) as cFname,(select mac_id from set_top_boxes where cust_id=cr.cust_id) as cMacId,(select custom_customer_no from customers where cust_id=cr.cust_id) as custNo,(select group_name from groups where group_id=(select group_id from customers where cust_id=cr.cust_id)) as gName FROM customer_renewals cr where 1=1 $where1";
			}
			elseif($user_type==1)
			{
				$qry =  "SELECT cr.*,(select first_name from customers where cust_id=cr.cust_id) as cFname,(select mac_id from set_top_boxes where cust_id=cr.cust_id) as cMacId,(select custom_customer_no from customers where cust_id=cr.cust_id) as custNo,(select group_name from groups where group_id=(select group_id from customers where cust_id=cr.cust_id)) as gName FROM customer_renewals cr where 1=1 AND cr.admin_id='$inputLco'";
			}
			else
			{
				$qry =  "SELECT cr.*,(select first_name from customers where cust_id=cr.cust_id) as cFname,(select mac_id from set_top_boxes where cust_id=cr.cust_id) as cMacId,(select custom_customer_no from customers where cust_id=cr.cust_id) as custNo,(select group_name from groups where group_id=(select group_id from customers where cust_id=cr.cust_id)) as gName FROM customer_renewals cr where 1=1 AND cr.admin_id='$inputLco'";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND cr.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			else
			{
			    $from_date=date("Y-m-01 00:00:00");
			    $to_date=date("Y-m-31 23:59:00");
			    $qry.=" AND cr.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			$query = $this->db->query($qry);
		    return $query->result_array();
    }
    
    public function get_ala_remove_log(){
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		    $date=date("Y-m-01");
		    $where1="";
		    if(isset($inputLco) && $inputLco!='')
		    {
		        $where1.= " AND c.admin_id = '$inputLco'";
		    }
			if($user_type==9)
			{
				$qry =  "select ar.alacarte_remove_id,ar.removedOn,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select group_name from groups where group_id=c.group_id) as gName from alacarte_remove ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where 1 $where1";
			}
			elseif($user_type==1)
			{
				$qry =  "select ar.alacarte_remove_id,ar.removedOn,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select group_name from groups where group_id=c.group_id) as gName from alacarte_remove ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where c.admin_id='$admin_id'";
			}
			else
			{
				$qry =  "select ar.alacarte_remove_id,ar.removedOn,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select group_name from groups where group_id=c.group_id) as gName from alacarte_remove ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where c.admin_id='$admin_id'";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND ar.removedOn BETWEEN '$from_date' AND '$to_date'";
			}
			else
			{
			    $from_date=date("Y-m-01 00:00:00");
			    $to_date=date("Y-m-31 23:59:00");
			    $qry.=" AND ar.removedOn BETWEEN '$from_date' AND '$to_date'";
			}
			$query = $this->db->query($qry);			
		    return $query->result_array();
    }
    
    public function get_expenses($adminId=NULL)
    {
		extract($_REQUEST);
		$month=date('Y-m-00 00:00:00');
		$qry= "select * from expenses_inward_qty WHERE 1=1 AND admin_id='$adminId'";
		if((isset($receipt_date) && $receipt_date!='') && (isset($to_date) && $to_date!='')){
			$qry.=" AND receipt_date BETWEEN '$receipt_date' AND '$to_date'";
		} 
		else
		{
			$qry.=" AND receipt_date >= '$month'";
		}
		$query = $this->db->query($qry);
	    return $query->result_array();
    }
    
    public function get_all_cust_channels($emp_id)
    {
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select group_ids from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
	    $date=date("Y-m-01");
	    $where1="";
	    if(isset($inputLco) && $inputLco!='')
	    {
	        $where1.= " AND c.admin_id = '$inputLco'";
	    }
		if($user_type==9)
		{
			$qry =  "select ca.ca_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no from customer_alacarte ca left join customers c ON ca.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ca.stb_id where ca.ca_status=1 $where1";
		}
		elseif($user_type==1)
		{
			$qry =  "select ca.ca_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no from customer_alacarte ca left join customers c ON ca.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ca.stb_id where ca.ca_status=1 AND c.admin_id='$admin_id'";
		}
		else
		{
			$qry =  "select ca.ca_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.stb_no,s.mac_id,s.card_no from customer_alacarte ca left join customers c ON ca.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ca.stb_id where ca.ca_status=1 AND c.admin_id='$admin_id'";
		}
		if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
		{
			$org_fromdate=strtotime($fromdate);
			$from_date=date("Y-m-d H:i:s",$org_fromdate);
			$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
			$to_date=date("Y-m-d H:i:s",$org_todate);	
			$qry.=" AND ca.ca_date_created BETWEEN '$from_date' AND '$to_date'";
		}
		else
		{
		    $from_date=date("Y-m-01 00:00:00");
		    $to_date=date("Y-m-31 23:59:00");
		    $qry.=" AND ca.ca_date_created BETWEEN '$from_date' AND '$to_date'";
		}
		$query = $this->db->query($qry);			
	    return $query->result_array();
    }
	
	public function get_lco_wallet($emp_id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
			if($user_type==9)
			{
			    $where1="";
			    if(isset($inputLco) && $inputLco!='')
        		{
			        $where1=" AND f.admin_id='$inputLco'";
        		}
				$qry =  "SELECT f.*,a.balance,a.email,(select emp_first_name from employes_reg where emp_email=a.email) as empFname,(select emp_last_name from employes_reg where emp_email=a.email) as empLname,(select emp_mobile_no from employes_reg where emp_email=a.email) as empMobile FROM f_accounting f left join admin a ON f.admin_id=a.admin_id where 1=1 AND f.cust_id=0  AND f.admin_id!='' $where1";
			}
			else
			{
				$qry =  "SELECT f.*,a.balance,a.email,(select emp_first_name from employes_reg where emp_email=a.email) as empFname,(select emp_last_name from employes_reg where emp_email=a.email) as empLname,(select emp_mobile_no from employes_reg where emp_email=a.email) as empMobile FROM f_accounting f left join admin a ON f.admin_id=a.admin_id where 1=1 AND f.cust_id=0 $where1 AND f.admin_id='$inputLco'";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND f.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			else
			{
			    $from_date=date("Y-m-d 00:00:00");
			    $to_date=date("Y-m-d 23:59:00");
			    $qry.=" AND f.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			    $qry.=" AND f.type='credit'";
			$query = $this->db->query($qry);			
		    return $query->result_array();
    }
	
	public function get_lco_wallet_balance($emp_id)
	{
		extract($_REQUEST);
		$where1="";
		if(isset($inputLco) && $inputLco!='')
		{
			$where1=" AND a.admin_id='$inputLco'";
		}
		$qry =  "SELECT a.balance,a.email,(select emp_first_name from employes_reg where emp_email=a.email) as empFname,(select emp_last_name from employes_reg where emp_email=a.email) as empLname,(select emp_mobile_no from employes_reg where emp_email=a.email) as empMobile FROM admin a where 1=1 AND a.admin_id!='' AND a.admin_id!=1 $where1";
		$query = $this->db->query($qry);
		return $query->result_array();
    }
	
	public function get_cust_accounting_log()
	{
	    extract($_REQUEST);
	    $adminId=$this->session->userdata('admin_id');
	    $emp_id=$this->session->userdata('emp_id');
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
	    $date=date("Y-m-01");
	    $where1="";
	    if(isset($inputLco) && $inputLco!='')
	    {
	        $where1.= " AND c.admin_id = '$inputLco'";
	    }
		if($user_type==9)
		{
			$qry =  "select ca.*,c.stb_no,c.custom_customer_no,c.first_name from cust_accounting ca left join customers c ON ca.cust_id=c.cust_id where c.cust_id!='' $where1";
		}
		elseif($user_type==1)
		{
			$qry =  "select ca.*,c.stb_no,c.custom_customer_no,c.first_name from cust_accounting ca left join customers c ON ca.cust_id=c.cust_id where c.cust_id!='' AND c.admin_id='$admin_id'";
		}
		else
		{
			$qry =  "select ca.*,c.stb_no,c.custom_customer_no,c.first_name from cust_accounting ca left join customers c ON ca.cust_id=c.cust_id where c.cust_id!='' AND c.admin_id='$admin_id'";
		}
		if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
		{
			$org_fromdate=strtotime($fromdate);
			$from_date=date("Y-m-d H:i:s",$org_fromdate);
			$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
			$to_date=date("Y-m-d H:i:s",$org_todate);	
			$qry.=" AND ca.dateCreated BETWEEN '$from_date' AND '$to_date'";
		}
		else
		{
		    $from_date=date("Y-m-01 00:00:00");
		    $to_date=date("Y-m-31 23:59:00");
		    $qry.=" AND ca.dateCreated BETWEEN '$from_date' AND '$to_date'";
		}
		$query = $this->db->query($qry);
	    return $query->result_array();
	}
}