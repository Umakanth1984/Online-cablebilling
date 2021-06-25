<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_dashboard extends CI_Controller {

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
		$this->load->model('complaints_model');	
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
				$data['title'] = ucfirst('Customers'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('customer_dashboard.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	} 
	public function edit($id)
	{	
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$edit_customer = $this->customer_model->get_customer_by_id($id);
				$data['edit_customer'] = $edit_customer;
				$data['title'] = ucfirst('Edit Customer'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('edit_customer.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	public function customer_updated($id)
	{	
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$edit_customers = $this->customer_model->edit_customer($id,$_REQUEST);
				$data['msg'] = ucfirst('Data Updated Successfully'); 
				$edit_customer = $this->customer_model->get_customer_by_id($id);
				$data['customers'] = $edit_customer;
				redirect('customer/customer_list');
			}
	}
	public function make_payment($id)
	{	
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$payment_customer = $this->customer_model->get_customer_by_id($id);
				$data['payment_customer'] = $payment_customer;
				$data['title'] = ucfirst('Make A Payment'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('make_payment.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	 
	public function payment_history()
	{	
		
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$get_cust_id= $this->session->userdata('cust_id');
				$transactionslist = $this->customer_model->get_transactions_by_id($get_cust_id);
				$data['transactionslist'] = $transactionslist;
				$data['title'] = ucfirst('Payment History'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('customerPaymentHistory.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	public function paymentHistory($id)
	{	
			if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
				{			 
					redirect('login');
				}
			else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$transactionslist = $this->customer_model->get_payments_history($id);	
				$data['transactionslist'] = $transactionslist;
				$data['cust_id']=$id;
				$data['title'] = ucfirst('Payment History'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('customerPaymentHistory.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	public function complaints()
	{	
		
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['cust_id']= $this->session->userdata('cust_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$get_cust_id= $this->session->userdata('cust_id');
				$complaints = $this->customer_model->get_complaints_by_id($get_cust_id);
				$data['complaints'] = $complaints;
				$data['title'] = ucfirst('Customer Complaints'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('customer_complaints.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	 
	 public function add_complaint()
	{
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['cust_id']= $this->session->userdata('cust_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('complaints');
			 
			$this->load->view('website_template/header',$data);
			$this->load->view('add_complaints.php',$data);
			$this->load->view('website_template/footer',$data);
		}	
			
	}
	public function complaints_save()
	{
		if(($this->session->userdata('cust_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['cust_id']= $this->session->userdata('cust_id');
			$data['admin_id']= $this->session->userdata('admin_id');
		//	print_r($REQUEST); die;
			 
			$cnt = $this->complaints_model->save_complaints();
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Complaint Registered Successfully</div>'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('add_complaints.php',$data);
			$this->load->view('website_template/footer',$data);
		}
            
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */