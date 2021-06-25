<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empdeposit extends CI_Controller {

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
		//$this->load->library('session');
		$this->load->model('empdeposit_model');	
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
				$data['title'] = ucfirst('Employee Deposits'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('empdeposit.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	public function empdeposit_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');	
				$cnt = $this->empdeposit_model->save_employe_deposit($REQUEST);
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Data Saved Successfully</div>'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('empdeposit.php',$data);
				$this->load->view('website_template/footer',$data);
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
				$edit_empdeposit = $this->empdeposit_model->get_empdeposit_by_id($id);
				$data['edit_empdeposit'] = $edit_empdeposit;
				$data['title'] = ucfirst('Edit complaint'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('edit_empdeposit.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}
	public function empdeposit_updated($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$emp_id= $this->session->userdata('emp_id');
				$edit_empdeposit = $this->empdeposit_model->edit_empdeposit($id,$emp_id);
				$data['msg'] = ucfirst('Data Updated Successfully');
				$edit_empdeposit = $this->empdeposit_model->get_empdeposit_by_id($id);
				$data['empdeposit'] = $edit_empdeposit;
				redirect('empdeposit/empdeposit_list');
			}
	}
   public function empdeposit_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');	
				$empdeposit = $this->empdeposit_model->get_employe_deposit();		
				$data['empdeposit'] = $empdeposit;
				$data['title'] = ucfirst('empdeposit List'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('empdeposit_list.php',$data);
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
				$view_empdeposit = $this->empdeposit_model->get_empdeposit_by_id($id);		
				$data['empdeposit'] = $view_empdeposit;
				$data['title'] = ucfirst('View empdeposit Data'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('view_empdeposit.php',$data);
				$this->load->view('website_template/footer',$data);
			}
	}  
	public function delete($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');	
				//$id=$this->uri->segment(3);
				$this->empdeposit_model->delete_empdeposit_by_id($id);
				$data['empdeposit']=$this->empdeposit_model->getposts();
				$this->load->view('empdeposit_list.php',$data);
			}
	}
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */