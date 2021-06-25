<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
$grp_ids=$chkEmpGrps['group_ids']; 
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
      	<h1>Digital Cables  - Total Outstanding History</h1>
      	<ol class="breadcrumb">
	        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li><a  href="#">Customer</a></li>
	        <li class="active">Outstanding History</li>
      	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  	<h3 class="box-title">Outstanding History</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/totaloutstanding">
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
										<select class="form-control" id="inputGroup" name="inputGroup[]" multiple>
											<option value="">Select All Groups</option>
										<?php
											$grp_qry=mysql_query("select group_id,group_name from groups where group_id IN ($grp_ids) AND admin_id='$adminId'");
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
									<!--<th>Amount Paid</th>-->
									<th>Current Due</th>
									<!--<th>Transaction Type </th>-->
									<!--<th>Invoice No</th>
									<th>Paid On </th>-->
								</tr>
							</thead>
							<tbody>
						   <?php
							$i=1;$totAmt=0;
							foreach($payments as $key => $payment )
							{
								$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
								$grp_ids=$chkEmpGrps['group_ids'];
								$sql=mysql_query("SELECT * FROM customers WHERE cust_id=".$payment['cust_id']." AND group_id IN ($grp_ids)");
								$row=mysql_fetch_assoc($sql);
								$name=$row['first_name']." ".$row['last_name'];
								$mobile=$row['mobile_no'];
								$customerNo=$row['custom_customer_no'];
								$amount=$row['amount'];
							?>  
								<tr>
									<td><?php echo $i;?></td>
									<td><a  href="<?php echo base_url()?>customer/view/<?php echo $payment['cust_id']?>"><?php echo $payment['custom_customer_no'];?></a></td>
									<td><?php echo $payment['first_name'];?></td>
									<td><?php echo $payment['mobile_no'];?></td>
									<!--<td><?php echo $payment['amount_paid'];?></td>-->
									<td><?php echo $payment['pending_amount'];?></td>
									<!--<td><?php if($paidRes['transaction_type']==1){echo "Cash";}elseif($paidRes['transaction_type']==2){ echo "Bank";}else{ echo "Reverse";}?></td>-->
									<!--<td><?php echo $paidRes['invoice'];?></td>-->
									<!--<td><?php echo $payment['dateCreated'];?></td> 					
									<td><a  data-toggle="tooltip" data-placement="bottom"  title="Reverse Payment" href="<?php echo base_url()?>customer/reverse_payment/<?php echo $row['cust_id']?>"><i class="fa fa-money fa-lg" aria-hidden="true"></i></a></td>-->
								</tr>
						<?php
							//} // if condition
							$i=$i+1;
							$totAmt=$totAmt+$payment['pending_amount'];
							}?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="11" align="right">Total Outstanding Amount : <b style="color:red;">Rs. <?php echo $totAmt;?></b></td>
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