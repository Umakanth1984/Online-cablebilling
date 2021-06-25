<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 1000);
ini_set('memory_limit', '1024M');
class Dashboard extends CI_Controller {

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
		$this->load->library('pagination');
		$this->load->model('Dashboard_model');
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
			$data['title'] = ucfirst('Customer Requests');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
			    $data['user_type'] = 9;
			}
			$results = $this->Dashboard_model->lco_franchise_list();
    		$data['lco_list'] = $results;
    		$data['bouquet_list'] = $this->Dashboard_model->get_bouquet_list();
    		//pagination settings
			$config['base_url'] = base_url().'dashboard/index';
// 			$config['total_rows'] = $this->db->count_all('alacarte_request');
            $config['total_rows'] = $this->db->query("select ar.alacarte_req_id from alacarte_request ar left join customers c ON ar.cust_id=c.cust_id left join set_top_boxes s ON s.cust_id=c.cust_id where 1 AND ar.sms_status=0 AND ar.status IS NULL AND (ar.ala_ch_id!='' OR ar.pack_id!='') group by s.stb_id")->num_rows();
			$config['per_page'] = "500";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$customer_requets = $this->Dashboard_model->get_customer_requets($config["per_page"], $data['page']);
// 			print_r($customer_requets);exit;
			$data['customer_requets'] = array();
			foreach($customer_requets as $key => $creq)
			{
			    $data['customer_requets'][$key]['alacarte_req_id'] = $creq['alacarte_req_id'];
			    $data['customer_requets'][$key]['cust_id'] = $creq['cust_id'];
			    $data['customer_requets'][$key]['first_name'] = $creq['first_name'];
			    $data['customer_requets'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
			    $data['customer_requets'][$key]['mobile_no'] = $creq['mobile_no'];
			    $data['customer_requets'][$key]['addr1'] = $creq['addr1'];
			    $data['customer_requets'][$key]['stb_id'] = $creq['stb_id'];
			    $data['customer_requets'][$key]['stb_no'] = $creq['stb_no'];
			    $data['customer_requets'][$key]['mac_id'] = $creq['mac_id'];
			    $data['customer_requets'][$key]['group_id'] = $creq['group_id'];
			    $data['customer_requets'][$key]['card_no'] = $creq['card_no'];
			    $data['customer_requets'][$key]['basePackage'] = $creq['basePackage'];
			    $data['customer_requets'][$key]['basePackagePrice'] = $creq['basePackagePrice'];
			    $data['customer_requets'][$key]['empName'] = $creq['empName'];
			    $customer_ala_req = $this->Dashboard_model->get_customer_alacarte_req($creq['cust_id'],$creq['stb_id']);
			    foreach($customer_ala_req as $key2 => $c2)
			    {
			        $data['customer_requets'][$key]['alacarte'][]= $c2['ala_ch_name'];
			    }
			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_req($creq['cust_id'],$creq['stb_id']);
			    foreach($customer_bouquet_req as $key3 => $c3)
			    {
			        $data['customer_requets'][$key]['bouquet'][]= $c3['package_name'];
			    }
			}
			if(isset($_POST['bulkApprove']) && $_POST['bulkApprove']!='')
			{
			    foreach($_POST['checkId'] as $key4 => $chkbox)
			    {
			        $st=1;
			        $customer_ala_temp_status = $this->Dashboard_model->update_customer_ala_req($chkbox,$_POST['cId'][$key4],$_POST['sId'][$key4],$st);
			    }
			    redirect('dashboard?msg=success');
			}
			//echo "<pre>";
			//print_r($data['customer_requets']);exit;
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_bq_ala_req.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function bq_ala_req()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Customer Requests');
			$id1 = $this->uri->segment(3);
			$id2 = $this->uri->segment(4);
			if($id1=='' || $id2=='')
			{
			    redirect('dashboard');
			}
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type==0)
			{
			    redirect('dashboard');
			}
			$customer_requets_pending = $this->Dashboard_model->get_customer_requets_pending($id1,$id2);
			$data['customer_requets'] = array();
			foreach($customer_requets_pending as $key => $creq)
			{
			    $data['customer_requets'][$key]['alacarte_req_id'] = $creq['alacarte_req_id'];
			    $data['customer_requets'][$key]['cust_id'] = $creq['cust_id'];
			    $data['customer_requets'][$key]['first_name'] = $creq['first_name'];
			    $data['customer_requets'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
			    $data['customer_requets'][$key]['mobile_no'] = $creq['mobile_no'];
			    $data['customer_requets'][$key]['addr1'] = $creq['addr1'];
			    $data['customer_requets'][$key]['stb_id'] = $creq['stb_id'];
			    $data['customer_requets'][$key]['cust_balance'] = $creq['cust_balance'];
			    $data['customer_requets'][$key]['pending_amount'] = $creq['pending_amount'];
			    $data['customer_requets'][$key]['stb_no'] = $creq['stb_no'];
			    $data['customer_requets'][$key]['mac_id'] = $creq['mac_id'];
			    $data['customer_requets'][$key]['card_no'] = $creq['card_no'];
			    $customer_ala_req = $this->Dashboard_model->get_customer_alacarte_req_pending($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
			    foreach($customer_ala_req as $key2 => $c2)
			    {
			        $data['customer_requets'][$key]['alacarte'][]= $c2;
			    }
			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_req_pending($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
			    foreach($customer_bouquet_req as $key3 => $c3)
			    {
			        $data['customer_requets'][$key]['bouquet'][]= $c3;
			    }
			}
			if(count($data['customer_requets'])==0)
		    {
		        redirect('dashboard');
		    }
			$lcoInfo = $this->Dashboard_model->get_lco_info($id1);
			$data['lcoInfo'] = $this->Dashboard_model->get_admin_info($lcoInfo['admin_id']);
// 			echo "<pre>";
// 			print_r($data['customer_requets']);exit;
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_bq_ala_approve.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function addToStb()
	{
		$cust_id = $this->input->post('id1');
		$stb_id = $this->input->post('id2');
		$req_id = $this->input->post('id3');
		$data['last_id'] = $this->Dashboard_model->add_to_stb($cust_id,$stb_id,$req_id);
		echo json_encode($data['last_id']);
	}
	
	public function add_lco_credits()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Add Credits to LCO');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type==0)
			{
			    redirect('/');
			}
			if(isset($_POST['lcoCredits']) && $_POST['lcoCredits']!='')
    		{
    			$d=array();
    			$d['admin_id'] = $_POST['lco'];
    			$d['amount'] = $_POST['amount'];
    			$d['remarks'] = $_POST['remarks'];
    			$flag = $this->Dashboard_model->add_lco_credits($d);
    			if($flag==true)
    			{
					$this->session->set_userdata('success_message', "Amount added to Wallet Successfully");
    			    redirect("/", 'location');
    			}
    			else
    			{
					$this->session->set_userdata('error_message', "Amount not added.");
    			    redirect("/", 'location');
    			}
    		}
			$results = $this->Dashboard_model->lco_franchise_list();
    		$data['values'] = $results;
			$this->load->view('website_template/header',$data);
			$this->load->view('add_lco_credits.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function get_ajax_lco_data(){
		$program_id = $this->input->post('program_id');
		$data['last_id'] = $this->Dashboard_model->get_ajax_lco_data($program_id);
		echo json_encode($data['last_id']);
	}
	
	public function removeFromStb(){
		$cust_id = $this->input->post('id1');
		$stb_id = $this->input->post('id2');
		$req_id = $this->input->post('id3');
		$data['last_id'] = $this->Dashboard_model->remove_from_stb($cust_id,$stb_id,$req_id);
		echo json_encode($data['last_id']);
	}
	
	public function addToStb2(){
		$data['cust_id'] = $this->input->post('id1');
		$data['stb_id'] = $this->input->post('id2');
		$data['req_id'] = $this->input->post('id3');
		$data['action'] = $this->input->post('action');
		$data['PackInfo'] = $this->Dashboard_model->get_request_info($data['req_id']);
		$data['CustInfo'] = $this->Dashboard_model->get_customer_info($data['cust_id'],$data['stb_id']);
// 		print_r($data);exit;
		$data['last_id'] = $this->load->view('stb_request_save.php',$data);
	}
	
	public function removeFromStbSMS(){
		$data['cust_id'] = $this->input->post('id2');
		$data['stb_id'] = $this->input->post('id3');
		$data['req_id'] = $this->input->post('id4');
		$data['action'] = $this->input->post('action');
		$data['PackInfo'] = $this->Dashboard_model->get_request_remove_info($data['cust_id'],$data['stb_id'],$data['req_id']);
		$data['CustInfo'] = $this->Dashboard_model->get_customer_info($data['cust_id'],$data['stb_id']);
		$data['last_id'] = $this->load->view('stb_request_save.php',$data);
	}
	
	public function requests_in_que()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Requests in Que');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type!=0)
			{
			    $data['user_type'] = 9;
			}
			$results = $this->Dashboard_model->lco_franchise_list();
    		$data['lco_list'] = $results;
    		//pagination settings
			$config['base_url'] = base_url().'dashboard/requests_in_que';
			$config['total_rows'] = $this->db->count_all('before_expiries');
			$config['per_page'] = "300";
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"]/$config["per_page"];
			$config["num_links"] = floor($choice);

			// integrate bootstrap pagination
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '«';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '»';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);

			$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['pagination'] = $this->pagination->create_links();
			$customer_requets = $this->Dashboard_model->get_customer_requets_temp_approved($config["per_page"], $data['page']);
			$data['customer_requets'] = array();
			foreach($customer_requets as $key => $creq)
			{
			    $data['customer_requets'][$key]['cust_id'] = $creq['cust_id'];
			    $data['customer_requets'][$key]['first_name'] = $creq['first_name'];
			    $data['customer_requets'][$key]['custom_customer_no'] = $creq['custom_customer_no'];
			    $data['customer_requets'][$key]['mobile_no'] = $creq['mobile_no'];
			    $data['customer_requets'][$key]['addr1'] = $creq['addr1'];
			    $data['customer_requets'][$key]['stb_no'] = $creq['stb_no'];
			    $data['customer_requets'][$key]['group_id'] = $creq['group_id'];
			    $data['customer_requets'][$key]['cust_end_date'] = $creq['cust_end_date'];
			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_before_req($creq['cust_id']);
			    foreach($customer_bouquet_req as $key3 => $c3)
			    {
			        $data['customer_requets'][$key]['bouquet'][]= $c3['package_name'];
			    }
			}
			$this->load->view('website_template/header',$data);
			$this->load->view('customer_ala_temp_req.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
	
	public function check_import()
	{
		$data['import_status']=$this->Dashboard_model->check_import();
		echo json_encode($data['import_status']);
	}
	
	public function batch_approve()
	{
		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Batchwise Bulk Approve');
			$check_emp_type = $this->Dashboard_model->check_emp_type($data['emp_id']);
			if($check_emp_type==0)
			{
			    redirect('dashboard');
			}
			if(isset($_POST['uploadBatch']) && $_POST['uploadBatch']!=''){
    			$flag=$this->Dashboard_model->save_batch_import_new();
    			if($flag > 0){
    				$this->session->set_userdata('success_message', $flag." Requests uploaded Successfully!!");
    				redirect("dashboard/batch_approve?msg=", 'location');
    			}
    		}
			$lcoInfo = $this->Dashboard_model->get_lco_info($id1);
			$data['lcoInfo'] = $this->Dashboard_model->get_admin_info($lcoInfo['admin_id']);
			$this->load->view('website_template/header',$data);
			$this->load->view('batchwise_bq_ala_approve.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */