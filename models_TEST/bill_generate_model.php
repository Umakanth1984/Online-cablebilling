<?php
/**
* Laabus menus table
*/

class Bill_generate_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
/*
	public function send_sms(){
 
 
 		$busInfo=mysql_fetch_assoc(mysql_query("SELECT * FROM business_information"));
		$custName=$cust_res['first_name'];
		$busiName=$busInfo['business_name'];
		//echo $resCust['mobile_no'];
		$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer"));
		
 		$getCust=mysql_query("select customers.cust_id,customers.mobile_no,customers.first_name, billing_info.total_outstaning, billing_info.current_month_bill, billing_info.current_month_name from customers RIGHT JOIN billing_info ON billing_info.cust_id=customers.cust_id where billing_info.status=0");
		 
				while($resCust=mysql_fetch_assoc($getCust)){
				$cust_id=$resCust['cust_id'];
				$cust_first_name=$resCust['first_name'];
				$cust_mobile_no=$resCust['mobile_no'];
				$current_month_name =$resCust['current_month_name'];
				$total_outstaning=$resCust['total_outstaning'];
				$current_month_bill=$resCust['current_month_bill'];
				//SMS Sending	
				
				// Send SMS
				if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendpaymentsms']=='Yes')){
	
					//$mess = urlencode("Your Payment Rs.".$amount." received by ".$transType." towards Outstanding Cable Bill. Invoice No ".$invoice);
					$mess = urlencode("Dear ".ucwords($cust_first_name).",Your Monthly Bill has been Generated for the month of ".$current_month_name." sum of Rs.".$current_month_bill." towards your Cable TV Bill. total Outstanding Rs.".$total_outstaning." - ".ucwords($busiName));
				 $url = $resSmsPrefer['sms_api_url']."&sender=DRUPAY&number=".$cust_mobile_no."&message=" . $mess; 
					//$url = "http://www.bulksmsapps.com/apisms.aspx?user=DIGITALRUPAY&password=Digital@1&genkey=195470434&sender=DRUPAY&number=".$resCust['mobile_no']."&message=" . $mess;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
					curl_close ($ch);
				}
				// End of SMS Sending	
				$data = array( 
					 "status" =>1,
					);
				$this->db->where('cust_id', $cust_id);
				$this->db->where('status', 0);
				$this->db->update('billing_info', $data);
		} // End of While
 }
 */
	/*public function generate_bill()
	{		 
		//extract($_REQUEST);		
		$sel_customer=mysql_query("select * from customers where status=1");
		while($cust_res=mysql_fetch_assoc($sel_customer)){
				$qry_price=mysql_query("select package_price,package_validity from packages where package_id=".$cust_res['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);
				$stbInfo=mysql_fetch_assoc(mysql_query("select stb_id from set_top_boxes where cust_id=".$cust_res['cust_id']." LIMIT 0,1"));
				$stb_id=$stbInfo['stb_id'];
				$current_pack_price=$sel_price['package_price'];
				$current_due = $cust_res['cust_balance']+$current_pack_price;
				$id=$cust_res['cust_id'];
				$data = array( 
					//"amount" => $inputAmount,
					"pending_amount" => $current_due,
					"current_due" => $current_due,
					"cust_balance" => $current_due,
					"monthly_bill" => $current_pack_price,
				);
				$this->db->where('cust_id', $id);
				$this->db->update('customers', $data);
			//Inserting Data into Billinfo DB
			$data = array(
				"cust_id" => $cust_res['cust_id'],
				"stb_id" => $stb_id,
				"admin_id" => $cust_res['admin_id'],
				"pack_id" => $cust_res['pack_id'],
				"group_id" => $cust_res['group_id'],
				"previous_due" => $cust_res['pending_amount'],
				"total_outstaning" => $current_due,
				"current_month_name" => date("Y-m-01"),
				//"current_month_bill" => $sel_price['package_price'],
				"current_month_bill" =>$current_pack_price,
				"dateGenerated" => date('Y-m-d H:i:s'),
				"status" => 0				
			);
			$this->db->insert("billing_info", $data);
			
			$data7 = array(
		        "admin_id" => $cust_res['admin_id'],
		        "cust_id" => $cust_res['cust_id'],
		        "stb_id" => $stb_id,
		        "type" => "debit",
		        "open_bal" => $cust_res['pending_amount'],
		        "amount" => $current_pack_price,
		        "close_bal" => $current_due,
		        "remarks" => "NCF 46.02",
		        "ac_date" => date("Y-m-01"),
		        "dateCreated" => date("Y-m-d H:i:s"),
		        "created_by" => 1
		        );
		    $this->db->insert("f_accounting", $data7);
		}
		return 1;
	}*/
    
    public function generate_bill()
	{
		$sel_customer=mysql_query("select cust_id,admin_id,package_id,pending_amount,end_date,group_id,cust_balance,tax_rate,remarks from customers where status=1 AND group_id IS NOT NULL and admin_id=17");
		while($cust_res=mysql_fetch_assoc($sel_customer))
		{
		    $stbInfo=mysql_fetch_assoc(mysql_query("select pack_id,stb_id,cust_id from set_top_boxes where cust_id=".$cust_res['cust_id']));
		    if($stbInfo['pack_id']!=0)
		    {
    			$qry_price=mysql_query("select package_price,package_validity from packages where package_id=".$stbInfo['pack_id']);
    			$sel_price=mysql_fetch_assoc($qry_price);
    			$current_pack_price=$sel_price['package_price'];
				$tot_pack_amt=$current_pack_price;
    			$current_pack_price=$tot_pack_amt+($current_pack_price*(0/100)); 
    			$current_due = $cust_res['pending_amount']+$current_pack_price;
    // 			$tax=($tot_pack_amt*(0/100));
    			$id=$cust_res['cust_id'];
    			if($cust_res['tax_rate']!='' && $cust_res['tax_rate']!=0)
    			{
    			    $current_pack_price = $current_pack_price-$cust_res['tax_rate'];
    			    $current_due = $current_due-$cust_res['tax_rate'];
    			 //   $data['remarks']=$cust_res['remarks']." Discount given Rs.".$cust_res['tax_rate'];
    			}
    			$data = array(
    				"pending_amount" => $current_due,
    				"current_due" => $current_due,
    				"monthly_bill" => $current_pack_price
    				// "last_month_tax" => $tax
    			);
    			$this->db->where('cust_id', $id);
    			$this->db->update('customers', $data);
    			/*Inserting Data into Billinfo DB*/	
    			$data = array(
    				"cust_id" => $cust_res['cust_id'],
    				"admin_id" => $cust_res['admin_id'],
    				"stb_id" => $stbInfo['stb_id'],
    				"pack_id" => $stbInfo['pack_id'],
    				"group_id" => $cust_res['group_id'],
    				"previous_due" => $cust_res['pending_amount'],
    				"total_outstaning" => $current_due,
    				"current_month_name" => date("F"),
    				"current_month_bill" =>$current_pack_price,
    				"dateGenerated" => date('Y-m-d H:i:s'),
    				"status" => 0
    			);
    			$this->db->insert("billing_info", $data);
    			
    			$admin_id=$cust_res['admin_id'];
    			$cust_id=$id;
    			$alaQry=mysql_query("select ca.stb_id,ca.ala_ch_id,ca.pack_id from customer_alacarte ca left join set_top_boxes s ON ca.stb_id=s.stb_id where s.stb_id!='' AND ca.cust_id=".$id);
    			while($alaRes=mysql_fetch_assoc($alaQry))
    			{
    			    $temp7 = $this->db->query("select balance from admin where admin_id='$admin_id'")->result_array();
    			    $stb_id=$alaRes['stb_id'];
    			    $temp8 = $this->db->query("select cust_balance,pending_amount from customers where cust_id='$id'")->result_array();
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
    			    $cust_balance = $temp8[0]['pending_amount'] + $packPrice;
        		  //  $cust_tax = $temp8[0]['last_month_tax'] + ($packPrice*(18/100));
        		    $data5 = array(
        		        "pending_amount" => $cust_balance,
        		        "current_due" => $cust_balance
        		      //  "last_month_tax" => $cust_tax
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
		    }
		}
		return 1;
	}
}