<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {

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
		$this->load->model('group_model');	
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
			$data['title'] = ucfirst('Groups');
			$get_emp_id=$this->session->userdata('emp_id');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$groups = $this->group_model->get_group($get_emp_id);
			$data['groups'] = $groups;
			$data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('groups.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function group_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$cnt = $this->group_model->save_group();
			redirect('/groups');
		}
	}
	
	public function groups_list()
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$group = $this->group_model->get_group($get_emp_id);		
			$data['group'] = $group	;
			$data['title'] = ucfirst('Groups List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('groups.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Edit Group');
			$get_emp_id=$this->session->userdata('emp_id');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$edit_group = $this->group_model->get_group_by_id($id,$data['emp_id']);
			$data['edit_group'] = $edit_group;
			if(count($edit_group)==0)
			{
				redirect('groups');
			}
			$groups = $this->group_model->get_group($get_emp_id);		
			$data['groups'] = $groups;
			$data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('groups_edit.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function group_updated($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id= $this->session->userdata('emp_id');
			$edit_group = $this->group_model->edit_group($id,$get_emp_id,$_REQUEST);
			// $data['msg'] = ucfirst('Data Updated Successfully');
			$this->session->set_userdata("success_message","Group updated successfully");
			redirect('groups');
		}
	}
	
	public function delete($id)
	{	
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id= $this->session->userdata('emp_id');
			$edit_group = $this->group_model->del_group($id,$get_emp_id);
			redirect('/groups');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */