<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Complaints List</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li class="active"><a  href="#">Complaints</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Complaints List</h3>
						<div class="box-body">	
							<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/complaints">						
								<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
								<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?> >
								<input type="hidden" class="form-control" id="inputFname" name="inputFname" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="mobile" name="mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="inputStatus" name="inputStatus" <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']!=''){?> value="<?php echo $_REQUEST['inputStatus']; ?>" <?php } ?>>
								<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
							</form>
						</div>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/complaints">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-2">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Cust ID" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="Name or First Name" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputStatus" name="inputStatus">
											<option value="" <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']==''){ echo "selected";}?>>Select Status</option>
											<option value="0" <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']=='0'){ echo "selected";}?>>Pending</option>
											<option value="1"  <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']==1){ echo "selected";}?>>Processing</option>
											<option value="2"  <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']==2){ echo "selected";}?>>Closed</option>
										</select>
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
							<th>Sl.No</th>
							<th>Cust.ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Ticket Number</th>
							<th>Complaint</th>
							<th>Category</th>
							<th>Complaint Time</th>
							<th>Complaint Duration</th>
							<th>Status</th>
							<th>Mobile No</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($comp as $key => $complaints_data)
						// while($complaints_data=mysql_fetch_assoc($comp))
						{
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<!--<td><?php echo $complaints_data['created_date'];?></td>-->
							<td><?php echo $complaints_data['custom_customer_no'];?></td>
							<td><?php echo $complaints_data['first_name'];?></td>
							<td><?php echo $complaints_data['addr1'].", ".$complaints_data['addr2'];?></td>
							<td><?php echo $complaints_data['comp_ticketno'];?></td>
							<td><?php echo $complaints_data['complaint'];?></td>
							<td><?php echo $complaints_data['category'];?></td>
							<td><?php echo $complaints_data['created_date'];?></td>
							<td><?php
									$date1 = strtotime($complaints_data['created_date']);
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
							<td><?php if($complaints_data['comp_status']==0){ echo "Pending";}elseif($complaints_data['comp_status']==1){ echo "Processing";}else{ echo "Closed";}?></td>
							<td><?php echo $complaints_data['mobile_no'];?></td>
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