<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->model('Welcome_model');
		$this->load->model('Dashboard_model');
	}
	
	
	public function index()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Dashboard');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['lcoList'] = $this->Dashboard_model->lco_franchise_list();
			$this->load->view('website_template/header',$data);
			$this->load->view('index.php',$data);
			$this->load->view('website_template/home-footer',$data); 
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */