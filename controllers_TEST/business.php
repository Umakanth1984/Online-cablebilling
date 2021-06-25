<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business extends CI_Controller {

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
		$this->load->model('business_model');	
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
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Business Information'); 
			$get_business_infomation=$this->business_model->get_business_info($get_emp_id);	
			$data['business_information'] = $get_business_infomation;
			$this->load->view('website_template/header',$data);
			$this->load->view('business_info.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_business()
	{
        if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$get_emp_id=$this->session->userdata('emp_id');
				$save=$this->business_model->business_save();
				$get_business_infomation=$this->business_model->get_business_info($get_emp_id);	
				$data['business_information'] = $get_business_infomation;
				$data['title'] = ucfirst('Business Information'); 
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Business Information Updated.</div>'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('business_info.php',$data);
				$this->load->view('website_template/footer',$data);
        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */