<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preferences extends CI_Controller {

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
		$this->load->model('preferences_model');	
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
			$data['title'] = ucfirst('Common Preferences'); 
			//$this->preferences_model->save_common();	
			$get_common=$this->preferences_model->get_common();
			$data['get_common']=$get_common;
			$this->load->view('website_template/header',$data);
			$this->load->view('common_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_common_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Common Preferences');
			$this->preferences_model->save_common();	
			$get_common=$this->preferences_model->get_common();	
			$data['get_common']=$get_common;
			$data['title'] = ucfirst('SMS Preferences'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('common_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function sms_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$get_sms=$this->preferences_model->get($get_emp_id);	
			$data['get_sms']=$get_sms;
			$data['title'] = ucfirst('SMS Preferences'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('sms_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_sms_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			$this->preferences_model->save_sms($get_emp_id);
			$get_sms=$this->preferences_model->get($get_emp_id);	
			$data['get_sms']=$get_sms;
			$data['title'] = ucfirst('SMS Preferences'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('sms_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function dealer_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Dealer Preferences');
			$dealerlist = $this->preferences_model->get_dealer_prefer();		
			$data['dealerlist'] = $dealerlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_dealer_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Edit Dealer Preferences');
			$dealerlist = $this->preferences_model->get_dealer_prefer();		
			$data['dealerlist'] = $dealerlist;
			$dealer = $this->preferences_model->get_dealer_prefer_by_id($id);		
			$data['dealer'] = $dealer;
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_dealer_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}

	public function save_dealer_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Dealer Preferences'); 
			$data['msg'] = ucfirst('Data Saved Successfully'); 
			$this->preferences_model->save_dealerprefer($_REQUEST);
			$dealerlist = $this->preferences_model->get_dealer_prefer();		
			$data['dealerlist'] = $dealerlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}

	public function update_dealer_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Dealer Preferences'); 
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$this->preferences_model->update_dealerprefer($_REQUEST);
			$dealerlist = $this->preferences_model->get_dealer_prefer();		
			$data['dealerlist'] = $dealerlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}

	public function delete_dealer_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Dealer Preferences');
			$data['msg'] = ucfirst('Data Deleted Successfully'); 
			$this->preferences_model->delete_dealerprefer($id);
			$dealerlist = $this->preferences_model->get_dealer_prefer();		
			$data['dealerlist'] = $dealerlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('dealer_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function payment_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Payment Gateway Preferences'); 
			//$this->preferences_model->save_paymentgateway();
			$paymentlist = $this->preferences_model->get_payment_prefer();		
			$data['paymentlist'] = $paymentlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('payment_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_payment_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$data['title'] = ucfirst('Payment Gateway Preferences'); 
			$this->preferences_model->save_paymentgateway();
			$paymentlist = $this->preferences_model->get_payment_prefer();		
			$data['paymentlist'] = $paymentlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('payment_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function complaint_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			//$this->preferences_model->save_complaint($_REQUEST);
			//$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Complaint Preferences'); 
			$complaintlist = $this->preferences_model->get_complaint_prefer();		
			$data['complaintlist'] = $complaintlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('complaint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function node_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			//$this->preferences_model->save_complaint($_REQUEST);
			//$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Nodepoint Preferences'); 
			$nodepoint = $this->preferences_model->get_node_prefer();		
			$data['nodepoint'] = $nodepoint;
			$this->load->view('website_template/header',$data);
			$this->load->view('nodepoint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function save_node_prefer()
	{
		
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$this->preferences_model->save_node();
			//$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Nodepoint Preferences');
			$nodepointlist = $this->preferences_model->get_node_prefer();		
			$data['nodepointlist'] = $nodepointlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('nodepoint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function update_node_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
		 $this->preferences_model->update_node();
			//$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('nodepoint Preferences');
			$nodepointlist = $this->preferences_model->get_node_prefer();		
			$data['nodepointlist'] = $nodepointlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('nodepoint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function delete_node_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			 $data['emp_id']= $this->session->userdata('emp_id');
			 $data['adminId']= $this->session->userdata('admin_id');
			$nodepointlist = $this->preferences_model->delete_node_prefer($id);
			$data['msg'] = ucfirst('Data Deleted Successfully');
			$data['title'] = ucfirst('nodepoint Preferences'); 
			$nodepointlist = $this->preferences_model->get_node_prefer();		
			$data['nodepointlist'] = $nodepointlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('nodepoint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function edit_node_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id'); 
			$data['title'] = ucfirst('Edit nodepoint Preferences'); 
			$edit = $this->preferences_model->update_node($id);
			$data['edit'] = $edit;
			$nodepointlist = $this->preferences_model->edit_node_prefer($id);			
			$data['editeednodepointlist'] = $nodepointlist;
			$nodepointlist1 = $this->preferences_model->get_node_prefer();			
			$data['nodepointlist'] = $nodepointlist1;
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_node_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function save_complaint_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$this->preferences_model->save_complaint();
			$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Complaint Preferences');
			$complaintlist = $this->preferences_model->get_complaint_prefer();		
			$data['complaintlist'] = $complaintlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('complaint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function update_complaint_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$this->preferences_model->update_complaint();
			$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Complaint Preferences');
			$complaintlist = $this->preferences_model->get_complaint_prefer();		
			$data['complaintlist'] = $complaintlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('complaint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	public function emp_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			//$this->preferences_model->save_complaint($_REQUEST);
			//$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Employee Preferences'); 
			$emplist = $this->preferences_model->get_emp_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_emp_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$this->preferences_model->save_emp();
			$data['msg'] = ucfirst('Data Saved Successfully'); 
			$data['title'] = ucfirst('Employee Preferences');
			$emplist = $this->preferences_model->get_emp_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
		
	public function delete_complaint_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$emplist = $this->preferences_model->delete_complaint_prefer($id);
			$data['msg'] = ucfirst('Data Deleted Successfully');
			$data['title'] = ucfirst('Complaint Preferences'); 
			$complaintlist = $this->preferences_model->get_complaint_prefer();		
			$data['complaintlist'] = $complaintlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('complaint_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_complaint_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			// $emplist = $this->preferences_model->delete_complaint_prefer($id);
			// $data['msg'] = ucfirst('Data Deleted Successfully');
			$data['title'] = ucfirst('Edit Complaint Preferences'); 
			$edit = $this->preferences_model->edit_complaint_prefer($id);
			$data['edit'] = $edit;
			$complaintlist = $this->preferences_model->get_complaint_prefer();			
			$data['complaintlist'] = $complaintlist;
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_node_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function delete_emp_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$emplist = $this->preferences_model->delete_emp_prefer($id);
			$data['msg'] = ucfirst('Data Deleted Successfully');
			$data['title'] = ucfirst('Employee Preferences'); 
			$emplist = $this->preferences_model->get_emp_prefer();
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_emp_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Edit Employee Preferences');
			$edit = $this->preferences_model->edit_emp_prefer($id);
			$data['edit'] = $edit;
			$emplist = $this->preferences_model->get_emp_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_emp_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function update_emp_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$this->preferences_model->update_emp();
			$data['msg'] = ucfirst('Data Updated Successfully'); 
			$data['title'] = ucfirst('Employee Preferences');
			$emplist = $this->preferences_model->get_emp_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function mso_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('MSO Preferences'); 
			$emplist = $this->preferences_model->get_mso_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('mso_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_mso_prefer()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$mso_save=$this->preferences_model->save_mso();
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">MSO Saved Successfully..</div>'); 
			$data['title'] = ucfirst('MSO Preferences');
			$emplist = $this->preferences_model->get_mso_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('mso_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_mso_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Edit MSO Preferences');
			$edit = $this->preferences_model->edit_mso_prefer($id);
			$data['edit'] = $edit;
			$emplist = $this->preferences_model->get_mso_prefer();
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_mso_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function update_mso_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$update_mso=$this->preferences_model->update_mso($id);
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">MSO Updated Successfully..</div>'); 
			$data['title'] = ucfirst('MSO Preferences');
			$emplist = $this->preferences_model->get_mso_prefer();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('mso_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function delete_mso_prefer($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$emplist = $this->preferences_model->delete_mso_prefer($id);
			$data['msg'] = ucfirst('<div style="color:RED;font-size:20px;text-align:center">MSO Deleted Successfully..</div>');
			$data['title'] = ucfirst('MSO Preferences'); 
			$emplist = $this->preferences_model->get_mso_prefer();
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('mso_preferences.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */