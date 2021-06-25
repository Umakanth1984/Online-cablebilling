<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complaints extends CI_Controller {

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
		$this->load->model('complaints_model');	
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
			$data['title'] = ucfirst('complaints');
			$cust=$this->complaints_model->get_customers_id($get_emp_id);
			$data['cust']=$cust;
			$this->load->view('website_template/header',$data);
			$this->load->view('complaints.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function complaints_save()
	{
		 
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			// $cust=$this->complaints_model->get_customers_id();
			// $data['cust']=$cust;
			$cnt = $this->complaints_model->save_complaints();
			// $data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Complaint Registered Successfully</div>'); 
			// $this->load->view('website_template/header',$data);
			// $this->load->view('complaints.php',$data);
			// $this->load->view('website_template/footer',$data);
			redirect('complaints/complaints_list');
		}
	}
	
	public function edit($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$get_emp_id=$this->session->userdata('emp_id');
				$edit_complaints = $this->complaints_model->get_complaints_by_id($id,$get_emp_id);
				$data['edit_complaints'] = $edit_complaints;
				$data['title'] = ucfirst('Edit complaint'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('edit_complaints.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	
	public function complaints_updated($id)
	{
		$get_emp_id=$this->session->userdata('emp_id');
		$edit_complaints = $this->complaints_model->edit_complaints($id,$get_emp_id);
		// $data['msg'] = ucfirst('Data Updated Successfully'); 
		// $edit_complaints = $this->complaints_model->get_complaints_by_id($id);
		// $data['complaints'] = $edit_complaints;
		redirect('complaints/complaints_list');
	}
	
   public function complaints_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$complaints = $this->complaints_model->get_complaints($get_emp_id);		
			$data['complaints'] = $complaints;
			$data['title'] = ucfirst('complaints List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('complaints_list.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function view($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$view_complaints = $this->complaints_model->get_complaints_by_id($id,$get_emp_id);		
			$data['complaints'] = $view_complaints;
			$data['title'] = ucfirst('View complaints Details'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('view_complaints.php',$data);
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
			$get_emp_id=$this->session->userdata('emp_id');
			$closed_complaints = $this->complaints_model->closed_complaints($get_emp_id);		
			$data['closed_complaints'] = $closed_complaints;
			$data['title'] = ucfirst('Closed Complaints Details'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('view_closed_complaints.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */