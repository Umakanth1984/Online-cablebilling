<?php
class Customer_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	public function customer_no_exists($ccno,$admin_id=NULL)
	{
		$this->db->select('cust_id');
		$this->db->where('custom_customer_no', $ccno);
		if($admin_id!='')
		{
			$this->db->where('admin_id', $admin_id);
		}
		$query = $this->db->get('customers');
		if ($query->num_rows() > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function customer_mobile_exists($mobile)
	{
		$this->db->select('cust_id');
		$this->db->where('mobile_no', $mobile);
		$query = $this->db->get('customers');
		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}
	
	public function save_customer()
	{
		extract($_REQUEST);
		$adminId=$this->session->userdata('admin_id');
		$grpInfo=mysql_fetch_assoc(mysql_query("select admin_id,group_name from groups where group_id=".$inputGroup));
// 	 	$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
// 		$sel_price=mysql_fetch_assoc($qry_price);
		if($inputPhone == ''){$phone=0;}else{$phone=$inputPhone;}
		if($inputDOB == ''){$dob1=0;}else{$dob1=$inputDOB;}
		if($inputAnniDate == ''){$adate=0;}else{$adate=$inputAnniDate;}
		if($Endingdate == ''){$endDate=0;}else{$endDate=$Endingdate;}
		// Multiple Packs
		$mPacks=implode (",", $inputPackage);
		$multiMso=implode (",", $mso);
		$mStb=implode (",", $stb_no);
		$mMac=implode (",", $mac_id);
		$mCard=implode (",", $card_no);
		$maadharCard=implode (",", $aadhar_card_no);
		if(isset($lco_id) && $lco_id!='')
		{
		    $adminId = $lco_id;
		}
		$mac_id = "0";
	    $data = array(
			"admin_id" => $adminId,
			"first_name" =>$inputFname,
			"last_name" =>$inputLname,
			"addr1" => $inputAddr1,
			"addr2" => $inputAddr2,
			"city" => $inputCity,
			"pin_code" => $inputPincode,
			"country" => $inputCountry,
			"state" => $inputState,
			"phone_no" => $phone,
			"mobile_no" => $inputMobile,
			"pwd" => $inputMobile,
			"email_id" => $inputEmail,
			"install_charge" => $install_charge,
			"custom_customer_no" => $inputCCN,
			"group_id" => $inputGroup,
			"package_id" =>'1',
			"stb_no" => $stb_no,
			"mac_id" => $mac_id,
			"card_no" => $card_no,
			"connection_date" => $connectionDate,
			"dob" => "0000-00-00",
			"anniversary_date" => "0000-00-00",
			"remarks" => $inputRemarks,
			"amount" => $inputAmount,
			"pending_amount" => $inputAmount,
			"tax_rate" => $inputTaxRate,
			"start_date" => $startDate,
			"end_date" => $endDate,
			"status" => 1,
			"dateCreated" => date('Y-m-d H:i:s'),
			"inactive_date"=>0
		);
		if(isset($crd_id) && $crd_id!='')
		{
		    $data['crd_id'] = $crd_id;
		    $getCrdInfo = $this->db->query("select * from credentials where crd_id='$crd_id'")->row_array();
		    $data['lco_portal_url'] = $getCrdInfo['portal_url'];
		    $data['lco_username'] = $getCrdInfo['user_name'];
		    $data['lco_password'] = $getCrdInfo['password'];
		}
		$this->db->insert("customers", $data);
		$inserted_cust_id = $this->db->insert_id();
		$packData = array(
			"cust_id" => $inserted_cust_id,
			"mso_id" => 1,
			"pack_id" => 1,
			"mac_id" => $mac_id,
			"stb_no" => $stb_no,
			"card_no" => $card_no,
			"aadhar_card_no" => "0",
			"dateCreated" => date('Y-m-d H:i:s')
		);
		$this->db->insert("customer_packs", $packData);
		$dt=date('Y-m-d H:i:s');
		$check1=$this->db->query("select stb_no from set_top_boxes where stb_no like '$stb_no'")->num_rows();
        // if($check1==0)
        // {
            $insQ=$this->db->query("INSERT INTO set_top_boxes(`cust_id`, `stb_no`, `card_no`, `mac_id`, `aadhar_no`, `pack_id`, `mso_id`, `date_created`) VALUES ('$inserted_cust_id','$stb_no','$card_no','$mac_id','0','1','1','$dt')");
        // }
			return 1;
	}
	
	public function edit_customer($id,$REQUEST,$emp_id)
	{
 		extract($REQUEST);
		// print_r($_REQUEST);exit;
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id=$id"));
		if($resCust['admin_id']==$admin_id || $user_type==9)
		{
			if(($REQUEST['inputFname']!='') && ($REQUEST['inputCCN']!=''))
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
				$custQry=mysql_query("SELECT  first_name AS FirstName, last_name AS LastName, addr1 AS Address1, addr2 AS Address2, country AS Country, state AS State, city AS City, pin_code AS Pincode, phone_no AS Phone, mobile_no AS MobileNumber, email_id AS Email, install_charge AS InstallationCharge, group_id AS GroupName, package_id AS PackageName, custom_customer_no AS CustomerID, mac_id AS MACID, stb_no AS STBNumber, card_no AS CardNumber, connection_date AS ConnectionDate, dob AS DOB, anniversary_date AS AnniversaryDate, remarks AS Remarks, pending_amount AS OutstandingAmount,  tax_rate AS TaxRate, start_date AS StartDate, end_date AS EndDate FROM customers where cust_id='$id'");
				$custRes=mysql_fetch_assoc($custQry);
				$getData=$REQUEST;
				unset($getData['ci_session']);
				$diffData=array_diff($getData,$custRes);
				$logData='';
				foreach($diffData as $key=>$val)
				{
					if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
					if($key=='GroupName'){
						$chkGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$val"));
						$oldGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=$old"));
						$logData.=$key." : ".$oldGrp['group_name']." changed as ".$chkGrp['group_name'].", ";
					}elseif($key=='PackageName'){
						$chkPack=mysql_fetch_assoc(mysql_query("SELECT package_name FROM packages WHERE package_id=$val"));
						$oldPack=mysql_fetch_assoc(mysql_query("SELECT package_name FROM packages WHERE package_id=$old"));
						$logData.=$key." : ".$oldPack['package_name']." changed as ".$chkPack['package_name'].", ";
					}else{
						$logData.=$key." : ".$old." changed as ".$val.", ";
					}
				}
				$newLogData= rtrim($logData, ",");
				if($newLogData!="")
				{
					$data1 = array(
						"emp_id" => $emp_id,
						"category" => "Customer Edit",
						"ipaddress" => $ipaddress,
						"log_text" => $custRes['FirstName']." ( ".$custRes['CustomerID']." ) Details of ".$newLogData,
						"dateCreated" => date("Y-m-d H:i:s")
					);
					$this->db->insert("change_log", $data1);
				}
				if($REQUEST['inputPhone'] == ''){$phone=0;}else{$phone=$REQUEST['inputPhone'];}
				if($REQUEST['inputDOB'] == ''){$dob1=0;}else{$dob1=$REQUEST['inputDOB'];}
				if($REQUEST['inputAnniDate'] == ''){$adate=0;}else{$adate=$REQUEST['inputAnniDate'];}
				if($REQUEST['Endingdate'] == ''){$endDate=0;}else{$endDate=$REQUEST['Endingdate'];}
				if($REQUEST['inputCity'] == ''){$city=" ";}else{$city=$REQUEST['inputCity'];}
				if($REQUEST['inputPincode'] == ''){$pin_code=" ";}else{$pin_code=$REQUEST['inputPincode'];}
				if($REQUEST['inputState'] == ''){$state=" ";}else{$state=$REQUEST['inputState'];}
				if($REQUEST['connectionDate'] == ''){$connection_date="0000-00-00";}else{$connection_date=$REQUEST['connectionDate'];}
				if($REQUEST['startDate'] == ''){$start_date="0000-00-00";}else{$start_date=$REQUEST['startDate'];}
				if($REQUEST['endDate'] == ''){$end_date="0000-00-00";}else{$end_date=$REQUEST['endDate'];}
				$gValue=$REQUEST['inputGroup'];
				$mStb=implode (",", $REQUEST['stb_no']);
				$mMac=implode (",", $REQUEST['mac_id']);
				$mCard=implode (",", $REQUEST['card_no']);
					$data = array(
						"first_name" =>$REQUEST['inputFname'],
						"last_name" =>$REQUEST['inputLname'],
						"addr1" => $REQUEST['inputAddr1'],
						"addr2" => $REQUEST['inputAddr2'],
						"city" => $city,
						"pin_code" => $pin_code,
						"country" => $REQUEST['inputCountry'],
						"state" => $state,
						"phone_no" => $phone,
						"mobile_no" => $REQUEST['inputMobile'],
						"email_id" => $REQUEST['inputEmail'],
						"install_charge" => $REQUEST['install_charge'],
						"custom_customer_no" => $REQUEST['inputCCN'],
						"group_id" => $REQUEST['inputGroup'],
						"stb_no" => $REQUEST['stb_no'],
        				"mac_id" => "0",
        				"card_no" => $REQUEST['card_no'],
						"connection_date" => $connection_date,
						"dob" => $dob1,
						"anniversary_date" => $adate,
						"remarks" => $REQUEST['inputRemarks'],
						"amount" => $REQUEST['inputAmount'],
						"current_due" => $REQUEST['inputAmount'],
						"pending_amount" => $REQUEST['inputAmount'],
						"tax_rate" => $REQUEST['inputTaxRate'],
						"start_date" => $start_date,
						"end_date" =>  $end_date,
						"inactive_date"=>0
					);
				if(isset($crd_id) && $crd_id!='')
        		{
        		    $data['crd_id'] = $crd_id;
        		    $getCrdInfo = $this->db->query("select * from credentials where crd_id='$crd_id'")->row_array();
        		    $data['lco_portal_url'] = $getCrdInfo['portal_url'];
        		    $data['lco_username'] = $getCrdInfo['user_name'];
        		    $data['lco_password'] = $getCrdInfo['password'];
        		}
				$this->db->where('cust_id', $id);
				$this->db->update('customers', $data);
				
				$check1=$this->db->query("select stb_no from set_top_boxes where cust_id='$id'")->num_rows();
				if($check1>=1)
				{
					$packData2 = array(
						"pack_id" => 1,
						"mso_id" => 1,
						"mac_id" => "0",
						"stb_no" => $REQUEST['stb_no'],
						"card_no" => $REQUEST['card_no'],
						"aadhar_no" => "0"
					);
					$this->db->where('cust_id', $id);
					$this->db->update('set_top_boxes', $packData2);
				}
			}
		}
		else
		{
			return 0;
		}
	}
	
	public function payment()
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT first_name,mobile_no,custom_customer_no,email_id,addr1,addr2,city,admin_id,stb_no,lco_portal_url,lco_username,lco_password FROM customers WHERE cust_id=$cust_id"));
		if($resCust['admin_id']==$admin_id || $user_type==1 || $user_type==9)
		{
			if($transactionType==3)
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
				$custQry=mysql_query("SELECT  first_name AS FirstName, last_name AS LastName, custom_customer_no AS CustomerID, pending_amount AS OutstandingAmount FROM customers where cust_id='$cust_id'");
				$custRes=mysql_fetch_assoc($custQry);
				$getData=$_REQUEST;
				unset($getData['ci_session']);
				$newLogData= $custRes['FirstName']." ( ".$custRes['CustomerID']." ) has Outstanding Amount Rs. ".$custRes['OutstandingAmount'].", Adjustment of Rs. ".$getData['amount']." has been done.";
				
				if($newLogData!="")
				{
					$data1 = array(
						"emp_id" => $emp_id,
						"category" => "Payment Adjustment",
						"ipaddress" => $ipaddress,
						"log_text" => $newLogData,
						"dateCreated" => date("Y-m-d H:i:s")
					);
					$this->db->insert("change_log", $data1);
				}
				
				$updateAmt=$custRes['OutstandingAmount'] - $amount;
				$data2 = array(
						"pending_amount" =>$updateAmt,
						"current_due" =>$updateAmt,
						);
				$this->db->where('cust_id',$cust_id);
				$this->db->update('customers', $data2);
				return 1;
			}
			else
			{
			    $checkDuplicate = mysql_num_rows(mysql_query("select payment_id from payments where customer_id='$cust_id' AND amount_paid='$amount' AND dateCreated>='".date('Y-m-d 00:00:00')."'"));
			    if($checkDuplicate==0)
			    {
				$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
				extract($chkEmpType);
				$busInfo=mysql_fetch_assoc(mysql_query("SELECT * FROM business_information"));
				if($instrument_date == ''){$idate=0;}else{$idate=$instrument_date;}
				$qryRec=mysql_fetch_assoc(mysql_query("select payment_id from payments order by payment_id DESC limit 1"));
				$recNo=$qryRec['payment_id']+1;
				$format=$busInfo['invoice_code'];
				$invoice=$format."/".date('ymdHis')."/".$recNo;
				$data = array(
					//"isAdjustment" =>$REQUEST['isAdjustment'],
					"customer_id" =>$cust_id,
					"emp_id" =>$emp_id,
					"admin_id" =>$admin_id,
					"amount_paid" =>$amount,
					"grp_id" => $grp_id,
					"transaction_type" => $transactionType,
					"invoice" => $invoice,
					"cheque_number" => $cheque_number,
					"bank" => $bank,
					"branch" => $branch,
					"instrument_date" => $idate,
					"remarks" => $remarks,
					"dateCreated" => date('Y-m-d H:i:s')
				);
				$this->db->insert("payments", $data);
				$payment_id=$this->db->insert_id();
				
				$updateAmt=$pendingAmt - $amount;
				$data1 = array(
					"pending_amount" =>$updateAmt,
					"current_due" =>$updateAmt,
				);
				$this->db->where('cust_id',$cust_id);
				$this->db->update('customers', $data1);
				
				if($transactionType==1){ $transType="Cash";}elseif($transactionType==2){$transType="Bank / Cheque";}
				$custName=$resCust['first_name'];
				$custCCNO=$resCust['custom_customer_no'];
				$email_Id=$resCust['email_id'];
				$busiName=$busInfo['business_name'];
				$bImage=$busInfo['business_image'];
				//echo $resCust['mobile_no'];
				$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT sendsms,sendpaymentsms,sms_api_url FROM sms_prefer"));
				// Send SMS
				if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendpaymentsms']=='Yes'))
				{
					$mess = urlencode("Dear ".ucwords($custName).",Thank you for your Payment for the sum of Rs.".$amount." towards your Cable TV Bill Receipt No : ".$invoice." total Outstanding Rs.".$updateAmt." - ".ucwords($busiName));
					$url = $resSmsPrefer['sms_api_url']."&contacts=".$resCust['mobile_no']."&msg=".$mess;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
					curl_close ($ch);
				}
				// End of SMS
				/*$getUserPacks = $this->db->query("select ca_id,ala_ch_id,pack_id from customer_alacarte where cust_id='$cust_id'")->result_array();
    			$pack_no = '';
    			foreach($getUserPacks as $key => $uPackInfo)
    			{
    			    if($uPackInfo['ala_ch_id']!='' && $uPackInfo['ala_ch_id']!='0')
    			    {
    			        $ch_id = $uPackInfo['ala_ch_id'];
    			        $getChInfo = $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio,lco_ratio,ala_ch_type,mso_pack_id from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
    			        $pack_no.=$getChInfo[0]['mso_pack_id'].",";
    			    }
    			    elseif($uPackInfo['pack_id']!='' && $uPackInfo['pack_id']!='0')
    			    {
    			        $pack_id = $uPackInfo['pack_id'];
    			        $getPackInfo = $this->db->query("select package_price,package_name,mso_ratio,lco_ratio,cat_id,mso_pack_id from packages where package_id='$pack_id'")->result_array();
    			        $pack_no.=$getPackInfo[0]['mso_pack_id'].",";
    			    }
    			}
    			$stb_info = $this->db->query("select stb_no from set_top_boxes where cust_id='$cust_id'")->result_array();
    			$lco_portal_url = $resCust['lco_portal_url'];
    			$lco_username = $resCust['lco_username'];
    			$lco_password = $resCust['lco_password'];
    			$nxt_db = $this->load->database('nxt_db', TRUE);
    		    $nxtPackData = array();
    		    $nxtPackData['portal_url'] = $lco_portal_url;
    		    $nxtPackData['Username'] = $lco_username;
    		    $nxtPackData['Password'] = $lco_password;
    		    $nxtPackData['Cust_id'] = $cust_id;
    		    $nxtPackData['Box_no'] = $stb_info[0]['stb_no'];
    		    $nxtPackData['pack_no'] = substr($pack_no,0,-1);
    		    $nxtPackData['Mac_id'] = 0;
    		    $nxtPackData['Action'] = 'renew';
    		    $nxtPackData['Datecreated'] = date("Y-m-d");
    		    $nxtPackData['Status'] = 0;
    		    $nxt_db->insert("useractivation", $nxtPackData);*/
				return 1;
			    }
			}
		}
		else
		{
			return 0;
		}
	}
	
	public function payment_reverse()
	{
		extract($_REQUEST);
		if($instrument_date == ''){$idate=0;}else{$idate=$instrument_date;}
		$qryRec=mysql_fetch_assoc(mysql_query("select * from payments where customer_id='$cust_id' order by payment_id DESC limit 1"));
		$cust=mysql_fetch_assoc(mysql_query("select * from cutomers where cust_id='$cust_id'"));
		$rec=$qryRec['payment_id'];
		$recNo=$qryRec['payment_id']+1;
		$invoice="RC/".date('ymdHis')."/".$recNo;
		$type=3;
		$data = array(
				"customer_id" =>$cust_id,
				"emp_id" =>$emp_id,				"grp_id" => $grp_id,
				"amount_paid" =>-($amount),
				"transaction_type" => $type,
				"invoice" => $invoice,
				"cheque_number" => $cheque_number,
				"bank" => $bank,
				"branch" => $branch,
				"instrument_date" => $idate,
				"remarks" => $remarks,
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->insert("payments", $data);
		
		$updateAmt=$cust['pending_amount']+$amount;
		$data1 = array(
				"pending_amount" =>$updateAmt,
				);
		$this->db->where('cust_id',$cust_id);
		$this->db->update('customers', $data1);
		
		return 1;
	}
	
	public function get_payments($limit, $start,$id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		$today=date("Y-m-d 00:00:00");
		if($user_type==9)
		{
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$today')";
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND groups.group_id = '$inputGroup'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);
		}
		elseif($user_type=='1')
		{
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$today') AND customers.admin_id='$admin_id'";
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND groups.group_id = '$inputGroup'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);		
		}else{
			$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=".$id));
			$grp_ids=$chkEmpGrps['group_ids'];
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$today' and payments.grp_id IN ($grp_ids)) AND customers.admin_id='$admin_id'";
			
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND groups.group_id = '$inputGroup'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);
		}
	    return $query->result_array();
    }
	
	public function get_payments_monthly($limit, $start, $id, $p=NULL, $sg=NULL)
	{
		extract($_REQUEST);
		$pageData = array(
			'mpl_cur_page_no' => $p
		);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		$month=date("Y-m-00 00:00:00");
		if($user_type==9)
		{
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month')";
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			//if(isset($inputGroup) && $inputGroup!='')
			//{
				//$qry.=" AND groups.group_id = '$inputGroup'";
			//}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND payments.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			if(isset($inputGroup)){
				$groupData = array(
					'mpl_cur_grp_id' => $inputGroup
				);
				$this->session->set_userdata($groupData);
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND groups.group_id='$inputGroup'";
				}
			}
			if(isset($sg) && $sg!=''){
				$qry.= " AND groups.group_id='$sg'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);
		}
		elseif($user_type=='1')
		{
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month') AND customers.admin_id='$admin_id'";
			
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			//if(isset($inputGroup) && $inputGroup!='')
			//{
				//$qry.=" AND groups.group_id = '$inputGroup'";
			//}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				// $qry.=" AND payments.dateCreated='$mobile'";
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND payments.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
			if(isset($inputGroup)){
				$groupData = array(
					'mpl_cur_grp_id' => $inputGroup
				);
				$this->session->set_userdata($groupData);
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND groups.group_id='$inputGroup'";
				}
			}
			if(isset($sg) && $sg!=''){
				$qry.= " AND groups.group_id='$sg'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);		
		}else{
			$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
			$grp_ids=$chkEmpGrps['group_ids'];
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month' and payments.grp_id IN ($grp_ids)) AND customers.admin_id='$admin_id'";
			
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			if(isset($inputGroup)){
				$groupData = array(
					'mpl_cur_grp_id' => $inputGroup
				);
				$this->session->set_userdata($groupData);
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND groups.group_id='$inputGroup'";
				}
			}
			if(isset($sg) && $sg!=''){
				$qry.= " AND groups.group_id='$sg'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);
		}
	    return $query->result_array();
    }
	
	public function get_outstanding($limit, $start, $id, $p=NULL, $sg=NULL)
	{
		extract($_REQUEST);
		$pageData = array(
			'to_cur_page_no' => $p
		);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		if($user_type==9)
		{
			$qry = "SELECT customers.cust_id,customers.custom_customer_no,customers.first_name,customers.last_name,customers.mobile_no,customers.pending_amount FROM customers where group_id IN ($grp_ids) ";
		}
		elseif($user_type==1)
		{
			$qry = "SELECT customers.cust_id,customers.custom_customer_no,customers.first_name,customers.last_name,customers.mobile_no,customers.pending_amount FROM customers where group_id IN ($grp_ids) AND customers.admin_id='$admin_id'";
		}
		else
		{
			$qry = "SELECT customers.cust_id,customers.custom_customer_no,customers.first_name,customers.last_name,customers.mobile_no,customers.pending_amount FROM customers where group_id IN ($grp_ids) AND customers.admin_id='$admin_id'";
		}
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}
			$grp='';
			foreach($inputGroup as $key => $Group){
				$grp.=$Group.",";
			}
			$newGrpIds= substr($grp, 0, -1);
			if(isset($newGrpIds)){
				$groupData = array(
					'to_cur_grp_id' => $newGrpIds
				);
				$this->session->set_userdata($groupData);
				if(isset($newGrpIds) && $newGrpIds!='')
				{
					$qry.=" AND customers.group_id IN ($newGrpIds)";
				}
			}
				$qry.=" ORDER BY customers.cust_id ASC limit $start,$limit";
			//echo $qry;
			$query = $this->db->query($qry);
	    	return $query->result_array();
	}
	
	public function get_payments_cheque($limit, $start)
	{
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id='$emp_id'"));
		$grp_ids=$chkEmpGrps['group_ids'];
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($mobile) && $mobile!=''))
			{
				$query = $this->db->query("SELECT * FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id where custom_customer_no='$inputCCN' or first_name='$inputFname' or mobile_no='$mobile' and transaction_type=2 limit $start,$limit");
			}
			else
			{
				$query = $this->db->query("select * from payments where transaction_type=2 limit $start,$limit");
			}
	    return $query->result_array();
    }
	
	public function get_customer($id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$id"));
		if($chkEmpType['user_type']==1)
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($inputGroup) && $inputGroup!='') || (isset($inputMobile) && $inputMobile!='') )
			{
				$query = $this->db->query("select * from customers where (custom_customer_no='$inputCCN' or mobile_no='$inputMobile' or first_name='$inputFname' or group_id='$inputGroup') AND status=1");
			}
			else
			{
				$query = $this->db->query("select * from customers where status=1");
			}
		}
		else
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($inputGroup) && $inputGroup!='') || (isset($inputMobile) && $inputMobile!='') )
			{
				$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
				$grp_ids=$chkEmpGrps['group_ids'];
				$query = $this->db->query("select * from customers where (custom_customer_no='$inputCCN'  or mobile_no='$inputMobile' or first_name='$inputFname' or group_id='$inputGroup') and group_id IN ($grp_ids)  AND status=1");
			}
			else
			{
				$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
				$grp_ids=$chkEmpGrps['group_ids'];
				$query = $this->db->query("select * from customers where group_id IN ($grp_ids) AND status=1 ");
			}
		}
        return $query->result_array();
    }
	
	public function get_inactive_customer($id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$id"));
		if($chkEmpType['user_type']==1)
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($inputGroup) && $inputGroup!='') || (isset($inputMobile) && $inputMobile!='') )
			{
				$query = $this->db->query("select * from customers where (custom_customer_no='$inputCCN' or mobile_no='$inputMobile' or first_name='$inputFname' or group_id='$inputGroup') AND status=0");
			}
			else
			{
				$query = $this->db->query("select * from customers where status=0");
			}
		}
		else
		{
			if((isset($inputCCN) && $inputCCN!='') || (isset($inputFname) && $inputFname!='') || (isset($inputGroup) && $inputGroup!='') || (isset($inputMobile) && $inputMobile!='') )
			{
				$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
				$grp_ids=$chkEmpGrps['group_ids'];
				$query = $this->db->query("select * from customers where (custom_customer_no='$inputCCN'  or mobile_no='$inputMobile' or first_name='$inputFname' or group_id='$inputGroup') and group_id IN ($grp_ids)  AND status=0");
			}
			else
			{
				$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
				$grp_ids=$chkEmpGrps['group_ids'];
				$query = $this->db->query("select * from customers where group_id IN ($grp_ids) AND status=0");
			}
		}
        return $query->result_array();
    }
	
	public function inactive_customer_customer_by_id($id = NULL,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id,cust_id FROM customers WHERE cust_id=$id AND status=1"));
		if($resCust['admin_id']==$admin_id || $user_type==9)
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
			
		    	$custQry=mysql_query("SELECT  first_name AS FirstName, last_name AS LastName, addr1 AS Address1, addr2 AS Address2, country AS Country, state AS State, city AS City, pin_code AS Pincode, phone_no AS Phone, mobile_no AS MobileNumber, email_id AS Email, install_charge AS InstallationCharge, group_id AS GroupName, package_id AS PackageName, custom_customer_no AS CustomerID, mac_id AS MACID, stb_no AS STBNumber, card_no AS CardNumber, connection_date AS ConnectionDate, dob AS DOB, anniversary_date AS AnniversaryDate, remarks AS Remarks, pending_amount AS OutstandingAmount,  tax_rate AS TaxRate, start_date AS StartDate, end_date AS EndDate FROM customers where cust_id='$id'");
				$custRes=mysql_fetch_assoc($custQry);
				// if($newLogData!="")
				// {
					$data2 = array(
						"emp_id" => $emp_id,
						"category" => "Customer Inactivate",
						"ipaddress" => $ipaddress,
						"log_text" => $custRes['FirstName']." ( ".$custRes['CustomerID']." ) has been Inactivated.",
						"dateCreated" => date("Y-m-d H:i:s")
					);
					$this->db->insert("change_log", $data2);
				// }

			$data = array(
				"status" => 0,
				"inactive_date" => date('Y-m-d H:i:s')
			);
			$this->db->where('cust_id', $id);
			$this->db->update('customers', $data);
			
			$data1 = array(
				"cust_id" => $id,
				"inactive_date" => date('Y-m-d H:i:s'),
				"datecreated" => date('Y-m-d H:i:s')
			);
			$this->db->insert("customers_inactive", $data1);
			
			$d1=date("Y-m-01 00:00:00");
		    $temp3 = $this->db->query("select s.stb_id,s.pack_id from set_top_boxes s where s.cust_id='$id' LIMIT 1")->result_array();
		    if(count($temp3)==1)
		    {
		      //  $temp4 = $this->db->query("select s.stb_id,c.group_id,s.pack_id from customers c left join set_top_boxes s ON c.cust_id=s.cust_id where s.cust_id='$id'")->result_array();
    		  //  $temp5 = $this->db->query("select package_price,package_name,mso_ratio from packages where package_id=".$temp4[0]['pack_id'])->result_array();
    		  //  $packPrice = $temp5[0]['package_price'] * ($temp5[0]['mso_ratio']/100);
    		  //  $packName = $temp5[0]['package_name'];
    		    
    		    $daysInMonth=date("t");
    		    $currentDay=date("d");
    		    $refundDays=$daysInMonth-$currentDay;
    		  //  $actPackPrice = ($packPrice/$daysInMonth)*$refundDays;
    		    
    		  //  $cdue = array(
    		  //      "pending_amount" => round($custRes['OutstandingAmount']+$actPackPrice,2),
    		  //      "current_due" => round($custRes['OutstandingAmount']+$actPackPrice,2)
    		  //  );
    		  //  $this->db->where('cust_id', $id);
    		  //  $this->db->update('customers', $cdue);
    		    
    		    $admin_id=$resCust['admin_id'];
    			$cust_id=$id;
    			/*if($temp3[0]['pack_id']!='')
    			{
    			    $packRes = $this->db->query("select package_price,package_name from packages where package_id=".$temp3[0]['pack_id'])->result_array();
        			$actPackPrice = ($packRes[0]['package_price']/$daysInMonth)*$refundDays;
    			    $cust_balance = $custRes['OutstandingAmount'] - $actPackPrice;
        		    $data52 = array(
        		        "pending_amount" => $cust_balance,
        		        "current_due" => $cust_balance
        		    );
        		    $this->db->where('cust_id', $cust_id);
        		    $this->db->update('customers', $data52);
        		    
        		    $temp72 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
        		    $balance = $temp72[0]['balance'] + $actPackPrice;
        		    $data42 = array(
        		        "admin_id" => $admin_id,
        		        "cust_id" => $cust_id,
                        "stb_id" => $temp3[0]['stb_id'],
        		        "type" => "credit",
        		        "open_bal" => $temp72[0]['balance'],
        		        "amount" => $actPackPrice,
        		        "close_bal" => $balance,
        		        "remarks" => $refundDays." days amount refunded for:".$packRes[0]['package_name'],
        		        "ac_date" => date("Y-m-01"),
        		        "dateCreated" => date("Y-m-d H:i:s"),
        		        "created_by" => $emp_id
        		    );
        		    $this->db->insert("f_accounting", $data42);
    			}
    			
    			$alaQry=mysql_query("select ca.stb_id,ca.ala_ch_id,ca.pack_id from customer_alacarte ca left join set_top_boxes s ON ca.stb_id=s.stb_id where s.stb_id!='' AND ca.cust_id=".$id);
    			while($alaRes=mysql_fetch_assoc($alaQry))
    			{
    			    $temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
    			    $stb_id=$alaRes['stb_id'];
    			    $temp8 = $this->db->query("select pending_amount from customers where cust_id='$id'")->result_array();
    			    $packPrice = 0;
        		    if($alaRes['ala_ch_id']!='' && $alaRes['ala_ch_id']!='0')
        		    {
        		        $ch_id = $alaRes['ala_ch_id'];
        		        $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio,lco_ratio from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
        		        $packPrice = $pack1[0]['ala_ch_price'];
        		        $packName = $pack1[0]['ala_ch_name'];
        		    }
        		    elseif($alaRes['pack_id']!='')
        		    {
        		        $packID = $alaRes['pack_id'];
        		        $pack1 = $this->db->query("select package_price,package_name,mso_ratio,lco_ratio from packages where package_id='$packID' AND isbase!='Yes'")->result_array();
        		        $packPrice = $pack1[0]['package_price'];
        		        $packName = $pack1[0]['package_name'];
        		    }
        		    $actPackPrice = ($packPrice/$daysInMonth)*$refundDays;
    			    $cust_balance = $temp8[0]['pending_amount'] - $actPackPrice;
        		    $data5 = array(
        		        "pending_amount" => $cust_balance,
        		        "current_due" => $cust_balance
        		    );
        		    $this->db->where('cust_id', $cust_id);
        		    $this->db->update('customers', $data5);
        		    
        		    $balance = $temp7[0]['balance'] + $actPackPrice;
        		    $data3 = array(
        		        "balance" => $balance
        		    );
        		    $this->db->where('admin_id', $admin_id);
        		    $this->db->update('admin', $data3);
        		    
        		    $data4 = array(
        		        "admin_id" => $admin_id,
        		        "cust_id" => $cust_id,
                        "stb_id" => $stb_id,
        		        "type" => "credit",
        		        "open_bal" => $temp7[0]['balance'],
        		        "amount" => $actPackPrice,
        		        "close_bal" => $balance,
        		        "remarks" => $refundDays." days amount refunded for:".$packName,
        		        "ac_date" => date("Y-m-01"),
        		        "dateCreated" => date("Y-m-d H:i:s"),
        		        "created_by" => $emp_id
        		    );
        		    $this->db->insert("f_accounting", $data4);
    			}*/
		    }
			
			return 1;
		}
		else
		{
			return 0;
		}
    }
	
	public function activate_customer_by_id($id = NULL,$emp_id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id,cust_id FROM customers WHERE cust_id=$id AND status=0"));
		if($resCust['admin_id']==$admin_id || $user_type==9)
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
				
			$custQry=mysql_query("SELECT  first_name AS FirstName, last_name AS LastName, addr1 AS Address1, addr2 AS Address2, country AS Country, state AS State, city AS City, pin_code AS Pincode, phone_no AS Phone, mobile_no AS MobileNumber, email_id AS Email, install_charge AS InstallationCharge, group_id AS GroupName, package_id AS PackageName, custom_customer_no AS CustomerID, mac_id AS MACID, stb_no AS STBNumber, card_no AS CardNumber, connection_date AS ConnectionDate, dob AS DOB, anniversary_date AS AnniversaryDate, remarks AS Remarks, pending_amount AS OutstandingAmount,  tax_rate AS TaxRate, start_date AS StartDate, end_date AS EndDate FROM customers where cust_id='$id'");
				$custRes=mysql_fetch_assoc($custQry);
				$data2 = array(
					"emp_id" => $emp_id,
					"category" => "Customer Activate",
					"ipaddress" => $ipaddress,
					"log_text" => $custRes['FirstName']." ( ".$custRes['CustomerID']." ) has been Activated.",
					"dateCreated" => date("Y-m-d H:i:s")
				);
				$this->db->insert("change_log", $data2);
			
			$data = array(
				"status" => 1
			);
			$this->db->where('cust_id', $id);
			$this->db->update('customers', $data);
			
			$data1 = array(
    			"active_date" => date('Y-m-d H:i:s'),
    			"datecreated" => date('Y-m-d H:i:s')
			);
			$this->db->where('cust_id', $id);
			$this->db->update('customers_inactive', $data1);
			
			$d1=date("Y-m-01 00:00:00");
		    /*$temp3 = $this->db->query("select b.stb_id from billing_info b where b.cust_id='$id' AND dateGenerated>='$d1'")->result_array();
		    if(count($temp3)==0)
		    {
		        $temp4 = $this->db->query("select s.stb_id,c.group_id,s.pack_id from customers c left join set_top_boxes s ON c.cust_id=s.cust_id where s.cust_id='$id'")->result_array();
    		    $temp5 = $this->db->query("select package_price,package_name,mso_ratio from packages where package_id=".$temp4[0]['pack_id'])->result_array();
    		    $packPrice = $temp5[0]['package_price'] * ($temp5[0]['mso_ratio']/100);
    		    $packName = $temp5[0]['package_name'];
    		    
    		    $daysInMonth=date("t");
    		    $currentDay=date("d")-1;
    		    $refundDays=$daysInMonth-$currentDay;
    		    $actPackPrice = ($packPrice/$daysInMonth)*$refundDays;
    		    
		        $data6 = array(
    		        "admin_id" => $resCust['admin_id'],
    		        "cust_id" => $id,
    		        "stb_id" => $stb_id,
    		        "group_id" => $temp4[0]['group_id'],
    		        "pack_id" => $temp4[0]['pack_id'],
    		        "stb_id" => $temp4[0]['stb_id'],
    		        "current_month_name" => date("F"),
    		        "previous_due" => $custRes['OutstandingAmount'],
    		        "current_month_bill" => $actPackPrice,
    		        "total_outstaning" => ($custRes['OutstandingAmount'] + $actPackPrice),
    		        "dateGenerated" => date("Y-m-d H:i:s")
    		        );
    		    $this->db->insert("billing_info", $data6);
    		    
    		    $cdue = array(
    		        "pending_amount" => round($custRes['OutstandingAmount']+$actPackPrice,2),
    		        "current_due" => round($custRes['OutstandingAmount']+$actPackPrice,2)
    		    );
    		    $this->db->where('cust_id', $id);
    		    $this->db->update('customers', $cdue);
    		    
    		    $admin_id=$resCust['admin_id'];
    			$cust_id=$id;
    			$alaQry=mysql_query("select ca.stb_id,ca.ala_ch_id,ca.pack_id from customer_alacarte ca left join set_top_boxes s ON ca.stb_id=s.stb_id where s.stb_id!='' AND ca.cust_id=".$id);
    			while($alaRes=mysql_fetch_assoc($alaQry))
    			{
    			    $temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
    			    $stb_id=$alaRes['stb_id'];
    			    $temp8 = $this->db->query("select pending_amount from customers where cust_id='$id'")->result_array();
    			    $packPrice = 0;
        		    if($alaRes['ala_ch_id']!='' && $alaRes['ala_ch_id']!='0')
        		    {
        		        $ch_id = $alaRes['ala_ch_id'];
        		        $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio,lco_ratio from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
        		        $packPrice = $pack1[0]['ala_ch_price'];
        		        $packName = $pack1[0]['ala_ch_name'];
        		    }
        		    elseif($alaRes['pack_id']!='')
        		    {
        		        $packID = $alaRes['pack_id'];
        		        $pack1 = $this->db->query("select package_price,package_name,mso_ratio,lco_ratio from packages where package_id='$packID' AND isbase!='Yes'")->result_array();
        		        $packPrice = $pack1[0]['package_price'];
        		        $packName = $pack1[0]['package_name'];
        		    }
        		    $packPrice2 = ($packPrice/$daysInMonth)*$refundDays;
    			    $cust_balance = $temp8[0]['pending_amount'] + $packPrice2;
        		    $data5 = array(
        		        "pending_amount" => $cust_balance,
        		        "current_due" => $cust_balance
        		    );
        		    $this->db->where('cust_id', $cust_id);
        		    $this->db->update('customers', $data5);
        		    
        		    $balance = $temp7[0]['balance'] - $packPrice2;
        		    $data3 = array(
        		        "balance" => $balance
        		    );
        		    $this->db->where('admin_id', $admin_id);
        		    $this->db->update('admin', $data3);
        		    
        		    $data4 = array(
        		        "admin_id" => $admin_id,
        		        "cust_id" => $cust_id,
                        "stb_id" => $stb_id,
        		        "type" => "debit",
        		        "open_bal" => $temp7[0]['balance'],
        		        "amount" => $packPrice2,
        		        "close_bal" => $balance,
        		        "remarks" => $refundDays." days amount added for:".$packName,
        		        "ac_date" => date("Y-m-01"),
        		        "dateCreated" => date("Y-m-d H:i:s"),
        		        "created_by" => $emp_id
        		    );
        		    $this->db->insert("f_accounting", $data4);
    			}
		    }
		    elseif(count($temp3)==1)
		    {
		        $temp4 = $this->db->query("select s.stb_id,c.group_id,s.pack_id from customers c left join set_top_boxes s ON c.cust_id=s.cust_id where s.cust_id='$id'")->result_array();
    		    $temp5 = $this->db->query("select package_price,package_name,mso_ratio from packages where package_id=".$temp4[0]['pack_id'])->result_array();
    		    $packPrice = $temp5[0]['package_price'] * ($temp5[0]['mso_ratio']/100);
    		    $packName = $temp5[0]['package_name'];
    		    
    		    $daysInMonth=date("t");
    		    $currentDay=date("d");
    		    $refundDays=$daysInMonth-$currentDay;
    		    $actPackPrice = ($packPrice/$daysInMonth)*$refundDays;
    		    
    		    $cdue = array(
    		        "pending_amount" => round($custRes['OutstandingAmount']+$actPackPrice,2),
    		        "current_due" => round($custRes['OutstandingAmount']+$actPackPrice,2)
    		    );
    		    $this->db->where('cust_id', $id);
    		    $this->db->update('customers', $cdue);
    		    
    		    $temp72 = $this->db->query("select balance from admin where admin_id=".$resCust['admin_id'])->result_array();
    		    $balance = $temp72[0]['balance'] - $actPackPrice;
    		    $data42 = array(
    		        "admin_id" => $resCust['admin_id'],
    		        "cust_id" => $id,
                    "stb_id" => $temp3[0]['stb_id'],
    		        "type" => "debit",
    		        "open_bal" => $temp72[0]['balance'],
    		        "amount" => $actPackPrice,
    		        "close_bal" => $balance,
    		        "remarks" => $refundDays." days amount added for:".$packName,
    		        "ac_date" => date("Y-m-01"),
    		        "dateCreated" => date("Y-m-d H:i:s"),
    		        "created_by" => $emp_id
    		    );
    		    $this->db->insert("f_accounting", $data42);
    		    
    		    $admin_id=$resCust['admin_id'];
    			$cust_id=$id;
    			$alaQry=mysql_query("select ca.stb_id,ca.ala_ch_id,ca.pack_id from customer_alacarte ca left join set_top_boxes s ON ca.stb_id=s.stb_id where s.stb_id!='' AND ca.cust_id=".$id);
    			while($alaRes=mysql_fetch_assoc($alaQry))
    			{
    			    $temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
    			    $stb_id=$alaRes['stb_id'];
    			    $temp8 = $this->db->query("select pending_amount from customers where cust_id='$id'")->result_array();
    			    $packPrice = 0;
        		    if($alaRes['ala_ch_id']!='' && $alaRes['ala_ch_id']!='0')
        		    {
        		        $ch_id = $alaRes['ala_ch_id'];
        		        $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio,lco_ratio from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
        		        $packPrice = $pack1[0]['ala_ch_price'];
        		        $packName = $pack1[0]['ala_ch_name'];
        		    }
        		    elseif($alaRes['pack_id']!='')
        		    {
        		        $packID = $alaRes['pack_id'];
        		        $pack1 = $this->db->query("select package_price,package_name,mso_ratio,lco_ratio from packages where package_id='$packID' AND isbase!='Yes'")->result_array();
        		        $packPrice = $pack1[0]['package_price'];
        		        $packName = $pack1[0]['package_name'];
        		    }
        		    $packPrice = ($packPrice/$daysInMonth)*$refundDays;
    			    $cust_balance = $temp8[0]['pending_amount'] + $packPrice;
        		    $data5 = array(
        		        "pending_amount" => $cust_balance,
        		        "current_due" => $cust_balance
        		    );
        		    $this->db->where('cust_id', $cust_id);
        		    $this->db->update('customers', $data5);
        		    
        		    $balance = $temp7[0]['balance'] - $packPrice;
        		    $data3 = array(
        		        "balance" => $balance
        		    );
        		    $this->db->where('admin_id', $admin_id);
        		    $this->db->update('admin', $data3);
        		    
        		    $data4 = array(
        		        "admin_id" => $admin_id,
        		        "cust_id" => $cust_id,
                        "stb_id" => $stb_id,
        		        "type" => "debit",
        		        "open_bal" => $temp7[0]['balance'],
        		        "amount" => $packPrice,
        		        "close_bal" => $balance,
        		        "remarks" => $packName,
        		        "ac_date" => date("Y-m-01"),
        		        "dateCreated" => date("Y-m-d H:i:s"),
        		        "created_by" => $emp_id
        		    );
        		    $this->db->insert("f_accounting", $data4);
    			}
		    }*/
			return 1;
		}
    }

	public function get_customer_by_id($id = NULL)
	{
		$adminId=$this->session->userdata('admin_id');
		if($adminId==1)
		{
			$query = $this->db->query("select * from customers where cust_id = $id ");
		}
		else
		{
			$query = $this->db->query("select * from customers where cust_id = $id AND admin_id='$adminId'");
		}
        return $query->result_array();
    }

	public function get_payments_history($id = NULL,$emp_id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id=$id"));
		if($resCust['admin_id']==$admin_id || $admin_id==1)
		{
			if((isset($fromdate) && $fromdate!='') || (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime($todate);
				$to_date=date("Y-m-d H:i:s",$org_todate);
				$query = $this->db->query("select * from payments where customer_id = $id AND dateCreated BETWEEN '$from_date' AND '$to_date'");
			}
			else
			{
				$query = $this->db->query("select * from payments where customer_id = $id ");
			}
			return $query->result_array();
		}
    }
	
	public function multi_del_customer($emp_id)
	{
		$j=0;
		foreach($_REQUEST['case'] as $key => $delCust)
		{
			//print_r($_REQUEST['case'][$j]);die;
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
			
		$custQry=mysql_query("SELECT  first_name AS FirstName, last_name AS LastName, addr1 AS Address1, addr2 AS Address2, country AS Country, state AS State, city AS City, pin_code AS Pincode, phone_no AS Phone, mobile_no AS MobileNumber, email_id AS Email, install_charge AS InstallationCharge, group_id AS GroupName, package_id AS PackageName, custom_customer_no AS CustomerID, mac_id AS MACID, stb_no AS STBNumber, card_no AS CardNumber, connection_date AS ConnectionDate, dob AS DOB, anniversary_date AS AnniversaryDate, remarks AS Remarks, pending_amount AS OutstandingAmount,  tax_rate AS TaxRate, start_date AS StartDate, end_date AS EndDate FROM customers where cust_id=".$_REQUEST['case'][$j]);
			$custRes=mysql_fetch_assoc($custQry);
			$data1 = array(
				"emp_id" => $emp_id,
				"category" => "Customer Delete",
				"ipaddress" => $ipaddress,
				"log_text" => $custRes['FirstName']." ( ".$custRes['CustomerID']." ) has been Deleted.",
				"dateCreated" => date("Y-m-d H:i:s")
			);
			$this->db->insert("change_log", $data1);
		
	    		$query = $this->db->query("DELETE FROM customers WHERE cust_id = ".$_REQUEST['case'][$j]);
	    		$j++;
	    	}
		return true;
	}
	
	public function del_customer($id=NULL,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id=$id"));
		if($resCust['admin_id']==$admin_id || $user_type==9)
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
			
			$custQry=mysql_query("SELECT  first_name AS FirstName, last_name AS LastName, addr1 AS Address1, addr2 AS Address2, country AS Country, state AS State, city AS City, pin_code AS Pincode, phone_no AS Phone, mobile_no AS MobileNumber, email_id AS Email, install_charge AS InstallationCharge, group_id AS GroupName, package_id AS PackageName, custom_customer_no AS CustomerID, mac_id AS MACID, stb_no AS STBNumber, card_no AS CardNumber, connection_date AS ConnectionDate, dob AS DOB, anniversary_date AS AnniversaryDate, remarks AS Remarks, pending_amount AS OutstandingAmount,  tax_rate AS TaxRate, start_date AS StartDate, end_date AS EndDate FROM customers where cust_id = $id");
			$custRes=mysql_fetch_assoc($custQry);
			$data1 = array(
				"emp_id" => $emp_id,
				"category" => "Customer Delete",
				"ipaddress" => $ipaddress,
				"log_text" => $custRes['FirstName']." ( ".$custRes['CustomerID']." ) has been Deleted.",
				"dateCreated" => date("Y-m-d H:i:s")
			);
			$this->db->insert("change_log", $data1);
			
	    	$query = $this->db->query("DELETE FROM customers WHERE cust_id = $id");
			return true;
		}
	}	

	public function get_customer_list($limit, $start, $id,$p=NULL,$sg=NULL)
	{
		extract($_REQUEST);
		$pageData = array(
			'cur_page_no' => $p
		);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		if($user_type==9)
		{
			$qry= "select customers.cust_id,customers.first_name,customers.last_name,customers.custom_customer_no,customers.mobile_no,customers.mac_id,customers.stb_no,customers.pending_amount,customers.cust_balance,customers.end_date,(select group_name from groups where group_id=customers.group_id) as group_name,(select package_price from packages where package_id=customers.package_id) as package_price,(select stb_id from set_top_boxes where cust_id=customers.cust_id LIMIT 0,1) as stb_id from customers WHERE customers.status=1 ";
			if(isset($inputCCN) && $inputCCN!='')
			{
				$qry.= " AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.= " AND customers.admin_id='$inputEmp'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.= " AND (customers.first_name LIKE '%$inputFname%' or customers.last_name LIKE '%$inputFname%')";
			}
			if(isset($inputMobile) && $inputMobile!='')
			{
			    $qry.= " AND (customers.mobile_no='$inputMobile' or customers.stb_no LIKE '%$inputMobile%')";
			}
			if(isset($inputGroup))
			{
				$groupData = array(
					'cur_grp_id' => $inputGroup
				);
				$this->session->set_userdata($groupData);
				if(isset($inputGroup) && $inputGroup!='')
				{
					$qry.=" AND customers.group_id='$inputGroup'";
				}
			}
			if(isset($sg) && $sg!='')
			{
				$qry.= " AND customers.group_id='$sg'";
			}
				$qry.= " limit ". $start . ", " . $limit;
			$query = $this->db->query($qry);
		}
		elseif($user_type==1)
		{
			$qry= "select customers.cust_id,customers.first_name,customers.last_name,customers.custom_customer_no,customers.mobile_no,customers.mac_id,customers.stb_no,customers.pending_amount,customers.cust_balance,customers.end_date,(select group_name from groups where group_id=customers.group_id) as group_name,(select package_price from packages where package_id=customers.package_id) as package_price,(select stb_id from set_top_boxes where cust_id=customers.cust_id LIMIT 0,1) as stb_id from customers WHERE customers.status=1 AND customers.admin_id=$admin_id";
			if(isset($inputCCN) && $inputCCN!='')
			{
				$qry.= " AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.= " AND customers.admin_id='$inputEmp'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.= " AND (customers.first_name LIKE '%$inputFname%' or customers.last_name LIKE '%$inputFname%')";
			}
			if(isset($inputMobile) && $inputMobile!='')
			{
		        $qry.= " AND (customers.mobile_no='$inputMobile' or customers.stb_no LIKE '%$inputMobile%')";
			}
			if(isset($inputGroup))
			{
				$groupData = array(
					'cur_grp_id' => $inputGroup
				);
				$this->session->set_userdata($groupData);
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND customers.group_id='$inputGroup'";
				}
			}
			if(isset($sg) && $sg!='')
			{
				$qry.= " AND customers.group_id='$sg'";
			}
				$qry.= " limit ". $start . ", " . $limit;
			$query = $this->db->query($qry);
		}
		else
		{
		 	$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
			$grp_ids=$chkEmpGrps['group_ids'];
         	$qry= "select customers.cust_id,customers.first_name,customers.last_name,customers.custom_customer_no,customers.mobile_no,customers.mac_id,customers.stb_no,customers.pending_amount,customers.cust_balance,customers.end_date,(select group_name from groups where group_id=customers.group_id) as group_name,(select package_price from packages where package_id=customers.package_id) as package_price,(select stb_id from set_top_boxes where cust_id=customers.cust_id LIMIT 0,1) as stb_id from customers WHERE customers.status=1 AND customers.admin_id='$admin_id' AND customers.group_id IN ($grp_ids) ";
			if(isset($inputCCN) && $inputCCN!='')
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.= " AND customers.admin_id='$inputEmp'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND (customers.first_name LIKE '%$inputFname%' or customers.last_name LIKE '%$inputFname%')";
			}
			if(isset($inputMobile) && $inputMobile!='')
			{
                $qry.= " AND (customers.mobile_no='$inputMobile' or customers.stb_no LIKE '%$inputMobile%')";
			}
			if(isset($inputGroup))
			{
				$groupData = array(
					'cur_grp_id' => $inputGroup
				);
				$this->session->set_userdata($groupData);
				if(isset($inputGroup) && $inputGroup!='')
				{
					$qry.=" AND customers.group_id='$inputGroup'";
				}
			}
			if(isset($sg) && $sg!='')
			{
				$qry.= " AND customers.group_id='$sg'";
			}
				$qry.= " limit ". $start . ", " . $limit;
			$query = $this->db->query($qry);
		}
       		return $query->result_array();
	}
	
	public function get_customers_count($sg=NULL)
	{
		extract($_REQUEST);
		$qry = "select cust_id from customers where 1=1 AND status=1";
			if(isset($sg) && $sg!=''){
				$qry.= " AND group_id='$sg'";
			}
			if(isset($inputGroup) && $inputGroup!=''){
				$qry.= " AND group_id='$inputGroup'";
			}
		$query = $this->db->query($qry); 
		return $query->num_rows();
	}
	
	public function get_monthly_payments_count($sg=NULL,$id=NULL)
	{
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$month=date("Y-m-00 00:00:00");
		$qry = "SELECT  payments.customer_id FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month' and payments.grp_id IN ($grp_ids))";
			if(isset($sg) && $sg!=''){
				$qry.= " AND payments.grp_id='$sg'";
			}
			if(isset($inputGroup) && $inputGroup!=''){
				$qry.= " AND payments.grp_id='$inputGroup'";
			}
		$query = $this->db->query($qry); 
		return $query->num_rows();
	}
	
	public function get_totaloutstanding_count($sg=NULL,$id=NULL)
	{
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$qry = "SELECT cust_id FROM customers where group_id IN ($grp_ids)";
			if(isset($sg) && $sg!=''){
				$qry.= " AND group_id='$sg'";
			}
			if(isset($inputGroup) && $inputGroup!=''){
				$qry.= " AND group_id='$inputGroup'";
			}
		$query = $this->db->query($qry); 
		return $query->num_rows();
	}	

	public function get_customer_payment_by_id($id,$payment_id,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id=$id"));
		if($resCust['admin_id']==$admin_id || $admin_id==1)
		{
			$query = $this->db->query("select * from payments where customer_id = $id and payment_id='$payment_id'");
			return $query->result_array();
		}
	}
	
	public function payment_edit($id,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id=$id"));
        if($resCust['admin_id'])
		{
			extract($_REQUEST);
	
			$data = array(
					"amount_paid" =>$amount,
					"transaction_type" =>$transactionType,
					);
			$this->db->where('payment_id', $payment_id);
			$this->db->update('payments', $data);
			
			$custQry=mysql_query("select * from customers where cust_id='$cust_id'");
			$custRes=mysql_fetch_assoc($custQry);
			$updateAmt=$custRes['pending_amount']+($pendingAmt-$amount);
			$data1 = array(
					"pending_amount" =>$updateAmt,
					"current_due" =>$updateAmt,
					);
			$this->db->where('cust_id', $cust_id);
			$this->db->update('customers', $data1);
			
			//Log History
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
				
				$data2 = array(
					"emp_id" => $emp_id,
					"category" => "Payment Edit",
					"ipaddress" => $ipaddress,
					// "log_text" => $custRes['first_name']." ( ".$custRes['custom_customer_no']." ) payment amount has been Updated Rs.".$pendingAmt." as Rs.".$amount.".",
					"log_text" => $custRes['first_name']." (".$custRes['custom_customer_no'].") Amount of Rs. ".$pendingAmt." edited to Rs. ".$amount.".",
					"dateCreated" => date("Y-m-d H:i:s")
				);
				$this->db->insert("change_log", $data2);
		}
	}
	
	public function payment_delete($id, $payment_id, $amount,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id=$id"));
		if($resCust['admin_id']==$admin_id || $admin_id==1)
		{
			extract($_REQUEST);
			$custQry=mysql_query("select * from customers where cust_id = $id");
			$custRes=mysql_fetch_assoc($custQry);
			if($delReason==1){
				$updateAmt=$custRes['pending_amount'];
			}else{
			$updateAmt=$custRes['pending_amount']+$amount;
			}
			$data1 = array(
					"pending_amount" =>$updateAmt,
					"current_due" =>$updateAmt,
					);
			$this->db->where('cust_id',$id);
			$this->db->update('customers', $data1);
			$query = $this->db->query("DELETE FROM payments WHERE customer_id = $id and payment_id='$payment_id'");
			$reason='';
			if($delReason == 1){$reason="Duplicate Entry";}else{$reason="Wrong Entry";}
			
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
			$data2 = array(
				"emp_id" => $emp_id,
				"category" => "Payment Delete",
				"ipaddress" => $ipaddress,
				// "log_text" => $custRes['first_name']." ( ".$custRes['custom_customer_no']." ) payment amount is Deleted Rs.".$amount.". Due to $reason",
				"log_text" => "Payment of Rs.".$amount." has been deleted due to $reason",
				"dateCreated" => date("Y-m-d H:i:s")
			);
			$this->db->insert("change_log", $data2);
			return true;
		}
    }
	
	public function get_inactive_customer_list($limit, $start, $id)
	{
		extract($_REQUEST);
		$chkEmpType=mysql_fetch_assoc(mysql_query("select user_type,admin_id from employes_reg where emp_id=$id"));
		extract($chkEmpType);
		if($user_type==9)
		{
				$qry= "select * from customers WHERE status=0 ";
				if(isset($inputCCN) && $inputCCN!=''){
					$qry.=" AND custom_customer_no='$inputCCN'";
				}
				if(isset($inputFname) && $inputFname!=''){
					$qry.=" AND (first_name LIKE '%$inputFname%' or last_name LIKE '%$inputFname%')";
				}
				if(isset($inputMobile) && $inputMobile!=''){
					$qry.=" AND (mobile_no='$inputMobile' OR stb_no LIKE '%$inputMobile%')";
				}
				if(isset($inputEmp) && $inputEmp!='')
				{
					$qry.= " AND customers.admin_id='$inputEmp'";
				}
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND group_id='$inputGroup'";
				}
				else
				{
					$qry.= " limit ". $start . ", " . $limit;
				}
				$query = $this->db->query($qry);
		}
		elseif($user_type==1)
		{
				$qry= "select * from customers WHERE status=0 AND admin_id='$admin_id'";
				if(isset($inputCCN) && $inputCCN!=''){
					$qry.=" AND custom_customer_no='$inputCCN'";
				}
				if(isset($inputFname) && $inputFname!=''){
					$qry.=" AND (first_name LIKE '%$inputFname%' or last_name LIKE '%$inputFname%')";
				}
				if(isset($inputMobile) && $inputMobile!=''){
					$qry.=" AND (mobile_no='$inputMobile' OR stb_no LIKE '%$inputMobile%')";
				}
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND group_id='$inputGroup'";
				}
				else
				{
					$qry.= " limit ". $start . ", " . $limit;
				}
				$query = $this->db->query($qry);
		}
		else
		{
			 	$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
				$grp_ids=$chkEmpGrps['group_ids'];
             	$qry= "select * from customers  WHERE status=0 AND group_id IN ($grp_ids) ";
				if(isset($inputCCN) && $inputCCN!=''){
					$qry.=" AND custom_customer_no='$inputCCN'";
				}
				if(isset($inputFname) && $inputFname!=''){
					$qry.=" AND (first_name LIKE '%$inputFname%' or last_name LIKE '%$inputFname%')";
				}
				if(isset($inputMobile) && $inputMobile!=''){
					$qry.=" AND (mobile_no='$inputMobile' OR stb_no LIKE '%$inputMobile%')";
				}
				if(isset($inputGroup) && $inputGroup!=''){
					$qry.=" AND group_id='$inputGroup'";
				}
				else
				{
					$qry.= " limit ". $start . ", " . $limit;
				}
			$query = $this->db->query($qry);
		}
        return $query->result_array();
	}
	
	// Customer Dashboard Functions
	public function get_transactions_by_id($id)
	{
        $query = $this->db->query("select * from payments where customer_id = $id");
        return $query->result_array();
    }
	
	public function get_complaints_by_id($id)
	{
        $query = $this->db->query("select * from create_complaint where customer_id = $id");;
        return $query->result_array();
    }
	
	public function get_program_specific($program_id) {
		$query=mysql_query("SELECT cust_id,custom_customer_no FROM customers WHERE group_id='".$program_id."' ORDER BY cust_id DESC limit 0,1");
		$result=mysql_fetch_assoc($query);
		return $result['custom_customer_no'];
	}
	
	public function generate_pwds()
	{	
		$sel_customer=mysql_query("select cust_id,mobile_no from customers");
		while($cust_res=mysql_fetch_assoc($sel_customer)){
				$id=$cust_res['cust_id'];
				$pwds = $cust_res['mobile_no'];
				$data = array(
					"pwd" => $pwds
				);
				$this->db->where('cust_id', $id);
				$this->db->update('customers', $data);
		}
		return 1;
	}
	
	public function get_customer_disable($id)
	{
		extract($_REQUEST);
			$data = array(
				"status" => 0,
				"inactive_date" => date('Y-m-d H:i:s')
			);
		$this->db->where('cust_id', $id);
		$this->db->update('customers', $data);
	
		$data1 = array(
					"cust_id" => $id,
					"remarks"=>$inputRemarks,
					"inactive_date" => date('Y-m-d H:i:s'),
					"datecreated" => date('Y-m-d H:i:s')
		);
		$this->db->insert("customers_inactive", $data1);
		return 1;
	}
	
	public function delete_stb($program_id=NULL,$program_id2=NULL) {
		$query = $this->db->query("select * from set_top_boxes where cust_id = '$program_id' AND stb_id='$program_id2'")->result_array();
		if(count($query)>0)
		{
		    $query2 = $this->db->query("delete from set_top_boxes where cust_id = $program_id AND stb_id='$program_id2'");
		    return 1;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_stb_by_id($cust_id=NULL)
	{
		$query = $this->db->query("select s.*,c.first_name,c.end_date,c.custom_customer_no,c.pending_amount,c.admin_id from customers c LEFT JOIN set_top_boxes s ON c.cust_id=s.cust_id where c.cust_id = '$cust_id'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquets($cust_id=NULL,$stb_id=NULL) {
		$query = $this->db->query("select ca.*,p.package_id,p.package_name,p.package_price,p.ala_channels,(select lco_price from operator_packages where package_id=p.package_id AND admin_id=(select admin_id from customers where cust_id=ca.cust_id)) as lco_price,(select pack_tax from operator_packages where package_id=p.package_id AND admin_id=(select admin_id from customers where cust_id=ca.cust_id)) as pack_tax from customer_alacarte ca LEFT JOIN packages p ON ca.pack_id=p.package_id where ca.cust_id = '$cust_id' AND ca.stb_id='$stb_id' AND ca.pack_id!='' AND p.package_id!='' ORDER BY ca.ca_id ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_pay_channels($cust_id=NULL,$stb_id=NULL) {
		$query = $this->db->query("select ca.*,ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_price from customer_alacarte ca LEFT JOIN alacarte_channels ac ON ca.ala_ch_id=ac.ala_ch_id where ca.cust_id = '$cust_id' AND ca.stb_id='$stb_id' AND ca.ala_ch_id!='' AND ac.ala_ch_id!=''")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_bouquets($admin_id=NULL)
	{
	    if($admin_id!='')
	    {
		    $query = $this->db->query("select p.*,op.cust_price,op.lco_price from packages p LEFT JOIN operator_packages op ON p.package_id=op.package_id where op.admin_id='$admin_id' AND op.op_status=1 order by p.package_name ASC")->result_array();
	    }
	    else
	    {
	        $query = $this->db->query("select p.*,op.cust_price,op.lco_price from packages p LEFT JOIN operator_packages op ON p.package_id=op.package_id where p.isbase!='Yes' AND op.admin_id='$admin_id' order by p.package_name ASC")->result_array();
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
	
	public function get_pay_channels($cust_id=NULL,$stb_id=NULL)
	{
		$query = $this->db->query("select * from alacarte_channels where ala_ch_type = '2' order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquets_req($cust_id=NULL,$stb_id=NULL) {
	    $date=date("Y-m-01");
		$query = $this->db->query("select ca.pack_id,p.package_name,p.package_price,p.ala_channels from alacarte_request ca LEFT JOIN packages p ON ca.pack_id=p.package_id where ca.cust_id = '$cust_id' AND ca.stb_id='$stb_id' AND ca.pack_id!='' AND p.package_id!='' AND ca.ar_month='$date' AND ca.sms_status=0")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_pay_channels_req($cust_id=NULL,$stb_id=NULL) {
	    $date=date("Y-m-01");
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_price from alacarte_request ca LEFT JOIN alacarte_channels ac ON ca.ala_ch_id=ac.ala_ch_id where ca.cust_id = '$cust_id' AND ca.stb_id='$stb_id' AND ca.ala_ch_id!='' AND ac.ala_ch_id!='' AND ca.ar_month='$date'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function add_stb_request()
	{
	    extract($_REQUEST);
	    $empId=$this->session->userdata('emp_id');
		$adminId=$this->session->userdata('admin_id');
		$temp1 = $this->db->query("select admin_id from customers where cust_id = '$cust_id'")->result_array();
		$chkEmpType=$this->db->query("select admin_id,user_type from employes_reg where emp_id=$empId")->result_array();
		if($temp1[0]['admin_id']==$adminId || $chkEmpType[0]['user_type']==9)
		{
			foreach($newBouquet as $key => $nbInfo)
			{
				if($nbInfo!='')
				{
					$data1 = array(
						"cust_id" => $cust_id,
						"stb_id" => $stb_id,
						"pack_id" => $nbInfo,
						"ar_month" => date("Y-m-01"),
						"dateCreated" => date("Y-m-d H:i:s"),
						"emp_id" => $empId
					);
					$this->db->insert("alacarte_request", $data1);
				}
			}
			foreach($newAlacartes as $key => $nalaInfo)
			{
				if($nalaInfo!='')
				{
					$data2 = array(
						"cust_id" => $cust_id,
						"stb_id" => $stb_id,
						"ala_ch_id" => $nalaInfo,
						"ar_month" => date("Y-m-01"),
						"dateCreated" => date("Y-m-d H:i:s"),
						"emp_id" => $empId
					);
					$this->db->insert("alacarte_request", $data2);
				}
			}
			
			if(isset($_REQUEST['renewFlag']) && $_REQUEST['renewFlag']==1)
			{
				$check1 = $this->db->query("SELECT * FROM customer_alacarte WHERE cust_id='$cust_id' AND stb_id='$stb_id'")->result_array();
				if(count($check1)>=1)
				{
					foreach($check1 as $key3 => $existpack)
					{
						extract($existpack);
						$queryDelIns = $this->db->query("INSERT INTO alacarte_remove (cust_id,stb_id,pack_id,ar_month,sms_status,status,removedOn) VALUES ('$cust_id','$stb_id','$pack_id','$ar_month','$sms_status','$status','".date("Y-m-d H:i:s")."')");
						$queryIns = $this->db->query("DELETE from customer_alacarte where cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$pack_id'");
					}
					$optimize = $this->db->query("OPTIMIZE TABLE customer_alacarte");
				}
			}
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function del_cust_bq($cust_id=NULL,$stb_id=NULL,$bq_id=NULL)
	{
		$query = $this->db->query("select ca.* from customer_alacarte ca where ca.cust_id='$cust_id' AND ca.stb_id='$stb_id' AND ca.pack_id='$bq_id' AND ca.ca_status=1")->result_array();
		if(count($query)>0)
		{
		        $packPrice = 0;
    		    if($query[0]['pack_id']!='')
    		    {
    		        $packID = $query[0]['pack_id'];
    		        $pack1 = $this->db->query("select package_price,package_name,mso_ratio from packages where package_id='$packID'")->result_array();
    		        $packPrice = $pack1[0]['package_price'] * ($pack1[0]['mso_ratio']/100);
    		        $packName = $pack1[0]['package_name'];
    		    }
		        $custAccount1 = $this->db->query("select admin_id,cust_balance,pending_amount from customers where cust_id='$cust_id'")->result_array();
		        $admin_id=$custAccount1[0]['admin_id'];
		        $cust_balance=$custAccount1[0]['pending_amount'];
		        $daysInMonth=date("t");
    		    $currentDay=date("d");
    		    $refundDays=$daysInMonth-$currentDay;
    		    
    		    /*$cust_balance2 = -round(($packPrice/$daysInMonth)*$refundDays,2);
		        $data5 = array(
    		        "pending_amount" => round(($cust_balance+$cust_balance2),2)
    		    );
    		    $this->db->where('cust_id', $cust_id);
    		    $this->db->update('customers', $data5);
    		    
                $custAccounting3 = array(
                    "admin_id" => $admin_id,
                    "cust_id" => $cust_id,
                    "stb_id" => $stb_id,
                    "type" => "debit",
                    "amount" => $cust_balance2,
                    "remarks" => $refundDays." days refund.".$packName,
                    "dateCreated" => date("Y-m-d H:i:s"),
                    "created_by" => $adminId
                );
                $this->db->insert("cust_accounting", $custAccounting3);*/
                
		    $data2 = array(
		        "cust_id" => $query[0]['cust_id'],
		        "stb_id" => $query[0]['stb_id'],
		        "ala_ch_id" => $query[0]['ala_ch_id'],
		        "pack_id" => $query[0]['pack_id'],
		        "sms_status" => 0,
		        "status" => 0,
		        "ar_month" => date('Y-m-01'),
		        "removedOn" => date('Y-m-d H:i:s')
		        );
		    $this->db->insert("alacarte_remove", $data2);
		    
		    $temp1 = $this->db->query("delete from customer_alacarte where cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$bq_id'");
		    return true;
		}
		else
		{
		    return 0;
		}
	}
	
	public function del_cust_alacarte($cust_id=NULL,$stb_id=NULL,$ala_id=NULL) {
		$query = $this->db->query("select ca.* from customer_alacarte ca where ca.cust_id='$cust_id' AND ca.stb_id='$stb_id' AND ca.ala_ch_id='$ala_id' AND ca.ca_status=1")->result_array();
		if(count($query)>0)
		{
		        $packPrice = 0;
    		    if($query[0]['ala_ch_id']!='')
    		    {
    		        $ch_id = $query[0]['ala_ch_id'];
    		        $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
    		        $packPrice = $pack1[0]['ala_ch_price'] * ($pack1[0]['mso_ratio']/100);
    		        $packName = $pack1[0]['ala_ch_name'];
    		    }
		        $custAccount1 = $this->db->query("select admin_id,cust_balance,pending_amount from customers where cust_id='$cust_id'")->result_array();
		        $admin_id=$custAccount1[0]['admin_id'];
		        $cust_balance=$custAccount1[0]['pending_amount'];
		        $daysInMonth=date("t");
    		    $currentDay=date("d");
    		    $refundDays=$daysInMonth-$currentDay;
    		    
    		    /*$cust_balance2 = -round(($packPrice/$daysInMonth)*$refundDays,2);
		        $data5 = array(
    		        "pending_amount" => round(($cust_balance+$cust_balance2),2)
    		    );
    		    $this->db->where('cust_id', $cust_id);
    		    $this->db->update('customers', $data5);
    		    
                $custAccounting3 = array(
                    "admin_id" => $admin_id,
                    "cust_id" => $cust_id,
                    "stb_id" => $stb_id,
                    "type" => "credit",
                    "amount" => $cust_balance2,
                    "remarks" => $refundDays." days refund.".$packName,
                    "dateCreated" => date("Y-m-d H:i:s"),
                    "created_by" => $adminId
                );
                $this->db->insert("cust_accounting", $custAccounting3);*/
                
		    $data2 = array(
		        "cust_id" => $query[0]['cust_id'],
		        "stb_id" => $query[0]['stb_id'],
		        "ala_ch_id" => $query[0]['ala_ch_id'],
		        "pack_id" => $query[0]['pack_id'],
		        "sms_status" => 0,
		        "status" => 0,
		        "ar_month" => date('Y-m-01'),
		        "removedOn" => date('Y-m-d H:i:s')
		        );
		    $this->db->insert("alacarte_remove", $data2);
		    
		    $temp1 = $this->db->query("delete from customer_alacarte where cust_id='$cust_id' AND stb_id='$stb_id' AND ala_ch_id='$ala_id'");
		    return true;
		}
		else
		{
		    return 0;
		}
	}
	
	public function check_lco_wallet($admin_id=NULL) {
		$query = $this->db->query("select admin_id,balance from admin where admin_id='$admin_id'")->result_array();
		if(count($query)>0)
		{
		    $temp1 = $this->db->query("select SUM(ac.ala_ch_price) as totAlaPrice from alacarte_channels ac left join alacarte_request ar ON ar.ala_ch_id=ac.ala_ch_id left join set_top_boxes s ON s.stb_id=ar.stb_id left join customers c ON c.cust_id=s.cust_id where ar.sms_status=0 AND c.admin_id='$admin_id'")->result_array();
		    $temp2 = $this->db->query("select SUM(p.package_price) as totBqPrice from packages p left join alacarte_request ar ON ar.pack_id=p.package_id left join set_top_boxes s ON s.stb_id=ar.stb_id left join customers c ON c.cust_id=s.cust_id where ar.sms_status=0 AND c.admin_id='$admin_id'")->result_array();
		    $totUnapproveAmount = (int) $temp1[0]['totAlaPrice'] + $temp2[0]['totBqPrice'];
		    if($query[0]['balance']>($totUnapproveAmount+100))
		    {
		        return true;
		    }
		    else
		    {
		        return $totUnapproveAmount;
		    }
		}
		else
		{
		    return false;
		}
	}
	
	public function get_base_packages($emp_id=NULL) {
	    $admin_id = $this->session->userdata('admin_id');
	    $chkEmpType=$this->db->query("select admin_id,user_type from employes_reg where emp_id=$emp_id")->result_array();
	    if($chkEmpType[0]['user_type']==9)
	    {
	        $query = $this->db->query("select p.* from packages p where p.package_id!='' AND p.isbase='Yes' AND status=1")->result_array();
	    }
	    else
	    {
		    $query = $this->db->query("select p.* from packages p where p.package_id!='' AND p.isbase='Yes' AND admin_id='$admin_id' AND status=1")->result_array();
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
	
	public function get_customer_stb_info_by_id($stb_id=NULL) {
		$query = $this->db->query("select * from set_top_boxes where stb_id = '$stb_id'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_billing($cust_id=NULL,$stb_id=NULL)
	{
	    $month=date("Y-m-01");
		$query = $this->db->query("select current_month_bill,dateGenerated from billing_info b where b.cust_id = '$cust_id' AND current_month_name='$month'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function renew_stb()
	{
		$emp_id = $this->session->userdata('emp_id');
		$resp = array();
	    extract($_REQUEST);
	    $month=date("Y-m-01");
		$query = $this->db->query("select p.package_id from packages p left join customer_alacarte ca ON p.package_id=ca.pack_id where ca.cust_id = '$cust_id' AND p.cat_id=1")->result_array();
		if(count($query)==0)
		{
			$resp['status'] = "Failed";
			$resp['msg'] = "No Basepack found.";
		    return $resp;
		}
		else
		{
			$temp4 = $this->db->query("select c.cust_id,c.admin_id,c.pending_amount,c.end_date,c.stb_no,c.lco_portal_url,c.lco_username,c.lco_password from customers c where c.cust_id='$cust_id'")->row_array();
			$admin_id = $temp4['admin_id'];
			
			$temp2 = $this->db->query("select balance from admin where admin_id='$admin_id'")->row_array();
			if($temp2['balance']<$existing_price)
			{
				$resp['status'] = "Failed";
				$resp['msg'] = "LCO Wallet is Low. Current Renewal value is Rs.".$existing_price;
				return $resp;
			}
			$cust_end_date = $temp4['end_date'];
			$today = date("Y-m-d");
			if((strtotime($cust_end_date)-strtotime($today))>=0)
			{
				$renewFlag = 0;
				$dateCreated = date('Y-m-d H:i:s');
				$ar_month = date("Y-m-01");
				$sms_status=0;$custPrice = 0;
				$end_date = date("Y-m-d",(strtotime($cust_end_date)+(date("t")*86400)-(86400)));
				$today = date("Y-m-d 00:00:00");
				$getPreviousPacks = $this->db->query("select ca.pack_id from customer_alacarte ca left join packages p ON ca.pack_id=p.package_id where p.package_id!='' AND ca.cust_id='$cust_id' AND ca_date_created<='$today' ORDER BY p.cat_id ASC")->result_array();
				foreach($getPreviousPacks as $key => $pPack)
				{
					$packID = $pPack['pack_id'];
					$check1 = $this->db->query("SELECT alacarte_req_id FROM alacarte_request WHERE cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$packID' AND ar_month>='$ar_month' AND sms_status!=1")->num_rows();
					if($check1==0)
					{
						$temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->row_array();
						
						$queryIns = $this->db->query("INSERT INTO alacarte_request(cust_id,stb_id,pack_id,ar_month,dateCreated,emp_id,sms_status) VALUES ('$cust_id','$stb_id','$packID','$ar_month','$dateCreated','$emp_id','1')");
						
						$beforeExpiryIns = $this->db->query("INSERT INTO before_expiries(cust_id,stb_id,pack_id,expiry_month,created_at,emp_id,cust_end_date) VALUES ('$cust_id','$stb_id','$packID','$ar_month','$dateCreated','$emp_id','$cust_end_date')");
						
						$days = date("t");
						$daysInMonth=date("t");
						$refundDays=$days;
						$packPrice = 0;
						
						$pack2 = $this->db->query("select package_price,package_name,mso_ratio,mso_pack_id,cat_id from packages where package_id='$packID'")->row_array();
						$pack1 = $this->db->query("select package_name,lco_price,cust_price,pack_tax from operator_packages where package_id='$packID' AND admin_id='$admin_id'")->row_array();
						$packPrice = $pack1['lco_price']+($pack1['lco_price'] * ($pack1['pack_tax']/100));
						$packName = $pack1['package_name'];
						$custpackPrice = $pack1['cust_price']+($pack1['cust_price'] * ($pack1['pack_tax']/100));
						$custpackPrice = round(($custpackPrice/$daysInMonth)*$refundDays,2);
						$pack_type = $pack2['cat_id'];
						$pack_no = $pack2['mso_pack_id'];
						$packPrice = round(($packPrice/$daysInMonth)*$refundDays,2);
						if($pack_type==1)
						{
							$renewFlag = 1;
						}
						
						$lcoPackPrice = round($packPrice,2);
						$balance = $temp7['balance'] - $lcoPackPrice;
						$update2 = $this->db->query("UPDATE admin SET balance='$balance' WHERE admin_id='$admin_id'");
						
						$open_bal = $temp7['balance'];
						$remarks = $packName." ( ".$refundDays." days amount)";
						$now = date("Y-m-d H:i:s");
						$insert2 = $this->db->query("INSERT INTO f_accounting (admin_id,cust_id,stb_id,type,open_bal,amount,close_bal,remarks,ac_date,dateCreated,created_by) VALUES ('$admin_id','$cust_id','$stb_id','debit','$open_bal','$lcoPackPrice','$balance','$remarks','$ar_month','$now','$emp_id')");
						
						$remarks2 = $packName." ( ".$refundDays." days amount)";
						
						$actPackPrice = $custpackPrice;
						$custPrice+=$custpackPrice;
						$now = date("Y-m-d H:i:s");
						$insert3 = $this->db->query("INSERT INTO cust_accounting (admin_id,cust_id,stb_id,type,amount,remarks,dateCreated,created_by) VALUES ('$admin_id','$cust_id','$stb_id','credit','$actPackPrice','$remarks2','$now','$emp_id')");
					}
				}
				$where = "";
				if($renewFlag==1){ $where = ",end_date='$end_date'";}
				$update3 = $this->db->query("UPDATE customers SET pending_amount='$custPrice' $where WHERE cust_id='$cust_id'");
				$resp['status'] = "Success";
				$resp['msg'] = "Customer Renewed Successfully.";
				return $resp;
			}
			else
			{
				$renewFlag = 0;
				$dateCreated = date('Y-m-d H:i:s');
				$ar_month = date("Y-m-01");
				$sms_status=1;$custPrice = 0;
				$end_date = date("Y-m-d",(strtotime($cust_end_date)+(date("t")*86400)-(86400)));
				$today = date("Y-m-d 00:00:00");
				$getPreviousPacks = $this->db->query("select ca.pack_id from customer_alacarte ca left join packages p ON ca.pack_id=p.package_id where p.package_id!='' AND ca.cust_id='$cust_id' AND ca_date_created<='$today' ORDER BY p.cat_id ASC")->result_array();
				foreach($getPreviousPacks as $key => $pPack)
				{
					$packID = $pPack['pack_id'];
					$check1 = $this->db->query("SELECT alacarte_req_id FROM alacarte_request WHERE cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$packID' AND ar_month>='$ar_month' AND sms_status!=1")->num_rows();
					if($check1==0)
					{
						$check1 = $this->db->query("SELECT ca_id FROM customer_alacarte WHERE cust_id='$cust_id' AND pack_id='$packID' AND ca_status=1 AND ca_date_created<'$today'")->num_rows();
						if($check1>=1)
						{
							$queryDelIns = $this->db->query("INSERT INTO alacarte_remove (cust_id,stb_id,pack_id,ar_month,sms_status,status,removedOn) VALUES ('$cust_id','$stb_id','$packID','".date('Y-m-01')."','1','1','$dateCreated')");
							$queryIns = $this->db->query("DELETE from customer_alacarte where cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$packID'");
						}
						
						$queryIns = $this->db->query("INSERT INTO alacarte_request(cust_id,stb_id,pack_id,ar_month,dateCreated,emp_id,sms_status) VALUES ('$cust_id','$stb_id','$packID','$ar_month','$dateCreated','$emp_id','1')");
						
						$temp8 = $this->db->query("select admin_id,pending_amount,end_date,stb_no,lco_portal_url,lco_username,lco_password from customers where cust_id='$cust_id'")->row_array();
						$cust_end_date = $temp8['end_date'];
						$today = date("Y-m-d");
						$diff = (strtotime($cust_end_date)-strtotime($today));
						$remaining_days = floor($diff / 86400);
						echo "Remaining Days :: ".$remaining_days;
						if($remaining_days>0)
						{
							$days = ($remaining_days+1);
							$end_date = $cust_end_date;
						}
						else
						{
							$days = date("t");
							$end_date = date("Y-m-d",(strtotime("+1 month")-(86400)));
						}
						$daysInMonth=date("t");
						$refundDays=$days;
						$packPrice = 0;
						
						$pack2 = $this->db->query("select package_price,package_name,mso_ratio,mso_pack_id,cat_id from packages where package_id='$packID'")->row_array();
						$pack1 = $this->db->query("select package_name,lco_price,cust_price,pack_tax from operator_packages where package_id='$packID' AND admin_id='$admin_id'")->row_array();
						$packPrice = $pack1['lco_price']+($pack1['lco_price'] * ($pack1['pack_tax']/100));
						$packName = $pack1['package_name'];
						$custpackPrice = $pack1['cust_price']+($pack1['cust_price'] * ($pack1['pack_tax']/100));
						$custpackPrice = round(($custpackPrice/$daysInMonth)*$refundDays,2);
						$pack_type = $pack2['cat_id'];
						$pack_no = $pack2['mso_pack_id'];
						$packPrice = round(($packPrice/$daysInMonth)*$refundDays,2);
						if($pack_type==1)
						{
							$renewFlag = 1;
						}
						$temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->row_array();
						if($temp7['balance']>$packPrice)
						{
							$lcoPackPrice = round($packPrice,2);
							$balance = $temp7['balance'] - $lcoPackPrice;
							$update2 = $this->db->query("UPDATE admin SET balance='$balance' WHERE admin_id='$admin_id'");
							
							$open_bal = $temp7['balance'];
							$remarks = $packName." ( ".$refundDays." days amount)";
							$now = date("Y-m-d H:i:s");
							$insert2 = $this->db->query("INSERT INTO f_accounting (admin_id,cust_id,stb_id,type,open_bal,amount,close_bal,remarks,ac_date,dateCreated,created_by) VALUES ('$admin_id','$cust_id','$stb_id','debit','$open_bal','$lcoPackPrice','$balance','$remarks','$ar_month','$now','$emp_id')");
							
							$actPackPrice = $custpackPrice;
							$custPrice+=$custpackPrice;
							
							$remarks2 = $packName." ( ".$refundDays." days amount)";
							$now = date("Y-m-d H:i:s");
							$insert3 = $this->db->query("INSERT INTO cust_accounting (admin_id,cust_id,stb_id,type,amount,remarks,dateCreated,created_by) VALUES ('$admin_id','$cust_id','$stb_id','credit','$actPackPrice','$remarks2','$now','$emp_id')");
							
							$ca_expiry = $end_date;
							$now = date("Y-m-d H:i:s");
							$insert4 = $this->db->query("INSERT INTO customer_alacarte (cust_id,stb_id,pack_id,ca_status,ca_expiry,ca_date_created) VALUES ('$cust_id','$stb_id','$packID','1','$ca_expiry','$now')");
							
							$lco_portal_url = $temp8['lco_portal_url'];
							$lco_username = $temp8['lco_username'];
							$lco_password = $temp8['lco_password'];
							$stb_no = $temp8['stb_no'];
							$packNos[] = $pack_no;
							$Datecreated = date("Y-m-d");
							$nxt_db = $this->load->database('nxt_db', TRUE);
							
							$nxtPackData = array();
							$nxtPackData['portal_url'] = $lco_portal_url;
							$nxtPackData['Username'] = $lco_username;
							$nxtPackData['Password'] = $lco_password;
							$nxtPackData['Cust_id'] = $cust_id;
							$nxtPackData['Box_no'] = $stb_no;
							$nxtPackData['pack_type'] = $pack_type;
							$nxtPackData['pack_no'] = $pack_no;
							$nxtPackData['Action'] = 'Add Pack';
							$nxtPackData['Datecreated'] = date("Y-m-d");
							$nxtPackData['Status'] = 0;
							$nxt_db->insert("add_packages", $nxtPackData);
						}
					}
				}
				$where2 = "";
				if($renewFlag==1){ $where2 = ",end_date='$end_date'";}
				$update3 = $this->db->query("UPDATE customers SET pending_amount='$custPrice' $where2 WHERE cust_id='$cust_id'");
				$packNos = implode(",",$packNos);
				
				$nxt_db = $this->load->database('nxt_db', TRUE);
				$lco_portal_url = $temp4['lco_portal_url'];
				$lco_username = $temp4['lco_username'];
				$lco_password = $temp4['lco_password'];
				$stb_no = $temp4['stb_no'];
				
				$nxtPackData = array();
				$nxtPackData['portal_url'] = $lco_portal_url;
				$nxtPackData['Username'] = $lco_username;
				$nxtPackData['Password'] = $lco_password;
				$nxtPackData['Cust_id'] = $cust_id;
				$nxtPackData['Box_no'] = $stb_no;
				$nxtPackData['pack_no'] = $packNos;
				$nxtPackData['Mac_id'] = 0;
				$nxtPackData['Action'] = 'renew';
				$nxtPackData['Datecreated'] = date("Y-m-d");
				$nxtPackData['Status'] = 0;
				$nxt_db->insert("useractivation", $nxtPackData);
				
				$resp['status'] = "Success";
				$resp['msg'] = "Customer Renewed Successfully.";
				return $resp;
			}
	        $resp['status'] = "Failed";
			$resp['msg'] = "Customer Renew Failed.";
			return $resp;
		}
	}
	
    public function get_payments_online($limit, $start, $id)
    {
		extract($_REQUEST);
		$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$id"));
		$grp_ids=$chkEmpGrps['group_ids'];
		$chkEmp=mysql_fetch_assoc(mysql_query("select user_type from employes_reg where emp_id=$id"));
		if($chkEmp['user_type']=='1'){
			$month=date("Y-m-00 00:00:00");
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month' AND payments.transaction_type=0)";
		    //echo "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month' AND payments.transaction_type=0)";
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
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
				// $qry.=" AND payments.dateCreated='$mobile'";
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d H:i:s",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND payments.dateCreated BETWEEN '$from_date' AND '$to_date'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);		
		}else{
			$month=date("Y-m-00 00:00:00");
			$qry = "SELECT customers.custom_customer_no,customers.first_name,customers.mobile_no,payments.amount_paid,customers.pending_amount, payments.customer_id,payments.transaction_type,payments.emp_id,payments.invoice,payments.dateCreated,employes_reg.emp_first_name,groups.group_name FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON payments.emp_id=employes_reg.emp_id RIGHT JOIN groups ON customers.group_id=groups.group_id where (payments.dateCreated >= '$month' and payments.grp_id IN ($grp_ids) AND payments.transaction_type=0)";
			
			if((isset($inputCCN) && $inputCCN!=''))
			{
				$qry.=" AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.=" AND customers.first_name LIKE '%$inputFname%' OR last_name LIKE '%$inputFname%'";
			}
			if(isset($mobile) && $mobile!='')
			{
				$qry.=" AND customers.mobile_no='$mobile'";
			}			
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.=" AND employes_reg.emp_id = '$inputEmp'";
			}
			if(isset($inputGroup) && $inputGroup!='')
			{
				$qry.=" AND groups.group_id = '$inputGroup'";
			}
				$qry.=" ORDER BY payments.dateCreated DESC limit $start,$limit";
			$query = $this->db->query($qry);
		}
	    return $query->result_array();
    }
    
    public function get_groups($emp_id=NULL,$admin_id=NULL)
	{
	    $res1 = $this->db->query("select group_ids from emp_to_group where emp_id='$emp_id'")->result_array();
	    if(count($res1)>0)
	    {
	        $grp_ids.=$res1[0]['group_ids'];
	    }
	    else
	    {
	        $grp_ids = "0";
	    }
	   // $grp_ids = substr($grp_ids,0,-1);
	   // echo $grp_ids;exit;
		$query = $this->db->query("select * from groups where group_id IN ($grp_ids)")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_employee_access($emp_id=NULL,$admin_id=NULL)
	{
		$query = $this->db->query("select * from emp_access_control where emp_id='$emp_id'")->result_array();
		if(count($query)>0)
		{
		    return $query[0];
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_employee_info($emp_id=NULL,$admin_id=NULL)
	{
		$query = $this->db->query("select * from employes_reg where emp_id='$emp_id'")->result_array();
		if(count($query)>0)
		{
		    return $query[0];
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_packages($emp_id=NULL,$admin_id=NULL)
	{
		$query = $this->db->query("select * from packages where admin_id='1' AND isbase='Yes'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_operator_packages($admin_id=NULL)
	{
		$query = $this->db->query("select * from operator_packages where admin_id='$admin_id'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_newly_added_requests($cust_id=NULL,$stb_id=NULL)
	{
	    $now = date("Y-m-d H:i:00",strtotime("-2 minutes"));
		$query = $this->db->query("select * from alacarte_request ar where ar.cust_id = '$cust_id' AND ar.stb_id='$stb_id' AND ar.dateCreated>='$now'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function stb_retrack($cust_id=NULL,$stb_id=NULL,$stb_no=NULL)
	{
	    $empId=$this->session->userdata('emp_id');
		$adminId=$this->session->userdata('admin_id');
		$date = date('Y-m-d H:i:s',strtotime("-30 mins"));
		$rows = array();
        $check_retrack = $this->db->query("select srt_id from stb_retrack where created_at>='$date' AND cust_id='$cust_id'")->num_rows();
		if($check_retrack==0)
		{
			$cust_info = $this->db->query("SELECT cust_id,lco_portal_url,lco_username,lco_password,stb_no from customers where cust_id='$cust_id'")->row_array();
			$lco_portal_url = $cust_info['lco_portal_url'];
			$lco_username = $cust_info['lco_username'];
			$lco_password = $cust_info['lco_password'];
			$stb_no = $cust_info['stb_no'];
			
			$data1 = array(
				"cust_id" => $cust_id,
				"stb_id" => $stb_id,
				"stb_no" => $stb_no,
				"created_at" => date("Y-m-d H:i:s"),
				"emp_id" => $empId
			);
			$this->db->insert("stb_retrack", $data1);
			$queryInsId = $this->db->insert_id();
			if($queryInsId)
			{
				$today = date("Y-m-d");
				$nxt_db = $this->load->database('nxt_db', TRUE);
    		    $nxtPackData = array();
    		    $nxtPackData['portal_url'] = $lco_portal_url;
    		    $nxtPackData['Username'] = $lco_username;
    		    $nxtPackData['Password'] = $lco_password;
    		    $nxtPackData['Box_no'] = $stb_no;
    		    $nxtPackData['Action'] = 'retrack';
    		    $nxtPackData['Datecreated'] = date("Y-m-d");
    		    $nxtPackData['Status'] = 0;
    		    $nxtPackData['validate'] = 0;
    		    $nxt_db->insert("box_retrack", $nxtPackData);
				$rows['message']=  "success";
				$rows['text'] = 'Retrack Request Sent Successfully.';
			}
			else
			{
				$rows['message']=  "failed";
				$rows['text'] = 'Request Not Added.';
			}
		}
		else
		{
			$rows['message']=  "failed";
			$rows['text'] = 'Retrack Request already added. Try after 30 mins.';
		}
		return $rows;
	}
	
	public function check_stb_expiry($cust_id=NULL,$stb_id=NULL,$stb_no=NULL)
	{
	    $empId=$this->session->userdata('emp_id');
		$adminId=$this->session->userdata('admin_id');
		$date = date('Y-m-d H:i:s',strtotime("-1 day"));
		$rows = array();
        $check_retrack = $this->db->query("select stb_exp_id from stb_expiry where created_at>='$date' AND cust_id='$cust_id'")->num_rows();
		if($check_retrack==0)
		{
			$cust_info = $this->db->query("SELECT cust_id,lco_portal_url,lco_username,lco_password,stb_no from customers where cust_id='$cust_id'")->row_array();
			$lco_portal_url = $cust_info['lco_portal_url'];
			$lco_username = $cust_info['lco_username'];
			$lco_password = $cust_info['lco_password'];
			$stb_no = $cust_info['stb_no'];
			
			$data1 = array(
				"cust_id" => $cust_id,
				"stb_id" => $stb_id,
				"stb_no" => $stb_no,
				"created_at" => date("Y-m-d H:i:s"),
				"emp_id" => $empId
			);
			$this->db->insert("stb_expiry", $data1);
			$queryInsId = $this->db->insert_id();
			if($queryInsId)
			{
				$bUrl = base_url();
				$escape = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ?  "https" : "http")."://";
				$actUrl = explode(".",str_replace("/","",str_replace($escape,"",$bUrl)));
				$network = $actUrl[0];
				$today = date("Y-m-d");
				$nxt_db = $this->load->database('nxt_db', TRUE);
    		    $nxtPackData = array();
    		    $nxtPackData['portal_url'] = $lco_portal_url;
    		    $nxtPackData['Username'] = $lco_username;
    		    $nxtPackData['Password'] = $lco_password;
    		    $nxtPackData['Box_no'] = $stb_no;
    		    $nxtPackData['cust_id'] = $cust_id;
    		    $nxtPackData['Action'] = 'expiry';
    		    $nxtPackData['Datecreated'] = date("Y-m-d");
    		    $nxtPackData['Status'] = 0;
    		    $nxtPackData['validate'] = 0;
    		    $nxtPackData['network'] = $network;
    		    $nxt_db->insert("box_validation", $nxtPackData);
				$rows['message']=  "success";
				$rows['text'] = 'Expiry Request Sent Successfully.';
			}
			else
			{
				$rows['message']=  "failed";
				$rows['text'] = 'Request Not Added.';
			}
		}
		else
		{
			$rows['message']=  "failed";
			$rows['text'] = 'Expiry Request already added. Check after 10 mins.';
		}
		return $rows;
	}
	
	public function get_stb_expiry($cust_id=NULL,$stb_id=NULL)
	{
		$query = $this->db->query("select * from stb_expiry where cust_id = '$cust_id' AND stb_exp_status=1 ORDER BY stb_exp_id DESC LIMIT 0,1")->result_array();
		if(count($query)>0)
		{
		    return $query[0];
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_stb_expiry_from_nxt()
	{
		$nxt_db = $this->load->database('nxt_db', TRUE);
		$today = date("Y-m-d");
		$bUrl = base_url();
		$escape = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ?  "https" : "http")."://";
        $actUrl = explode(".",str_replace("/","",str_replace($escape,"",$bUrl)));
		$network = $actUrl[0];
		$getBoxValidation = $nxt_db->query("select * from box_validation where Status=1 AND Datecreated='$today' AND network='$network'")->result_array();
		foreach($getBoxValidation as $key => $BoxValidation)
		{
			$expiry = $BoxValidation['validate'];
			$stb_no = $BoxValidation['Box_no'];
			$cust_id = $BoxValidation['cust_id'];
			$now = date("Y-m-d H:i:s");
			$BoxValidationUpdate = $this->db->query("UPDATE stb_expiry SET expiry='$expiry',updated_at='$now',stb_exp_status=1 WHERE cust_id='$cust_id' AND stb_no='$stb_no' AND stb_exp_status=0");
			$affected_rows = $this->db->affected_rows();
			if($affected_rows>0)
			{
				if($expiry=='Expired')
				{
					$custInfo = $this->db->query("select end_date from customers where cust_id='$cust_id'")->row_array();
					$expDate = $custInfo['end_date'];
				}
				elseif($expiry=='Expiring today')
				{
					$expDate = date("Y-m-d");
				}
				else
				{
					$exp = round($expiry);
					$expDate = date("Y-m-d",strtotime("+".$exp." days"));
				}
				$updateCust = $this->db->query("UPDATE customers SET end_date='$expDate' WHERE cust_id='$cust_id' AND stb_no='$stb_no'");
			}
		}
		return 1;
	}
	
	public function get_lco_groups($admin_id=NULL)
	{
		$result = $this->db->query("select * from groups where admin_id = '$admin_id' ORDER BY group_name DESC")->result_array();
		if(count($result)>0)
		{
		    return $result;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_expiry_customer_list($limit, $start, $id)
	{
		extract($_REQUEST);
		$chkEmpType=$this->db->query("select * from employes_reg where emp_id='$id'")->row_array();
		$current_date = date('Y-m-d');
		$admin_id = $chkEmpType['admin_id'];
		if($chkEmpType['user_type']==1 || $chkEmpType['user_type']==9)
		{
			$where = "";
			if($chkEmpType['user_type']==1)
			{
				$where=" AND customers.admin_id='$admin_id'";
			}
			$qry= "select customers.cust_id,customers.first_name,customers.last_name,customers.custom_customer_no,customers.mobile_no,customers.mac_id,customers.stb_no,customers.pending_amount,customers.cust_balance,customers.end_date,(select group_name from groups where group_id=customers.group_id) as group_name,(select package_price from packages where package_id=customers.package_id) as package_price,(select stb_id from set_top_boxes where cust_id=customers.cust_id LIMIT 0,1) as stb_id from customers WHERE customers.status=1 ".$where;
			if(isset($inputCCN) && $inputCCN!='')
			{
				$qry.= " AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.= " AND customers.admin_id='$inputEmp'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.= " AND (customers.first_name LIKE '%$inputFname%' or customers.last_name LIKE '%$inputFname%')";
			}
			if(isset($inputMobile) && $inputMobile!='')
			{
			    $qry.= " AND (customers.mobile_no='$inputMobile' or customers.stb_no LIKE '%$inputMobile%')";
			}
			if((isset($fromdate) && $fromdate!='') && (isset($todate) && $todate!=''))
			{
				$org_fromdate=strtotime($fromdate);
				$from_date=date("Y-m-d 00:00:00",$org_fromdate);
				$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($todate));
				$to_date=date("Y-m-d H:i:s",$org_todate);	
				$qry.=" AND (date(end_date) BETWEEN '$from_date' AND '$to_date') ";
			}
			else
			{
			    $qry.=" AND (date(end_date) <= '$current_date') ";
			}
				$qry.= " limit ". $start . ", " . $limit;
			$query = $this->db->query($qry);
		}
		else
		{
		 	$chkEmpGrps=$this->db->query("select * from emp_to_group where emp_id='$id'")->row_array();
			$grp_ids=$chkEmpGrps['group_ids'];
			$qry = "select customers.cust_id,customers.first_name,customers.last_name,customers.custom_customer_no,customers.mobile_no,customers.mac_id,customers.stb_no,customers.pending_amount,customers.cust_balance,customers.end_date,(select group_name from groups where group_id=customers.group_id) as group_name,(select package_price from packages where package_id=customers.package_id) as package_price,(select stb_id from set_top_boxes where cust_id=customers.cust_id LIMIT 0,1) as stb_id from customers WHERE customers.status=1 AND customers.group_id IN ($grp_ids) AND customers.admin_id='$admin_id'";
			if(isset($inputCCN) && $inputCCN!='')
			{
				$qry.= " AND customers.custom_customer_no='$inputCCN'";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
				$qry.= " AND customers.admin_id='$inputEmp'";
			}
			if(isset($inputFname) && $inputFname!='')
			{
				$qry.= " AND (customers.first_name LIKE '%$inputFname%' or customers.last_name LIKE '%$inputFname%')";
			}
			if(isset($inputMobile) && $inputMobile!='')
			{
			    $qry.= " AND (customers.mobile_no='$inputMobile' or customers.stb_no LIKE '%$inputMobile%')";
			}
			$query = $this->db->query($qry);
		}
        return $query->result_array();
	}
}