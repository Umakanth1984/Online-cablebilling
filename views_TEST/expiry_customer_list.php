<?php 
extract($emp_access); 
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<style>
.button.disabled {
  opacity: 0.65; 
  cursor: not-allowed;
}
</style>
<script>
function ConfirmDialog()
{
	var x=confirm("Are you sure to delete record?")
	if (x)
	{
		document.getElementById("submit").className = "disabled";
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables - Expiry Customers List</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Customers</a></li>
			<li class="active"><a  href="#">Expiry Customers List</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Expiry Customers List</h3>
						<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url();?>excelsheet/expiry_customers">						
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" class="form-control" id="fromdate" name="fromdate" value="<?php echo $_REQUEST['fromdate']; ?>">
							<input type="hidden" class="form-control" id="todate" name="todate" value="<?php echo $_REQUEST['todate']; ?>">
							<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="inputFname" name="inputFname" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="inputMobile" name="inputMobile" <?php if(isset($_REQUEST['inputMobile']) && $_REQUEST['inputMobile']!=''){?> value="<?php echo $_REQUEST['inputMobile']; ?>" <?php } ?>>
							<!--<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">-->
						</form>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" 
										<?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){ ?> value=<?php echo $_REQUEST['inputCCN'];?><?php } ?> placeholder="By Customer ID">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputFname" name="inputFname" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){ ?> value=<?php echo $_REQUEST['inputFname'];?><?php } ?>  placeholder="By Customer Name">
									</div>
								</div>
								<?php
								    if($employee_info['user_type']==9)
								    {
								?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputEmp" name="inputEmp">
											<option value="">Select LCO</option>
										<?php
											foreach($lco_list as $key2 => $lco)
											{
										?>
											<option value="<?php echo $lco['admin_id'];?>"  <?php if($lco['admin_id'] == $_REQUEST['inputEmp']){ echo "selected";} ?>><?php echo $lco['adminFname'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<?php
								    }
								?>
							</div>
							<div class="form-group">
							    <div class="col-md-4">
									<div class="col-md-4">
										<label for="fromdate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> max="<?php echo date('Y-m-d', strtotime("+90 days"));?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="todate">To Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate'];?>" <?php } ?> max="<?php echo date('Y-m-d', strtotime("+90 days"));?>">
									</div>
								</div>
								<div class="col-md-1 pull-right">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<?php if(isset($msg) && $msg!=''){ echo $msg;} ?>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Customer No</th>
									<th>Name</th>
									<th>Mobile</th> 
									<th>Group</th>
									<th>STB NO</th>
									<th>End Date</th>
									<th>Due</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($customers as $key => $customer )
							{
								$fullName = $customer['first_name'] ." ".$customer['last_name'];
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><a data-toggle="tooltip" data-placement="right" title="<?php echo $customer['custom_customer_no'];?>"><?php echo $customer['custom_customer_no'];?></a></td>
									<td><a data-toggle="tooltip" data-placement="right" title="<?php echo $fullName;?>"><?php if(strlen($fullName)>10){echo ucwords(substr($fullName,0,10))."...";}else{ echo ucwords(substr($fullName,0,10));}?></a></td>
									<td><?php echo $customer['mobile_no'];?></td>  
									<td><a data-toggle="tooltip" data-placement="right" title="<?php echo $customer['group_name'];?>"><?php if(strlen($customer['group_name'])>10){echo ucwords(substr($customer['group_name'],0,10))."...";}else{echo  ucwords(substr($customer['group_name'],0,10));}?></a></td>
									<td><a href="<?php echo base_url()?>customer/customer_stb/<?php echo $customer['cust_id']?>"><?php echo $customer['stb_no'];?></a></td>
									<td><?php echo $customer['end_date'];?></td>
									<td><?php echo $customer['pending_amount'];?></td>
								</tr>
								<?php 
								$i=$i+1;
							}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<?php echo $pagination; ?>
			</div>
		</div>
    </section>
  </div>
  <?php 
    }
    else
    { 
	    redirect('/');
    }?>