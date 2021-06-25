<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/PHPExcel.php";

class Check_payment extends CI_Controller {
    public function __construct() {
        parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('reports_model');
		$this->load->model('customer_model');
 
			$this->load->database();

			 
    }

	public function index()
	{
		// print_r($_REQUEST);
 		if(($this->session->userdata('cust_id')==''))
			{			 
				redirect('login');
			}
			else{
				 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Check Payments'); 
				 
				$this->load->view('website_template/header',$data);
				$this->load->view('check_payments.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function check($id)
	{
		
 		if(($this->session->userdata('cust_id')==''))
			{			 
				redirect('login');
			}
			else{
				 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Check Payments'); 
				// $payment_customer = $this->customer_model->get_customer_by_id($id);
				// $data['payment_customer'] = $payment_customer;
				$this->load->view('website_template/header',$data);
				$this->load->view('check_details.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
}
?>