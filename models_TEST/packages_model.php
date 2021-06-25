<?php
class Packages_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function save_packages()
	{
		extract($_REQUEST);
		// if($inputpackageisbase=='No')
		// {
		    // $alaChannels=implode(",",$bouquetChannels);
			// $bqChannels=implode(",",$bouquets);
		// }
		// else
		// {
		    // $alaChannels="";
		    // $bqChannels="";
		// }
			$pack_price=$totalPrice-$inputpackagediscount;
			if(!isset($REQUEST['inputservicetax'])){$service=0;}else{$service=$REQUEST['inputservicetax'];}
			$adminId= $this->session->userdata('admin_id');
			$data = array(
				"admin_id" =>$adminId,
				"package_name" =>$inputpackagename,
				"package_description" => $inputpackagedesc,
				"package_price" => $pack_price,
				"package_tax2" => $lcoPrice,
				"package_tax1" => $inputpackagetax1,
				"package_tax3" => "",
				"package_validity" => $inputpackagevalidity, 
				// "package_discount" => $inputpackagediscount, 
				// "isdefault" => $inputpackagedefault,
				"isbase" => "No",
				// "service_tax" => $service,
				// "franchise_type" => $sharingOption,
				// "lco_ratio" => $operator,
				// "mso_ratio" => $mso,
				// "ala_channels" => $alaChannels,
				"cat_id" => $package_cat,
				"mso_id" => 1,
				"mso_pack_id" => $mso_pack_id,
				"dateCreated" => date('Y-m-d H:i:s')
			);
		$this->db->insert("packages", $data);
		return 1;
	}
	
	public function edit_packages($id,$REQUEST,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM packages WHERE package_id=$id"));
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
			$custQry=mysql_query("SELECT package_name AS PackageName,package_description AS PackageDescription,package_price AS PackagePrice,package_tax1 AS Tax1,package_tax2 AS Tax2,package_tax3 AS Tax3,package_validity AS ValidityInMonths,package_discount AS Discount,isdefault AS IsDefault,isbase AS IsBase,service_tax AS IncludingServiceTax FROM packages where package_id='$id'");
			$custRes=mysql_fetch_assoc($custQry);
			$getData=$_REQUEST;
			unset($getData['ci_session']);
			$diffData=array_diff($getData,$custRes);
			$logData='';
			foreach($diffData as $key=>$val)
			{
				if($custRes[$key]==''){ $old="Empty Value";}else{ $old=$custRes[$key];}
				$logData.=$key." : ".$old." changed as ".$val.", ";
			}
			$newLogData= rtrim($logData, ",");
			if($newLogData!="")
			{
				$data1 = array(
					"emp_id" => $emp_id,
					"category" => "Package Edit",
					"ipaddress" => $ipaddress,
					"log_text" => $custRes['PackageName']." Details of ".$newLogData,
					"dateCreated" => date("Y-m-d H:i:s")
				);
				$this->db->insert("change_log", $data1);
			}
			// if($REQUEST['inputpackageisbase']=='No')
			// {
				// $alaChannels=implode(",",$REQUEST['bouquetChannels']);
				// $bqChannels=implode(",",$REQUEST['bouquets']);
			// }
			// else
			// {
				// $alaChannels="";
				// $bqChannels="";
			// }
			$pack_price=$REQUEST['totalPrice'];
			if(!isset($REQUEST['IncludingServiceTax'])){$service="0";}else{$service=$REQUEST['IncludingServiceTax'];}
			$data = array(
				"package_name" =>$REQUEST['PackageName'],
				"package_description" =>$REQUEST['PackageDescription'],
				"package_price" =>$pack_price,
				"package_tax1" => $REQUEST['Tax1'],
				"package_validity" => $REQUEST['ValidityInMonths'], 
				"package_tax2" => $REQUEST['lcoPrice'], 
			// 	"isdefault" => $REQUEST['inputpackagedefault'],
				// "isbase" => $REQUEST['inputpackageisbase'],
			// 	"ala_channels" => $alaChannels,
			// 	"bouquet_channels" => $bqChannels,
			// 	"franchise_type" => $REQUEST['sharingOption'],
			// 	"lco_ratio" => $REQUEST['operator'],
			// 	"mso_ratio" => $REQUEST['mso'],
				// "service_tax" => $service
				"cat_id" => $REQUEST['package_cat'],
				"mso_id" => 1,
				"mso_pack_id" => $REQUEST['mso_pack_id'],
			);
			$this->db->where('package_id', $id);
			$this->db->update('packages', $data);
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function get_packages($id = NULL)
	{
		extract($_REQUEST);
		$chkEmpType=$this->db->query("select user_type,admin_id from employes_reg where emp_id='$id'")->row_array();
		extract($chkEmpType);
		if($user_type==9)
		{
		    $where = "";
			if(isset($package_name) && $package_name!='')
			{
			    $where.=" AND (p.package_name like '%$package_name%')";
			}
			if(isset($inputEmp) && $inputEmp!='')
			{
			    $where.=" AND (op.admin_id='$inputEmp')";
			    $query = $this->db->query("select p.*,op.lco_price,op.cust_price from packages p LEFT JOIN operator_packages op ON p.package_id=op.package_id where op.op_status=1".$where);
			}
			else
			{
			    $query = $this->db->query("select p.* from packages p where 1".$where);
			}
			return $query->result_array();
		}
		else
		{
			if((isset($package_name) && $package_name!='') || (isset($package_price) && $package_price!=''))
			{
				$query = $this->db->query("select * from packages where admin_id='$admin_id' AND (package_name='$package_name' OR package_price='$package_price')");
			}
			else
			{
				$query = $this->db->query("select * from packages where admin_id='$admin_id'");
			}
			return $query->result_array();
		}
    }
	
	public function get_packages_by_id($id = NULL,$emp_id=NULL) {
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM packages WHERE package_id=$id"));
		if($resCust['admin_id']==$admin_id)
		{
			$query = $this->db->query("select * from packages where package_id = $id ");
			return $query->result_array();
		}
		elseif($user_type==9)
		{
		    $query = $this->db->query("select * from packages where package_id = $id ");
			return $query->result_array();
		}
    }
	
	public function group_packages() {
		extract($_REQUEST);
		$data = array( 
				"package_id" => $package_id,
			 );
		$this->db->where('group_id', $group_id);
		$this->db->update('groups', $data);
		return 1;
    }

	public function del_package($id = NULL,$emp_id) {
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM packages WHERE package_id=$id"));
		if($resCust['admin_id']==$admin_id)
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
		
			$packQry=mysql_query("SELECT * FROM packages where package_id= $id ");
			$packRes=mysql_fetch_assoc($packQry);
				$data1 = array(
					"emp_id" => $emp_id,
					"category" => "Package Delete",
					"ipaddress" => $ipaddress,
					"log_text" => $packRes['package_name']." Package has been Deleted.",
					"dateCreated" => date("Y-m-d H:i:s")
				);
			$this->db->insert("change_log", $data1);
			
			$query = $this->db->query("DELETE FROM packages WHERE package_id = $id ");
			return true;
		}
    }
    
    public function save_package_cat()
	{
		extract($_REQUEST);
		$data = array(
			"cat_name" => $cat_name,
			"cat_description" => $cat_description,
			"status"=>1,
			"dateCreated" => date('Y-m-d H:i:s')
		);
		$this->db->insert("package_cat", $data);
		return 1;
	}
	
    public function get_package_cat()
    {
	    $query = $this->db->query("select * from package_cat");
        return $query->result_array();
	}
	
	public function update_package_cat($cat_id=NULL)
	{
		extract($_REQUEST);
		$data = array(
			"cat_name" => $cat_name,
			"cat_description" => $cat_description,
			"updatedOn" => date('Y-m-d H:i:s')
		);
		$this->db->where("cat_id", $cat_id);
		$this->db->update("package_cat", $data);
		return 1;
	}
	
	public function edit_package_cat($id = NULL)
	{
        $query = $this->db->query("select * from package_cat where cat_id='$id'");
        return $query->result_array();
	}
	
	public function delete_package_cat($id = NULL)
	{
	    $query = $this->db->query("DELETE from package_cat where cat_id='$id'");
    }
	
	public function get_pay_channels()
	{
        $query = $this->db->query("select * from alacarte_channels where ala_ch_type=2 order by ala_ch_name ASC");
    	return $query->result_array();
	}
	
	public function get_fta_channels()
	{
        $query = $this->db->query("select * from alacarte_channels where ala_ch_type=1 order by ala_ch_name ASC");
    	return $query->result_array();
	}
	
	public function get_pay_channels_info()
	{
        $query = $this->db->query("select ac.*,pc.cat_name,pc.cat_id from alacarte_channels ac left join package_cat pc ON ac.ala_ch_category=pc.cat_id where ac.ala_ch_type=2 order by ac.ala_ch_name ASC");
    	return $query->result_array();
	}
	
	public function save_pay_channel()
	{
		extract($_REQUEST);
		$temp = $this->db->query("select ala_ch_name from alacarte_channels where ala_ch_name LIKE '$channel_name'")->result_array();
		if(count($temp)>0)
		{
			return 0;
		}
		else
		{
			$data = array(
				"ala_ch_name" => $channel_name,
				"ala_ch_price" => $channel_price,
				"ala_ch_category" => $channel_category,
				"lco_ratio" => $operator,
				"mso_ratio" => $mso,
				"ala_ch_type"=>2,
				"dateCreated" => date('Y-m-d H:i:s')
			);
			$this->db->insert("alacarte_channels", $data);
			return 1;
		}
	}
	
	public function get_pay_channel_info($id = NULL)
	{
		$query = $this->db->query("select * from alacarte_channels where ala_ch_id='$id'");
		$res = $query->result_array();
		if(count($res)>0)
		{
			return $res[0];
		}
		else
		{
			return 0;
		}
	}
	
	public function update_pay_channel()
	{
		extract($_REQUEST);
		$temp = $this->db->query("select ala_ch_name from alacarte_channels where ala_ch_name LIKE '$channel_name' AND ala_ch_id!='$ala_ch_id'")->result_array();
		if(count($temp)>0)
		{
			return 0;
		}
		else
		{
			$data = array(
				"ala_ch_name" => $channel_name,
				"ala_ch_price" => $channel_price,
				"ala_ch_category" => $channel_category,
				"lco_ratio" => $operator,
				"mso_ratio" => $mso,
				"updatedOn" => date('Y-m-d H:i:s')
			);
			$this->db->where("ala_ch_id", $ala_ch_id);
			$this->db->update("alacarte_channels", $data);
			return 1;
		}
	}
	
	public function delete_pay_channel($id=NULL)
	{
		$temp = $this->db->query("select ala_ch_id from alacarte_channels where ala_ch_id='$id' AND ala_ch_type=2")->result_array();
		if(count($temp)>0)
		{
			$temp = $this->db->query("DELETE from alacarte_channels where ala_ch_id='$id' AND ala_ch_type=2");
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	public function get_bouquets()
	{
		$query = $this->db->query("select * from packages where isbase!='Yes'");
		$res = $query->result_array();
		if(count($res)>0)
		{
			return $res;
		}
		else
		{
			return 0;
		}
	}
	
	public function get_operator_package_by_id($id=NULL,$admin_id=NULL)
	{
		$query = $this->db->query("select * from operator_packages where op_id='$id' AND admin_id='$admin_id'");
		$res = $query->result_array();
		if(count($res)>0)
		{
			return $res[0];
		}
		else
		{
			return 0;
		}
	}
	
	public function update_package($op_id=NULL)
	{
		extract($_REQUEST);
		$getOpack = $this->db->query("select * from operator_packages where op_id='$op_id'")->result_array();
		if(count($getOpack)>0)
		{
    		$data = array(
    			"package_name" => $PackageName,
    			"package_description" => $PackageDescription,
    			"cust_price" => $PackagePrice,
    			"updated_at" => date('Y-m-d H:i:s')
    		);
    		$this->db->where("op_id", $op_id);
    		$this->db->update("operator_packages", $data);
    		return true;
		}
		else
		{
		    return false;
		}
	}
	
	public function get_operator_packages($admin_id = NULL)
	{
		extract($_REQUEST);
		if((isset($package_name) && $package_name!='') || (isset($package_price) && $package_price!=''))
		{
			$query = $this->db->query("select * from operator_packages where admin_id='$admin_id' AND (package_name='$package_name' OR cust_price='$package_price') AND op_status=1");
		}
		else
		{
			$query = $this->db->query("select * from operator_packages where admin_id='$admin_id' AND op_status=1");
		}
		return $query->result_array();
    }
}