<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Monthly Bill Generation Report</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Collection</a></li>
			<li class="active"><a  href="#">Monthly Bill Generation Report</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<!--<div class="box-header">
				  <h3 class="box-title">Monthly Bill Generation Report</h3>
				</div>-->
				<div class="box-header with-border">
					<h3 class="box-title">Monthly Bill Generation Report</h3>
					<a  href="<?php echo base_url()?>excelsheet/monthdemand" class="pull-right btn btn-primary">Export to Excel</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/monthdemand">
					<div class="form-group">
						<div class="col-md-3">
							<div class="col-md-12">
								<select class="form-control" name="inputGroup[]" multiple id="inputGroup">
									<option value="">Select All Groups</option>
								<?php
									$grp_qry=mysql_query("select group_id,group_name from groups where admin_id='$adminId'");
									while($grp_res=mysql_fetch_assoc($grp_qry))
									{
								?>
								
									<option value="<?php echo $grp_res['group_id'];?>" 
									<?php if(in_array($grp_res['group_id'], $_REQUEST['inputGroup'])){ echo "selected";}?>><?php echo $grp_res['group_name'];?></option>
								<?php
									}
								?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="col-md-12">
								<select class="form-control" id="inputEmp" name="inputEmp">
									<option value="">Select Employee</option>
								<?php
									$grp_qry=mysql_query("select emp_id,emp_first_name from employes_reg where status=1 AND emp_id!=12 AND user_type!=9 AND admin_id='$adminId'");
									while($grp_res=mysql_fetch_assoc($grp_qry))
									{
								?>
									<option value="<?php echo $grp_res['emp_id'];?>"  <?php if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']==$grp_res['emp_id']){ echo "selected";}?>><?php echo $grp_res['emp_first_name'];?></option>
								<?php
									}
								?>
								</select>
							</div>
						</div>
						<div class="col-md-1">
							<button name="submit" id="submit" class="btn btn-primary">Search</button>
						</div>
					</div>
				</form>
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>S.No</th>
							<th>Cust ID</th>
							<th>Cust Name</th>
							<th>Group</th>
							<th>Previous Due</th>
							<th>Current M Bill</th>
							<th>Amount Paid</th>
							<th>Month</th>
							<th>Total Outstanding</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						// foreach($inactive as $key => $resCust){
						while($resCust=mysql_fetch_assoc($cust_data)){
						$custData=$resCust['cust_id'];
						$grp_id=$resCust['group_id'];
						$monthly_demand = mysql_fetch_assoc(mysql_query("select * from billing_info where cust_id=$custData ORDER BY bill_info_id DESC"));
						$month=date("Y-m-00 00:00:00");
							$grpQry=mysql_query("select * from groups where group_id='$grp_id'");
							$grpRes=mysql_fetch_assoc($grpQry);
							$paymentQry=mysql_query("select * from payments where customer_id=".$resCust['cust_id']." AND dateCreated >= '$month'");
							$paymentRes=mysql_fetch_assoc($paymentQry);
						/**/	
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $resCust['custom_customer_no'];?></td>
							<td><?php echo $resCust['first_name'];?></td>
							<td><?php echo $grpRes['group_name'];?></td>
							<td><?php echo $monthly_demand['previous_due'];?></td>
							<td><?php echo $monthly_demand['current_month_bill'];?></td>
							<td><?php echo $paymentRes['amount_paid'];?></td>
							<td><?php echo $monthly_demand['current_month_name'];?></td>
							<td><?php echo $res=($monthly_demand['total_outstaning']-$paymentRes['amount_paid']);?></td>
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