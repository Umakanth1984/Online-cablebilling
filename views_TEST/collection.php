<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){
	$newGrpIds='';   
	if(isset($_REQUEST['inputGroup']) && $_REQUEST['inputGroup']!=''){
		foreach($_REQUEST['inputGroup'] as $key => $Group){
			$grp.=$Group.",";
		}
		$newGrpIds= substr($grp, 0, -1); 
	}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Digital Cables  - Employee Collection List </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Collection</a></li>
			<li class="active"><a  href="#">Employee Collection</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Employee Collection Report</h3>
						<div class="box-body">	
							<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/collection">						
								<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
								<input type="hidden" class="form-control" id="inputGroup1" name="inputGroup[]" <?php if(isset($newGrpIds) && $newGrpIds!=''){?> value="<?php echo $newGrpIds; ?>" <?php } ?> placeholder="inputGroup">
								<input type="hidden" class="form-control" id="inputEmp" name="inputEmp" <?php if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!=''){?> value="<?php echo $_REQUEST['inputEmp']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> >
								<input type="hidden" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?> >
								<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
							</form>
						</div>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/collection">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-2">
									<div class="col-md-12">
										<select class="form-control" id="inputGroup" name="inputGroup[]" multiple>
											<option value="">Select All Groups</option>
										<?php
											$grp_qry=mysql_query("select group_id,group_name from groups where admin_id='$adminId'");
											while($grp_res=mysql_fetch_assoc($grp_qry))
											{
										?>
											<option value="<?php echo $grp_res['group_id'];?>" <?php if(in_array($grp_res['group_id'], $_REQUEST['inputGroup'])){ echo "selected";}?>><?php echo $grp_res['group_name'];?></option>
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
											$grp_qry=mysql_query("select emp_id,emp_first_name from employes_reg where status=1 AND user_type!=9 and emp_id!=12 and admin_id='$adminId'");
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
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> title="From Date">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?> title="To Date">
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
									<th>Cust.ID</th>
									<th>Customer Name</th>
									<th>Mobile</th>
									<th>Amount Paid</th>
									<th>Group Name</th>
									<th>Emp Name</th>
									<!--<th>Current Due</th>-->
									<th>Transaction Type </th>
									<th>Invoice No</th>
									<th>Paid On </th>
								</tr>
							</thead>
							<tbody>
						   <?php
							$i=1;$totAmt=0;
							foreach($payments as $key => $payment )
							{
							?>  
								<tr>
									<td><?php echo $i;?></td>
									<td><a  href="<?php echo base_url()?>customer/view/<?php echo $payment['customer_id']?>"><?php echo $payment['custom_customer_no'];?></a></td>
									<td><?php echo $payment['first_name'];?></td>
									<td><?php echo $payment['mobile_no'];?></td>
									<td><?php echo $payment['amount_paid'];?></td>
									<td><?php echo $payment['group_name'];?></td>
									<td><?php echo $payment['emp_first_name'];?></td>
									<!--<td><?php echo $payment['pending_amount'];?></td>-->
									<td><?php if($payment['transaction_type']==1){echo "Cash";}elseif($payment['transaction_type']==2){ echo "Bank";}elseif($payment['transaction_type']==3){ echo "Adjustment";}elseif($payment['transaction_type']==4){ echo "Google Pay";}elseif($payment['transaction_type']==5){ echo "Phone pay";}elseif($payment['transaction_type']==6){ echo "Paytm";}else{ echo "Reverse";}?></td>	
									<td><?php echo $payment['invoice'];?></td>
									<td><?php echo $payment['dateCreated'];?></td>
								</tr>
						<?php
							$i=$i+1;
							$totAmt=$totAmt+$payment['amount_paid'];
							}?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="11" align="right">Total Amount : <b style="color:red;">Rs. <?php echo $totAmt;?></b></td>
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