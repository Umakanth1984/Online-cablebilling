<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Digital Cables  - Customers List</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li class="active"><a  href="#">Customers</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Customers List</h3>
						<div class="box-body">	
						<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet">						
					<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" 
									<?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?> placeholder="Cust ID">
									<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
					<input type="hidden" class="form-control" id="inputFname" name="inputFname" 
									<?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?> placeholder="Name or First Name">
					<input type="hidden" class="form-control" id="mobile" name="mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?> placeholder="Mobile Number">

<input type="hidden" class="form-control" id="inputGroup" name="inputGroup" <?php if(isset($_REQUEST['inputGroup']) && $_REQUEST['inputGroup']!=''){?> value="<?php echo $_REQUEST['inputGroup']; ?>" <?php } ?> placeholder="inputGroup">

<input type="hidden" class="form-control" id="report_type" name="report_type" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']!=''){?> value="<?php echo $_REQUEST['report_type']; ?>" <?php } ?> placeholder="report_type">

<input type="hidden" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> >

<input type="hidden" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?> >

						
						<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>
							</div>
					</div>		
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/index">	
					<!--<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo 	base_url()?>excelsheet">-->
						<div class="box-body">				
							<div class="form-group">		
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" 
										<?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?> placeholder="Cust ID">
									</div>								
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputFname" name="inputFname" 
										<?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){?> value="<?php echo $_REQUEST['inputFname']; ?>" <?php } ?> placeholder="Name or First Name">
									</div>
								</div>
								<div class="col-md-3">									
									<div class="col-md-12">										
										<input type="text" class="form-control" id="mobile" name="mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){?> value="<?php echo $_REQUEST['mobile']; ?>" <?php } ?> placeholder="Mobile Number">
									</div>	
								</div>								
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputGroup" name="inputGroup">
											<option value="">Select Group</option>
										<?php
											$grp_qry=mysql_query("select * from groups");
											while($grp_res=mysql_fetch_assoc($grp_qry))
											{
										?>
											<option value="<?php echo $grp_res['group_id'];?>" <?php if(isset($_REQUEST['inputGroup']) && $_REQUEST['inputGroup']==$grp_res['group_id']){ echo "selected";}?>><?php echo $grp_res['group_name'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="report_type" name="report_type">
											<option value="none" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']=="none"){ echo "selected";}?>>Select All</option>
											<option value="0" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']=='0'){ echo "selected";}?>>Paid Customers</option>
											<option value="1" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']==1){ echo "selected";}?>>Unpaid Customers</option>
											<option value="2" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']==2){ echo "selected";}?>>Advance paid Customers</option>
											<option value="3" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']==3){ echo "selected";}?>>Active Customers</option>
											<option value="4" <?php if(isset($_REQUEST['report_type']) && $_REQUEST['report_type']==4){ echo "selected";}?>>Inactive Customers</option>
										</select>
									</div>
								</div>
								<div id="dates" style="display:none;">
									<div class="col-md-3">
										<div class="col-md-4">
											<label for="fromdate">From Date</label>
										</div>
										<div class="col-md-8">
											<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> >
										</div>
									</div>
									<div class="col-md-3">
										<div class="col-md-4">
											<label for="todate">To Date</label>
										</div>
										<div class="col-md-8">
											<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?> >
										</div>
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
								<th>Cust ID</th>
								<th>Name</th>
								<th>Mobile No.</th>
								<th>Address</th>
								<th>Group</th>
								<th>Status</th>
								<th>Amt. Paid</th>
								<th>Current Due</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
					 
						foreach($customers as $key => $customer_data ){
						// foreach($paid as $key => $customer_data)
						//while($customer_data=mysql_fetch_assoc($customers))
						//{
							$cust_id=$customer_data['cust_id'];
							$paymentQry=mysql_query("select * from payments where customer_id='$cust_id'");
							$paymentRes=mysql_fetch_assoc($paymentQry);

							$grp_ID=$customer_data['group_id'];
							$group_qry=mysql_query("select * from groups where group_id='$grp_ID'");
							$group_res=mysql_fetch_assoc($group_qry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $customer_data['custom_customer_no'];?></td>
							<td><?php echo $customer_data['first_name'];?></td>
							<td><?php echo $customer_data['mobile_no'];?></td>
							<td><?php echo $customer_data['addr1'];?></td>
							<td><?php echo $customer_data['group_name'];?></td>
							<td><?php if($customer_data['status']==1){ echo "Active";}else{ echo "Inactive";}?></td>
							<td>Rs. <?php echo $paymentRes['amount_paid']?></td>
							<td>Rs. <?php echo $customer_data['pending_amount']?></td>
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
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<?php echo $pagination; ?>
			</div>
		</div>
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) { 
	$('#report_type').on('change',function() {
		if(this.value=='none')
		{ 
			// $("#dates").hide();
			$("#dates").css("display","none");
		}
		//if(this.value==0)
		else
		{ 
			// $("#dates").show();
			//$("#dates").css("display","block");
			$("#dates").css("display","none");
		}  
    });
});
</script>
	<?php }	else	{
		redirect('/');
	}?>  