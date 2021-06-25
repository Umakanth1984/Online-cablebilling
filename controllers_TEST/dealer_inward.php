<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dealer_inward extends CI_Controller {

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
		$this->load->model('dealer_inward_qty_model');	
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
			$inventories = $this->dealer_inward_qty_model->get();		
			$data['inventories'] = $inventories;	
			$outward_inventories = $this->dealer_outward_qty_model->get();		
			$data['outward_inventories'] = $outward_inventories;
			$data['title'] = ucfirst('Dealer Inward Items'); 
			$this->load->view('website_template/header',$data);
			
			$this->load->view('dealer_inward.php',$data);
			
			$this->load->view('website_template/footer',$data); 
		}
	
	}
	public function dealer_inward_save()
	{
		// print_r($_REQUEST); die;
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			 //
			$cnt = $this->dealer_inward_qty_model->save($_REQUEST);
			$data['msg'] = ucfirst('Dealer Inward Item Saved Successfully'); 
			redirect('/dealer_inward');
		}
	}
   public function dealer_inward_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$inventories = $this->dealer_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Dealer Inward List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_inward.php',$data);
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
			$data['admin_id']= $this->session->userdata('admin_id');	
			$edit_inventory = $this->dealer_inward_qty_model->get_by_id($id);
			$data['edit_inventory'] = $edit_inventory;
			$inventories = $this->dealer_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_inward_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function dealer_inward_updated($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$edit_inventory = $this->dealer_inward_qty_model->edit($id,$_REQUEST);
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$edit_inventory = $this->dealer_inward_qty_model->get_by_id($id);
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
			$edit_inventory = $this->dealer_inward_qty_model->del($id);
			$data['msg'] = ucfirst('Dealer Inward Item Deleted Successfully'); 
			 
			redirect('/dealer_inward');
		}
	}
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */