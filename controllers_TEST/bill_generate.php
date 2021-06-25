<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_generate extends CI_Controller {

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
		//$this->load->helper('form');
		//$this->load->library('form_validation');
		//$this->load->library('session');
		$this->load->library('pagination');
		$this->load->model('customer_model');	
		$this->load->model('bill_generate_model');	
		
	}
	
	public function index()
	{
		$data['admin_id']= "Cable Billing Team";
		$cnt = $this->bill_generate_model->generate_bill();
		$mailTest="Bill Generated for Cable Billing Demo at : ".date("Y-m-d H:i:s");
		mail("ukmca2007@gmail.com",$mailTest,$mailTest);
		mail("ukmca2007@gmail.com",$mailTest,$mailTest);
		echo "Bill Generated:".date("Y-m-d H:i:s");
		exit;
	}
	
	public function send_sms()
	{		 
		$data['admin_id']= "Cable Billing Team";
		$cnt = $this->bill_generate_model->send_sms();
		$data['msg'] = ucfirst('Data Saved Successfully'); 
		$mailTest="Bill Generated:".date("Y-m-d H:i:s");
		mail("ukmca2007@gmail.com",$mailTest,"SMS Sent");
		echo "SMS Sent:".date("Y-m-d H:i:s");
		exit;
	}
	 
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */