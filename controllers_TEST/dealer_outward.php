<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dealer_outward extends CI_Controller {

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
		$this->load->model('dealer_outward_qty_model');	
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
			$inventories = $this->dealer_outward_qty_model->get();		
			$data['inventories'] = $inventories;	
			$data['title'] = ucfirst('Dealer Inward Items'); 
			$this->load->view('website_template/header',$data);
			
			$this->load->view('dealer_inward.php',$data);
			
			$this->load->view('website_template/footer',$data); 
		}
	}
	public function dealer_outward_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			//print_r($REQUEST); die;
			$cnt = $this->dealer_outward_qty_model->save();
			$updateQty = $this->dealer_outward_qty_model->updateAddQty();
			$data['msg'] = ucfirst('Dealer Inward Item Saved Successfully'); 
			redirect('/dealer_inward');
		}
	}
   public function dealer_outward_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$inventories = $this->dealer_outward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Dealer Inward List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_inward.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function edit($id)
	{	
		//print_r($id); die;
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$edit_inventory = $this->dealer_outward_qty_model->get_by_id($id);
			//print_r($edit_inventory); die;
			$data['edit_inventory'] = $edit_inventory;
		
			//$inventories = $this->dealer_outward_qty_model->get();		
			//$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_outward_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function dealer_outward_updated($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$updateQty = $this->dealer_outward_qty_model->updateQty();
			$edit_inventory = $this->dealer_outward_qty_model->edit($id);
			
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$edit_inventory = $this->dealer_outward_qty_model->get_by_id($id);
			$data['inventories'] = $edit_inventory;
			redirect('/dealer_inward');
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
			$data['admin_id']= $this->session->userdata('admin_id');	
			$edit_inventory = $this->dealer_outward_qty_model->del($id);
			$data['msg'] = ucfirst('Dealer Inward Item Deleted Successfully'); 
			 
			redirect('/dealer_inward');
		}
	}
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */