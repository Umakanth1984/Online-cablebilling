<?php
extract($emp_access);
extract($employee_info);
if(($usersE ==1) || ($usersV ==1) || ($usersD ==1))
{
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Employee To Groups Assign</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee To Groups</a></li>
			<li class="active">Employee To Groups Assign List </li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
		<?php	foreach($emp_name as $key => $emp ){}?>
		<?php if(isset($msg)){ echo $msg; } ?>
		<form id="empGrpForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/emp_group_save"> 
				<input type="hidden" name="assign_emp_id" id="assign_emp_id" value="<?php echo $assign_emp_id; ?>">
				<input type="hidden" name="userType" id="userType" value="<?php echo $employee_info['user_type']; ?>">
			<div class="box">
            <div class="box-header">
              <h3 class="box-title"> Assign Group to <b><?php echo $emp['emp_first_name']." ".$emp['emp_last_name']; ?></b></h3>
            </div>
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
					<tr>
						<th>Group Id</th>
						<th>Group Name</th>
						<th>&nbsp;</th>
						<th>Associated Employees</th>
						<th>&nbsp;</th>
					</tr>
                </thead>
                <tbody>
                <?php
					$checkGrp=mysql_query("select * from emp_to_group where emp_id=$assign_emp_id");
					$resChkGrp=mysql_fetch_assoc($checkGrp);
					$chkGrpValue=explode(",",$resChkGrp['group_ids']);
					if($user_type==9)
					{
					    $selGrp=mysql_query("select group_id,group_name from groups where admin_id='$assign_admin_id'");
					}
					else
					{
					    $selGrp=mysql_query("select group_id,group_name from groups where admin_id='$assign_admin_id'");
					}
					while($resGrp=mysql_fetch_assoc($selGrp))
					{
						$grp_id=$resGrp['group_id'];
						$checkGrpID=mysql_query("SELECT * FROM emp_to_group WHERE  find_in_set('$grp_id',(group_ids))");
						$grpEmpName='';
						while($resGrpEmpId=mysql_fetch_assoc($checkGrpID))
						{
							$selEmpName=mysql_fetch_assoc(mysql_query("SELECT * FROM employes_reg WHERE emp_id=".$resGrpEmpId['emp_id']));
							$grpEmpName.=$selEmpName['emp_first_name']." ".$selEmpName['emp_last_name']." , ";
						}
				?>
					<tr>
					<td><?php echo $resGrp['group_id'];?></td>
					<td><?php echo $resGrp['group_name'];?></td>
					<td><input type="checkbox" class="checkbox" name="grp[]" id="grp[]" value="<?php echo $resGrp['group_id'];?>"
					<?php if (in_array($resGrp['group_id'], $chkGrpValue)){ echo "checked";}?>></td>
					<td><?php echo $grpEmpName;?></td>
					<td> &nbsp;&nbsp;</td>
					</tr>
				<?php }?>
                </tbody>
              </table>
            </div>
          </div>
			<div class="box-footer">
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
            </div>
		</form>
        </div>
      </div>
    </section>
  </div>	
 <?php 
	} 
	else
	{ 
		redirect('/welcome');
	}?>