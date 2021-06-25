<?php 
class Login_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	public function check_login() {
				$email = $_REQUEST['loginEmail'];
				$password = $_REQUEST['loginPwd'];
				$this->db->select('emp_id,admin_id');
				$this->db->where("(emp_email='$email' OR emp_mobile_no='$email')",NULL, FALSE);
				$this->db->where('emp_password', $password);        // Run the query
				$query = $this->db->get('employes_reg');
				$row = $query->row();
				if ($query->num_rows() > 0) {
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
					
					$env_info=$_SERVER['HTTP_USER_AGENT'];
					
					$data1 = array(
						"emp_id" => $row->emp_id,
						"admin_id" => $row->admin_id,
						"ip" => $ipaddress,
						"env_info" => $env_info,
						"login_time" => date("Y-m-d H:i:s")
					);
					$this->db->insert("login_history", $data1);
					$login_id = $this->db->insert_id();
					// If there is a user, then create session data

					$data = array(
						'emp_id' => $row->emp_id,
						'admin_id' => $row->admin_id,
						'email' => $email,
						'login_id' => $login_id,
						'Login' => TRUE
					);
					$this->session->set_userdata($data);
					return 1;
				}
				else{
					return 0;
				}
			 
		}
  
	  public function check_customer_login() {
				 
					$email = $_REQUEST['loginEmail'];
					$password = $_REQUEST['loginPwd'];
					$this->db->select('cust_id');
					$this->db->where("(email_id='$email' OR mobile_no='$email')",NULL, FALSE);
					$this->db->where('pwd', $password);        // Run the query
					$query = $this->db->get('customers');
					 
					if ($query->num_rows() > 0) {
						// If there is a user, then create session data
					 
						$row = $query->row();
						$data = array(
							'cust_id' => $row->cust_id,
							'email' => $email,
							'Login' => TRUE
						);
						$this->session->set_userdata($data);
						return $this->session->set_userdata($data);
					}
					else{
						return 0;
					}
				 
			}
  
  	public function forgot_password() {
			 
				$email = $_REQUEST['loginEmail'];
				 
				$this->db->select('emp_id');
				$this->db->where("(emp_email='$email' OR emp_mobile_no='$email')", NULL, FALSE);
			 
				$query = $this->db->get('employes_reg');
				 
				if ($query->num_rows() > 0) {
					// If there is a user, then create session data
				 
					$row = $query->row();
					$data = array(
						'emp_id' => $row->emp_id,
						'email' => $email,
						'Login' => TRUE
					);
				 
				}
				else{
					return 0;
				}
		 
		}
		
	public function logout($login_id,$emp_id) {
			
			$logout_data = array(						
						"logout_time" => date("Y-m-d H:i:s")
					);

				$this->db->where("(login_id='$login_id' AND emp_id='$emp_id')",NULL, FALSE);
				$this->db->update('login_history', $logout_data);
		
				$data = array(
						'emp_id' => '',
						'admin_id' => '',
						'email' => '',
						'cur_page_no' => '',
						'cur_grp_id' => '',
						'Login' => FALSE
					);
			$this->session->unset_userdata($data);
			return $this->session->unset_userdata($data);
	}
	public function customer_logout() {
				$data = array(
						'cust_id' => '',
						'email' => '',
						'Login' => FALSE
					);
			 $this->session->unset_userdata($data);
			 
			 return $this->session->unset_userdata($data);
	}
 
	public function check_forgot() {
		extract($_REQUEST);
		$query = mysql_query("select emp_id,emp_email,emp_mobile_no from employes_reg where emp_email='$loginEmail' OR emp_mobile_no='$loginEmail' AND status=1");
		$res=mysql_fetch_assoc($query);
		$count=mysql_num_rows($query);
		// echo $count;die;
		if($count==1)
		{
			$id=$res['emp_id'];
			$genPwd=rand(100000,999999);
			$data = array(
					"emp_password" => $genPwd
				);
			$this->db->where('emp_id', $id);
			$this->db->update('employes_reg', $data);
			
			$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer"));
			
			if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendservicesmsemployee']=='Yes')){
			
			// Send SMS
				$mess = urlencode("Your Login details for ".base_url()." are - Email: ".$res['emp_email']. " password: ".$genPwd);
				
				$url = "http://www.bulksmsapps.com/apisms.aspx?user=DIGITALRUPAY&password=Digital@1&genkey=195470434&sender=DRUPAY&number=".$res['emp_mobile_no']."&message=" . $mess;
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
				curl_close ($ch);			
			}
			return 1;
		}	
		else
		{
			return 0;
		}
		// print_r($res);die;
		// die;
	}
}