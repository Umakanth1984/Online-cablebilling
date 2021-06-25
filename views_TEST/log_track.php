<?php	
	$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
	if($chkEmpType['user_type']==1)
	{
?>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Log History</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li class="active"><a  href="#">Log History</a></li>
		</ol>
    </section>

    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Log History</h3>
					</div>
					<?php if(isset($msg) && $msg!=''){ echo $msg;} ?>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/log_history">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="from_date">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="from_date" name="from_date" value="<?php if($_REQUEST['from_date'] && $_REQUEST['from_date']!=''){ echo $_REQUEST['from_date'];}else{ echo date("Y-m-d");}?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="to_date">To Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="to_date" name="to_date" value="<?php if($_REQUEST['to_date'] && $_REQUEST['to_date']!=''){ echo $_REQUEST['to_date'];}else{ echo date("Y-m-d");}?>">
									</div>
								</div>
								<div class="col-md-1">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Employee Name</th>
									<th>Category</th>
									<th>IP Address</th>
									<th>Description</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$i=1;
								foreach($get_log_history as $key => $log_details )
								{
									$chkEmp=mysql_fetch_assoc(mysql_query("select emp_first_name,emp_last_name from employes_reg where emp_id=".$log_details['emp_id']));
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $chkEmp['emp_first_name']." ".$chkEmp['emp_last_name'];?></td>
									<td><?php echo $log_details['category'];?></td>
									<td><?php echo $log_details['ipaddress'];?></td>  
									<td><?php echo $log_details['log_text'];?></td>
									<td><?php echo $log_details['dateCreated'];?></td>
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
    </section>
</div>
	<?php
	}
	else
	{
		redirect('/');
	}
	?>  