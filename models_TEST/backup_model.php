<?php 
class Backup_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	public function check_emp($emp_id=NULL){
		$this->db->select('emp_id');
			$this->db->where('user_type',1);
			$this->db->where('emp_id', $emp_id);
			$query = $this->db->get('employes_reg');
			if ($query->num_rows() > 0){
				return 1;
			} else {
				return 0;
			}
	}
}