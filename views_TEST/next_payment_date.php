<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1> Digital Cables  - Next Payment Date </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li class="active">Next Payment Date</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Next Payment Date</h3>
						<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/nextpaymentdate">						
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" class="form-control" id="from_date" name="from_date" <?php if(isset($_REQUEST['from_date']) && $_REQUEST['from_date']!=''){?> value="<?php echo $_REQUEST['from_date']; ?>" <?php } ?> >
							<input type="hidden" class="form-control" id="to_date" name="to_date" <?php if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!=''){?> value="<?php echo $_REQUEST['to_date']; ?>" <?php } ?> >
							<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/nextpaymentdate">
						<div class="box-body">
							<div class="form-group">
								
								<!--<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputGroup" name="inputGroup">
											<option value="">Select Group</option>
										<?php
											$grp_qry=mysql_query("select group_id,group_name from groups");
											while($grp_res=mysql_fetch_assoc($grp_qry))
											{
										?>
											<option value="<?php echo $grp_res['group_id'];?>" <?php if(isset($_REQUEST['inputGroup']) && $_REQUEST['inputGroup']==$grp_res['group_id']){ echo "selected";}?>><?php echo $grp_res['group_name'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>-->
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
										<input type="date" class="form-control" id="to_date" name="to_date" value="<?php if($_REQUEST['to_date'] && $_REQUEST['to_date']!=''){ echo $_REQUEST['to_date'];}else { echo date("Y-m-d"); }?>">
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
									<th>Cust ID</th>
									<th>Cust Name</th>
									<th>Address</th>
									<th>Mobile No</th>
									<th>Group Name</th>
									<th>Payment Date</th>
									<th>Created Date</th>
								</tr>
							</thead>
							<tbody>
						   <?php
							$i=1;$totAmt=0;
							foreach($next_payment_info as $key => $next_payment)
							{
							?>  
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $next_payment['custom_customer_no'];?></td>
									<td><?php echo $next_payment['first_name'];?></td>
									<td><?php echo $next_payment['addr1'];?></td>
									<td><?php echo $next_payment['mobile_no'];?></td>
									<td><?php echo $next_payment['group_name'];?></td>
									<td><?php echo $next_payment['next_pay_date'];?></td>
									<td><?php echo $next_payment['dateCreated'];?></td>
								</tr>
						<?php
							$i++;
							}?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="11" align="right">Total : <b style="color:red;"><?php echo $i-1;?></b></td>
								</tr>
							</tfoot>
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