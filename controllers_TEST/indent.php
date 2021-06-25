<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indent extends CI_Controller {

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
		$this->load->model('indent_model');	
	}
	public function index()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$indents = $this->indent_model->get();		
			$data['indents'] = $indents;	
			$data['title'] = ucfirst('indents'); 
			$this->load->view('website_template/header',$data);
			
			$this->load->view('indent.php',$data);
			
			$this->load->view('website_template/footer',$data); 
		}
	
	}
	public function indent_save()
	{
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			//  print_r($REQUEST); die;
			$cnt = $this->indent_model->save();
			$data['msg'] = ucfirst('Group Saved Successfully'); 
			redirect('/indent');
		}
	}
   public function groups_list()
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$indent = $this->indent_model->get();		
			$data['indent'] = $indent;
			$data['title'] = ucfirst('Indent List'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('indent.php',$data);
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
			$edit_indent = $this->indent_model->edit($id);
			$data['edit_indent'] = $edit_indent;
			$indents = $this->indent_model->get();		
			$data['indents'] = $indents;	
			$data['title'] = ucfirst('Edit indents'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('indent.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function indent_updated($id)
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$edit_indent = $this->indent_model->edit($id,$REQUEST);
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$edit_indent = $this->indent_model->get_by_id($id);
			$data['indent'] = $edit_indent;
			redirect('/indent');
		}
	}
	public function delete($id)
	{	
		if($this->session->userdata('emp_id')=='')
		{
			redirect('login');
		}else{ 
			$data['emp_id']= $this->session->userdata('emp_id');
			$edit_indent = $this->indent_model->del($id);
			$data['msg'] = ucfirst('Deleted Successfully'); 
			 
			redirect('/indent');
		}
	}
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */