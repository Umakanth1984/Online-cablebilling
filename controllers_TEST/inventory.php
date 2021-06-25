<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller {

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
		$this->load->model('inventory_model');	
	}
	public function index()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$inventories = $this->inventory_model->get_inventory();		
			$data['inventories'] = $inventories;	
			$data['title'] = ucfirst('Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('inventory.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	
	}
	public function inventory_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
				 	extract($_REQUEST); 
				 $cnt = $this->inventory_model->inventory_id_exists($item_number);
				// print_r($cnt); extract($cnt); echo $cnt[0]['emp_id']; die;
				$existing_id=$cnt[0]['inv_id'];
				if ($existing_id > 0) {
						$edit_inventory = $this->inventory_model->get_inventory_by_id($existing_id);
						$data['edit_inventory'] = $edit_inventory;
						$inventories = $this->inventory_model->get_inventory();		
						$data['inventories'] = $inventories;
						$data['msg'] = ucfirst('<div style="text-align:center;color:red"><h3>Inventory ID is already existed..</h3></div>'); 
						$data['title'] = ucfirst('Edit Inventory Items'); 
						$this->load->view('website_template/header',$data);
						$this->load->view('inventory_edit.php',$data);
						$this->load->view('website_template/footer',$data);
				} else {
					//  print_r($REQUEST); die;
					
						$cnt = $this->inventory_model->save_inventory();
						$data['msg'] = ucfirst('Inventory Item Saved Successfully'); 
						redirect('/inventory');
				}
		}
		
     //  print_r($REQUEST); die;
		/*$cnt = $this->inventory_model->save_inventory($REQUEST);
		$data['msg'] = ucfirst('Inventory Item Saved Successfully'); 
		redirect('/inventory'); */
	}
   public function inventories_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$inventories = $this->inventory_model->get_inventory();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Inventory List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('inventory.php',$data);
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
			$edit_inventory = $this->inventory_model->get_inventory_by_id($id);
			$data['edit_inventory'] = $edit_inventory;
			$inventories = $this->inventory_model->get_inventory();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit Inventory Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('inventory_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function inventory_updated($id)
	{	
		$edit_inventory = $this->inventory_model->edit_inventory($id);
		$data['msg'] = ucfirst('Data Updated Successfully'); 
		$edit_inventory = $this->inventory_model->get_inventory_by_id($id);
		$data['inventories'] = $edit_inventory;
		redirect('/inventory');
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
			$edit_inventory = $this->inventory_model->del_inventory($id);
			$data['msg'] = ucfirst('Inventory Item Deleted Successfully'); 
			redirect('/inventory');
		}
	}
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */