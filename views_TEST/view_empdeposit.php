<?php 
	$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
	extract($userAccess);
	if(($empdepositeV ==1)){ 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - View Deposit</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Employee</a></li>
			<li class="active">View Deposit</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
		<?php foreach($empdeposit as $key => $empdeposit){}?>
	    <?php if(isset($msg)){ echo $msg; } ?>
			<!-- left column -->
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Deposit View</h3>
					</div>
				<!-- /.box-header -->				  
					<div class="box-body">
						<div class="form-group col-md-12">
							<label for="inputempname" class="col-sm-2 control-label">Employee</label>
							<?php
								$emp_id=$empdeposit['emp_name'];
								$empQry=mysql_query("select emp_first_name,emp_last_name from employes_reg where emp_id='$emp_id'");
								$empRes=mysql_fetch_assoc($empQry);
							?>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputempname" name="inputempname" value="<?php echo $empRes['emp_first_name']." ".$empRes['emp_last_name'];?>" readonly >
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="inputLname" class="col-sm-2 control-label">Amount</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="inputLname" name="inputLname" value="<?php echo $empdeposit['depos_amount'];?>" readonly>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="inputdepositDate" class="col-sm-2 control-label">Deposit Date:</label>
							<div class="col-sm-10">
								<input type="date" class="form-control pull-right" id="inputdepositDate"  name="inputdepositDate" value="<?php echo $empdeposit['depos_date'];?>" readonly>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label for="inputRemarks" class="col-sm-2 control-label">Remarks:</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="3" id="inputRemarks" name="inputRemarks" readonly><?php echo $empdeposit['remarks'];?></textarea>
							</div>
						</div>
						<div class="box-footer">
							<a  href="../../empdeposit/empdeposit_list/" class="btn btn-info pull-right">Back</a>
						</div>			  
					</div>
				</div>
			</div>
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<?php 
	}
	else
	{ 
		redirect('/');
	}
?>