<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses extends CI_Controller {

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
		$this->load->model('expenses_model');	
	}
	
	public function index()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$inventories = $this->expenses_model->get_expenses();		
			$data['inventories'] = $inventories;	
			$data['title'] = ucfirst('expenses Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function expenses_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
				 	extract($_REQUEST); 
				 $cnt = $this->expenses_model->expenses_id_exists($name);
				// print_r($cnt); extract($cnt); echo $cnt[0]['emp_id']; die;
				$existing_id=$cnt[0]['exp_id'];
				if ($existing_id > 0) {
						$edit_expenses = $this->expenses_model->get_expenses_by_id($existing_id);
						$data['edit_expenses'] = $edit_expenses;
						$inventories = $this->expenses_model->get_expenses();		
						$data['inventories'] = $inventories;
						$data['msg'] = ucfirst('<div style="text-align:center;color:red"><h3>expenses ID is already existed..</h3></div>'); 
						$data['title'] = ucfirst('Edit expenses Items'); 
						$this->load->view('website_template/header',$data);
						$this->load->view('expenses_edit.php',$data);
						$this->load->view('website_template/footer',$data);
				} else {
					//  print_r($REQUEST); die;
						$cnt = $this->expenses_model->save_expenses();
						$data['msg'] = ucfirst('expenses Item Saved Successfully'); 
						redirect('/expenses');
				}
		}
	}
	
	public function category()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$categories = $this->expenses_model->get_expenses_cat();		
			//print_r($categories); die;
			$data['categories'] = $categories;	
			$data['title'] = ucfirst('Expenses Category Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_cat.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function expenses_cat_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
				extract($_REQUEST); 
				$cnt = $this->expenses_model->expenses_cat_id_exists($catName);
				// print_r($cnt); extract($cnt); echo $cnt[0]['emp_id']; die;
				$existing_id=$cnt[0]['exp_cat_id'];
				if ($existing_id > 0) {
						$edit_expenses_cat = $this->expenses_model->get_expenses_cat_by_id($existing_id);
						$data['edit_expenses_cat'] = $edit_expenses_cat;
						$data['msg'] = ucfirst('<div style="text-align:center;color:red"><h3>Expenses Category Name is already existed..</h3></div>'); 
						$data['title'] = ucfirst('Edit expenses Items'); 
						$this->load->view('website_template/header',$data);
						$this->load->view('expenses_cat_edit.php',$data);
						$this->load->view('website_template/footer',$data);
				} else {
					//  print_r($REQUEST); die;
						$cnt = $this->expenses_model->save_expenses_cat();
						$data['msg'] = ucfirst('expenses Item Saved Successfully'); 
						redirect('/expenses/category');
				}
		}
	}
	
	public function inventories_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$inventories = $this->expenses_model->get_expenses();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('expenses List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses.php',$data);
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
			$edit_expenses = $this->expenses_model->get_expenses_by_id($id);
			$data['edit_expenses'] = $edit_expenses;
			$inventories = $this->expenses_model->get_expenses();		
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit expenses Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function expenses_updated($id)
	{	
		$edit_expenses = $this->expenses_model->edit_expenses($id);
		// $data['msg'] = ucfirst('Data Updated Successfully'); 
		// $edit_expenses = $this->expenses_model->get_expenses_by_id($id);
		// $data['inventories'] = $edit_expenses;
		redirect('/expenses');
	}
	
	public function cat_edit($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$edit_expenses_cat = $this->expenses_model->get_expenses_cat_by_id($id);
			$data['edit_expenses_cat'] = $edit_expenses_cat;
			$inventories = $this->expenses_model->get_expenses_cat();	
			$data['inventories'] = $inventories;
			$data['title'] = ucfirst('Edit expenses Items'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_cat_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function expenses_cat_updated($id)
	{	
		$edit_expenses = $this->expenses_model->edit_expenses_cat($id);
		// $data['msg'] = ucfirst('Expenses Category Updated Successfully'); 
		// $edit_expenses = $this->expenses_model->get_expenses_cat_by_id($id);
		// $data['inventories'] = $edit_expenses;
		redirect('/expenses/category');
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
			$edit_expenses = $this->expenses_model->del_expenses($id);
			// $data['msg'] = ucfirst('Expenses Item Deleted Successfully'); 
			redirect('/expenses');
		}
	}
	
	public function cat_delete($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$edit_expenses = $this->expenses_model->del_expenses_cat($id);
			redirect('/expenses/category');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */