<?php
extract($emp_access);
if(($gropusA ==1) || ($gropusE ==1) || ($gropusV ==1) ||($gropusD ==1))
	{
?>
<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete record?")
  if (x) {
    return true;
  } else {
    return false;
  }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Groups</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Groups</a></li>
			<li class="active">Add Group</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<?php
			if(($gropusA ==1))
			{
		?>
		<div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
			<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>groups/group_save"> 
			<!-- left column -->
				<div class="col-md-10">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Add Group Details</h3>
						</div>
						<div class="box-body">
							<div class="form-group col-md-5">
							  <label for="group_name" class="col-sm-4 control-label">Group Name *</label>
							  <div class="col-sm-8">
								<input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name" maxlength=30 required>
							  </div>
							</div>
							<?php if($employee_info['user_type']==9){?>
							<div class="form-group col-md-5">
								<label for="lco_id" class="col-sm-4 control-label">Select LCO *</label>
								<div class="col-sm-8">
									<select class="form-control" id="lco_id" name="lco_id" required>
									<option value="">Select LCO</option>
									<?php
									foreach($lco_list as $key => $lco){
									?>
									<option value="<?php echo $lco['admin_id']; ?>"><?php echo $lco['adminFname'];?></option>
									<?php }?>
								  </select>
								</div>
							</div>
							<?php } ?>
							<div class="form-group col-md-2">
								<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info">Submit</button>
							</div>
						</div>
					</div>
				</div>
			<!--/.col (left) -->
			</form>
		</div>
		<?php
			}
			if(($gropusV ==1))
			{
		?>
	  <!-- Group List Starts Here -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Groups List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>groups">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-4">
									<label for="groupname" class="col-md-4 control-label">Group Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="groupname" name="groupname" placeholder="Group Name" maxlength=30>
									</div>
								</div>
								<?php if($employee_info['user_type']==9){?>
    							<div class="form-group col-md-4">
    								<label for="lco_id" class="col-sm-4 control-label">By LCO</label>
    								<div class="col-sm-8">
    									<select class="form-control" id="lco_id" name="lco_id">
        									<option value="">All LCOs</option>
        									<?php foreach($lco_list as $key => $lco){?>
        									<option value="<?php echo $lco['admin_id']; ?>" <?php if(isset($_REQUEST['lco_id']) && $_REQUEST['lco_id']==$lco['admin_id']){ echo "selected";}?>><?php echo $lco['adminFname'];?></option>
        									<?php }?>
    								    </select>
    								</div>
    							</div>
    							<?php } ?>
								<div class="col-md-2">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<div class="box-body">
					  <table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Group ID</th>
							<th>Group Name</th>
							<!--<th>Parent</th>-->
							<?php if($employee_info['user_type']==9){?><th>LCO</th><?php }?>
							<th>Status</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
					    <?php
						foreach($groups as $key => $group )
						{
						?>
							<tr>
                                <td><?php echo $group['group_id']?></td>
                                <td><?php echo $group['group_name']?></td>
                                <!--<td><?php if($group['is_parent'] == 0){ echo "NO";}else{echo $group['is_parent'];}?></td>-->
                                <?php if($employee_info['user_type']==9){?><td><?php echo $group['adminFname'];?></td><?php }?>
                                <td><?php if($group['status'] == 1){ echo "Active";}else{echo "InActive";}?></td>
                                <td><?php if($gropusE ==1){?><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>groups/edit/<?php echo $group['group_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }if($gropusD ==1){ ?><a  data-toggle="tooltip" data-placement="bottom"  title="Delete" href="<?php echo base_url()?>groups/delete/<?php echo $group['group_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php } ?></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
		?>
    </section>
  </div>
  <?php
	}
	else
	{ 
		redirect('/');
	}
	?> 