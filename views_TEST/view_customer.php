<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custV ==1)){ ?>
<div class="content-wrapper">
	<?php  foreach($customer as $key => $customer){} ?>
    <?php if(isset($msg)){ echo $msg; } ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Customer Details of <?php echo $customer['first_name'];?></h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">View Customer</a></li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li class="active"><a  href="#activity" data-toggle="tab">Personal Data</a></li>
				<li><a  href="#timeline" data-toggle="tab">Connection Details</a></li>
				<li><a  href="#settings" data-toggle="tab">Setup Box Details</a></li>
				<li><a  href="#pack" data-toggle="tab">Package & Group Details</a></li>
				<li><a  href="#invoice" data-toggle="tab">Invoice Details</a></li>
				<li><a  href="#actandinact" data-toggle="tab">Active & Inactive Details</a></li>
				<li><a  href="#trans" data-toggle="tab">Transaction History</a></li>
            </ul>
			<?php
				$grp_id=$customer['group_id'];
				$grpQry=mysql_query("select group_name from groups where group_id='$grp_id'");
				$grpRes=mysql_fetch_assoc($grpQry);
				$pack_id=$customer['package_id'];
				$packQry=mysql_query("select * from packages where package_id='$pack_id'");
				$packRes=mysql_fetch_assoc($packQry);
				$cust_id=$customer['cust_id'];
				$invoiceQry=mysql_query("select invoice,amount_paid,dateCreated from payments where customer_id='$cust_id'");
				// $invoiceRes=mysql_fetch_assoc($invoiceQry);
			?>
           		 <div class="tab-content">
				<div class="active tab-pane" id="activity">
					<table id="example2" class="table table-bordered table-hover">
						<tr>
							<td><b>Name : </b><?php echo $customer['first_name'];?> <?php if($customer['last_name']!='NULL'){ echo $customer['last_name'];}?></td>
							<td><b>Address : </b><?php echo $customer['addr1'];?> , <?php echo $customer['addr2']." , ".$customer['city']." , ".$customer['state']." , ".$customer['pin_code'];?></td>
						</tr>
						<tr>
							<td><b>Email Id : </b><?php if($customer['email_id']==''){ echo "No email id";}else{ echo $customer['email_id'];}?></td>
							<td><b>Group Name : </b> <?php echo $grpRes['group_name'];?></td>
						</tr>
						<tr>
							<td><b>Mobile Number : </b><?php echo $customer['mobile_no'];?></td>
							<td><b>Installation Charges : </b> <?php if($customer['install_charge']==''){ echo "0";}else{ echo $customer['install_charge'];}?></td>
						</tr>
						<tr>
							<td><b>Date of Birth : </b><?php echo $customer['dob'];?></td>
							<td><b>Anniversary Date : </b> <?php echo $customer['anniversary_date'];?></td>
						</tr>
					</table>
                    <table id="example2" class="table table-bordered table-hover">
						<tr>
						<td><b>Document : </b></td>
						<td>
						<?php
						$imgs=explode(",",$customer['documents']);
						$cnt=count($imgs);
						for($im=0;$im<$cnt;$im++)
						{
							if($imgs[$im]!='')
							{
							?>
								<img style="height:200px;width:200px;" src="<?php echo base_url()?>webservices/uploads/<?php echo $imgs[$im];?>" title="" alt="">
							<?php
							}
						}
						?>
						</td>
						</tr></table>
				</div>
			<!-- /.tab-pane -->
				<div class="tab-pane" id="timeline">
					<table id="example2" class="table table-bordered table-hover">
						<tr>
							<td><b>Connection Date : </b><?php echo $customer['connection_date'];?></td>
							<td><b>Start Date : </b><?php echo $customer['start_date'];?></td>
						</tr>
					</table>
				</div>
            <!-- /.tab-pane -->
				<div class="tab-pane" id="settings">
					<table id="example2" class="table table-bordered table-hover">
						<tr>
							<td><b>Setup Box Number : </b><?php echo $customer['stb_no'];?></td>
							<td><b>Card Number : </b><?php echo $customer['card_no'];?></td>
							<td><b>MAC ID : </b><?php echo $customer['mac_id'];?></td>
						</tr>
					</table>
				</div>
				<div class="tab-pane" id="pack">
					<table id="example2" class="table table-bordered table-hover">
						<tr>
							<td><b>Package Name : </b><?php echo $packRes['package_name'];?></td>
							<td><b>Package Price : </b><?php echo $packRes['package_price'];?></td>
							<td><b>Validity : </b><?php echo $packRes['package_validity']." month(s)";?></td>
						</tr>
					</table>
				</div>
				<div class="tab-pane" id="invoice">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Invoice Number</th>
								<th>Amount Paid</th>
								<th>Date</th>
							</tr>
						</thead>
					<?php
						while($invoiceRes=mysql_fetch_assoc($invoiceQry))
						{
					?>
						<tr>
							<td><?php echo $invoiceRes['invoice'];?></td>
							<td><?php echo $invoiceRes['amount_paid'];?></td>
							<td><?php echo $invoiceRes['dateCreated'];?></td>
						</tr>
					<?php
						}
					?>
					</table>
				</div>
				
				<div class="tab-pane" id="actandinact">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Inactive Date</th>
								<th>Active Date</th>
								<th>Last Modified</th>
								<th>Inactive Duration</th>
							</tr>
						</thead>
					<?php
						$inactQry=mysql_query("select inactive_date,active_date,datecreated from customers_inactive where cust_id='$cust_id'");
						$i=1;
						while($inactRes=mysql_fetch_assoc($inactQry))
						{
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php $inact_date=date_create($inactRes['inactive_date']);
									echo date_format($inact_date,"d-F-Y h:i:s A");
								?></td>
							<td><?php $act_date=date_create($inactRes['active_date']);
									echo date_format($act_date,"d-F-Y h:i:s A");
								;?></td>
							<td><?php echo $inactRes['datecreated'];?></td>
							<td><?php
							if($inactRes['active_date']!='NULL')
							{
								$date1 = strtotime($inactRes['inactive_date']);
								$date2 = strtotime($inactRes['active_date']);
								$subTime = $date2 - $date1;
								//$y = ($subTime/(60*60*24*365));
								$d = ($subTime/(60*60*24))%365;
								$h = ($subTime/(60*60))%24;
								$m = ($subTime/60)%60;

								echo "Inactive Duration is: ";
								echo $d." days, ";
								echo $h." hours, ";
								echo $m." minutes";
							}
							?></td>
						</tr>
					<?php
						$i++;
						}
					?>
					</table>
				</div>
				
				<div class="tab-pane" id="trans">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Previous Due</th>
								<th>Current M Bill</th>
								<th>Month</th>
								<th>Total Outstanding</th>
							</tr>
						</thead>
					<?php
						$tansQry=mysql_query("select previous_due,current_month_bill,current_month_name,total_outstaning from billing_info where cust_id='$cust_id'");
						$i=1;
						while($transRes=mysql_fetch_assoc($tansQry))
						{
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $transRes['previous_due'];?></td>
							<td><?php echo $transRes['current_month_bill'];?></td>
							<td><?php echo $transRes['current_month_name'];?></td>
							<td><?php echo $transRes['total_outstaning'];?></td>
						</tr>
					<?php
						$i++;
						}
					?>
					</table>
					<br>
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Type</th>
								<th>Amount</th>
								<th>Remarks</th>
								<th>Date</th>
							</tr>
						</thead>
					<?php
					    $f=1;
						$fQry=mysql_query("select type,amount,remarks,dateCreated from f_accounting where cust_id='$cust_id' order by f_ac_id DESC");
						while($fRes=mysql_fetch_assoc($fQry))
						{
					?>
						<tr>
							<td><?php echo $f;?></td>
							<td><?php echo $fRes['type'];?></td>
							<td><?php echo $fRes['amount'];?></td>
							<td><?php echo $fRes['remarks'];?></td>
							<td><?php echo $fRes['dateCreated'];?></td>
						</tr>
					<?php
					    $f++;
						}
					?>
					</table>
				</div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>		
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php } else{ 
	 redirect('/');
  }?>