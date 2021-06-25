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
      <h1>
        Digital Cables  - Unpaid Customers List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Customers</a></li>
			<li class="active"><a  href="#">Unpaid Customers</a></li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
				
					<div class="box-header with-border">
						<h3 class="box-title">Unpaid Customers List</h3>
						<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/unpaid">						
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?> >
							<input type="hidden" class="form-control" id="inputFname" name="inputFname" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="mobile" name="mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="inputGroup1" name="inputGroup[]" <?php if(isset($newGrpIds) && $newGrpIds!=''){?> value="<?php echo $newGrpIds; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="inputEmp" name="inputEmp" <?php if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!=''){?> value="<?php echo $_REQUEST['inputEmp']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="amount" name="amount" <?php if(isset($_REQUEST['amount']) && $_REQUEST['amount']!=''){?> value="<?php echo $_REQUEST['amount']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="condition" name="condition" <?php if(isset($_REQUEST['condition']) && $_REQUEST['condition']!=''){?> value="<?php echo $_REQUEST['condition']; ?>" <?php } ?>>
							<input type="hidden" class="form-control" id="inputStatus" name="inputStatus" <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']!=''){?> value="<?php echo $_REQUEST['inputStatus']; ?>" <?php } ?>>
							<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>
					</div>
				<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/unpaid">
					<div class="box-body">
						<div class="form-group">
							<div class="col-md-3">
								<div class="col-md-12">
									<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Cust ID" maxlength="10" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?>>
								</div>
							</div>
							<div class="col-md-3">
								<div class="col-md-12">
									<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="Name or First Name" maxlength="20" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
								</div>
							</div>
							<div class="col-md-3">
								<div class="col-md-12">
									<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" maxlength="10" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
								</div>
							</div>
							<div class="col-md-3">
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
						</div>
						<div class="form-group">
							<div class="col-md-5">
								<div class="col-md-6">
									<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" value="<?php if(isset($_REQUEST['amount']) && $_REQUEST['amount']!=''){ echo $_REQUEST['amount'];}?>" maxlength="4">
								</div>
								<div class="col-md-6">
									<select class="form-control" id="condition" name="condition">
										<option value="=">Equal To</option>
										<option value="!=" <?php if(isset($_REQUEST['condition']) && $_REQUEST['condition']=='!='){ echo "selected";}?>>Not equal To</option>
										<option value="<" <?php if(isset($_REQUEST['condition']) && $_REQUEST['condition']=='<'){ echo "selected";}?>>Less than</option>
										<option value=">" <?php if(isset($_REQUEST['condition']) && $_REQUEST['condition']=='>'){ echo "selected";}?>>Greater than</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="col-md-12">
									<select class="form-control" id="inputStatus" name="inputStatus">
										<option value="">Select Status</option>
										<option value="1" <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']=='1'){ echo "selected";}?>>Active</option>
										<option value="0" <?php if(isset($_REQUEST['inputStatus']) && $_REQUEST['inputStatus']=='0'){ echo "selected";}?>>Inactive</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="col-md-12">
									<select class="form-control" id="inputEmp" name="inputEmp">
										<option value="">Select Employee</option>
									<?php
										$grp_qry=mysql_query("select emp_id,emp_first_name from employes_reg where status=1 AND user_type!=9 AND emp_id!=12 AND admin_id='$adminId'");
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
								<th>Mobile No.</th>
								<th>MAC ID</th>
								<th>Group</th>
								<th>Status</th>
								<th>Pre.M.Pending</th>
								<th>Cur.M.Billing</th>
								<th>Cur.M.Coltbl</th>
								<th>Cur.M.Coll</th>
								<th>Amt.Pending</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i=1;$totAmt=0;
						foreach($unpaid as $key => $unpaid_customer_data)
						{
							$month=date("Y-m-00 00:00:00");
							$cust_id=$unpaid_customer_data['cust_id'];
							$paymentQry=mysql_query("select SUM(amount_paid) as tot_paid from payments where customer_id='$cust_id' AND dateCreated >='".$month."'");
							$paymentRes=mysql_fetch_assoc($paymentQry);
						 
							$monthlyQry=mysql_query("select * from billing_info where cust_id='".$cust_id."' ORDER BY bill_info_id DESC limit 0,1");
							$monthlyRes=mysql_fetch_assoc($monthlyQry);
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $unpaid_customer_data['custom_customer_no'];?></td>
							<td><?php echo $unpaid_customer_data['first_name']." ".$unpaid_customer_data['last_name'];?></td>
							<td><?php echo $unpaid_customer_data['addr1'].",".$unpaid_customer_data['addr2'];?></td>
							<td><?php echo $unpaid_customer_data['mobile_no'];?></td>
							<td><?php echo $unpaid_customer_data['mac_id'];?></td>
							<td><?php echo $unpaid_customer_data['group_name'];?></td>
							<td><?php if($unpaid_customer_data['status']==1){ echo "Active";}else{ echo "Inactive";}?></td>
							<td>Rs. <?php echo $monthlyRes['previous_due'];?></td>
							<td>Rs. <?php echo $monthlyRes['current_month_bill'];?></td>
							<td>Rs. <?php echo $monthlyRes['total_outstaning'];?></td>
							<td>Rs. <?php echo $paymentRes['tot_paid']?></td>
							<td>Rs. <?php echo $unpaid_customer_data['pending_amount'];?></td>
						</tr>
						<?php
							$i++;
							$totAmt=$totAmt+$unpaid_customer_data['pending_amount'];
						}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="11" align="center">Total Amount : <b style="color:red;font-size:24px;">Rs. <?php echo $totAmt;?></b></td>
							</tr>
						</tfoot>
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