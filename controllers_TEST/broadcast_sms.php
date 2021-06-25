<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Broadcast_sms extends CI_Controller {

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
		$this->load->library('pagination');
		$this->load->model('customer_model');	
		$this->load->model('broadcast_sms_model');	
	 
	}
	
	public function index()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				//$cnt = $this->broadcast_sms_model->broadcast_sms();
				//$data['msg'] = "<h2 style='text-align:center;color:GREEN;'>Bill Generated:".date("Y-m-d H:i:s")."</h2>"; 
				$this->load->view('website_template/header',$data);
				$this->load->view('broadcast_sms.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	
	public function sendSms()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$cnt = $this->broadcast_sms_model->broadcast_sms();
				$data['msg'] = "<h2 style='text-align:center;color:GREEN;'>SMS Send Successfully...</h2>"; 
				$this->load->view('website_template/header',$data);
				$this->load->view('broadcast_sms.php',$data);
				$this->load->view('website_template/footer',$data);
		}
	}
	
	public function single_sms()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Send Single SMS');
				$this->load->view('website_template/header',$data);
				$this->load->view('broadcast_single_sms.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	
	public function sendSingleSms()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$cnt = $this->broadcast_sms_model->broadcast_single_sms();
				$data['title'] = ucfirst('Send Single SMS');
				$data['msg'] = "<h2 style='text-align:center;color:GREEN;'>SMS Sent Successfully...</h2>"; 
				$this->load->view('website_template/header',$data);
				$this->load->view('broadcast_single_sms.php',$data);
				$this->load->view('website_template/footer',$data);
		}
	}	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */