<?php 
	$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
	extract($userAccess);
	if(($empdepositeE ==1)){ 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Employee Deposit    
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Employee</a></li>
        <li class="active">Edit Employee Deposit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
	    <?php foreach($edit_empdeposit as $key => $empdeposit )
				{
				} ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
			<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>empdeposit/empdeposit_updated/<?php echo $empdeposit['emp_depos_id']?>""> 
				<!-- left column -->
				<div class="col-md-6">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title"></h3>
						</div>
						<div class="box-body">
						   <div class="form-group">
								<label for="EmployeeName" class="col-sm-2 control-label">Select Employee</label>
								<div class="col-sm-10">
								  <select class="form-control" id="EmployeeName" name="EmployeeName" >
									<?php $sel_user=mysql_query("select * from employes_reg where emp_id!=12 AND user_type!=9 AND admin_id='$adminId'");
											while($row_user=mysql_fetch_assoc($sel_user)){
									?>
									<option value="<?php echo $row_user['emp_id']; ?>" <?php if($empdeposit['emp_name'] == $row_user['emp_id']) { echo "selected";}?>><?php echo $row_user['emp_first_name']." ".$row_user['emp_last_name']; ?></option>
									<?php }?>
								  </select>
								</div>
							</div>
							<div class="form-group">
							  <label for="DepositAmount" class="col-sm-2 control-label">Deposit Amount *</label>
							  <div class="col-sm-10">
								<input type="text" class="form-control" id="DepositAmount" value="<?php echo $empdeposit['depos_amount'];?>" name="DepositAmount" required>
							  </div>
							</div>
							<div class="form-group">
								<label for="DepositDate" class="col-sm-2 control-label">Deposit Date *:</label>
								<div class="col-sm-10">
								   <input type="date" class="form-control pull-right" id="DepositDate" value="<?php echo $empdeposit['depos_date'];?>"  name="DepositDate" required>
								</div>
							</div>
							<div class="form-group">
								<label for="Remarks" class="col-sm-2 control-label">Remarks:</label>
								<div class="col-sm-10">
									<textarea  class="form-control"  rows="3"  id="Remarks" name="Remarks" placeholder="Remarks" ><?php echo $empdeposit['remarks'];?></textarea>
								</div>
							</div>
							<div class="box-footer">
								<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
							</div>			  
						</div>
					</div>
				</div>
			</form>
		</div>
    </section>
</div>
<?php 
	}
	else
	{ 
		redirect('/');
	}
?>