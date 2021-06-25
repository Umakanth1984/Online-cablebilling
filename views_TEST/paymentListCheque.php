<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Payments History
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Customer</a></li>
        <li class="active">Payments History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Payments History</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/paymentsListCheque">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<label for="inputCCN" class="col-md-4 control-label">Cust ID</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Cust ID">
									</div>
								</div>
								<div class="col-md-3">
									<label for="inputFname" class="col-md-4 control-label">Customer Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="Name or First Name">
									</div>
								</div>
								<div class="col-md-4">
									<label for="mobile" class="col-md-4 control-label">Customer Mobile</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Customer Mobile">
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
									<th>Sr #</th>
									<th>Cust. ID/Acc. No</th>
									<th>Customer</th>
									<th>Mobile</th>
									<th>Bill Amount Paid</th> 
									<th>Transaction Type </th>
									<th>Invoice No</th>
									<th>Paid On </th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
						   <?php
							// print_r($payments); 
							$i=1;
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
								$amount=$row['amount']; /*	*/
							//	if($name['payment_id'] !=''){ 
							?>  
								<tr>
									<td><?php echo $i;?></td>
									<td><a  href="<?php echo base_url()?>customer/view/<?php echo $row['cust_id']?>"><?php echo $customerNo;?></a></td>
									<td><?php echo $name;?></td>
									<td><?php echo $mobile;?></td>
									<td><?php echo $payment['amount_paid'];?></td>
									<td><?php if($payment['transaction_type']==1){echo "Cash";}else{ echo "Bank";}?></td>	
									<td><?php echo $payment['invoice'];?></td>
									<td><?php echo $payment['dateCreated'];?></td> 					
									<td>&nbsp;</td>
								</tr>
						<?php
							//} // if condition
							$i=$i+1;
							}?>
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