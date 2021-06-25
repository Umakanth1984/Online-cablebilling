<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Open Complaints List</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Reports</a></li>
			<li><a href="#">Complaints</a></li>
			<li class="active"><a href="#">Open Complaints</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/open_complaints">
						<div class="box-header with-border">
							<h3 class="box-title">Open Complaints List</h3>
							<a  href="<?php echo base_url()?>excelsheet/open_complaints" class="pull-right btn btn-primary">Export to Excel</a>
						</div>
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Cust ID">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="Name or First Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">
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
							<th>Sl.No</th>
							<!--<th>Date</th>-->
							<th>Cust.ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Ticket Number</th>
							<th>Complaint</th>
							<th>Category</th>
							<th>Complaint Time</th>
							<th>Complaint Duration</th>
							<th>Status</th>
							<th>Remarks</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($open_comp as $key => $active_complaints_data)
						{
							$cust_id=$active_complaints_data['customer_id'];
							$custQry=mysql_query("select * from customers where cust_id='$cust_id'");
							$custRes=mysql_fetch_assoc($custQry);
							
							$cat_id=$active_complaints_data['comp_cat'];
							$catQry=mysql_query("select * from complaint_prefer where id='$cat_id'");
							$catRes=mysql_fetch_assoc($catQry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<!--<td><?php echo $active_complaints_data['created_date'];?></td>-->
							<td><?php echo $custRes['custom_customer_no'];?></td>
							<td><?php echo $custRes['first_name'];?></td>
							<td><?php echo $custRes['addr1'].", ".$custRes['addr2'];?></td>
							<td><?php echo $active_complaints_data['comp_ticketno'];?></td>
							<td><?php echo $active_complaints_data['complaint'];?></td>
							<td><?php echo $catRes['category'];?></td>
							<td><?php echo $active_complaints_data['created_date'];?></td>
							<td><?php
									$date1 = strtotime($active_complaints_data['created_date']);
									// $date2 = strtotime($complaints['edited_on']);
									$subTime = time() - $date1;
									//$y = ($subTime/(60*60*24*365));
									$d = ($subTime/(60*60*24))%365;
									$h = ($subTime/(60*60))%24;
									$m = ($subTime/60)%60;

									// echo "Complaint Duration is: ";
									echo $d." days, ";
									echo $h." hours, ";
									echo $m." minutes";
								?></td>
							<td><?php if($active_complaints_data['comp_status']==0){ echo "Pending";}else{ echo "Processing";}?></td>
							<td><?php echo $active_complaints_data['comp_remarks'];?></td>
						</tr>
						<?php
							$i++;
						}
						?>
						</tbody>
					</table>
				</div>
            <!-- /.box-body -->
				</div>
          <!-- /.box -->
			</div>
        <!-- /.col -->
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
  <?php } else{ 
	 redirect('/');
  }?>