<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mso extends CI_Controller {

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
		$this->load->model('mso_model');	
	}
	public function index()
	{
		
		 $data['title'] = ucfirst('MSO Details'); 
		$this->load->view('website_template/header',$data);
		$this->load->view('mso.php',$data);
		$this->load->view('website_template/footer',$data);
			
	}
	public function mso_save()
	{
      //print_r($REQUEST); die;
	   $cnt = $this->mso_model->save_create_mso($REQUEST);
		$data['msg'] = ucfirst('Data Saved Successfully'); 
		$this->load->view('website_template/header',$data);
         $this->load->view('mso.php',$data);
		$this->load->view('website_template/footer',$data);
            
	}
	public function edit($id)
	{	
		$edit_mso = $this->mso_model->get_mso_by_id($id);
		$data['edit_mso'] = $edit_mso;
		$data['title'] = ucfirst('Edit MSO'); 
		$this->load->view('website_template/header',$data);
		$this->load->view('edit_mso.php',$data);
		$this->load->view('website_template/footer',$data);
	}
	public function mso_updated($id)
	{	
		$edit_mso = $this->mso_model->edit_mso($id,$REQUEST);
		$data['msg'] = ucfirst('Data Updated Successfully'); 
		$edit_mso = $this->mso_model->get_mso_by_id($id);
		$data['mso'] = $edit_mso;
		redirect('mso/mso_list');
	}
      
   public function mso_list()
	{	
		$mso = $this->mso_model->get_create_mso();		
		$data['mso'] = $mso;
		$data['title'] = ucfirst('Mso List'); 
		$this->load->view('website_template/header',$data);
		$this->load->view('mso_list.php',$data);
		$this->load->view('website_template/footer',$data);
		
	}
	public function view($id)
	{	
		$view_mso = $this->mso_model->get_mso_by_id($id);		
		$data['mso'] = $view_mso;
		$data['title'] = ucfirst('View Mso Data'); 
		$this->load->view('website_template/header',$data);
		$this->load->view('view_mso.php',$data);
		$this->load->view('website_template/footer',$data);
		
	}  
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */