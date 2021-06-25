<?php 
class User_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function user_email_exists($email,$mobile) {
		$this->db->select('emp_id');
			$this->db->where("(emp_email='$email' OR emp_mobile_no='$mobile')", NULL, FALSE);
			$query = $this->db->get('employes_reg');
			if ($query->num_rows() > 0) {
				 return $query->result_array();
			} else {
				return 0;
			}
	}
	
	public function user_mobile_exists($mobile) {
		$this->db->select('emp_id');
			$this->db->where('emp_mobile_no', $mobile);
			$query = $this->db->get('employes_reg');
			if ($query->num_rows() > 0) {
				return 1;
			} else {
				return 0;
			}
	}
	
	public function save_user($REQUEST,$emp_id,$lco=NULL)
	{
		extract($_REQUEST);
		$genPwd=rand(100000,999999);
		if($lco!='')
		{
			$adminId= $lco;
		}
		else
		{
			$adminId= $this->session->userdata('admin_id');
		}
	 	$data = array(
			"admin_id" => $adminId,
			"emp_first_name" => $inputFname,
			"emp_last_name" => $inputLname, 
			"emp_add1" => $inputAddr1,
			"emp_add2" => $inputAddr2,
			"emp_add3" => $inputAddr3,
			"emp_city" => $inputCity,
			"emp_pin_code" => $inputPincode,
			"emp_email" => $inputEmail,
			"emp_phone_no" => $inputPhone,
			"emp_mobile_no" => $inputMobile,
			"user_type" => $inputusertype,
			"user_role" => $inputuserrole,
			"emp_password" => $inputMobile,
			"date_created" => date('Y-m-d H:i:s'),
			"status" => 1,
			"inactive_date" =>0	
		);
		if(isset($_REQUEST['lco_portal_url']) && $_REQUEST['lco_portal_url']!='')
		{
		    $data['lco_portal_url'] = $_REQUEST['lco_portal_url'];
		}
		if(isset($_REQUEST['lco_username']) && $_REQUEST['lco_username']!='')
		{
		    $data['lco_username'] = $_REQUEST['lco_username'];
		}
		if(isset($_REQUEST['lco_password']) && $_REQUEST['lco_password']!='')
		{
		    $data['lco_password'] = $_REQUEST['lco_password'];
		}
		$this->db->insert("employes_reg", $data);
		$id = $this->db->insert_id();
		
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
			"emp_id" => $emp_id,
			"admin_id" => $adminId,
			"category" => "New Employee",
			"ipaddress" => $ipaddress,
			// "log_text" => $inputFname." ( ".$inputMobile." ) new user created. Details are Name :".$inputFname." ".$inputLname.", Address :".$inputAddr1." ".$inputAddr2." ".$inputAddr3.", City :".$inputCity.", Email ID :".$inputEmail.", and Password :".$genPwd.".",
			"log_text" => " New employee created with Role : ".$inputuserrole." .",
			"dateCreated" => date("Y-m-d H:i:s")
		);
		$this->db->insert("change_log", $data1);
		// Send SMS
		$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer"));
		if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendservicesmsemployee']=='Yes'))
		{
			// Send SMS
			$mess = urlencode("Your Login details for ".base_url()." are - Email: ".$inputEmail. " password: ".$inputMobile);
			$url = $resSmsPrefer['sms_api_url']."&number=".$inputMobile."&message=" . $mess;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
			curl_close ($ch);		
		}
		$data = array(
			"emp_id" => $id,
		);
		$this->db->insert("emp_access_control", $data);
		return $id;
	}
	
	public function edit_user($id = NULL,$emp_id,$REQUEST)
	{
		$email=$REQUEST['inputEmail'];
		$mobile=$REQUEST['inputMobile'];
		if($id!='')
		{
    		$query_sel = $this->db->query("select * from employes_reg where emp_id = $id ");
    		$res=$query_sel->result_array();
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
		
		if($res[0]['emp_email']==$email)
		{
			if($res[0]['emp_mobile_no']==$mobile)
			{
				$custQry=mysql_query("SELECT * FROM employes_reg where emp_id='$id'");
				$custRes=mysql_fetch_assoc($custQry);
				$getData=$_REQUEST;
				unset($getData['ci_session']);
				$diffData=array_diff($getData,$custRes);
				$logData='';
				foreach($diffData as $key=>$val){
					if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
						if($key=='GroupName'){
							$chkGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$val"));
							$oldGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$old"));
							$logData.=$key." : ".$oldGrp['group_name']." changed as ".$chkGrp['group_name'].", ";
						}else{
							$logData.=$key." : ".$old." changed as ".$val.",";
						}
				};
				$newLogData= rtrim($logData, ",");
				// echo $newLogData;die;
				if($newLogData!="")
				{
					$data2 = array(
						"emp_id" => $emp_id,
						"admin_id" => $admin_id,
						"category" => "Employee Edit",
						"ipaddress" => $ipaddress,
						"log_text" => $custRes['emp_first_name']." ( ".$custRes['emp_mobile_no']." ) Details of ".$newLogData,
						"dateCreated" => date("Y-m-d H:i:s")
					);
					$this->db->insert("change_log", $data2);
				}
				$data = array(
					"emp_first_name" => $REQUEST['inputFname'],
					"emp_last_name" => $REQUEST['inputLname'], 
					"emp_add1" => $REQUEST['inputAddr1'], 
					"emp_add2" => $REQUEST['inputAddr2'], 
					"emp_add3" => $REQUEST['inputAddr3'], 
					"emp_city" => $REQUEST['inputCity'], 
					"emp_pin_code" => $REQUEST['inputPincode'], 
					"emp_email" => $REQUEST['inputEmail'],
					"emp_phone_no" => $REQUEST['inputPhone'],
					"emp_mobile_no" => $REQUEST['inputMobile'],				
					"user_type" => $REQUEST['inputusertype'],
					"user_role" => $REQUEST['inputuserrole']
    				);
    			if(isset($_REQUEST['lco_portal_url']) && $_REQUEST['lco_portal_url']!='')
        		{
        		    $data['lco_portal_url'] = $_REQUEST['lco_portal_url'];
        		}
        		if(isset($_REQUEST['lco_username']) && $_REQUEST['lco_username']!='')
        		{
        		    $data['lco_username'] = $_REQUEST['lco_username'];
        		}
        		if(isset($_REQUEST['lco_password']) && $_REQUEST['lco_password']!='')
        		{
        		    $data['lco_password'] = $_REQUEST['lco_password'];
        		}
    			$this->db->where('emp_id', $id);
    			$this->db->update('employes_reg', $data);
			}
			else
			{
				// Email Check
				$this->db->select('emp_id');
				$this->db->where('emp_mobile_no',$mobile);
				//$this->db->where("(emp_email1='$email' OR emp_mobile_no='$mobile')", NULL, FALSE);
				$query = $this->db->get('employes_reg');
				if($query->num_rows() > 0){
					return $query->result_array();
				}
				else{
					$custQry=mysql_query("SELECT * FROM employes_reg where emp_id='$id'");
					$custRes=mysql_fetch_assoc($custQry);
					$getData=$_REQUEST;
					unset($getData['ci_session']);
					$diffData=array_diff($getData,$custRes);
					
					$logData='';
					foreach($diffData as $key=>$val){
						if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
							if($key=='GroupName'){
								$chkGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$val"));
								$oldGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$old"));
								$logData.=$key." : ".$oldGrp['group_name']." changed as ".$chkGrp['group_name'].", ";
							}else{
								$logData.=$key." : ".$old." changed as ".$val.",";
							}
					};
					$newLogData= rtrim($logData, ",");
					// echo $newLogData;die;
					if($newLogData!="")
					{
						$data1 = array(
							"emp_id" => $emp_id,
							"category" => "Employee Edit",
							"ipaddress" => $ipaddress,
							"log_text" => $custRes['emp_first_name']." ( ".$custRes['emp_mobile_no']." ) Details of ".$newLogData,
							"dateCreated" => date("Y-m-d H:i:s")
						);
						$this->db->insert("change_log", $data1);
					}
					
					$data = array(
							"emp_first_name" => $REQUEST['inputFname'],
							"emp_last_name" => $REQUEST['inputLname'], 
							"emp_add1" => $REQUEST['inputAddr1'], 
							"emp_add2" => $REQUEST['inputAddr2'], 
							"emp_add3" => $REQUEST['inputAddr3'], 
							"emp_city" => $REQUEST['inputCity'], 
							"emp_pin_code" => $REQUEST['inputPincode'], 
							"emp_email" => $REQUEST['inputEmail'],
							"emp_phone_no" => $REQUEST['inputPhone'],
							"emp_mobile_no" => $REQUEST['inputMobile'],				
							"user_type" => $REQUEST['inputusertype'],
							"user_role" => $REQUEST['inputuserrole'],
							// "date_created" => date('Y-m-d H:i:s'),
							// "status" => 1,
							// "inactive_date" =>0
						);
					$this->db->where('emp_id', $id);
					$this->db->update('employes_reg', $data);
				}
			}
		}else{
			// Email Check
			$this->db->select('emp_id');
			$this->db->where('emp_email', $email);
			//$this->db->where("(emp_email1='$email' OR emp_mobile_no='$mobile')", NULL, FALSE);
			$query = $this->db->get('employes_reg');
			if($query->num_rows() > 0){
				return $query->result_array();
			}
			else{ 
				$custQry=mysql_query("SELECT * FROM employes_reg where emp_id='$id'");
				$custRes=mysql_fetch_assoc($custQry);
				$getData=$_REQUEST;
				unset($getData['ci_session']);
				$diffData=array_diff($getData,$custRes);			
				$logData='';
				foreach($diffData as $key=>$val){
					if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
						if($key=='GroupName'){
							$chkGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$val"));
							$oldGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$old"));
							$logData.=$key." : ".$oldGrp['group_name']." changed as ".$chkGrp['group_name'].", ";
						}else{
							$logData.=$key." : ".$old." changed as ".$val.",";
						}
				};
				$newLogData= rtrim($logData, ",");
				// echo $newLogData;die;
				if($newLogData!="")
				{
					$data1 = array(
						"emp_id" => $emp_id,
						"category" => "Employee Edit",
						"ipaddress" => $ipaddress,
						"log_text" => $custRes['emp_first_name']." ( ".$custRes['emp_mobile_no']." ) Details of ".$newLogData,
						"dateCreated" => date("Y-m-d H:i:s")
					);
					$this->db->insert("change_log", $data1);
				}			
					$data = array(
							"emp_first_name" => $REQUEST['inputFname'],
							"emp_last_name" => $REQUEST['inputLname'], 
							"emp_add1" => $REQUEST['inputAddr1'], 
							"emp_add2" => $REQUEST['inputAddr2'], 
							"emp_add3" => $REQUEST['inputAddr3'], 
							"emp_city" => $REQUEST['inputCity'], 
							"emp_pin_code" => $REQUEST['inputPincode'], 
							"emp_email" => $REQUEST['inputEmail'],
							"emp_phone_no" => $REQUEST['inputPhone'],
							"emp_mobile_no" => $REQUEST['inputMobile'],				
							"user_type" => $REQUEST['inputusertype'],
							"user_role" => $REQUEST['inputuserrole'],
							"date_created" => date('Y-m-d H:i:s'),			
							"status" => 1,
							"inactive_date" =>0	
						);
					$this->db->where('emp_id', $id);
					$this->db->update('employes_reg', $data);
			}
		}
		}
	}
	
	public function emp_access_edit($emp_id=NULL)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM employes_reg WHERE emp_id=$access_emp_id"));
		//echo $resCust['admin_id'];die;
		if(($resCust['admin_id']==$admin_id) || ($user_type==9))
		{
			// print_r($REQUEST);
			$data = array(
					"emp_id" => $access_emp_id,
					"custA" => $custA,
					"custE" => $custE,
					"custV" => $custV,
					"custD" => $custD,
					"packageA" => $packageA,
					"packageE" => $packageE,
					"packageV" => $packageV,
					"packageD" => $packageD,
					"complA" => $complA,
					"complE" => $complE,
					"complV" => $complV,
					"complD" => $complD,
					"gropusA" => $gropusA,
					"gropusE" => $gropusE,
					"gropusV" => $gropusV,
					"gropusD" => $gropusD,
					"invA" => $invA,
					"invE" => $invE,
					"invV" => $invV,
					"invD" => $invD,
					"usersA" => $usersA,
					"usersE" => $usersE,
					"usersV" => $usersV,
					"usersD" => $usersD,
					"settingsA" => $settingsA,
					"settingsE" => $settingsE,
					"settingsV" => $settingsV,
					"settingsD" => $settingsD,
					"paymentsA" => $paymentsA,
					"paymentsE" => $paymentsE,
					"paymentsV" => $paymentsV,
					"paymentsD" => $paymentsD,
					"empdepositeA" => $empdepositeA,
					"empdepositeE" => $empdepositeE,
					"empdepositeV" => $empdepositeV,
					"empdepositeD" => $empdepositeD,
					"dealerinvA" => $dealerinvA,
					"dealerinvE" => $dealerinvE,
					"dealerinvV" => $dealerinvV,
					"dealerinvD" => $dealerinvD,
					"empinvA" => $empinvA,
					"empinvE" => $empinvE,
					"empinvV" => $empinvV,
					"empinvD" => $empinvD,
					"indentA" => $indentA,
					"indentE" => $indentE,
					"indentV" => $indentV,
					"indentD" => $indentD,
					"resetPwd" => $resetPwd
					
			);
			$this->db->where('emp_id', $access_emp_id);
			$this->db->update('emp_access_control', $data);
		}
	}

	public function emp_group_save($emp_id=NULL)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM employes_reg WHERE emp_id=$assign_emp_id"));
		if($resCust['admin_id']==$chkEmpType['admin_id'])
		{
			$chkGrp=mysql_query("select * from emp_to_group where emp_id=$assign_emp_id");
			$cntGrp=mysql_num_rows($chkGrp);
			if($cntGrp <= 0){
					$group_ids=implode(",",$grp);		
					$data = array(
							"group_ids" => $group_ids,
							"emp_id" => $assign_emp_id
					);
					$this->db->insert("emp_to_group", $data);
				}else{
					$group_ids=implode(",",$grp);	
					$data = array(
						"group_ids" => $group_ids,
						"emp_id" => $assign_emp_id
					);
					$this->db->where('emp_id', $assign_emp_id);
					$this->db->update('emp_to_group', $data);
				}
		}
		elseif($user_type==9)
		{
		    $chkGrp=mysql_query("select * from emp_to_group where emp_id=$assign_emp_id");
			$cntGrp=mysql_num_rows($chkGrp);
			if($cntGrp <= 0){
				$group_ids=implode(",",$grp);		
				$data = array(
						"group_ids" => $group_ids,
						"emp_id" => $assign_emp_id
				);
				$this->db->insert("emp_to_group", $data);
			}
			else{
				$group_ids=implode(",",$grp);	
				$data = array(
					"group_ids" => $group_ids,
					"emp_id" => $assign_emp_id
				);
				$this->db->where('emp_id', $assign_emp_id);
				$this->db->update('emp_to_group', $data);
			}
		}
	}
	
	public function change_password()
	{
		extract($_REQUEST); 
		$chkPass=mysql_query("select * from employes_reg where emp_id=$emp_id AND emp_password='$old_password' ");
		$cntPass=mysql_num_rows($chkPass);  
		if($cntPass <= 0){
			return 0;
		}else{ 
			$data = array(
				"emp_password" => $new_password,
				);
			$this->db->where('emp_id', $emp_id);
			$this->db->update('employes_reg', $data);
			return 1; 
		}
	}	
	
	public function get_users($id = NULL)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM employes_reg WHERE admin_id=$id"));
		if($user_type==9)
		{
			$qry="select * from employes_reg where user_type!=9 AND emp_email IN (SELECT email from admin)";
		}
		else
		{
			$qry="select * from employes_reg where admin_id='$admin_id' AND user_type!=9";
		}
		if(isset($emp_first_name) && $emp_first_name!='')
		{
			$qry.= " AND emp_first_name LIKE '%$emp_first_name%' OR emp_last_name LIKE '%$emp_first_name%' ";
		}
		if(isset($mobile) && $mobile!='')
		{
			$qry.= " AND emp_mobile_no='$emp_mobile_no'";
		}
		if(isset($type) && $type!='')
		{
			$qry.= " AND user_type='$type'";
		}
		$qry.= " AND status=1";
		$query = $this->db->query($qry);
        return $query->result_array();
    }
	
	public function get_users_by_id($id = NULL,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id,emp_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			$query = $this->db->query("select * from employes_reg where emp_id = $id ");
			return $query->result_array();
		}
		else
		{
			$query = $this->db->query("select * from employes_reg where emp_id = $id AND admin_id='$admin_id' AND emp_id!='12'");
			return $query->result_array();
		}
    }
	
	public function get_users_access_id($id=NULL,$emp_id=NULL)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM employes_reg WHERE emp_id=$id"));
		if(($resCust['admin_id']==$admin_id) || ($user_type==9))
		{
			$query = $this->db->query("select * from emp_access_control where emp_id = $id ");
			return $query->result_array();
		}
    }
	
	public function inactive_user_by_id($id = NULL,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resUser=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM employes_reg WHERE emp_id=$id"));
		if($resUser['admin_id']==$admin_id)
		{
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
			$empRes=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id='$id'"));
			$data1 = array(
				"emp_id" => $emp_id,
				"category" => "Employee Inactivate",
				"ipaddress" => $ipaddress,
				"log_text" => $empRes['emp_first_name']." ( ".$empRes['emp_mobile_no']." ) has been Inactivated.",
				"dateCreated" => date("Y-m-d H:i:s")
			);
			$this->db->insert("change_log", $data1);	
			
			$data = array( 
					"status" => 0,					
					"inactive_date" => date('Y-m-d H:i:s')
			);
			$this->db->where('emp_id', $id);
			$this->db->update('employes_reg', $data);
			return 1;
		}
		else
		{
			return 0;
		}
    }
	
	public function reset_password($id,$emp_id)
	{
		$adminId= $this->session->userdata('admin_id');
		$chkPass=mysql_query("select * from employes_reg where emp_id=$id");
		$res=mysql_fetch_assoc($chkPass);
		$cntPass=mysql_num_rows($chkPass);
		$inputEmail=$res['emp_email'];
		$inputMobile=$res['emp_mobile_no'];
		if($cntPass <= 0){
			return 0;
		}else{
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
					"emp_id" => $emp_id,
					"category" => "Employee Password Reset",
					"ipaddress" => $ipaddress,
					"log_text" => "Password reset for Employee Name : ".$res['emp_first_name']." with mobile : ".$res['emp_mobile_no'].".",
					"dateCreated" => date("Y-m-d H:i:s")
				);
				$this->db->insert("change_log", $data1);
			
			$genPwd=rand(100000,999999);
			
			$data = array(
				"emp_password" => $genPwd,
			);
			$this->db->where('emp_id', $id);
			$this->db->update('employes_reg', $data);
			$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer where id=1"));
			// Send SMS
			if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendservicesmsemployee']=='Yes'))
			{	
				$mess = urlencode("Your Login details for ".base_url()." are - Email: ".$inputEmail. " password: ".$genPwd);
				$url = $resSmsPrefer['sms_api_url']."&number=".$inputMobile."&message=".$mess;
				// echo $url;exit;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
				curl_close ($ch);
			}
			return 1; 
		}
    }
	
	public function save_lco($emp_id=NULL)
	{
		extract($_REQUEST);
		$data1 = array(
			"created_by" => $emp_id,
			"email" => $inputEmail,
			"pwd" => '1234567890',
			"dateCreated" => date("Y-m-d H:i:s")
		);
		$this->db->insert("admin", $data1);
		$admin_id=$this->db->insert_id();
		return $admin_id;
	}
	
	public function save_operator_packages($admin_id=NULL)
	{
		if($admin_id!='')
		{
		    $packages = $this->db->query("select package_id,package_name,package_price,package_tax2 from packages")->result_array();
		    foreach($packages as $key => $package)
		    {
    		    $data = array(
        			"package_id" => $package['package_id'],
        			"admin_id" => $admin_id,
        			"package_name" => $package['package_name'],
        			"cust_price" => $package['package_price'],
        			"lco_price" => $package['package_tax2'],
        			"created_at" => date("Y-m-d H:i:s")
        		);
        		$this->db->insert("operator_packages", $data);
		    }
		}
		return true;
	}
	
	public function get_credentials($admin_id=NULL)
	{
		$query = $this->db->query("select * from credentials where admin_id = '$admin_id'");
		$res = $query->result_array();
		return $res;
    }
    
    public function save_credentials($admin_id=NULL)
	{
	    extract($_POST);
		if($admin_id!='')
		{
		    $checkCredential = $this->db->query("select * from credentials where user_name='$user_name'")->result_array();
		    if(count($checkCredential)==0)
		    {
    		    $data = array(
        			"admin_id" => $admin_id,
					"portal_url" => 'https://lcoportal.nxtdigital.in/login.php',
        			"user_name" => $user_name,
        			"password" => $password,
        			"created_at" => date("Y-m-d H:i:s")
        		);
        		$this->db->insert("credentials", $data);
        		return true;
		    }
		    else
		    {
		        return false;
		    }
		}
	}
	
	public function update_credentials($admin_id=NULL)
	{
		if($admin_id!='')
		{
	        extract($_POST);
		    $checkCredential = $this->db->query("select * from credentials where crd_id='$crd_id'")->result_array();
		    if(count($checkCredential)>=1)
		    {
    		    $data2 = array(
        			"user_name" => $user_name,
        			"password" => $password,
        			"updated_at" => date("Y-m-d H:i:s")
        		);
        		$this->db->where("crd_id",$crd_id);
        		$this->db->update("credentials",$data2);
        		return true;
		    }
		    else
		    {
		        return false;
		    }
		}
	}
	
	public function get_credentials_by_id($crd_id=NULL,$admin_id=NULL)
	{
		$query = $this->db->query("select * from credentials where crd_id = '$crd_id'");
		$res = $query->result_array();
		if(count($res)>0)
		{
		    return $res[0];
		}
	    return false;
    }
}