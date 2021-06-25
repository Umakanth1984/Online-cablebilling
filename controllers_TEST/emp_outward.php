<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_outward extends CI_Controller {

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
		$this->load->model('emp_outward_qty_model');	
	}
	public function index()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');	
			$inventories = $this->emp_outward_qty_model->get();		
			$data['inventories'] = $inventories;	
			$data['title'] = ucfirst('Employee Outward Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_outward.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	
	}
	public function emp_outward_save()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');	
			//  print_r($REQUEST); die;
			$cnt = $this->emp_outward_qty_model->save($_REQUEST);
			 $updateQty = $this->emp_outward_qty_model->updateQty($_REQUEST);
			$data['msg'] = ucfirst('Employee Outward Item Saved Successfully'); 
			redirect('/emp_outward');
		}
	}
   public function emp_outward_list()
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');	
			$inventories = $this->emp_outward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Employee Outward List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_outward.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function edit($id)
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');	
			$edit_inventory = $this->emp_outward_qty_model->get_by_id($id);
			$data['edit_inventory'] = $edit_inventory;
			$inventories = $this->emp_outward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_outward_edit.php',$data);
			$this->load->view('website_template/footer',$data);\
		}
	}
	public function emp_outward_updated($id)
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');	
			$edit_inventory = $this->emp_outward_qty_model->edit($id,$_REQUEST);
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$edit_inventory = $this->emp_outward_qty_model->get_by_id($id);
			$data['inventories'] = $edit_inventory;
			redirect('/emp_outward');
		}
	}
	public function delete($id)
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');	
			$edit_inventory = $this->emp_outward_qty_model->del($id);
			$data['msg'] = ucfirst('Employee Outward Item Deleted Successfully'); 
			redirect('/emp_outward');
		}
	}
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */