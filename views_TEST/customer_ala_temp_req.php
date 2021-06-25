<?php 
$userAccess=$this->db->query("select * from emp_access_control where emp_id=$emp_id")->row_array();
extract($userAccess);
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<style>
.button.disabled {
  opacity: 0.65; 
  cursor: not-allowed;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Requests in Que</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Customers</a></li>
			<li class="active"><a href="#">Requests in Que</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					    <h3 class="box-title">Requests in Que</h3>
					    <!--<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url();?>excelsheet/req_download">						
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" class="form-control" id="inputLco" name="inputLco" value="<?php echo $_REQUEST['inputLco']; ?>">
							<input type="hidden" class="form-control" id="fromdate" name="fromdate" value="<?php echo $_REQUEST['fromdate']; ?>">
							<input type="hidden" class="form-control" id="todate" name="todate" value="<?php echo $_REQUEST['todate']; ?>">
							<input type="hidden" class="form-control" id="temp_appr" name="temp_appr" value="1">
							<input type="hidden" class="form-control" id="bouquet" name="bouquet" value="<?php echo $_REQUEST['bouquet']; ?>">
							<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?>>
							<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>-->
					</div>
					<form id="customerForm111" name="customerForm111" class="form-horizontal" role="form" method="post" autocomplete="off" action="">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="inputCCN">Customer / STB No</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" 
										<?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){ ?> value=<?php echo $_REQUEST['inputCCN'];?><?php } ?> placeholder="By Customer ID / STB No">
									</div>
								</div>
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
							</div>
							<div class="form-group">
							    <?php
								    if($user_type==9)
								    {
								?>
								<div class="col-md-6">
									<div class="col-md-4">
										<label for="inputLco">LCO</label>
									</div>
									<div class="col-md-8">
										<select class="form-control" id="inputLco" name="inputLco">
											<option value="">Select LCO</option>
										<?php
											foreach($lco_list as $key1 => $lcoInfo1)
											{
										?>
											<option value="<?php echo $lcoInfo1['admin_id'];?>" <?php if(isset($_REQUEST['inputLco']) && $_REQUEST['inputLco']==$lcoInfo1['admin_id']){ echo "selected";}?>><?php echo $lcoInfo1['adminFname'];?></option>
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
								        echo '<div class="col-md-6"></div>';
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
									<th>Mobile</th>
									<!--<th>Group Name</th>-->
									<th>STB No</th>
									<th>Date</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($customer_requets as $key => $customer_req)
							{

								//$getGrpData=$this->db->query("SELECT group_name from groups WHERE group_id=".$customer_req['group_id')->row_array();
								
								
							?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $customer_req['custom_customer_no'];?></td>
									<td><?php echo $customer_req['first_name'];?></td>
									<td><?php echo $customer_req['mobile_no'];?></td>
									<!--<td><?php  echo $getGrpData['group_name'];?></td>-->
									<td><?php echo $customer_req['stb_no'];?></td>
									<td><?php echo $customer_req['cust_end_date'];?></td>
									<td><?php echo implode("<br>",$customer_req['bouquet']);?></td>
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