<?php 
class Expenses_inward_qty_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	public function save()
	{ 
			//print_r($_REQUEST); die;
			extract($_REQUEST);
			$adminId= $this->session->userdata('admin_id');
			//	echo "select * from expenses_inward_qty where exp_id=$exp_id"; die;
			//$chkSql=mysql_query("select * from expenses_inward_qty where exp_id=$exp_id");
			//$chkCnt=mysql_num_rows($chkSql);
 			//if($chkCnt >0 ){
			//	$chkQty=mysql_fetch_assoc($chkSql);
				//print_r($chkQty);die;
			//	$inwardQty=$chkQty['inward_qty'] + $inward_qty;
 			//		$data = array( 
			//			"inward_qty" => $inwardQty,	
			//		);
			//		$this->db->where('exp_id', $exp_id);
			//		$this->db->update('expenses_inward_qty', $data);

			//	}
			//else{
				$data = array(
					"exp_id" => $exp_id,
					"admin_id" => $adminId,
					"inward_qty" => $inward_qty,
					"receipt_no" => $receipt_no,
					"receipt_date" => $receipt_date,
					"remarks" => $remarks,
					"dateCreated" => date('Y-m-d H:i:s')
				);
				$this->db->insert("expenses_inward_qty", $data);
			//}
		return 1;
	}
	
	public function edit($id,$REQUEST,$emp_id){
		$adminId= $this->session->userdata('admin_id');
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
			
		$custQry=mysql_query("SELECT * FROM expenses_inward_qty where exp_inv_id='$id'");
		$custRes=mysql_fetch_assoc($custQry);
		$getData=$_REQUEST;
		$path='expenses_inward/expenses_inward_updated/'.$id;
		unset($getData[$path]);
		unset($getData['expenseSubmit']);
		unset($getData['ci_session']);
		$diffData=array_diff($getData,$custRes);
		$logData='';
		foreach($diffData as $key=>$val){
			if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
			if($key=='exp_id'){
					$newRes=mysql_fetch_assoc(mysql_query("SELECT name FROM expenses_items WHERE exp_id=$val"));
					$oldRes=mysql_fetch_assoc(mysql_query("SELECT name FROM expenses_items WHERE exp_id=$old"));
					$logData.=$key." : ".$oldRes['name']." changed as ".$newRes['name']." , ";
				}
				else
				{
					$logData.=$key." : ".$old." changed as ".$val." , ";
				}
		}
		$newLogData= rtrim($logData, ",");
			
			if($newLogData!="")
			{
				$data1 = array(
					"emp_id" => $emp_id,
					"admin_id" => $adminId,
					"category" => "Expenses Edit",
					"ipaddress" => $ipaddress,
					"log_text" => $newLogData,
					"dateCreated" => date("Y-m-d H:i:s")
				);
				$this->db->insert("change_log", $data1);
			}	
		
		extract($REQUEST);
 		$data = array(
				"exp_id" => $exp_id,
				"inward_qty" => $inward_qty,
				"receipt_no" => $receipt_no,
				"receipt_date" => $receipt_date,
				"remarks" => $remarks,
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->where('exp_inv_id', $id);
		$this->db->where('admin_id', $adminId);
		$this->db->update('expenses_inward_qty', $data);
	}
	
 	public function get($id = NULL) {
		$adminId= $this->session->userdata('admin_id');
		$month=date('Y-m-0');
	//	echo "select * from expenses_inward_qty where admin_id='$adminId' AND receipt_date >= '$month' ORDER BY receipt_date ASC ";
        $query = $this->db->query("select * from expenses_inward_qty where admin_id='$adminId' AND receipt_date >= '$month' ORDER BY receipt_no DESC ");
        return $query->result_array();
    }
 
	public function get_by_id($id = NULL) {
		$adminId= $this->session->userdata('admin_id');
        $query = $this->db->query("select * from expenses_inward_qty where exp_inv_id = $id AND admin_id='$adminId'");
        return $query->result_array();
    }
	
	public function del($id = NULL,$emp_id) {
		$adminId= $this->session->userdata('admin_id');
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
			
			$expQry=mysql_query("SELECT * FROM expenses_inward_qty where exp_inv_id= $id ");
			$expRes=mysql_fetch_assoc($expQry);
			$data1 = array(
				"emp_id" => $emp_id,
				"admin_id" => $adminId,
				"category" => "Expense Delete",
				"ipaddress" => $ipaddress,
				"log_text" => "Expenses of Rs. ".$expRes['inward_qty']." /- deleted.",
				"dateCreated" => date("Y-m-d H:i:s")
			);
		$this->db->insert("change_log", $data1);
		
	    $query = $this->db->query("DELETE FROM expenses_inward_qty WHERE exp_inv_id = $id AND admin_id='$adminId'");
        return true;
    }
}