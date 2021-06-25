<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Changepwd extends CI_Controller {

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
		$this->load->model('settings_model');	
	}
	public function index()
	{
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['cust_id']= $this->session->userdata('cust_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Change Password'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_change_password.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function change_password()
	{
		
		//$cnt = $this->user_model->user_email_exists($_REQUEST["inputEmail"],$_REQUEST["inputMobile"]);
		//print_r($cnt); extract($cnt); echo $cnt[0]['emp_id']; die;
		//$existing_id=$cnt[0]['emp_id'];
        if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$this->settings_model->customer_password_change();
				//$data['edit_user'] = $edit_user1;
				//$edit_user_access = $this->user_model->get_users_access_id($existing_id);
				//$data['edit_user_access'] = $edit_user_access;
				$data['title'] = ucfirst('Change Password'); 
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Password Changed Successfully...</div>'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('customer_change_password.php',$data);
				$this->load->view('website_template/footer',$data);
        }
		 
	}
	
	public function username()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Change Username'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('change_username.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function change_username()
	{
        if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$this->settings_model->username_change();
				//$data['edit_user'] = $edit_user1;
				//$edit_user_access = $this->user_model->get_users_access_id($existing_id);
				//$data['edit_user_access'] = $edit_user_access;
				$data['title'] = ucfirst('Change Username'); 
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Username is updated.</div>'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('change_username.php',$data);
				$this->load->view('website_template/footer',$data);
        }
		 
	}
	
	public function assign_import()
	{
        if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$data['import_data']= $this->settings_model->get_import_values();
				
				$data['title'] = ucfirst('Assign Excelsheet');
				$this->load->view('website_template/header',$data);
				$this->load->view('import_excel_format.php',$data);
				$this->load->view('website_template/footer',$data);
        }
	}
	
	public function update_import()
	{
        if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$this->settings_model->update_import_values();
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Excelsheet Format Updated ..</div>'); 
				$data['import_data']= $this->settings_model->get_import_values();
				
				$data['title'] = ucfirst('Assign Excelsheet');
				$this->load->view('website_template/header',$data);
				$this->load->view('import_excel_format.php',$data);
				$this->load->view('website_template/footer',$data);
        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */