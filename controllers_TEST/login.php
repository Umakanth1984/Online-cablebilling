<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	function __construct() { 
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		 $this->load->library('session');
		$this->load->model('login_model');	
	}
	public function index()
	{
		/*	if($this->session->userdata('emp_id')=='')
			{			 
				redirect('/');
			}
			elseif($this->session->userdata('cust_id')==''){
				redirect('customer_dashboard');
			}
			else{*/
				$user_access = $this->login_model->check_login();
				if($user_access!=''){
					$data['title'] = ucfirst('Login - Cable Billing System '); 
					$data['msg'] = "<div style='color:GREEN;font-size:20px;text-align:center'>Invalid Email / Password...</div>"; 
					$this->load->view('website_template/login-header',$data);
					$this->load->view('login.php',$data);
					$this->load->view('website_template/login-footer',$data);
				}else{
					$data['emp_id']= $this->session->userdata('emp_id');
					$data['admin_id']= $this->session->userdata('admin_id');
					$data['title'] = ucfirst('Login - Cable Billing System '); 
					$this->load->view('website_template/login-header',$data);
					$this->load->view('login.php',$data);
					$this->load->view('website_template/login-footer',$data);
				}
				
		//	}
	}
	public function check_user()
	{
		$user_access = $this->login_model->check_login();
		// print_r($user_access); die;
		 if($user_access!='1'){
				$data['title'] = ucfirst('Login - Cable Billing System '); 
				$data['msg'] = "<div style='color:GREEN;font-size:20px;text-align:center'>Invalid Email / Password...</div>"; 
				$this->load->view('website_template/login-header',$data);
				$this->load->view('login.php',$data);
				$this->load->view('website_template/login-footer',$data);
		}else{
				redirect('/');
		}
	}
	public function customer()
	{
		//$user_access = $this->login_model->check_customer_login();
				// print_r($user_access); die;
		 //if($user_access!=''){
				$data['title'] = ucfirst('Login - Cable Billing System '); 
				// $this->load->view('website_template/header',$data);
				//$data['msg'] = "<div style='color:GREEN;font-size:20px;text-align:center'>Invalid Email / Password...</div>"; 
				$this->load->view('customer_login.php',$data);
				// $this->load->view('website_template/footer',$data);
		 /*}else{
				$data['cust_id']= $this->session->userdata('cust_id');
				 
				$data['title'] = ucfirst('Login - Cable Billing System '); 
				$this->load->view('customer_login.php',$data);
		}*/
	//	$data['title'] = ucfirst('Login - Cable Billing System '); 
		// $this->load->view('website_template/header',$data);
	//	$this->load->view('login.php',$data);
		// $this->load->view('website_template/footer',$data);
	}
	public function check_customer()
	{
	
		$user_access = $this->login_model->check_customer_login();
		 
		 if($user_access!=''){
				$data['title'] = ucfirst('Login - Cable Billing System '); 
				// $this->load->view('website_template/header',$data);
				$data['msg'] = "<div style='color:GREEN;font-size:20px;text-align:center'>Invalid Email / Password...</div>"; 
				$this->load->view('customer_login.php',$data);
				// $this->load->view('website_template/footer',$data);
		 }else{
				redirect('/customer_dashboard');
		}/**/
		//redirect('/');
		//$data['edit_user'] = $user_access;
	}
	
	public function logout()
	{
		$emp_id=$this->session->userdata('emp_id');
		$login_id=$this->session->userdata('login_id');
		$user_access = $this->login_model->logout($login_id,$emp_id);
		redirect('login');
		//$data['edit_user'] = $user_access;
	}
	
	public function customer_logout()
	{
		// $emp_id=$this->session->userdata('emp_id');
		$user_access = $this->login_model->customer_logout();
		redirect('login/customer');
		
		//$data['edit_user'] = $user_access;
	}
	
	public function forgot()
	{
		$data['title'] = ucfirst('Forgot Password - Cable Billing System ');
		$this->load->view('forgot_password.php',$data);
	}
	
	public function check_forgot()
	{
	
		$user_access = $this->login_model->check_forgot();
		 
		if($user_access=='0'){
				$data['title'] = ucfirst('Forgot Password - Cable Billing System ');
				$data['msg'] = "<div style='color:RED;font-size:20px;text-align:center'>Invalid Email / Mobile Number...</div>"; 
				$this->load->view('forgot_password.php',$data);
		}
		elseif($user_access=='1'){
				$data['title'] = ucfirst('Forgot Password - Cable Billing System ');
				$data['msg'] = "<div style='color:GREEN;font-size:20px;text-align:center'>Password Sent to your Mobile..</div>"; 
				$this->load->view('forgot_password.php',$data);
		}
	}
	
	public function test()
	{
		$temp = $this->db->query("select cust_id,end_date from customers where cust_id IN (1)")->result_array();
		foreach($temp as $key => $res)
		{
			$custData = array();
			$custData['end_date'] = date("Y-m-d",(strtotime($res['end_date'])-86400));
			// print_r($res);exit;
			// $this->db->update("customers",$custData,array("cust_id"=>$res['cust_id']));
		}
		echo "Completed";
	}
	
	public function today_schedule()
	{
		$today = date("Y-m-d");
		$before_day = date("Y-m-d",strtotime("-1 days"));
		$before_2days = date("Y-m-d",strtotime("-2 days"));
		$temp = $this->db->query("select be.* from before_expiries be where be.be_status=0 AND be.cust_end_date<'$today' AND be.cust_end_date>'$before_2days'")->result_array();
		foreach($temp as $key => $res)
		{
			extract($res);
			$res2 = $this->db->query("select ca.* from customer_alacarte ca where ca.cust_id='$cust_id' AND ca.stb_id='$stb_id' AND ca.pack_id='$pack_id' AND ca.ca_date_created<'$today'")->result_array();
			if(count($res2)>0)
			{
				$custInfo = $this->db->query("select cust_id,stb_no,lco_portal_url,lco_username,lco_password from customers where cust_id='$cust_id'")->row_array();
				$packInfo = $this->db->query("select package_price,package_name,mso_ratio,mso_pack_id,cat_id from packages where package_id='$pack_id'")->row_array();
				$data2 = array(
					"cust_id" => $cust_id,
					"stb_id" => $stb_id,
					"pack_id" => $pack_id,
					"sms_status" => $res2[0]['sms_status'],
					"status" => $res2[0]['status'],
					"ar_month" => date('Y-m-01'),
					"removedOn" => date('Y-m-d H:i:s')
				);
				$this->db->insert("alacarte_remove", $data2);
				
				$temp2 = $this->db->query("delete from customer_alacarte where cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$pack_id'");
				
				$data3 = array(
    		        "cust_id" => $cust_id,
    		        "stb_id" => $stb_id,
    		        "ala_ch_id" => 0,
    		        "pack_id" => $pack_id,
    		        "ca_status" => 1,
    		        "ca_expiry" => date("Y-m-d",strtotime(date("t")." days")),
    		        "ca_date_created" => date('Y-m-d H:i:s')
    		    );
    		    $this->db->insert("customer_alacarte", $data3);
				
				$lco_portal_url = $custInfo['lco_portal_url'];
    			$lco_username = $custInfo['lco_username'];
    			$lco_password = $custInfo['lco_password'];
    		    $nxt_db = $this->load->database('nxt_db', TRUE);
    		    
    		    $nxtPackData = array();
    		    $nxtPackData['portal_url'] = $lco_portal_url;
    		    $nxtPackData['Username'] = $lco_username;
    		    $nxtPackData['Password'] = $lco_password;
    		    $nxtPackData['Cust_id'] = $cust_id;
    		    $nxtPackData['Box_no'] = $custInfo['stb_no'];
    		    $nxtPackData['pack_type'] = $packInfo['cat_id'];
    		    $nxtPackData['pack_no'] = $packInfo['mso_pack_id'];
    		    $nxtPackData['Action'] = 'Add Pack';
    		    $nxtPackData['Datecreated'] = date("Y-m-d");
    		    $nxtPackData['Status'] = 0;
    		    $nxt_db->insert("add_packages", $nxtPackData);
				
				$temp3 = $this->db->query("UPDATE before_expiries SET be_status=1 where cust_id='$cust_id' AND stb_id='$stb_id' AND pack_id='$pack_id'");
				
				$checkForLastRec = $this->db->query("select be_id from before_expiries where cust_id='$cust_id' AND stb_id='$stb_id' AND be_status=0")->num_rows();
				if($checkForLastRec==0)
				{
					$getAllPacks = $this->db->query("select GROUP_CONCAT(pack_id) as total_packs from before_expiries where cust_id='$cust_id' AND stb_id='$stb_id' AND be_status=1 AND cust_end_date='$before_day'")->row_array();
					$pack_no = $getAllPacks['total_packs'];
					$getMsoPackId = $this->db->query("select GROUP_CONCAT(mso_pack_id) as mso_pack_id from packages where package_id IN ($pack_no)")->row_array();
					
					$lco_portal_url = $custInfo['lco_portal_url'];
					$lco_username = $custInfo['lco_username'];
					$lco_password = $custInfo['lco_password'];
					$nxt_db = $this->load->database('nxt_db', TRUE);
					
					$nxtPackData = array();
					$nxtPackData['portal_url'] = $lco_portal_url;
					$nxtPackData['Username'] = $lco_username;
					$nxtPackData['Password'] = $lco_password;
					$nxtPackData['Cust_id'] = $cust_id;
					$nxtPackData['Box_no'] = $custInfo['stb_no'];
					$nxtPackData['pack_no'] = $getMsoPackId['mso_pack_id'];
					$nxtPackData['Mac_id'] = 0;
					$nxtPackData['Action'] = 'renew';
					$nxtPackData['Datecreated'] = date("Y-m-d");
					$nxtPackData['Status'] = 0;
					$nxt_db->insert("useractivation", $nxtPackData);
				}
				echo "Request Sent for ".$custInfo['stb_no']." with Pack ID :".$packInfo['mso_pack_id']."<br>";
			}
		}
		echo "Completed at ".date("Y-m-d H:i:s");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */