<?php 
	$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
	extract($userAccess);
	if(($empdepositeA ==1)){
?>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Employee Deposit</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Employee Deposit</a></li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>empdeposit/empdeposit_save"> 
        <!-- left column -->
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
              <div class="box-body">
				   <div class="form-group">
					  <label for="inputempname" class="col-sm-2 control-label">Employee *</label>
					   <div class="col-sm-10">
						  <select class="form-control" id="inputempname" name="inputempname" required>
						  <option value="">Select Employee</option>
							<?php $sel_user=mysql_query("select * from employes_reg where emp_id!=12 AND user_type!=9 AND status=1 AND admin_id='$adminId'");
									while($row_user=mysql_fetch_assoc($sel_user)){
							?>
							<option value="<?php echo $row_user['emp_id']; ?>"><?php echo $row_user['emp_first_name']." ".$row_user['emp_last_name']; ?></option>
							<?php }?>
							
						  </select>
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputdepositAmount" class="col-sm-2 control-label">Deposit Amount *</label>
					  <div class="col-sm-10">
						<input type="number" min="1" max="9999" class="form-control" id="inputdepositAmount" name="inputdepositAmount" placeholder="Deposit Amount" maxlength=4 required>
					  </div>
					</div>
					<div class="form-group">
					<label for="inputdepositDate" class="col-sm-2 control-label">Deposit Date *:</label>
					<div class="col-sm-10">
					   <input type="date" class="form-control pull-right" id="inputdepositDate"  name="inputdepositDate" placeholder="YYYY-DD-MM" required>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputRemarks" class="col-sm-2 control-label">Remarks:</label>
					<div class="col-sm-10">
						<textarea  class="form-control"  rows="3"  id="inputRemarks" name="inputRemarks" placeholder="Remarks" ></textarea>
					</div>
				  </div>
				   <div class="box-footer">
					<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
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