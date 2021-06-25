<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charts extends CI_Controller {

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
				$data['admin_id']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Employee wise Collection Chart'); 
				$active=$this->reports_model->get_active_cust_number();
				$inactive=$this->reports_model->get_inactive_cust_number();
				$data['active'] = $active;
				$data['inactive'] = $inactive;
				//$this->load->view('website_template/header',$data);
				$this->load->view('charts.php',$data);
				//$this->load->view('website_template/footer',$data); 
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
				$data['admin_id']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Open/Closed Complaints Chart'); 
				$active=$this->reports_model->get_open_comp_number();
				$inactive=$this->reports_model->get_closed_comp_number();
				$data['active'] = $active;
				$data['inactive'] = $inactive;
				$this->load->view('website_template/header',$data);
				$this->load->view('chart2.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
}
?>