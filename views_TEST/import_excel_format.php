<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);	
$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
$grp_ids=$chkEmpGrps['group_ids'];
if($custA ==1){ ?>
<style>
input {
    text-transform: uppercase;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Excelsheet Format</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Excelsheet Format</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php foreach($import_data as $key => $excel_value){}?>
		<form id="importForm" name="importForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>settings/update_import">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Assign</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="first_name" class="col-sm-4 control-label">Customer Name *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Value of First Name in Excel" maxlength=2 minlength=1 required value="<?php echo $excel_value['first_name'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="last_name" class="col-sm-4 control-label">Last Name </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Value of Last Name in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['last_name'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="addr1" class="col-sm-4 control-label">Address 1 *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="addr1" name="addr1" placeholder="Value of Address 1 in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['addr1'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="addr2" class="col-sm-4 control-label">Address 2:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="addr2" name="addr2" placeholder="Value of Address 2 in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['addr2'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="city" class="col-sm-4 control-label">City *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="city" name="city" placeholder="Value of City in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['city'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="pin_code" class="col-sm-4 control-label">PinCode </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="pin_code" name="pin_code" placeholder="Value of Pincode in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['pin_code'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="state" class="col-sm-4 control-label">State</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="state" name="state" placeholder="Value of State in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['state'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="phone_no" class="col-sm-4 control-label">Phone </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Value of Phone Number in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['phone_no'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="mobile_no" class="col-sm-4 control-label">Mobile *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Value of Mobile Number in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['mobile_no'];?>">
								</div>
							</div>
							<!--<div class="form-group">
								<label for="connection_date" class="col-sm-4 control-label">Connection Date</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="connection_date" name="connection_date" placeholder="Value of Connection Date in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['connection_date'];?>">
								</div>
							</div>-->
							<div class="form-group">
								<label for="pending_amount" class="col-sm-4 control-label">Pending / Outstanding Amount</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="pending_amount" name="pending_amount" placeholder="Value of Pending / Outstanding Amount in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['pending_amount'];?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			<!--/.col (left) -->
			<!-- right column -->
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Assign</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="group_id" class="col-sm-4 control-label">Group *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="group_id" name="group_id" placeholder="Value of Group Name in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['group_id'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="package_id" class="col-sm-4 control-label">Package *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="package_id" name="package_id" placeholder="Value of Package Name in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['package_id'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="custom_customer_no" class="col-sm-4 control-label">Custom Customer Number *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="custom_customer_no" name="custom_customer_no" placeholder="Value of Custom Customer Number in Excel" maxlength=2 minlength=1 required value="<?php echo $excel_value['custom_customer_no'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="connection_date" class="col-sm-4 control-label">Connection Date: </label>
								<div class="col-sm-8">
								   <input type="text" class="form-control" id="connection_date" name="connection_date" placeholder="Value of Connection Date in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['connection_date'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="mac_id" class="col-sm-4 control-label">MAC ID:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mac_id" name="mac_id" placeholder="Value of MAC ID in Excel" value="<?php echo $excel_value['mac_id'];?>" maxlength=2 minlength=1>
								</div>
							</div>
							<div class="form-group">
								<label for="stb_no" class="col-sm-4 control-label">STB :</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="stb_no" name="stb_no" placeholder="Value of STB Number in Excel" value="<?php echo $excel_value['stb_no'];?>" maxlength=2 minlength=1>
								</div>
							</div>
							<div class="form-group">
								<label for="card_no" class="col-sm-4 control-label">Card No:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="card_no" name="card_no" placeholder="Value of Card No in Excel" value="<?php echo $excel_value['card_no'];?>" maxlength=2 minlength=1>
								</div>
							</div>
							<!--<div class="form-group">
								<label for="start_date" class="col-sm-4 control-label">Start Date:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="start_date" name="start_date" placeholder="Value of Start Date in Excel" value="<?php echo $excel_value['start_date'];?>" maxlength=2 minlength=1>
								</div>
							</div>-->
							<div class="form-group">
								<label for="end_date" class="col-sm-4 control-label">End Date:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="end_date" name="end_date" placeholder="Value of End Date in Excel" value="<?php echo $excel_value['end_date'];?>" maxlength=2 minlength=1>
								</div>
							</div>
							<div class="form-group">
								<label for="status" class="col-sm-4 control-label">Status:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="status" name="status" placeholder="Value of Status in Excel" value="<?php echo $excel_value['status'];?>" maxlength=2 minlength=1>
								</div>
							</div>
							<div class="form-group">
								<label for="cafStatus" class="col-sm-4 control-label">Credential:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="cafStatus" name="cafStatus" placeholder="Value of Credential Status in Excel" value="<?php echo $excel_value['caf_status'];?>" maxlength=2 minlength=1>
								</div>
							</div>
							<!--<div class="form-group">
								<label for="servicePoid" class="col-sm-4 control-label">Service Poid:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="servicePoid" name="servicePoid" placeholder="Value of Service Poid in Excel" value="<?php echo $excel_value['service_poid'];?>" maxlength=2 minlength=1>
								</div>
							</div>-->
							<div class="form-group">
								<label for="cust_admin_id" class="col-sm-4 control-label">LCO Reg Email *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="cust_admin_id" name="cust_admin_id" placeholder="Value of LCO Registered Email in Excel" required value="<?php echo $excel_value['cust_admin_id'];?>" maxlength=2 minlength=1>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<div class="box-footer">
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
            </div>
		</form>
    </section>
</div>
	<?php
	}
	else
	{ 
		redirect('/welcome');
	}
	?>