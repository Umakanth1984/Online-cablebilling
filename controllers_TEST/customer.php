<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
		$this->output->set_header('Access-Control-Allow-Origin: *');
	}
	
	public function index()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['adminId'] = $this->session->userdata('admin_id');
			$data['emp_id'] = $this->session->userdata('emp_id');
			$data['title'] = ucfirst('Add Customer');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['groups'] = $this->customer_model->get_groups($data['emp_id'],$data['adminId']);
// 			$data['packages'] = $this->customer_model->get_packages($data['emp_id'],$data['adminId']);
            $this->load->model("group_model");
            $data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
            $this->load->model("user_model");
            $data['credentials'] = $this->user_model->get_credentials($data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('customer.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
	public function customer_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$cnt = $this->customer_model->customer_no_exists($_REQUEST["inputCCN"],$_REQUEST["lco_id"]);
		    if ($cnt > 0)
			{
			 	$this->session->set_userdata('error_message', "Customer Number is already exists : ".$_REQUEST["inputCCN"]);
			 	redirect("customer");
			}
			else
			{
				$cnt = $this->customer_model->save_customer();
				$this->session->set_userdata('success_message', "Data Saved Successfully");
				redirect("customer");
			}
		}
	}
	
	public function customer_list()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Customers List');
			
			/*//pagination settings
			$config['base_url'] = base_url().'customer/customer_list';
			$config['total_rows'] = $this->db->count_all('customers');
			$config['per_page'] = "200";
			*/
			//pagination settings
			$config['base_url'] = base_url().'customer/customer_list';
			if(isset($_REQUEST['inputGroup']))
			{
				$sg = $_REQUEST['inputGroup'];
				$data['search_group'] = $_REQUEST['inputGroup'];
				$config['total_rows'] = $this->customer_model->get_customers_count($sg);
			}
			elseif($this->session->userdata('cur_grp_id')!='')
			{
				$sg = $this->session->userdata('cur_grp_id');
				//echo $sg;
				$data['search_group'] = $this->session->userdata('cur_grp_id');
				$config['total_rows'] = $this->customer_model->get_customers_count($sg);
			}
			else
			{
				$sg = '';
				$data['search_group'] = $_REQUEST['inputGroup'];
				$config['total_rows'] = $this->customer_model->get_customers_count($sg);
			}
			//echo $sg;
			$config['total_rows'] = $this->customer_model->get_customers_count($sg);
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$p=$data['page'];
			if(isset($_REQUEST['msg']) && $_REQUEST['msg']!='')
			{
			    $data['msg'] = $_REQUEST['msg'];
			}
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['customers'] = $this->customer_model->get_customer_list($config["per_page"],$data['page'],$get_emp_id,$p,$sg);
			$data['groups'] = $this->customer_model->get_groups($data['emp_id'],$data['adminId']);
			$this->load->model("group_model");
            $data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_list.php',$data);
		    $this->load->view('website_template/footer',$data);
		}
	}
	
	public function customer_monthlydues()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else
			{
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['lcactive']="active";
				$get_emp_id=$this->session->userdata('emp_id');
				// $customers = $this->customer_model->get_customer($get_emp_id);		
				// $data['customers'] = $customers;
				$data['title'] = ucfirst('Customers List');
				
				//pagination settings
				$config['base_url'] = base_url().'customer/customer_list';
				$config['total_rows'] = $this->db->count_all('customers');
				$config['per_page'] = "200";
				$config["uri_segment"] = 3;
				$choice = $config["total_rows"]/$config["per_page"];
				$config["num_links"] = floor($choice);

				// integrate bootstrap pagination
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = false;
				$config['last_link'] = false;
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '«';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '»';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$this->pagination->initialize($config);

				$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				
				// get books list
				$data['customers'] = $this->customer_model->get_customer_list($config["per_page"], $data['page'], $get_emp_id);
				
				$data['pagination'] = $this->pagination->create_links();
				
				$this->load->view('website_template/header',$data);
				$this->load->view('customer_monthlydues.php',$data);
			 $this->load->view('website_template/footer',$data);
			}
	}
	
	public function edit($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['title'] = ucfirst('Edit Customer');
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$edit_customer = $this->customer_model->get_customer_by_id($id);
			$data['edit_customer'] = $edit_customer;
			if(count($edit_customer)==0)
			{
				redirect('customer/customer_list');
			}
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['groups'] = $this->customer_model->get_groups($data['emp_id'],$data['adminId']);
			$this->load->model("group_model");
            $data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
            $this->load->model("user_model");
            $data['credentials'] = $this->user_model->get_credentials($data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_customer.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function customer_updated($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$emp_id= $this->session->userdata('emp_id');
			$edit_customers = $this->customer_model->edit_customer($id,$_REQUEST,$emp_id);
			redirect('customer/customer_list');
		}
	}
	
	public function make_payment($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$payment_customer = $this->customer_model->get_customer_by_id($id);
			$data['payment_customer'] = $payment_customer;
			$data['title'] = ucfirst('Make A Payment'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('make_payment.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function make_a_payment($id)
	{	
		if($this->session->userdata('cust_id')=='')
		{
			redirect('login');
		}
		else
		{
			$data['cust_id']= $this->session->userdata('cust_id');
			$payment_customer = $this->customer_model->get_customer_by_id($id);
			$data['payment_customer'] = $payment_customer;
			$data['title'] = ucfirst('Make A Payment'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('make_a_payment.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function reverse_payment($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['active']="active";
			$payment_customer = $this->customer_model->get_customer_by_id($id);
			$data['payment_customer'] = $payment_customer;
			$data['title'] = ucfirst('Reverse Payment'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('reverse_payment.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function inactive_customer($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$payment_customer = $this->customer_model->inactive_customer_customer_by_id($id,$get_emp_id);
			if($payment_customer==1)
			{
			    $msg1 = '<div style="color:GREEN;font-size:20px;text-align:center">Customer Inactivated Successfully</div>';
			    redirect('customer/inactive_customer_list?msg='.$msg1);
			}
			else
			{
			    $msg1 = '<div style="color:RED;font-size:20px;text-align:center">Customer Not Inactivated</div>';
			    redirect('customer/customer_list?msg='.$msg1);
			}
			$data['title'] = ucfirst('Customers List');
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Customer Inactivated Successfully</div>');
		    //pagination settings
			$config['base_url'] = base_url().'customer/inactive_customer_list';
			$config['total_rows'] = $this->db->count_all('customers');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['customers'] = $this->customer_model->get_customer_list($config["per_page"], $data['page'], $get_emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_list.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function activate_customer($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$payment_customer = $this->customer_model->activate_customer_by_id($id,$get_emp_id);
			redirect('customer/inactive_customer_list');
		}
	}
	
	public function payment()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$pay_customer = $this->customer_model->payment($_REQUEST);
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Payment Done Successfully</div>');
			redirect('customer/customer_list');
		}
	}
	
	public function payment_reverse()
	{	 
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$pay_customer = $this->customer_model->payment_reverse($_REQUEST);
			$get_emp_id= $this->session->userdata('emp_id');
			// $paymentslist = $this->customer_model->get_payments($get_emp_id);	
			// $data['payments'] = $paymentslist;
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Payment Done Successfully</div>'); 
			//$this->load->view('website_template/header',$data);
			//$this->load->view('paymentList.php',$data);
			//$this->load->view('website_template/footer',$data); 
			redirect('customer/customer_list');
		}
	}	
	
	public function todaypaymentslist()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['active']="active";
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Today Collection History');
			
			//pagination settings
			$config['base_url'] = base_url().'customer/todaypaymentslist';
			$config['total_rows'] = $this->db->count_all('payments');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			// get books list
			$data['payments'] = $this->customer_model->get_payments($config["per_page"], $data['page'], $get_emp_id);
			
			$data['pagination'] = $this->pagination->create_links();
			// $paymentslist = $this->customer_model->get_payments($get_emp_id);	
			// $data['payments'] = $paymentslist; 
			
			$this->load->view('website_template/header',$data);
			$this->load->view('paymentList.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}	
	
	public function monthlypaymentslist()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			//$data['active']="active";
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Monthly Payment History'); 
			
			//pagination settings
			$month=date("Y-m-00 00:00:00");
			$config['base_url'] = base_url().'customer/monthlypaymentslist';
			//$this->db->select('payment_id');
			//$this->db->from('payments');
			//$this->db->where('dateCreated >=',$month);
			//$config['total_rows'] = $this->db->get('payments');$this->db->count_all('customers');
			//$config['total_rows'] = $this->db->count_all('payments');
			if(isset($_REQUEST['inputGroup']))
			{
				$sg = $_REQUEST['inputGroup'];
				$data['mpl_search_group'] = $_REQUEST['inputGroup'];
				$config['total_rows'] = $this->customer_model->get_monthly_payments_count($sg,$get_emp_id);
			}
			elseif($this->session->userdata('mpl_cur_grp_id')!='')
			{
				$sg = $this->session->userdata('cur_grp_id');
				//echo $sg;
				$data['mpl_search_group'] = $this->session->userdata('mpl_cur_grp_id');
				$config['total_rows'] = $this->customer_model->get_monthly_payments_count($sg,$get_emp_id);
			}
			else
			{
				$sg = '';
				$data['mpl_search_group'] = $_REQUEST['inputGroup'];
				$config['total_rows'] = $this->customer_model->get_monthly_payments_count($sg,$get_emp_id);
			}				
			$config['total_rows'] = $this->customer_model->get_monthly_payments_count($sg,$get_emp_id);
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$p=$data['page'];
			// get books list
			$data['payments'] = $this->customer_model->get_payments_monthly($config["per_page"], $data['page'], $get_emp_id, $p, $sg);
			
			$data['pagination'] = $this->pagination->create_links();				
			// $paymentslist = $this->customer_model->get_payments_monthly($get_emp_id);	
			// $data['payments'] = $paymentslist;
			
			$this->load->view('website_template/header',$data);
			$this->load->view('paymentListMonthly.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function totaloutstanding()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Total Outstanding History'); 
			$get_emp_id=$this->session->userdata('emp_id');
			
			//pagination settings
			$config['base_url'] = base_url().'customer/totaloutstanding';
			//$config['total_rows'] = $this->db->count_all('customers');
			if(isset($_REQUEST['inputGroup']))
			{
				$sg = $_REQUEST['inputGroup'];
				$data['to_search_group'] = $_REQUEST['inputGroup'];
				$config['total_rows'] = $this->customer_model->get_totaloutstanding_count($sg,$get_emp_id);
			}
			elseif($this->session->userdata('to_cur_grp_id')!='')
			{
				$sg = $this->session->userdata('cur_grp_id');
				//echo $sg;
				$data['to_search_group'] = $this->session->userdata('to_cur_grp_id');
				$config['total_rows'] = $this->customer_model->get_totaloutstanding_count($sg,$get_emp_id);
			}
			else
			{
				$sg = '';
				$data['to_search_group'] = $_REQUEST['inputGroup'];
				$config['total_rows'] = $this->customer_model->get_totaloutstanding_count($sg,$get_emp_id);
			}
			$config['total_rows'] = $this->customer_model->get_totaloutstanding_count($sg,$get_emp_id);				
			$config['per_page'] = "20";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$p=$data['page'];
			// get books list
			$data['payments'] = $this->customer_model->get_outstanding($config["per_page"], $data['page'], $get_emp_id, $p, $sg);
			
			$data['pagination'] = $this->pagination->create_links();				
			// $paymentslist = $this->customer_model->get_outstanding($get_emp_id);	
			// $data['payments'] = $paymentslist;
			
			$this->load->view('website_template/header',$data);
			$this->load->view('total_outstanding.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}	
	
	public function paymentslistCheque()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['active']="active";
			$data['title'] = ucfirst('Payment History'); 
			
			//pagination settings
			$config['base_url'] = base_url().'customer/paymentslistCheque';
			$config['total_rows'] = $this->db->count_all('payments');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			// get books list
			$data['payments'] = $this->customer_model->get_payments_cheque($config["per_page"], $data['page']);
			
			$data['pagination'] = $this->pagination->create_links();				
			// $paymentslist = $this->customer_model->get_payments_cheque();	
			// $data['payments'] = $paymentslist;
			
			$this->load->view('website_template/header',$data);
			$this->load->view('paymentListCheque.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	 
	public function view($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$view_customer = $this->customer_model->get_customer_by_id($id);		
			$data['customer'] = $view_customer;
			$data['title'] = ucfirst('View customers Data'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('view_customer.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function delete($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$delete_cust = $this->customer_model->del_customer($id,$get_emp_id);
			redirect('/customer/customer_list');
		}
	}
	
	public function paymentHistory($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$paymenthistory = $this->customer_model->get_payments_history($id,$get_emp_id);	
			$data['paymenthistory'] = $paymenthistory;
			$data['customer_id']=$id;
			$data['title'] = ucfirst('Payment History'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('paymentHistory.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function paymentDeleteView($id,$payment_id,$amount)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$del_payment = $this->customer_model->get_customer_payment_by_id($id,$payment_id,$get_emp_id);
			$data['paymentdelete'] = $del_payment;
			$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id='$id'"));
			if($resCust['admin_id']==$data['adminId'] || $data['adminId']==1)
			{
				$data['customer_id']=$id;
			}
			$data['title'] = ucfirst('Payment History'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('delete_customer_payment.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function paymentEdit($id,$payment_id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$edit_payment = $this->customer_model->get_customer_payment_by_id($id,$payment_id,$get_emp_id);
			$data['edit_payment'] = $edit_payment;
			$resCust=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM customers WHERE cust_id='$id'"));
			if($resCust['admin_id']==$data['adminId'])
			{
				$data['customer_id'] = $id;
			}
			$data['title'] = ucfirst('Edit Customer'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_payment.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function editPayment($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id= $this->session->userdata('emp_id');
			$edit_customer = $this->customer_model->payment_edit($id,$get_emp_id,$_REQUEST);
			// $paymentslist = $this->customer_model->get_payments($get_emp_id);	
			// $data['payments'] = $paymentslist;
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Payment Done Successfully</div>'); 
			//$this->load->view('website_template/header',$data);
			//$this->load->view('paymentList.php',$data);
			//$this->load->view('website_template/footer',$data); 
			redirect('customer/paymentHistory/'.$id);
		}
	}
	
	public function paymentDelete($id,$payment_id,$amount)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id= $this->session->userdata('emp_id');
			//$delReason= $_REQUEST['delReason'];
			$delete_payment = $this->customer_model->payment_delete($id,$payment_id,$amount,$get_emp_id);
			// $data['payments'] = $paymentslist;
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Payment Done Successfully</div>'); 
			//$this->load->view('website_template/header',$data);
			//$this->load->view('paymentList.php',$data);
			//$this->load->view('website_template/footer',$data); 
			redirect('customer/paymentHistory/'.$id);
		}
	}
	
	public function inactive_customer_list()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Inactive Customers List');
			//pagination settings
			$config['base_url'] = base_url().'customer/inactive_customer_list';
			$config['total_rows'] = $this->db->count_all('customers');
			$config['per_page'] = "500";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			if(isset($_REQUEST['msg']) && $_REQUEST['msg']!='')
			{
			    $data['msg'] = $_REQUEST['msg'];
			}
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['groups'] = $this->customer_model->get_groups($data['emp_id'],$data['adminId']);
			$this->load->model("group_model");
            $data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
			$data['customers'] = $this->customer_model->get_inactive_customer_list($config["per_page"], $data['page'], $get_emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('inactive_customer_list.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function get_program_data()
	{
		$program_id = $this->input->post('program_id');
		$data['last_id'] = $this->customer_model->get_program_specific($program_id);
		echo json_encode($data['last_id']);
	}
	
	public function cust_card($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$customer = $this->customer_model->get_customer_by_id($id);
			$data['customer'] = $customer;
			//$this->load->view('website_template/header',$data);
			$this->load->view('customer_card.php',$data);
			//$this->load->view('website_template/footer',$data);
		}
	}
	
	public function customer_pwds()
	{
		$cnt = $this->customer_model->generate_pwds();
		echo "Customers Passwords generated ..".date("Y-m-d H:i:s");
		exit;
	}
	
	public function multi_del()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$delete_cust = $this->customer_model->multi_del_customer($get_emp_id);
			redirect('/customer/inactive_customer_list');
		}
 	}
	
	public function delete_stb()
	{
		$program_id = $this->input->post('program_id');
		$program_id2 = $this->input->post('program_id2');
		$data['last_id'] = $this->customer_model->delete_stb($program_id2,$program_id);
		echo json_encode($data['last_id']);
	}
	
	public function customer_stb($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Customer STB Info');
			$data['customer_stb'] = $this->customer_model->get_customer_stb_by_id($id);
			$data['stage'] = 1;
			if($data['customer_stb']==0)
			{
				redirect('customer/customer_list?msg=STB No is missing.');
			}
			// $data['billing_info'] = $this->customer_model->get_customer_billing($id,$data['customer_stb'][0]['stb_id']);
			$data['fetch_expiry'] = $this->customer_model->get_stb_expiry_from_nxt();
// 			if(isset($_REQUEST['stbSubmit']) && $_REQUEST['stbSubmit']!='')
// 			{
			    $this->load->model('Dashboard_model');
			    $check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			    $check_wallet = $this->customer_model->check_lco_wallet($data['admin_id']);
			    if($check_wallet===true || $check_emp_type[0]['user_type']==9)
			    {
			        // $data['base_packs'] = $this->customer_model->get_base_packages($data['emp_id']);
			        $stb_info = $this->customer_model->get_customer_stb_info_by_id($_REQUEST['stb_id']);
			        $data['pack_id'] = $stb_info[0]['pack_id'];
    				$data['stage'] = 2;
    				$data['custId'] = $id;
    				$data['stb_id'] = $data['customer_stb'][0]['stb_id'];
    				$data['stb_bouquets'] = $this->customer_model->get_customer_bouquets($id,$data['stb_id']);
    				// $data['stb_pay_channels'] = $this->customer_model->get_customer_pay_channels($id,$data['stb_id']);
    				$data['stb_bouquets_req'] = $this->customer_model->get_customer_bouquets_req($id,$data['stb_id']);
    				// $data['stb_pay_channels_req'] = $this->customer_model->get_customer_pay_channels_req($id,$data['stb_id']);
    				$data['stb_expiry'] = $this->customer_model->get_stb_expiry($id,$data['stb_id']);
    				if($check_emp_type[0]['user_type']!=9)
    				{
    				    $data['bouquets'] = $this->customer_model->get_bouquets($data['admin_id']);
    				}
    				else
    				{
    				    $data['bouquets'] = $this->customer_model->get_bouquets();
    				}
    				// $data['pay_channels'] = $this->customer_model->get_pay_channels();
			    }
			    elseif($check_wallet===false)
			    {
			        redirect('customer/customer_list?type=2&msg=Something Went Wrong');
			    }
			    else
			    {
					$adminID = $data['customer_stb'][0]['admin_id'];
					$adminInfo = $this->db->query("select balance from admin where admin_id='$adminID'")->row_array();
			        redirect('customer/customer_list?type=2&msg=You have low wallet balance of Rs.'.$adminInfo['balance'].'. Please recharge your wallet.');
			    }
// 			}
            /*if(isset($_REQUEST['renew']) && $_REQUEST['renew']!='')
			{
			    $data['stb_renew'] = $this->customer_model->renew_stb();
			    if($data['stb_renew'] == 1)
			    {
			        redirect('customer/customer_list?type=2&msg=Customer Renewed.');
			    }
			    else
			    {
			        redirect('customer/customer_list?msg=failed2');
			    }
			}*/
			if(isset($_REQUEST['submit']) && $_REQUEST['submit']!='')
			{
				$_REQUEST['cust_id'] = $id;
				$data['stb_request'] = $this->customer_model->add_stb_request();
				if($data['stb_request']==0)
				{
					redirect('customer/customer_list?msg=failed');
				}
				$getNewlyAddedReq = $this->customer_model->get_newly_added_requests($id,$_REQUEST['stb_id']);
				$packNos = array();
				$this->load->model('Dashboard_model');
				foreach($getNewlyAddedReq as $key2 => $reqInfo)
				{
				    $last_id = $this->Dashboard_model->add_to_stb($id,$_REQUEST['stb_id'],$reqInfo['alacarte_req_id']);
				    if($last_id==true)
				    {
				        $packNos[] = $reqInfo['pack_id'];
				    }
				}
				$packNos = implode(",",$packNos);
				$renew_packs = $this->Dashboard_model->renew_packs($id,$_REQUEST['stb_id'],$packNos);
				redirect('customer/customer_list?msg=success');
			}
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_stb.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function del_cust_bq()
	{
		$cust_id = $this->input->post('id2');
		$stb_id = $this->input->post('id3');
		$bq_id = $this->input->post('id4');
		$data['last_id'] = $this->customer_model->del_cust_bq($cust_id,$stb_id,$bq_id);
		echo json_encode($data['last_id']);
	}
	
	public function del_cust_alacarte()
	{
		$cust_id = $this->input->post('id2');
		$stb_id = $this->input->post('id3');
		$ala_id = $this->input->post('id4');
		$data['last_id'] = $this->customer_model->del_cust_alacarte($cust_id,$stb_id,$ala_id);
		echo json_encode($data['last_id']);
	}
	
	public function renew_stb()
	{
		$data['result'] = $this->customer_model->renew_stb(); 
		echo json_encode($data['result']);
	}
	
	public function temp_unavail()
	{
	    echo '
	    <html>
	        <head>
	            <title>Temporarily Unavailable</title>
	        </head>
	        <body>
	            <h1 style="text-align:center;color:RED;">This service is Temporarily Unavailable.</h1>
	            <h1 style="text-align:center;color:RED;">Please check after some time</h1>
	        </body>
	    </html>
	    ';
	}
	
	public function onlinepayment()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['active']="active";
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Online Payment History'); 
			
			//pagination settings
			$month=date("Y-m-00 00:00:00");
			$config['base_url'] = base_url().'customer/onlinepayment';
			$this->db->select('payment_id');
			// $this->db->from('payments');
			$this->db->where('dateCreated >=',$month);
			$config['total_rows'] = $this->db->get('payments');
			
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
			// get books list
			$data['payments'] = $this->customer_model->get_payments_online($config["per_page"], $data['page'], $get_emp_id);
			
			$data['pagination'] = $this->pagination->create_links();				
			// $paymentslist = $this->customer_model->get_payments_monthly($get_emp_id);	
			// $data['payments'] = $paymentslist;
			
			$this->load->view('website_template/header',$data);
			$this->load->view('paymentListonline.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function get_lco_groups()
	{
	    $lco_id = $this->input->post('lco_id');
        $groups = $this->customer_model->get_lco_groups($lco_id);
		if($groups>0)
		{
			echo "<option value=''>Select Group</option>";
			foreach ($groups as $key => $value)
			{
				echo '<option value="'.$value["group_id"].'">'.$value["group_name"].'</option>';
			}
		}
		else
		{
			echo "<option value=''>No Groups</option>";
		}
	}
	
	public function stb_retrack()
	{
		$cust_id = $this->input->post('cust_id');
		$stb_id = $this->input->post('stb_id');
		$stb_no = $this->input->post('stb_no');
		$data['response'] = $this->customer_model->stb_retrack($cust_id,$stb_id,$stb_no);
		echo json_encode($data['response']);
	}
	
	public function check_stb_expiry()
	{
		$cust_id = $this->input->post('cust_id');
		$stb_id = $this->input->post('stb_id');
		$stb_no = $this->input->post('stb_no');
		$data['response'] = $this->customer_model->check_stb_expiry($cust_id,$stb_id,$stb_no);
		echo json_encode($data['response']);
	}
	
	public function check_customer_no()
	{
		$custom_customer_no = $this->input->post('value');
		$lco_id = $this->input->post('lco_id');
		$data['response'] = $this->customer_model->customer_no_exists($custom_customer_no,$lco_id);
		echo json_encode($data['response']);
	}
	
	public function expiry_customer_list()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['title'] = ucfirst('Expiring Customers List');
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			//pagination settings
			$config['base_url'] = base_url().'customer/expiry_customer_list';
			$config['total_rows'] = $this->db->count_all('customers');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['groups'] = $this->customer_model->get_groups($data['emp_id'],$data['adminId']);
			$this->load->model("group_model");
            $data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
			$data['customers'] = $this->customer_model->get_expiry_customer_list($config["per_page"], $data['page'], $get_emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('expiry_customer_list.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */