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
		<h1>Digital Cables  - Edit Employee Preferences</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li><a  href="#">Preferences</a></li>
			<li class="active">Edit Employee Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php foreach($edit as $key => $emp_edit_data){}?>
			<?php if(isset($msg)){ echo $msg; } ?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/update_emp_prefer/<?php echo $emp_edit_data['emp_id'];?>"> 
			<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_edit_data['emp_id'];?>">
        <!-- left column -->
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Edit Employee Preferences</h3>
					</div>
				<!-- /.box-header -->
				<!-- form start -->
					<div class="box-body">
						<div class="form-group">
							<label for="employeerole" class="col-sm-4 control-label">Employee Role</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="employeerole" id="employeerole" value="<?php echo $emp_edit_data['employeerole'];?>" placeholder="Enter Employee Role" required>
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
						<button type="submit" id="save" name="save" class="btn btn-info">Update</button>
					</div>
				</div>
			</div>
		
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Role List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Employee Role</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($emplist as $key => $emp_data )
								{	
								?>
								<tr>
									<td><?=$emp_data['emp_id'];?></td>
									<td><?=$emp_data['employeerole'];?></td>
									<td><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>preferences/edit_emp_prefer/<?php echo $emp_data['emp_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									&nbsp;<a  data-toggle="tooltip" data-placement="bottom"  title="Delete" href="<?php echo base_url()?>preferences/delete_emp_prefer/<?php echo $emp_data['emp_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
									</td>
								</tr>
								<?php  
								} 
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
		</div>
      <!-- /.row -->

		<!--	row end	-->
    </section>
    <!-- /.content -->
</div>