<?php 
require_once APPPATH."/third_party/PHPExcel.php";
class Dashboard_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function get_customer_requets($limit, $start)
	{
	    extract($_REQUEST);
	    $adminId=$this->session->userdata('admin_id');
	    $emp_id=$this->session->userdata('emp_id');
	    $temp1 = $this->db->query("select user_type from employes_reg where emp_id='$emp_id' AND status=1")->result_array();
	    //$date=date("Y-m-01");
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
        
	    if($temp1[0]['user_type']==9)
	    {
	        $where1="";
	        if(isset($inputLco) && $inputLco!='')
	        {
	            $where1.=" AND c.admin_id='$inputLco'";
	        }
	        if(isset($inputCCN) && $inputCCN!='')
	        {
	            $where1.=" AND (c.custom_customer_no LIKE '$inputCCN' or s.stb_no LIKE '%$inputCCN%' or s.mac_id LIKE '%$inputCCN%')";
	        }
	        $limit =" limit $start,$limit";
	        //echo "select ar.alacarte_req_id,c.cust_id,c.first_name,c.custom_customer_no,c.mobile_no,c.group_id,c.addr1,s.stb_id,s.mac_id,s.stb_no,s.card_no,(select package_name from packages where package_id=s.pack_id) as basePackage,(select package_price from packages where package_id=s.pack_id) as basePackagePrice,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empName from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.cust_id=c.cust_id where 1 $where1 AND ar.sms_status=0 AND ar.status IS NULL AND (ar.ala_ch_id!='' OR ar.pack_id!='') AND ar.dateCreated BETWEEN '$date1' AND '$date2' group by s.stb_id $limit";
	        $query = $this->db->query("select ar.alacarte_req_id,c.cust_id,c.first_name,c.custom_customer_no,c.mobile_no,c.group_id,c.addr1,s.stb_id,s.mac_id,s.stb_no,s.card_no,(select package_name from packages where package_id=s.pack_id) as basePackage,(select package_price from packages where package_id=s.pack_id) as basePackagePrice,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empName from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.cust_id=c.cust_id where 1 $where1 AND ar.sms_status=0 AND ar.status IS NULL AND (ar.ala_ch_id!='' OR ar.pack_id!='') AND ar.dateCreated BETWEEN '$date1' AND '$date2' group by s.stb_id $limit")->result_array();
	    }
	    else
	    {
	        $where1="";
	        if(isset($inputCCN) && $inputCCN!='')
	        {
	            $where1.=" AND (c.custom_customer_no LIKE '$inputCCN' or s.stb_no LIKE '%$inputCCN%' or s.mac_id LIKE '%$inputCCN%')";
	        }
	        $limit =" limit $start,$limit";
	        //echo "select ar.alacarte_req_id,c.cust_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.mac_id,s.stb_no,s.card_no,(select package_name from packages where package_id=s.pack_id) as basePackage,(select package_price from packages where package_id=s.pack_id) as basePackagePrice,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empName from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.cust_id=c.cust_id where 1 $where1 AND c.admin_id='$adminId' AND ar.sms_status=0 AND ar.status IS NULL AND ar.dateCreated BETWEEN '$date1' AND '$date2' group by s.stb_id $limit";
	        $query = $this->db->query("select ar.alacarte_req_id,c.cust_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,s.stb_id,s.mac_id,s.stb_no,s.card_no,(select package_name from packages where package_id=s.pack_id) as basePackage,(select package_price from packages where package_id=s.pack_id) as basePackagePrice,(select emp_first_name from employes_reg where emp_id=ar.emp_id) as empName from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.cust_id=c.cust_id where 1 $where1 AND c.admin_id='$adminId' AND ar.sms_status=0 AND ar.status IS NULL AND ar.dateCreated BETWEEN '$date1' AND '$date2' group by s.stb_id $limit")->result_array();
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
	
    public function get_customer_alacarte_req($cust_id=NULL,$stb_id=NULL)
    {
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ar.alacarte_req_id from alacarte_request ar left join alacarte_channels ac ON ar.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.sms_status=0 order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet_req($cust_id=NULL,$stb_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,p.package_name,ar.alacarte_req_id,(select lco_price from operator_packages where package_id=p.package_id AND admin_id=(select admin_id from customers where cust_id=ar.cust_id)) as lco_price from alacarte_request ar left join packages p ON ar.pack_id=p.package_id where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.pack_id!='' AND ar.sms_status=0 order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_requets_pending($cust_id=NULL,$stb_id=NULL)
	{
	    $adminId=$this->session->userdata('admin_id');
	    $emp_id=$this->session->userdata('emp_id');
	    $temp1 = $this->db->query("select user_type from employes_reg where emp_id='$emp_id' AND status=1")->result_array();
	    $date=date("Y-m-01");
	    if($temp1[0]['user_type']==9)
	    {
	        $query = $this->db->query("select ar.alacarte_req_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,c.cust_balance,c.pending_amount,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select package_name from packages where package_id=s.pack_id) as basePackage,(select package_price from packages where package_id=s.pack_id) as basePackagePrice from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.sms_status=0")->result_array();
	    }
	    else
	    {
		    $query = $this->db->query("select ar.alacarte_req_id,c.cust_id,c.admin_id,c.first_name,c.custom_customer_no,c.mobile_no,c.addr1,c.cust_balance,c.pending_amount,s.stb_id,s.stb_no,s.mac_id,s.card_no,(select package_name from packages where package_id=s.pack_id) as basePackage,(select package_price from packages where package_id=s.pack_id) as basePackagePrice from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.stb_id=ar.stb_id where c.admin_id='$adminId' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.sms_status=0")->result_array();
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
	
	public function get_customer_alacarte_req_pending($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_price from alacarte_request ar left join alacarte_channels ac ON ar.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.alacarte_req_id='$req_id' order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet_req_pending($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,p.package_name,(select lco_price from operator_packages where package_id=p.package_id AND admin_id=(select admin_id from customers where cust_id=ar.cust_id)) as lco_price,p.package_price from alacarte_request ar left join packages p ON ar.pack_id=p.package_id where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.pack_id!='' AND ar.alacarte_req_id='$req_id' order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function add_to_stb($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
	    $adminId=$this->session->userdata('admin_id');
		$query = $this->db->query("select ar.* from alacarte_request ar where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.alacarte_req_id='$req_id' AND ar.sms_status=0")->result_array();
		if(count($query)>0)
		{
			$renewFlag = 0;
	        $temp8 = $this->db->query("select admin_id,cust_balance,current_due,pending_amount,end_date,lco_portal_url,lco_username,lco_password from customers where cust_id='$cust_id'")->result_array();
	        $stb_info = $this->db->query("select stb_no from set_top_boxes where cust_id='$cust_id' AND stb_id='$stb_id'")->result_array();
	        $cust_end_date = $temp8[0]['end_date'];
			$pending_amount = $temp8[0]['pending_amount'];
	        $today = date("Y-m-d");
	        $diff = (strtotime($cust_end_date)-strtotime($today));
			$remaining_days = floor($diff / 86400);
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
    		  //  $currentDay=date("d")-1;
		  //  $refundDays=$daysInMonth-$currentDay;
		    $refundDays=$days;
			
		    $admin_id=$temp8[0]['admin_id'];
		    $d1=date("Y-m-01");
		    $packPrice = 0;
		    if($query[0]['ala_ch_id']!='')
		    {
		        $ch_id = $query[0]['ala_ch_id'];
		        $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio,ala_ch_type,mso_pack_id from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
		        $packPrice = $pack1[0]['ala_ch_price'] * ($pack1[0]['mso_ratio']/100);
		        $packName = $pack1[0]['ala_ch_name'];
		        $pack_type = $pack1[0]['ala_ch_type'];
		        $pack_no = $pack1[0]['mso_pack_id'];
		        $packPrice = round(($packPrice/$daysInMonth)*$refundDays,2);
		    }
		    elseif($query[0]['pack_id']!='')
		    {
		        $packID = $query[0]['pack_id'];
		        $pack2 = $this->db->query("select package_price,package_name,mso_ratio,mso_pack_id,cat_id from packages where package_id='$packID'")->result_array();
		        $pack1 = $this->db->query("select package_name,lco_price,cust_price,pack_tax from operator_packages where package_id='$packID' AND admin_id='$admin_id'")->result_array();
		        $packPrice = $pack1[0]['lco_price']+($pack1[0]['lco_price'] * ($pack1[0]['pack_tax']/100));
		        $packName = $pack1[0]['package_name'];
		        $custpackPrice = $pack1[0]['cust_price']+($pack1[0]['cust_price'] * ($pack1[0]['pack_tax']/100));
		        $custpackPrice = round(($custpackPrice/$daysInMonth)*$refundDays,2);
		        $pack_type = $pack2[0]['cat_id'];
		        $pack_no = $pack2[0]['mso_pack_id'];
		        $packPrice = round(($packPrice/$daysInMonth)*$refundDays,2);
				if($pack_type==1)
				{
					$pending_amount = 0;
					$renewFlag = 1;
				}
		    }
		  //  $daysInMonth=date("t");
		  //  $currentDay=date("d")-1;
		  //  $refundDays=$daysInMonth-$currentDay;
		    $temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
		    if($temp7[0]['balance']>$packPrice)
		    {
    		    $data1 = array(
    		        "sms_status" => 1,
    		    );
    		    $this->db->where('cust_id', $cust_id);
    		    $this->db->where('stb_id', $stb_id);
    		    $this->db->where('alacarte_req_id', $req_id);
    		    $this->db->update('alacarte_request', $data1);
    		    
    		    $lcoPackPrice = round($packPrice,2);
    		    $balance = $temp7[0]['balance'] - $lcoPackPrice;
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
    		        "amount" => $lcoPackPrice,
    		        "close_bal" => $balance,
    		        "remarks" => $packName." ( ".$refundDays." days amount)",
    		        "ac_date" => date("Y-m-01"),
    		        "dateCreated" => date("Y-m-d H:i:s"),
    		        "created_by" => $adminId
    		    );
    		    $this->db->insert("f_accounting", $data4);
    		    
    		    $actPackPrice = $custpackPrice;
    		    $cust_balance2 = round($pending_amount+$custpackPrice,2);
    		    $data5 = array(
    		        "pending_amount" => $cust_balance2
    		    );
    		    $this->db->where('cust_id', $cust_id);
    		    $this->db->update('customers', $data5);
    		    
    		    $custAccounting3 = array(
    		        "admin_id" => $admin_id,
    		        "cust_id" => $cust_id,
                    "stb_id" => $stb_id,
    		        "type" => "credit",
    		        "amount" => $actPackPrice,
    		        "remarks" => $packName." ( ".$refundDays." days amount)",
    		        "dateCreated" => date("Y-m-d H:i:s"),
    		        "created_by" => $adminId
    		    );
    		    $this->db->insert("cust_accounting", $custAccounting3);
    		    
    		    $data2 = array(
    		        "cust_id" => $query[0]['cust_id'],
    		        "stb_id" => $query[0]['stb_id'],
    		        "ala_ch_id" => $query[0]['ala_ch_id'],
    		        "pack_id" => $query[0]['pack_id'],
    		        "ca_status" => 1,
    		        "ca_expiry" => date("Y-m-d",strtotime($refundDays." days")),
    		        "ca_date_created" => date('Y-m-d H:i:s')
    		    );
    		    $this->db->insert("customer_alacarte", $data2);
				
    		    if($renewFlag==1)
				{
					$this->db->update("customers",array("end_date"=>$end_date),array("cust_id"=>$cust_id));
				}
    		    
    		    $lco_portal_url = $temp8[0]['lco_portal_url'];
    			$lco_username = $temp8[0]['lco_username'];
    			$lco_password = $temp8[0]['lco_password'];
    		    $nxt_db = $this->load->database('nxt_db', TRUE);
    		    
    		    $nxtPackData = array();
    		    $nxtPackData['portal_url'] = $lco_portal_url;
    		    $nxtPackData['Username'] = $lco_username;
    		    $nxtPackData['Password'] = $lco_password;
    		    $nxtPackData['Cust_id'] = $query[0]['cust_id'];
    		    $nxtPackData['Box_no'] = $stb_info[0]['stb_no'];
    		    $nxtPackData['pack_type'] = $pack_type;
    		    $nxtPackData['pack_no'] = $pack_no;
    		    $nxtPackData['Action'] = 'Add Pack';
    		    $nxtPackData['Datecreated'] = date("Y-m-d");
    		    $nxtPackData['Status'] = 0;
    		    $nxt_db->insert("add_packages", $nxtPackData);
    		    return true;
		    }
		    elseif($packPrice=='')
		    {
		        return "Pacakge is not available in Operator Packages.";
		    }
		    else
		    {
		        return "Low balance for LCO.!";
		    }
		}
		else
		{
		    return 0;
		}
	}
	
	public function lco_franchise_list()
	{
		$query = $this->db->query("select a.*,(select emp_first_name from employes_reg where admin_id=a.admin_id AND user_type=1 order by emp_id ASC LIMIT 0,1) as adminFname from admin a left join employes_reg e ON e.admin_id=a.admin_id where a.franchise_type=1 and e.emp_id !='' group by a.admin_id")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_ajax_lco_data($program_id=NULL)
	{
		$temp = $this->db->get_where("admin", array("admin_id" => $program_id))->result_array();
		return $temp[0]['balance'];
	}
	
	public function check_emp_type($emp_id=NULL)
	{
		$query = $this->db->query("select user_type from employes_reg where emp_id='$emp_id' AND status=1 AND (user_type=9 OR user_type=1)")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_admin_info($admin_id=NULL)
	{
		$query = $this->db->query("select * from admin where admin_id='$admin_id'")->result_array();
		if(count($query)>0)
		{
		    return $query[0];
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_lco_info($cust_id=NULL)
	{
		$query = $this->db->query("select admin_id from customers where cust_id='$cust_id'")->result_array();
		if(count($query)>0)
		{
		    return $query[0];
		}
		else
		{
		    return 0;
		}
	}
	
	public function add_lco_credits($data=NULL)
	{
	    $adminId=$this->session->userdata('admin_id');
	    $admin_id=$data['admin_id'];
		$query = $this->db->query("select * from admin where admin_id='$admin_id'")->result_array();
		if(count($query)>0)
		{
		    if($query[0]['admin_id']!='')
		    {
    		    $balance = $query[0]['balance'] + $data['amount'];
    		    $data3 = array(
    		        "balance" => $balance
    		        );
    		    $this->db->where('admin_id', $admin_id);
    		    $this->db->update('admin', $data3);
    		    
    		    $data4 = array(
    		        "admin_id" => $data['admin_id'],
    		        "type" => "credit",
    		        "open_bal" => $query[0]['balance'],
    		        "amount" => $data['amount'],
    		        "close_bal" => $balance,
    		        "remarks" => $data['remarks'],
    		        "ac_date" => date("Y-m-01"),
    		        "dateCreated" => date("Y-m-d H:i:s"),
    		        "created_by" => $adminId
    		        );
    		    $this->db->insert("f_accounting", $data4);
    		    return true;
		    }
		    else
		    {
		        return "Something went wrong!";
		    }
		}
		else
		{
		    return 0;
		}
	}
	
	public function remove_from_stb($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
	    $adminId=$this->session->userdata('admin_id');
		$query = $this->db->query("select ar.* from alacarte_request ar where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.alacarte_req_id='$req_id' AND ar.sms_status=0")->result_array();
		if(count($query)>0)
		{
    		    $data2 = array(
    		        "cust_id" => $query[0]['cust_id'],
    		        "stb_id" => $query[0]['stb_id'],
    		        "ala_ch_id" => $query[0]['ala_ch_id'],
    		        "pack_id" => $query[0]['pack_id'],
    		        "ar_month" => date("Y-m-01"),
    		        "dateCreated" => date('Y-m-d H:i:s')
    		        );
    		    $this->db->insert("alacarte_reject", $data2);
    		    $temp2 = $this->db->query("DELETE FROM alacarte_request where cust_id='$cust_id' AND stb_id='$stb_id' AND alacarte_req_id='$req_id'");
    		    return true;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_alacarte_reject($cust_id=NULL,$stb_id=NULL,$rej_id=NULL)
	{
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_price from alacarte_reject ar left join alacarte_channels ac ON ar.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.alacarte_rej_id='$rej_id' AND ar.ala_ch_id!='' order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet_reject($cust_id=NULL,$stb_id=NULL,$rej_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,p.package_name,p.package_price from alacarte_reject ar left join packages p ON ar.pack_id=p.package_id where p.isbase != 'Yes' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.pack_id!='' AND ar.alacarte_rej_id='$rej_id' order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function update_customer_ala_req($req_id=NULL,$cust_id=NULL,$stb_id=NULL,$st=NULL)
	{
	    $adminId=$this->session->userdata('admin_id');
		$query = $this->db->query("select ar.* from alacarte_request ar where ar.alacarte_req_id='$req_id' AND ar.sms_status=0")->result_array();
		if(count($query)>0)
		{
		    $id1=$query[0]['cust_id'];
		    $id2=$query[0]['stb_id'];
		    $data2 = array(
		        "status" => $st
		    );
		    $this->db->where("cust_id", $id1);
		    $this->db->where("stb_id", $id2);
		    $this->db->update("alacarte_request", $data2);
		    return true;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_requets_temp_approved($limit, $start)
	{
	    extract($_REQUEST);
	    $adminId=$this->session->userdata('admin_id');
	    $emp_id=$this->session->userdata('emp_id');
	    $temp1 = $this->db->query("select user_type from employes_reg where emp_id='$emp_id' AND status=1")->result_array();
	    if(isset($fromdate) && $fromdate!='' && isset($todate) && $todate!='')
        {
        	$date1=date("Y-m-d 00:00:00",strtotime($fromdate));
        	$date2=date("Y-m-d 23:59:59",strtotime($todate));
        }
        else
        {
        	$date1=date("Y-01-01 00:00:00");
        	$date2=date("Y-m-31 23:59:59");
        }
        $limit =" limit $start,$limit";
	    if($temp1[0]['user_type']==9)
	    {
	        $where1="";
	        if(isset($inputLco) && $inputLco!='')
	        {
	            $where1.=" AND c.admin_id='$inputLco'";
	        }
	        if(isset($inputCCN) && $inputCCN!='')
	        {
	            $where1.=" AND (c.custom_customer_no LIKE '$inputCCN' or c.stb_no LIKE '%$inputCCN%')";
	        }
	       $query = $this->db->query("select c.cust_id,c.first_name,c.custom_customer_no,c.mobile_no,c.group_id,c.addr1,c.stb_no,be.cust_end_date from before_expiries be left join customers c ON be.cust_id=c.cust_id where 1 $where1 AND be.be_status=0 AND be.created_at BETWEEN '$date1' AND '$date2' group by c.cust_id $limit")->result_array();
		  
	    }
	    else
	    {
	        $where1="";
	        if(isset($inputCCN) && $inputCCN!='')
	        {
	            $where1.=" AND (c.custom_customer_no LIKE '$inputCCN' or s.stb_no LIKE '%$inputCCN%' or s.mac_id LIKE '%$inputCCN%')";
	        }
	        $query = $this->db->query("select c.cust_id,c.first_name,c.custom_customer_no,c.mobile_no,c.group_id,c.addr1,c.stb_no,be.cust_end_date from before_expiries be left join customers c ON be.cust_id=c.cust_id where 1 $where1 AND c.admin_id='$adminId' AND be.be_status=0 AND be.created_at BETWEEN '$date1' AND '$date2' group by c.cust_id $limit")->result_array();
		  
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
	
	public function get_customer_alacarte_approved($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ar.alacarte_req_id,ac.ala_ch_price from alacarte_request ar left join alacarte_channels ac ON ar.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.alacarte_req_id='$req_id' AND ar.sms_status=1 order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet_approved($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,p.package_name,ar.alacarte_req_id,p.package_price,(select lco_price from operator_packages where package_id=p.package_id AND admin_id=(select admin_id from customers where cust_id=ar.cust_id)) as lco_price from alacarte_request ar left join packages p ON ar.pack_id=p.package_id where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.pack_id!='' AND ar.alacarte_req_id='$req_id' AND ar.sms_status=1 order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function check_import()
	{
	    $adminId=$this->session->userdata('admin_id');
		if((!$_FILES['file']['error']) && ($_FILES['file'] !=''))
		{
			$new_image=rand(1,10000)."_".$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],"import/".$new_image);
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
			$import_values=$this->db->query("select custom_customer_no,mac_id,deal_name,final_status from import_customers where admin_id='$adminId'")->result_array();
			$import_values=$import_values[0];
			$uCount=0;
			$uniques='';
			foreach($data['values'] as $key=>$val) 
			{
				extract($import_values);
				$usernameCount=$this->db->query("select custom_customer_no from customers where custom_customer_no='".$val[$custom_customer_no]."'")->result_array();
				$MacIdCount=$this->db->query("select mac_id from set_top_boxes where mac_id='".$val[$mac_id]."'")->result_array();
				$dName=rtrim($val[$deal_name]);
				$DealCount1=$this->db->query("select ala_ch_id from alacarte_channels where ala_ch_descr='".$dName."'")->result_array();
				$DealCount2=$this->db->query("select package_id from packages where package_description LIKE '".$dName."'")->result_array();
				if((count($usernameCount)==1) && (count($MacIdCount)==1) && (count($DealCount1)==1 || count($DealCount2)==1))
				{
					$uCount++;
				}
				elseif(count($MacIdCount)==0)
				{
					$uniques.="MAC ID not Exists : ".$val[$mac_id];
				}
				elseif((count($DealCount1)==0) || (count($DealCount2)==0))
				{
					$uniques.="Deal Name not Exists : ".$val[$deal_name];
				}
				else
				{
					$uniques.="Account No not Exists : ".$val[$custom_customer_no];
				}
			}
			if($uCount==0)
			{
				$uCount=$uniques;
			}
			else
			{
				$uCount=$uniques;
			}
			unlink($file);
		return $uCount;
	}
	
	public function save_batch_import()
	{
	    $adminId=$this->session->userdata('admin_id');
		if((!$_FILES['import_file']['error']) && ($_FILES['import_file'] !=''))
		{
			$new_image=rand(1,10000)."_".$_FILES['import_file']['name'];
			move_uploaded_file($_FILES['import_file']['tmp_name'],"import/".$new_image);
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
			$import_values=$this->db->query("select custom_customer_no,mac_id,deal_name,final_status from import_customers where admin_id='$adminId'")->result_array();
			$import_values=$import_values[0];
			$uCount=0;
			$uniques='';
			foreach($data['values'] as $key=>$val) 
			{
			 //   print_r($val);
				extract($import_values);
				$usernameCount=$this->db->query("select cust_id,custom_customer_no from customers where custom_customer_no='".$val[$custom_customer_no]."'")->result_array();
				$MacIdCount=$this->db->query("select stb_id,mac_id from set_top_boxes where mac_id='".$val[$mac_id]."'")->result_array();
				$dName=rtrim($val[$deal_name]);
				$DealCount1=$this->db->query("select ala_ch_id from alacarte_channels where ala_ch_descr='".$dName."'")->result_array();
				$DealCount2=$this->db->query("select package_id from packages where package_description LIKE '".$dName."'")->result_array();
				if((count($usernameCount)==1) && (count($MacIdCount)==1) && (count($DealCount1)==1 || count($DealCount2)==1) && $val[$final_status]=='SUCCESS')
				{
				    $cust_id=$usernameCount[0]['cust_id'];
				    $stb_id=$MacIdCount[0]['stb_id'];
				    if(count($DealCount1)==1)
				    {
				        $deal_id=$DealCount1[0]['ala_ch_id'];
				    }
				    elseif(count($DealCount2)==1)
				    {
				        $deal_id=$DealCount2[0]['package_id'];
				    }
            		$query = $this->db->query("select ar.* from alacarte_request ar where ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND (ar.ala_ch_id='$deal_id' OR ar.pack_id='$deal_id') AND ar.sms_status=0")->result_array();
            		if(count($query)>0)
            		{
            		    $req_id = $query[0]['alacarte_req_id'];
            		    $temp1 = $this->db->query("select admin_id,cust_balance from customers where cust_id='$cust_id'")->result_array();
            		    $admin_id=$temp1[0]['admin_id'];
            		    $temp2 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
            		    $d1=date("Y-m-01");
            		    $temp3 = $this->db->query("select b.stb_id from billing_info b where b.cust_id='$cust_id' AND b.stb_id='$stb_id' AND current_month_name='$d1'")->result_array();
            		    if(count($temp3)==0)
            		    {
            		        $temp4 = $this->db->query("select s.stb_id,c.group_id,s.pack_id from customers c left join set_top_boxes s ON c.cust_id=s.cust_id where s.cust_id='$cust_id' AND s.stb_id='$stb_id'")->result_array();
                		    $temp5 = $this->db->query("select package_price,package_name,mso_ratio from packages where package_id=".$temp4[0]['pack_id'])->result_array();
                		    $packPrice = $temp5[0]['package_price'] * ($temp5[0]['mso_ratio']/100);
                		    $packName = $temp5[0]['package_name'];
            		        $data6 = array(
                		        "admin_id" => $admin_id,
                		        "cust_id" => $cust_id,
                		        "stb_id" => $stb_id,
                		        "group_id" => $temp4[0]['group_id'],
                		        "pack_id" => $temp4[0]['pack_id'],
                		        "stb_id" => $stb_id,
                		        "current_month_name" => $d1,
                		        "previous_due" => $temp1[0]['cust_balance'],
                		        "current_month_bill" => $packPrice,
                		        "total_outstaning" => ($temp1[0]['cust_balance'] + $packPrice),
                		        "dateGenerated" => date("Y-m-d H:i:s")
                		        );
                		    $this->db->insert("billing_info", $data6);
                		    
                		    $balance = $temp2[0]['balance'] - $packPrice;
                		    $data8 = array(
                		        "balance" => $balance
                		        );
                		    $this->db->where('admin_id', $admin_id);
                		    $this->db->update('admin', $data8);
                		    
                		    $cust_balance = $temp1[0]['cust_balance'] + $packPrice;
                		    $data9 = array(
                		        "cust_balance" => $cust_balance
                		        );
                		    $this->db->where('cust_id', $cust_id);
                		    $this->db->update('customers', $data9);
                		    
                		    $data7 = array(
                		        "admin_id" => $admin_id,
                		        "cust_id" => $cust_id,
                		        "stb_id" => $stb_id,
                		        "type" => "debit",
                		        "open_bal" => $temp2[0]['balance'],
                		        "amount" => $packPrice,
                		        "close_bal" => $balance,
                		        "remarks" => $packName,
                		        "ac_date" => date("Y-m-01"),
                		        "dateCreated" => date("Y-m-d H:i:s"),
                		        "created_by" => $adminId
                		        );
                		    $this->db->insert("f_accounting", $data7);
            		    }
            		    $packPrice = 0;
            		    if($query[0]['ala_ch_id']!='')
            		    {
            		        $ch_id = $query[0]['ala_ch_id'];
            		        $pack1 = $this->db->query("select ala_ch_price,ala_ch_name,mso_ratio from alacarte_channels where ala_ch_id='$ch_id'")->result_array();
            		        $packPrice = $pack1[0]['ala_ch_price'] * ($pack1[0]['mso_ratio']/100);
            		        $packName = $pack1[0]['ala_ch_name'];
            		    }
            		    elseif($query[0]['pack_id']!='')
            		    {
            		        $packID = $query[0]['pack_id'];
            		        $pack1 = $this->db->query("select package_price,package_name,mso_ratio from packages where package_id='$packID'")->result_array();
            		        $packPrice = $pack1[0]['package_price'] * ($pack1[0]['mso_ratio']/100);
            		        $packName = $pack1[0]['package_name'];
            		    }
            		    $temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
            		    if($temp7[0]['balance']>$packPrice)
            		    {
            		        $temp8 = $this->db->query("select admin_id,cust_balance from customers where cust_id='$cust_id'")->result_array();
                		    $data1 = array(
                		        "sms_status" => 1,
                		        );
                		    $this->db->where('cust_id', $cust_id);
                		    $this->db->where('stb_id', $stb_id);
                		    $this->db->where('alacarte_req_id', $req_id);
                		    $this->db->update('alacarte_request', $data1);
                		    
                		    $cust_balance = $temp8[0]['cust_balance'] + $packPrice;
                		    $data5 = array(
                		        "cust_balance" => $cust_balance
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
                		        "created_by" => $adminId
                		        );
                		    $this->db->insert("f_accounting", $data4);
                		    
                		    $data2 = array(
                		        "cust_id" => $query[0]['cust_id'],
                		        "stb_id" => $query[0]['stb_id'],
                		        "ala_ch_id" => $query[0]['ala_ch_id'],
                		        "pack_id" => $query[0]['pack_id'],
                		        "ca_status" => 1,
                		        "ca_date_created" => date('Y-m-d H:i:s')
                		        );
                		    $this->db->insert("customer_alacarte", $data2);
            		    }
					    $uCount++;
            		}
				}
				elseif(count($MacIdCount)==0)
				{
					$uniques.="MAC ID not Exists : ".$val[$mac_id];
				}
				elseif((count($DealCount1)==0) || (count($DealCount2)==0))
				{
					$uniques.="Deal Name not Exists : ".$val[$deal_name];
				}
				else
				{
					$uniques.="Account No not Exists : ".$val[$custom_customer_no];
				}
			}
// 			exit;
			if($uCount==0)
			{
				$uCount=$uniques;
			}
			else
			{
				//$uCount=$uniques;
			}
// 			unlink($file);
		return $uCount;
	}
	
	public function get_bouquet_list()
	{
		$query = $this->db->query("select p.package_id,p.package_name,p.package_price from packages p where p.isbase != 'Yes' AND p.package_id!='' order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_request_info($req_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,ar.ala_ch_id from alacarte_request ar WHERE ar.alacarte_req_id='$req_id' AND ar.sms_status=0")->result_array();
		if(count($query)>0)
		{
		    if($query[0]['ala_ch_id']!='')
		    {
		        $ch_id=$query[0]['ala_ch_id'];
		        $query2 = $this->db->query("select ac.* from alacarte_channels ac WHERE ac.ala_ch_id='$ch_id'")->result_array();
		        return $query2;
		    }
		    elseif($query[0]['pack_id']!='')
		    {
		        $ch_id=$query[0]['pack_id'];
		        $query2 = $this->db->query("select p.* from packages p WHERE p.package_id='$ch_id'")->result_array();
		        return $query2;
		    }
		    return 0;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_info($cust_id=NULL,$stb_id=NULL)
	{
		$query = $this->db->query("select s.stb_no,s.mac_id,s.card_no from set_top_boxes s where s.stb_id='$stb_id'")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_request_remove_info($cust_id=NULL,$stb_id=NULL,$ala_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,ar.ala_ch_id from alacarte_remove ar WHERE ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND (ar.ala_ch_id='$ala_id' OR ar.pack_id='$ala_id') AND ar.sms_status=0")->result_array();
		if(count($query)>0)
		{
		    if($query[0]['ala_ch_id']!='' && $query[0]['ala_ch_id']!='0')
		    {
		        $ch_id=$query[0]['ala_ch_id'];
		        $query2 = $this->db->query("select ac.* from alacarte_channels ac WHERE ac.ala_ch_id='$ch_id'")->result_array();
		        return $query2;
		    }
		    elseif($query[0]['pack_id']!='')
		    {
		        $ch_id=$query[0]['pack_id'];
		        $query2 = $this->db->query("select p.* from packages p WHERE p.package_id='$ch_id'")->result_array();
		        return $query2;
		    }
		    return 0;
		}
		else
		{
		    return 0;
		}
	}
	
	public function save_batch_import_new()
	{
	    $adminId=$this->session->userdata('admin_id');
		if((!$_FILES['import_customer']['error']) && ($_FILES['import_customer'] !=''))
		{
			$new_image=rand(1,10000)."_".$_FILES['import_customer']['name'];
			move_uploaded_file($_FILES['import_customer']['tmp_name'],"import/".$new_image);
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
			$import_values=$this->db->query("select custom_customer_no,mac_id,deal_name from import_customers where admin_id='$adminId'")->result_array();
			$import_values=$import_values[0];
			$uCount=0;
			$uniques='';
			$date = date('Y-m-d H:i:s');
			foreach($data['values'] as $key=>$val) 
			{
				extract($import_values);
				$usernameCount=$this->db->query("select cust_id from customers where custom_customer_no='".$val[$custom_customer_no]."'")->result_array();
				$MacIdCount=$this->db->query("select cust_id,stb_id from set_top_boxes where mac_id='".$val[$mac_id]."'")->result_array();
				$dName=rtrim($val[$deal_name]);
			    $DealCount1=$this->db->query("select ala_ch_id from alacarte_channels where ala_ch_descr='".$dName."'")->result_array();
				$DealCount2=$this->db->query("select package_id from packages where package_description LIKE '".$dName."'")->result_array();
				if((count($MacIdCount)==1) && (count($DealCount1)==1 || count($DealCount2)==1))
				{
				    // print_r($val);exit;
				    $cust_id=$MacIdCount[0]['cust_id'];
				    $stb_id=$MacIdCount[0]['stb_id'];
				    if(count($DealCount1)==1)
				    {
				        $ch_id=$DealCount1[0]['ala_ch_id'];
				        $deal_id=$DealCount1[0]['ala_ch_id'];
				        $pack_id=NULL;
				    }
				    elseif(count($DealCount2)==1)
				    {
				        $ch_id=NULL;
				        $deal_id=$DealCount2[0]['package_id'];
				        $pack_id=$DealCount2[0]['package_id'];
				    }
				    echo "INSERT INTO customer_alacarte (cust_id,stb_id,ala_ch_id,pack_id,ca_status,ca_date_created) VALUES ('$cust_id','$stb_id','$ch_id','$pack_id','1','$date');<br>";
    //         		$query = $this->db->query("select ca.* from customer_alacarte ca where ca.cust_id='$cust_id' AND ca.stb_id='$stb_id' AND (ca.ala_ch_id='$deal_id' OR ca.pack_id='$deal_id') AND ca.ca_status=1")->result_array();
    //         		if(count($query)==0)
    //         		{
				// 		$data2 = array(
				// 			"cust_id" => $cust_id,
				// 			"stb_id" => $stb_id,
				// 			"ala_ch_id" => $ch_id,
				// 			"pack_id" => $pack_id,
				// 			"ca_status" => 1,
				// 			"ca_date_created" => date('Y-m-d H:i:s')
				// 			);
				// 		$this->db->insert("customer_alacarte", $data2);
				// 	    $uCount++;
    //         		}
				}
				elseif(count($MacIdCount)==0)
				{
				    print_r($val);
				// 	$uniques.="MAC ID not Exists : ".$val[$mac_id]."<br>";
				}
				elseif((count($DealCount1)==0) || (count($DealCount2)==0))
				{
				// 	$uniques.="Deal Name not Exists : ".$val[$deal_name]."<br>";
				    print_r($val);
				}
				else
				{
				    // print_r($val);
					$uniques.="Account No not Exists : ".$val[$custom_customer_no]."<br>";
				}
			}
			echo $uniques;
			exit;
			if($uCount==0)
			{
				$uCount=$uniques;
			}
			else
			{
				//$uCount=$uniques;
			}
// 			unlink($file);
		return $uCount;
	}
	
	public function get_customer_alacarte_remove_info($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_price,ac.ala_ch_descr from alacarte_remove ar left join alacarte_channels ac ON ar.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.alacarte_remove_id='$req_id' order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet_remove_info($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ar.pack_id,p.package_name,p.package_price,p.package_description from alacarte_remove ar left join packages p ON ar.pack_id=p.package_id where p.isbase != 'Yes' AND ar.cust_id='$cust_id' AND ar.stb_id='$stb_id' AND ar.pack_id!='' AND ar.alacarte_remove_id='$req_id' order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_alacarte($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ac.ala_ch_id,ac.ala_ch_name,ac.ala_ch_price from customer_alacarte ca left join alacarte_channels ac ON ca.ala_ch_id=ac.ala_ch_id where ac.ala_ch_type = '2' AND ca.cust_id='$cust_id' AND ca.stb_id='$stb_id' AND ca.ca_id='$req_id' order by ala_ch_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function get_customer_bouquet($cust_id=NULL,$stb_id=NULL,$req_id=NULL)
	{
		$query = $this->db->query("select ca.pack_id,p.package_name,p.package_price from customer_alacarte ca left join packages p ON ca.pack_id=p.package_id where p.isbase != 'Yes' AND ca.cust_id='$cust_id' AND ca.stb_id='$stb_id' AND ca.pack_id!='' AND ca.ca_id='$req_id' order by p.package_name ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
	
	public function renew_packs($cust_id=NULL,$stb_id=NULL,$pack_no=NULL)
	{
	    $getMsoPackId = $this->db->query("select GROUP_CONCAT(mso_pack_id) as mso_pack_id from packages where package_id IN ($pack_no)")->row_array();
		$cust_info = $this->db->query("select cust_id,lco_portal_url,lco_username,lco_password from customers where cust_id='$cust_id'")->row_array();
		$stb_info = $this->db->query("select stb_no from set_top_boxes where cust_id='$cust_id'")->result_array();
		$lco_portal_url = $cust_info['lco_portal_url'];
		$lco_username = $cust_info['lco_username'];
		$lco_password = $cust_info['lco_password'];
		$nxt_db = $this->load->database('nxt_db', TRUE);
	    $nxtPackData = array();
	    $nxtPackData['portal_url'] = $lco_portal_url;
	    $nxtPackData['Username'] = $lco_username;
	    $nxtPackData['Password'] = $lco_password;
	    $nxtPackData['Cust_id'] = $cust_id;
	    $nxtPackData['Box_no'] = $stb_info[0]['stb_no'];
	    $nxtPackData['pack_no'] = $getMsoPackId['mso_pack_id'];
	    $nxtPackData['Mac_id'] = 0;
	    $nxtPackData['Action'] = 'renew';
	    $nxtPackData['Datecreated'] = date("Y-m-d");
	    $nxtPackData['Status'] = 0;
	    $nxt_db->insert("useractivation", $nxtPackData);
	    return true;
	}
	
	public function get_customer_bouquet_before_req($cust_id=NULL,$stb_id=NULL)
	{
		$month = date("Y-m-01");
		$query = $this->db->query("select be.pack_id,p.package_name,(select lco_price from operator_packages where package_id=p.package_id AND admin_id=(select admin_id from customers where cust_id=be.cust_id)) as lco_price from before_expiries be left join packages p ON be.pack_id=p.package_id where be.cust_id='$cust_id' AND be.pack_id!='' AND be.be_status=0 order by be.be_id ASC")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
}