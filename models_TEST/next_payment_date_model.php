<?php 
class Next_payment_date_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function get_next_payment_date_list()
	{
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
			if($chkEmpType==1)
			{
				$today=date("Y-m-d");
				$qry =  "select * from next_payment_date where 1=1";
			}
			else
			{
				$today=date("Y-m-d");
				$qry = "select * from next_payment_date where 1=1";
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
				$qry.=" AND next_pay_date BETWEEN '$fromdate' AND '$todate'";
			}
			else
			{
				$qry.=" AND next_pay_date = '$today'";
			}
				// $qry.= " limit ". $start . ", " . $limit;
				// echo $qry;
			$query = $this->db->query($qry);			
	    return $query->result_array();
	}
	
}