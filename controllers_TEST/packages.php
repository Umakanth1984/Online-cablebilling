<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends CI_Controller {

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
		$this->load->model('packages_model');	
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
				$data['title'] = ucfirst('Packages');
				// $data['payChannels'] = $this->packages_model->get_pay_channels();
				// $data['ftaChannels'] = $this->packages_model->get_fta_channels();
			 //   $data['bouquets'] = $this->packages_model->get_bouquets();
				$this->load->view('website_template/header',$data);
				$this->load->view('packages.php',$data);
				$this->load->view('website_template/footer',$data);
		}
	}
	
	public function packages_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Package Saved');
			$cnt = $this->packages_model->save_packages();
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Package Saved Successfully ..</div>');
			$this->load->view('website_template/header',$data);
            $this->load->view('packages.php',$data);
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
			$data['title'] = ucfirst('Edit Package');
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id=$this->session->userdata('emp_id');
			if($this->uri->segment(3)=="")
			{
			    $this->session->set_userdata('error_message', "Parameter is missing.");
				redirect("packages/packages_list");
			}
			else
			{
			    $id = $this->uri->segment(3);
			}
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			if($data['employee_info']['user_type']!=9)
			{
			    if(isset($_POST['updatePackage']) && $_POST['updatePackage']!='')
			    {
			        $update = $this->packages_model->update_package($id);
			        if($update==true)
			        {
			            $this->session->set_userdata('success_message', "Package updated.");
    				    redirect("packages/packages_list");
			        }
			        else
			        {
			            $this->session->set_userdata('error_message', "Package not updated.");
    				    redirect("packages/packages_list");
			        }
			    }
    			$data['data'] = $this->packages_model->get_operator_package_by_id($id,$data['adminId']);
    			if($data['data']==0)
    			{
    			    $this->session->set_userdata('error_message', "Package not exist.");
    				redirect("packages/packages_list");
    			}
    			$this->load->view('website_template/header',$data);
    			$this->load->view('edit_lco_package.php',$data);
    			$this->load->view('website_template/footer',$data);
			}
			else
			{
    			$edit_packages = $this->packages_model->get_packages_by_id($id,$get_emp_id);
    			$data['edit_packages'] = $edit_packages;
    			$data['payChannels'] = $this->packages_model->get_pay_channels();
    			$data['ftaChannels'] = $this->packages_model->get_fta_channels();
    			$data['bouquets'] = $this->packages_model->get_bouquets();
    			$this->load->view('website_template/header',$data);
    			$this->load->view('edit_packages.php',$data);
    			$this->load->view('website_template/footer',$data);
			}
		}
	}
	
	public function packages_updated($id)
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
			$edit_packages = $this->packages_model->edit_packages($id,$_REQUEST,$get_emp_id);
			// $data['msg'] = ucfirst('Data Updated Successfully'); 
			// $edit_packages = $this->packages_model->get_packages_by_id($id);
			// $data['packages'] = $edit_packages;
			redirect('packages/packages_list');
		}
	}

	public function packages_list()
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
			$data['title'] = ucfirst('Packages List');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    $this->session->set_userdata('error_message', "Access Denied.");
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			if($data['employee_info']['user_type']!=9)
			{
			    $data['packages'] = $this->packages_model->get_operator_packages($data['adminId']);
    			$this->load->view('website_template/header',$data);
    			$this->load->view('lco_packages_list.php',$data);
    			$this->load->view('website_template/footer',$data);
			}
			else
			{
			    $this->load->model("group_model");
                $data['lco_list'] = $this->group_model->get_lco_list($data['emp_id'],$data['adminId']);
    			$packages = $this->packages_model->get_packages($get_emp_id);
    			$data['packages'] = $packages;
    			$this->load->view('website_template/header',$data);
    			$this->load->view('packages_list.php',$data);
    			$this->load->view('website_template/footer',$data);
			}
		}
	}
	
	public function view($id)
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
			$view_packages = $this->packages_model->get_packages_by_id($id,$get_emp_id);		
			$data['packages'] = $view_packages;
			$data['title'] = ucfirst('View Package Details'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('view_packages.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}  
	
	public function group_packages()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$groups = $this->group_model->get_group_packages();		
			$data['groups'] = $groups;
			$this->load->view('website_template/header',$data);
			$this->load->view('package_group.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function group_packages_updated()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$cnt = $this->packages_model->group_packages();
			redirect('/packages/group_packages');
			// return 1;
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
			$edit_group = $this->packages_model->del_package($id,$get_emp_id);
			$data['msg'] = ucfirst('Package Deleted Successfully');
			redirect('packages/packages_list');
		}
	}
	
	public function package_cat()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('MSO Preferences'); 
			$emplist = $this->packages_model->get_package_cat();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('package_cat.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function save_package_cat()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$mso_save=$this->packages_model->save_package_cat();
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">package categeory Saved Successfully..</div>'); 
			$data['title'] = ucfirst('package categeory');
			$emplist = $this->packages_model->get_package_cat();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('package_cat.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_package_cat($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Edit package categeory');
			$edit = $this->packages_model->edit_package_cat($id);
			$data['edit'] = $edit;
			$emplist = $this->packages_model->get_package_cat();
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('edit_package_cat.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function update_package_cat($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
		else{ 
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$update_package_cat=$this->packages_model->update_package_cat($id);
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">package categeory Updated Successfully..</div>'); 
			$data['title'] = ucfirst('package categeory');
			$emplist = $this->packages_model->get_package_cat();		
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			//$this->load->view('package_cat.php',$data);
			$this->load->view('edit_package_cat.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function delete_package_cat($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$emplist = $this->packages_model->delete_package_cat($id);
			$data['msg'] = ucfirst('<div style="color:RED;font-size:20px;text-align:center">package categeory Deleted Successfully..</div>');
			$data['title'] = ucfirst('package categeory'); 
			$emplist = $this->packages_model->get_package_cat();
			$data['emplist'] = $emplist;
			$this->load->view('website_template/header',$data);
			$this->load->view('package_cat.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function alacarte_req()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id'); 
			$emplist = $this->packages_model->get_alacarte_req();
			$data['title'] = ucfirst('');
			$data['emplist'] = $emplist;
			//$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">alacarte Saved Successfully ..</div>');
			$this->load->view('website_template/header',$data);
            $this->load->view('alacarte_req.php',$data);
			$this->load->view('website_template/footer',$data);
		} 
	}
	
	public function pay_channels()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
		    redirect('login');
		}
		else
		{
    		$data['emp_id']= $this->session->userdata('emp_id');
    		$data['admin_id']= $this->session->userdata('admin_id');
    		$data['title'] = ucfirst('Ala-carte Pay Channels');
			$data['data'] = array("ala_ch_name"=>"","ala_ch_price"=>"","ala_ch_category"=>"");
			$data['package_cat'] = $this->packages_model->get_package_cat();
    		$data['payChannels'] = $this->packages_model->get_pay_channels_info();
			if(isset($_POST['submit']) && $_POST['submit']!='')
			{
				$savePayChannel = $this->packages_model->save_pay_channel();
				if($savePayChannel==1)
				{
					redirect('packages/pay_channels?msg=Pay Channel Added Successfully&type=1');
				}
				elseif($savePayChannel==0)
				{
					redirect('packages/pay_channels?msg=Already Pay Channel Exists&type=2');
				}
			}
    		$this->load->view('website_template/header',$data);
    		$this->load->view('pay_channels.php',$data);
    		$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_pay_channel($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
		    redirect('login');
		}
		else
		{
    		$data['emp_id']= $this->session->userdata('emp_id');
    		$data['admin_id']= $this->session->userdata('admin_id'); 
    		$data['title'] = ucfirst('Ala-carte Pay Channels');
			$data['data'] = $this->packages_model->get_pay_channel_info($id);
			$data['data']['action'] = "Edit";
			$data['package_cat'] = $this->packages_model->get_package_cat();
    		$data['payChannels'] = $this->packages_model->get_pay_channels_info();
			if(isset($_POST['submit']) && $_POST['submit']!='')
			{
				$savePayChannel = $this->packages_model->update_pay_channel();
				if($savePayChannel==1)
				{
					redirect('packages/pay_channels?msg=Pay Channel Updated Successfully&type=1');
				}
				elseif($savePayChannel==0)
				{
					redirect('packages/pay_channels?msg=Already Pay Channel Exists&type=2');
				}
			}
    		$this->load->view('website_template/header',$data);
    		$this->load->view('pay_channels.php',$data);
    		$this->load->view('website_template/footer',$data);
		}
	}
	
	public function delete_pay_channel($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['admin_id']= $this->session->userdata('admin_id');
			$payChannelDelete = $this->packages_model->delete_pay_channel($id);
			if($payChannelDelete==1)
			{
				redirect('packages/pay_channels?msg=Pay Channel Deleted Successfully&type=1');
			}
			elseif($payChannelDelete==0)
			{
				redirect('packages/pay_channels?msg=Pay Channel Not Exists&type=2');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */