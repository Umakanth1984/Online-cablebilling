<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_rollback extends CI_Controller {

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
		//$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		//$this->load->library('session');
		$this->load->library('pagination');
		$this->load->model('customer_model');	
		$this->load->model('bill_rollback_model');	
		
	}
	
	public function index()
	{
 
				//$data['emp_id']= $this->session->userdata('emp_id');
				//$data['admin_id']= $this->session->userdata('admin_id');
				$data['admin_id']= "Cable Billing Team";
				$cnt = $this->bill_rollback_model->rollback_bill();
				$data['msg'] = ucfirst('Data Saved Successfully'); 
				//$this->load->view('website_template/header',$data);
				//$this->load->view('customer.php',$data);
				//$this->load->view('website_template/footer',$data);
				mail("naveenkumar4994@gmail.com","test","test");
				echo "Bill Roll Back Done:".date("Y-m-d H:i:s");
				exit;

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */