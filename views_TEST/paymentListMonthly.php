<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
$grp_ids=$chkEmpGrps['group_ids'];
if(($custE ==1) || ($custV ==1) ||($custD ==1)){
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Monthly Payments History
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Customer</a></li>
        <li class="active">Monthly Payments History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Monthly Payments History</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/monthlypaymentslist">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
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
										<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Customer Mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputGroup" name="inputGroup">
											<option value="">Select Group</option>
										<?php
											$grp_qry=mysql_query("select group_id,group_name from groups where group_id IN ($grp_ids) AND admin_id='$adminId'");
											while($grp_res=mysql_fetch_assoc($grp_qry))
											{
										?>
											<option value="<?php echo $grp_res['group_id'];?>" <?php if($grp_res['group_id'] == $mpl_search_group){ echo "selected";} ?>><?php echo $grp_res['group_name'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="fromdate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="todate">To Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?>>
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
									<th>Customer Name</th>
									<th>Mobile</th>
									<th>Group</th>
									<th>Amount Paid</th>
									<th>Current Due</th>
									<th>Type</th>
									<th>Employee</th>
									<th>Invoice No</th>
									<th>Paid On </th>
								</tr>
							</thead>
							<tbody>
						   <?php
							// print_r($payments); 
							$i=1;$totAmt=0;
							foreach($payments as $key => $payment )
							{
							//$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
							//echo "SELECT first_name,last_name,mobile_no,amount FROM customers WHERE cust_id=".$payment['customer_id']; die;
							$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
							$grp_ids=$chkEmpGrps['group_ids'];
							 
								$sql=mysql_query("SELECT * FROM customers WHERE cust_id=".$payment['customer_id']." AND group_id IN ($grp_ids)");
								$row=mysql_fetch_assoc($sql);
								$name=$row['first_name']." ".$row['last_name'];
								$mobile=$row['mobile_no'];
								$customerNo=$row['custom_customer_no'];
								$amount=$row['amount'];
							?>  
								<tr>
									<td><?php echo $i;?></td>
									<td><a  href="<?php echo base_url()?>customer/view/<?php echo $row['cust_id']?>"><?php echo $customerNo;?></a></td>
									<td><?php echo $name;?></td>
									<td><?php echo $mobile;?></td>
									<td><?php echo $payment['group_name'];?></td>
									<td><?php echo $payment['amount_paid'];?></td>
									<td><?php echo $payment['pending_amount'];?></td>
									<td><?php if($payment['transaction_type']==1){echo "Cash";}elseif($payment['transaction_type']==2){ echo "Bank";}elseif($payment['transaction_type']==3){ echo "Adjustment";}elseif($payment['transaction_type']==4){ echo "Google Pay";}elseif($payment['transaction_type']==5){ echo "Phone pay";}elseif($payment['transaction_type']==6){ echo "Paytm";}else{ echo "Reverse";}?></td>
									<td><?php echo $payment['emp_first_name'];?></td>
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
<?php } else{ 
	 redirect('/');
  }?>  