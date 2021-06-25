<?php
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
if(($custE ==1) || ($custV ==1) ||($custD ==1))
{
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Digital Cables - Activated List</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li class="active"><a  href="#">Activated List</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Activated List</h3>
						<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url();?>excelsheet/ala_approved">
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" class="form-control" id="inputLco" name="inputLco" value="<?php echo $_REQUEST['inputLco']; ?>">
							<input type="hidden" class="form-control" id="fromdate" name="fromdate" value="<?php echo $_REQUEST['fromdate']; ?>">
							<input type="hidden" class="form-control" id="todate" name="todate" value="<?php echo $_REQUEST['todate']; ?>">
							<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/ala_approved">
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
								    if($employee_info['user_type']==9)
								    {
								?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputLco" name="inputLco">
											<option value="">Select LCO</option>
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
    								<th>Name</th>
    								<th>STB No</th>
    								<th>Name of Pack</th>
    								<th>Price</th>
    								<th>Employee Name</th>
    							</tr>
    						</thead>
    						<tbody>
    						<?php
    						$i=1;
    						foreach($customer_approved as $key => $customer_req1)
    						{
    						    if(isset($customer_req1['bouquet'])){ $packName=$customer_req1['bouquet']['0']['package_name'];$packPrice=$customer_req1['bouquet']['0']['lco_price'];}
    						    else{ $packName=$customer_req1['alacarte']['0']['ala_ch_name'];$packPrice=$customer_req1['alacarte']['0']['ala_ch_price'];}
    						?>
    							<tr>
    								<td><?php echo $i;?></td>
    								<td><?php echo $customer_req1['custom_customer_no'];?></td>
    								<td><?php echo $customer_req1['first_name'];?></td>
    								<td><?php echo $customer_req1['stb_no'];?></td>
    								<td><?php echo $packName;?></td>
    								<td><?php echo $packPrice;?></td>
    								<td><?php echo $customer_req1['empFname'];?></td>
    							</tr>
    						<?php 
    					    	$i=$i+1;
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