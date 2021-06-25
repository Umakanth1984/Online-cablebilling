<?php 
class Group_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	
	public function save_group()
	{ 
		extract($_REQUEST);
		if($is_parent == ''){$parent=0;}else{$parent=$is_parent;}
		$adminId=$this->session->userdata('admin_id');
		if(isset($lco_id) && $lco_id!='')
		{
		    $adminId = $lco_id;
		}
		$data = array(
		 	"admin_id" => $adminId,
		 	"group_name" => $group_name,
			"is_parent" => $parent,
			"status" => 1,
			"dateCreated" => date('Y-m-d H:i:s')
		);
		$this->db->insert("groups", $data);
		return 1;
	}
	
	public function edit_group($id,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id,user_type from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resGroup=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM groups WHERE group_id=$id"));
		if($resGroup['admin_id']==$admin_id || $user_type==9)
		{
			$ipaddress = '';
			if(isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			
			$grpQry=mysql_query("SELECT * FROM groups where group_id='$id'");
			$grpRes=mysql_fetch_assoc($grpQry);
			$changed="";
			if(($grpRes['group_name']===$_REQUEST['group_name']) || ($_REQUEST['group_name']==''))
				{ $changed.="";}
			else{ $changed.="Group Name : ".$grpRes['group_name']." changed as ".$_REQUEST['group_name'].",";}
			
			if(($grpRes['is_parent']===$_REQUEST['is_parent']) && ($_REQUEST['is_parent']!=''))
			{ $changed.="";}
			else{
				$chkGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id=".$_REQUEST['is_parent']));
				$oldGrp=mysql_fetch_assoc(mysql_query("SELECT group_name FROM groups WHERE group_id='$id' AND is_parent=".$grpRes['is_parent']));
				$changed.="Parent : ".$oldGrp['group_name']." changed as ".$chkGrp['group_name'].",";
			}
			if(($grpRes['is_default']===$_REQUEST['is_default']) && ($_REQUEST['is_default']!=''))
			{ $changed.="";}
			else{
				if($grpRes['is_default']==1){ $old="Yes";}else{ $old="No";}
				if($_REQUEST['is_default']==1){ $new="Yes";}else{ $new="No";}
				$changed.="Is Default : ".$old." changed as ".$new.",";
			}
			
			if($changed!='')
			{
				$data1 = array(
					"emp_id" => $emp_id,
					"admin_id" => $admin_id,
					"category" => "Group Edit",
					"ipaddress" => $ipaddress,
					"log_text" => $grpRes['group_name']." Group Details of ".$changed,
					"dateCreated" => date("Y-m-d H:i:s")
				);
			    $this->db->insert("change_log", $data1);
			}
			extract($_REQUEST);
			if($is_parent == ''){$parent=0;}else{$parent=$is_parent;}
			$data = array(
				"group_name" => $group_name,
				"is_parent" => $parent,
				"status" => 1
			);
			if(isset($lco_id) && $lco_id!='')
    		{
    		    $data['admin_id'] = $lco_id;
    		}
			$this->db->where('group_id', $id);
			$this->db->update('groups', $data);
		}
	}
	
 	public function get_group($id = NULL)
 	{
		extract($_REQUEST);
		$chkEmpType=$this->db->query("select user_type,admin_id from employes_reg where emp_id='$id'")->row_array();
		extract($chkEmpType);
		if($user_type==9)
		{
		    $where="";
			if((isset($groupname) && $groupname!=''))
			{
				$where.= " AND g.group_name LIKE '%$groupname%'";
			}
			if((isset($lco_id) && $lco_id!=''))
			{
				$where.= " AND g.admin_id LIKE '$lco_id'";
			}
		    $query = $this->db->query("select g.*,(select emp_first_name from employes_reg where admin_id=g.admin_id AND user_type=1 order by emp_id ASC LIMIT 0,1) as adminFname from groups g WHERE g.is_parent=0 $where ORDER BY g.group_id ASC ");
			return $query->result_array();
		}
		else
		{
			if((isset($groupname) && $groupname!=''))
			{
				$query = $this->db->query("select g.* from groups g WHERE g.admin_id='$admin_id' AND g.group_name LIKE '%$groupname%' AND g.is_parent=0");
			}
			else
			{
				$query = $this->db->query("select g.* from groups g WHERE g.admin_id='$admin_id' AND g.is_parent=0 ORDER BY g.group_id ASC ");
			}
			return $query->result_array();
		}
    }
	
	public function get_group_packages($id = NULL)
	{
        $query = $this->db->query("select * from groups where package_id !=0 ORDER By group_id ASC ");
        return $query->result_array();
    }
	
	public function get_group_by_id($id = NULL,$emp_id=NULL)
	{
		$adminId=$this->session->userdata('admin_id');
		$empInfo = $this->db->query("select user_type from employes_reg where emp_id='$emp_id'")->row_array();
		extract($empInfo);
		if($user_type==9)
		{
            $query = $this->db->query("select * from groups where group_id = $id");
            return $query->result_array();
		}
		else
		{
		    $query = $this->db->query("select * from groups where group_id = $id AND admin_id='$adminId'");
            return $query->result_array();
		}
    }
	
	public function del_group($id = NULL,$emp_id)
	{
		$chkEmpType=mysql_fetch_assoc(mysql_query("select admin_id from employes_reg where emp_id=$emp_id"));
		extract($chkEmpType);
		$resGroup=mysql_fetch_assoc(mysql_query("SELECT admin_id FROM groups WHERE group_id=$id"));
		if($resGroup['admin_id']==$admin_id)
		{
			$ipaddress = '';
			if(isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			
			$grpQry=mysql_query("SELECT * FROM groups where group_id= $id ");
			$grpRes=mysql_fetch_assoc($grpQry);
			$data1 = array(
				"emp_id" => $emp_id,
				"admin_id" => $admin_id,
				"category" => "Group Delete",
				"ipaddress" => $ipaddress,
				"log_text" => $grpRes['group_name']." Group has been Deleted.",
				"dateCreated" => date("Y-m-d H:i:s")
			);
			$this->db->insert("change_log", $data1);
		
			$query = $this->db->query("DELETE FROM groups WHERE group_id = $id ");
			return true;
		}
    }
    
    public function get_lco_list()
	{
		$query = $this->db->query("select a.*,(select emp_first_name from employes_reg where admin_id=a.admin_id AND user_type=1 order by emp_id ASC LIMIT 0,1) as adminFname from admin a left join employes_reg e ON e.admin_id=a.admin_id where a.franchise_type=1 and e.emp_id !='' group by a.admin_id")->result_array();
		if(count($query)>0)
		{
		    return $query;
		}
		else
		{
		    return 0;
		}
	}
}