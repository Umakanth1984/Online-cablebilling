<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_inward extends CI_Controller {

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
		$this->load->model('emp_inward_qty_model');	
		$this->load->model('emp_outward_qty_model');	
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
			$emp_id= $this->session->userdata('emp_id');			
			$inventories = $this->emp_inward_qty_model->get($emp_id);		
			$data['inventories'] = $inventories;	
			$data['title'] = ucfirst('Employee Outward Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_inward.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	public function emp_inward_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['admin_id']= $this->session->userdata('admin_id');	
				$emp_id=$this->session->userdata('emp_id');
				//print_r($REQUEST); die;
				 $cnt = $this->emp_inward_qty_model->cust_inv_exists($_REQUEST["customer_id"],$_REQUEST["inv_id"]);
				//print_r($cnt); extract($cnt); echo $cnt[0]['emp_id']; die;
				$existing_id=$cnt[0]['emp_inward_id'];
				if ($existing_id > 0) {
						$edit_inventory = $this->emp_inward_qty_model->edit($existing_id,$emp_id);
						$updateQty = $this->emp_inward_qty_model->updateQty($emp_id);
						$data['msg'] = ucfirst('Data Updated Successfully'); 
						$edit_inventory = $this->emp_inward_qty_model->get_by_id($existing_id);
						$data['inventories'] = $edit_inventory;
						redirect('/emp_inward');		
				} else {
					$cnt = $this->emp_inward_qty_model->save($emp_id);
					$updateQty = $this->emp_inward_qty_model->updateQty($emp_id);
					$data['msg'] = ucfirst('Employee Outward Item Saved Successfully'); 
					redirect('/emp_inward');
				}
			//  print_r($REQUEST); die;
		}
	
	}
	public function emp_inward_return()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$emp_id= $this->session->userdata('emp_id');			
			//print_r($REQUEST); die;
			 $cnt = $this->emp_inward_qty_model->cust_inv_exists($_REQUEST["customer_id"],$_REQUEST["inv_id"]);
			// print_r($cnt); extract($cnt); echo $cnt[0]['emp_id']; die;
			extract($cnt);
			$existing_id=$cnt[0]['emp_inward_id'];
			if ($existing_id > 0) {
					$edit_inventory = $this->emp_inward_qty_model->return_inventry($existing_id,$emp_id);
					$data['msg'] = ucfirst('Data Updated Successfully'); 
					$edit_inventory = $this->emp_inward_qty_model->get_by_id($existing_id);
					$data['inventories'] = $edit_inventory;
					redirect('/emp_inward');		
			} else {
				//$cnt = $this->emp_inward_qty_model->save($emp_id);
				//$updateQty = $this->emp_inward_qty_model->updateQty($emp_id);
				//$data['msg'] = ucfirst('Employee Outward Item Saved Successfully'); 
				//redirect('/emp_inward');
			}
			//  print_r($REQUEST); die;
		}
	
	}
   public function emp_inward_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$inventories = $this->emp_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Employee Outward List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_inward.php',$data);
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
			$edit_inventory = $this->emp_inward_qty_model->get_by_id($id);
			$data['edit_inventory'] = $edit_inventory;
			$inventories = $this->emp_inward_qty_model->get();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_inward_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function emp_inward_updated($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');	
			$edit_inventory = $this->emp_inward_qty_model->edit($id,$_REQUEST);
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$edit_inventory = $this->emp_inward_qty_model->get_by_id($id);
			$data['inventories'] = $edit_inventory;
			redirect('/emp_inward');
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
			$edit_inventory = $this->emp_inward_qty_model->del($id);
			$data['msg'] = ucfirst('Employee Outward Item Deleted Successfully'); 
		 	redirect('/emp_inward');
		}
	}
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */