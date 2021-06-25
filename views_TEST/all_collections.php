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
        Digital Cables  - All Collection List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Collection</a></li>
			<li class="active"><a  href="#">All Collection</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">All Collection List</h3>
						<div class="box-body">	
							<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/allcollections">						
								<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
								<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?> >
								<input type="hidden" class="form-control" id="inputFname" name="inputFname" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="mobile" name="mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="inputGroup1" name="inputGroup" <?php if(isset($newGrpIds) && $newGrpIds!=''){?> value="<?php echo $newGrpIds; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="inputEmp" name="inputEmp" <?php if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!=''){?> value="<?php echo $_REQUEST['inputEmp']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="amount" name="amount" <?php if(isset($_REQUEST['amount']) && $_REQUEST['amount']!=''){?> value="<?php echo $_REQUEST['amount']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="condition" name="condition" <?php if(isset($_REQUEST['condition']) && $_REQUEST['condition']!=''){?> value="<?php echo $_REQUEST['condition']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> >
								<input type="hidden" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?> >
								<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
							</form>
						</div>
					</div>				
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/allcollections">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-2">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Cust ID" maxlength="10" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-2">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="Name or First Name" maxlength="20" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-2">
									<div class="col-md-12">
										<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" maxlength="10" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-4">
										<label for="fromdate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-4">
										<label for="todate">To Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?>>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-5">
									<div class="col-md-4">
										<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" value="<?php if(isset($_REQUEST['amount']) && $_REQUEST['amount']!=''){ echo $_REQUEST['amount'];}?>" maxlength="4">
									</div>
									<div class="col-md-8">
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
				<?php
					$qry = "SELECT payments.amount_paid FROM customers RIGHT JOIN payments ON customers.cust_id=payments.customer_id RIGHT JOIN employes_reg ON employes_reg.emp_id=payments.emp_id RIGHT JOIN groups ON payments.grp_id=groups.group_id where 1=1";
					if((isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''))
					{
						$qry.=" AND customers.custom_customer_no='".$_REQUEST['inputCCN']."'";
					}		
					if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!='')
					{
						$qry.=" AND employes_reg.emp_id ='".$_REQUEST['inputEmp']."'";
					}
					$grp='';
					foreach($_REQUEST['inputGroup'] as $key => $Group){
						$grp.=$Group.",";
					}
					$newGrpIds= substr($grp, 0, -1);
					if(isset($newGrpIds) && $newGrpIds!='')
					{
						$qry.=" AND groups.group_id IN ($newGrpIds)";
					}
					if((isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!='') && (isset($_REQUEST['todate']) && $_REQUEST['todate']!=''))
					{
						$org_fromdate=strtotime($_REQUEST['fromdate']);
						$from_date=date("Y-m-d H:i:s",$org_fromdate);
						$org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime($_REQUEST['todate']));
						$to_date=date("Y-m-d H:i:s",$org_todate);	
						$qry.=" AND payments.dateCreated BETWEEN '$from_date' AND '$to_date'";
					}
					if((isset($_REQUEST['amount']) && $_REQUEST['amount']!='') && (isset($_REQUEST['condition']) && $_REQUEST['condition']!=''))
					{
						$qry.=" AND payments.amount_paid ".$_REQUEST['condition']." '".$_REQUEST['amount']."'";
					}
						$qry.= " GROUP BY payments.payment_id ";
						$query=mysql_query($qry);
						$totalAmt=0;
						while($result=mysql_fetch_assoc($query))
						{
							$totalAmt=$totalAmt+$result['amount_paid'];
						}
				?>
					<h4 align="center">Total Amount : <span style="color:GREEN;">Rs. <?php echo $totalAmt;?></span></h4>
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sl.No</th>
							<th>Cust ID</th>
							<th>Name</th>
							<th>Address</th>
							<th>Group</th>
							<th>Status</th>
							<th>Amount</th>
							<th>Mode</th>
							<th>Emp</th>
							<th>Date</th>
							<th>Receipt</th>
							<!--<th>Bank Details</th>
							<th>Remarks</th>-->
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;$totAmt=0;
						foreach($allcollections as $key => $all_payments_data)
						{
							$cust_ID=$all_payments_data['customer_id'];
							$custqry=mysql_query("select * from customers where cust_id='$cust_ID'");
							$custres=mysql_fetch_assoc($custqry);
							
							$emp_ID=$all_payments_data['emp_id'];
							$empQry=mysql_query("select * from employes_reg where emp_id='$emp_ID'");
							$empRes=mysql_fetch_assoc($empQry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $all_payments_data['custom_customer_no'];?></td>
							<td><?php echo $all_payments_data['first_name'];?></td>
							<td><?php echo $all_payments_data['addr1'];?></td>
							<td><?php echo $all_payments_data['group_name'];?></td>
							<td><?php if($custres['status']==1){ echo "Active";}else{ echo "Inactive";}?></td>
							<td>Rs. <?php echo $all_payments_data['amount_paid'];?></td>
							<td><?php if($all_payments_data['transaction_type']==1){ echo "Cash"; }elseif($all_payments_data['transaction_type']==2){ echo "Bank / Cheque"; }elseif($all_payments_data['transaction_type']==3){ echo "Adjustment";}elseif($all_payments_data['transaction_type']==4){ echo "Google Pay";}elseif($all_payments_data['transaction_type']==5){ echo "Phone pay";}elseif($all_payments_data['transaction_type']==6){ echo "Paytm";}else{ echo "Reverse";}?></td>
							<td><?php echo $empRes['emp_first_name'];?></td>
							<td><?php echo $all_payments_data['dateCreated'];?></td>
							<td><?php echo $all_payments_data['invoice'];?></td>
							<!--<td><?php echo $all_payments_data['bank'];?></td>
							<td><?php echo $all_payments_data['remarks'];?></td>-->
						</tr>
						<?php
							$i++;
							$totAmt=$totAmt+$all_payments_data['amount_paid'];
						}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="13" align="right">Total Collection : <b style="color:red;">Rs. <?php echo $totAmt;?></b></td>
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