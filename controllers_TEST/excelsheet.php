<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/third_party/PHPExcel.php";
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 1200);
class Excelsheet extends CI_Controller {
    public function __construct() {
        parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('reports_model');
		$this->load->model('excelsheet_model');
		$this->load->library('excel');
		$this->load->database();
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
				$data['title'] = ucfirst('Customers Reports');
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Customers list');
				if($_REQUEST['report_type']=='none'){$name="All_";}
				if($_REQUEST['report_type']==0){$name="Paid_";}
				if($_REQUEST['report_type']==1){$name="UnPaid_";}
				if($_REQUEST['report_type']==2){$name="Adv_Paid_";}
				if($_REQUEST['report_type']==3){$name="Active_";}
				if($_REQUEST['report_type']==4){$name="InActive_";}
				$filename=$name.'Customers_'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','First Name','Address','Mobile Number','Group Name','Status','Amt Paid','Current Due');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12);
				$rowCount++;
			
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$customers = $this->excelsheet_model->get_customers();
				//print_r($users); die;
					$rowCount = 2;$s_no=1;
				//while($value=mysql_fetch_assoc($users)){
					foreach($customers as $key => $users ){
					$cust_id=$users['cust_id'];
					$paymentQry=mysql_query("select * from payments where customer_id='$cust_id'");
					$paymentRes=mysql_fetch_assoc($paymentQry);

					$grp_ID=$users['group_id'];
					$group_qry=mysql_query("select * from groups where group_id='$grp_ID'");
					$group_res=mysql_fetch_assoc($group_qry);
					
					if($users['status']==1){ $status="Active";}else{ $status="Inactive";}
					
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $users['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $group_res['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $paymentRes['amount_paid']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $users['pending_amount']);
					$s_no++;
					$rowCount++;
					}

        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
				$this->load->view('website_template/header',$data);
				$this->load->view('customer_reports.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function paid()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{
			    ini_set("display_errors",1);
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Paid Customers Reports'); 

				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				$sheet = $this->excel->getActiveSheet();
				//name the worksheet
				$sheet->setTitle('Paid Customers list');
				$filename='Paid_Customers_'.date("Ymd").'.csv'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','Customer Name','Address','Mobile Number','MAC ID','VC No','Group Name','Status','Prev.M.Pending','Cur.M.Billing','Cur.M.Coltbl','Cur.M.Coll','Amt.Pending');
				
				$sheet->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$sheet->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$sheet->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$sheet->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$sheet->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$sheet->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$sheet->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$sheet->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$sheet->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$sheet->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$sheet->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$sheet->setCellValueExplicit('L'.$rowCount, $customTitle[11]);
				$sheet->setCellValueExplicit('M'.$rowCount, $customTitle[12]);
				$sheet->setCellValueExplicit('N'.$rowCount, $customTitle[13]);

				$sheet->getStyle('A1')->getFont()->setSize(12);
				$sheet->getStyle('B1')->getFont()->setSize(12);
				$sheet->getStyle('C1')->getFont()->setSize(12);
				$sheet->getStyle('D1')->getFont()->setSize(12);
				$sheet->getStyle('E1')->getFont()->setSize(12);
				$sheet->getStyle('F1')->getFont()->setSize(12);
				$sheet->getStyle('G1')->getFont()->setSize(12);
				$sheet->getStyle('H1')->getFont()->setSize(12);
				$sheet->getStyle('I1')->getFont()->setSize(12);
				$sheet->getStyle('J1')->getFont()->setSize(12);
				$sheet->getStyle('K1')->getFont()->setSize(12);
				$sheet->getStyle('L1')->getFont()->setSize(12);
				$sheet->getStyle('M1')->getFont()->setSize(12);
				$sheet->getStyle('N1')->getFont()->setSize(12);
				$rowCount++;

				// get all users in array formate
				$customers = $this->excelsheet_model->get_paid_customers();
					$rowCount = 2;$s_no=1;
				//while($value=mysql_fetch_assoc($users)){
				foreach($customers as $key => $users ){
					if($users['status']==1){ $status="Active";}else{ $status="Inactive";}
					$sheet->setCellValueExplicit('A'.$rowCount, $s_no);
					$sheet->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$sheet->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$sheet->setCellValueExplicit('D'.$rowCount, $users['addr1']." ".$users['addr2']);
					$sheet->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$sheet->setCellValueExplicit('F'.$rowCount, $users['mac_id']);
					$sheet->setCellValueExplicit('G'.$rowCount, $users['stb_no']);
					$sheet->setCellValueExplicit('H'.$rowCount, $users['group_name']);
					$sheet->setCellValueExplicit('I'.$rowCount, $status);
					$sheet->setCellValueExplicit('J'.$rowCount, $users['tot_pre_due']);
					$sheet->setCellValueExplicit('K'.$rowCount, $users['monthly_bill']);
					$sheet->setCellValueExplicit('L'.$rowCount, $users['total_outstaning']);
					$sheet->setCellValueExplicit('M'.$rowCount, $users['amount_paid']);
					$sheet->setCellValueExplicit('N'.$rowCount, $users['pending_amount']);
					$s_no++;
					$rowCount++;
				}
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
				$this->load->view('website_template/header',$data);
				$this->load->view('paid_customers.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}
	
	public function unpaid()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Unpaid Customers Reports'); 
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Unpaid Customers list');
				$filename='Unpaid_Customers_'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','Customer Name','Address','Mobile Number','MAC ID','VC No','Group Name','Status','Prev.M.Pending','Cur.M.Billing','Cur.M.Coltbl','Cur.M.Coll','Amt.Pending');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);
				$this->excel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $customTitle[12]);
				$this->excel->getActiveSheet()->setCellValueExplicit('N'.$rowCount, $customTitle[13]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('M1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('N1')->getFont()->setSize(12);
				$rowCount++;
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$customers = $this->excelsheet_model->get_unpaid_customers();
					$rowCount = 2;$s_no=1;
				//while($value=mysql_fetch_assoc($users)){
				foreach($customers as $key => $users ){
					$month=date("Y-m-00 00:00:00");
					$cust_id=$users['cust_id'];
					$paymentQry=mysql_query("select SUM(amount_paid) as tot_paid from payments where customer_id='$cust_id' AND dateCreated >='".$month."'");
					$paymentRes=mysql_fetch_assoc($paymentQry);

					$grp_ID=$users['group_id'];
					$group_qry=mysql_query("select group_name from groups where group_id='$grp_ID'");
					$group_res=mysql_fetch_assoc($group_qry);
					
					$monthlyQry=mysql_query("select * from billing_info where cust_id='".$cust_id."' ORDER BY bill_info_id DESC limit 0,1");
					$monthlyRes=mysql_fetch_assoc($monthlyQry);
					
					if($users['status']==1){ $status="Active";}else{ $status="Inactive";}
					
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $users['addr1']." ".$users['addr2']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $users['mac_id']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $users['stb_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $group_res['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $monthlyRes['previous_due']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $monthlyRes['current_month_bill']);
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $monthlyRes['total_outstaning']);
					$this->excel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $paymentRes['tot_paid']);
					$this->excel->getActiveSheet()->setCellValueExplicit('N'.$rowCount, $users['pending_amount']);
					$s_no++;
					$rowCount++;
					}

				header('Content-Type: application/vnd.ms-excel'); //mime type

				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

				header('Cache-Control: max-age=0'); //no cache

				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('unpaid_customers.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function advancepaid()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Advance Paid Customers Reports');
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Advance paid Customers list');
		 
				$filename='Advance-paid-customers-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','Customer Name','Address','Mobile Number','Card No','Group Name','Status','Prev.M.Pending','Cur.M.Billing','Cur.M.Coltbl','Cur.M.Coll','Amt.Pending');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);
				$this->excel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $customTitle[12]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('M1')->getFont()->setSize(12);
				$rowCount++;
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$customers = $this->excelsheet_model->get_adv_paid_customers();
					$rowCount = 2;$s_no=1;
				//while($value=mysql_fetch_assoc($users)){
				foreach($customers as $key => $users ){
					$month=date("Y-m-00 00:00:00");
					$cust_id=$users['cust_id'];
					$paymentQry=mysql_query("select SUM(amount_paid) as tot_paid from payments where customer_id='$cust_id' AND dateCreated >='".$month."'");
					$paymentRes=mysql_fetch_assoc($paymentQry);

					$grp_ID=$users['group_id'];
					$group_qry=mysql_query("select group_name from groups where group_id='$grp_ID'");
					$group_res=mysql_fetch_assoc($group_qry);
					
					$monthlyQry=mysql_query("select * from billing_info where cust_id='".$cust_id."' ORDER BY bill_info_id DESC limit 0,1");
					$monthlyRes=mysql_fetch_assoc($monthlyQry);
					
					if($users['status']==1){ $status="Active";}else{ $status="Inactive";}
					
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $users['addr1']." ".$users['addr2']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $users['card_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $group_res['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $monthlyRes['previous_due']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $monthlyRes['current_month_bill']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $monthlyRes['total_outstaning']);
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $paymentRes['tot_paid']);
					$this->excel->getActiveSheet()->setCellValueExplicit('M'.$rowCount, $users['pending_amount']);
					$s_no++;
					$rowCount++;
					}
		 
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('advance_paid_customers.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function active_customers()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Active Customers Reports');
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Active Customers Report');
		 
				$filename='Active_Customers-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','Customer Name','Address','Mobile Number','STB NO','Group Name','Status','Customer Due');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(12);
				$rowCount++;
				// load database
				$this->load->database();
				// load model
				$this->load->model('excelsheet_model');
				// get all users in array formate
				$customers = $this->excelsheet_model->get_active_customers();
				$rowCount = 2;$s_no=1;
				foreach($customers as $key => $users)
				{
					$cust_id=$users['cust_id'];
					$paymentQry=mysql_query("select amount_paid from payments where customer_id='$cust_id'");
					$paymentRes=mysql_fetch_assoc($paymentQry);
					$grp_ID=$users['group_id'];
					$group_qry=mysql_query("select group_name from groups where group_id='$grp_ID'");
					$group_res=mysql_fetch_assoc($group_qry);
					$status="Active";
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $users['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $users['stb_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $group_res['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $users['pending_amount']);
					$s_no++;
					$rowCount++;
				}
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('active_customers.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function inactive_customers()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Inactive Customers Reports');
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Inactive Customers Report');
				$filename='Inactive_Customers-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','Customer Name','Address','Mobile Number','STB NO','Group Name','Status','Customer Due','Remarks','Inactivated On');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(12);
				$rowCount++;
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$customers = $this->excelsheet_model->get_inactive_customers();
				$rowCount = 2;$s_no=1;
				foreach($customers as $key => $users)
				{
					if($users['status']==1){ $status="Active";}else{ $status="Inactive";}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $users['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $users['stb_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $users['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $users['pending_amount']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $users['remarks']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $users['inactive_date']);
					$s_no++;
					$rowCount++;
				}
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('inactive_customers.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function allcollections()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('All Collection Reports');
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('All Collection list');
		 
				$filename='All-collections-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('ID','Customer ID','First Name','Address','Status','Mobile Number','MAC ID','VC No','Amount Paid','Emp Name','Receipt Number','Date');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(14);
				$rowCount++;
			
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_allcollections();
					$rowCount = 2;$s_no=1;
				// while($value=mysql_fetch_assoc($users)){
				foreach($users as $key => $value){
					if($value['status']==1){ $status="Active";}elseif($value['status']==0){ $status='Inactive';}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $value['mac_id']);
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $value['stb_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['amount_paid']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['emp_first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['invoice']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['dateCreated']);
					$s_no++;
					$rowCount++;
					}
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('all_collections.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function collection()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			{			 
				redirect('login');
			}
			else{
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['adminId']= $this->session->userdata('admin_id');
				$data['title'] = ucfirst('Employee Collection Reports'); 
				$emp_id = $this->session->userdata('emp_id');
				
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Employee Collection Report');
				$filename='Employee Collection Report'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Cust ID','Customer Name','Address','Mobile Number','Group Name','MAC ID','VC No','Emp Name','Amt Paid','Invoice No','Paid On');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(14);
				$rowCount++;

				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$customers = $this->excelsheet_model->get_collection($emp_id);
				//print_r($users); die;
					$rowCount = 2;$s_no=1;
				foreach($customers as $key => $users ){
					if($users['status']==1){ $status="Active";}else{ $status="Inactive";}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $users['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $users['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $users['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $users['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $users['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $users['mac_id']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $users['stb_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $users['emp_first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $users['amount_paid']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $users['invoice']);
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $users['dateCreated']);
					$s_no++;
					$rowCount++;
				}
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
				$this->load->view('website_template/header',$data);
				$this->load->view('collection.php',$data);
				$this->load->view('website_template/footer',$data); 
			}
 	}	
	
	public function open_complaints()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Open Complaints Reports'); 
			$open_comp=$this->excelsheet_model->get_open_complaints();
			$data['open_comp'] = $open_comp;
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Open Complaints list');
		 
				$filename='Open-complaints-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('ID','Customer ID','First Name','Address','City','Mobile Number','Category','Complaint','Ticket No','Date','Status','Remarks');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(14);
				$rowCount++;
			
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_open_complaints();
				
				$rowCount = 2;$s_no=1;
				while($value=mysql_fetch_assoc($users)){
					if($value['comp_status']==1){ $status="Processing";}elseif($value['comp_status']==0){ $status='Pending';}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['city']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['category']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['complaint']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['comp_ticketno']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['created_date']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $value['comp_remarks']);
					$s_no++;
					$rowCount++;
					}
		 
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('open_complaints.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function closed_complaints()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Closed Complaints Reports'); 
			$closed_comp=$this->excelsheet_model->get_closed_complaints();
			$data['closed_comp'] = $closed_comp;
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Closed Complaints list');
		 
				$filename='Closed-complaints-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('ID','Customer ID','First Name','Address','City','Mobile Number','Category','Complaint','Ticket No','Date','Status','Remarks');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(14);
				$rowCount++;
			
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_closed_complaints();
				
				$rowCount = 2;$s_no=1;
				while($value=mysql_fetch_assoc($users)){
					if($value['comp_status']==2){ $status="Closed";}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['city']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['category']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['complaint']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['comp_ticketno']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $value['created_date']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $value['comp_remarks']);
					$s_no++;
					$rowCount++;
					}
		 
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('closed_complaints.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}

	public function complaints()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Complaints Reports'); 
			$emp_id = $this->session->userdata('emp_id');
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Complaints list');
		 
				$filename='Complaints-Reports'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Customer ID','Customer Name','Address','Ticket Number','Mobile Number','Category','Complaint','Date','Status','Remarks');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);
				// $this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $customTitle[11]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				// $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(14);
				$rowCount++;
			
			
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_complaints($emp_id);
				
				$rowCount = 2;$s_no=1;
				// while($value=mysql_fetch_assoc($users)){
				foreach($users as $key => $value ){	
					if($value['comp_status']==2){ $status="Closed";}elseif($value['comp_status']==1){ $status="Processing";}elseif($value['comp_status']==0){ $status="Pending";}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $value['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $value['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $value['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $value['comp_ticketno']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $value['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $value['category']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $value['complaint']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $value['created_date']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $status);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $value['remarks']);
					// $this->excel->getActiveSheet()->setCellValueExplicit('L'.$rowCount, $value['comp_remarks']);
					$s_no++;
					$rowCount++;
					}
		 
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('complaint_reports.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function monthdemand()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('All Collection Reports'); 
			// $monthdemand=$this->excelsheet_model->get_monthdemand();
			// $data['monthdemand'] = $monthdemand;
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Monthly Demand');
		 
				$filename='Monthly-Demand-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('ID','Customer ID','First Name','Address','Mobile Number','Group','Prev Due','Current M Bill','Amount Paid','Month','Total Outstanding');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				$rowCount++;

				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_monthdemand();
					$rowCount = 2;$s_no=1;
				while($resCust=mysql_fetch_assoc($users)){
					$custData=$resCust['cust_id'];
					$monthly_demand = mysql_fetch_assoc(mysql_query("select * from billing_info where cust_id=$custData ORDER BY bill_info_id DESC"));
					$grp_id=$resCust['group_id'];
					$grpQry=mysql_query("select * from groups where group_id='$grp_id'");
					$grpRes=mysql_fetch_assoc($grpQry);
					
					$month=date("Y-m-00 00:00:00");
					$paymentQry=mysql_query("select * from payments where customer_id=".$resCust['cust_id']." AND dateCreated >= '$month'");
					$paymentRes=mysql_fetch_assoc($paymentQry);
					$tot_out=($monthly_demand['total_outstaning']-$paymentRes['amount_paid']);
					
					if($value['status']==1){ $status="Active";}elseif($value['status']==0){ $status='Inactive';}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $resCust['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $resCust['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $resCust['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $resCust['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $grpRes['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $monthly_demand['previous_due']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $monthly_demand['current_month_bill']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $paymentRes['amount_paid']);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $monthly_demand['current_month_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $tot_out);
					$s_no++;
					$rowCount++;
					}
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('monthly_demand.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function current_month_demand()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Current Month Due Report'); 
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Current Monthly Demand');
		 
				$filename='Current-Monthly-Demand-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('ID','Customer ID','First Name','Address','Mobile Number','Group','Prev Due','Current M Bill','Amount Paid','Month','Total Outstanding');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $customTitle[10]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(14);
				$rowCount++;

				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_current_month_demand();
					$rowCount = 2;$s_no=1;
				$cust_ids='0';
				while($resCust=mysql_fetch_assoc($users)){
					$cust_ids=$cust_ids.",".$resCust['cust_id'];
				}	
				$qry="select * from customers where cust_id NOT IN (".$cust_ids.")";
				if(isset($_REQUEST['inputGroup']) && $_REQUEST['inputGroup']!='')
				{
					$qry.=" AND group_id = ".$_REQUEST['inputGroup'];
				}
				$qry=mysql_query($qry);
				while($resCust=mysql_fetch_assoc($qry)){
					$custData=$resCust['cust_id'];
					$monthly_demand = mysql_fetch_assoc(mysql_query("select * from billing_info where cust_id=$custData ORDER BY bill_info_id DESC"));
					$grp_id=$resCust['group_id'];
					$grpQry=mysql_query("select * from groups where group_id='$grp_id'");
					$grpRes=mysql_fetch_assoc($grpQry);
					
					$month=date("Y-m-00 00:00:00");
					$paymentQry=mysql_query("select * from payments where customer_id=".$resCust['cust_id']." AND dateCreated >= '$month'");
					$paymentRes=mysql_fetch_assoc($paymentQry);
					// $tot_out=($monthly_demand['total_outstaning']-$paymentRes['amount_paid']);
					$tot_out=$resCust['pending_amount']+$monthly_demand['current_month_bill'];
					if($paymentRes['amount_paid']==''){ $amount=0;}
					
					if($value['status']==1){ $status="Active";}elseif($value['status']==0){ $status='Inactive';}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $resCust['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $resCust['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $resCust['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $resCust['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $grpRes['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $resCust['pending_amount']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $monthly_demand['current_month_bill']);
					$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $amount);
					$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $monthly_demand['current_month_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('K'.$rowCount, $tot_out);
					$s_no++;
					$rowCount++;
					}
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('current_month_demand.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}

	public function nextpaymentdate()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Next Payment Date Report'); 
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Next Payment Date');
		 
				$filename='Next-Payment-Date-'.date("Ymd").'.xls'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','Customer ID','First Name','Address','Mobile Number','Group','Payment Date','Created Date');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$rowCount++;

				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
		 
				// get all users in array formate
				$users = $this->excelsheet_model->get_next_payment_date_list();
					$rowCount = 2;$s_no=1;
				// while($resCust=mysql_fetch_assoc($qry)){
				foreach($users as $key => $resCust){
					
					if($value['status']==1){ $status="Active";}elseif($value['status']==0){ $status='Inactive';}
					$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $resCust['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $resCust['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $resCust['addr1']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $resCust['mobile_no']);
					$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $resCust['group_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $resCust['next_pay_date']);
					$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $resCust['dateCreated']);
					$s_no++;
					$rowCount++;
					}
				
				header('Content-Type: application/vnd.ms-excel'); //mime type
		 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		 
				header('Cache-Control: max-age=0'); //no cache
		 
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
				
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function req_download()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('New Ala-carte and Bouquet Request Report');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('New Requests Report');
				$filename='New_Ala_carte_Bouquet_Request_Report-'.date("Ymd").'.csv'; //save our workbook as this file name
				$rowCount = 1;
				$customTitle = array ('S.No','ACCOUNT NO','MAC ID','DESCR','DEAL NAME');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
					$rowCount = 2;$s_no=1;
				$customer_requets_pending = $this->excelsheet_model->get_customer_requets_pending();
    			$data['customer_requets'] = array();
    			foreach($customer_requets_pending as $key => $creq)
    			{
    			    if(isset($_REQUEST['bouquet']) && $_REQUEST['bouquet']!='')
    			    {
    			        $packName='';
        			    $customer_ala_req = $this->excelsheet_model->get_customer_alacarte_req_pending($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
        			    $customer_bouquet_req = $this->excelsheet_model->get_customer_bouquet_req_pending($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
        			    if($customer_ala_req!=0)
        			    {
        			        $packName = $customer_ala_req[0]['ala_ch_descr'];
        			        $this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
        					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
        					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['mac_id']);
        					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $creq['gDescr']);
        					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $packName);
        					$s_no++;
    					    $rowCount++;
        			    }
        			    elseif($customer_bouquet_req!=0)
        			    {
        			        $packName1 = $customer_bouquet_req[0]['package_description'];
        			        $packName = $packName1;
        			        $this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
        					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
        					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['mac_id']);
        					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $creq['gDescr']);
        					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $packName);
        					$s_no++;
					        $rowCount++;
        			    }
    			    }
    			    else
    			    {
        			    $packName='';
        			    $customer_ala_req = $this->excelsheet_model->get_customer_alacarte_req_pending($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
        			    $customer_bouquet_req = $this->excelsheet_model->get_customer_bouquet_req_pending($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
        			    if($customer_ala_req!=0)
        			    {
        			        $packName = $customer_ala_req[0]['ala_ch_descr'];
        			        $this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
        					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
        					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['mac_id']);
        					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $creq['gDescr']);
        					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $packName);
        					$s_no++;
    					    $rowCount++;
        			    }
        			    elseif($customer_bouquet_req!=0)
        			    {
        			        $packName1 = $customer_bouquet_req[0]['package_description'];
        			        $packName = explode(",",$packName1);
        			        foreach($packName as $key2 => $pkInfo)
        			        {
            			        $this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $s_no);
            					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
            					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['mac_id']);
            					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $creq['gDescr']);
            					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $pkInfo);
            					$s_no++;
    					        $rowCount++;
        			        }
        			    }
    			    }
        			 //   print_r($packName);
    			}
    // 			exit;
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function ala_approved()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('New Ala-carte and Bouquet Request Approved');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Activated Report');
				$filename='Activated_Report-'.date("Ymd").'.csv';
				$rowCount = 1;
				$customTitle = array ('S.No','ACCOUNT NO','NAME','STB NO','PACK NAME','PACK PRICE','EMPLOYEE NAME');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$this->load->model('Dashboard_model');
				$rowCount = 2;$s_no=1;
				$customer_approved = $this->excelsheet_model->get_ala_approved_log();
    			foreach($customer_approved as $key => $creq)
    			{
    			    // $customer_ala_req = $this->Dashboard_model->get_customer_alacarte_approved($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
    			    // foreach($customer_ala_req as $key2 => $c2)
    			    // {
    			        // $customer_req1['alacarte']= $c2;
    			    // }
    			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_approved($creq['cust_id'],$creq['stb_id'],$creq['alacarte_req_id']);
    			    foreach($customer_bouquet_req as $key3 => $c3)
    			    {
    			        $customer_req1['bouquet']= $c3;
    			    }
    			    if($customer_req1['bouquet']!='')
					{
						$packName=$customer_req1['bouquet']['package_name'];$packPrice=$customer_req1['bouquet']['lco_price'];
					}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['first_name']);
					$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $creq['stb_no']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $packName);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $packPrice);
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $creq['empFname']);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function ala_reject()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Ala-carte and Bouquet Reject');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Reject Report');
				$filename='Ala_carte_Bouquet_Reject_Report-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('S.No','ACCOUNT NO','NAME','MAC ID','VC NO','PACK NAME','PACK PRICE');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$this->load->model('Dashboard_model');
				$rowCount = 2;$s_no=1;
				$customer_rejects = $this->excelsheet_model->get_ala_reject_log();
    			foreach($customer_rejects as $key => $creq)
    			{
    			    $customer_ala_req = $this->Dashboard_model->get_customer_alacarte_reject($creq['cust_id'],$creq['stb_id'],$creq['alacarte_rej_id']);
    			    foreach($customer_ala_req as $key2 => $c2)
    			    {
    			        $customer_req1['alacarte']= $c2;
    			    }
    			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_reject($creq['cust_id'],$creq['stb_id'],$creq['alacarte_rej_id']);
    			    if($customer_bouquet_req[0]['pack_id']!=''){ $packName=$customer_bouquet_req[0]['package_name'];$packPrice=$customer_bouquet_req[0]['package_price'];}else{ $packName=$customer_req1['alacarte']['ala_ch_name'];$packPrice=$customer_req1['alacarte']['ala_ch_price'];}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['first_name']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['mac_id']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['stb_no']);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $packName);
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $packPrice);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function franchise()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Franchise Report');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Franchise Report');
				$filename='Franchise_Report-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('S.No','Account No','STB NO','Name','Description','Type','Open Balance','Amount','Close Balance','Date Created');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$rowCount = 2;$s_no=1;
				$franchise_log = $this->excelsheet_model->get_franchise_log();
    			foreach($franchise_log as $key => $creq)
    			{
    			    if($creq['type']=='debit'){ $sign="-";}else{$sign="+";}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custNo']);
					$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $creq['cStbNo']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['cFname']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['remarks']);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, ucfirst($creq['type']));
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $creq['open_bal']);
					$this->excel->getActiveSheet()->setCellValue('H'.$rowCount, $sign.$creq['amount']);
					$this->excel->getActiveSheet()->setCellValue('I'.$rowCount, $creq['close_bal']);
					$this->excel->getActiveSheet()->setCellValue('J'.$rowCount, $creq['dateCreated']);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function customer_renewals()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Customer Renewal Report');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Customer Renewal Report');
				$filename='Customer_Renewal_Report-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('S.No','Account No','MAC ID','Name','Group','Amount','Date Created');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$rowCount = 2;$s_no=1;
				$customer_renewals = $this->excelsheet_model->get_customer_renewals();
    			foreach($customer_renewals as $key => $creq)
    			{
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custNo']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['cMacId']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['cFname']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['gName']);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $creq['amount']);
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $creq['dateCreated']);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function removal_requests()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Ala-carte and Bouquet Remove');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('Remove Request Report');
				$filename='Ala_carte_Bouquet_Remove_Report-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('S.No','ACCOUNT NO','NAME','MAC ID','VC NO','GROUP','PACK NAME','PACK PRICE','DATE & TIME');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$this->load->model('Dashboard_model');
				$rowCount = 2;$s_no=1;
				$customer_rejects = $this->excelsheet_model->get_ala_remove_log();
    			foreach($customer_rejects as $key => $creq)
    			{
    			    $customer_ala_req = $this->Dashboard_model->get_customer_alacarte_remove_info($creq['cust_id'],$creq['stb_id'],$creq['alacarte_remove_id']);
    			    foreach($customer_ala_req as $key2 => $c2)
    			    {
    			        $customer_req1['alacarte']= $c2;
    			    }
    			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet_remove_info($creq['cust_id'],$creq['stb_id'],$creq['alacarte_remove_id']);
    			    if($customer_bouquet_req[0]['pack_id']!=''){ $packName=$customer_bouquet_req[0]['package_description'];$packPrice=$customer_bouquet_req[0]['package_price'];}else{ $packName=$customer_req1['alacarte']['ala_ch_descr'];$packPrice=$customer_req1['alacarte']['ala_ch_price'];}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['first_name']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['mac_id']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['stb_no']);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $creq['gName']);
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $packName);
					$this->excel->getActiveSheet()->setCellValue('H'.$rowCount, $packPrice);
					$this->excel->getActiveSheet()->setCellValue('I'.$rowCount, $creq['removedOn']);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function export_expenses()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Expenses Reports');
			
				//load our new PHPExcel library
				$this->load->library('excel');
				//activate worksheet number 1
				$this->excel->setActiveSheetIndex(0);
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle('Expenses  Reports');
				$filename='Expenses-Reports-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('ID','Category','Name','Receipt No','Booking Date','Remarks','Price');
				$this->excel->getActiveSheet()->SetCellValue('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->SetCellValue('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->SetCellValue('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->SetCellValue('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->SetCellValue('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->SetCellValue('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->SetCellValue('G'.$rowCount, $customTitle[6]);
				
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$rowCount++;
				// load database
				$this->load->database();
		 
				// load model
				$this->load->model('excelsheet_model');
				$users = $this->excelsheet_model->get_expenses($data['adminId']);
				$rowCount = 2;$s_no=1;
				foreach($users as $key => $value)
				{
					$sel_inward_item=mysql_query("select exp_cat_id,name from expenses_items where exp_id=".$value['exp_id']);
					$res_inward_item=mysql_fetch_assoc($sel_inward_item);
					$sel_exp_cat=mysql_query("select catName from expenses_cat where exp_cat_id=".$res_inward_item['exp_cat_id']);
					$res_exp_cat=mysql_fetch_assoc($sel_exp_cat);
					$this->excel->getActiveSheet()->SetCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->SetCellValue('B'.$rowCount, $res_exp_cat['catName']);
					$this->excel->getActiveSheet()->SetCellValue('C'.$rowCount, $res_inward_item['name']);
					$this->excel->getActiveSheet()->SetCellValue('D'.$rowCount, $value['receipt_no']);
					$this->excel->getActiveSheet()->SetCellValue('E'.$rowCount, $value['receipt_date']);
					$this->excel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['remarks']);
					$this->excel->getActiveSheet()->SetCellValue('G'.$rowCount, $value['inward_qty']);
					$s_no++;
					$rowCount++;
				}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('expenses_reports.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
 	
 	public function all_cust_channels()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('All Customers Packages');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('All Customers PackagesReport');
				$filename='All_Customers_Packages-'.date("Ymd").'.csv';
				$rowCount = 1;
				$customTitle = array ('S.No','ACCOUNT NO','NAME','MAC ID','VC NO','PACK NAME','PACK PRICE');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$this->load->model('Dashboard_model');
				$rowCount = 2;$s_no=1;
				$customer_approved = $this->excelsheet_model->get_all_cust_channels();
    			foreach($customer_approved as $key => $creq)
    			{
    			    $customer_ala_req = $this->Dashboard_model->get_customer_alacarte($creq['cust_id'],$creq['stb_id'],$creq['ca_id']);
    			    foreach($customer_ala_req as $key2 => $c2)
    			    {
    			        $customer_req1['alacarte']= $c2;
    			    }
    			    $customer_bouquet_req = $this->Dashboard_model->get_customer_bouquet($creq['cust_id'],$creq['stb_id'],$creq['ca_id']);
    			    foreach($customer_bouquet_req as $key3 => $c3)
    			    {
    			        $customer_req1['bouquet']= $c3;
    			    }
    			    if($customer_req1['bouquet']!=''){ $packName=$customer_req1['bouquet']['package_name'];$packPrice=$customer_req1['bouquet']['package_price'];}else{ $packName=$customer_req1['alacarte']['ala_ch_name'];$packPrice=$customer_req1['alacarte']['ala_ch_price'];}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['first_name']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['mac_id']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['stb_no']);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $packName);
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $packPrice);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function lco_wallets()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('LCO Wallet Report');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('LCO Wallet Report');
				$filename='LCO_Wallet_Report-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('S.No','LCO Name','Mobile NO','Wallet as of Now','Description','Type','Open Balance','Amount','Close Balance','Date Created');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$rowCount = 2;$s_no=1;
				$franchise_log = $this->excelsheet_model->get_lco_wallet($data['emp_id']);
    			foreach($franchise_log as $key => $creq)
    			{
    			    if($creq['type']=='debit'){ $sign="-";}else{$sign="+";}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['empFname']." ".$creq['empLname']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['empMobile']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['balance']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['remarks']);
					$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, ucfirst($creq['type']));
					$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $creq['open_bal']);
					$this->excel->getActiveSheet()->setCellValue('H'.$rowCount, $sign.$creq['amount']);
					$this->excel->getActiveSheet()->setCellValue('I'.$rowCount, $creq['close_bal']);
					$this->excel->getActiveSheet()->setCellValue('J'.$rowCount, $creq['dateCreated']);
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
			$this->load->view('website_template/header',$data);
			$this->load->view('next_payment_date.php',$data);
			$this->load->view('website_template/footer',$data); 
		}
 	}
	
	public function lco_wallet_balance()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('LCO Wallet Report');
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('LCO Wallet Balance Report');
				$filename='LCO_Wallet_Balance_Report-'.date("Ymd").'.xls';
				$rowCount = 1;
				$customTitle = array ('S.No','LCO Name','Mobile NO','Wallet as of Now','Date Created');
				$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
				$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
				$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.$rowCount, $customTitle[7]);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.$rowCount, $customTitle[8]);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.$rowCount, $customTitle[9]);

				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(14);
				$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(14);
				$rowCount++;
				$this->load->database();
				$this->load->model('excelsheet_model');
				$rowCount = 2;$s_no=1;
				$franchise_log = $this->excelsheet_model->get_lco_wallet_balance($data['emp_id']);
    			foreach($franchise_log as $key => $creq)
    			{
    			    if($creq['type']=='debit'){ $sign="-";}else{$sign="+";}
			        $this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
					$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['empFname']." ".$creq['empLname']);
					$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['empMobile']);
					$this->excel->getActiveSheet()->setCellValue('D'.$rowCount, $creq['balance']);
					$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, date("d,M Y"));
					$s_no++;
			        $rowCount++;
    			}
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				$objWriter->save('php://output');
				exit;
		}
 	}
	
	public function cust_accounting()
	{
 		if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
		{			 
			redirect('login');
		}
		else
		{
			$data['emp_id']= $this->session->userdata('emp_id');
			$data['adminId']= $this->session->userdata('admin_id');
			$data['title'] = ucfirst('Collection Report');
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('Customer Collection Report');
			$filename='Collection_Report-'.date("Ymd").'.xls';
			$rowCount = 1;
			$customTitle = array ('S.No','ACCOUNT NO','NAME','STB NO','PACK NAME','PACK PRICE','DATE');
			$this->excel->getActiveSheet()->setCellValueExplicit('A'.$rowCount, $customTitle[0]);
			$this->excel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $customTitle[1]);
			$this->excel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $customTitle[2]);
			$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $customTitle[3]);
			$this->excel->getActiveSheet()->setCellValueExplicit('E'.$rowCount, $customTitle[4]);
			$this->excel->getActiveSheet()->setCellValueExplicit('F'.$rowCount, $customTitle[5]);
			$this->excel->getActiveSheet()->setCellValueExplicit('G'.$rowCount, $customTitle[6]);

			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(14);
			$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
			$rowCount++;
			$this->load->database();
			$this->load->model('excelsheet_model');
			$rowCount = 2;$s_no=1;
			$customer_approved = $this->excelsheet_model->get_cust_accounting_log();
			foreach($customer_approved as $key => $creq)
			{
				$this->excel->getActiveSheet()->setCellValue('A'.$rowCount, $s_no);
				$this->excel->getActiveSheet()->setCellValue('B'.$rowCount, $creq['custom_customer_no']);
				$this->excel->getActiveSheet()->setCellValue('C'.$rowCount, $creq['first_name']);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $creq['stb_no']);
				$this->excel->getActiveSheet()->setCellValue('E'.$rowCount, $creq['remarks']);
				$this->excel->getActiveSheet()->setCellValue('F'.$rowCount, $creq['amount']);
				$this->excel->getActiveSheet()->setCellValue('G'.$rowCount, $creq['dateCreated']);
				$s_no++;
				$rowCount++;
			}
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			$objWriter->save('php://output');
		}
 	}
}
?>