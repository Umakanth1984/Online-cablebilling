<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($complE ==1) || ($complV ==1) ||($complD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Closed Complaints List</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Complaints</a></li>
			<li class="active"><a  href="#">Closed Complaints</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/closed_complaints">
						<div class="box-header with-border">
							<h3 class="box-title">Open Complaints List</h3>
							<a  href="<?php echo base_url()?>excelsheet/closed_complaints" class="pull-right btn btn-primary">Export to Excel</a>
						</div>
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-4">
									<label for="inputCCN" class="col-md-4 control-label">Cust ID</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Cust ID">
									</div>
								</div>
								<div class="col-md-4">
									<label for="inputFname" class="col-md-4 control-label">Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="Name or First Name">
									</div>
								</div>
								<div class="col-md-2">
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
							<th>Cust.ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Ticket Number</th>
							<th>Complaint</th>
							<th>Category</th>
							<th>Complaint Registered Time</th>
							<th>Complaint Closed Time</th>
							<th>Complaint Duration</th>
							<th>Status</th>
							<th>Remarks</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($closed_comp as $key => $closed_complaints_data)
						{
							$cust_id=$closed_complaints_data['customer_id'];
							$custQry=mysql_query("select * from customers where cust_id='$cust_id'");
							$custRes=mysql_fetch_assoc($custQry);
							
							$cat_id=$closed_complaints_data['comp_cat'];
							$catQry=mysql_query("select * from complaint_prefer where id='$cat_id'");
							$catRes=mysql_fetch_assoc($catQry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $custRes['custom_customer_no'];?></td>
							<td><?php echo $custRes['first_name'];?></td>
							<td><?php echo $custRes['addr1'].", ".$custRes['addr2'];?></td>
							<td><?php echo $closed_complaints_data['comp_ticketno'];?></td>
							<td><?php echo $closed_complaints_data['complaint'];?></td>
							<td><?php echo $catRes['category'];?></td>
							<td><?php echo $closed_complaints_data['created_date'];?></td>
							<td><?php echo $closed_complaints_data['edited_on'];?></td>
							<td><?php
									$date1 = strtotime($closed_complaints_data['created_date']);
									$date2 = strtotime($closed_complaints_data['edited_on']);
									$subTime = $date2 - $date1;
									//$y = ($subTime/(60*60*24*365));
									$d = ($subTime/(60*60*24))%365;
									$h = ($subTime/(60*60))%24;
									$m = ($subTime/60)%60;
									// echo "Complaint Duration is: ";
									echo $d." days, ";
									echo $h." hours, ";
									echo $m." minutes";
								?></td>
							<td><?php echo "Closed";?></td>
							<td><?php echo $closed_complaints_data['comp_remarks'];?></td>
						</tr>
						<?php
							$i++;
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
	}?>