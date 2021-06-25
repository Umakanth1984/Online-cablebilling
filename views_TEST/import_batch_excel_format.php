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
		<h1>Digital Cables  - Batch Excelsheet Format</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Batch Excelsheet Format</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php foreach($import_data as $key => $excel_value){}?>
		<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>settings/update_batch_import">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Assign</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="custom_customer_no" class="col-sm-4 control-label">Account No *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="custom_customer_no" name="custom_customer_no" placeholder="Value of Account No in Excel" maxlength=2 minlength=1 required value="<?php echo $excel_value['custom_customer_no'];?>">
								</div>
							</div>
							<div class="form-group">
								<label for="mac_id" class="col-sm-4 control-label">MAC ID </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mac_id" name="mac_id" placeholder="Value of MAC ID in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['mac_id'];?>" required>
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
								<label for="deal_name" class="col-sm-4 control-label">Deal Name *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="deal_name" name="deal_name" placeholder="Value of Deal Name in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['deal_name'];?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="final_status" class="col-sm-4 control-label">Final Status *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="final_status" name="final_status" placeholder="Value of Final Status in Excel" maxlength=2 minlength=1 value="<?php echo $excel_value['final_status'];?>" required>
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