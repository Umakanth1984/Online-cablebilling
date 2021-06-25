<?php 
require_once APPPATH."/third_party/PHPExcel.php";
class Import_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function save_import($emp_id=NULL)
	{
		//extract($_FILES);
		$adminId= $this->session->userdata('admin_id');
		if((!$_FILES['import_customer']['error']) && ($_FILES['import_customer'] !=''))
		{
			$new_image=rand(1,10000)."_".$_FILES['import_customer']['name'];
			move_uploaded_file($_FILES['import_customer']['tmp_name'],"import/".$new_image);
		}
		$file = "import/".$new_image;
		$this->load->library('excel');
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}
	
		$data['header'] = $header;
		$data['values'] = $arr_data; 
		$length=sizeof($data['values']);
		$import=$this->db->query("select * from import_customers where admin_id='$adminId'")->result_array();
	 	$uniques = '';$uniqueCount = 0;
		foreach($data['values'] as $key=>$val) 
		{
	 	    extract($import[0]);
	 	    $temp = $this->db->query("select admin_id from admin where email like '".$val[$cust_admin_id]."'")->result_array();
	 	    if(count($temp)>0)
	 	    {
	 	        $cadmin_id = $temp[0]['admin_id'];
    	 	    $temp1 = $this->db->query("select custom_customer_no from customers where custom_customer_no like '".$val[$custom_customer_no]."' AND admin_id='$cadmin_id'")->result_array();
    	        if(count($temp1)==0)
    	        {
    	            $temp2 = $this->db->query("select group_id from groups where group_name like '".$val[$group_id]."' AND admin_id='$cadmin_id'")->result_array();
    	            if(count($temp2)>=1)
    	            {
    	                $temp3 = $this->db->query("select package_id,package_price from packages where package_name like '".$val[$package_id]."'")->result_array();
    	                if(count($temp3)>=1)
    	                {
    	                    $credential_username = $val[$caf_status];
    	                    $temp4 = $this->db->query("select * from credentials where user_name LIKE '$credential_username'")->result_array();
    	                    if(count($temp4)>=1)
    	                    {
                    			if($val[$first_name]==''){$new_first_name="No Name";}else{$new_first_name=$val[$first_name];}
                    			if($val[$last_name]==''){$new_last_name=" ";}else{$new_last_name=$val[$last_name];}
                    			if($val[$addr1]==''){$new_addr1="No Address";}else{$new_addr1=mysql_real_escape_string($val[$addr1]);}
                    			if($val[$addr2]==''){$new_addr2="";}else{$new_addr2=mysql_real_escape_string($val[$addr2]);}
                    			if($val[$city]==''){$new_city="";}else{$new_city=$val[$city];} 
                    			if($val[$state]==''){$new_state="";}else{$new_state=$val[$state];} 
                    			if($val[$pincode]==''){$new_pincode="";}else{$new_pincode=$val[$pincode];} 
                    			if($val[$phone_no]==''){$new_phone_no="0";}else{$new_phone_no=$val[$phone_no];} 
                    			if($val[$mobile_no]==''){$new_mobile_no="1234567890";}else{$new_mobile_no=$val[$mobile_no];} 
                    			if($val[$group_id]==''){$new_group_id="0";}else{$new_group_id=$val[$group_id];} 
                    			if($val[$package_id]==''){$new_package_id="0";}else{$new_package_id=$val[$package_id];}
                    			if($val[$custom_customer_no]==''){$new_custom_customer_no="Z1001";}else{$new_custom_customer_no=$val[$custom_customer_no];}
                    			if($val[$connection_date]==''){$new_connection_date="0000-00-00";}else{
                    				$new_date=strtotime($val[$connection_date]);
                    				$new_connection_date=date('Y-m-d',$new_date);
                    			}
                    			if($val[$mac_id]==''){$new_mac_id="0";}else{$new_mac_id=$val[$mac_id];}
                    			if($val[$stb_no]==''){$new_stb_no="0";}else{$new_stb_no=$val[$stb_no];}
                    			if($val[$card_no]==''){$new_card_no="0";}else{$new_card_no=$val[$card_no];}
                    			if($val[$pending_amount]==''){$new_pending_amount="0";}else{$new_pending_amount=$val[$pending_amount];}
								if($val[$end_date]==''){$new_end_date="0000-00-00";}else{$new_end_date=date("Y-m-d",strtotime($val[$end_date]));}
                    			if($val[$service_poid]==''){$new_service_poid="";}else{$new_service_poid=$val[$service_poid];}
                    			
                    			$data = array(
                    				"admin_id" => $cadmin_id,
                    				"first_name" => $new_first_name,
                    				"last_name" => $new_last_name,
                    				"addr1" => $new_addr1,
                    				"addr2" => $new_addr2,
                    				"city" => $new_city,
                    				"pin_code" => $new_pincode,
                    				"country" => "IND",
                    				"state" => $new_state,
                    				"phone_no" => $new_phone_no,
                    				"mobile_no" => $new_mobile_no,
                    				"group_id" => $temp2[0]['group_id'],
                    				"package_id" => $temp3[0]['package_id'],
                    				"custom_customer_no" => $new_custom_customer_no,
                    				"connection_date" => $new_connection_date,
                    				"dob" => "0000-00-00",
                    				"anniversary_date" => "0000-00-00",
                    				"mac_id" => $new_mac_id,
                    				"stb_no" => $new_stb_no,
                    				"card_no" => $new_card_no,
                    				"pending_amount" => $new_pending_amount,
                    				"current_due" => $new_pending_amount,
									"end_date" => $new_end_date,	
                    				"monthly_bill" => $temp3[0]['package_price'],
                    				"service_poid" => $new_service_poid,
                    				"status" => 1,
                    				"dateCreated" => date('Y-m-d H:i:s'),
                    				"inactive_date" =>0,
                    				"crd_id" => $temp4[0]['crd_id'],
                    				//"lco_portal_url" => $temp4[0]['portal_url'],
									"lco_portal_url" => "https://lcoportal.nxtdigital.in/login.php",
                    				"lco_username" => $temp4[0]['user_name'],
                    				"lco_password" => $temp4[0]['password']
                    			);
                    			$this->db->insert("customers", $data);
                    			$inserted_cust_id = $this->db->insert_id();
                    			
                    			$dt=date('Y-m-d H:i:s');
                    			$e1= explode(",",$new_stb_no);
                    			$mac_id1=explode(",",$new_mac_id);
                    			$card_no1=explode(",",$new_card_no);
                    			$aadhar_no="";
                    			$pack_id1=$temp3[0]['package_id'];
                    			$mso1="1";
                    			foreach($e1 as $key1 => $e)
                    			{
                    				// $check1=$this->db->query("select stb_no from set_top_boxes where stb_no like '$e'")->num_rows();
                    				// if($check1==0)
                    				// {
                    					$insQ=$this->db->query("INSERT INTO set_top_boxes(`cust_id`, `stb_no`, `card_no`, `mac_id`, `aadhar_no`, `pack_id`, `mso_id`, `date_created`) VALUES ('$inserted_cust_id','$e','$card_no1[$key1]','$mac_id1[$key1]','$aadhar_no','$pack_id1','$mso1','$dt')");
                    				// }
                    			}
                    			$uniqueCount++;
    	                    }
    	                    else
    	                    {
    	                        $uniques.="Credential not Exists :".$val[$caf_status]."<br>";
    	                    }
    	                }
    	                else
    			        {
    			            $uniques.="Package not Exists :".$val[$package_id]."<br>";
    			        }
    	            }
    	            else
        	        {
        	            $uniques.="Group Name not Exists:".$val[$group_id]."<br>";
        	        }
    	        }
    	        else
    	        {
    	            $uniques.="Customer ID already Exists:".$val[$custom_customer_no]."<br>";
    	        }
	 	    }
	 	    else
	        {
	            $uniques.="LCO Registered Email not Exists:".$val[$cust_admin_id]."<br>";
	        }
		}
		$ie_id = 0;
		if($uniques!='')
		{
		    $errorData = array(
				"emp_id" => $this->session->userdata('emp_id'),
				"error_message" => $uniques,
				"date_created" => date('Y-m-d H:i:s')
			);
			$this->db->insert("import_errors", $errorData);
			$ie_id = $this->db->insert_id();
		}
		unlink($file);
		return array("uploaded"=>$uniqueCount,"ie_id"=>$ie_id);
	}
	
	public function save_import_dues()
	{
		if((!$_FILES['import_customer']['error']) && ($_FILES['import_customer'] !=''))
		{
			$new_image=rand(900000,999999)."_".$_FILES['import_customer']['name'];
			 move_uploaded_file($_FILES['import_customer']['tmp_name'],"import/".$new_image);
		}
		$file = "import/".$new_image;
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}

		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data; 
		$length=sizeof($data['values']);
		foreach($data['values'] as $key=>$val) 
		{
			$selCust=mysql_fetch_assoc(mysql_query("select cust_id from customers where custom_customer_no='".$val['A']."'"));
			if($selCust['cust_id']!='')
			{
				$data = array(
					"tax_rate" =>$val['D'],
					"pending_amount" =>$val['D']
				);
				$this->db->where("cust_id", $selCust['cust_id']); 
				$this->db->update("customers", $data);
			}
		}
		unlink($file);
		return 1;
	}
	
	public function save_bulk_pay()
	{
		extract($_REQUEST);
		if((!$_FILES['import_customer']['error']) && ($_FILES['import_customer'] !=''))
		{
			$new_image=rand(100000,999999)."_BULKPAY_".$_FILES['import_customer']['name'];
			move_uploaded_file($_FILES['import_customer']['tmp_name'],"import/".$new_image);
		}
		$file = "import/".$new_image;
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data; 
		$length=sizeof($data['values']);
		$busInfo=mysql_fetch_assoc(mysql_query("SELECT * FROM business_information"));
		$format=$busInfo['invoice_code'];
		$busiName=$busInfo['business_name'];
		foreach($data['values'] as $key => $val) 
		{
			$selCust=mysql_fetch_assoc(mysql_query("select cust_id,group_id,admin_id,pending_amount,mobile_no,first_name from customers where mac_id='".$val['A']."'"));
			if(($selCust['cust_id']!='') && ($val['B']!=''))
			{
				$qryRec=mysql_fetch_assoc(mysql_query("select payment_id from payments order by payment_id DESC limit 1"));
				$recNo=$qryRec['payment_id']+1;
				$invoice=$format."/".date("Ymd").date('His')."/".$recNo;
				$updateAmt=$selCust['pending_amount'] - $val['B'];
				$date="2019-05-31 00:00:00";
				$pay_data = array(
					"customer_id" =>$selCust['cust_id'],
					"emp_id" =>$selCust['admin_id'],
					"admin_id" =>"1",
					"amount_paid" =>$val['B'],
					"outstanding_amt" =>$updateAmt,
					"grp_id" => $selCust['group_id'],
					"payment_for_month" => "2019-05",
					"transaction_type" => '1',
					"invoice" => $invoice,
					"cheque_number" => "",
					"bank" => "",
					"branch" => "",
					"instrument_date" => 0,
					"remarks" => 'N/A',
					"dateCreated" => $date
				);
				$this->db->insert("payments", $pay_data);
				
				$cust_data = array(
					"pending_amount" =>$updateAmt,
					"current_due" =>$updateAmt
				);
				$this->db->where('cust_id',$selCust['cust_id']);
				$this->db->update('customers', $cust_data);
			// print_r($val);exit;
			}
		}
		unlink($file);
		return 1;
	}
	
	public function save_package_import()
	{
		if((!$_FILES['import_package']['error']) && ($_FILES['import_package'] !=''))
		{
			$new_image=rand(1,10000)."_".$_FILES['import_package']['name'];
			move_uploaded_file($_FILES['import_package']['tmp_name'],"import/".$new_image);
		}
		$file = "import/".$new_image;
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			foreach ($cell_collection as $cell) {
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
				}
			}
			$data['header'] = $header;
			$data['values'] = $arr_data; 
			$length=sizeof($data['values']);
// 			$import_values=$this->db->query("select bulk_pack_name,bulk_ala_ch_name,bulk_pack_price,bulk_pack_gst,bulk_pack_tot_price,bulk_pack_mso from import_customers where id=1")->result_array();
// 			$import_values=$import_values[0];
			$uCount=0;$uniqueCount = 0;
			$uniques='';
			foreach($data['values'] as $key => $val)
			{
    // 			extract($import_values);
                $admin_info = $this->db->query("select * from admin where email LIKE '".$val['A']."'")->result_array();
			    if(($val['A']!='') && ($val['B']!='') && ($val['C']!='') && ($val['D']!=='') && ($val['E']!=='') && count($admin_info)>0)
			    {
			        $adm_id = $admin_info[0]['admin_id'];
    				$PackageCount=$this->db->query("select * from operator_packages where package_id LIKE '".trim($val['B'])."' AND admin_id='$adm_id'")->result_array();
    				if((count($PackageCount)>=1))
    				{
    				    $Packdata = array(
            		        "lco_price" => round($val['E'],2),
            		        "cust_price" => round($val['D'],2),
            		        "pack_tax" => round($val['F']),
            		        "op_status" => round($val['G'])
            		    );
            		    $this->db->where('op_id', $PackageCount[0]['op_id']);
            		    $this->db->update('operator_packages', $Packdata);
    				    $uCount++;
    				}
    				elseif(count($PackageCount)==0)
    				{
    				    $Packagedata = array(
    				        "admin_id" => $adm_id,
    				        "package_id" => trim($val['B']),
            		        "package_name" => trim($val['C']),
            		        "lco_price" => round($val['E'],2),
            		        "cust_price" => round($val['D'],2),
            		        "pack_tax" => round($val['F']),
            		        "op_status" => round($val['G']),
            		        "created_at" => date('Y-m-d H:i:s')
                    	);
            		    $this->db->insert('operator_packages', $Packagedata);
    			        $pack_id=$this->db->insert_id();
    				    $uCount++;
    				}
    				else
    				{
    					$uniques.="Package not Exists : ".$val['C'];
    				}
			    }
			    else
			    {
			        if($val['A']=='')
			        {
			            $uniques.="Field Value not Exists for : LCO Reg Email<br>";
			        }
			        if($val['B']=='')
			        {
			            $uniques.="Field Value not Exists for : Package Id <br>";
			        }
			        if($val['C']=='')
			        {
			            $uniques.="Field Value not Exists for : Package Name <br>";
			        }
			        if($val['D']==='')
			        {
			            $uniques.="Field Value not Exists for : LCO Price - ".$val['D']." <br>";
			        }
			        if($val['E']==='')
			        {
			            $uniques.="Field Value not Exists for : Customer Price - ".$val['E']." <br>";
			        }
			        if(count($admin_info)==0)
			        {
			            $uniques.="LCO Reg Email not found : ".$val['A']." <br>";
			        }
			    }
			}
			$ie_id = 0;
    		if($uniques!='')
    		{
    		    $errorData = array(
    				"emp_id" => $this->session->userdata('emp_id'),
    				"error_message" => $uniques,
    				"date_created" => date('Y-m-d H:i:s')
    			);
    			$this->db->insert("import_errors", $errorData);
    			$ie_id = $this->db->insert_id();
    		}
// 			unlink($file);
		return array("uploaded"=>$uCount,"ie_id"=>$ie_id);
	}
	
	public function get_error_data_by_id($ie_id=NULL)
	{
	    $error1=$this->db->query("select * from import_errors where ie_id LIKE '".$ie_id."'")->result_array();
	    if(count($error1)>0)
	    {
	        return $error1[0];
	    }
	    return false;
	}
}