<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller {

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
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->dbutil();
		$this->load->model('backup_model');
	}
	
	public function index()
	{
 		//if(($this->session->userdata('emp_id')=='') && ($this->session->userdata('admin_id')==''))
			//{
				//redirect('login');
			//}
			//else{
				// error_reporting(E_ALL);
				$data['emp_id']= $this->session->userdata('emp_id');
				$data['admin_id']= $this->session->userdata('admin_id');
				$emp_id= $this->session->userdata('emp_id');
				$user_access = $this->backup_model->check_emp($emp_id);
				//if($user_access==1)
				//{
					// Load the DB utility class
					
					$prefs = array(
							'tables'        => array(),   // Array of tables to backup.
							'ignore'        => array(),                     // List of tables to omit from the backup
							'format'        => 'zip',                       // gzip, zip, txt
							'filename'      => 'Cablebilling_'. date("Y-m-d-H-i-s").'-backup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
							//'filename' => $this->db->database .' '. date("Y-m-d-H-i-s").'-backup.sql',
							'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
							'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
							'newline'       => "\n"                         // Newline character used in backup file
					);		
					
					
					// Backup your entire database and assign it to a variable
					$backup =& $this->dbutil->backup($prefs);

					// Load the file helper and write the file to your server
					$this->load->helper('file');
					write_file('/home/digitalrrupay/cablebilling/DB_backup/'.'Cablebilling_'.date("Y-m-d-H-i-s").'.zip', $backup);

					// Load the download helper and send the file to your desktop
					$this->load->helper('download');
					force_download('Cablebilling.zip', $backup);
					// redirect('/');
				//}
			//}
 	}
	
	public function backup()
	{
		// Load the DB utility class
		$this->load->dbutil();

		$prefs = array(
				'tables'        => array(),   // Array of tables to backup.
				'ignore'        => array(),                     // List of tables to omit from the backup
				'format'        => 'zip',                       // gzip, zip, txt
				'filename'      => 'Cablebilling.sql',              // File name - NEEDED ONLY WITH ZIP FILES
				'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
				'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
				'newline'       => "\n"                         // Newline character used in backup file
		);		
		
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup($prefs);

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file('/path/to/'.'Cablebilling.gz', $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('Cablebilling.gz', $backup);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */