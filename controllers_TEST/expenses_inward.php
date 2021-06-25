<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses_inward extends CI_Controller {

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
		$this->load->model('expenses_inward_qty_model');	
		//$this->load->model('expenses_outward_qty_model');	
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
			$inventories = $this->expenses_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('expenses Inward Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_inward.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function expenses_inward_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$cnt = $this->expenses_inward_qty_model->save($_REQUEST);
			redirect('/expenses_inward');
		}
	}
	
	public function expenses_inward_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$inventories = $this->expenses_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('expenses Inward List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_inward.php',$data);
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
			$edit_expenses = $this->expenses_inward_qty_model->get_by_id($id);
			$data['edit_expenses'] = $edit_expenses;
			$inventories = $this->expenses_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_inward_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function expenses_inward_updated($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id= $this->session->userdata('emp_id');
			$edit_expenses = $this->expenses_inward_qty_model->edit($id,$_REQUEST,$get_emp_id);
			// $data['msg'] = ucfirst('Data Updated Successfully'); 
			// $edit_expenses = $this->expenses_inward_qty_model->get_by_id($id);
			// $data['inventories'] = $edit_expenses;
			redirect('/expenses_inward');
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
			$get_emp_id= $this->session->userdata('emp_id');
			$edit_expenses = $this->expenses_inward_qty_model->del($id,$get_emp_id);
			// $data['msg'] = ucfirst('expenses Inward Item Deleted Successfully');
			redirect('/expenses_inward');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */