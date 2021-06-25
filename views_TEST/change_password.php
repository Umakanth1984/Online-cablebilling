<?php $userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
	extract($userAccess);		 
?>
<script type="text/javascript">
function Validate(objForm) {
var firstInput = document.getElementById("new_password").value;
var secondInput = document.getElementById("reenter").value;
	if(firstInput === secondInput)
	{
		return true;
	}
	else
	{
		alert("Password's are not matched !")
		return false;
	}
}
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Change Password</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Change Password</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($get_common as $key => $common_data){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/change_password" onsubmit="return Validate(this);"> 
		<input type="hidden" id="emp_id" value="<?php echo $emp_id; ?>" name="emp_id">
        <!-- left column -->
        <div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Change Password</h3>
				</div>
            <!-- /.box-header -->
            <!-- form start -->
				<div class="box-body">
					<div class="form-group">
						<label for="old_password" class="col-sm-4 control-label">Old Password <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="old_password" value="" name="old_password" placeholder="Old Password" autofill="off" required> 
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="new_password" class="col-sm-4 control-label">New Password <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="new_password" value="" name="new_password" placeholder="New Password" required autofill="off">
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="reenter" class="col-sm-4 control-label">Re-enter New Password <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="reenter" name="reenter" placeholder="Re-enter New Password" autofill="off" required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
				</div>
				<div class="box-footer" style="text-align:center;">
					<button type="submit" id="businessupdate" name="businessupdate" class="btn btn-info">Update</button>
				</div>
			</div>
		</div>
		</form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>