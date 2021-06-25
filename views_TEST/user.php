<?php 
extract($emp_access);
extract($employee_info);
if($user_type==9)
{
?>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Add New LCO</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">LCO</a></li>
			<li class="active">Add New LCO</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
			<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/lco_save"> 
			<!-- left column -->
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Personal Data</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="inputFname" class="col-sm-2 control-label">First Name *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="First Name" maxlength=50 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputLname" class="col-sm-2 control-label">Last Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputLname" name="inputLname" placeholder="Last Name" maxlength=30>
								</div>
							</div>
							<div class="form-group">
								<label for="inputAddr1" class="col-sm-2 control-label">Address 1: *</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="3" id="inputAddr1" name="inputAddr1" placeholder="Address 1" required></textarea>
								</div>
							</div>
							<!--<div class="form-group">
								<label for="lco_portal_url" class="col-sm-2 control-label">LCO Portal URL</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="lco_portal_url" name="lco_portal_url" placeholder="LCO Portal URL" maxlength=100 required>
								</div>
							</div>
							<div class="form-group">
								<label for="lco_username" class="col-sm-2 control-label">LCO Portal Username</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="lco_username" name="lco_username" placeholder="LCO Portal Username" maxlength=30 required>
								</div>
							</div>
							<div class="form-group">
								<label for="lco_password" class="col-sm-2 control-label">LCO Portal Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="lco_password" name="lco_password" placeholder="LCO Portal Password" maxlength=30 required>
								</div>
							</div>-->
						</div>
					</div>
				</div>
			<!--/.col (left) -->
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">&nbsp;</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="inputCity" class="col-sm-2 control-label">City</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="City" maxlength=50>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPincode" class="col-sm-2 control-label">PinCode</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputPincode" name="inputPincode" placeholder="Pincode" maxlength=6>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="col-sm-2 control-label">Email Id *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" maxlength=60 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPhone" class="col-sm-2 control-label">Phone</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputPhone" value="0" name="inputPhone" placeholder="Phone Number" maxlength=13>
								</div>
							</div>
							<div class="form-group">
								<label for="inputMobile" class="col-sm-2 control-label">Mobile *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputMobile" name="inputMobile" placeholder="Mobile" maxlength=10 minlength=10 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputusertype" class="col-sm-2 control-label">User Type *</label>
								<div class="col-sm-10">
									<select class="form-control" id="inputusertype" name="inputusertype" required>
										<option value="">Select Option</option>
										<option value="1" selected>Admin</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
    </section>
</div>
<?php	
}
else
{
if($usersA ==1){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Add New Employee</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Employees</a></li>
			<li class="active">Add New Employee</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
			<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/user_save"> 
			<!-- left column -->
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Personal Data</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="inputFname" class="col-sm-2 control-label">First Name *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="First Name" maxlength=30 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputLname" class="col-sm-2 control-label">Last Name *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputLname" name="inputLname" placeholder="Last Name" maxlength=30 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputAddr1" class="col-sm-2 control-label">Address 1: *</label>
								<div class="col-sm-10">
									<textarea  class="form-control"  rows="3"  id="inputAddr1" name="inputAddr1" placeholder="Address 1" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="inputAddr2" class="col-sm-2 control-label">Address 2:</label>
								<div class="col-sm-10">
									<textarea  class="form-control"  rows="3"  id="inputAddr2" name="inputAddr2" placeholder="Address 2"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="inputAddr3" class="col-sm-2 control-label">Address 3:</label>
								<div class="col-sm-10">
									<textarea  class="form-control"  rows="3"  id="inputAddr3" name="inputAddr3" placeholder="Address 3"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!--/.col (left) -->
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">&nbsp;</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="inputCity" class="col-sm-2 control-label">City *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="City" maxlength=30 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPincode" class="col-sm-2 control-label">PinCode *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputPincode" name="inputPincode" placeholder="Pincode" maxlength=6 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="col-sm-2 control-label">Email Id *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" maxlength=40 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPhone" class="col-sm-2 control-label">Phone</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputPhone" value="0" name="inputPhone" placeholder="Phone Number" maxlength=13>
								</div>
							</div>
							<div class="form-group">
								<label for="inputMobile" class="col-sm-2 control-label">Mobile *</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="inputMobile" name="inputMobile" placeholder="Mobile" maxlength=13 required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputusertype" class="col-sm-2 control-label">User Type *</label>
								<div class="col-sm-10">
									<select class="form-control" id="inputusertype" name="inputusertype" required>
										<option value="">Select Option</option>
										<option value="1">Admin</option>
										<option value="2">Employee</option>
										<option value="3">Technical Person </option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputusertype" class="col-sm-2 control-label">User Role *</label>
								<div class="col-sm-10">
									<select class="form-control" id="inputuserrole" name="inputuserrole" required>
										<option value="">Select Employee Role</option>
									<?php 
										$roleqry=mysql_query("select * from emp_prefer");
										while($roleres=mysql_fetch_assoc($roleqry))
										{
									?>	
											<option value="<?=$roleres['employeerole'];?>"><?=$roleres['employeerole'];?></option>
									<?php
										}
									?>
									</select>
									<a  href="<?php echo base_url();?>preferences/emp_prefer">Add New Role </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
				</div>
			</form>
		</div>
    </section>
</div>
<?php
	}
	else
	{ 
		redirect('/welcome');
	}
}
?>