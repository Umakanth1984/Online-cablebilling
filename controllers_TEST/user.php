<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
	 
	function __construct()
	{ 
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->output->set_header('Access-Control-Allow-Origin: *');	
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
			$data['title'] = ucfirst('User');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('user.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function user_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$cnt = $this->user_model->user_email_exists($_REQUEST["inputEmail"],$_REQUEST["inputMobile"]);
			$existing_id=$cnt[0]['emp_id'];
			if ($existing_id > 0)
			{
				$data['emp_id']= $this->session->userdata('emp_id');
				$get_emp_id=$this->session->userdata('emp_id');
				$edit_user1 = $this->user_model->get_users_by_id($existing_id);
				$data['edit_user'] = $edit_user1;
				$edit_user_access = $this->user_model->get_users_access_id($existing_id,$get_emp_id);
				$data['edit_user_access'] = $edit_user_access;
				$data['user_exists'] = 1;
				$data['title'] = ucfirst('Edit User'); 
				$data['msg'] = ucfirst('<div style="color:RED;font-size:20px;text-align:center">Email / Mobile is already existed..</div>'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('edit_user.php',$data);
				$this->load->view('website_template/footer',$data);
			}
			else
			{
				$get_emp_id= $this->session->userdata('emp_id');
				$cnt = $this->user_model->save_user($REQUEST,$get_emp_id);
				if($cnt)
				{
				    $this->session->set_userdata('success_message', "Data Saved Successfully");
				    redirect("user");
				}
			}
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
			$get_emp_id=$this->session->userdata('emp_id');
			$data['title'] = ucfirst('Edit User');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$edit_user1 = $this->user_model->get_users_by_id($id,$get_emp_id);
			$data['edit_user'] = $edit_user1;
			$edit_user_access = $this->user_model->get_users_access_id($id,$get_emp_id);
			$data['edit_user_access'] = $edit_user_access;
			$this->load->view('website_template/header',$data);
			if($data['employee_info']['user_type']==9)
			{
			    $this->load->view('edit_lco.php',$data);
			}
			else
			{
			    $this->load->view('edit_user.php',$data);
			}
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function user_updated($id=NULL)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$get_emp_id= $this->session->userdata('emp_id');
			$edit_user2 = $this->user_model->edit_user($id,$get_emp_id,$_REQUEST);
			extract($edit_user2); //print_r($edit_user2); echo $edit_user2[0]['emp_id']; die;
			$existing_id=$edit_user2[0]['emp_id'];
			if($existing_id > 0){
				//print_r($edit_user2); echo $edit_user2[0]['emp_id']; die;
				$get_emp_id=$this->session->userdata('emp_id');
				$edit_user1 = $this->user_model->get_users_by_id($existing_id);
				$data['edit_user'] = $edit_user1;
				$edit_user_access = $this->user_model->get_users_access_id($existing_id,$get_emp_id);
				$data['edit_user_access'] = $edit_user_access;
				$data['user_exists'] = 1;
				$data['title'] = ucfirst('Edit User'); 
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Email / Mobile is Already Exists..</div>'); 
				$this->load->view('website_template/header',$data);
				$this->load->view('edit_user.php',$data);
				$this->load->view('website_template/footer',$data);
			}else{
				$get_emp_id=$this->session->userdata('emp_id');
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Data Updated Successfully</div>'); 
				// $edit_user = $this->user_model->get_users_by_id($id);
				// $data['user'] = $edit_user;
				// $edit_user_access = $this->user_model->get_users_access_id($id);
				// $data['edit_user_access'] = $edit_user_access;
				redirect('user/employees_list');
			}
		}
	}
	
	public function inactive_user($id)
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
			$inactive_user = $this->user_model->inactive_user_by_id($id,$get_emp_id);
			$data['title'] = ucfirst('Users List'); 
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">User Inactivated Successfully</div>'); 
			$users = $this->user_model->get_users();		
			$data['users'] = $users;
			$this->load->view('website_template/header',$data);
			$this->load->view('user_list.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function employees_list()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Employees List');
			$get_emp_id= $this->session->userdata('emp_id');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($get_emp_id,$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$users = $this->user_model->get_users($get_emp_id);
			$data['users'] = $users;
			$this->load->view('website_template/header',$data);
			$this->load->view('user_list.php',$data);
			$this->load->view('website_template/footer',$data);
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
			$view_user = $this->user_model->get_users_by_id($id,$get_emp_id);		
			$data['employee'] = $view_user;
			$data['title'] = ucfirst('View Employee Data'); 
			$this->load->view('website_template/header',$data);
			$this->load->view('view_user.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function emp_group($id)
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
			$data['title'] = ucfirst('Employee To Groups Assign');
			$this->load->model('customer_model');
			$data['employee_info'] = $this->customer_model->get_employee_info($get_emp_id,$data['adminId']);
			if($data['employee_info']==0)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$resCust=$this->db->query("SELECT admin_id FROM employes_reg WHERE emp_id='$id'")->row_array();
			if($resCust['admin_id']==$data['adminId'])
			{
				$data['assign_emp_id']=$id;
				$data['assign_admin_id']=$resCust['admin_id'];
			}
			else
			{
				$data['assign_emp_id']=$id;
				$data['assign_admin_id']=$resCust['admin_id'];
			}
			$emp_name = $this->user_model->get_users_by_id($id,$get_emp_id);		
			$data['emp_name'] = $emp_name;
			$this->load->view('website_template/header',$data);
			$this->load->view('emp_group.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function emp_group_save()
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
			$cnt = $this->user_model->emp_group_save($get_emp_id);
			$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Data Saved Successfully</div>'); 
			//$this->load->view('website_template/header',$data);
			//$this->load->view('user_list.php',$data);
			//$this->load->view('website_template/footer',$data);
			redirect('user/employees_list');
		}
	}
	
	public function emp_access($id)
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
			$resCust=mysql_fetch_assoc(mysql_query("SELECT user_type,admin_id FROM employes_reg WHERE emp_id='$id'"));
			$resCust2=mysql_fetch_assoc(mysql_query("SELECT user_type,admin_id FROM employes_reg WHERE emp_id='$get_emp_id'"));
			if(($resCust['admin_id']==$data['adminId']) || ($resCust2['user_type']==9))
			{
				$data['access_emp_id']=$id;
			}
			$data['title'] = ucfirst('Access Control'); 
			$emp_access_list = $this->user_model->get_users_access_id($id,$get_emp_id);		
			$data['emp_access_list'] = $emp_access_list;
			$this->load->view('website_template/header',$data);
			$this->load->view('accesscontrol.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function emp_access_edit()
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
			$cnt = $this->user_model->emp_access_edit($get_emp_id);
			// $data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Data Saved Successfully</div>'); 
			//$this->load->view('website_template/header',$data);
			//$this->load->view('user_list.php',$data);
			//$this->load->view('website_template/footer',$data);
			redirect('user/employees_list',$data);
		}
	}
	
	public function change_password($id)
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');	
			$cnt = $this->user_model->change_password($id);
			 //print_r($cnt); die; 
			if($cnt==0){
				$data['msg'] = ucfirst('<div style="color:RED;font-size:20px;text-align:center">Enter Correct OLD Password.. !!!</div>'); 
			}elseif($cnt==1){
				$data['msg'] = ucfirst('<div style="color:GREEN;font-size:20px;text-align:center">Password Changed Successfully</div>'); 
			}
				$this->load->view('website_template/header',$data);
				$this->load->view('change_password.php',$data);
				$this->load->view('website_template/footer',$data);
		}
	}
	
	public function reset_password($id)
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
			$cnt = $this->user_model->reset_password($id,$get_emp_id);
			$data['msg'] = ucfirst('<div style="color:RED;font-size:20px;text-align:center">Password reset has been done.. !!!</div>');
			$this->load->view('website_template/header',$data);
			$this->load->view('user_list.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function lco_save()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$cnt = $this->user_model->user_email_exists($_REQUEST["inputEmail"],$_REQUEST["inputMobile"]);
			$existing_id=$cnt[0]['emp_id'];
			if ($existing_id > 0)
			{
				$data['msg'] = ucfirst('<div style="color:RED;font-size:20px;text-align:center">Email / Mobile is already existed..</div>');
				$this->session->set_userdata('error_message', "Data Not Saved.!");
				$get_emp_id= $this->session->userdata('emp_id');
				$data['emp_id']= $this->session->userdata('emp_id');
				$this->load->view('website_template/header',$data);
				$this->load->view('user.php',$data);
				$this->load->view('website_template/footer',$data);
			}
			else
			{
				$get_emp_id= $this->session->userdata('emp_id');
				$lco = $this->user_model->save_lco($get_emp_id);
				$cnt = $this->user_model->save_user($REQUEST,$get_emp_id,$lco);
				if($lco)
				{
				    $packages = $this->user_model->save_operator_packages($lco);
				    $this->session->set_userdata('success_message', "Data Saved Successfully");
				    redirect("user");
				}
			}
		}
	}
	
	public function package_download()
	{
	    if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
		    $data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$admin_id = $_POST['id'];
			if($admin_id!='')
			{
			    $this->load->model("customer_model");
        		$results = $this->customer_model->get_operator_packages($admin_id);
        		$report_type = "Lco_Packages";
        		$filename = 'import/tmp/'.$report_type.'('.date('jS M Y').').csv';
        		$fp = fopen($filename, 'w');
        		//Headings
        		$temp = array("LCO Reg Email","Package ID","Package Name","Customer Price","LCO Price","Tax (%)","Hidden (0-Yes,1-No)");
        		fputcsv($fp, $temp);
        		$i = 1;
        		$admin_info = $this->db->query("select * from admin where admin_id='$admin_id'")->result_array();
        		foreach($results as $fields)
        		{
        			$temp = array();
        // 			$temp[] = $i++;
                    $temp[] = $admin_info[0]['email'];
        			$temp[] = $fields['package_id'];
        			$temp[] = $fields['package_name'];
        			$temp[] = $fields['cust_price'];
        			$temp[] = $fields['lco_price'];
        			$temp[] = $fields['pack_tax'];
        			$temp[] = $fields['op_status'];
        			fputcsv($fp, $temp);
        		}
        		fclose($fp);
        		$response = array();
        		$response['status'] = "success";
        		$response['file'] = $filename;
        		echo json_encode($response);
        		exit;
			}
			else
			{
			    $response = array();
        		$response['status'] = "failed";
        		$response['msg'] = "Parameter missing.";
        		echo json_encode($response);
        		exit;
			}
		}
	}
	
	public function credentials()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
		    redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Add Credential');
			$data['page_type'] = "Add";
			$this->load->model('customer_model');
			if(isset($_POST['submit']) && $_POST['submit']!='')
			{
			    $credential = $this->user_model->save_credentials($data['adminId']);
			    if($credential==true)
			    {
			        $this->session->set_userdata('success_message', "Credential Saved Successfully");
				    redirect("user/credentials");
			    }
			    else
			    {
			        $this->session->set_userdata('error_message', "Credential already exist.");
				    redirect("user/credentials");
			    }
			}
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0 || $data['employee_info']['user_type']!=9)
			{
			    redirect("/");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['credentials'] = $this->user_model->get_credentials($data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('credentials.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
	
	public function edit_credential()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
		    redirect('login');
		}
		else
		{
 			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Edit Credential');
			$data['page_type'] = "Edit";
			if($this->uri->segment(3)=="")
			{
			    $this->session->set_userdata('error_message', "Parameter is missing.");
				redirect("user/credentials");
			}
			else
			{
			    $id = $this->uri->segment(3);
			}
			$this->load->model('customer_model');
			if(isset($_POST['submit']) && $_POST['submit']!='')
			{
			    $credential = $this->user_model->update_credentials($data['adminId']);
			    if($credential==true)
			    {
			        $this->session->set_userdata('success_message', "Credential Updated Successfully");
				    redirect("user/credentials");
			    }
			    else
			    {
			        $this->session->set_userdata('error_message', "Credential already exist.");
				    redirect("user/credentials");
			    }
			}
			$data['employee_info'] = $this->customer_model->get_employee_info($data['emp_id'],$data['adminId']);
			if($data['employee_info']==0 || $data['employee_info']['user_type']!=9)
			{
			    redirect("/");
			}
			$data['data'] = $this->user_model->get_credentials_by_id($id,$data['adminId']);
			if($data['data']==false)
			{
			    $this->session->set_userdata('error_message', "Credential not exist.");
				redirect("user/credentials");
			}
			$data['emp_access'] = $this->customer_model->get_employee_access($data['emp_id'],$data['adminId']);
			$data['credentials'] = $this->user_model->get_credentials($data['adminId']);
			$this->load->view('website_template/header',$data);
			$this->load->view('credentials.php',$data);
			$this->load->view('website_template/footer',$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */