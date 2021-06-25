<?php 
class Business_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function business_save(){
		extract($_REQUEST);
		$adminId= $this->session->userdata('admin_id');
		$this->db->select('admin_id');
		$this->db->where('admin_id', $adminId);
		$query = $this->db->get('business_information');
		if ($query->num_rows() > 0) {
			//$new_image=rand(1,10000).$_FILES['business_image']['tmp_name'];
			//if(is_uploaded_file($_FILES['business_image']['tmp_name']))
				$sel_img=mysql_query("select business_image from business_information where admin_id='$adminId'");
				$res_img=mysql_fetch_assoc($sel_img);	
			 
			//if(!$_FILES['business_image']['error'])
			if((!$_FILES['business_image']['error']) && ($_FILES['business_image'] !=''))
			{
				$new_image=rand(1,10000)."_".$_FILES['business_image']['name'];
				move_uploaded_file($_FILES['business_image']['tmp_name'],"images/".$new_image);
			}else
			{
				$new_image=$res_img['business_image'];
			}
			$data = array(
					"business_name" => $business_name,
					"address1" => $address1,
					"address2" => $address2,
					"address3" => $address3,
					"city" => $city,
					"state" => $state,
					"country" => $country,
					"pincode" => $pincode,
					"email" => $email,
					"mobile" => $mobile,
					"service_tax_no" => $service_tax_no,
					"invoice_code" => $invoice_code,
					"business_image" => $new_image
				);
			//$this->db->insert("business_information", $data);
			//$id = $this->db->insert_id();
			$this->db->where('admin_id', $adminId);
			$this->db->update('business_information', $data);
			return 1;
		} 
		else {
			//$new_image=rand(1,10000).$_FILES['business_image']['tmp_name'];
			//if(is_uploaded_file($_FILES['business_image']['tmp_name']))
				// $sel_img=mysql_query("select business_image from business_information");
				// $res_img=mysql_fetch_assoc($sel_img);	
			 
			//if(!$_FILES['business_image']['error'])
			if((!$_FILES['business_image']['error']) && ($_FILES['business_image'] !=''))
			{
				$new_image=rand(1,10000)."_".$_FILES['business_image']['name'];
				move_uploaded_file($_FILES['business_image']['tmp_name'],"images/".$new_image);
			}
			// else
			// {
				// $new_image=$res_img['business_image'];
			// }
			$data = array(
					"admin_id" => $adminId,
					"business_name" => $business_name,
					"address1" => $address1,
					"address2" => $address2,
					"address3" => $address3,
					"city" => $city,
					"state" => $state,
					"country" => $country,
					"pincode" => $pincode,
					"email" => $email,
					"mobile" => $mobile,
					"service_tax_no" => $service_tax_no,
					"invoice_code" => $invoice_code,
					"business_image" => $new_image
				);
			$this->db->insert("business_information", $data);
			$id = $this->db->insert_id();
			return 1;
		}
	}
	
	public function get_business_info($emp_id=NULL)
	{
		$adminId= $this->session->userdata('admin_id');
		$query = $this->db->query("select * from business_information where admin_id='$adminId'");
        return $query->result_array();
	}
}