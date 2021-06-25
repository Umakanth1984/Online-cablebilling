<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
	 function __construct() { 
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('pagination');		
		$this->load->model('reports_model');
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
				$data['title'] = ucfirst('Customers Reports'); 
				$emp_id=$this->session->userdata('emp_id');
				// $paid=$this->reports_model->get_paid_customers();
				// $data['paid'] = $paid;
				
				//pagination settings
				$config['base_url'] = base_url().'reports/index';
				$config['total_rows'] = $this->db->count_all('customers');
				$config['per_page'] = "100";
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
				$data['customers'] = $this->reports_model->get_customers($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();
				
				// $customers=$this->reports_model->get_customers(1000, 1, $emp_id);
				// $data['customers']=$customers;
				$this->load->view('website_template/header',$data);
				$this->load->view('customer_reports.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function paid()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Paid Customers Reports'); 
				$emp_id=$this->session->userdata('emp_id');
				// $paid=$this->reports_model->get_paid_customers();
				// $data['paid'] = $paid;
				
				//pagination settings
				$config['base_url'] = base_url().'reports/paid';
				$config['total_rows'] = $this->db->count_all('customers');
				$config['per_page'] = "100";
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
				$data['customers'] = $this->reports_model->get_paid_customers($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();

				$this->load->view('website_template/header',$data);
				$this->load->view('paid_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}

	public function unpaid()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Unpaid Customers Reports'); 
				$emp_id=$this->session->userdata('emp_id');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/unpaid';
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
				
				$data['unpaid'] = $this->reports_model->get_unpaid_customers($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();				
				$this->load->view('website_template/header',$data);
				$this->load->view('unpaid_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function advancepaid()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Advance Paid Customers Reports');
				$emp_id=$this->session->userdata('emp_id');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/advancepaid';
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
				
				$data['advancepaid'] = $this->reports_model->get_adv_paid_customers($config["per_page"], $data['page'], $emp_id);
				$this->load->view('website_template/header',$data);
				$this->load->view('advance_paid_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function active_customers()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Active Customers Reports'); 
				$emp_id=$this->session->userdata('emp_id');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/active_customers';
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
				
				$data['active'] = $this->reports_model->get_active_customers($config["per_page"], $data['page'], $emp_id);
				$this->load->view('website_template/header',$data);
				$this->load->view('active_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function inactive_customers()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Inactive Customers Reports'); 
				$emp_id=$this->session->userdata('emp_id');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/inactive_customers';
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
				
				$data['inactive'] = $this->reports_model->get_inactive_customers($config["per_page"], $data['page'], $emp_id);
				$this->load->view('website_template/header',$data);
				$this->load->view('inactive_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}

	public function one_time_charges()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('One Time Charges Customers Reports'); 
				$inactive=$this->reports_model->get_one_time_charges();
				$data['inactive'] = $inactive;
				$this->load->view('website_template/header',$data);
				$this->load->view('one_time_charges.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}

	public function deactive_reactive()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Deactive and Reactive Customers Reports'); 
				$inactive=$this->reports_model->get_deactive_reactive();
				$data['inactive'] = $inactive;
				$this->load->view('website_template/header',$data);
				$this->load->view('deactive_reactive.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}

	public function connections()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Connections Customers Reports'); 
				$connection=$this->reports_model->get_connections();
				$data['connection'] = $connection;
				$this->load->view('website_template/header',$data);
				$this->load->view('connections.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function new_connection()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('New Connection Customers Reports'); 
				$new_con=$this->reports_model->get_new_connection();
				$data['new_con'] = $new_con;
				$this->load->view('website_template/header',$data);
				$this->load->view('new_connection.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function collection()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Employee Collection Reports'); 
				$emp_id= $this->session->userdata('emp_id');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/collection';
				$month=date("Y-m-00 00:00:00");
				$this->db->select('payment_id');
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
				$data['payments'] = $this->reports_model->get_collection($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();				
				
				// $inactive=$this->reports_model->get_collection($emp_id);
				// $data['inactive'] = $inactive;
				
				$this->load->view('website_template/header',$data);
				$this->load->view('collection.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function allcollections()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('All Collection Reports');
				$emp_id= $this->session->userdata('emp_id');
				//pagination settings
				$config['base_url'] = base_url().'reports/allcollections';
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
				$data['allcollections'] = $this->reports_model->get_allcollections($config["per_page"], $data['page'], $emp_id);
				$data['pagination'] = $this->pagination->create_links();
				// $allcollections=$this->reports_model->get_allcollections();
				// $data['allcollections'] = $allcollections;
				$this->load->view('website_template/header',$data);
				$this->load->view('all_collections.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function monthdemand()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Monthly Demand Reports');
				$emp_id = $this->session->userdata('emp_id');
				//pagination settings
				$config['base_url'] = base_url().'reports/monthdemand';
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
				$data['cust_data'] = $this->reports_model->get_monthdemand($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();
				
				// $inactive=$this->reports_model->get_monthdemand();
				// $data['inactive'] = $inactive;
				$this->load->view('website_template/header',$data);
				$this->load->view('monthly_demand.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function open_complaints()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Open Complaints Reports'); 
				$open_comp=$this->reports_model->get_open_complaints();
				$data['open_comp'] = $open_comp;
				$this->load->view('website_template/header',$data);
				$this->load->view('open_complaints.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function closed_complaints()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Closed Complaints Reports'); 
				$closed_comp=$this->reports_model->get_closed_complaints();
				$data['closed_comp'] = $closed_comp;
				$this->load->view('website_template/header',$data);
				$this->load->view('closed_complaints.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function complaints()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Complaints Reports'); 
				$emp_id = $this->session->userdata('emp_id');
				// die;
				//pagination settings
				$config['base_url'] = base_url().'reports/complaints';
				$config['total_rows'] = $this->db->count_all('create_complaint');
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
				$data['comp'] = $this->reports_model->get_complaints($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();
				
				// $data['comp']=$this->reports_model->get_complaints();
				$this->load->view('website_template/header',$data);
				$this->load->view('complaint_reports.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function expenses()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Employee Collection Reports');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/expenses';
				$config['total_rows'] = $this->db->count_all('expenses_inward_qty');
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
				$data['getExp'] = $this->reports_model->get_expenses($config["per_page"], $data['page']);
				
				$data['pagination'] = $this->pagination->create_links();
				
				// $getExp=$this->reports_model->get_expenses();
				// $data['getExp'] = $getExp; 
				$this->load->view('website_template/header',$data);
				$this->load->view('expenses_reports.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function current_month_demand()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Current Month Demand Report');
				$emp_id = $this->session->userdata('emp_id');
				//pagination settings
				$config['base_url'] = base_url().'reports/current_month_demand';
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
				$data['cust_data'] = $this->reports_model->get_current_month_demand($config["per_page"], $data['page'], $emp_id);
				
				$data['pagination'] = $this->pagination->create_links();
				
				// $inactive=$this->reports_model->get_monthdemand();
				// $data['inactive'] = $inactive;
				$this->load->view('website_template/header',$data);
				$this->load->view('current_month_demand.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function datewise()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['active']="active";
				$get_emp_id=$this->session->userdata('emp_id');
				$data['title'] = ucfirst('DATEWISE Payment History'); 
				
				//pagination settings
				$month=date("Y-m-00 00:00:00");
				$config['base_url'] = base_url().'reports/datewise';
				$this->db->select('payment_id');
				// $this->db->from('payments');
				$this->db->where('dateCreated >=',$month);
				$config['total_rows'] = $this->db->get('payments');
				
				$config['per_page'] = "100";
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
				$data['payments'] = $this->reports_model->get_payments_datewise($config["per_page"], $data['page'], $get_emp_id);
				
				$data['pagination'] = $this->pagination->create_links();				
				// $paymentslist = $this->customer_model->get_payments_monthly($get_emp_id);	
				// $data['payments'] = $paymentslist;
				
				$this->load->view('website_template/header',$data);
				$this->load->view('datewise.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}	
	
	public function nextpaymentdate()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Next Payment Date Report'); 
			$next_payment_info=$this->reports_model->get_next_payment_date_list();	
			$data['next_payment_info'] = $next_payment_info;
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data);
		}		
	}
	
	public function log_history()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Log History'); 
			$get_log_history=$this->reports_model->get_log_history();	
			$data['get_log_history'] = $get_log_history;
			$this->load->view('website_template/header',$data);
			$this->load->view('log_track.php',$data);
			$this->load->view('website_template/footer',$data);
		}		
	}
	
	public function new_con()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('New Customers Reports'); 
				$emp_id=$this->session->userdata('emp_id');
				
				//pagination settings
				$config['base_url'] = base_url().'reports/active_customers';
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
				
				$data['active'] = $this->reports_model->get_new_customers($config["per_page"], $data['page'], $emp_id);
				$this->load->view('website_template/header',$data);
				$this->load->view('new_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
 	
 	public function franchise()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('LCO Wise Wallet Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$config['base_url'] = base_url().'reports/franchise';
			$config['total_rows'] = $this->db->count_all('f_accounting');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			// $this->load->model('Dashboard_model');
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$data['franchise_log'] = $this->reports_model->get_franchise_log($config["per_page"], $data['page'], $emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('franchise_report.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function ala_reject()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Ala-carte Reject Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$config['base_url'] = base_url().'reports/ala_reject';
			$config['total_rows'] = $this->db->count_all('alacarte_reject');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			// $this->load->model('Dashboard_model');
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$customer_reject_requets = $this->reports_model->get_ala_reject_log($config["per_page"], $data['page'], $emp_id);
			foreach($customer_reject_requets as $key => $creq)
			{
				$data['customer_rejects'][$key]['alacarte_rej_id'] = $creq['alacarte_rej_id'];
				$data['customer_rejects'][$key]['cust_id'] = $creq['cust_id'];
				$data['customer_rejects'][$key]['first_name'] = $creq['first_name'];
				$data['customer_rejects'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
				$data['customer_rejects'][$key]['mobile_no'] = $creq['mobile_no'];
				$data['customer_rejects'][$key]['addr1'] = $creq['addr1'];
				$data['customer_rejects'][$key]['stb_no'] = $creq['stb_no'];
				$data['customer_rejects'][$key]['mac_id'] = $creq['mac_id'];
				$data['customer_rejects'][$key]['card_no'] = $creq['card_no'];
				$customer_ala_req = $this->Dashboard_model->get_customer_alacarte_reject($creq['cust_id'],$creq['stb_id'],$creq['alacarte_rej_id']);
				foreach($customer_ala_req as $key2 => $c2)
				{
					$data['customer_rejects'][$key]['alacarte'][]= $c2;
				}
				$customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_reject($creq['cust_id'],$creq['stb_id'],$creq['alacarte_rej_id']);
				foreach($customer_bouquet_req as $key3 => $c3)
				{
					$data['customer_rejects'][$key]['bouquet'][]= $c3;
				}
			}
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('ala_reject_report.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function ala_approved()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Activated Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
				redirect("/");
			}
			$config['base_url'] = base_url().'reports/ala_approved';
			$config['total_rows'] = $this->db->count_all('alacarte_request');
			$config['per_page'] = "500";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$customer_approved_requets = $this->reports_model->get_ala_approved_log($config["per_page"], $data['page'], $emp_id);
			foreach($customer_approved_requets as $key => $creq)
			{
				$data['customer_approved'][$key]['alacarte_req_id'] = $creq['alacarte_req_id'];
				$data['customer_approved'][$key]['cust_id'] = $creq['cust_id'];
				$data['customer_approved'][$key]['first_name'] = $creq['first_name'];
				$data['customer_approved'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
				$data['customer_approved'][$key]['mobile_no'] = $creq['mobile_no'];
				$data['customer_approved'][$key]['addr1'] = $creq['addr1'];
				$data['customer_approved'][$key]['stb_no'] = $creq['stb_no'];
				$data['customer_approved'][$key]['mac_id'] = $creq['mac_id'];
				$data['customer_approved'][$key]['card_no'] = $creq['card_no'];
				$data['customer_approved'][$key]['empFname'] = $creq['empFname'];
				// $customer_ala_req = $this->Dashboard_model->get_customer_alacarte_approved($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
				// foreach($customer_ala_req as $key2 => $c2)
				// {
					// $data['customer_approved'][$key]['alacarte'][]= $c2;
				// }
				$customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_approved($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
				foreach($customer_bouquet_req as $key3 => $c3)
				{
					$data['customer_approved'][$key]['bouquet'][]= $c3;
				}
			}
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('ala_approved_report.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function customer_renewals()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Customer Renewal Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$config['base_url'] = base_url().'reports/customer_renewals';
			$config['total_rows'] = $this->db->count_all('customer_renewals');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$data['customer_renewals'] = $this->reports_model->get_customer_renewals($config["per_page"], $data['page'], $emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_renewals.php',$data);
			$this->load->view('website_template/footer',$data);
		}
 	}
 	
 	public function removal_requests()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Remove Request Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$config['base_url'] = base_url().'reports/removal_requests';
			$config['total_rows'] = $this->db->count_all('alacarte_remove');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$customer_requets_pending = $this->reports_model->get_customer_removal_requests($config["per_page"], $data['page'], $emp_id);
			$data['customer_requets'] = array();
			foreach($customer_requets_pending as $key => $creq)
			{
				$data['customer_requets'][$key]['alacarte_remove_id'] = $creq['alacarte_remove_id'];
				$data['customer_requets'][$key]['cust_id'] = $creq['cust_id'];
				$data['customer_requets'][$key]['first_name'] = $creq['first_name'];
				$data['customer_requets'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
				$data['customer_requets'][$key]['mobile_no'] = $creq['mobile_no'];
				$data['customer_requets'][$key]['addr1'] = $creq['addr1'];
				$data['customer_requets'][$key]['stb_id'] = $creq['stb_id'];
				$data['customer_requets'][$key]['cust_balance'] = $creq['cust_balance'];
				$data['customer_requets'][$key]['stb_no'] = $creq['stb_no'];
				$data['customer_requets'][$key]['mac_id'] = $creq['mac_id'];
				$data['customer_requets'][$key]['card_no'] = $creq['card_no'];
				$customer_ala_req = $this->Dashboard_model->get_customer_alacarte_remove_info($creq['cust_id'],$creq['stb_id'],$creq['alacarte_remove_id']);
				foreach($customer_ala_req as $key2 => $c2)
				{
					$data['customer_requets'][$key]['alacarte'][]= $c2;
				}
				$customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_remove_info($creq['cust_id'],$creq['stb_id'],$creq['alacarte_remove_id']);
				foreach($customer_bouquet_req as $key3 => $c3)
				{
					$data['customer_requets'][$key]['bouquet'][]= $c3;
				}
			}
			// $data['customer_removal_requests'] = $this->reports_model->get_customer_removal_requests($config["per_page"], $data['page'], $emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('removal_report.php',$data);
			$this->load->view('website_template/footer',$data);
		}
 	}
 	
 	public function all_cust_channels()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('All Customers Packages Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$config['base_url'] = base_url().'reports/all_cust_channels';
			$config['total_rows'] = $this->db->count_all('customer_alacarte');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			$results = $this->Dashboard_model->lco_franchise_list();
		    $data['lco_list'] = $results;
			$customer_approved_requets = $this->reports_model->get_all_cust_channels($config["per_page"], $data['page'], $emp_id);
			foreach($customer_approved_requets as $key => $creq)
			{
			    $data['customer_approved'][$key]['cust_id'] = $creq['cust_id'];
			    $data['customer_approved'][$key]['first_name'] = $creq['first_name'];
			    $data['customer_approved'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
			    $data['customer_approved'][$key]['mobile_no'] = $creq['mobile_no'];
			    $data['customer_approved'][$key]['addr1'] = $creq['addr1'];
			    $data['customer_approved'][$key]['stb_no'] = $creq['stb_no'];
			    $data['customer_approved'][$key]['mac_id'] = $creq['mac_id'];
			    $data['customer_approved'][$key]['card_no'] = $creq['card_no'];
			    $customer_ala_req = $this->Dashboard_model->get_customer_alacarte($creq['cust_id'],$creq['stb_id'],$creq['ca_id']);
			    foreach($customer_ala_req as $key2 => $c2)
			    {
			        $data['customer_approved'][$key]['alacarte'][]= $c2;
			    }
			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet($creq['cust_id'],$creq['stb_id'],$creq['ca_id']);
			    foreach($customer_bouquet_req as $key3 => $c3)
			    {
			        $data['customer_approved'][$key]['bouquet'][]= $c3;
			    }
			}
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('all_cust_channels_report.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function lco_wallets()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('LCO Wise Wallet Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$config['base_url'] = base_url().'reports/franchise';
			$config['total_rows'] = $this->db->count_all('f_accounting');
			$config['per_page'] = "200";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$data['franchise_log'] = $this->reports_model->get_lco_wallet($config["per_page"], $data['page'], $emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('lco_wallet_report.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function cust_accounting()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Collection Report');
			$emp_id= $this->session->userdata('emp_id');
			$this->load->model('Dashboard_model');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
				$data['user_type'] = $check_emp_type[0]['user_type'];
			}
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
				redirect("/");
			}
			$config['base_url'] = base_url().'reports/cust_accounting';
			$config['total_rows'] = $this->db->count_all('cust_accounting');
			$config['per_page'] = "500";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);
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
			$results = $this->Dashboard_model->lco_franchise_list();
			$data['lco_list'] = $results;
			$data['customer_approved'] = $this->reports_model->get_cust_accounting_log($config["per_page"], $data['page'], $emp_id);
			$data['pagination'] = $this->pagination->create_links();
			$this->load->view('website_template/header',$data);
			$this->load->view('cust_accounting_report.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */