<?php 

class Empdeposit_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function save_employe_deposit()
	{
		extract($_REQUEST);
			$data = array(
				"emp_name" =>$inputempname,	 
				"depos_amount" => $inputdepositAmount,				
				"depos_date" => $inputdepositDate,
				"remarks" => $inputRemarks,								
			);
		$this->db->insert("employe_deposit", $data);
		return 1;

	}
	public function edit_empdeposit($id,$emp_id){
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
		$custQry=mysql_query("select emp_name AS EmployeeName, depos_amount AS DepositAmount, depos_date AS DepositDate, remarks AS Remarks from employe_deposit where emp_depos_id='$id'");
		$custRes=mysql_fetch_assoc($custQry);
		$getData=$_REQUEST;
		$path='empdeposit/empdeposit_updated/'.$id;
		unset($getData[$path]);
		unset($getData['ci_session']);
		unset($getData['customerSubmit']);
		$diffData=array_diff($getData,$custRes);
		// print_r($diffData);die;
		$logData='';
		foreach($diffData as $key=>$val){
			if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
				if($key=='EmployeeName'){
					$chkRes=mysql_fetch_assoc(mysql_query("SELECT emp_first_name FROM employes_reg WHERE emp_id=$val"));
					$oldRes=mysql_fetch_assoc(mysql_query("SELECT emp_first_name FROM employes_reg WHERE emp_id=$old"));
					$logData.=$key." : ".$oldRes['emp_first_name']." changed as ".$chkRes['emp_first_name'].", ";
				}else{
					$logData.=$key." : ".$old." changed as ".$val.", ";
				}
		}
		$newLogData= rtrim($logData,",");
		// echo $newLogData;die;
			if($newLogData!="")
			{
				$data1 = array(
					"emp_id" => $emp_id,
					"category" => "Deposit Edit",
					"ipaddress" => $ipaddress,
					"log_text" => $newLogData,
					"dateCreated" => date("Y-m-d H:i:s")
				);
				$this->db->insert("change_log", $data1);
			}		
		
		extract($_REQUEST); 
 		$data = array(
				"emp_name" =>$EmployeeName,	 
				"depos_amount" => $DepositAmount,				
				"depos_date" => $DepositDate,
				"remarks" => $Remarks,		
			);
		$this->db->where('emp_depos_id', $id);
		$this->db->update('employe_deposit', $data);
	}
	
	public function get_employe_deposit($id = NULL) {
		extract($_REQUEST);
		if((isset($emp_first_name) && $emp_first_name!=''))
		{
			$emp_qry=mysql_query("select * from employes_reg where emp_first_name='$emp_first_name'");
			$emp_res=mysql_fetch_assoc($emp_qry);
			$emp_ID=$emp_res['emp_id'];
			$query = $this->db->query("select * from employe_deposit where emp_name='$emp_ID'");
		}
		else
		{
			$query = $this->db->query("select * from employe_deposit");
		}
        //echo $query;exit;
        return $query->result_array();
    }
	public function get_empdeposit_by_id($id = NULL) {
        $query = $this->db->query("select * from employe_deposit where emp_depos_id = $id ");
        //echo $query;exit;
        return $query->result_array();
    }
	
	 function empdeposit_del($id) {
        $this->load->database();
        return $this->db->delete('employe_deposit', array('emp_depos_id' => $id));
    }

}