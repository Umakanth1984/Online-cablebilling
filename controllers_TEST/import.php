<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/PHPExcel.php";
ini_set('max_execution_time', 900);
ini_set('memory_limit', '512M');
class Import extends CI_Controller {

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
		$this->load->model('import_model');	
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
			$data['title'] = ucfirst('Import Customers');
			if(isset($_REQUEST['msg']) && $_REQUEST['msg']!='')
			{
			    $data['msg'] = $_REQUEST['msg'];
			}
            if(isset($_REQUEST['error']) && $_REQUEST['error']!='')
            {
                $error_data = $this->import_model->get_error_data_by_id($_REQUEST['error']);
                $data['error_data'] = $error_data['error_message'];
            }
			$this->load->view('website_template/header',$data);
			$this->load->view('import_customer.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function import_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Import Customers');
			$get_emp_id= $this->session->userdata('emp_id');
			$uploaded_data=$this->import_model->save_import($get_emp_id);
            redirect('import/index?msg='.$uploaded_data['uploaded']."&error=".$uploaded_data['ie_id']);
		}
	}
	
	public function package_import()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$this->load->model('customer_model');
			$data['emp_info']=$this->customer_model->get_employee_info($data['emp_id']);
			if($data['emp_info']['user_type']!=9)
			{
			    $this->session->set_userdata('error_message', "Unauthorized Access.");
			    redirect("/");
			}
			$data['title'] = ucfirst('Bulk Package Upload');
			if(isset($_REQUEST['msg']) && $_REQUEST['msg']!='')
			{
			    $data['msg'] = $_REQUEST['msg'];
			}
            if(isset($_REQUEST['error']) && $_REQUEST['error']!='')
            {
                $error_data = $this->import_model->get_error_data_by_id($_REQUEST['error']);
                $data['error_data'] = $error_data['error_message'];
            }
			if(isset($_POST['uploadPackage']) && $_POST['uploadPackage']!='')
			{
    			$uploaded_data=$this->import_model->save_package_import();
    			redirect('import/package_import?msg='.$uploaded_data['uploaded']."&error=".$uploaded_data['ie_id']);
    		}
			$this->load->view('website_template/header',$data);
			$this->load->view('import_package.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function dues()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Import Customers');
			$this->load->view('website_template/header',$data);
			$this->load->view('import_customer_dues.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_import_dues()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Import Customers');
			$get_common=$this->import_model->save_import_dues();
// 			$get_common=$this->import_model->save_bulk_pay();
		  //  $this->load->model('dashboard_model');
    //         $get_common=$this->dashboard_model->save_batch_import_new();
			$data['get_common']=$get_common;
			$this->load->view('website_template/header',$data);
			$this->load->view('import_customer_dues.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */