<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1))
{
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Customer Renewals
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Franchise</a></li>
			<li class="active"><a  href="#">Customer Renewals</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Customer Renewals List</h3>
						<div class="box-body">	
							<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/customer_renewals">						
								<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
								<input type="hidden" class="form-control" id="inputLco" name="inputLco" <?php if(isset($_REQUEST['inputLco']) && $_REQUEST['inputLco']!=''){?> value="<?php echo $_REQUEST['inputLco']; ?>" <?php } ?>>
								<input type="hidden" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?> >
								<input type="hidden" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?> >
								<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
							</form>
						</div>
					</div>				
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/customer_renewals">
						<div class="box-body">
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
								<?php
								    if($user_type==9)
								    {
								?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputLco" name="inputLco">
											<option value="">All LCOs</option>
										<?php
											foreach($lco_list as $key => $lcoInfo2)
											{
										?>
											<option value="<?php echo $lcoInfo2['admin_id'];?>" <?php if(isset($_REQUEST['inputLco']) && $_REQUEST['inputLco']==$lcoInfo2['admin_id']){ echo "selected";}?>><?php echo $lcoInfo2['adminFname'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<?php
									}
									else
									{
									    echo '<input type="hidden" class="form-control" id="inputLco" name="inputLco" value="'.$adminId.'">';
									}
								?>
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
    							<th>MAC ID</th>
    							<th>Name</th>
    							<th>Amount</th>
    							<th>Date Created</th>
    						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						$totAmt=0;
						foreach($customer_renewals as $key => $crInfo)
						{   
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $crInfo['custNo'];?></td>
							<td><?php echo $crInfo['cMacId'];?></td>
							<td><?php echo $crInfo['cFname'];?></td>
							<td><?php echo $crInfo['amount'];?></td>
							<td><?php echo $crInfo['dateCreated'];?></td>
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